<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class LinkCreateRequest
 * @package App\Http\Requests
 * 友情链接 添加 规则
 */
class LinkCreateRequest extends Request
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
            'link_name'=>'required',
            'link_url'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'link_url.required'=>'地址不能为空!',
            'link_name.required'=>'友情链接标题不能为空!',
        ];
    }
}
