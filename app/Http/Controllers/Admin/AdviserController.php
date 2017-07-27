<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Account;
use App\Http\Model\Ask;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Class AdviserController
 * @package App\Http\Controllers\Admin
 * 建议
 */
class AdviserController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.advise',['only'=>['index','search','show']]);
        $this->middleware('checkpermission:create.advise', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.advise', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.advise', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = (new Ask)->data(2);
        $cate = trans('ask_category');
        $type = 2;
        $url = 'advise';
        return view('admin.ask.ask_list',compact('data','cate','type','url'));
    }

    public function create()
    {
        $cate = trans('ask_category');
        $url = 'advise';
        return view('admin.ask.ask_add',compact('cate','url'));
    }

    public function store(Requests\AskCreateRequest $request)
    {
        $input = $request->except('_token');
        $input['ask_time'] = time();
        $input['user_id'] = 0;
        return (new Ask)->add($input,'advise');
    }

    public function edit($id)
    {
        $data = Ask::findOrFail($id);
        $cate = trans('ask_category');
        $url = 'advise';
        return view('admin.ask.ask_edit',compact('cate','data','url'));
    }

    public function update(Requests\AskCreateRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        return (new Ask())->MyUpdate($id,$input,'advise');
    }

    public function show($id)
    {
        $data = Ask::findOrFail($id);
        $cate = trans('ask_category');
        if(Input::method()=="POST"){
            $input['answer'] = Input::get('answer');
            $input['answer_user_name'] = session('users.admin_name');
            return (new Ask())->reply($id,$input,'advise',$data);
        }
        $url = 'advise';
        return view('admin.ask.ask_reply',compact('data','cate','url'));
    }

    public function search()
    {
        $cat_id = Input::get('cat_id');
        $keywords = Input::get('keywords');
        $data = (new Ask())->search(2,$cat_id,$keywords);
        $cate = trans('ask_category');
        $type = 2;
        $url = 'advise';
        return view('admin.ask.ask_list',compact('data','cate','type','url'));
    }

    //删除
    public function destroy($id){
       return (new Ask())->del($id);
    }


    //批量删除
    public function deleteAll()
    {
        $input = Input::except('_token');
        return (new Ask())->delAll($input);
    }
}
