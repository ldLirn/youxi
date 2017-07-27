<?php

namespace App\Http\Controllers\Home;

use App\Events\SendMessage;
use App\Http\Controllers\Admin\DKApiController;
use App\Http\Controllers\Controller;

use App\Http\Model\Banner;
use App\Http\Model\DkGame;
use App\Http\Model\DkGameFaceValue;
use App\Http\Model\DkOrderModel;
use App\Http\Model\Game;
use App\Http\Model\GoodsGame;
use App\Http\Model\User;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Toplan\FilterManager\Facades\FilterManager;
use Toplan\Sms\Facades\SmsManager;
use Vinkla\Hashids\Facades\Hashids;


/**
 * Class DkController
 * @package App\Http\Controllers\Home
 * 点卡商城
 */
class DkController extends CommonController
{

    /**
     * Create a new controller instance.
     * @return void
     *
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
        $str = Letter;
        $data = $this->getDkGameByFirst();  //取得所有显示的点卡游戏列表
        $rand = $this->dk_recommend();
        $hot = $this->dk_hot();
        return view('home.dk_shop',compact('data','str','rand','hot'));
    }

    public function dk_order()
    {
        if(Auth::check() == false){
            return redirect('/login?redirectUrl='.url()->full());
        }
        $user = $this->getUser();
        $cz_gameid = Input::get('cz_gameid');
        $cz_dktype = Input::get('cz_dktype');
        $data = DkGameFaceValue::where('cardid',$cz_dktype)->first()->toArray();
        $data['accountdesc'] = unserialize($data['accountdesc']);
        if(Input::method()=='POST'){
            $input = Input::all();
            $rules = [
                'game_userid'=>'required',
                'Regame_userid'=>'required|same:game_userid',
                'telphone'=>'required|regex:/^1[34578]\d{9}$/|confirm_mobile_not_change',
                'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
                'cardnum'=>'required|numeric',
                'verifyCode'=>'required|verify_code',
            ];
            $messages = [
                'game_userid.required'=>trans('com.no_game_user_name'),
                'Regame_userid.required'=>trans('com.no_game_user_name'),
                'Regame_userid.same'=>trans('com.not_same_game_user_name'),
                'telphone.required'=>trans('com.no_phone'),
                'telphone.regex'=>trans('com.error_phone'),
                'telphone.confirm_mobile_not_change'=>trans('com.change_phone_and_code'),
                'qq.required'=>trans('com.no_qq'),
                'qq.regex'=>trans('com.error_qq'),
                'goods_price.regex'=>trans('com.error_goods_price'),
                'cardnum.required'=>trans('com.no_buy_number'),
                'cardnum.numeric'=>trans('com.error_buy_number'),
                'verifyCode.required'=>trans('com.no_code'),
                'verifyCode.verify_code'=>trans('com.error_code'),
            ];
            $validator = Validator::make($input,$rules,$messages);
            if($validator->fails()){
                SmsManager::forgetState();//验证失败后建议清空存储的发送状态，防止用户重复试错
                return $data=[
                    'status'=>'n',
                    'info' => json_encode($validator->messages()->first(),JSON_UNESCAPED_UNICODE)
                ];
            }else{
                if($user['money']<$input['TotalMoney']){
                    return $data=[
                        'status'=>'n',
                        'info' => '用户余额不足，请充值余额'
                    ];
                }
                //支付密码
                if (!Hash::check(Input::get('pay_password'), $user['pay_password'])){
                    return $data=[
                        'status'=>'n',
                        'info' => '支付密码错误'
                    ];
                }
                $sendOrder = ((new DKApiController())->sendOrder($data['cardid'],$input['cardnum'],$input['game_userid']));
                $insert['cardid'] = $sendOrder['cardid'];
                $insert['cardnum'] = $sendOrder['cardnum'];
                $insert['ordercash'] = $sendOrder['ordercash'];
                $insert['cardname'] = $sendOrder['cardname'];
                $insert['sporder_id'] = $sendOrder['sporder_id'];
                $insert['game_userid'] = $sendOrder['game_userid'];
                $insert['game_area'] = serialize($sendOrder['game_area']);
                $insert['game_srv'] = serialize($sendOrder['game_srv']);
                $insert['game_state'] = $sendOrder['game_state'];
                $insert['user_id'] = $user['id'];
                $insert['telphone'] = $input['telphone'];
                $insert['qq'] = $input['qq'];
                $insert['time'] = time();

                if($sendOrder['game_state']==1 || $sendOrder['game_state']==0){   //如果成功为1，澈消(充值失败)为9，充值中为0,只能当状态为9时，商户才可以退款给用户。
                    $insert['pay_status'] = 2;
                    $insert['order_status'] = 1;
                    try {
                        DB::transaction(function () use($user,$insert){
                            DB::table('dk_order')->insert($insert);  //写入点卡订单
                            DB::table('users')->where('id',$user['id'])->decrement('money', $insert['ordercash']);  //减去用户表中支付的钱
                            $account['user_id'] = $user['id'];
                            $account['money'] = -$insert['ordercash'];   //这里只记录用户余额变化，积分之类的确认收获后改变
                            $account['change_time'] = time();
                            $account['change_desc'] = '支付点卡订单'.$insert['sporder_id'];
                            $account['change_type'] = '99';
                            DB::table('account_log')->insert($account);         //写入账目记录
                        });
                        Event::fire(new SendMessage($user['id'],'user.order_payment',$insert['sporder_id'],'','',''));
                        Cache::forget('user_info_'.$user['id']);
                        return $data=[
                            'status'=>'y',
                            'info' => '充值成功'
                        ];
                    } catch (\Exception $e) {
                        return $data=[
                            'status'=>'n',
                            'info' => '未知错误'
                        ];
                    }

                }elseif($sendOrder['game_state']==9){
                    $insert['pay_status'] = 1;
                    if(DB::table('dk_order')->insert($insert)){  //写入点卡订单
                        return $data=[
                            'status'=>'n',
                            'info' => '充值失败'
                        ];
                    } else{
                        return $data=[
                            'status'=>'n',
                            'info' => '未知错误'
                        ];
                    }
                }
            }
        }
       // dd(mb_convert_encoding($data['caption'],"gbk","utf-8"));
        $amounts = explode(',',$data['amounts']);
        $qu = (new DKApiController())->getGameQu($cz_dktype);
       foreach($amounts as $k=>$v){
           if(strstr($v,'-')){
               $amounts[$k]=explode('-',$v);
           }
       }
        foreach($amounts as $k=>$v){
            if(is_array($v)){
                $amounts_arr = range($v[0],$v[1]);
            }else{
                $amounts_arr[] = $v;
            }
        }
        return view('home.dk_order',compact('data','amounts_arr','user','qu'));
    }


    /**
     * 商品详情
     *
     */
    public function goods($id)
    {
        $id = $this->getId($id);
        $data = GoodsGame::with('DaQu', 'XiaQu','game', 'game_user_info', 'hasManyType','goods_pic')->where('id', $id)->where('is_trash', '0')->select()->first()->toArray();
       // dd($data);
        return view('home.goods',compact('data'));
    }
    
    
    /**
     * 加入收藏
     */
    public function add_Collection()
    {
        if(Auth::check() == false){
            return $data =[
                'status' =>'30',
                'info' =>'请您先登录！'
            ];
        }
        $user_id = Auth::user()->id;
        $goods_id = intval(Input::get('goods_id'));
        $has = DB::table('collection')->where('user_id',$user_id)->where('goods_id',$goods_id)->first();
        if($has){
            return $data =[
                'status' =>'40',
                'info' =>'您已经收藏过此商品了！'
            ];
        }
        $status = DB::table('collection')->insert(['user_id'=>$user_id,'goods_id'=>$goods_id]);
        if($status){
            return $data =[
                'status' =>'1',
                'info' =>'加入收藏成功！'
            ];
        }else{
            return $data =[
                'status' =>'2',
                'info' =>'系统错误，请稍后重试！'
            ];
        }
    }
    
    
    /**
     * 购买页面
     */
    public function buy()
    {
        return view('home.buy');
    }
    
    /**
     * need   求购
     */
    public function need()
    {
        return view('home.need');
    }
    
    /**
     * category_zh  帐号交易
     */
    public function category_zh()
    {
        return view('home.category_zh');
    }

    /**
     * 点卡商城首页展示
     * 推荐
     */
    public function dk_recommend()
    {
        if(!Cache::has('rand_12')){
            $data = DkGameFaceValue::select('id','pid','cardid','innum','cardname','memberprice','thumb')->where('is_on_sale',1)->where('is_recommend','2')->limit(12)->get();
            Cache::forever('rand_12',$data);
        }
        $data = Cache::get('rand_12');
        return $data;
    }

    /**
     * 热销
     */
    public function dk_hot()
    {
        if(!Cache::has('dk_hot')){
            $data = DkGameFaceValue::select('id','pid','cardid','innum','cardname','memberprice','thumb','pervalue')->where('is_on_sale',1)->where('is_hot','2')->limit(5)->get();
            Cache::forever('dk_hot',$data);
        }
        $data = Cache::get('dk_hot');
        return $data;
    }

}
