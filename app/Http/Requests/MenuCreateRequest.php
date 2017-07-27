<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class MenuCreateRequest
 * @package App\Http\Requests
 * 后台 菜单 添加 规则
 */
class MenuCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pid = $this->get('pid');
        if($pid=='0'){
            return [
                'name'=>'required|unique:menu,name',
                'pid'=>'required',
            ];
        }else{
            return [
                'name'=>'required|unique:menu,name',
                'pid'=>'required',
                'url'=>'required|unique:menu,url',
                'bind_permission'=>'required',
            ];
        }

    }

    public function messages()
    {
        return[
            'name.required'=>'菜单名称不能为空!',
            'name.unique'=>'菜单名称已经存在!',
            'pid.required'=>'类型不能为空!',
            'url.required'=>'地址不能为空!',
            'url.unique'=>'链接地址已经存在!',
            'bind_permission.required'=>'绑定权限必须选择！'
        ];
    }
}
