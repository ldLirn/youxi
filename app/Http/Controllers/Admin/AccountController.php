<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Account;
use App\Http\Model\User;
use Doctrine\Common\Cache\Cache;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

/**
 * Class AccountController
 * @package App\Http\Controllers\Admin
 * 调节 用户 资金
 */
class AccountController extends CommonController
{
    /**
     * AccountController constructor.
     * 设置权限
     */
    public function __construct()
    {
        $this->middleware('checkpermission:list.account',['only'=>['index','search','show']]);
        $this->middleware('checkpermission:create.account', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.account', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.account', ['only' => ['destroy']]);
    }


    public function index()
    {
        $data = Account::Paginate(PAGE);
        return view('admin.user.account.list',compact('data'));
    }

    public function create()
    {
        $id = intval(Input::get('id'));
        $user = (new User())->money($id);
        return view('admin.user.account.add',compact('user','id'));
    }

    public function store(Requests\AccountCreateRequest $request)
    {
        $input = $request->except('_token');
        $obj = new Account();
        $money = $obj->is_add($input['money'],$input['money_do']);

        $frozen_money = $obj->is_add($input['frozen_money'],$input['frozen_money_do']);
        $integral = $obj->is_add($input['integral'],$input['integral_do']);
        $user_point_buy = $obj->is_add($input['user_point_buy'],$input['user_point_buy_do']);
        $user_point_sell = $obj->is_add($input['user_point_sell'],$input['user_point_sell']);
        if($money || $frozen_money || $integral || $user_point_buy || $user_point_sell) {
            $account['user_id'] = $input['id'];
            $account['money'] = $money;
            $account['frozen_money'] = $frozen_money;
            $account['integral'] = $integral;
            $account['user_point_buy'] = $user_point_buy;
            $account['user_point_sell'] = $user_point_sell;
            $account['change_time'] = time();
            $account['change_desc'] = $input['change_desc'];
            $account['change_type'] = '2';
            try {
                DB::transaction(function () use ($account, $input, $money, $frozen_money, $integral, $user_point_buy, $user_point_sell) {
                   // dd($account);
                    $old_user = DB::table('users')->where('id',$input['id'])->select('money','frozen_money','integral','user_point_buy','user_point_sell')->first();
                    $user['money'] = $money+$old_user->money;
                    $user['frozen_money'] = $frozen_money+$old_user->frozen_money;
                    $user['integral'] = $integral+$old_user->integral;
                    $user['user_point_buy'] = $user_point_buy+$old_user->user_point_buy;
                    $user['user_point_sell'] = $user_point_sell+$old_user->user_point_sell;
                    DB::table('account_log')->insert($account);
                    DB::table('users')->where('id',$input['id'])->update($user);
                });
                Log::info(session('users.admin_name') . '修改用户账户ID=' . $input['id']);
                Cache::forget('user_info_'.$input['id']);
                return redirect('admin/account/' . $input['id'])->with('msg', '调节成功');

            } catch (Exception $e) {
                return back()->with('msg', $e);
            }
        }
    }

    public function edit()
    {
        abort(404);
    }

    public function update()
    {
       abort(404);
    }

    public function show($id)
    {
        $Account = new Account();
        $html = $Account->user_money($id);
        $type = '0';
        if(Input::get('show_type')){
            $type = Input::get('show_type');
            $data = $Account->show_type($type,$id);
        }else{
            $data = $Account->where('user_id',$id)->Paginate(PAGE);
        }
        return view('admin.user.account.list',compact('data','html','id','type'));
    }

    public function search()
    {
        $Account = new Account();
        $type = Input::get('show_type');
        $id = Input::get('id');
        $html = $Account->user_money($id);
        $data = $Account->show_type($type,$id);
        return view('admin.user.account.list',compact('data','html','id','type'));
    }
}
