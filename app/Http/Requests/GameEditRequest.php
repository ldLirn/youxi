<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class GameEditRequest
 * @package App\Http\Requests
 * 游戏 修改 规则
 */
class GameEditRequest extends Request
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
            'game_name'=>'required|unique:game,game_name,'.$this->get('id'),
            'cate_id'=>'required',
            'qu_name'=>'required',
//            'type_name'=>'required',
//            'fee'=>'required|regex:/^\d+(?=\.{0,1}\d+$|$)/',
        ];
    }


    public function messages()
    {
        return[
            'game_name.required'=>'游戏名不能为空!',
            'game_name.unique'=>'游戏名称已经存在!',
            'cate_id.required'=>'分类不能为空!',
            'qu_name.required'=>'游戏区服不能为空!',
//            'type_name.required'=>'游戏商品种类不能为空!',
//            'fee.required'=>'手续费不能为空!',
//            'fee.regex'=>'手续费只能是数字!',
        ];
    }
}
