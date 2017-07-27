<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAccount extends Model
{
    protected $table="user_account";

    protected $guarded=[];
    public $timestamps = false;

    //会员信息
    public function user()
    {
        return $this->hasOne('App\Http\Model\User','id','user_id');
    }
    
    //搜索
    public function search($input)
    {
        $user = new User();
        if($input['user_name']=='' && $input['process_type']=='' && $input['payment']=='' && $input['result']==''){
            $data = UserAccount::with('user')->Paginate(PAGE);
        }elseif($input['user_name']!='' && $input['process_type']=='' && $input['payment']=='' && $input['result']==''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->Paginate(PAGE);
        }elseif($input['user_name']!='' && $input['process_type']!='' && $input['payment']=='' && $input['result']==''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('process_type',$input['process_type'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']=='' && $input['payment']!='' && $input['result']==''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('payment',$input['payment'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']=='' && $input['payment']=='' && $input['result']!=''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('result',$input['result'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']!='' && $input['payment']!='' && $input['result']==''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('process_type',$input['process_type'])->where('payment',$input['payment'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']!='' && $input['payment']=='' && $input['result']!=''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('process_type',$input['process_type'])->where('result',$input['result'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']=='' && $input['payment']!='' && $input['result']!=''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('payment',$input['payment'])->where('result',$input['result'])->Paginate(PAGE);
        }elseif ($input['user_name']!='' && $input['process_type']!='' && $input['payment']!='' && $input['result']!=''){
            $data = UserAccount::with('user')->whereIn('user_id',$user->getUserId($input['user_name']))->where('payment',$input['payment'])->where('result',$input['result'])->where('process_type',$input['process_type'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']!='' && $input['payment']=='' && $input['result']==''){
            $data = UserAccount::with('user')->where('process_type',$input['process_type'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']!='' && $input['payment']!='' && $input['result']==''){
            $data = UserAccount::with('user')->where('process_type',$input['process_type'])->where('payment',$input['payment'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']!='' && $input['payment']=='' && $input['result']!=''){
            $data = UserAccount::with('user')->where('process_type',$input['process_type'])->where('result',$input['result'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']!='' && $input['payment']!='' && $input['result']!=''){
            $data = UserAccount::with('user')->where('process_type',$input['process_type'])->where('result',$input['result'])->where('payment',$input['payment'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']=='' && $input['payment']!='' && $input['result']==''){
            $data = UserAccount::with('user')->where('payment',$input['payment'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']=='' && $input['payment']!='' && $input['result']!=''){
            $data = UserAccount::with('user')->where('payment',$input['payment'])->where('result',$input['result'])->Paginate(PAGE);
        }elseif ($input['user_name']=='' && $input['process_type']=='' && $input['payment']=='' && $input['result']!=''){
            $data = UserAccount::with('user')->where('result',$input['result'])->Paginate(PAGE);
        }
        return $data;
    }
}
