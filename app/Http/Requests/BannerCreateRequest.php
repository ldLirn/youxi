<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class BannerCreateRequest
 * @package App\Http\Requests
 * 轮播图 添加 规则
 */
class BannerCreateRequest extends Request
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
            'banner_name'=>'required',
            'banner_url'=>'required',
            'banner_img'=>'required',
        ];
    }

    public function messages()
    {
        return[
            'banner_url.required'=>'地址不能为空!',
            'banner_name.required'=>'标题不能为空!',
            'banner_img.required'=>'请上传轮播图!',
        ];
    }
}
