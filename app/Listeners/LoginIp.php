<?php

namespace App\Listeners;

use App\Events\AuthLgin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;


/**
 * Class LoginIp
 * @package App\Listeners
 * 记录登录ip
 */
class LoginIp
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuthLgin  $event
     * @return void
     */
    public function handle(AuthLgin $event)
    {
        $post = $event->post;
        $address = $this->Get_Ip_From($post['ip']);
        if($address) {
            $add['time'] = $post['login_time'];
            $add['ip'] = $address['ip'];
            $add['address'] = $address['region'] . $address['city'] . $address['isp'];
            $add = serialize($add);
            if ($info = DB::table('user_ip')->select('ip_info')->where('user_id', $post['user_id'])->first()) {
                $arr = explode('*', $info->ip_info);
                if (count($arr) == 10) {
                    $arr[0] = $add;
                    $a = implode('*', $arr);
                    DB::table('user_ip')->where('user_id', $post['user_id'])->update(['ip_info' => $a]);
                } else {
                    $a = $info->ip_info . '*' . $add;
                    DB::table('user_ip')->where('user_id', $post['user_id'])->update(['ip_info' => $a]);
                }
            } else {
                DB::table('user_ip')->insert(['user_id' => $post['user_id'], 'ip_info' => $add]);
            }
        }
    }


    //获得本地真实IP
    function get_onlineip() {
        $ip_json = @file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=myip");
        $ip_arr=json_decode(stripslashes($ip_json),1);
        if($ip_arr['code']==0)
        {
            return $ip_arr['data']['ip'];
        }

    }

////根据ip获得访客所在地地名
    function Get_Ip_From($ip=''){
        if(empty($ip) || $ip=='127.0.0.1' || preg_match("/^(10|172.16|192.168)./i",$ip)){
            $ip = $this->get_onlineip();
        }
        $ip_json=@file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip);//根据taobao ip
        $ip_arr=json_decode($ip_json,true);
        if($ip_arr['code']==0)
        {
            return $ip_arr['data'];
        }
        else
        {
            return false;
        }

    }


}
