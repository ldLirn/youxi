<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\UserRank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

/**
 * Class UserRankController
 * @package App\Http\Controllers\Admin
 * 用户等级
 */
class UserRankController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.user_account',['only'=>['index','search']]);
        $this->middleware('checkpermission:edit.user_account', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.user_account', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = UserRank::orderBy('min_points','asc')->Paginate(PAGE);
        return view('admin.user.user_rank.list',compact('data'));
    }

    public function create()
    {
        return view('admin.user.user_rank.add');
    }

    public function store(Requests\UserRankCreateRequest $request)
    {
        $input = $request->except('_token');
        $status = UserRank::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加会员等级'.$input['rank_name']);
            return redirect('admin/user_rank');
        }else{
            return back()->with('msg','添加失败，请稍后重试！');
        }
    }

    public function edit($id)
    {
        $data = UserRank::find($id);
        return view('admin.user.user_rank.edit',compact('data'));
    }

    public function update(Requests\UserRankEditRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        $status = UserRank::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改会员等级'.$input['rank_name']);
            return redirect('admin/user_rank')->with('msg','更新成功');
        }else{
            return back()->with('msg','更新失败，请稍后重试！');
        }
    }

    public function destroy($id)
    {
        $status = UserRank::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除会员等级ID='.$id);
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





    public function show()
    {
        
    }

}
