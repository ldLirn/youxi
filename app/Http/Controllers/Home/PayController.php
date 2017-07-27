<?php

namespace App\Http\Controllers\Home;

use App\Events\Event;
use App\Events\SendMessage;
use App\Http\Controllers\Controller;

use App\Http\Model\Account;
use App\Http\Model\Banner;
use App\Http\Model\Game;
use App\Http\Model\GoodsGame;
use App\Http\Model\Order;
use App\Http\Model\User;
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Omnipay\Omnipay;
use Overtrue\Socialite\Providers\WeChatProvider;
use Toplan\FilterManager\Facades\FilterManager;
use Vinkla\Hashids\Facades\Hashids;


/**
 * Class PayController
 * @package App\Http\Controllers\Home
 * 支付
 */
class PayController extends CommonController
{

    /**
     * Create a new controller instance.
     * @return void
     *
     */
    public function __construct()
    {
        if(!Auth::check()){
            redirect('/login');
        }
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *  余额支付
     * @return \Illuminate\Http\Response
     */
    public function money()
    {
        $order = Order::where('id',intval(Input::get('id')))->first()->toArray();
        $user_id = Auth::user()->id;
        $use_money = Input::get('money');
        if($use_money<=0){
            return $data =[
                'status' =>'-1',
                'info' =>'请输入正确的金额'
            ];
        }
        if($use_money>$order['order_amount']){
            return $data =[
                'status' =>'-1',
                'info' =>'支付金额不能大于订单金额'
            ];
        }
        if(!preg_match('/^\d+(?=\.{0,1}\d+$|$)/',$use_money)){
            return $data =[
                'status' =>'-1',
                'info' =>'请输入正确的金额'
            ];
        }else{
            $user_money = Auth::user()->money;  //用户的余额
            if($use_money>$user_money){    //使用的余额大于用户余额
                return $data =[
                    'status' =>'-2',
                    'info' =>'余额不足'
                ];
            }else{
                $pay_password = Auth::user()->pay_password;
                if($pay_password==''){
                    return $data =[
                        'status' =>'-200',
                        'info' =>'请先设置支付密码!',
                    ];            //没有设置支付密码，跳转到支付密码设置
                }else{

                    if (!Hash::check(Input::get('pay_password'), $pay_password)){
                        return $data =[
                            'status' =>'-3',
                            'info' =>'支付密码错误'
                        ];
                    }else{
                        if($order['order_amount']==$use_money){ //全部使用余额支付
                            try {
                                DB::transaction(function () use($use_money,$user_id,$order){
                                    DB::table('users')->where('id',$user_id)->decrement('money', $use_money);  //减去用户表中支付的钱
                                    DB::table('goods_game')->where('id',$order['goods_id'])->decrement('goods_stock',$order['buy_number']);  //减库存
                                    $account['user_id'] = $user_id;
                                    $account['money'] = -$use_money;   //这里只记录用户余额变化，积分之类的确认收获后改变
                                    $account['change_time'] = time();
                                    $account['change_desc'] = '支付订单'.$order['order_sn'];
                                    $account['change_type'] = '99';
                                    DB::table('account_log')->insert($account);         //写入账目记录
                                    $pay_log['order_id'] = $order['id'];
                                    $pay_log['order_amount'] = $order['order_amount'];
                                    $pay_log['is_paid'] = '1';   //已支付
                                    DB::table('pay_log')->insert($pay_log);    //写入支付记录
                                    DB::table('order')->where('id',$order['id'])->update(['pay_status'=>'1','pay_id'=>'0','pay_name'=>'余额','money_paid'=>$order['order_amount'],'pay_time'=>time()]);
                                });
                                Cache::forget('goods_detail_'.$order['goods_id']);
                                Event::fire(new SendMessage($user_id,'user.order_payment',$order['order_sn'],'','',''));
                                return $data =[
                                    'status' =>'202',
                                    'info' =>''
                                ];
                            } catch (Exception $e) {
                                return back()->with('msg', $e);
                            }
                        }else{  //余额支付一部分 ,只记录使用了多少，在order表，不更改用户余额
                            $sy_money = $order['order_amount']-$use_money;  //剩余支付金额
                            $msg = Order::where('id',$order['id'])->update(['use_balance'=>$use_money,'updated_at'=>time()]);
                            if($msg){
                                return $data =[
                                    'status' =>'200',
                                    'info' =>'余额使用成功，还需支付'.$sy_money,
                                    'sy_money' => $sy_money
                                ];
                            }else{
                                return $data =[
                                    'status' =>'203',
                                    'info' =>trans('com.system_error')
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    /**
     *   其他支付展示页
     */
    public function PayDirectly()
    {
        $data = Input::all();
        $data['pay_money'] = 0;
        $money = Order::where('order_sn',$data['order_sn'])->select('use_balance','order_amount')->first();
        if(!$money){
            return abort(404);
        }
        if(isset($data['use_balace'])){
            $data['pay_money'] = $money['use_balance'];
        }
        $data['sy_money'] = $money['order_amount']-$data['pay_money'];
        $data['order_amount'] = $money['order_amount'];
        return view('home.PayDirectly',compact('data'));
    }
    
    
    
    /**
     *    支付宝   支付请求
     */
    public function pay()
    {
        $order_sn = Input::get('order_sn');
        $order_info = Order::where('order_sn',$order_sn)->first();
        if(!$order_info){
            return abort(404);
        }
        // 创建支付单。
        $alipay = app('alipay.web');
        $alipay->setOutTradeNo('order_id');
        $alipay->setTotalFee('order_price');
        $alipay->setSubject('goods_name');
        $alipay->setBody('goods_description');

        $alipay->setQrPayMode('4'); //该设置为可选，添加该参数设置，支持二维码支付。

        // 跳转到支付页面。
        return redirect()->to($alipay->getPayLink());
    }


    /**
     * 微信，支付请求
     */
    public function wechat()
    {

        /**
         * 第 1 步：定义商户
         * Business
         */
        $business = new Businese(
            APP_ID,
            APP_KEY,
            MCH_ID,
            MCH_KEY
        );

        /**
         * 第 2 步：定义订单
         */
        $order = new Order();
        $order->body = 'test body';
        $order->out_trade_no = md5(uniqid().microtime());
        $order->total_fee = '1'; // 单位为 “分”, 字符串类型
        $order->openid = OPEN_ID;
        $order->notify_url = 'http://xxx.com/wechat/payment/notify';

        /**
         * 第 3 步：统一下单
         */
        $unifiedOrder = new UnifiedOrder($business, $order);

        /**
         * 第 4 步：生成支付配置文件
         */
        $payment = new Payment($unifiedOrder);
    }
}
