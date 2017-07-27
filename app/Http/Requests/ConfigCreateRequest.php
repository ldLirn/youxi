<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class ConfigCreateRequest
 * @package App\Http\Requests
 * 网站配置 添加 规则
 */
class ConfigCreateRequest extends Request
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
            'config_title'=>'required',
            'config_name'=>'required|alpha_dash',
            'field_type'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'config_title.required'=>'配置名称不能为空!',
            'config_name.required'=>'英文别名不能为空!',
            'config_name.alpha'=>'别名只能是字母和数字，以及破折号和下划线!',
            'field_type.required'=>'类型不能为空!',
        ];
    }
}
