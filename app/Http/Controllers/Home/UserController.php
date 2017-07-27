<?php

namespace App\Http\Controllers\Home;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;

use App\Http\Model\Account;
use App\Http\Model\ArticleModel;
use App\Http\Model\Attribute;
use App\Http\Model\Banner;
use App\Http\Model\DkOrderModel;
use App\Http\Model\ExchangeOrder;
use App\Http\Model\Game;
use App\Http\Model\GameQu;
use App\Http\Model\GameType;
use App\Http\Model\GameUserInfo;
use App\Http\Model\GoodsGame;
use App\Http\Model\GoodsPicture;
use App\Http\Model\Order;
use App\Http\Model\OrderAction;
use App\Http\Model\User;
use App\Http\Model\UserAccount;
use App\Http\Model\UserRank;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use Toplan\FilterManager\Facades\FilterManager;
use Toplan\PhpSms\PhpSmsException;
use Vinkla\Hashids\Facades\Hashids;
use PhpSms;
use Toplan\Sms\Facades\SmsManager;

/**
 * Class UserController
 * @package App\Http\Controllers\Home
 * 会员中心
 */
class UserController extends CommonController
{

    /**
     * Create a new controller instance.
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *  首页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getUser();
        $buy_sum =$this->buy_sum($user['id']);  //买家成交总数
        $sell_sum = $this->sell_sum($user['id']); //卖家成交总数
        $str = $this->star($user);   //安全星级

        $buy_rank = $this->vip_level($user['user_point_buy']);  //买家会员等级
        $sell_rank = $this->vip_level($user['user_point_sell']);  //卖家会员等级

        //推荐安全新闻
        $recommend = (new HelpController())->recommend(6);
        return view('user.index',compact('user','buy_sum','sell_sum','str','buy_rank','sell_rank','recommend'));
    }

    
    
    
    /**
     * 安全星级
     */
    public function star($user)
    {
        //安全星级
        $star_num =1;  //默认一颗星
        if($user['answer']!=''){$star_num++;}  //设置密保加一颗
        if($user['is_check_email']=='1'){$star_num++;}     //验证邮箱
        if($user['is_check_phone']=='1'){$star_num++;}      //验证手机
        if($user['bind_ip']!=''){$star_num++;}          //绑定ip
        $str ='';
        $fs =0;
        for($i=1;$i<=$star_num;$i++){     //有色星星
            $str .= "<img src='".web_url.''.HOME_IMG."center/str.png'>";
            $fs +=20;
        }
        for ($i=1;$i<=(5-$star_num);$i++){  //无色星星
            $str .= "<img src='".web_url.''.HOME_IMG."center/hstr.png'>";
        }
        $arr['str'] = $str;
        $arr['fs'] = $fs;
        return $arr;
    }


    /**
     * 发布求购，选择游戏页面
     */
    public function needsPublish()
    {
        return view('user.needsPublish');
    }

