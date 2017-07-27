<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

/**
 * Class RoleEditRequest
 * @package App\Http\Requests
 * 角色 修改 规则
 */
class RoleEditRequest extends Request
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
            'name'=>'required|alpha|unique:roles,slug,'.$this->get('id'),
            'description'=>'required|unique:roles,description,'.$this->get('id'),
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'角色名称必须填写',
            'name.unique'=>'角色名称已经存在',
            'name.alpha'=>'角色名称必须是英文字母',
            'description.required'=>'中文名称必须填写',
            'description.unique'=>'中文名称已经存在',
            
        ];
    }
}
