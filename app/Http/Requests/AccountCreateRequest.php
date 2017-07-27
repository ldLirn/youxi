<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


/**
 * Class AccountCreateRequest
 * @package App\Http\Requests
 *  调节会员账户验证规则
 */
class AccountCreateRequest extends Request
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
            'change_desc'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'change_desc.required'=>'请填写变动原因!',
        ];
    }
}
