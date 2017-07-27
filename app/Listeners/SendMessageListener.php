<?php

namespace App\Listeners;

use App\Events\SendMessage;
use Fenos\Notifynder\Facades\Notifynder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SendMessageListener
 * @package App\Listeners
 * 发送站内信
 */
class SendMessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */


    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SendMessage  $event
     * @return void
     */
    public function handle(SendMessage $event)
    {
        $to_user_id = $event->to_user_id;
        $category = $event->category;
        $order_sn = $event->order_sn;
        $name = $event->name;
        $money = $event->money;
        $goods_code = $event->goods_code;
        Notifynder::category($category)
            ->from(3)
            ->to($to_user_id)
            ->url('http://'.web_url.'/user/message')
            ->extra(compact('order_sn','money','name','goods_code'))
            ->send();
    }
}
