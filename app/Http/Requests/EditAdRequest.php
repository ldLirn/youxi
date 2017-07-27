<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;


/**
 * Class EditAdRequest
 * @package App\Http\Requests
 * 广告 修改 规则
 */
class EditAdRequest extends Request
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
            'ad_name'=>'required|unique:ad,ad_name,'.$this->get('id'),
            'start_time'=>'date',
            'end_time'=>'date',
        ];
    }

    public function messages()
    {
        return[
            'ad_name.required'=>'广告名称不能为空!',
            'ad_name.unique'=>'广告已经存在!',
            'start_time.date'=>'开始时间必须是时间格式!',
            'end_time.date'=>'结束时间必须是时间格式!',
        ];
    }
}
