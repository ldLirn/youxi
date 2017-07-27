<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class AdminCreateRequest
 * @package App\Http\Requests
 * 添加管理员验证规则
 */
class AdminCreateRequest extends Request
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
        return [
            'name'=>'required|unique:users,name',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|confirmed',
            'role_id'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'password.required'=>'密码不能为空!',
            'password.confirmed'=>'两次输入的密码不相同!',
            'name.required'=>'用户名不能为空!',
            'email.required'=>'邮箱不能为空!',
            'name.unique'=>'用户名已经存在!',
            'email.unique'=>'邮箱已经存在!',
            'email.email'=>'邮箱格式不正确!',
            'role_id.required'=>'请选择角色'
        ];
    }
}
