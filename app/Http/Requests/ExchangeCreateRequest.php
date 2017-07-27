<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class ExchangeCreateRequest
 * @package App\Http\Requests
 * 积分商城 添加 规则
 */
class ExchangeCreateRequest extends Request
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
            'goods_name'=>'required',
            'pic'=>'required',
            'integral'=>'required|numeric',
            'stock'=>'required|numeric',
            'max_exchange'=>'required|numeric',
            'content'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'goods_name.required'=>trans('com.no_goods_name'),
            'pic.required'=>'请上传商品图片!',
            'integral.numeric'=>'所需积分必须是数字!',
            'integral.required'=>'请填写所需积分!',
            'stock.numeric'=>'库存必须是数字!',
            'stock.required'=>'请填写库存!',
            'max_exchange.numeric'=>'最大兑换必须是数字!',
            'max_exchange.required'=>'请填写最大兑换数量!',
            'content.required'=>'请填写商品详情!',
            
        ];
    }
}
