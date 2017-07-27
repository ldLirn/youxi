<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class ApplicationRequest
 * @package App\Http\Requests
 * 异常申请验证规则
 */
class ApplicationRequest extends Request
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
            'user_id'=>'required',
            'email'=>'required|exists:users,email',
            'BindPhone'=>'required|regex:/^1[34578]\d{9}$/|exists:users,telphone',
            'IdCard'=>'required|regex:/^\d{15,18}$/',
            'bankNo'=>'required|regex:/^\d{13,21}$/',
            'bankName'=>'required|regex:/\p{Han}/u',
            'content'=>'required',
            'phone'=>'required|regex:/^1[34578]\d{9}$/',
            'qq'=>'required|regex:/^[1-9]\d{4,13}$/',
        ];
    }

    public function messages()
    {
        return[
            'user_id.required'=>'请选择申请人',
            'email.required'=>trans('com.no_email'),
            'email.exists'=>trans('com.exists_email'),
            'BindPhone.required'=>trans('com.no_BindPhone'),
            'BindPhone.regex'=>trans('com.error_BindPhone'),
            'BindPhone.exists'=>trans('com.exists_BindPhone'),
            'IdCard.required'=>trans('com.no_IdCard'),
            'IdCard.regex'=>trans('com.error_IdCard'),
            'bankNo.required'=>trans('com.no_bankNo'),
            'bankNo.regex'=>trans('com.error_bankNo'),
            'bankName.required'=>trans('com.no_bankName'),
            'bankName.regex'=>trans('com.error_bankName'),
            'content.required'=>trans('com.no_content'),
            'phone.required'=>trans('com.no_phone'),
            'phone.regex'=>trans('com.error_BindPhone'),
            'qq.required'=>trans('com.no_qq'),
            'qq.regex'=>trans('com.error_qq'),
        ];
    }
}
