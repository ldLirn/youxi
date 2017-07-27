<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class CateGameEditRequest
 * @package App\Http\Requests
 * 游戏分类 修改 规则
 */
class CateGameEditRequest extends Request
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
            'cat_name'=>'required|unique:game_category,cat_name,'.$this->get('id'),
            'pid'=>'required',
        ];
    }


    public function messages()
    {
        return[
            'cat_name.required'=>'分类名不能为空!',
            'cat_name.unique'=>'分类名称已经存在!',
            'pid.required'=>'分类不能为空!',
        ];
    }
}
