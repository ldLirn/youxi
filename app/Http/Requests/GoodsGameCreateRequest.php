<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class GoodsGameCreateRequest
 * @package App\Http\Requests
 * 商品 添加 规则
 */
class GoodsGameCreateRequest extends Request
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
            'traded_type'=>'required',
            'goods_name'=>'required',
            'goods_price'=>'required',
            'goods_stock'=>'required',
            'sale_end_time'=>'required',
            'game_id'=>'required',
            'qu_id'=>'required',
            'game_qu_id'=>'required',
            'game_goods_type_id'=>'required',
        ];
    }


    public function messages()
    {
        return[
            'traded_type.required'=>'交易类型不能为空!',
            'goods_name.required'=>'商品名称不能为空!',
            'goods_price.required'=>'单价不能为空!',
            'goods_stock.required'=>'库存不能为空!',
            'sale_end_time.required'=>'截止时间不能为空!',
            'game_id.required'=>'请选择游戏!',
            'qu_id.required'=>'请选择大区信息!',
            'game_qu_id.required'=>'请选择区服!',
            'game_goods_type_id.required'=>'请选择商品类型!',
        ];
    }
}
