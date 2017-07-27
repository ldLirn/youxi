<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class UserAccountEditRequest
 * @package App\Http\Requests
 * 用户资金 审核 规则
 */
class UserAccountEditRequest extends Request
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
            'admin_note'=>'required',
            'result' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'admin_note.required'=>'请填写备注',
            'result.required'=>'请选择审核结果',
        ];
    }
}
