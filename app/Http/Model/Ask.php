<?php

namespace App\Http\Model;

use App\Events\Event;
use App\Events\SendMessage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Ask extends Model
{
    protected $table="ask";

    protected $guarded=[];
    public $timestamps = false;


    public function data($type_id)
    {
        return $this->where('type_id',$type_id)->orderBy('ask_time','desc')->Paginate(PAGE);
    }

    public function add($input,$url)
    {
        $msg = $this->insert($input);
        if($msg){
            return redirect('/admin/'.$url);
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }

    public function MyUpdate($id,$input,$url)
    {
        $msg = $this->where('id',$id)->update($input);
        if($msg){
            return redirect('/admin/'.$url);
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }

    public function reply($id,$input,$url,$data)
    {
        $msg = Ask::where('id',$id)->update($input);
        if($msg){
            \Illuminate\Support\Facades\Event::fire(new SendMessage($data->user_id,'user.ask',$data->ask_title));
            return redirect('/admin/'.$url);
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }

    public function search($type_id,$cate_id='',$keywords='')
    {
        if($keywords=='' && $cate_id!=''){
            $list = $this->where('type_id',$type_id)->where('cate_id',$cate_id)->orderBy('ask_time','desc')->Paginate(PAGE);
        }elseif ($keywords!='' && $cate_id==''){
            $list = $this->where('type_id',$type_id)->where('ask_title','like','%'.$keywords.'%')->orderBy('ask_time','desc')->Paginate(PAGE);
        }elseif($keywords!='' && $cate_id!=''){
            $list = $this->where('type_id',$type_id)->where('ask_title','like','%'.$keywords.'%')->where('cate_id',$cate_id)->orderBy('ask_time','desc')->Paginate(PAGE);
        }else{
            $list = $this->data($type_id);
        }
        return $list;
    }

    public function del($id)
    {
        $status = $this->where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除问答ID='.$id);
            $data = [
                'status' => 0,
                'info' => '删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => trans('com.system_error')
            ];
        }
        return $data;
    }

    public function delAll($input)
    {
        $status = $this->whereIn('id',$input['id'])->delete();
        if($status){
            Log::info(session('users.admin_name').'批量删除问答');
            return back()->with('msg','删除成功！');
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }
}
