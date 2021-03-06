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
 * Class AskController
 * @package App\Http\Controllers\Admin
 * 咨询
 */
class AskController extends CommonController
{
    
    public function __construct()
    {
        $this->middleware('checkpermission:list.ask',['only'=>['index','search','show']]);
        $this->middleware('checkpermission:create.ask', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.ask', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.ask', ['only' => ['destroy']]);
    }


    public function index()
    {
        $data = (new Ask)->data(1);
        $cate = trans('ask_category');
        $type = 1;
        $url = 'ask';
        return view('admin.ask.ask_list',compact('data','cate','type','url'));
    }

    public function create()
    {
        $cate = trans('ask_category');
        $url = 'ask';
        return view('admin.ask.ask_add',compact('cate','url'));
    }

    public function store(Requests\AskCreateRequest $request)
    {
        $input = $request->except('_token');
        $input['ask_time'] = time();
        $input['user_id'] = 0;
        return (new Ask)->add($input,'ask');
    }

    public function edit($id)
    {
        $data = Ask::findOrFail($id);
        $cate = trans('ask_category');
        $url = 'ask';
        return view('admin.ask.ask_edit',compact('cate','data','url'));
    }

    public function update(Requests\AskCreateRequest $request,$id)
    {
        $input = $request->except('_token','_method');
        return (new Ask())->MyUpdate($id,$input,'ask');
    }

    public function show($id)
    {
        $data = Ask::findOrFail($id);
        $cate = trans('ask_category');
        if(Input::method()=="POST"){
            $input['answer'] = Input::get('answer');
            $input['answer_user_name'] = session('users.admin_name');
            return (new Ask())->reply($id,$input,'ask',$data);
        }
        $url = 'ask';
        return view('admin.ask.ask_reply',compact('data','cate','url'));
    }

    public function search()
    {
        $cat_id = Input::get('cat_id');
        $keywords = Input::get('keywords');
        $data = (new Ask())->search(1,$cat_id,$keywords);
        $cate = trans('ask_category');
        $type = 1;
        $url = 'ask';
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
