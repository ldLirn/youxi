<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AskCreateRequest
 * @package App\Http\Requests
 * 投诉咨询添加规则
 */
class AskCreateRequest extends Request
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
            'ask_title'=>'required',
            'ask_content'=>'required',
            'cate_id'=>'required',
            'tel'=>'required|regex:/^1[34578]\d{9}$/',
            'qq' =>'required|regex:/^[1-9]\d{4,13}$/',
        ];
    }


    public function messages()
    {
        return[
            'ask_title.required'=>'请填写问题标题',
            'ask_content.required'=>'请填写问题描述',
            'cate_id.required'=>'请选择问题分类',
            'tel.required'=>trans('com.no_phone'),
            'tel.regex'=>trans('com.error_phone'),
            'qq.required' =>trans('com.no_qq'),
            'qq.regex' =>trans('com.error_qq'),
        ];
    }
    
}
