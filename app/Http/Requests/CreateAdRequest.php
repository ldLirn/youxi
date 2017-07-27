<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class CreateAdRequest
 * @package App\Http\Requests
 * 广告 添加 规则
 */
class CreateAdRequest extends Request
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
            'ad_name'=>'required|unique:ad,ad_name',
        ];
    }
    
    public function messages()
    {
        return [
            'ad_name.required'=>'广告名称不能为空!',
            'ad_name.unique'=>'广告已经存在!',
        ];
    }
}
