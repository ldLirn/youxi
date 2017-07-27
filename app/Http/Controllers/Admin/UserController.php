<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendMessage;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\CountValidator\Exception;

/**
 * Class UserController
 * @package App\Http\Controllers\Admin
 * 用户
 */
class UserController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.user',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.user', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.user', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.user', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $data = User::where('is_admin','0')->Paginate(PAGE);
        return view('admin.user.list',compact('data'));
    }

    public function create()
    {
        return view('admin.user.add');
    }

    public function store(Requests\UserCreateRequest $request)
    {
        $input = $request->except('_token','password_confirmation');
        $input['password'] = bcrypt($input['password']);
        $input['reg_time'] = time();
        $input['pay_password'] = bcrypt($input['pay_password']);
        $status = User::create($input);
        if($status){
            Log::info(session('users.admin_name').'新增用户'.$input['name']);
            return redirect('admin/user')->with('msg','添加成功');
        }else{
            return back()->with('msg','新增失败，请稍后重试');
        }
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('admin.user.edit',compact('data'));
    }

    public function update(Requests\UserEditRequest $request,$id)
    {
        $input = $request->except('_token','_method','password_confirmation');
        $input['password'] = $input['password']?bcrypt($input['password']):'';
        $input['pay_password'] = $input['pay_password']?bcrypt($input['pay_password']):'';
        if($input['password']==''){
            unset($input['password']);
        }
        if($input['pay_password']==''){
            unset($input['pay_password']);
        }
        $status = User::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改用户'.$input['email']);
            Cache::forget('user_info_'.$id);
            return redirect('admin/user')->with('msg','修改成功');
        }else{
            return back()->with('msg','修改失败，请稍后重试');
        }
    }

    public function show()
    {
        
    }

    public function destroy($id)
    {
        try {
            DB::transaction(function () use($id){
                DB::table('users')->where('id',$id)->delete();
                DB::table('user_account')->where('user_id',$id)->delete();
                $goods_id = DB::table('goods_game')->where('user_id',$id)->select('id')->first()->toArray();
                DB::table('goods_game')->where('user_id',$id)->delete();
                DB::table('goods_game_picture')->where('goods_id',$goods_id['id'])->delete();
                DB::table('game_user_info')->where('goods_id',$goods_id['id'])->delete();
                DB::table('account_log')->where('user_id',$id)->delete();
                DB::table('order')->where('user_id',$id)->delete();

            });
            Log::info(session('users.admin_name') . '删除用户ID='.$id);
            Cache::forget('user_info_'.$id);
            $data = [
                'status' => 0,
                'info' => '会员删除成功！',
            ];
            return $data;
        } catch (Exception $e) {
            $data = [
                'status' => 1,
                'info' => $e,
            ];
            return $data;
        }

    }
    
    public function search()
    {
        $input = Input::except('_token');

        if($input['dyjf']!='' && $input['xyjf']!=''&& $input['dyjf']>=$input['xyjf']){
            return back()->with('msg','查询参数不正确');
        }
        if($input['dyjf']=='' && $input['xyjf']==''&& $input['keywords']==''){
            return back()->with('msg','请输入查询条件');
        }

        if($input['dyjf']!='' && $input['xyjf']=='' && $input['keywords']==''){
            $data = User::where('is_admin',0)->where('integral','>=',$input['dyjf'])->Paginate(PAGE);
        }
        if($input['xyjf']!='' && $input['dyjf']=='' && $input['keywords']==''){
            $data = User::where('is_admin',0)->where('integral','<=',$input['xyjf'])->Paginate(PAGE);
        }
        if($input['keywords']!='' && $input['xyjf']=='' && $input['dyjf']==''){
            $data = User::where('name','like','%'.$input['keywords'].'%')->orwhere('email','like','%'.$input['keywords'].'%')->where('is_admin',0)->Paginate(PAGE);
        }
        if($input['dyjf']!='' && $input['xyjf']!='' && $input['keywords']==''){
            $data = User::where('is_admin',0)->where('integral','>=',$input['dyjf'])->where('integral','<=',$input['xyjf'])->Paginate(PAGE);
        }
        if($input['dyjf']!='' && $input['xyjf']=='' && $input['keywords']!=''){
            $data = User::where('name','like','%'.$input['keywords'].'%')->orwhere('email','like','%'.$input['keywords'].'%')->where('is_admin',0)->where('integral','>=',$input['dyjf'])->Paginate(PAGE);
        }
        if($input['dyjf']=='' && $input['xyjf']!='' && $input['keywords']!=''){
            $data = User::where('name','like','%'.$input['keywords'].'%')->orwhere('email','like','%'.$input['keywords'].'%')->where('is_admin',0)->where('integral','<=',$input['xyjf'])->Paginate(PAGE);
        }
        if($input['dyjf']!='' && $input['xyjf']!='' && $input['keywords']!=''){
            $data = User::where('name','like','%'.$input['keywords'].'%')->orwhere('email','like','%'.$input['keywords'].'%')->where('is_admin',0)->where('integral','<=',$input['xyjf'])->where('integral','>=',$input['dyjf'])->Paginate(PAGE);
        }
        return view('admin.user.list',compact('data'));
    }

    public function all_do()
    {
        $type = Input::except('_token');
        switch (intval($type['all_do'])){
            case '1':
                $status = User::whereIn('id',$type['id'])->delete();
                if($status){
                    return redirect('admin/user')->with('msg','删除成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
            case '2':
                $status = User::whereIn('id',$type['id'])->update(array('status'=>'1'));
                if($status){
                    foreach($type['id'] as $v){
                        Cache::forget('user_info_'.$v);
                    }
                    return redirect('admin/user')->with('msg','所选冻结成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
            case '3':
                $status = User::whereIn('id',$type['id'])->update(array('status'=>'0'));
                if($status){
                    foreach($type['id'] as $v){
                        Cache::forget('user_info_'.$v);
                    }
                    return redirect('admin/user')->with('msg','所选解冻成功');
                }else{
                    return back()->with('msg','系统错误，请稍后重试');
                }
                break;
        }
    }

    /**
     * 发送消息
     */
    public function ChoiceMsgType($id)
    {
        if(Input::method()=='POST'){
            $user = User::where('id',$id)->select('email','telphone')->first();
            $input = Input::all();
            switch($input['msg_type']){
                case 1:
                    $content = $input['msg_content'];
                    Event::fire(new SendMessage($id,'user.msg','','',$content));
                    break;
                case 2:
                    $input['email'] = $user['email'];
                    $flag = Mail::send('toUserEmail',$input,function($message)use($input){
                        $message ->to($input['email'])->subject($input['email_title']);
                    });
                    if($flag){
                       return back()->with('msg','邮件发送成功');
                    }else{
                        return back()->with('msg','发送邮件失败，请重试！');
                    }
                    break;
                case 3:
                    header("Content-type: text/html; charset=utf-8");
                    date_default_timezone_set('PRC'); //设置默认时区为北京时间
                    //短信接口用户名 $uid
                    $uid = config('phpsms.agents.LingKai.CorpID');
                    //短信接口密码 $passwd
                    $passwd = config('phpsms.agents.LingKai.Pwd');
                    $msg = rawurlencode(mb_convert_encoding($input['tel_content']."【".config('phpsms.agents.LingKai.CorpName')."】", "gb2312", "utf-8"));
                    $gateway = "http://inolink.com/WS/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$user['telphone']}&Content={$msg}&Cell=&SendTime=";
                    $result = file_get_contents($gateway);
                    if(  $result > 0 )
                    {
                        return back()->with('msg','短信发送成功');
                    }
                    else
                    {
                        return back()->with('msg',"发送失败, 错误提示代码: ".$result);
                    }
                    break;
            }
        }
       return view('admin.user.msg',compact('id'));
    }
}
