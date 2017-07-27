<?php

namespace App\Http\Controllers\Admin;


use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;


require_once app_path().'\org\code\Code.class.php';

/**
 * Class LoginController
 * @package App\Http\Controllers\Admin
 * 后台 登录
 */
class LoginController extends CommonController
{

    //登录界面
    public function login()
    {
        return view('admin.login');
    }
    
    //验证码
    public function verify()
    {
        $verify = new \Code();
        $verify->make();
    }

    //验证登录
    public function verify_login()
    {
        if($data = Input::all()){
            $verify = new \Code();
            $code = $verify->get();
            if(strtoupper($data['verify']) != $code){
                return back()->with('error','验证码错误！');
            }
            if($data['admin_name']==''){
                return back()->with('error','用户名不能为空！');
            }
            if($data['admin_pass']==''){
                return back()->with('error','密码不能为空！');
            }

            $have = User::where('name', $data['admin_name'])->first();

              if(!$have){
                return back()->with('error','用户不存在');
            }else{
                  if($have['is_admin']=='0'){
                      return back()->with('error','对不起，您无权登录');
                  }
                if($data['admin_name'] ==$have->name && decrypt($have->password) == $data['admin_pass']){
                    $data['admin_pass'] = '';
                    session(['users'=>$data]);
                    Cache::forget('menu');
                    Log::info($data['admin_name'].'登录');
                    return redirect('admin/index');
                }else{
                    return back()->with('error','用户名或密码错误');
                }
            }

        }else{
            return back()->with('error','非法请求！');
        }
    }

    //退出
    public function logout()
    {
        Log::info(session('users.admin_name').'退出登录');
        session(['users'=>null]);
        return redirect('admin/login');
    }
}
