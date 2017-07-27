<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class AdPositionEditRequest
 * @package App\Http\Requests
 * 修改广告位置验证规则
 */
class AdPositionEditRequest extends Request
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
            'adp_name'=>'required|unique:ad_position,adp_name,'.$this->get('id'),
            'adp_width'=>'required|numeric',
            'adp_height'=>'required|numeric',
        ];
    }

    public function messages()
    {
        return[
            'adp_name.required'=>'广告位置标题不能为空!',
            'adp_name.unique'=>'广告位置已经存在!',
            'adp_width.required'=>'广告位置宽度必填!',
            'adp_width.numeric'=>'广告位置宽度必须是数字!',
            'adp_height.numeric'=>'广告位置高度必填!',
            'adp_height.required'=>'广告位置高度必须是数字!',
        ];
        
    }
}
