<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\AdPositionModel;

use App\Http\Model\Exchange;
use App\Http\Model\ExchangeOrder;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

/**
 * Class ExchangeOrderController
 * @package App\Http\Controllers\Admin
 * 积分商城订单
 */
class ExchangeOrderController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.exchange_order',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.exchange_order', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.exchange_order', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.exchange_order', ['only' => ['destroy']]);
    }

    //积分商品
    public function index(){
        $data = ExchangeOrder::with('exchange')->Paginate(15);
        return view('admin.exchange.order_list',compact('data'));
    }

    //添加页面
    public function create(){
        return view('admin.exchange.order_add');
    }
    //添加操作
    public function store(Requests\ExchangeCreateRequest $request)
    {
            $input = $request->except('_token');
            $status = Exchange::create($input);
            if($status){
                Log::info(session('users.admin_name').'添加积分商品'.$input['goods_name']);
                return redirect('admin/exchange_order');
            }else{
                return back()->with('msg','积分商品新增失败，请稍后重试');
            }
    }
    
    //删除
    public function destroy($id){
        if(ExchangeOrder::where('goods_id',$id)->first()){
            return $data = [
                'status' => 1,
                'info' => '请先处理此商品的订单，再删除',
            ];
        }
        $status = Exchange::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除积分商品ID='.$id);
            return $data = [
                'status' => 0,
                'info' => '删除成功',
            ];
        }else{
            return $data = [
                'status' => 1,
                'info' =>trans('com.system.error'),
            ];
        }

    }
    //修改操作
    public function update($id){
            $input = Input::except('_token','_method');
            $status = ExchangeOrder::where('id',$id)->select('order_status','user_id','order_integral','order_code','goods_id')->first();
            if($input['act']==EXCHANGE_COMPLETE){
                $update['order_status'] = 2;
            }elseif ($input['act']==ORDER_CANCEL){
                $update['order_status'] = 3;
                $user['integral'] = $status['order_integral'];
            }else{
                return back()->with('msg', trans('com.not_allow_operation'));
            }
            $update['action_user_name'] = session('users.admin_name');
            $update['note'] = $input['note'];
            $update['note_time'] = time();
            $user = isset($user)?$user:null;
            try {
                DB::transaction(function () use($id,$input,$update,$status,$user){
                    DB::table('exchange_order')->where('id',$id)->update($update);
                    if(isset($user)){  //如是取消，则退回积分
                        $account['user_id'] = $status['user_id'];
                        $account['integral'] = $user['integral'];
                        $account['change_time'] = time();
                        $account['change_desc'] = '订单'.$status['order_code'].' 取消退回积分';
                        $account['change_type'] ='99';
                        DB::table('account_log')->insert($account);
                        DB::table('users')->where('id',$status['user_id'])->increment('integral',$user['integral']);
                    }
                });
                Log::info(session('users.admin_name') . '修改订单ID='.$status['order_code'].'的状态');
                Cache::forget('user_info_'.$status['user_id']);
                Cache::forget('exchange_info_'.$status['goods_id']);
                return back()->with('msg', '修改成功');
            } catch (Exception $e) {
                return back()->with('msg', $e);
            }
    }

    //修改页面
    public function edit($id){
        $data = ExchangeOrder::with('exchange','user')->find($id);
        return view('admin.exchange.order_edit',compact('data'));
    }


    //搜索功能
    public function search(){
        $keywords = Input::get('keywords');
        $data = Exchange::where('goods_name','like','%'.$keywords.'%')->Paginate(15);
        return view('admin.exchange.list',compact('data'));
    }
    

    public function show(){

    }
}
