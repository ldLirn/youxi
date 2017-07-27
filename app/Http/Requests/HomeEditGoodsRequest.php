<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class HomeEditGoodsRequest
 * @package App\Http\Requests
 * 前台 商品 修改 规则
 */
class HomeEditGoodsRequest extends Request
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
            'goods_price'=>'required|regex:/^[1-9]{1}\d*(\.\d{1,2})?$/',
            'goods_stock'=>'required',
            'sale_end_time'=>'required',
            'game_user'=>'required',
            'game_user_tel'=>'required|regex:/^1[34578]\d{9}$/',
            'game_user_qq' =>'required|regex:/^[1-9]\d{4,13}$/',
            'best_time'=>'required',
            'to_money'=>'required',
        ];
    }


    public function messages()
    {
        return[
            'goods_name.required'=>trans('com.no_goods_name'),
            'goods_price.required'=>trans('com.no_goods_price'),
            'goods_price.regex'=>trans('com.error_goods_price'),
            'goods_stock.required'=>trans('com.no_goods_stock'),
            'sale_end_time.required'=>trans('com.no_sale_end_time'),
            'game_user.required' =>trans('com.no_role_name'),
            'game_user_name.required'=>trans('com.no_game_user_name'),
            'game_user_pwd.required' =>trans('com.no_game_user_pwd'),
            'game_user_tel.required'=>trans('com.no_phone'),
            'game_user_tel.regex'=>trans('com.error_phone'),
            'game_user_qq.required' =>trans('com.no_qq'),
            'game_user_qq.regex' =>trans('com.error_qq'),
            'best_time.required'=>trans('com.no_best_time'),
            'to_money.required'=>trans('com.no_to_money'),
        ];
    }

    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            $err ='';
           foreach ($errors as $k=>$v){
               foreach ($v as $l){
                   $err .= $l.',';
               }
           }
            $err = rtrim($err,',');
            return new JsonResponse($err, 200);
        }

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
