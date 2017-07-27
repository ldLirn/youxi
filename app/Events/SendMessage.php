<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendMessage extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $to_user_id;
    public $category;
    public $order_sn;
    public $name;
    public $money;
    public $goods_code;

    public function __construct($to_user_id,$category,$order_sn='',$money='',$name='',$goods_code='')
    {
        $this->to_user_id = $to_user_id;
        $this->category = $category;
        $this->order_sn = $order_sn;
        $this->name = $name;
        $this->money = $money;
        $this->goods_code = $goods_code;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
