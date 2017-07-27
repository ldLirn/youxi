<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class UserRankEditRequest
 * @package App\Http\Requests
 * 会员等级 修改 规则
 */
class UserRankEditRequest extends Request
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
            'rank_name'=>'required|unique:user_rank,rank_name,'.$this->get('id'),
            'min_points'=>'required|numeric',
            'max_points'=>'required|numeric',
            'discount'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'rank_name.required'=>'会员等级名称不能为空!',
            'rank_name.unique'=>'会员等级名称已经存在!',
            'min_points.unique'=>'积分下限必须填写!',
            'max_points.unique'=>'积分上限必须填写!',
            'min_points.numeric'=>'积分下限必须是数字!',
            'max_points.numeric'=>'积分上限必须是数字!',
            'discount.unique'=>'手续费折扣必须填写!',
            'discount.numeric'=>'手续费折扣必须是数字!',

        ];
    }
}