    /**
     * 求购订单 填写表单
     * post
     */
    public function FillNeedsOrder()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        $input = Input::except('menu');
        $game_id = $this->getId($input['HG']);
        $game = Game::select('id','game_name')->where('id',$game_id)->first()->toArray();
        $fwq_id = $this->getId($input['G']);
        $fwq = GameQu::where('id',$fwq_id)->first()->toArray();
        $qu = GameQu::where('id',$fwq['pid'])->first()->toArray();
        $type_id = $this->getId($input['TP']);
        $type = GameType::where('id',$type_id)->first()->toArray();
        $vip_level = $this->vip_level($user['user_point_buy']);
        return view('user.FillNeedsOrder',compact('game','qu','fwq','type','f','vip_level','user'));
    }


    /**
     *   发布商品提交
     */
    public function needsFinish()
    {
        $data = Input::except('_token');
        $rule = $this->rule();

        $validator =Validator::make(Input::except('_token'), [       //验证，验证码
            'verify_mobileCode' => 'required|verify_code',
        ],
            ['verify_mobileCode.verify_code'=>trans('com.error_code')]
        );
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $data=[
                'status'=>'n',
                'info' => json_encode($validator->messages(),JSON_UNESCAPED_UNICODE)
            ];
        }
        $validator = Validator::make($data,$rule['rules'],$rule['msg']);
        if($validator->passes()){
                $data['game_id'] = $this->getId($data['game_id']);
                $data['qu_id']   = $this->getId($data['qu_id']);
                $data['game_qu_id']   = $this->getId($data['game_qu_id']);
                $data['goods_type_id']   = $this->getId($data['goods_type_id']);
                $data['user_id'] = Auth::user()->id;
                $data['goods_code'] = $this->GoodsCode($data['goods_type_id']); //生成商品编号
                $data['cate_id'] ='1';
                $data['traded_type'] ='2';
                $data['sale_start_time'] = time();
                $data['sale_end_time'] = strtotime('+'.$data['sale_end_time']." day");
                $data['created_at'] = date('Y-m-d H:i:s',time());
                $data['updated_at'] = date('Y-m-d H:i:s',time());
                unset($data['verify_mobileCode']);
                unset($data['NeedNumUnit']);
                $info['game_user'] = $data['role_name'];
                unset($data['role_name']);
                $info['game_user_tel'] = $data['phone'];
                unset($data['phone']);
                $info['game_user_qq'] = $data['qq'];
                unset($data['qq']);
                try{
                    DB::transaction(function () use($data,$info){
                        $goods_id = DB::table('goods_game')->insertGetId($data);
                        $info['goods_id'] = $goods_id;
                        $result = DB::table('game_user_info')->insert($info);
                        if (!$result) {
                            DB::rollback();//事务回滚
                            return $json =[
                                'status'=>'n',
                                'info'=>trans('com.system_error')
                            ];
                        }
                    });
                    return $json =[
                        'status'=>'y',
                        'info'=>trans('home.goods_add_success')
                    ];
                } catch (Exception $e) {
                    return $json =[
                        'status'=>'n',
                        'info'=>trans('com.system_error')
                    ];
                }
        }else{
            return $data=[
                'status'=>'n',
                'info' => json_encode($validator->messages(),JSON_UNESCAPED_UNICODE)
            ];
        }
    }
    protected function rule(){
        $data = array();
        $data['rules']=[
            'game_qu_id'=>'required',
            'goods_type_id'=>'required',
            'game_id'=>'required',
            'qu_id'=>'required',
            'goods_price'=>'required|regex:/^[1-9]{1}\d*(\.\d{1,2})?$/',
            'goods_name'=>'required',
            'goods_stock'=>'required|regex:/^\+?[1-9][0-9]*$/',
            'role_name'=>'required',
            'phone'=>'required|regex:/^1[34578]\d{9}$/',
            'sale_end_time'=>'required',
            'best_time'=>'required',
            'goods_content'=>'required',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
            'verify_mobileCode'=>'required'
        ];
        $data['msg']=[
            'game_qu_id.required'=>trans('com.no_fwq'),
            'goods_type_id.required'=>trans('com.no_type'),
            'game_id.required'=>trans('com.no_game'),
            'qu_id.required' =>trans('com.no_qu'),
            'goods_price.required'=>trans('com.no_goods_price'),
            'goods_price_regex' =>trans('com.error_goods_price'),
            'goods_name.required'=>trans('com.no_goods_name'),
            'goods_stock.required'=>trans('com.no_goods_stock'),
            'goods_stock.regex'=>trans('com,error_goods_stock'),
            'role_name.required'=>trans('com.no_role_name'),
            'phone.required'=>trans('com.no_phone'),
            'phone.regex'=>trans('com.error_phone'),
            'sale_end_time.required'=>trans('com.no_sale_end_time'),
            'best_time.required'=>trans('com.no_best_time'),
            'goods_content.required'=>trans('com.no_content'),
            'qq.required'=>trans('com.no_qq'),
            'qq.regex'=>trans('com.error_qq'),
            'verify_mobileCode.required'=>trans('com.no_code'),
        ];
        return $data;
    }
    /**
     * 我购买的点卡
     */
    public function dk()
    {
        $user = $this->getUser();
        $data = DkOrderModel::where('user_id',$user['id'])->orderBy('time','desc')->Paginate(PAGE);
        return view('user.dk',compact('user','data'));

    }

    /**
     *  我购买的商品
     */
    public function goods()
    {
        $str = Letter;
        $user = $this->getUser();
        $url = Input::url();
        $filter = 'goods';
        $pageSize = Input::get('pageSize')!==false && !empty(Input::get('pageSize'))?intval(Input::get('pageSize')):'10';
        $select = ['goods_game.goods_name', 'goods_game.goods_price','order.order_status','order.buy_number','order.order_status','order.pay_status','order.id as order_id',
                        'order.order_amount','order.created_at','order.order_sn','order.flag','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu'];
        if(Input::except('menu')){
            $where =array();
            $game_id = empty(Input::get('game'))?'':$this->getId(Input::get('game'));
            $qu_id = empty(Input::get('area'))?'':$this->getId(Input::get('area'));
            $fwq_id = empty(Input::get('server'))?'':$this->getId(Input::get('server'));
            $type_id = empty(Input::get('type'))?'':$this->getId(Input::get('type'));
            $trash_type = Input::get('SellType');
            $order_sn = Input::get('order_sn');
            $start_time = strtotime(Input::get('act_start_time'));
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = strtotime(Input::get('act_end_time'))?strtotime(Input::get('act_end_time')):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            $order_status = Input::get('order_status');
            if($game_id){
                $where['goods_game.game_id']=$game_id;
                $page_path['game']=Input::get('game');
            }
            if($qu_id){
                $where['goods_game.qu_id']=$qu_id;
                $page_path['area']=Input::get('area');
            }
            if($fwq_id){
                $where['goods_game.game_qu_id']=$fwq_id;
                $page_path['server']=Input::get('server');
            }
            if($type_id){
                $where['goods_game.goods_type_id']=$type_id;
                $page_path['type']=Input::get('type');
            }

            if($order_sn){
                $where['order.order_sn']=$order_sn;
                $page_path['order_sn']=Input::get('order_sn');
            }
            if($order_status){
               if($order_status=='1' || $order_status=='3' || $order_status=='4'){
                   $where['order.order_status']=$order_status;
               }elseif($order_status=='11'){
                   $where['order.pay_status']='0';
               }elseif ($order_status=='12'){
                   $where['order.pay_status']='1';
               }
                $page_path['order_status']=Input::get('order_status');
            }
            if($start_time){
                $page_path['act_start_time']=Input::get('act_start_time');
            }
            if($start_time){
                $page_path['act_end_time']=Input::get('act_end_time');
            }
            if($order_sn){
                $page_path['order_sn']=Input::get('order_sn');
            }

            $game_name = $game_id?Game::where('id',$game_id)->select('game_name')->first()->toArray():'';
            $qu_name = $qu_id?GameQu::where('id',$qu_id)->select('qu_name')->first()->toArray():'';
            $fwq_name = $fwq_id?GameQu::where('id',$fwq_id)->select('qu_name')->first()->toArray():'';
            $type_name = $type_id?GameType::where('id',$type_id)->select('type')->first()->toArray():'';

                switch ($trash_type){
                    case 'a':
                        $jy_type = '全部商品';
                        $trash='';
                        break;
                    case 's':
                        $jy_type = '寄售商品';
                        $trash='0';
                        break;
                    case 'd':
                        $jy_type = '担保商品';
                        $trash='1';
                        break;
                    case 'c':
                        $jy_type = '帐号交易';
                        $trash='';
                        break;
                    case '':
                        $jy_type ='';
                        break;
                }


            if(isset($trash) && $trash!=''){
                $where['goods_game.traded_type']=$trash;
                $page_path['SellType']=Input::get('SellType');
            }
            if($order_sn){
                $goodsShow = DB::table('order')
                    ->join('goods_game', function($join)
                    {
                        $join->on('goods_game.id', '=', 'order.goods_id');
                    })
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where('order.order_sn',$order_sn)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('order.user_id',$user['id'])
                    ->whereBetween('order.created_at', array($start_time, $end_time))
                    ->orderBy('order.created_at', 'desc')
                    ->Paginate($pageSize);
                //dd($goodsShow);
            }else{
                $goodsShow = DB::table('order')
                    ->join('goods_game', function($join)
                    {
                        $join->on('goods_game.id', '=', 'order.goods_id');
                    })
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where($where)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('order.user_id',$user['id'])
                    ->whereBetween('order.created_at', array($start_time, $end_time))
                    ->orderBy('order.created_at', 'desc')
                    ->Paginate($pageSize);
            }
            //dd(DB::getQueryLog());
           //dd($goodsShow);
        }
        //dd(DB::getQueryLog());
        if(!isset($goodsShow))
        $goodsShow = DB::table('order')
            ->join('goods_game', function($join)
            {
                $join->on('goods_game.id', '=', 'order.goods_id');
            })
            ->join('game', function($join)
            {
                $join->on('game.id', '=', 'goods_game.game_id');
            })
            ->join('game_qu', function($join)
            {
                $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
            })
            ->join('game_qu as qu', function($join)
            {
                $join->on('qu.id', '=', 'goods_game.qu_id');
            })
            ->join('game_type', function($join)
            {
                $join->on('game_type.id', '=', 'goods_game.goods_type_id');
            })
            ->select($select)
            ->where('order.user_id',$user['id'])
            ->where('goods_game.traded_type','!=','2')
            ->orderBy('order.created_at', 'desc')
            ->Paginate($pageSize);
        return view('user.goods',compact('user','str','goodsShow','game_name','qu_name','fwq_name','type_name','jy_type','page_path','url','filter'));
    }


    /**
     * 取消购买商品
     */
    public function goodsCancel()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){
            $id = Route::input('id');
            $order = Order::select('order_sn','user_id')->where('id',$id)->first();
            $note = Input::get('note')===null?trans('com.action_note_action_4'):htmlspecialchars(Input::get('note'));
        try{
            DB::transaction(function () use($id,$user,$note,$order){
                DB::table('order')->where('id',$id)->update(['order_status'=>'4']);  //更新订单状态
                $result = DB::table('order_action')->insert(['order_id'=>$id,'action_user_name'=>'用户'.$user['name'],'order_status'=>'4','action_note'=>$note,'log_time'=>time()]);    //添加订单操作日志
                if (!$result) {
                    DB::rollback();//事务回滚
                    return $json =[
                        'status'=>'-1',
                        'info'=>trans('com.system_error')
                    ];
                }
            });
            Event::fire(new SendMessage($order['user_id'],'user.order_cancel',$order['order_sn']));
            return $json =[
                'status'=>'1',
                'info'=>trans('home.goods_cancel_success')
            ];
            } catch (Exception $e) {
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
        }
    }

    /**
     * 商品下架 删除
     */
    public function goodsOffSale()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){
            $id = Route::input('id');
            if(Input::get('type')=='2'){    //删除，放入回收站，不直接删除
                $msg = GoodsGame::where('id',$id)->update(['is_trash'=>'1']);
            }else{                  //上下架
                $status = intval(Input::get('type'))=='1'?'1':'0';
                $msg = GoodsGame::where('id',$id)->update(['is_on_sale'=>$status]);
            }
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>trans('home.operation_success')
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
        }
    }
    /**
     * 确认收货
     */
    public function goodsSure()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){
            $id = Route::input('id');
            $order_status = Input::get('t')===null?'3':'1';
            $goods = GoodsGame::where('id',Input::get('gid'))->select('to_money','account','security','goods_code','user_id')->first();
            $order = Order::where('id',$id)->select('money_paid','order_sn')->first();
            if($goods){
                if($goods['to_money']==1){    //提现到银行卡,自动为卖家申请提现到银行操作，
                    /**
                     * 1.把订单付款金额，添加进用户表冻结资金
                     * 2.写入用户资金明细表
                     * 3.写用户提现申请
                     * $order,订单信息
                     */
                    DB::transaction(function () use($order,$goods){
                       DB::table('users')->where('id',$goods['user_id'])->increment('frozen_money',$order['money_paid']);
                        $accoun['user_id'] = $goods['user_id'];
                        $accoun['frozen_money'] = $order['money_paid'];
                        $accoun['change_time'] = time();
                        $accoun['change_desc'] = '订单'.$order['order_sn'].'出售，所得收益（到账银行卡）';
                        $accoun['change_type'] ='4';
                        $accou['user_id'] = $goods['user_id'];
                        $accou['frozen_money'] = $order['money_paid'];
                        $accou['change_time'] = time();
                        $accou['change_desc'] = '商品成功出售，订单'.$order['order_sn'].'收益转账到银行卡';
                        $accou['change_type'] ='1';
                        $account =array('0'=>$accoun,'1'=>$accou);
                        DB::table('account_log')->insert($account);
                        $user_account['user_id'] =  $goods['user_id'];
                        $user_account['amount'] =  $order['money_paid'];
                        $user_account['created_at'] = date('Y-m-d H:i:s',time());
                        $user_account['updated_at'] = $user_account['created_at'];
                        $user_account['user_note'] = $goods['account'];
                        $user_account['process_type'] = '1';
                        DB::table('user_account')->insert($user_account);
                    });
                }else{        //出售金额到余额，（如有有资金延迟到账，未做）
                    DB::transaction(function () use($order,$goods){
                        DB::table('users')->where('id',$goods['user_id'])->increment('money',$order['money_paid']);
                        $accoun['user_id'] = $goods['user_id'];
                        $accoun['money'] = $order['money_paid'];
                        $accoun['change_time'] = time();
                        $accoun['change_desc'] = '订单'.$order['order_sn'].'出售，所得收益';
                        $accoun['change_type'] ='4';
                        DB::table('account_log')->insert($accoun);
                    });
                }
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
            $IntegralRatio = config('web.IntegralRatio');//获取积分比例
            $note = Input::get('t')===null?trans('com.action_note_action_3'):trans('com.action_note_action_1');
            try{
                DB::transaction(function () use($id,$user,$order_status,$note,$order,$IntegralRatio,$goods){
                    DB::table('order')->where('id',$id)->update(['order_status'=>'3']);  //更新订单状态
                    $integral = intval($order['money_paid']*$IntegralRatio);
                    DB::table('users')->where('id',$user['id'])->increment('integral',$integral);//添加积分
                    DB::table('users')->where('id',$user['id'])->increment('user_point_buy',intval($order['money_paid'])); //更新买家信用积分
                    DB::table('users')->where('id',$goods['user_id'])->increment('user_point_sell',intval($order['money_paid'])); //更新卖家信用积分
                    $buy_account['user_id'] = $user['id'];
                    $buy_account['integral'] = $integral;
                    $buy_account['user_point_buy'] = intval($order['money_paid']);
                    $buy_account['change_time'] = time();
                    $buy_account['change_desc'] = '购买订单'.$order['order_sn'].'获得积分';
                    $buy_account['change_type'] ='3';
                    DB::table('account_log')->insert($buy_account);  //记录买家积分增加
                    $sell_account['user_id'] = $goods['user_id'];
                    $sell_account['user_point_sell'] = intval($order['money_paid']);
                    $sell_account['change_time'] = time();
                    $sell_account['change_desc'] = '出售订单'.$order['order_sn'].'获得积分';
                    $sell_account['change_type'] ='4';
                    DB::table('account_log')->insert($sell_account);  //记录卖家积分增加
                    $result = DB::table('order_action')->insert(['order_id'=>$id,'action_user_name'=>'用户'.$user['name'],'order_status'=>$order_status,'action_note'=>$note,'log_time'=>time()]);    //添加订单操作日志
                    if (!$result) {
                        DB::rollback();//事务回滚
                        return $json =[
                            'status'=>'-1',
                            'info'=>trans('com.system_error')
                        ];
                    }
                });
                Cache::forget('user_info_'.$user['id']);
                Cache::forget('user_info_'.$goods['user_id']);
                Cache::forget('goods_detail_'.$id);
                Event::fire(new SendMessage($goods['user_id'],'seller.money_change',$order['order_sn'],$order['money_paid']));
                return $json =[
                    'status'=>'1',
                    'info'=>trans('com.operation_success')
                ];
            } catch (Exception $e) {
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
        }
    }
    /**
     * 订单详情
     */
    public function orderDetail()
    {
        $order_sn = Input::get('order_sn');
        $has_order = Order::where('order_sn',$order_sn)->select('id')->first();
        if(!$has_order){
            return redirect('/user/goods');
        }
        $user = $this->getUser();
        $order_sn = htmlspecialchars(Input::get('order_sn'));
        $order = Order::where('order_sn',$order_sn)->first()->toArray();
        $info = DB::table('user_order_address')->where('order_id',$order['id'])->select('role_name','qq','telphone')->first();
        $data = $this->GetGameById($order['goods_id']);
        $order_act = OrderAction::where('order_id',$order['id'])->get()->toArray();
       // dd($order_act);
        return view('user.orderDetail',compact('user','order','data','info','order_act'));
    }
    /**
     * 我发布的求购
     */
    public function needs()
    {
        $str = Letter;
        $user = $this->getUser();
        $url = Input::url();
        $filter = 'needs';
        $pageSize = Input::get('pageSize')!==false && !empty(Input::get('pageSize'))?intval(Input::get('pageSize')):'10';
        if(Input::except('menu')){
            $where =array();
            $game_id = empty(Input::get('game'))?'':$this->getId(Input::get('game'));
            $qu_id = empty(Input::get('area'))?'':$this->getId(Input::get('area'));
            $fwq_id = empty(Input::get('server'))?'':$this->getId(Input::get('server'));
            $type_id = empty(Input::get('type'))?'':$this->getId(Input::get('type'));
            $order_sn = Input::get('order_sn');
            $start_time = strtotime(Input::get('act_start_time'));
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = strtotime(Input::get('act_end_time'))?strtotime(Input::get('act_end_time')):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            $goods_status = Input::get('goods_status');
            if($game_id){
                $where['goods_game.game_id']=$game_id;
                $page_path['game']=Input::get('game');
            }
            if($qu_id){
                $where['goods_game.qu_id']=$qu_id;
                $page_path['area']=Input::get('area');
            }
            if($fwq_id){
                $where['goods_game.game_qu_id']=$fwq_id;
                $page_path['server']=Input::get('server');
            }
            if($type_id){
                $where['goods_game.goods_type_id']=$type_id;
                $page_path['type']=Input::get('type');
            }

            if($order_sn){
                $where['goods_game.goods_code']=$order_sn;
                $page_path['order_sn']=Input::get('order_sn');
            }
            if($goods_status){
                if($goods_status=='d'){
                    $where['goods_game.is_check']='0';
                }elseif ($goods_status=='s'){
                    $where['goods_game.is_check']='1';
                }elseif ($goods_status=='e'){
                    $where['goods_game.is_check']='2';
                }elseif ($goods_status=='x'){
                    $where['goods_game.is_on_sale']='0';
                }
                $page_path['goods_status']=Input::get('goods_status');
            }
            if($start_time){
                $page_path['act_start_time']=Input::get('act_start_time');
            }
            if($start_time){
                $page_path['act_end_time']=Input::get('act_end_time');
            }

            $game_name = $game_id?Game::where('id',$game_id)->select('game_name')->first()->toArray():'';
            $qu_name = $qu_id?GameQu::where('id',$qu_id)->select('qu_name')->first()->toArray():'';
            $fwq_name = $fwq_id?GameQu::where('id',$fwq_id)->select('qu_name')->first()->toArray():'';
            $type_name = $type_id?GameType::where('id',$type_id)->select('type')->first()->toArray():'';


            if($order_sn){
                $goodsShow = DB::table('goods_game')
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select('goods_game.goods_name', 'goods_game.goods_price','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu','goods_game.sale_end_time'
                    ,'goods_game.is_on_sale','goods_game.goods_code','goods_game.sale_start_time','goods_game.goods_stock','goods_game.is_check')
                    ->where('goods_game.goods_code',$order_sn)
                    ->where('goods_game.traded_type','=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->whereBetween('goods_game.sale_start_time', array($start_time, $end_time))
                    ->orderBy('goods_game.sale_start_time', 'desc')
                    ->Paginate($pageSize);
                //dd($goodsShow);
            }else{
                $goodsShow = DB::table('goods_game')
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select('goods_game.goods_name', 'goods_game.goods_price','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu','goods_game.sale_end_time'
                        ,'goods_game.is_on_sale','goods_game.goods_code','goods_game.sale_start_time','goods_game.goods_stock','goods_game.is_check')
                    ->where($where)
                    ->where('goods_game.traded_type','=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->whereBetween('goods_game.sale_start_time', array($start_time, $end_time))
                    ->orderBy('goods_game.sale_start_time', 'desc')
                    ->Paginate($pageSize);
            }
            //dd(DB::getQueryLog());
           // dd($goodsShow);
        }
        //dd(DB::getQueryLog());
        if(!isset($goodsShow))
            $goodsShow = DB::table('goods_game')
                ->join('game', function($join)
                {
                    $join->on('game.id', '=', 'goods_game.game_id');
                })
                ->join('game_qu', function($join)
                {
                    $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                })
                ->join('game_qu as qu', function($join)
                {
                    $join->on('qu.id', '=', 'goods_game.qu_id');
                })
                ->join('game_type', function($join)
                {
                    $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                })
                ->select('goods_game.goods_name', 'goods_game.goods_price','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu','goods_game.sale_end_time'
                    ,'goods_game.is_on_sale','goods_game.goods_code','goods_game.sale_start_time','goods_game.goods_stock','goods_game.is_check')
                ->where('goods_game.user_id',$user['id'])
                ->where('goods_game.traded_type','=','2')
                ->orderBy('goods_game.sale_start_time', 'desc')
                ->Paginate($pageSize);

        return view('user.needs',compact('user','str','goodsShow','game_name','qu_name','fwq_name','type_name','jy_type','page_path','url','filter'));
    }

    /**
     * 我的求购订单
     */
    public function needsOrder()
    {
        $user = $this->getUser();
        $where = array();
        if(Input::get('order_status')!==null){
            if(Input::get('order_status')=='3'){
                $where['order.order_status']=Input::get('order_status');
            }elseif(Input::get('order_status')=='4'){
                $where['order.order_status']='4';
            }elseif (Input::get('order_status')=='12'){
                $where['order.pay_status']='1';
            }
            $page_path['order_status']=Input::get('order_status');
        }
        $goodsShow = DB::table('order')
            ->join('goods_game', function($join)
            {
                $join->on('goods_game.id', '=', 'order.goods_id');
            })
            ->join('game', function($join)
            {
                $join->on('game.id', '=', 'goods_game.game_id');
            })
            ->join('game_qu', function($join)
            {
                $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
            })
            ->join('game_qu as qu', function($join)
            {
                $join->on('qu.id', '=', 'goods_game.qu_id');
            })
            ->join('game_type', function($join)
            {
                $join->on('game_type.id', '=', 'goods_game.goods_type_id');
            })
            ->select('goods_game.goods_name', 'goods_game.goods_price','order.order_status','order.buy_number','order.order_status','order.pay_status','order.id as order_id',
                'order.order_amount','order.created_at','order.order_sn','order.flag','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu')
            ->where($where)
            ->where('order.user_id',$user['id'])
            ->where('order.flag','=',trans('com.need_order'))
            ->orderBy('order.created_at', 'desc')
            ->Paginate(PAGE);
        return view('user.needsOrder',compact('user','str','goodsShow','game_name','qu_name','fwq_name','type_name','jy_type','page_path'));
    }

    /**
     * 我的求降价信息
     */
    public function changePrice()
    {
        $user = $this->getUser();
        $input = Input::except('menu');
        if($input){
            $status = intval($input['cut_status']);
            $data = DB::table('cut_price')->where('user_id',$user['id'])->where('status',$status)->get();
        }else{
            $data = DB::table('cut_price')->where('user_id',$user['id'])->get();
        }
        foreach ($data as $k=>$v){
            $data[$k]->goods =  $this->GetGameById($v->goods_id);
        }
        $type = 'buyer';
        return view('user.changePrice',compact('user','data','type'));
    }
    
    /**
     * 我的收货信息
     * 
     */
    public function address()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){
            $id = Route::input('id');
            $msg = DB::table('user_order_address')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>trans('com.delete_success')
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
        }
        $data = DB::table('user_order_address')->join('game','game.id','=','user_order_address.game_id')
        ->join('game_qu','game_qu.id','=','user_order_address.da_qu_id')->join('game_qu as qu','qu.id','=','user_order_address.xia_qu_id')
        ->select('user_order_address.*','game.game_name','game_qu.qu_name','qu.qu_name as fwq')
        ->where('user_order_address.user_id',$user['id'])
        ->orderBy('user_order_address.id', 'desc')
        ->Paginate(8);
        return view('user.address',compact('user','data'));
    }
    
    /**
     * 我要发布
     */
    public function sell()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        if(Input::method()=='GET'){    //选择游戏页面
            return view('user.sell',compact('user'));
        }elseif (Input::method()=='POST'){ //填写详细信息页面
            if($user['is_check_datecard']==0){  //没有实名认证通过  ,跳转到实名认证
                return redirect('user/IDCard');
            }else{
                $input = Input::except('menu');
                $game_id = $this->getId($input['HG']);
                $game = Game::select('id','game_name')->where('id',$game_id)->first()->toArray();
                $fwq_id = $this->getId($input['G']);
                $fwq = GameQu::where('id',$fwq_id)->first()->toArray();
                $qu = GameQu::where('id',$fwq['pid'])->first()->toArray();
                $type_id = $this->getId($input['TP']);
                $type = GameType::where('id',$type_id)->first()->toArray();
                $vip_level = $this->vip_level($user['user_point_buy']);
                $arr_data = (new Attribute())->attr($game_id,$type_id)?(new Attribute())->attr($game_id,$type_id)->toArray():array('0'=>array('0'=>$type['type']));
                if(isset($arr_data['data'])){
                    $arr_data = json_decode($arr_data['data']);
                    $arr_data = $arr_data->value;
                }
                
                if($accounts = (new Attribute())->attr($game_id,$type_id)){
                    $accounts = $this->getQuData($accounts['data'])?$this->getQuData($accounts['data']):array();
                }

                $traded_type = $input['T'];   //交易类型
                //读取绑定银行卡
                $bank_info = DB::table('user_bank')->select('id','data')->where('user_id',$user['id'])->get();
                foreach ($bank_info as $k=>$v){
                    $bank_info[$k] = json_decode($v->data,true);
                    $bank_info[$k]['id'] = $v->id;
                }
                return view('user.sell_info',compact('user','game','fwq','qu','type','vip_level','arr_data','bank_info','traded_type','accounts'));
            }
        }
    }

    /**
     *  发布流程
     */
    public function sellNext(Requests\JSGoodsCreateRequest $request)
    {
        $user = $this->getUser();
        $vip_level = $this->vip_level($user['user_point_buy']);
        //商品表信息
        $goods['game_id'] = $this->getId($request->game_id);
        $goods['qu_id'] = $this->getId($request->qu_id);
        $goods['game_qu_id'] = $this->getId($request->game_qu_id);
        $goods['goods_type_id'] = $this->getId($request->game_goods_type_id);
        $goods['cate_id'] = '1';
        $goods['goods_name'] = isset($request->is_acc)?json_encode($request->attr_value,JSON_UNESCAPED_UNICODE).htmlspecialchars($request->goods_name):htmlspecialchars($request->goods_name);
        $goods['goods_price'] = $request->goods_price;
        $goods['goods_code'] = $this->GoodsCode($goods['goods_type_id']);
        $goods['traded_type'] = $request->traded_type=='s'?'0':'1';
        $goods['goods_stock'] = intval($request->goods_stock);
        $goods['sale_start_time'] = time();
        $goods['sale_end_time'] = $vip_level['max_time']>=$request->sale_end_time?strtotime('+'.$request->sale_end_time." day"):strtotime('+'.$vip_level['max_time'].'day');
        $goods['best_time'] = $request->best_time;
        $goods['goods_content'] = htmlspecialchars($request->goods_content);
        $goods['user_id'] = $user['id'];
        $goods['pwd'] = $request->pwd;
        $goods['to_money'] = $request->to_money;
        $goods['account'] = $request->account;
        $goods['security'] = $request->security;
        $goods['code'] = $request->code?$request->code:'';
        $goods['one_num'] = $request->one_num?$request->one_num:'0';
        $goods['created_at'] = date('Y-m-d H:i:s',time());
        $goods['updated_at'] = $goods['created_at'];
        $goods['security'] = $request->security;
        $goods['is_cut_price'] =  $request->is_cut_price?$request->is_cut_price:'0';
        $goods['attr_value'] = isset($request->attr_value)?json_encode($request->attr_value,JSON_UNESCAPED_UNICODE):'';
        //商品对应帐号信息
        $info['game_user_name'] = $request->game_user_name;
        $info['game_user_pwd'] = $request->game_user_pwd;
        $info['secretcard_img'] = $request->secretcard_img;
        $info['is_secretcard'] = $info['secretcard_img']==''?'0':'1';
        $info['datacard'] = $request->datacard;
        $info['is_datacard'] = $info['datacard']==''?'0':'1';
        $info['game_user_tel'] = $request->game_user_tel;
        $info['game_user_qq'] = $request->game_user_qq;
        $info['mb_tel'] = $request->mb_tel;
        $info['mb_question'] = $request->mb_question;
        $info['mb_answer'] = $request->mb_answer;
        $info['game_user'] = $request->game_user;
        $info['two_level_pass'] = $request->two_level_pass;
        try {
            DB::transaction(function () use($goods,$request,$info){  //开启事务
                $goods_id = DB::table('goods_game')->insertGetId($goods);  //写入商品表 返回id
                if($request->pictrue!=''){
                    //商品图片
                    $img = array();
                    foreach ($request->pictrue as $k=>$v){
                        $img[$k]['goods_id'] = $goods_id;
                        $img[$k]['picture'] = $v;
                        $img[$k]['create_time'] = time();
                    }
                    DB::table('goods_game_picture')->insert($img);      //写入图片
                }
                $info['goods_id'] = $goods_id;
                $msg = DB::table('game_user_info')->insert($info);      //写入帐号信息
            });
            return $json =[
                'status'=>'1',
                'info'=>trans('com.operation_success')
            ];

        } catch (Exception $e) {
            return $json =[
                'status'=>'-1',
                'info'=>trans('com.system_error')
            ];
        }
    }

    /**
     * 我发布的商品
     */
    public function MySell()
    {
        $filter='sell';  //标识
        $url = Input::url();
        $str = Letter;
        $user = $this->getUser();
        $pageSize = Input::get('pageSize')!==false && !empty(Input::get('pageSize'))?intval(Input::get('pageSize')):'10';
        $select = ['goods_game.goods_name', 'goods_game.goods_price','goods_game.is_check','goods_game.is_on_sale','goods_game.goods_stock','goods_game.created_at','goods_game.is_cut_price','goods_game.goods_code','goods_game.sale_end_time'
            ,'goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu'];
        if(Input::except('menu')){
            $where =array();
            $game_id = empty(Input::get('game'))?'':$this->getId(Input::get('game'));
            $qu_id = empty(Input::get('area'))?'':$this->getId(Input::get('area'));
            $fwq_id = empty(Input::get('server'))?'':$this->getId(Input::get('server'));
            $type_id = empty(Input::get('type'))?'':$this->getId(Input::get('type'));
            $trash_type = Input::get('SellType');
            $order_sn = Input::get('order_sn');
            $start_time = strtotime(Input::get('act_start_time'));
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = strtotime(Input::get('act_end_time'))?strtotime(Input::get('act_end_time')):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            $order_status = Input::get('order_status');
            if($game_id){
                $where['goods_game.game_id']=$game_id;
                $page_path['game']=Input::get('game');
            }
            if($qu_id){
                $where['goods_game.qu_id']=$qu_id;
                $page_path['area']=Input::get('area');
            }
            if($fwq_id){
                $where['goods_game.game_qu_id']=$fwq_id;
                $page_path['server']=Input::get('server');
            }
            if($type_id){
                $where['goods_game.goods_type_id']=$type_id;
                $page_path['type']=Input::get('type');
            }

            if($order_sn){
                $where['order.order_sn']=$order_sn;
                $page_path['order_sn']=Input::get('order_sn');
            }
            
            if($order_status){
                if($order_status=='1' || $order_status=='2'){
                    $where['goods_game.is_check']=$order_status;
                }elseif($order_status=='11'){
                    $where['goods_game.is_check']='1';
                    $where['goods_game.is_on_sale']='1';
                }elseif ($order_status=='12'){
                    $where['goods_game.is_check']='0';
                }elseif($order_status=='10'){
                    $where['goods_game.is_on_sale']='0';
                }
                $page_path['order_status']=Input::get('order_status');
            }
            
            if($start_time){
                $page_path['act_start_time']=Input::get('act_start_time');
            }
            if($start_time){
                $page_path['act_end_time']=Input::get('act_end_time');
            }

            $game_name = $game_id?Game::where('id',$game_id)->select('game_name')->first()->toArray():'';
            $qu_name = $qu_id?GameQu::where('id',$qu_id)->select('qu_name')->first()->toArray():'';
            $fwq_name = $fwq_id?GameQu::where('id',$fwq_id)->select('qu_name')->first()->toArray():'';
            $type_name = $type_id?GameType::where('id',$type_id)->select('type')->first()->toArray():'';

            switch ($trash_type){
                case 'a':
                    $jy_type = '全部商品';
                    $trash='';
                    break;
                case 's':
                    $jy_type = '寄售商品';
                    $trash='0';
                    break;
                case 'd':
                    $jy_type = '担保商品';
                    $trash='1';
                    break;
                case 'c':
                    $jy_type = '帐号交易';
                    $trash='';
                    break;
                case '':
                    $jy_type ='';
                    break;
            }


            if(isset($trash) && $trash!=''){
                $where['goods_game.traded_type']=$trash;
                $page_path['SellType']=Input::get('SellType');
            }
            if($order_sn){
                $goodsShow = DB::table('goods_game')
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where('goods_game.goods_code',$order_sn)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->where('goods_game.is_trash','0')
                    ->whereBetween('goods_game.sale_start_time', array($start_time, $end_time))
                    ->orderBy('goods_game.created_at', 'desc')
                    ->Paginate($pageSize);
            }else{

                $goodsShow = DB::table('goods_game')
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where($where)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->where('goods_game.is_trash','0')
                    ->whereBetween('goods_game.sale_start_time', array($start_time, $end_time))
                    ->orderBy('goods_game.created_at', 'desc')
                    ->Paginate($pageSize);
            }
           // dd(DB::getQueryLog());
            //dd($goodsShow);
        }
        //dd(DB::getQueryLog());
        if(!isset($goodsShow))
            $goodsShow = DB::table('goods_game')
                ->join('game', function($join)
                {
                    $join->on('game.id', '=', 'goods_game.game_id');
                })
                ->join('game_qu', function($join)
                {
                    $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                })
                ->join('game_qu as qu', function($join)
                {
                    $join->on('qu.id', '=', 'goods_game.qu_id');
                })
                ->join('game_type', function($join)
                {
                    $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                })
                ->select($select)
                ->where('goods_game.user_id',$user['id'])
                ->where('goods_game.traded_type','!=','2')
                ->where('goods_game.is_trash','0')
                ->orderBy('goods_game.created_at', 'desc')
                ->Paginate($pageSize);
        return view('user.my_sell',compact('user','str','filter','url','goodsShow','game_name','qu_name','fwq_name','type_name','jy_type','page_path'));
    }

    /**
     * 编辑商品 页面
     */
    public function EditGoods()
    {
        $user = $this->getUser();
        $vip_level = $this->vip_level($user['user_point_buy']);
        $goods_id = intval(Input::get('goods_id'));
        $uid = intval(Input::get('uid'));
        if($user['id']!=$uid){  //判断是否当前用户
            return abort(404);
        }
        if($goods = GoodsGame::where(['id'=>$goods_id,'user_id'=>$uid])->first()){
            $goods_pic = GoodsPicture::where('goods_id',$goods['id'])->get();
          //  dd($goods_pic);
            $goods_user_info = GameUserInfo::where('goods_id',$goods['id'])->first();
            $game = Game::where('id',$goods['game_id'])->select('game_name')->first()->toArray();
            $fwq = GameQu::where('id',$goods['game_qu_id'])->first()->toArray();
            $qu = GameQu::where('id',$goods['qu_id'])->first()->toArray();
            $type = GameType::where('id',$goods['goods_type_id'])->first()->toArray();
            $arr_data = (new Attribute())->attr($goods['game_id'],$goods['goods_type_id'])?(new Attribute())->attr($goods['game_id'],$goods['goods_type_id'])->toArray():array('0'=>array('0'=>$type['type']));
            if(isset($arr_data['data'])){
                $arr_data = json_decode($arr_data['data']);
                $arr_data = $arr_data->value;
            }
            if($accounts = (new Attribute())->attr($goods['game_id'],$goods['goods_type_id'])){
                $accounts = $this->getQuData($accounts['data'])?$this->getQuData($accounts['data']):array();
            }
            //读取绑定银行卡
            $bank_info = DB::table('user_bank')->select('id','data')->where('user_id',$user['id'])->get();
            foreach ($bank_info as $k=>$v){
                $bank_info[$k] = json_decode($v->data,true);
                $bank_info[$k]['id'] = $v->id;
            }
            //计算天数
            $timediff = $goods['sale_end_time']-$goods['sale_start_time'];
            $days = intval($timediff/86400);
            return view('user.edit_goods',compact('user','game','fwq','qu','type','vip_level','arr_data','bank_info','traded_type','accounts','goods','goods_pic','goods_user_info','days'));
        }else{      //非法操作
            return abort(404);
        }
    }

    /**
     *  修改 流程
     */
    public function EditGoodsDo(Requests\HomeEditGoodsRequest $request)
    {
        if(Input::method()=='POST'){        //修改操作
            $goods_id = intval(Input::get('gid'));
            $vip_level = Input::get('vip_level');
            //商品表修改
            $goods_data['goods_price'] = $request->goods_price;
            $goods_data['goods_name'] = isset($request->is_acc)?json_encode($request->attr_value,JSON_UNESCAPED_UNICODE).htmlspecialchars($request->goods_name):htmlspecialchars($request->goods_name);
            $goods_data['goods_stock'] = intval($request->goods_stock);
            $goods_data['goods_content'] =  htmlspecialchars($request->goods_content);
            $goods_data['security'] = $request->security;
            $goods_data['code'] = $request->code?$request->code:'';
            $goods_data['pwd'] = $request->pwd?$request->pwd:'';
            $goods_data['sale_end_time'] = $vip_level>=$request->sale_end_time?strtotime('+'.$request->sale_end_time." day"):strtotime('+'.$vip_level.'day');
            $goods_data['best_time'] = $request->best_time;
            $goods_data['to_money'] = $request->to_money;
            $goods_data['account'] = $request->account;
            $goods_data['one_num'] = $request->one_num?$request->one_num:'0';
            $goods_data['attr_value'] = isset($request->attr_value)?json_encode($request->attr_value,JSON_UNESCAPED_UNICODE):'';
            $goods_data['is_check'] = '0';
            $goods_data['is_on_sale'] ='0';
            //商品对应帐号信息
            $info['game_user_name'] = $request->game_user_name?$request->game_user_name:'';
            $info['game_user_pwd'] = $request->game_user_pwd?$request->game_user_pwd:'';
            $info['secretcard_img'] = $request->secretcard_img?$request->secretcard_img:'';
            $info['is_secretcard'] = $info['secretcard_img']==''?'0':'1';
            $info['datacard'] = $request->datacard;
            $info['is_datacard'] = $info['datacard']==''?'0':'1';
            $info['game_user_tel'] = $request->game_user_tel;
            $info['game_user_qq'] = $request->game_user_qq;
            $info['mb_tel'] = $request->mb_tel?$request->mb_tel:'';
            $info['mb_question'] = $request->mb_question?$request->mb_question:'';
            $info['mb_answer'] = $request->mb_answer?$request->mb_answer:'';
            $info['game_user'] = $request->game_user?$request->game_user:'';
            $info['two_level_pass'] = $request->two_level_pass?$request->two_level_pass:'';
            try {
                DB::transaction(function () use($goods_data,$request,$info,$goods_id){  //开启事务
                    DB::table('goods_game')->where('id',$goods_id)->update($goods_data);  //修改商品表
                    if($request->pictrue!=''){
                        //商品图片
                        $pictrue=array_combine($request->pictrue_id,$request->pictrue);  //合并商品相册数组
                        $key = '0';
                        foreach ($pictrue as $k=>$v) {
                            if (is_numeric($k)) {   //更新
                                $delete[] = $k;
                                DB::table('goods_game_picture')->where('id',$k)->update(['picture'=>$v]);
                                unset($pictrue[$k]);
                            } else {        //新增
                                $img[$key]['goods_id'] = $goods_id;
                                $img[$key]['picture'] = $v;
                                $img[$key]['create_time'] = time();
                                $key++;
                            }
                        }
                        DB::table('goods_game_picture')->where('goods_id',$goods_id)->whereNotIn('id',$delete)->delete();
                        DB::table('goods_game_picture')->insert($img);
                    }
                    $msg = DB::table('game_user_info')->where('goods_id',$goods_id)->update($info);      //更新帐号信息
                });
                return $json =[
                    'status'=>'1',
                    'info'=>trans('com.operation_success')
                ];

            } catch (Exception $e) {
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }
        }
    }

    /**
     * 我的商品订单
     */
    public function SellOrder()
    {
        $str = Letter;
        $user = $this->getUser();
        $filter='goods';  //标识
        $url = Input::url();
        $pageSize = Input::get('pageSize')!==false && !empty(Input::get('pageSize'))?intval(Input::get('pageSize')):'10';
        $select = ['goods_game.goods_name', 'goods_game.goods_price','order.order_status','order.buy_number','order.order_status','order.pay_status','order.id as order_id','order.order_type',
            'order.order_amount','order.created_at','order.order_sn','order.flag','goods_game.id','game.game_name','game_qu.qu_name','game_type.type','qu.qu_name as da_qu'];
        if(Input::except('menu')){
            $where =array();
            $game_id = empty(Input::get('game'))?'':$this->getId(Input::get('game'));
            $qu_id = empty(Input::get('area'))?'':$this->getId(Input::get('area'));
            $fwq_id = empty(Input::get('server'))?'':$this->getId(Input::get('server'));
            $type_id = empty(Input::get('type'))?'':$this->getId(Input::get('type'));
            $trash_type = Input::get('SellType');
            $order_sn = Input::get('order_sn');
            $start_time = strtotime(Input::get('act_start_time'));
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = strtotime(Input::get('act_end_time'))?strtotime(Input::get('act_end_time')):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            $order_status = Input::get('order_status');
            if($game_id){
                $where['goods_game.game_id']=$game_id;
                $page_path['game']=Input::get('game');
            }
            if($qu_id){
                $where['goods_game.qu_id']=$qu_id;
                $page_path['area']=Input::get('area');
            }
            if($fwq_id){
                $where['goods_game.game_qu_id']=$fwq_id;
                $page_path['server']=Input::get('server');
            }
            if($type_id){
                $where['goods_game.goods_type_id']=$type_id;
                $page_path['type']=Input::get('type');
            }

            if($order_sn){
                $where['order.order_sn']=$order_sn;
                $page_path['order_sn']=Input::get('order_sn');
            }
            if($order_status){
                if($order_status=='1' || $order_status=='3' || $order_status=='4'){
                    $where['order.order_status']=$order_status;
                }elseif ($order_status=='12'){
                    $where['order.pay_status']='1';
                }
                $page_path['order_status']=Input::get('order_status');
            }
            if($start_time){
                $page_path['act_start_time']=Input::get('act_start_time');
            }
            if($end_time){
                $page_path['act_end_time']=Input::get('act_end_time');
            }
            if($order_sn){
                $page_path['order_sn']=Input::get('order_sn');
            }

            $game_name = $game_id?Game::where('id',$game_id)->select('game_name')->first()->toArray():'';
            $qu_name = $qu_id?GameQu::where('id',$qu_id)->select('qu_name')->first()->toArray():'';
            $fwq_name = $fwq_id?GameQu::where('id',$fwq_id)->select('qu_name')->first()->toArray():'';
            $type_name = $type_id?GameType::where('id',$type_id)->select('type')->first()->toArray():'';
            switch ($trash_type){
                case 'a':
                    $jy_type = '全部商品';
                    $trash='';
                    break;
                case 's':
                    $jy_type = '寄售商品';
                    $trash='0';
                    break;
                case 'd':
                    $jy_type = '担保商品';
                    $trash='1';
                    break;
                case 'c':
                    $jy_type = '帐号交易';
                    $trash='';
                    break;
                case '':
                    $jy_type ='';
                    break;
            }
            if(isset($trash) && $trash!=''){
                $where['goods_game.traded_type']=$trash;
                $page_path['SellType']=Input::get('SellType');
            }
            if($order_sn){
                $goodsShow = DB::table('order')
                    ->join('goods_game', function($join)
                    {
                        $join->on('goods_game.id', '=', 'order.goods_id');
                    })
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where('order.order_sn',$order_sn)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->whereBetween('order.created_at', array($start_time, $end_time))
                    ->orderBy('order.created_at', 'desc')
                    ->Paginate($pageSize);
                //dd($goodsShow);
            }else{
                $goodsShow = DB::table('order')
                    ->join('goods_game', function($join)
                    {
                        $join->on('goods_game.id', '=', 'order.goods_id');
                    })
                    ->join('game', function($join)
                    {
                        $join->on('game.id', '=', 'goods_game.game_id');
                    })
                    ->join('game_qu', function($join)
                    {
                        $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                    })
                    ->leftjoin('game_qu as qu', function($join)
                    {
                        $join->on('qu.id', '=', 'goods_game.qu_id');
                    })
                    ->join('game_type', function($join)
                    {
                        $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                    })
                    ->select($select)
                    ->where($where)
                    ->where('goods_game.traded_type','!=','2')
                    ->where('goods_game.user_id',$user['id'])
                    ->whereBetween('order.created_at', array($start_time, $end_time))
                    ->orderBy('order.created_at', 'desc')
                    ->Paginate($pageSize);
            }
            //dd(DB::getQueryLog());
            //dd($goodsShow);
        }
        //dd(DB::getQueryLog());
        if(!isset($goodsShow))
            $goodsShow = DB::table('order')
                ->join('goods_game', function($join)
                {
                    $join->on('goods_game.id', '=', 'order.goods_id');
                })
                ->join('game', function($join)
                {
                    $join->on('game.id', '=', 'goods_game.game_id');
                })
                ->join('game_qu', function($join)
                {
                    $join->on('game_qu.id', '=', 'goods_game.game_qu_id');
                })
                ->join('game_qu as qu', function($join)
                {
                    $join->on('qu.id', '=', 'goods_game.qu_id');
                })
                ->join('game_type', function($join)
                {
                    $join->on('game_type.id', '=', 'goods_game.goods_type_id');
                })
                ->select($select)
                ->where('goods_game.user_id',$user['id'])
                ->where('goods_game.traded_type','!=','2')
                ->orderBy('order.created_at', 'desc')
                ->Paginate($pageSize);
        return view('user.sell_order',compact('user','str','goodsShow','game_name','qu_name','fwq_name','type_name','jy_type','page_path','url','filter'));
    }
    /**
     * 降价信息管理
     */
    public function changePriceInfo()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        if($input=Input::except('menu')){
            $status = intval($input['cut_status']);
            $data = DB::table('cut_price')->where('to_user_id',$user['id'])->where('status',$status)->get();
        }else{
            $data = DB::table('cut_price')->where('to_user_id',$user['id'])->get();
        }
        foreach ($data as $k=>$v){
            $data[$k]->goods =  $this->GetGameById($v->goods_id);
        }
        $type = 'sell';
        return view('user.changePrice',compact('user','data','type'));
    }
    /**
     * 改变降价信息
     */
    public function changePriceStatus()
    {
        if(Input::method()=='DELETE'){
            $id = Route::input('id');
            $status = intval(Input::get('status'));
            if($status==2){             //同意的同时生成订单
                $cut_info = DB::table('cut_price')->where('id',$id)->first();
                $goods_data = $this->GetGameById($cut_info->goods_id); //读取商品缓存
                $order['order_sn'] = $this->orderSn($this->Pinyin($goods_data['has_many_type']['type']));
                $order['order_type'] = $goods_data['traded_type'];
                $order['user_id'] = $cut_info->user_id;
                $order['goods_price'] = $cut_info->new_price;
                $order['buy_number'] = intval($cut_info->buy_number);
                $order['goods_amount'] = $order['buy_number']*$order['goods_price'];
                $order['order_amount'] = $order['goods_amount'];
                $order['goods_id'] = $cut_info->goods_id;
                $order['created_at'] = time();
                $order['flag'] = trans('com.cut_order');
                $order_address['user_id'] = $order['user_id'];
                $order_address['game_id'] = $goods_data['game_id'];
                $order_address['da_qu_id'] = $goods_data['qu_id'];
                $order_address['xia_qu_id'] = $goods_data['game_qu_id'];
                $order_address['role_name'] = $cut_info->role_name;
                $order_address['telphone'] = $cut_info->telphone;
                $order_address['qq'] = $cut_info->qq;
                try {
                    DB::transaction(function () use($order,$order_address,$status,$id){  //开启事务
                        $order_id = DB::table('order')->insertGetId($order);  //写入订单数据
                        $order_address['order_id'] = $order_id;
                        DB::table('user_order_address') -> insert($order_address);
                        $result = DB::table('cut_price')->where('id',$id)->update(['status'=>$status,'order_sn'=>$order['order_sn']]);
                    });
                    Event::fire(new SendMessage($order['user_id'],'seller.cut_price','','','',$goods_data['goods_code']));
                    return $json =[
                        'status'=>'1',
                        'info'=>trans('com.operation_success')
                    ];

                } catch (Exception $e) {
                    return $json =[
                        'status'=>'-1',
                        'info'=>trans('com.system_error')
                    ];
                }
            }
            $result = DB::table('cut_price')->where('id',$id)->update(['status'=>$status]);
            if (!$result) {
                return $json =[
                    'status'=>'-1',
                    'info'=>trans('com.system_error')
                ];
            }else{
                return $json =[
                    'status'=>'1',
                    'info'=>trans('com.operation_success')
                ];
            }
        }
    }
    
    
    /**
     * 基本信息
     */
    public function info()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        if(Input::method()=='GET'){
            return view('user.info',compact('user'));
        }elseif (Input::method()=='POST'){
            if(!preg_match("/^[1-9][0-9]{4,12}$/",Input::get('qq'))){
                return back()->with('msg','QQ格式不正确');
            }
            if(!preg_match("/^1[34578]\d{9}$/",Input::get('telphone'))){
                return back()->with('msg','手机格式不正确');
            }

            if(Input::get('verifyCode')!='' && $this->verifyCode(Input::except('menu'))!==true && $user['telphone']!=Input::get('telphone')){
                return redirect()->back()->withErrors($this->verifyCode(Input::except('menu')));
            }elseif (Input::get('verifyCode')=='' && $user['telphone']!=Input::get('telphone')){
                return back()->with('msg','请输入验证码');
            }
            else{
                $data['qq'] = Input::get('qq');
                $data['telphone'] = Input::get('telphone');
                $data['head_img'] = Input::get('thumb');
                $msg = User::where('id',$user['id'])->update($data);
                if($msg){
                    Cache::forget('user_info_'.$user['id']);
                    return back()->with('msg','修改成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }
        }
    }

    /**
     * 完善信息
     */
    public function perfect_info()
    {
        $user = $this->getUser();
        if($user['pay_password']!=''){
            return back();
        }
        if(Input::method()=="POST"){
           $input = Input::except('_token','verify_mobileCode','redirectUrl');
           if($input['pay_password']!=$input['comfirm_password']){   //验证两次输入的支付密码
               return $data = [
                    'status'=>"n",
                    'info'  =>trans('com.comfirm')
               ];
           }
            unset($input['comfirm_password']);
            if($user['is_check_phone']=='0'){
                $validator =Validator::make(Input::except('menu'), [       //验证，验证码对应的手机号是否改变
                    'telphone'     => 'required|confirm_mobile_not_change',
                    'verifyCode' => 'required|verify_code',
                    'qq'           => 'required|unique:users,qq|regex:/^[1-9]\d{4,13}$/'
                ],
                    ['telphone.confirm_mobile_not_change'=>trans('com.change_phone_and_code')]
                );
                if ($validator->fails()) {
                    //验证失败后建议清空存储的发送状态，防止用户重复试错
                    SmsManager::forgetState();
                    return $data=[
                        'status'=>'n',
                        'info' => json_encode($validator->messages(),JSON_UNESCAPED_UNICODE)
                    ];
                }
            }
            if($user['is_check_phone']=='1'){
                unset($input['telphone']);
            }
            $input['pay_password'] = bcrypt($input['pay_password']);
            $input['is_check_phone'] = '1';
            $msg = User::where('id',$user['id'])->update($input);
            if($msg){
                Cache::forget('user_info_'.$user['id']);
                return $data=[
                    'status'=>'y',
                    'info' => trans('com.operation_success')
                ];
            }else{
                return $data=[
                    'status'=>'n',
                    'info' => trans('com.system_error')
                ];
            }
        }
        return view('user.perfect_info',compact('user'));
    }


    /**
     * 修改登录密码
     */
    public function reset_pass()
    {
        $user = $this->getUser();
        if($user['question']==''){
            return redirect('/user/question');
        }
        //验证密保问题
        if(Input::method()=='GET'){
            $url = Input::url();
            return view('user.check_answer',compact('user','url'));
        }elseif(Input::method()=='POST'){
            return view('user.reset_pass',compact('user'));
        }
    }

    /**
     * 修改登录密码操作
     */
    public function reset_pass_update()
    {
        $o_password = Input::get('o_password');
        $password = Input::get('password');
        $password_confirmation = Input::get('password_confirmation');
        if(password_verify($o_password,Auth::user()->password)===false){
            return back()->with('msg','原登录密码错误');
        }
        if($password==$password_confirmation){
            $msg = User::where('id',Auth::user()->id)->update(['password'=>bcrypt($password)]);
            if($msg){
                Cache::forget('user_info_'.Auth::user()->id);
                Event::fire(new SendMessage(Auth::user()->id,'user.edit_login_password','','',Auth::user()->name,''));
                return back()->with('msg','密码修改成功');
            }else{
                return back()->with('msg','系统错误，请稍后重试');
            }
        }else{
            return back()->with('msg','两次输入的密码不一致');
        }
    }

    /**
     * 判断原密码是否正确
     */
    public function check_old_pass()
    {
        $o_password = Input::get('param');
        if(Input::get('t')!==null){
            $pass = Auth::user()->pay_password;
        }else{
            $pass = Auth::user()->password;
        }
        if(password_verify($o_password,$pass)===false){
            return $data=[
                'status'=>'-1',
                'info'=>'密码错误'
            ];
        }else{
            return $data=[
                'status'=>'y',
            ];
        }
    }

    /**
     * 修改支付密码
     */
    public function EditPayPass()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        if($user['question']==''){
            return redirect('/user/question');
        }
        //验证密保问题
        if(Input::method()=='GET'){
            $url = Input::url();
            return view('user.check_answer',compact('user','url'));
        }elseif(Input::method()=='POST'){
            return view('user.EditPayPass',compact('user'));
        }
    }

    /**
     * 修改支付密码操作
     */
    public function EditPayPass_update()
    {
        $o_password = Input::get('o_password');
        $password = Input::get('password');
        $password_confirmation = Input::get('password_confirmation');
        if(password_verify($o_password,Auth::user()->pay_password)===false){
            return back()->with('msg','原支付密码错误');
        }
        if($password==$password_confirmation){
            $msg = User::where('id',Auth::user()->id)->update(['pay_password'=>bcrypt($password)]);
            if($msg){
                Cache::forget('user_info_'.Auth::user()->id);
                Event::fire(new SendMessage(Auth::user()->id,'user.edit_pay_password','','',Auth::user()->name,''));
                return back()->with('msg','支付密码修改成功');
            }else{
                return back()->with('msg','系统错误，请稍后重试');
            }
        }else{
            return back()->with('msg','两次输入的密码不一致');
        }
    }

    /**
     * 设置 修改密保问题
     */
    public function question()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        if($user['question']=='' && Input::method()=='POST'){   //设置密保
            $question = Input::get('n_question');
            $answer = Input::get('n_answer');
            $msg = User::where('id',$user['id'])->update(['question'=>$question,'answer'=>$answer]);
            if($msg){
                Cache::forget('user_info_'.$user['id']);
                Event::fire(new SendMessage($user['id'],'user.edit_answer','','',$user['name'],''));
                return back()->with('msg','密保设置成功');
            }else{
                return back()->with('msg','系统错误，请稍后重试');
            }
        }elseif ($user['question']!='' && Input::method()=='POST'){  //修改密保
            $answer = Input::get('answer');
            if($answer==$user['answer']){
                $n_question = Input::get('n_question');
                $n_answer = Input::get('n_answer');
                $msg = User::where('id',$user['id'])->update(['question'=>$n_question,'answer'=>$n_answer]);
                if($msg){
                    Cache::forget('user_info_'.$user['id']);
                    Event::fire(new SendMessage($user['id'],'user.edit_answer','','',$user['name'],''));
                    return back()->with('msg','密保修改成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->with('msg','原密保答案错误');
            }

        }
        return view('user.question',compact('user'));
    }
    /**
     * 修改，绑定手机
     */
    public function tel()
    {
        $user = $this->getUser();
        if(Input::method()=='POST') {
            if ($this->verifyCode(Input::except('menu')) !== true) {
                return redirect()->back()->withErrors($this->verifyCode(Input::except('menu')));
            }else{
                $msg = User::where('id',$user['id'])->update(['telphone'=>Input::get('telphone'),'is_check_phone'=>'1']);
                if($msg){
                    Cache::forget('user_info_'.$user['id']);
                    Event::fire(new SendMessage($user['id'],'user.edit_phone','','',$user['name'],''));
                    return back()->with('msg','手机号绑定成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }
        }
        return view('user.tel',compact('user'));
    }
    /**
     *   更换手机号码
     */
    public function changePhone()
    {
        $user = $this->getUser();
        if(Input::method()=="POST"){
           if(Input::get('new_phone')==Input::get('r_phone')){
                $msg = User::where('id',$user['id'])->update(['telphone'=>Input::get('new_phone')]);
               if($msg){
                   Cache::forget('user_info_'.$user['id']);
                   Event::fire(new SendMessage($user['id'],'user.edit_phone','','',$user['name'],''));
                   return $data=[
                       'status'=>'y',
                       'info' =>'手机号码更换成功'
                   ];
               }else{
                   return $data=[
                       'status'=>'n',
                       'info' =>'系统错误，请稍后重试'
                   ];
               }
           }else{
               return $data=[
                   'status'=>'n',
                   'info' =>'两次输入的号码不一致'
               ];
           }
        }else{
            return view('user.changePhone',compact('user'));
        }
    }
    public function changePhoneActive()
    {
        $user = $this->getUser();
        if(Input::method()=="POST"){
        if($this->verifyCode(Input::except('menu'))===true){
            $new = 1;
            return view('user.changePhoneActive',compact('user','new'));
        }else{
            return back()->with('msg',trans('com.error_code'));
        }
        }else{
            return view('user.changePhoneActive',compact('user'));
        }
    }

    /**
     * 绑定ip
     */
    public function Ip()
    {
        $user = $this->getUser();
        $data = DB::table('user_ip')->select('ip_info')->where('user_id',$user['id'])->first();
        $ip_info = (explode('*',$data->ip_info));
        foreach ($ip_info as $k=>$v){
            $ip_info[$k]=unserialize($v);
        }
        if(Input::get('status')==1){   //已绑定列表
            $ip_info = explode(',',$user['bind_ip']);
            if($ip_info[0]==''){
                $ip_info = array();
            }
            $type = 'u';
        }elseif (Input::method()=='POST'){      //绑定操作
            if($this->verifyCode(Input::all())!==true){
                return $data = [
                    'status'=>'n',
                    'info'  =>trans('com.error_code')
                ];
            }
            $k = Input::get('k');
            $ip_arr = explode('.',$ip_info[$k]['ip']);
            $ip = $ip_arr[0].'.'.$ip_arr[1];         //得到当前绑定的IP前两端
            if($user['bind_ip']!=''){     //判断有没绑定IP，有则追加
                if(count(explode(',',$user['bind_ip']))==3){
                    return $data = [
                        'status'=>'n',
                        'info'  =>trans('home.has_ip_more')
                    ];
                }elseif($user['bind_ip']==$ip){
                    return $data = [
                        'status'=>'n',
                        'info'  =>trans('home.has_ip')
                    ];
                }else{
                    $new_ip = $user['bind_ip'].','.$ip;
                    $msg = User::where('id',$user['id'])->update(['bind_ip'=>$new_ip]);
                    if($msg){
                        Event::fire(new SendMessage($user['id'],'user.edit_ip','','',$user['name'],''));
                        Cache::forget('user_info_'.$user['id']);
                        return $data = [
                            'status'=>'y',
                            'info'  =>trans('com.operation_success')
                        ];
                    }else{
                        return $data = [
                            'status'=>'n',
                            'info'  =>trans('com.system_error')
                        ];
                    }
                }
            }else{
                $msg = User::where('id',$user['id'])->update(['bind_ip'=>$ip]);
                if($msg){
                    Cache::forget('user_info_'.$user['id']);
                    Event::fire(new SendMessage($user['id'],'user.edit_ip','','',$user['name'],''));
                    return $data = [
                        'status'=>'y',
                        'info'  =>trans('com.operation_success')
                    ];
                }else{
                    return $data = [
                        'status'=>'n',
                        'info'  =>trans('com.system_error')
                    ];
                }
            }
        }elseif(Input::method()=='DELETE'){         //解绑操作
            $k = Input::get('k');
            $ip_info = explode(',',$user['bind_ip']);
            unset($ip_info[$k]);
            $ip = implode(',',$ip_info);
            $msg = User::where('id',$user['id'])->update(['bind_ip'=>$ip]);
            if($msg){
                Cache::forget('user_info_'.$user['id']);
                Event::fire(new SendMessage($user['id'],'user.edit_ip','','',$user['name'],''));
                return $data = [
                    'status'=>'1',
                    'info'  =>trans('com.operation_success')
                ];
            }else{
                return $data = [
                    'status'=>'-1',
                    'info'  =>trans('com.system_error')
                ];
            }
        }
        else{                                       //登录明细
            $data = DB::table('user_ip')->select('ip_info')->where('user_id',$user['id'])->first();
            $ip_info = (explode('*',$data->ip_info));
            foreach ($ip_info as $k=>$v){
                $ip_info[$k]=unserialize($v);
            }
            krsort($ip_info);
            $type = 'n';
        }
        return view('user.ip',compact('user','ip_info','type'));
    }

    /**
     * 帐号充值
     */
    public function recharge()
    {
        $user = $this->getUser();
        return view('user.recharge',compact('user'));
    }

    /**
     * 提现
     */
    public function Withdrawal()
    {
        $this->is_(Input::url());
        $user = $this->getUser();
        //验证密保问题
        if($user['question']==''){
            return redirect('/user/question');
        }
        if(Input::method()=='GET'){
            $url = Input::url();
            return view('user.check_answer',compact('user','url'));
        }elseif (Input::method()=='POST'){
            if(Input::get('verifyCode')!==null){
                if(password_verify(Input::get('pay_password'),$user['pay_password'])===false){
                    return $data = [
                        'status'=>'n',
                        'info'  =>trans('com.pay_pass_error')
                    ];
                }
                if(!$this->verifyCode(Input::except('menu'))){
                    return $data = [
                        'status'=>'n',
                        'info'  =>trans('com.error_code')
                    ];
                }
                $account['user_id'] = $user['id'];
                $account['amount'] = Input::get('money');
                $account['process_type'] = 1;
                $account['payment'] = Input::get('withdrawal');
                $account['created_at'] = date('Y-m-d H:i:s',time());
                $account['updated_at'] = $account['created_at'];
                if($account['payment']==ALIPAY){
                    $account['user_note'] = '姓名：'.Input::get('alipay_name').'帐号:'.Input::get('alipay_zh');
                }else{
                    $account['user_note'] = Input::get('bank_id');
                }
                    //把提现金额冻结
                    try {
                        DB::transaction(function () use($user,$account){
                                $msg = UserAccount::insert($account);   //写入用户资金流动表
                                $accoun['money'] = -$account['amount'];
                                $accoun['frozen_money'] = $account['amount'];
                                $accoun['change_time'] = time();
                                $accoun['change_desc'] = '用户提现';
                                $accoun['change_type'] ='1';
                                $accoun['user_id'] =$user['id'];
                                DB::table('account_log')->insert($accoun);
                                DB::table('users')->where('id',$user['id'])->decrement('money',$account['amount']);
                                DB::table('users')->where('id',$user['id'])->increment('frozen_money',$account['amount']);
                        });
                        Cache::forget('user_info_'.$user['id']);
                        return $data = [
                            'status'=>'y',
                            'info'  =>trans('com.operation_success')
                        ];
                    } catch (Exception $e) {
                        return $data = [
                            'status'=>'n',
                            'info'  =>trans('com.system_error')
                        ];
                    }
                }

            $bank_info = DB::table('user_bank')->select('id','data')->where('user_id',$user['id'])->get();
            $is_empty = empty($bank_info)?'':'1';
            //验证是否实名通过，没实名则跳转实名
            if($user['is_check_datecard']==''){
                return redirect('/user/IDCard');
            }
            foreach ($bank_info as $k=>$v){
                $bank_info[$k] = json_decode($v->data,true);
                $bank_info[$k]['id'] = $v->id;
            }
            return view('user.Withdrawal',compact('user','bank_info','is_empty'));
        }
    }

    /**
     *   资金明细
     */
    public function MoneyInfo()
    {
        $user = $this->getUser();
        $count_buy = abs(Account::where('user_id',$user['id'])->where('change_type','3')->sum('money'));   //统计支付
        $count_sell = abs(Account::where('user_id',$user['id'])->where('change_type','4')->sum('money'));//售得
        $count_recharge = abs(Account::where('user_id',$user['id'])->where('change_type','0')->sum('money'));
        $count_withdrawals = abs(Account::where('user_id',$user['id'])->where('change_type','1')->sum('money'));
        $input = Input::except('menu');
        if(isset($input['act_start_time']) && $input['act_start_time']!=''){
            $page_path['act_start_time']=$input['act_start_time'];
            $start_time = strtotime($input['act_start_time']);
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = isset($input['act_end_time'])?strtotime($input['act_end_time']):time();

            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            if(isset($input['act_end_time'])){
                $page_path['act_end_time']=$input['act_end_time'];
            }else{
                $page_path['act_end_time']=date('Y-m-d',time());
            }
        }
        if(isset($input['status']) && is_numeric($input['status'])){
            $where['change_type'] = $input['status']==10?'0':$input['status'];
            $page_path['status']= $input['status'];
        }
        $where['user_id'] = $user['id'];
        if(isset($start_time)){
            $data = Account::where($where)->whereBetween('change_time', array($start_time, $end_time))->where(function($query){
                $query->where('money','<>','0')
                    ->orWhere(function($query){
                        $query->where('frozen_money','<>', '0');
                    });})
                ->orderBy('change_time','desc')->Paginate(PAGE);
        }else{
            $data = Account::where($where)->where(function($query){
                $query->where('money','<>',0)
                    ->orWhere(function($query){
                        $query->where('frozen_money','<>',0);
                    });})->orderBy('change_time','desc')->Paginate(PAGE);
            // dd(DB::getQueryLog());
        }
        $data = count($data)==0?1:$data;
        return view('user.MoneyInfo',compact('user','data','count_buy','count_sell','count_recharge','count_withdrawals','page_path'));
    }



    /**
     * 积分明细
     */
    public function integral()
    {
        $user = $this->getUser();
        $input = Input::except('menu');
        if(isset($input['act_start_time']) && $input['act_start_time']!=''){
            $page_path['act_start_time']=$input['act_start_time'];
            $start_time = strtotime($input['act_start_time']);
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = isset($input['act_end_time'])?strtotime($input['act_end_time']):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            if(isset($input['act_end_time'])){
                $page_path['act_end_time']=$input['act_end_time'];
            }else{
                $page_path['act_end_time']=date('Y-m-d',time());
            }
        }
        $where['user_id'] = $user['id'];
        if(isset($start_time)){
            $data = Account::where($where)->whereBetween('change_time', array($start_time, $end_time))->where('integral','<>',0)->orderBy('change_time','desc')->Paginate(PAGE);
            // dd(DB::getQueryLog());
        }else{
            $data = Account::where($where)->where('integral','<>',0)->orderBy('change_time','desc')->Paginate(PAGE);
        }
        return view('user.integral_info',compact('user','data','page_path'));
    }

    /**
     * 兑换商品列表
     */
    public function ExchangeList()
    {
        $user = $this->getUser();
        $input = Input::except('menu');
        if(isset($input['act_start_time']) && $input['act_start_time']!=''){
            $page_path['act_start_time']=$input['act_start_time'];
            $start_time = strtotime($input['act_start_time']);
            $start_time = mktime(0,0,0,date("m",$start_time),date("d",$start_time),date("Y",$start_time));
            $end_time = isset($input['act_end_time'])?strtotime($input['act_end_time']):time();
            $end_time = mktime(23,59,59,date("m",$end_time),date("d",$end_time),date("Y",$end_time));
            if(isset($input['act_end_time'])){
                $page_path['act_end_time']=$input['act_end_time'];
            }else{
                $page_path['act_end_time']=date('Y-m-d',time());
            }
        }
        if(isset($input['status']) && is_numeric($input['status'])){
            $where['order_status'] = $input['status'];
            $page_path['status']= $input['status'];
        }
        $where['user_id'] = $user['id'];
        if(isset($start_time)){
            $data = ExchangeOrder::with('exchange')->where($where)->whereBetween('create_time', array($start_time, $end_time))->orderBy('create_time','desc')->Paginate(PAGE);
            // dd(DB::getQueryLog());
        }else{
            $data = ExchangeOrder::with('exchange')->where($where)->orderBy('create_time','desc')->Paginate(PAGE);
        }
      //  dd($data);
        return view('user.exchange_list',compact('user','data','page_path'));
    }
    /**
     * 银行卡管理
     */
    public function bindBank()
    {
        $user = $this->getUser();
        $bank_info = DB::table('user_bank')->select('id','data','add_time')->where('user_id',$user['id'])->get();
        foreach ($bank_info as $k=>$v){
            $bank_info[$k] = json_decode($v->data,true);
            $bank_info[$k]['id'] = $v->id;
            $bank_info[$k]['add_time'] = $v->add_time;
        }
        return view('user.bank',compact('user','bank_info'));
    }

    /**
     * 银行卡管理
     */
    public function bindBankAdd()
    {
        $user = $this->getUser();
        if(Input::method()=='GET'){
            $url = Input::url();
            return view('user.check_answer',compact('user','url'));
        }elseif (Input::method()=='POST'){
            if(Input::get('answer')===null){
                $data['name'] = $user['rel_name'];
                $data['bankNo'] = Input::get('bankNo');
                $data['bank_name'] = Input::get('bank_name');
                $data['sheng'] = Input::get('selectp');
                $data['city'] = Input::get('selectc');
                $data = json_encode($data,JSON_UNESCAPED_UNICODE);
                $msg = DB::table('user_bank')->insert(['data'=>$data,'add_time'=>time(),'user_id'=>$user['id']]);
                if($msg){
                    return redirect('/user/bindBank');
                }else{
                    return back()->with('msg','系统开小差了，请稍后重试');
                }
            };
        }
        return view('user.bindBankCard',compact('user'));
    }
    /**
     * 实名认证
     */
    public function IDCard()
    {
        $user = $this->getUser();
        if(Input::method()=='POST'){
            $realName = Input::get('realName');
            $ID = Input::get('ID');
            $RID = Input::get('RID');
            if($ID!=$RID){
                return back()->with('msg','两次输入的身份证不一致');
            }else{
                $msg = User::where('id',$user['id'])->update(['rel_name'=>$realName,'datecard'=>$ID,'is_check_datecard'=>'0']);
                if($msg){
                    Cache::forget('user_info_'.$user['id']);
                    return back()->with('msg','提交成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }
        }
        return view('user.IDCard',compact('user'));
    }
    /**
     *  验证密保问题
     */
    public function check_answer()
    {
        $user = $this->getUser();
        $answer = Input::get('answer');
        $question = $user['question'];
        if($answer==''){
            return $data = [
                'status'=>'-1',
                'info' =>'请输入答案'
            ];
        }
        if($question==''){
            return $data = [
                'status'=>'-2',
                'info' =>'请先设置密保问题'
            ];
        }
        if($user['answer']==$answer){
            return $data = [
                'status'=>'1',
                'info' =>'y'
            ];
        }else{
            return $data = [
                'status'=>'-3',
                'info' =>'密保答案错误'
            ];
        }
    }
}
