<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class NavCreateRequest
 * @package App\Http\Requests
 * 前台 导航 添加 规则
 */
class NavCreateRequest extends Request
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
            'nav_name'=>'required',
            'p_id'=>'required',
            'nav_url'=>'required',
            'is_show'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'nav_name.required'=>'导航名称不能为空!',
            'p_id.required'=>'分类不能为空!',
            'nav_url.required'=>'导航地址不能为空!',
            'is_show.required'=>'是否显示不能为空!',
        ];
    }
}
