<?php

namespace App\Http\Controllers\Home;

use App\Events\SendMessage;
use App\Http\Controllers\Home\CommonController;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Class MessagesController
 * @package App\Http\Controllers\Home
 * 站内信
 */
class MessagesController extends CommonController
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $user = $this->getUser();
        $userNotified = User::find($user['id']);
        $messages = $userNotified->getNotifications();
        return view('messenger.index', compact('messages','user'));
    }
    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $user = $this->getUser();
        $userNotified = User::find($user['id']);
        $messages = $userNotified->getNotifications($id);
        foreach ($messages as $v){
            if($v->id==$id){
                $data = $v;
            }
        }
        if(!isset($data)){
            return redirect('user/messages');
        }
        Notifynder::readOne($id);
        return view('messenger.show', compact('data', 'user'));
    }


    public function delete($id)
    {
         $msg = Notifynder::delete($id);
        if($msg){
            return $data = [
                'status'=>'1',
                'info'  =>trans('com.operation_success')
            ];
        }else{
            return $data = [
                'status'=>'-1',
                'info'  =>trans('com.system_error')
            ];
        }
    }

}
