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
 * Class ExchangeController
 * @package App\Http\Controllers\Admin
 * 积分商城
 */
class ExchangeController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.exchange',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.exchange', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.exchange', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.exchange', ['only' => ['destroy']]);
    }

    //积分商品
    public function index(){
        $data = Exchange::Paginate(15);
        return view('admin.exchange.list',compact('data'));
    }

    //添加页面
    public function create(){
        return view('admin.exchange.add');
    }
    //添加操作
    public function store(Requests\ExchangeCreateRequest $request)
    {
            $input = $request->except('_token');
            $status = Exchange::create($input);
            if($status){
                Log::info(session('users.admin_name').'添加积分商品'.$input['goods_name']);
                return redirect('admin/exchange');
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
    public function update(Requests\ExchangeCreateRequest $request,$id){
            $input = $request->except('_token','_method');
            $status = Exchange::where('id',$id)->update($input);
            if($status){
                Log::info(session('users.admin_name').'修改积分商品'.$input['goods_name']);
                Cache::forget('exchange_info_'.$id);
                return redirect('admin/exchange');
            }else{
                return back()->with('msg','积分商品更新失败，请稍后重试！');
            }
    }

    //修改页面
    public function edit($id){
        $data = Exchange::find($id);
        return view('admin.exchange.edit',compact('data'));
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
