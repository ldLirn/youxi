<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class ArtCateCreateRequest
 * @package App\Http\Requests
 * 文章分类添加验证规则
 */
class ArtCateCreateRequest extends Request
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
            'cat_name'=>'required',
            'p_id'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'cat_name.required'=>'分类名称不能为空!',
            'p_id.required'=>'分类不能为空!',
        ];
    }
}
