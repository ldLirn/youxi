<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ConfigModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class ConfigController
 * @package App\Http\Controllers\Admin
 * 网站配置
 */
class ConfigController extends CommonController
{

    public function __construct()
    {
        $this->middleware('checkpermission:list.config',['only'=>['index','search']]);
        $this->middleware('checkpermission:create.config', ['only' => ['store']]);
        $this->middleware('checkpermission:edit.config', ['only' => ['edit', 'update']]);
        $this->middleware('checkpermission:delete.config', ['only' => ['destroy']]);
    }
    
    //网站配置列表
    public function index(){
        $data = ConfigModel::orderBy('config_order','desc')->get();
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" name="config_content[]" class="lg" value="'.$v->config_content.'"/>';
                    break;
                case 'radio':
                    $field_arr = explode(',',$v->field_value);  //单选字段的切割
                    $str = '';
                    foreach($field_arr as $a=>$s){
                        $arr = explode('|',$s);
                        $check ='';
                        if($v->config_content == $arr[0]){
                            $check = ' checked ';
                        }
                       $str .= '<input type="radio" name="config_content[]" value="'.$arr[0].'" '.$check.'/>'.$arr[1].''.'　';
                    }
                    $data[$k]->_html = $str;
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="config_content[]">'.$v->config_content.'</textarea>';
                    break;
            }
        }
        return view('admin.config.config_list',compact('data'));
    }
    //添加操作
    public function store(Requests\ConfigCreateRequest $request){
        $input = $request->except('_token');
        $status = ConfigModel::create($input);
        if($status){
            Log::info(session('users.admin_name').'添加网站配置'.$input['config_title']);
            return redirect('admin/config');
        }else{
            return back()->with('msg','配置信息新增失败，请稍后重试');
        }
    }
    //添加视图
    public function create(){
        return view('admin.config.config_add');
    }
    //删除
    public function destroy($id){
        $status = ConfigModel::where('id',$id)->delete();
        if($status){
            Log::info(session('users.admin_name').'删除网站配置ID='.$id);
            $this->putFile();
            $data = [
                'status' => 0,
                'info' => '配置项删除成功！',
            ];
        }else{
            $data = [
                'status' => 1,
                'info' => '配置项删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
    //修改操作
    public function update(Requests\ConfigEditRequest $request,$id){
        $input = $request->except('_token','_method');
        $status = ConfigModel::where('id',$id)->update($input);
        if($status){
            Log::info(session('users.admin_name').'修改网站配置'.$input['config_title']);
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('msg','配置项更新失败，请稍后重试！');
        }
       
    }
    //显示单个内容
    public function show(){

    }
    //修改视图
    public function edit($id){
        $data = ConfigModel::find($id);
        return view('admin.config.config_edit',compact('data'));
    }


    //改变排序 AJAX
    public function changeOrder()
    {
        $input = Input::all();
        $data = ConfigModel::find($input['id']);
        $data->config_order = $input['config_order'];
        $code = $data->update();
        if($code){
            $msg=[
                'status'=>'0',
                'info'=>'网站配置排序修改成功,请点击更新排序'
            ];
        }else{
            $msg=[
                'status'=>'1',
                'info'=>'失败了，系统错误请稍后重试'
            ];
        }
        return $msg;
    }
    
    ////网站配置值的改变
    public function updateConfig()
    {
        $input = Input::all();
        foreach($input['id'] as $k=>$v){
            ConfigModel::where('id',$v)->update(['config_content'=>$input['config_content'][$k]]);
        }
        $this->putFile();
        Log::info(session('users.admin_name').'修改网站配置值');
        return back()->with('msg','配置项更新成功！');
        
    }
    
    
    //将网站配置信息写入文件
    protected function putFile()
    {
        $config = ConfigModel::pluck('config_content','config_name')->all();
        $path = base_path().'\config\web.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }
}
