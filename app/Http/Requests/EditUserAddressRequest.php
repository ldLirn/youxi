<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class EditUserAddressRequest
 * @package App\Http\Requests
 * 修改用户收货信息 规则
 */
class EditUserAddressRequest extends Request
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
            'telphone'=>'required|regex:/^1[34578]\d{9}$/',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
            'role_name'=>'required'
        ];
    }

    public function messages()
    {
        return[
            'telphone.regex'=>'手机号码格式不正确',
            'telphone.required'=>'手机号码不能为空',
            'qq.required'=>'QQ不能为空!',
            'qq.regex'=>'QQ格式不正确!',
            'role_name.required'=>'请填写角色昵称'
        ];
    }
}
