<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Attribute;
use App\Http\Model\CateGame;
use App\Http\Model\Game;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/**
 * Class AttributeController
 * @package App\Http\Controllers\Admin
 * 游戏属性
 */
class AttributeController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.goodsattribute',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.goodsattribute', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.goodsattribute', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.goodsattribute', ['only' => ['destroy']]);
    }
    
    //列表页
    public function index()
    {
        $data=Attribute::with('game','game_type')->Paginate(15);
        return view('admin.game.attribute_list',compact('data'));
    }

    //添加页面

    public function create()
    {
        //获取所有游戏分类
        $CateGame = new CateGame();
        $CateGameDate = $CateGame->getCache();
        return view('admin.game.attribute_add',compact('CateGameDate'));
    }

    //修改页面

    public function edit($id)
    {
        //获取所有游戏分类
        $CateGame = new CateGame();
        $CateGameDate = $CateGame->getCache();
        $data=Attribute::find($id);
        $attr = $this->getQuData($data['data']);
        return view('admin.game.attribute_edit',compact('CateGameDate','data','attr'));
    }

    //添加操作
    public function store(Requests\AttributeCreateRequest $request)
    {
        $input = $request->except('_token','attr_name','attr_value','attr_field');
         $a = $this->removeNull($input['data']);
        $input['data'] = $a;
        $status = Attribute::create($input);
        if($status){
            return redirect('admin/attribute');
        }else{
            return back()->with('msg','添加失败，请稍后重试');
        }
    }

    //修改操作
    public function update(Requests\AttributeEditRequest $request,$id)
    {
        $input = $request->except('_token','_method','attr_name','attr_value');
        $check = Attribute::where('game_id',$input['game_id'])->where('game_goods_type_id',$input['game_goods_type_id'])->where('id','<>',$id)->first();
        if($check){
            return back()->with('msg','游戏属性已经存在!');
        }
        $a = $this->removeNull($input['data']);

        $input['data'] = $a;
       // dd($input);
        $status = Attribute::where('id',$id)->update($input);
        if($status){
            return redirect('admin/attribute');
        }else{
            return back()->with('msg','修改失败，请稍后重试');
        }
    }

    //删除
    public function destroy($id)
    {
        $status = Attribute::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除游戏属性ID='.$id);
            $data = [
                'status' => 0,
                'info' => '删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '删除失败，请稍后重试！',
            ];
        }
        return $data;
    }

    //搜索
    public function search()
    {
        $keywords = Input::get('keywords');
        $game_id = Game::where('game_name','like','%'.$keywords.'%')->lists('id')->toArray();
        $data = Attribute::whereIn('game_id',$game_id)->Paginate('15');
        return view('admin.game.attribute_search',compact('data'));
    }

    
    public function show()
    {
        
    }
}
