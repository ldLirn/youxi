<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\GoodsGame;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Class TrashController
 * @package App\Http\Controllers\Admin
 * 回收站
 */
class TrashController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.game',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.game', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.game', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.game', ['only' => ['destroy']]);
    }

    //
    public function index()
    {
        $where = Input::get('type')?Input::get('type'):'0';
        $data_all = (new GoodsGame())->where('traded_type',$where)->where('is_trash','1')->Paginate(PAGE);  //为了使用分页
        $data = (new GoodsGame())->with('game','DaQu','hasManyType','XiaQu','user')->where('traded_type',$where)->where('is_trash','1')->Paginate(PAGE)->toArray();  //得到所有数据
       // dd($data);
        return view('admin.game.goods_trash',compact('data','data_all'));
    }


    public function destroy($id)
    {
        try {
             DB::transaction(function() use ($id){
                DB::table('goods_game')->where('id',$id)->update(array('is_trash'=>'-1'));
                DB::table('collection')->where('goods_id',$id)->delete();
                DB::table('cut_price')->where('goods_id',$id)->delete();
            });
            Log::info(session('users.admin_name').'删除游戏商品ID='.$id);
            Cache::forget('goods_detail_'.$id);
            $data = [
                'status' => 0,
                'info' => '商品删除成功！',
            ];
           return $data;
        } catch(Exception $e) {
            $data = [
                'status' => 1,
                'info' => '删除失败，请稍后重试！',
            ];
            return $data;
        }
    }


    //恢复
    public function store()
    {
        $id=intval(Input::get('id'));
        $status = GoodsGame::where('id',$id)->update(array('is_trash'=>'0'));
        if($status){
            Cache::forget('goods_detail_'.$id);
            $data = [
                'status' => 0,
                'info' => '还原成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '系统错误，请稍后重试！',
            ];
        }
        return $data;
    }


    //批量操作
    public function all_do()
    {
        $type = Input::except('_token');
        switch (intval($type['all_do'])){
            case '1':
                try {
                    DB::transaction(function() use ($type){
                        DB::table('goods_game')->whereIn('id',$type['id'])->update(array('is_trash'=>'-1'));
                        DB::table('collection')->whereIn('goods_id',$type['id'])->delete();
                        DB::table('cut_price')->whereIn('goods_id',$type['id'])->delete();
                    });
                    foreach($type['id'] as $v){
                        Cache::forget('goods_detail_'.$v);
                    }
                    return redirect('admin/trash')->with('msg','删除成功');
                } catch(Exception $e) {
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
            case '2':
                $status = GoodsGame::whereIn('id',$type['id'])->update(array('is_trash'=>'0'));
                if($status){
                    foreach($type['id'] as $v){
                        Cache::forget('goods_detail_'.$v);
                    }
                    return redirect('admin/trash')->with('msg','所选恢复成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
        }
    }


    public function search(){
        $keywords = Input::get('keywords');

//        $goodsShow = GoodsGame::where('cate_id','=',$cate_id)
//            ->where(function($query){
//                $query->where('status','<','61')
//                    ->orWhere(function($query){
//                        $query->where('status', '91');
//                    });
//            })->first();
//
        $data_all = GoodsGame::where('is_trash','1')->where('goods_name','like','%'.$keywords.'%')->whereOr('goods_code',$keywords)->where('is_trash','1')->Paginate(PAGE);
        $data = (new GoodsGame())->with('game','DaQu','hasManyType','XiaQu','user')->where('is_trash','1')->where('goods_name','like','%'.$keywords.'%')->orwhere('goods_code',$keywords)->Paginate(PAGE)->toArray();  //得到所有数据
      //  dd($data);
        return view('admin.game.trash_search',compact('data','data_all'));

    }
    
    public function show()
    {

    }
}
