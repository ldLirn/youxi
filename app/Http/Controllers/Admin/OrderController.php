<?php

namespace App\Http\Controllers\Admin;

use App\Events\Event;
use App\Events\SendMessage;
use App\Http\Model\GameQu;
use App\Http\Model\GoodsGame;
use App\Http\Model\Order;
use App\Http\Model\Order_address;
use App\Http\Model\OrderAction;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Class OrderController
 * @package App\Http\Controllers\Admin
 * 订单
 */
class OrderController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.order',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.order', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.order', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.order', ['only' => ['destroy']]);
        $this->middleware('checkpermission:all.order', ['only' => ['all_do']]);
        $this->middleware('checkpermission:edit.user.info', ['only' => ['edit_user_info']]);
        $this->middleware('checkpermission:edit.money', ['only' => ['edit_money']]);
    }


    public function index()
    {
        $where = Input::get('type')?Input::get('type'):'0';     //判断选择的订单类型
        $data_all = Order::where('order_type',$where)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
        $data = Order::where('order_type',$where)->Paginate(PAGE)->toArray();
        foreach ($data['data'] as $k=>$v){
            $data['data'][$k]['user_name'] = $this->UserInfo($v['user_id']);
            $data['data'][$k]['goods_info'] = GoodsGame::where('id',$v['goods_id'])->with('game','DaQu','hasManyType','XiaQu','user')->first()->toArray();
            $this->UserInfo($v['user_id']);
        }
       // dd($data['data']);
        return view('admin.order.list',compact('data','data_all'));
    }

    public function create()
    {
        return view('admin.order.add');
    }

    public function store()
    {
        abort(404);
    }

    public function edit($id)
    {
        $data = Order::where('id',$id)->first()->toArray();
        $user_info = $this->GetUserInfo($data['user_id']);
        $order_address = Order_address::where('order_id',$id)->with('game_name','da_qu_name','xia_qu_name')->first()->toArray();
        $goods_info = GoodsGame::where('id',$data['goods_id'])->with('game','DaQu','hasManyType','XiaQu','user','game_user_info','game_cate')->first()->toArray();
        $order_action = OrderAction::where('order_id',$id)->get()->toArray();
       // dd($order_action);
        return view('admin.order.edit',compact('data','user_info','goods_info','order_address','order_action'));
    }

    public function update($id)
    {
        $input = Input::except('_token','_method');
        $status = Order::where('id',$id)->select('order_status','user_id','money_paid','order_sn','goods_id')->first();
        switch ($input['act']){
            case INVALID:
                if($input['pay_status']=='1' && ($status['order_status']=='0' || $status['order_status']=='1' || $status['order_status']=='2')){   //如果是已经支付的订单，则退回余额
                        $user['money'] = $status['money_paid'];
                }
                $update = array('order_status'=>'5','pay_status'=>'0');
                Event::fire(new SendMessage($status['user_id'],'user.order_cancel',$status['order_sn']));
                $insert['order_status'] = '5';
                break;
            case PAYMENT:
                $update = array('pay_status'=>'1');
                $insert['pay_status'] = '1';
                Event::fire(new SendMessage($status['user_id'],'user.order_payment',$status['order_sn']));
                break;
            case DELIVER:
                $update = array('order_status'=>'1');
                $insert['order_status'] = '1';
                $insert['pay_status'] = $input['pay_status'];
                Event::fire(new SendMessage($status['user_id'],'user.order_deliver',$status['order_sn']));
                break;
            case CONFIRM:
                $update = array('order_status'=>'2');
                $insert['order_status'] = '2';
                $insert['pay_status'] = $input['pay_status'];
                break;
            case COMPLETE:
                $update = array('order_status'=>'3');
                $insert['order_status'] = '3';
                $insert['pay_status'] = $input['pay_status'];
                $sell_user_id = GoodsGame::where('id',$status['goods_id'])->select('to_money','account','security','goods_code','user_id')->first();
                break;
            case UNPAID:
                if($input['pay_status']=='1' && ($status['order_status']=='0' || $status['order_status']=='1' || $status['order_status']=='2')){   //如果是已经支付的订单，则退回余额
                    $user['money'] = $status['money_paid'];
                }
                $update = array('pay_status'=>'0');
                $insert['pay_status'] = '0';
                break;
            case NOT_OPERATE:
                $update = array('order_status'=>'0');
                $insert['order_status'] = '0';
                break;
        }
        $insert['order_id'] = $id;
        $insert['action_user_name'] = session('users.admin_name');
        $insert['action_note'] = $input['action_note'];
        $insert['log_time'] = time();
        $user = isset($user)?$user:null;
        $sell_user_id = isset($sell_user_id)?$sell_user_id:null;
        try {
            DB::transaction(function () use($id,$input,$update,$insert,$user,$status,$sell_user_id){
                DB::table('order')->where('id',$id)->update($update);
                DB::table('order_action')->insert($insert);
                if(isset($user)){  //退回余额
                    $account['user_id'] = $status['user_id'];
                    $account['money'] = $user['money'];
                    $account['change_time'] = time();
                    $account['change_desc'] = '订单'.$status['order_sn'].' 退款';
                    $account['change_type'] ='2';
                    DB::table('account_log')->insert($account);
                    DB::table('users')->where('id',$status['user_id'])->increment('money',$user['money']);
                    Log::info(session('users.admin_name') . '订单='.$status['order_sn'].'退款:'.$user['money']);
                }
                if(isset($sell_user_id) && $sell_user_id){  //确认收货，交易完成，处理资金问题
                    $IntegralRatio = config('web.IntegralRatio');//获取积分比例
                    $integral = intval($status['money_paid']*$IntegralRatio);
                    DB::table('users')->where('id',$status['user_id'])->increment('integral',$integral);//添加积分
                    DB::table('users')->where('id',$status['user_id'])->increment('user_point_buy',intval($status['money_paid'])); //更新买家信用积分
                    DB::table('users')->where('id',$sell_user_id['user_id'])->increment('user_point_sell',intval($status['money_paid'])); //更新卖家信用积分
                    $buy_account['user_id'] = $status['user_id'];
                    $buy_account['integral'] = $integral;
                    $buy_account['user_point_buy'] = intval($status['money_paid']);
                    $buy_account['change_time'] = time();
                    $buy_account['change_desc'] = '购买订单'.$status['order_sn'].'获得积分';
                    $buy_account['change_type'] ='3';
                    DB::table('account_log')->insert($buy_account);  //记录买家积分增加
                    $sell_account['user_id'] = $sell_user_id['user_id'];
                    $sell_account['user_point_sell'] = intval($status['money_paid']);
                    $sell_account['change_time'] = time();
                    $sell_account['change_desc'] = '出售订单'.$status['order_sn'].'获得积分';
                    $sell_account['change_type'] ='4';
                    DB::table('account_log')->insert($sell_account);  //记录卖家积分增加
                    if($sell_user_id['to_money']==1){    //提现到银行卡,自动为卖家申请提现到银行操作，
                            /**
                             * 1.把订单付款金额，添加进用户表冻结资金
                             * 2.写入用户资金明细表
                             * 3.写用户提现申请
                             * $order,订单信息
                             */
                            DB::table('users')->where('id',$sell_user_id['user_id'])->increment('frozen_money',$status['money_paid']);
                            $accoun['user_id'] = $sell_user_id['user_id'];
                            $accoun['frozen_money'] = $status['money_paid'];
                            $accoun['change_time'] = time();
                            $accoun['change_desc'] = '订单'.$status['order_sn'].'出售，所得收益（到账银行卡）';
                            $accoun['change_type'] ='4';
                            $accou['user_id'] = $sell_user_id['user_id'];
                            $accou['frozen_money'] = $status['money_paid'];
                            $accou['change_time'] = time();
                            $accou['change_desc'] = '商品成功出售，订单'.$status['order_sn'].'收益转账到银行卡';
                            $accou['change_type'] ='1';
                            $account =array('0'=>$accoun,'1'=>$accou);
                            DB::table('account_log')->insert($account);
                            $user_account['user_id'] =  $sell_user_id['user_id'];
                            $user_account['amount'] =  $status['money_paid'];
                            $user_account['created_at'] = date('Y-m-d H:i:s',time());
                            $user_account['updated_at'] = $user_account['created_at'];
                            $user_account['user_note'] = $sell_user_id['account'];
                            $user_account['process_type'] = '1';
                            DB::table('user_account')->insert($user_account);
                    }else{        //出售金额到余额，（如有有资金延迟到账，未做）
                            DB::table('users')->where('id',$sell_user_id['user_id'])->increment('money',$status['money_paid']);
                            $accoun['user_id'] = $sell_user_id['user_id'];
                            $accoun['money'] = $status['money_paid'];
                            $accoun['change_time'] = time();
                            $accoun['change_desc'] = '订单'.$status['order_sn'].'出售，所得收益';
                            $accoun['change_type'] ='4';
                            DB::table('account_log')->insert($accoun);
                    }
                }
            });
            Log::info(session('users.admin_name') . '修改订单ID='.$id.'的状态');
            Cache::forget('user_info_'.$sell_user_id['user_id']);
            Cache::forget('user_info_'.$status['user_id']);
            Cache::forget('goods_detail_'.$status['goods_id']);
            return back()->with('msg', '修改成功');
        } catch (Exception $e) {
            return back()->with('msg', $e);
        }
    }

    public function destroy($id)
    {
      try {
        DB::transaction(function () use($id){
            DB::table('order')->where('id',$id)->delete();
            DB::table('order_action')->where('order_id',$id)->delete();
        });
        Log::info(session('users.admin_name') . '删除用户订单ID='.$id);
          $data = [
              'status' => 0,
              'info' => '删除成功！',
          ];
          return $data;
        } catch (Exception $e) {
          $data = [
              'status' => 1,
              'info' => $e,
          ];
          return $data;
        }
    }

    public function show()
    {
        
    }


    public function all_do()
    {
        
    }

    /**
     * 修改收货信息
     */
    public function edit_user_info_view()
    {
            $user_id = intval(Input::get('user_id'));
            $order_id = intval(Input::get('order_id'));
            $order_address = Order_address::where('user_id',$user_id)->where('order_id',$order_id)->first();
            $quData = (new GameQu())->GameDaQu($order_address['game_id']);
            $xquData = (new GameQu())->GameQu($order_address['da_qu_id']);
            if($order_address){
                return view('admin.order.edit_user_address',compact('order_address','quData','xquData'));
            }else{
                return back()->with('msg', '参数错误');
            }
    }

    public function edit_user_info(Requests\EditUserAddressRequest $request)
    {
            $id = $request->get('id');
            $order_id = $request->get('order_id');
            $input = $request->except('_token','id','order_id');
            $status = Order_address::where('id',$id)->update($input);
            if($status){
                Log::info(session('users.admin_name').'修改订单ID='.$order_id.'的买家收货信息');
                return redirect('admin/order/'.$order_id.'/edit');
            }else{
                return back()->with('msg','修改失败，请稍后重试');
            }
    }

    public function edit_money()
    {
        if(Input::method()=='GET'){
            $order_id = intval(Input::get('order_id'));
            $data = Order::where('id',$order_id)->first();
            if($data){
                return view('admin.order.edit_money',compact('data'));
            }else{
                return back()->with('msg','参数错误');
            }
        }elseif (Input::method()=='POST'){
            $order_id = Input::get('order_id');
            $order_amount = is_numeric(Input::get('order_amount'))?Input::get('order_amount'):'-1';
            if($order_amount>=0){
                $status = Order::where('id',$order_id)->update(array('order_amount'=>$order_amount));
                if($status){
                    Log::info(session('users.admin_name').'修改订单ID='.$order_id.'的订单金额');
                    return redirect('admin/order/'.$order_id.'/edit');
                }else{
                    return back()->with('msg','修改失败，请稍后重试');
                }
            }else{
                return back()->with('msg','金额错误');
            }
        }
    }
    
    public function search()
    {

        if(Input::method()=='GET'){
            $type = Input::get('type');
            $where = Input::get('pay_status');
            if(Input::get('user_name')!==null){
                $data_all = Order::where('order_type',$type)->where('user_id',Input::get('user_name'))->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$type)->where('user_id',Input::get('user_name'))->Paginate(PAGE)->toArray();
            }elseif($where!=''){
                $data_all = Order::where('order_type',$type)->where('pay_status',$where)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$type)->where('pay_status',$where)->Paginate(PAGE)->toArray();
            }else{
                $input = Input::except('_token');
                $order_sn = $input['order_sn'];
                $user_name = $input['user_name'];
                $order_status = $input['order_status'];
                if($input['order_sn']!='' && $input['user_name']=='' && $input['order_status']==''){
                    $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->Paginate(PAGE)->toArray();
                }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']==''){
                    $user_id = $this->UserId($input['user_name']);
                    $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->Paginate(PAGE)->toArray();
                }elseif($input['order_sn']!='' && $input['user_name']=='' && $input['order_status']!=''){
                    $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
                }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']==''){
                    $user_id = $this->UserId($input['user_name']);
                    $data_all = Order::where('order_type',$input['type'])->where('user_id',$user_id)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('user_id',$user_id)->Paginate(PAGE)->toArray();
                }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']!=''){
                    $user_id = $this->UserId($input['user_name']);
                    $data_all = Order::where('order_type',$input['type'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
                }elseif ($input['order_sn']=='' && $input['user_name']=='' && $input['order_status']!=''){
                    $data_all = Order::where('order_type',$input['type'])->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
                }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']!=''){
                    $user_id = $this->UserId($input['user_name']);
                    $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                    $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
                }
            }

        }elseif (Input::method()=='POST'){
            $input = Input::except('_token');
            $order_sn = $input['order_sn'];
            $user_name = $input['user_name'];
            $order_status = $input['order_status'];
            if($input['order_sn']!='' && $input['user_name']=='' && $input['order_status']==''){
                $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->Paginate(PAGE)->toArray();
            }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']==''){
                $user_id = $this->UserId($input['user_name']);
                $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->Paginate(PAGE)->toArray();
            }elseif($input['order_sn']!='' && $input['user_name']=='' && $input['order_status']!=''){
                $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
            }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']==''){
                $user_id = $this->UserId($input['user_name']);
                $data_all = Order::where('order_type',$input['type'])->where('user_id',$user_id)->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('user_id',$user_id)->Paginate(PAGE)->toArray();
            }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']!=''){
                $user_id = $this->UserId($input['user_name']);
                $data_all = Order::where('order_type',$input['type'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
            }elseif ($input['order_sn']=='' && $input['user_name']=='' && $input['order_status']!=''){
                $data_all = Order::where('order_type',$input['type'])->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
            }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']!=''){
                $user_id = $this->UserId($input['user_name']);
                $data_all = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->select('id')->Paginate(PAGE);    //写这条只是为了使用分页
                $data = Order::where('order_type',$input['type'])->where('order_sn',$input['order_sn'])->where('user_id',$user_id)->where('order_status',$input['order_status'])->Paginate(PAGE)->toArray();
            }
        }
        foreach ($data['data'] as $k=>$v){
            $data['data'][$k]['user_name'] = $this->UserInfo($v['user_id']);
            $data['data'][$k]['goods_info'] = GoodsGame::where('id',$v['goods_id'])->with('game','DaQu','hasManyType','XiaQu','user')->first()->toArray();
            $this->UserInfo($v['user_id']);
        }
        return view('admin.order.list',compact('data','data_all','where','order_sn','user_name','order_status'));
    }



}
