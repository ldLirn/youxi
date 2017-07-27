<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Home\CommonController;
use App\Http\Model\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Toplan\Sms\Facades\SmsManager;


/**
 * Class PasswordController
 * @package App\Http\Controllers\Auth
 * 找回密码
 */
class PasswordController extends CommonController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function getEmail()
    {
        return $this->showLinkRequestForm();
    }

    public function getReset()
    {

    }

    /**
     * ResetPassword
     * 手机重置密码   POST
     */
    public function postReset()
    {
        //检查 手机号是否更换
        $validator =\Illuminate\Support\Facades\Validator::make(Input::all(), [
            'phone'     => 'required|confirm_mobile_not_change',
        ]);
        if ($validator->fails()) {
            SmsManager::forgetState();
            return back()->with('msg',trans('com.change_phone'));
        }else{
            $phone = Input::get('phone');
            session(['phone' => $phone]);
            return view('auth.passwords.reset');
        }
    }

    /**
     * 邮箱重置密码
     */
    public function check_email_user()
    {
        $validator =\Illuminate\Support\Facades\Validator::make(Input::all(), [
            'email'     => 'required|email',
        ]);
        if ($validator->fails()) {
            return back()->with('msg',trans('com.error_email'));
        }else{
            $email = Input::except('_token');
            if(!User::where('email',$email['email'])->where('name',$email['name'])->select('id')->first()){
                return back()->with('msg',trans('home.email_not_user'));
            }
            session('email',$email);
            return view('auth.passwords.reset');
        }
    }

    /**
     * 重置密码操作
     */
    public function ResetPassword()
    {
        $input = Input::all();
        if($input['password'] != $input['password_confirmation']){
            return $data = [
                'status' =>'n',
                'info'   =>trans('com.comfirm')
            ];
        }

        $phone = session('phone')?session('phone'):'';  //通过手机重置密码
        $email = session('email')?session('email'):'';  //通过邮箱重置密码
        $password = bcrypt($input['password']);
        if($phone){
            $msg = User::where('telphone',$phone)->update(['password'=>$password]);
            if($msg){
                Session::pull('phone','');
                return $data=[
                    'status'=>'y',
                    'info' => trans('home.reset_pass_succ')
                ];
            }else{
                return $data=[
                    'status'=>'n',
                    'info' =>trans('com.system_error')
                ];
            }
        }
        if($email){
            $msg = User::where('email',$email)->update(['password'=>$password]);
            if($msg){
                Session::pull('email','');
                return $data=[
                    'status'=>'y',
                    'info' => trans('home.reset_pass_succ')
                ];
            }else{
                return $data=[
                    'status'=>'n',
                    'info' =>trans('com.system_error')
                ];
            }
        }
    }

    
}
