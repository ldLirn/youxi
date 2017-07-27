<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class AttributeEditRequest
 * @package App\Http\Requests
 * 游戏属性修改规则
 */
class AttributeEditRequest extends Request
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
            'game_goods_type_id'=>'required',
            'game_id'=>'required',
            'data'=>'required',
            
        ];
    }

    public function messages()
    {
        return[
            'game_id.required'=>'请选择游戏!',
            'game_goods_type_id.required'=>'请选择游戏商品类型!',
            'data.required'=>'属性不能为空!',
        ];
    }
}
