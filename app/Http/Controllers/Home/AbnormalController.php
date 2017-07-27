<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Http\Model\Banner;
use App\Http\Model\Game;
use App\Http\Model\GoodsGame;
use App\Http\Model\User;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Toplan\FilterManager\Facades\FilterManager;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Class AbnormalController
 * @package App\Http\Controllers\Home
 * 异常申请
 */
class AbnormalController extends CommonController
{

    /**
     * Create a new controller instance.
     * @return void
     *
     */
    public function __construct()
    {
        if(!Auth::check()){
            redirect('/login');
        }
        $this->middleware('auth');

    }

    /**
     * 手机申请解绑记录
     */
    public function unbindPhoneList()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){  //删除
            $id = Route::input('id');
            $msg = DB::table('applications')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>'删除成功'
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>'系统错误，请稍后重试'
                ];
            }
        }
        $url = Input::url();
        $type = '解绑手机';
        $data = DB::table('applications')->where('user_id',$user['id'])->where('type','解绑手机')->select('id','created_at','re_content','result','content')->get();
        return view('user.unlockedList',compact('user','str','data','type','url'));
    }
    /**
     * 解绑手机申请
     */
    public function unbindPhone()
    {
        $user = $this->getUser();
        $has = DB::table('applications')->where('user_id',$user['id'])->where('type','解绑手机')->select('id','created_at','re_content','result')->first();
        if($has){
            return redirect('user/unbindPhone/list')->with('msg','您已申请，请等待审核');
        }
        if(Input::method()=='POST'){
            $data = Input::except('_token');
            $rule = $this->rule();
            $rule['rules']['phone'] =  'required|regex:/^1[34578]\d{9}$/';
            $validator = Validator::make($data,$rule['rules'],$rule['msg']);
            if($validator->passes()){
                $data['username'] = htmlspecialchars($data['username']);
                $data['content'] = htmlspecialchars($data['content']);
                $data['type'] = '解绑手机';
                $data['user_id'] = $user['id'];
                $data['created_at'] = time();
                $msg = DB::table('applications')->insert($data);
                if($msg){
                    return redirect('user/unbindPhone/list');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $url = Input::url();
        $type="解绑手机";
        return view('user.unlocked',compact('user','type','url'));
    }

    /**
     * 申请修改绑定邮箱
     */
    public function EditEmail()
    {
        $user = $this->getUser();
        $has = DB::table('applications')->where('user_id',$user['id'])->where('type','换绑邮箱')->select('id','created_at','re_content','result')->first();
        if($has){
            return redirect('user/EditEmail/list')->with('msg','您已申请，请等待审核');
        }
        if(Input::method()=='POST'){
            $data = Input::except('_token');
            if($data['email']==$data['n_email']){
                return back()->with('msg','新邮箱不能和原邮箱相同');
            }
            $rule = $this->rule();
            $rule['rules']['n_email'] =  'required|email|unique:users,email';
            $validator = Validator::make($data,$rule['rules'],$rule['msg']);
            if($validator->passes()){
                $data['username'] = htmlspecialchars($data['username']);
                $data['content'] = htmlspecialchars($data['content']);
                $data['type'] = '换绑邮箱';
                $data['user_id'] = $user['id'];
                $data['created_at'] = time();
                $data['email'] = $data['n_email'];
                unset($data['n_email']);
                $msg = DB::table('applications')->insert($data);
                if($msg){
                    return redirect('user/EditEmail/list');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $url = Input::url();
        $type = '换绑邮箱';
        return view('user.unlocked',compact('user','url','type'));
    }
    /**
     * 手机申请解绑记录
     */
    public function EditEmailList()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE') {  //删除
            $id = Route::input('id');
            $msg = DB::table('applications')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>'删除成功'
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>'系统错误，请稍后重试'
                ];
            }
        }
        $url = Input::url();
        $type = '换绑邮箱';
        $data = DB::table('applications')->where('user_id',$user['id'])->where('type','换绑邮箱')->select('id','created_at','re_content','result','content')->get();
        return view('user.unlockedList',compact('user','data','url','type'));
    }

    /**
     *
     *资金异常
     *Abnormal capital
     */
    public function AbnormalCapital()
    {
        $user = $this->getUser();
        if(Input::method()=='POST'){
            $data = Input::except('_token');
            $rule = $this->rule();
            $validator = Validator::make($data,$rule['rules'],$rule['msg']);
            if($validator->passes()){
                $data['username'] = htmlspecialchars($data['username']);
                $data['content'] = htmlspecialchars($data['content']);
                $data['type'] = '资金异常';
                $data['user_id'] = $user['id'];
                $data['created_at'] = time();
                $msg = DB::table('applications')->insert($data);
                if($msg){
                    return redirect('user/AbnormalCapital/list');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $url = Input::url();
        $type = '资金异常';
        return view('user.unlocked',compact('user','url','type'));
    }
    /**
     *
     *资金异常申请列表
     *Abnormal capital
     */
    public function AbnormalCapitalList()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){  //删除
            $id = Route::input('id');
            $msg = DB::table('applications')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>'删除成功'
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>'系统错误，请稍后重试'
                ];
            }
        }
        $url = Input::url();
        $type = '资金异常';
        $data = DB::table('applications')->where('user_id',$user['id'])->where('type','资金异常')->select('id','created_at','re_content','result','content')->get();
        return view('user.unlockedList',compact('user','data','url','type'));
    }

    /**
     *
     *开户名修改
     */
    public function AccountName()
    {
        $user = $this->getUser();
        if(Input::method()=='POST'){
            $data = Input::except('_token');
            if($data['bankName']==$data['n_bankName']){
                return back()->with('msg','新开户名不能和原开户名相同');
            }
            $rule = $this->rule();
            $rule['rules']['n_bankName'] =  'required|regex:/\p{Han}/u';
            $validator = Validator::make($data,$rule['rules'],$rule['msg']);
            if($validator->passes()){
                $data['username'] = htmlspecialchars($data['username']);
                $data['content'] = htmlspecialchars($data['content']);
                $data['type'] = '开户名修改';
                $data['user_id'] = $user['id'];
                $data['created_at'] = time();
                $data['bankName'] = $data['n_bankName'];
                unset($data['n_bankName']);
                $msg = DB::table('applications')->insert($data);
                if($msg){
                    return redirect('user/AccountName/list');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $url = Input::url();
        $type = '开户名修改';
        return view('user.unlocked',compact('user','url','type'));
    }
    /**
     *
     *开户名修改列表
     */
    public function AccountNameList()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){  //删除
            $id = Route::input('id');
            $msg = DB::table('applications')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>'删除成功'
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>'系统错误，请稍后重试'
                ];
            }
        }
        $url = Input::url();
        $type = '开户名修改';
        $data = DB::table('applications')->where('user_id',$user['id'])->where('type','开户名修改')->select('id','created_at','re_content','result','bankNo','content')->get();
        return view('user.unlockedList',compact('user','data','url','type'));
    }

    /**
     *
     *帐号解封
     */
    public function unlocked()
    {
        $user = $this->getUser();
        if(Input::method()=='POST'){
            $data = Input::except('_token');
            $rule = $this->rule();
            $validator = Validator::make($data,$rule['rules'],$rule['msg']);
            if($validator->passes()){
                $data['username'] = htmlspecialchars($data['username']);
                $data['content'] = htmlspecialchars($data['content']);
                $data['type'] = '帐号解封';
                $data['user_id'] = $user['id'];
                $data['created_at'] = time();
                $msg = DB::table('applications')->insert($data);
                if($msg){
                    return redirect('user/unlockedList/list');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
            }else{
                return back()->withErrors($validator);
            }
        }
        $url = Input::url();
        $type = '帐号解封';
        return view('user.unlocked',compact('user','url','type'));
    }
    /**
     *
     *帐号解封列表
     */
    public function unlockedList()
    {
        $user = $this->getUser();
        if(Input::method()=='DELETE'){  //删除
            $id = Route::input('id');
            $msg = DB::table('applications')->where('id',$id)->delete();
            if($msg){
                return $json =[
                    'status'=>'1',
                    'info'=>'删除成功'
                ];
            }else{
                return $json =[
                    'status'=>'-1',
                    'info'=>'系统错误，请稍后重试'
                ];
            }
        }
        $url = Input::url();
        $type = '帐号解封';
        $data = DB::table('applications')->where('user_id',$user['id'])->where('type','帐号解封')->select('id','created_at','re_content','result')->get();
        return view('user.unlockedList',compact('user','data','type','url'));
    }

    protected function rule(){
        $data = array();
        $data['rules']=[
            'username'=>'required',
            'email'=>'required|email',
            'BindPhone'=>'required|regex:/^1[34578]\d{9}$/',
            'IdCard'=>'required',
            'bankNo'=>'required',
            'bankName'=>'required|regex:/\p{Han}/u',
            'content'=>'required',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
        ];
        $data['msg']=[
            'username.required'=>'请输入用户名!',
            'email.required'=>'请输入注册邮箱!',
            'email.email'=>'邮箱格式不正确!',
            'BindPhone.required'=>'绑定手机不能为空!',
            'BindPhone.regex'=>'手机格式不正确!',
            'IdCard.required'=>'请填写身份证!',
            'bankName.regex'=>'开户名只能是中文!',
            'bankName.required'=>'开户名不能为空!',
            'n_bankName.regex'=>'开户名只能是中文!',
            'n_bankName.required'=>'开户名不能为空!',
            'content.required'=>'写填写申请理由!',
            'phone.regex'=>'联系手机格式不正确!',
            'phone.required'=>'请填写联系手机!',
            'qq.required'=>'请填写联系QQ!',
            'qq.regex'=>'联系QQ不正确!',
            'n_email.required'=>'请输入新邮箱!',
            'n_email.email'=>'邮箱格式不正确!',
            'n_email.unique'=>'邮箱已经被占用!',
        ];
        return $data;
    }
}
