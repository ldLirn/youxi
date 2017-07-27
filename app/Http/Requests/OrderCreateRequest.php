<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class OrderCreateRequest
 * @package App\Http\Requests
 * 订单 添加 规则
 */
class OrderCreateRequest extends Request
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
            'order_sn' =>'required|unique:order,order_sn',
            'buy_number'=>'required|regex:/^(?!0)[0-9]{1,3}$/',
            'role_name'=>'required',
            'telphone'=>'required|regex:/^1[34578]\d{9}$/',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
        ];
    }

    public function messages()
    {
        return[
            'order_sn.required'=>'订单编号不存在!',
            'order_sn.unique'=>'订单已经存在!',
            'role_name.required'=>'请填写角色昵称!',
            'telphone.required'=>'手机号码必须填写!',
            'telphone.regex'=>'手机号码格式不正确!',
            'qq.required'=>'QQ号码必须填写!',
            'qq.regex'=>'QQ号码格式不正确!',
        ];
    }
}
