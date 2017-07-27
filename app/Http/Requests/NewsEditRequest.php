<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class NewsEditRequest
 * @package App\Http\Requests
 * 新闻 修改 规则
 */
class NewsEditRequest extends Request
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
            'cat_id'=>'required',
            'title'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'cat_id.required'=>'分类不能为空!',
            'title.required'=>'文章标题不能为空!',
        ];
    }
}
