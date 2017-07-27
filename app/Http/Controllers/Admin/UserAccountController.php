<?php

namespace App\Http\Controllers\Admin;

use App\Events\Event;
use App\Events\SendMessage;
use App\Http\Model\User;
use App\Http\Model\UserAccount;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Class UserAccountController
 * @package App\Http\Controllers\Admin
 * 充值 提现 申请
 */
class UserAccountController extends CommonController
{
    public function __construct()
    {
        $this->middleware('checkpermission:list.user_account',['only'=>['index','search']]);
        $this->middleware('checkpermission:edit.user_account', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.user_account', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = UserAccount::with('user')->Paginate(PAGE);
        return view('admin.user.user_account.list',compact('data'));
    }

    public function update(Requests\UserAccountEditRequest $request,$id)
    {
        $user_account = new UserAccount();
        $old = $user_account->find($id);//result
        $user_id = $old['user_id'];
        $process_type= $old['process_type'];
        $amount= $old['amount'];
        if($old['is_paid']=='0'){   //如果该申请是未处理过则直接保存
            try {
                DB::transaction(function () use($request,$id,$user_id,$process_type,$amount){
                    $account['result'] = intval($request->get('result')); //结果
                    $account['is_paid'] = '1';
                    $account['admin_user'] = session('users.admin_name');
                    DB::table('user_account')->where('id',$id)->update($account);
                    if($account['result']=='1'){   //结果为成功 则更新用户表
                        $accoun['change_time'] = time();
                        $accoun['user_id'] =$user_id;
                        if($process_type=='0'){   //充值，增加金额
                            DB::table('users')->where('id',$user_id)->increment('money', $amount);
                            $accoun['money'] = $amount;
                            $accoun['change_desc'] = '处理用户充值';
                            $accoun['change_type'] ='0';
                        }elseif($process_type=='1'){   //提现
                            DB::table('users')->where('id',$user_id)->decrement('frozen_money', $amount);
                            $accoun['frozen_money'] = -$amount;
                            $accoun['change_desc'] = '处理用户提现';
                            $accoun['change_type'] ='1';
                        }
                        DB::table('account_log')->insert($accoun);
                        Event::fire(new SendMessage($user_id,'user.withdrawal','',$amount,$this->UserInfo($user_id),''));
                    }else{   //失败,把冻结资金退回余额
                        DB::table('users')->where('id',$user_id)->increment('money', $amount);   //加余额
                        DB::table('users')->where('id',$user_id)->decrement('frozen_money', $amount);  //减冻结
                        $accoun['frozen_money'] = -$amount;
                        $accoun['money'] = $amount;
                        $accoun['change_desc'] = '用户提现审核不通过，退款';
                        $accoun['change_type'] ='99';
                        $accoun['change_time'] = time();
                        $accoun['user_id'] =$user_id;
                        DB::table('account_log')->insert($accoun);
                        Event::fire(new SendMessage($user_id,'user.withdrawal_error','',$amount,$this->UserInfo($user_id),''));
                    }
                });
                Cache::forget('user_info_'.$user_id);
                Log::info(session('users.admin_name') . '处理用户ID='.$user_id.'充值提现申请');
                return redirect('admin/user_account')->with('msg', '处理成功');

            } catch (Exception $e) {
                return back()->with('msg', $e);
            }
        }elseif($old['is_paid']=='1'){
            return back()->with('msg','此申请已经处理！！');
        }else{
            return back()->with('msg','未知错误');
        }
    }

    public function edit($id)
    {
        $data = UserAccount::with('user')->find($id);
        $user = User::where('id',$data['user_id'])->pluck('money');
        $user_money = $user['0'];
        if($data['process_type']=='1' && $data['amount']>$user_money){
            return back()->with('msg','用户余额不足');
        }
        return view('admin.user.user_account.edit',compact('data'));
    }

    public function destroy($id)
    {
        $status = UserAccount::where('id',$id)->delete();
        if($status){
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


    public function search()
    {
        $input = Input::except('_token');
        $data = (new UserAccount())->search($input);
        return view('admin.user.user_account.list',compact('data'));
    }
}
