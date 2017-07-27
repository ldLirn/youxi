<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


//后台  路由
Route::group(['middleware' => ['web','admin.login'],'prefix' => 'admin','namespace'=>'Admin'], function()
{

    \Illuminate\Support\Facades\DB::enableQueryLog();  //打开sql查看器     上线后注释 调试使用

    Route::get('common/GetUsername','CommonController@GetUsername');
    /**
     * 网站管理
     */
    Route::any('power/edit_pass', 'AdminController@edit_pass');
    Route::any('power/edit_info', 'AdminController@edit_info');
    Route::get('log', 'AdminController@log');

    Route::resource('power','AdminController');

    Route::get('index','IndexController@index');
    Route::get('logout', 'LoginController@logout');
    Route::get('start', 'IndexController@start');
    Route::get('test', 'IndexController@test');

    Route::post('menu/changeOrder','MenuController@changeOrder');  //改变排序
    Route::resource('menu','MenuController');

    Route::resource('role','RoleController');
    /**
     *
     * 文章分类
     */
    Route::post('ArtCate/changeOrder','ArtCateController@changeOrder');  //改变排序
    Route::resource('ArtCate','ArtCateController');
    /**
     *
     * 文章系统
     */
    Route::post('news/search','NewsController@search');  //搜索
    Route::post('news/deleteAll','NewsController@deleteAll');  //批量删除
    Route::resource('news','NewsController');
    Route::post('news/change','NewsController@change');

    /**
     *
     * 网站配置
     */
   // Route::get('config/putFile', 'ConfigController@putFile');  //网站配置写入文件
    Route::post('config/changeOrder','ConfigController@changeOrder');  //改变排序
    Route::post('config/updateConfig','ConfigController@updateConfig');  //网站配置值的改变
    Route::resource('config','ConfigController');  //网站配置 路由

    /**
     *
     * 自定义导航
     */
    Route::post('nav/changeOrder','NavController@changeOrder');  //改变排序
    Route::resource('nav','NavController');  //自定义导航
    /**
     * 轮播图
     */
    Route::post('banner/changeOrder','BannerController@changeOrder');  //改变排序
    Route::resource('banner','BannerController');  //自定义导航
    /**
     * 友情链接
     */
    Route::resource('link','LinkController');  
    
    /**
     * 广告列表
     */
    Route::post('ad/search','AdController@search');  //搜索
    Route::resource('ad','AdController'); 
    
    /**
     * 广告位置
     */
    Route::post('ad_position/search','AdPositionController@search');  //搜索
    Route::resource('ad_position','AdPositionController');

    /**
     * 游戏管理
     */
    Route::post('edit_game','GameController@edit_game');  //自定义修改
    Route::resource('cate_game','CateGameController');  //游戏分类

    Route::any('game/search','GameController@search');  //搜索
    Route::post('game/change','GameController@change');  //搜索
    Route::resource('game','GameController');  //游戏
    Route::post('goodsgame/AjaxGame','GoodsGameController@AjaxGame');  //搜索
    Route::post('goodsgame/is_check','GoodsGameController@is_check');  //审核
    Route::post('goodsgame/all_do','GoodsGameController@all_do');  //批量操作
    Route::post('goodsgame/sale_on_off','GoodsGameController@sale_on_off');  //上下架 操作
    Route::post('trash/all_do','TrashController@all_do');  //批量操作
    Route::post('trash/search','TrashController@search');  //批量操作
    Route::resource('trash','TrashController');  //回收站
    Route::post('goodsgame/trash','GoodsGameController@trash');  //清理0库存
    Route::post('goodsgame/expired','GoodsGameController@expired');  //清理过期
    Route::any('goodsgame/search','GoodsGameController@search');  //搜索
    Route::resource('goodsgame','GoodsGameController');  //游戏商品
    Route::post('attribute/search','AttributeController@search');  //搜索
    Route::resource('attribute','AttributeController');  //游戏属性

    Route::resource('exchange','ExchangeController');  //积分商品
    Route::any('exchange/search','ExchangeController@search');  //搜索商品
    /**
     * 会员管理
     */
    Route::post('user/all_do','UserController@all_do');  //批量操作
    Route::post('user/search','UserController@search');  //搜索
    Route::resource('user','UserController');
    Route::post('account/search','AccountController@search');

    Route::any('user/msg/{id}','UserController@ChoiceMsgType');


    Route::resource('account','AccountController'); //账目管理

    Route::post('user_account/search','UserAccountController@search');
    Route::resource('user_account','UserAccountController'); //充值提现

    Route::resource('user_rank','UserRankController'); //会员等级

    Route::resource('application','ApplicationController'); //异常申请
    Route::post('application/{id}','ApplicationController@show');

    /**
     * 订单管理
     */
    Route::any('order/search','OrderController@search');  //搜索
    Route::get('order/edit_user_info_view','OrderController@edit_user_info_view');  //修改收货信息
    Route::post('order/edit_user_info','OrderController@edit_user_info');  //修改收货信息
    Route::any('order/edit_money','OrderController@edit_money');  //修改金额
    Route::resource('order','OrderController');  //批量操作
    Route::resource('exchange_order','ExchangeOrderController');  //积分商品订单

    /**
     * 投诉建议管理
     */
    Route::any('ask/search','AskController@search');  //搜索
    Route::post('ask/deleteAll','AskController@deleteAll');  //批量删除
    Route::post('ask/{id}','AskController@show');  //回复
    Route::any('advise/search','AdviserController@search');  //搜索
    Route::post('advise/deleteAll','AdviserController@deleteAll');  //批量删除
    Route::post('advise/{id}','AdviserController@show');  //回复
    Route::any('complaint/search','ComplaintController@search');  //搜索
    Route::post('complaint/deleteAll','ComplaintController@deleteAll');  //批量删除
    Route::post('complaint/{id}','ComplaintController@show');  //回复
    Route::resource('ask','AskController');  //咨询
    Route::resource('advise','AdviserController');  //建议
    Route::resource('complaint','ComplaintController');  //投诉

    /**
     * 报表统计
     */
    Route::any('order_stats','ReportController@order_stats');  //订单统计
    Route::any('sale_general','ReportController@sale_general');  //销售概况
    Route::any('sale_list','ReportController@sale_list');  //销售明细

    /**
     * 点卡管理
     */
    Route::any('dk_config','DKApiController@dk_config');    //点卡配置信息
    Route::get('dk_list','DKApiController@dk_list');    //点卡订单
    Route::get('dk_sure/{sporder_id}','DKApiController@dk_sure');    //更新点卡订单状态
    Route::get('dk_order_detail/{id}','DKApiController@dk_order_detail');    //点卡订单详情
    Route::get('dk_order_refund/{id}','DKApiController@dk_order_refund');    //点卡订单退款
    Route::any('dk_order/search','DKApiController@search');  //搜索点卡订单
    Route::get('dk_game_list','DKApiController@dk_game_list');    //点卡游戏列表
    Route::any('dk_game_edit/{cardid}','DKApiController@dk_game_edit');    //点卡游戏修改
    Route::get('dk_game_faceValue/{cardid}','DKApiController@dk_game_faceValue');  //点卡游戏面值
    Route::post('dk/change','DKApiController@change');  //改变状态
    Route::post('dk/change_on_sale','DKApiController@change_on_sale');
    Route::any('dk/dk_game_faceValue_edit/{cardid}','DKApiController@dk_game_faceValue_edit'); //修改面值
    Route::any('dk/search','DKApiController@game_search');  //搜索游戏
    Route::get('dk/update_dk_game_list','DKApiController@update_dk_game_list'); //同步游戏列表
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//个人中心
Route::group(['middleware' => ['web','user.login'],'namespace'=>'Home'], function()
{
    Route::get('/user', ['uses'=>'UserController@index','as'=>'user']);   //会员中心
   // dd(Route('user'));
    Route::post('/pay/money', 'PayController@money');   //余额支付
    Route::post('/pay/PayDirectly', 'PayController@PayDirectly');   //支付信息页面
    Route::post('/pay/PayDirectly', 'PayController@PayDirectly');   //支付
    
    Route::post('/pay/pay_post','PayController@pay');   //支付宝支付处理
    Route::post('alipay/return','AlipayController@result'); //支付后跳转页面
    Route::any('/goods/changePrice/{id}', 'HomeController@changePrice');   //申请降价
    /**
     * 我是买家
     */
    Route::get('/needsPublish', 'UserController@needsPublish')->name('needsPublish');    //发布求购
    Route::get('/all_game/pushGame', 'CommonController@pushGame');   //发布游戏接口
    Route::any('/needs/FillNeedsOrder', 'UserController@FillNeedsOrder');   //发布表单填写
    Route::get('/user/dk', 'UserController@dk')->name('my_dk');   //我购买的点卡
    Route::get('/user/goods', 'UserController@goods')->name('my_buy_goods');   //我购买的商品
    Route::delete('/user/goods/cancel/{id}', 'UserController@goodsCancel');   //我购买的商品   取消购买商品
    Route::delete('/user/goods/sure/{id}', 'UserController@goodsSure');   //我购买的商品   确认收货
    Route::get('/user/needs', 'UserController@needs')->name('my_needs');   //我发布的求购
    Route::any('/user/needs/Finish', 'UserController@needsFinish');   //发布的求购
    Route::get('/user/needsOrder', 'UserController@needsOrder')->name('my_needs_order');   //我的求购订单
    Route::get('/user/changePrice', 'UserController@changePrice')->name('my_changePrice');   //我的求降价信息
    Route::any('/user/address/{id?}', 'UserController@address')->name('my_address');   //我的收货信息
    Route::get('/user/orderDetail', 'UserController@orderDetail');   //订单详情
    Route::delete('/user/goods/goodsOffSale/{id}', 'UserController@goodsOffSale');   //商品下架

    Route::delete('/user/changePrice/status/{id}', 'UserController@changePriceStatus');   //拒绝或撤销降价
    /**
     * 我是卖家
     */
    Route::any('/user/sell', 'UserController@sell')->name('sell');   //我要出售  选择游戏
    Route::any('/user/sell/next', 'UserController@sellNext');   //出售 流程
    Route::get('/user/MySell', 'UserController@MySell')->name('my_sell');   //我发布的商品
    Route::get('/user/SellOrder', 'UserController@SellOrder')->name('my_sell_order');   //我出售的商品
    Route::get('/user/EditGoods', 'UserController@EditGoods');   //商品修改
    Route::post('/user/EditGoods', 'UserController@EditGoodsDo');   //商品修改流程
    Route::get('/user/sell/changePriceInfo', 'UserController@changePriceInfo');   //降价信息管理
    /**
     * 账户信息
     */
    Route::any('/user/info', 'UserController@info')->name('my_info');   //基本信息
    Route::any('/user/info/perfect', 'UserController@perfect_info')->name('perfect_info');   //完善信息
    Route::post('/img/upload','CommonController@upload'); //上传
    Route::any('/user/reset_pass','UserController@reset_pass')->name('reset_pass'); //修改密码
    Route::post('/user/reset_pass/update','UserController@reset_pass_update'); //修改密码操作
    Route::post('/user/check_old_pass','UserController@check_old_pass'); //验证原密码
    Route::post('/user/check_answer','UserController@check_answer')->name('check_answer'); //验证密保
    Route::any('/user/question','UserController@question')->name('question'); //修改密保
    Route::any('/user/tel','UserController@tel')->name('tel'); //手机绑定
    Route::any('/user/changePhone','UserController@changePhone'); //选择手机验证方式
    Route::any('/user/changePhone/active','UserController@changePhoneActive'); //更换手机验证
    Route::any('/user/IDCard','UserController@IDCard')->name('IDCard'); //实名认证
    Route::any('/user/bindBank','UserController@bindBank')->name('bindBank'); //银行卡管理
    Route::any('/user/bindBank/add','UserController@bindBankAdd'); //银行卡管理
    Route::any('/user/ip','UserController@Ip')->name('ip'); //ip绑定
    Route::any('/user/EditPayPass','UserController@EditPayPass')->name('EditPayPass'); //修改支付密码
    Route::post('/user/EditPayPass/update','UserController@EditPayPass_update');

    /**
     * 积分中心
     */
    Route::any('/user/integral','UserController@integral')->name('integral'); //积分明细
    Route::any('/user/exchange/list','UserController@ExchangeList')->name('ExchangeList'); //兑换列表

    /**
     * 异常申请
     */
    Route::any('/user/unbindPhone','AbnormalController@unbindPhone'); //解绑手机号申请
    Route::any('/user/unbindPhone/list/{id?}','AbnormalController@unbindPhoneList');//解绑手机申请记录
    Route::any('/user/EditEmail','AbnormalController@EditEmail');//申请修改绑定邮箱
    Route::any('/user/EditEmail/list/{id?}','AbnormalController@EditEmailList');//申请修改绑定邮箱列表
    Route::any('/user/AbnormalCapital','AbnormalController@AbnormalCapital');//资金异常申请
    Route::any('/user/AbnormalCapital/list/{id?}','AbnormalController@AbnormalCapitalList');//资金异常申请列表
    Route::any('/user/AccountName','AbnormalController@AccountName');//开户名修改申请
    Route::any('/user/AccountName/list/{id?}','AbnormalController@AccountNameList');//开户名修改申请列表
    Route::any('/user/unlocked','AbnormalController@unlocked');//帐号解封申请
    Route::any('/user/unlocked/list/{id?}','AbnormalController@unlockedList');//帐号解封申请列表
    /**
     * 资金管理
     */
    Route::get('/user/money/recharge','UserController@recharge')->name('recharge'); //选充值
    Route::any('/user/money/Withdrawal','UserController@Withdrawal')->name('Withdrawal'); //提现
    Route::any('/user/money/info','UserController@MoneyInfo')->name('MoneyInfo'); //资金明细
    
    
    /**
     * 站内信
     */
    Route::get('/user/messages', 'MessagesController@index')->name('messages');
    Route::get('/user/messages/detail/{id}', 'MessagesController@show');
    Route::delete('/user/messages/{id}', 'MessagesController@delete');
});


Route::group(['middleware' => ['web']], function () {
    //后台登录
    Route::get('admin', function (){
        if(!session('users')){
            return redirect('admin/login');
        }else{
            return redirect('admin/index');
        }
    });
    Route::get('admin/login', 'Admin\LoginController@login');
    Route::get('admin/verify', 'Admin\LoginController@verify');
    Route::post('admin/login', 'Admin\LoginController@verify_login');
    /**
     * 点卡接口路由
     */
    Route::get('dk/api/getCategory','DKApiController@getCategory');

    /**
     * 公共方法配置
     */
    Route::post('/admin/img/upload','Admin\CommonController@upload');
    //前台登录注册
    Route::get('login/verify', 'Auth\AuthController@verify');
    Route::auth();   //注册登录路由
    Route::post('auth/postRegister', 'Auth\AuthController@postRegister');  //自定义注册
    Route::any('auth/register_success', 'Auth\AuthController@register_success');  //注册成功，
    Route::post('auth/send_email', 'Auth\AuthController@send_email');  //发送验证邮件
    Route::post('auth/send_reset_email', 'Auth\AuthController@send_reset_email');  //发送重置密码邮件
    Route::post('auth/check_email_code', 'Auth\AuthController@check_email_code');  //发送重置密码邮件
    Route::any('auth/reset', 'Auth\AuthController@reset');  //发送重置密码邮件
    Route::any('auth/send_phone_code', 'Auth\AuthController@send_phone_code');  //发送重置密码邮件

    //Route::get('password/sf_reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/sf_reset', 'Auth\PasswordController@postReset');
    Route::post('password/ResetPassword', 'Auth\PasswordController@ResetPassword');  //重置密码
    Route::post('password/check_email_user', 'Auth\PasswordController@check_email_user');  //检查用户名和邮箱是否对应
    
    Route::any('auth/active_success', 'Auth\AuthController@active_success');  //激活成功
    Route::any('auth/activation', 'Auth\AuthController@activation');  //激活成功
    Route::any('auth/active_success_info', 'Auth\AuthController@active_success_info');  //激活成功
    

    Route::get('/', 'Home\HomeController@index')->name('home');  //跳转路由,首页
    Route::get('/category/{id?}', 'Home\HomeController@category');  //游戏商品列表页


    Route::post('/add_Collection', 'Home\HomeController@add_Collection');
    Route::get('/buy/{id}', 'Home\HomeController@buy');   //购买页
    Route::post('/postBuy', 'Home\HomeController@postBuy');   //生成订单

    Route::get('/pay_order/{order_sn?}','Home\HomeController@pay_order');  //付款页面

    Route::get('/need', 'Home\HomeController@need');   //求购
    Route::get('/need/SellFinish','Home\HomeController@SellFinish');   //求购
    Route::get('/dk_shop', 'Home\DkController@index');   //点卡商城
    Route::any('/dk_shop/dk_order', 'Home\DkController@dk_order');   //点卡订单填写
   // Route::post('/dk_shop/dk_order', 'Home\DkController@dk_order');

    Route::get('/category_zh', 'Home\HomeController@category_zh');   //帐号交易
    Route::get('/help', 'Home\HelpController@index');   //帐号交易
    Route::get('/all_game', 'Home\HomeController@all_game');   //所有游戏
    Route::get('/all_game/GetGameByKey', 'Home\CommonController@GetGameByKey');   //游戏数据获取by首字母
    Route::get('/all_game/GetGameByLevel', 'Home\CommonController@GetGameByLevel');   //游戏数据获取by 搜索
    Route::get('/all_game/GameByKeyword', 'Home\CommonController@GameByKeyword');   //游戏数据获取by 关键词
    Route::get('/center/GetOrderReason', 'Home\CommonController@GetOrderReason');   //订单原因获取
    Route::post('/common/VerifyMobileCode', 'Home\CommonController@VerifyMobileCode');   //实时验证 手机验证码
    Route::post('/common/VerifyEmailCode', 'Home\CommonController@VerifyEmailCode');   //实时验证 邮箱验证码
    Route::post('/common/VerifyEmailUnique', 'Home\CommonController@VerifyEmailUnique');   //验证邮箱，
    Route::post('/common/VerifyPicCode', 'Home\CommonController@VerifyPicCode');   //验证图形验证码
    
    
    Route::get('/goods/{id}', 'Home\HomeController@goods');  //商品详情页
   // Route::any('/search/{id}', 'Home\HomeController@search');  //游戏商品搜索
    Route::get('/exchange','Home\HomeController@exchange')->name('exchange'); //积分商城
    Route::any('/exchange/{id}','Home\HomeController@exchange_info'); //积分商城详细

    Route::get('/news','Home\NewsController@index'); //文章/公告
    Route::get('/news/detail/{id}','Home\NewsController@detail'); //文章/公告 详情
    /**
     * 客服中心
     */
    Route::get('/help/help','Home\HelpController@help'); //帮助中心
    Route::get('/help/SearchArticle','Home\HelpController@SearchArticle'); //帮助中心--文章搜索
    Route::get('/help/cate/{id}','Home\HelpController@cate'); //帮助中心  小分类
    Route::get('/help/detail/{id}','Home\HelpController@detail'); //帮助中心  内容详细
    Route::get('/help/ask','Home\HelpController@ask'); //投诉建议，提问
    Route::get('/help/ask/type','Home\HelpController@ask_type'); //选择投诉建议类别
    Route::any('/help/ask/{id}','Home\HelpController@ask_detail'); //填写投诉建议页面
    Route::get('/help/ask/list/{id}','Home\HelpController@ask_list'); //小类问题列表页
    Route::get('/help/ask/MyList/{id}','Home\HelpController@ask_MyList'); //我的问题列表页
    Route::get('/help/ask/detail/{id}','Home\HelpController@ask_reply'); //问题详情页
    Route::get('/help/safe','Home\HelpController@safe'); //安全中心
    Route::get('/help/safe/news/list/{id?}','Home\HelpController@safe_news'); //安全中心_信息
    Route::get('/help/safe/news/detail/{id}','Home\HelpController@safe_news_detail'); //安全中心_信息详情
    Route::get('/help/safe/Verification','Home\HelpController@verification');  //验证中心
    Route::post('/help/safe/test','Home\HelpController@safe_test');  //验证中心

    Route::get('excel/exportMoneyInfo','ExcelController@exportMoneyInfo');
    Route::get('excel/exprotSellInfo','ExcelController@exprotSellInfo');

    Route::get('excel/import','ExcelController@import');


    /**
     * 点卡接口
     */
    Route::get('dk/dk_game_list','Admin\DKApiController@getGameDkList');   //直冲游戏信息
    Route::get('dk/dk_game_info','Admin\DKApiController@getGameInfo');   //具体商品信息
    Route::get('dk/dk_game_info_local','Admin\DKApiController@getGameInfoLocal');   //具体商品信息
    Route::get('dk/dk_game_info_by','Admin\DKApiController@getGameInfoByCardId');   //具体商品信息
    Route::get('dk/getDkFaceValueList','Admin\DKApiController@getDkFaceValueList');
});

