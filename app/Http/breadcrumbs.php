<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/7
 * Time: 14:04
 * 面包屑 导航
 */

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('首页', route('home'));
});

Breadcrumbs::register('change_price_form', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('求降价申请');
});

Breadcrumbs::register('exchange', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('积分商城',route('exchange'));
});

Breadcrumbs::register('exchange_info', function($breadcrumbs)
{
    $breadcrumbs->parent('exchange');
    $breadcrumbs->push('积分商品明细');
});

Breadcrumbs::register('user', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('我的搜付在线', route('user'));
});

Breadcrumbs::register('needsPublish', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('我要求购', route('needsPublish'));
});


Breadcrumbs::register('needsPublish_select_game', function($breadcrumbs)
{
    $breadcrumbs->parent('needsPublish');
    $breadcrumbs->push('选择游戏');
});

Breadcrumbs::register('needsPublish_form', function($breadcrumbs)
{
    $breadcrumbs->parent('needsPublish');
    $breadcrumbs->push('填写表单');
});


Breadcrumbs::register('my_dk', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我购买的点卡',route('my_dk'));
});

Breadcrumbs::register('my_buy_goods', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我购买的商品',route('my_buy_goods'));
});

Breadcrumbs::register('my_order_detail', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('订单详情');
});

Breadcrumbs::register('my_needs', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我发布的求购',route('my_needs'));
});

Breadcrumbs::register('my_needs_order', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我发布的求购订单',route('my_needs_order'));
});

Breadcrumbs::register('my_changePrice', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我的求降价信息',route('my_changePrice'));
});

Breadcrumbs::register('my_address', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我的收货信息',route('my_address'));
});

Breadcrumbs::register('sell', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('我要卖',route('sell'));

});

Breadcrumbs::register('sell_select_game', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('我要卖',route('sell'));
    $breadcrumbs->push('选择种类');
});

Breadcrumbs::register('sell_form', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('我要卖',route('sell'));
    $breadcrumbs->push('填写表单');
});

Breadcrumbs::register('my_sell', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我发布的商品',route('my_sell'));
});

Breadcrumbs::register('my_sell_edit', function($breadcrumbs)
{
    $breadcrumbs->parent('my_sell');
    $breadcrumbs->push('修改商品');
});

Breadcrumbs::register('my_sell_order', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我出售的商品',route('my_sell_order'));
});


Breadcrumbs::register('my_info', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我的基本信息',route('my_info'));
});

Breadcrumbs::register('IDCard', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('实名认证',route('IDCard'));
});

Breadcrumbs::register('bindBank', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('银行卡管理',route('bindBank'));
});

Breadcrumbs::register('bindBank_add', function($breadcrumbs)
{
    $breadcrumbs->parent('bindBank');
    $breadcrumbs->push('绑定银行卡');
});

Breadcrumbs::register('tel', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('手机绑定',route('tel'));
});

Breadcrumbs::register('tel_change', function($breadcrumbs)
{
    $breadcrumbs->parent('tel');
    $breadcrumbs->push('更换手机');
});

Breadcrumbs::register('ip', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('IP绑定',route('ip'));
});

Breadcrumbs::register('reset_pass', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('修改登录密码',route('reset_pass'));
});

Breadcrumbs::register('check_answer', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('验证密保',route('check_answer'));
});

Breadcrumbs::register('question', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('修改密保',route('question'));
});

Breadcrumbs::register('recharge', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('帐号充值',route('recharge'));
});

Breadcrumbs::register('Withdrawal', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('我要提现',route('Withdrawal'));
});

Breadcrumbs::register('MoneyInfo', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('资金明细',route('MoneyInfo'));
});

Breadcrumbs::register('integral', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('积分明细',route('integral'));
});

Breadcrumbs::register('ExchangeList', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('兑换列表',route('ExchangeList'));
});

Breadcrumbs::register('messages', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('站内信',route('messages'));
});



Breadcrumbs::register('AbnormalCapital', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('异常申请');
});


Breadcrumbs::register('perfect_info', function($breadcrumbs)
{
    $breadcrumbs->parent('user');
    $breadcrumbs->push('完善信息',route('perfect_info'));
});