<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Home\CommonController;
use App\Http\Model\ArticleModel;
use App\Http\Model\MailLog;
use App\Http\Model\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Mews\Captcha\Facades\Captcha;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use PhpSms;
use Toplan\Sms\Facades\SmsManager;
require_once app_path().'\org\code\Code.class.php';
class AuthController extends CommonController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins {
        AuthenticatesAndRegistersUsers::postLogin as laravelPostLogin;
    }
    protected $maxLoginAttempts = 5; //每分钟最大尝试登录次数
    protected $lockoutTime = 300;  //登录锁定时间
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';
    protected $username = 'login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return \Illuminate\Support\Facades\Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showLoginForm(Request $request){
        if (!empty($request->get('redirectUrl'))) { // 如果有跳转地址的话
            session(['url.intended' => $request->get('redirectUrl')]);
        }
        $ad = $this->getAdByPosition('7');
        return view("auth.login",compact('ad',$ad));
    }

    public function showRegistrationForm()
    {
        $ad = $this->getAdByPosition('6');
        $register_news = ArticleModel::where('id',30)->select('content')->first();
        return view("auth.register",compact('ad','register_news'));
    }

    // 增加方法
    protected function getCredentials(Request $request)
    {
        $login = $request->get('login');
       // $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }elseif (preg_match("/^1[34578]{1}\d{9}$/", $login)){
            $field = 'telphone';
        }else{
            $field = 'name';
        }
        return [
            $field => $login,
            'password' => $request->get('password'),
        ];
    }


    //验证码
    public function verify()
    {
        $verify = new \Code();
        $verify->height(49);
        $verify->background('#ffffff');
        $verify->make();
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 自定义注册
     */
    public function postRegister(Request $request)
    {
       // dd($request);
        $rules = [
            'name'=>'required|unique:users,name',
            'password' => 'required|between:6,20|confirmed',
            'email' =>'required|email|unique:users,email'
        ];
        $messages = [
            'required'=>':attribute不能为空',
            'name.unique'=>'用户名已被注册',
            'email.unique'=>'邮箱已被注册',
            'email.email'=>'邮箱地址错误',
            'password.between' => '密码必须是6~20位之间',
            'password.confirmed' => '密码和确认密码不匹配',

        ];
        $username = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $data = $request->all();
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);
        $last_ip = $request->getClientIp();
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
        $user = new User();
        $user->email = $email;
        $user->name = $username;
        $user->password = bcrypt($password);
        $user->last_login = time();
        $user->last_ip = $last_ip;
        $user->reg_time = time();

        if($user->save()){
            return redirect('auth/register_success?m='.$this->newbase64_en($email).'&n='.$this->newbase64_en($username));
        }else{
            return back()->with('msg','系统开小差了，请稍后重试');
        }
        //User::create($data); //插入一条新纪录，并返回保存后的模型实例
        //如果注册后还想立即登录的话，可以使用$user = User::create($data); Auth::login($user); 进行认证

    }

    public function register_success(Request $request)
    {
        if($request->Method()=='GET'){
            if(filter_var(Input::get('m'), FILTER_VALIDATE_EMAIL)){
                $name = $this->newbase64_en(Input::get('n'));
            }
            $ad = $this->getAdByPosition('6');
            return view("auth.register_success",compact('ad','email','name'));
        }elseif ($request->Method()=='POST'){
            return view("auth.register_active_success");
        }
    }
    /**
     *  发送激活邮件
     */
    public function send_email()
    {
        if(isset(request()->m1) && isset(request()->n1)){
            $mail = request()->m1;
            $name = request()->n1;
            $data['email'] = request()->m1;
            $data['name'] = request()->n1;
        }else{
            $mail = Input::get('m');
            $name = Input::get('n');
            $data['email'] = $this->newbase64_de(Input::get('m'));
            $data['name'] = $this->newbase64_de(Input::get('n'));
        }
        $data['activationcode'] = md5($mail.time());  //获取邮箱验证时的随机串
        if(Input::get('c')!==null){         //更换邮箱激活
            User::where('name',$data['name'])->update(['email'=>$data['email']]);
        }
       if(Mail::send('activemail', $data, function($message) use($data,$mail)
       {
           $message->to($data['email'], $data['name'])->subject('欢迎注册，请激活您的账号！');
           $mail_log = new MailLog();
           $mail_log->email = $data['email'];
           $mail_log->activationcode = $data['activationcode'];
           $mail_log->create_time = time();
           if($mail_log->where('email', $data['email'])->first()){
               $mail_log->where('email', $data['email'])->update(['activationcode'=>$data['activationcode']]);
           }else{
               $mail_log->save();
           }
       })) {
           if(isset(request()->m1) && isset(request()->n1)){
               return $data=[
                   'status' => '1',
                   'info' =>'发送成功'
               ];
           }else{
               return redirect('auth/active_success?m='.$data['email'].'&n='.$data['name'].'&a='.$mail.'&s='.$name);
           }
       }else{
           if(isset(request()->m1) && isset(request()->n1)){
               return $data=[
                   'status' => '2',
                   'info' =>'发送失败了，请稍后重试'
               ];
           }else{
               return back()->with('msg','系统开小差了，请稍后重试');
           }
       }
    }
    /**
     *  发送重置密码邮件
     */
    public function send_reset_email()
    {
        $mail = Input::get('mail');
        if(!User::where('email',$mail)->select('id')->first()){
            return $data=[
                'status'=>'1',
                'info' =>'此邮箱未注册，请更换邮箱!'
            ];
            exit;
        }
        $data['email'] = $mail;
        $data['activationcode'] =rand('156000','999999');  //验证码
        $data['create_time'] = time();

        if(Mail::send('find_pass_mail', $data, function($message) use($data,$mail)
        {
            $message->to($data['email'], '')->subject('您的邮箱验证码！');
            $mail_log = new MailLog();
            $mail_log->email = $data['email'];
            $mail_log->activationcode =$data['activationcode'];
            $mail_log->create_time =$data['create_time'];
            if($mail_log->where('email', $data['email'])->first()){
                $mail_log->where('email', $data['email'])->update(['activationcode'=>$data['activationcode'],'create_time'=>$data['create_time']]);
            }else{
                $mail_log->save();
            }
        })){
            return $data=[
                'status' => '2',
                'info' =>'发送成功'
            ];
        }else{
            return $data=[
                'status' => '3',
                'info' =>'发送失败了，请稍后重试'
            ];
        }
    }
    /**
     * 邮箱验证码验证
     */
    public function check_email_code()
    {
        $yzm = intval(Input::get('yzm'));
        $email = Input::get('email');
        $code = MailLog::where('email',$email)->select('activationcode','create_time')->first();
        if($code['activationcode']==$yzm){
            if(strtotime('-30minutes ')>$code['create_time']){
                return back()->with('msg','验证码过期，请重新获取');
            }else{
                MailLog::where('email',$email)->delete();
                return redirect('password/reset/'.csrf_token());
            }
        }else{
            return back()->with('msg','验证码错误');
        }
    }
    
    /**
     * 处理激活事件
     */
    public function activation()
    {
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        $email = preg_match($pattern, Input::get('m'))?Input::get('m'):'';
        $activationcode = Input::get('code');
        $mail_log = new MailLog();
        if($mail_log = $mail_log->where('email', $email)->where('activationcode',$activationcode)->first()){
            if(strtotime("+1 day",$mail_log['create_time'])<time()){
                return '激活邮件过期，请重新获取';
            }
            $mail_log->where('email', $email)->delete();
            User::where('email', $email)->update(['is_check_email'=>'1']);
            return redirect('auth/active_success_info');
        }else{
            return '参数不正确';
        }
    }
    /**
     *
     */
    public function active_success()
    {
        return view("auth.register_active_success");
    }

    /**
     *
     */
    public function active_success_info()
    {
        return view("auth.active_success_info");
    }
    
    
    /**
     *  短信激活,验证
     */
    public function send_phone_code()
    {

        $validator =\Illuminate\Support\Facades\Validator::make(Input::all(), [
            'phone'     => 'required|confirm_mobile_not_change',
        ]);
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $data=[
                'status'=>'n',
                'info' => trans('com.change_phone')
            ];
        }else{
            $email = $this->newbase64_de(Input::get('m'));
            $name = $this->newbase64_de(Input::get('n'));
            $msg = User::where('email', $email)->where('name',$name)->update(['is_check_phone'=>'1','telphone'=>Input::get('phone')]);
            if($msg){
                return $data=[
                    'status'=>'y',
                    'info' => '激活成功，去登录吧'
                ];
            }else{
                return $data=[
                    'status'=>'n',
                    'info' => '系统错误，请稍后重试'
                ];
            }
        }
    }
}
