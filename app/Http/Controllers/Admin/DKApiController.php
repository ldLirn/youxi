<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendMessage;
use App\Http\Controllers\Controller;
use App\Http\Model\DkGame;
use App\Http\Model\DkGameFaceValue;
use App\Http\Model\DkOrderModel;

use App\Http\Model\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

require_once app_path().'/Common/base.php';

/**
 * Class DKApiController
 * @package App\Http\Controllers\Admin
 * 点卡管理
 * 点卡接口
 */
class DKApiController extends Controller
{
    public $userid;
    public $userpws;
    public $keystr;

    /**
     * DKApiController constructor.
     * @param string $userid
     * @param string $userpws
     * @param string $keystr
     */
    public function __construct($userid="",$userpws="",$keystr=''){
        $this->userid = config('dk_config.userid');
        $this->userpws = config('dk_config.userpws');
        $this->keystr = config('dk_config.keystr');
    }

    /**
     * 点卡游戏列表
     */
    public function dk_game_list()
    {
        
        $data =  DB::table('dk_game_list')->Paginate(15);
        return view('admin.dk.dk_game_list',compact('data'));
    }

    /**
     * @param $id
     * 点卡游戏修改
     */
    public function dk_game_edit($id)
    {
        if(!isset($id) || !is_numeric($id)){
            return back()->with('msg','不存在的游戏');
        }
        if(Input::Method()=='POST'){
            $input = Input::all();
            if($input['cardname']==''){
                return back()->with('msg','点卡游戏名称不能为空');
            }
            $status = DkGame::where('cardid',$id)->update(['cardname'=>$input['cardname'],'cardimg'=>$input['thumb']]);
            if($status){
                Cache::forget('dk_game_list');  //清除缓存
                return redirect('admin/dk_game_list')->with('msg','点卡游戏修改成功');
            }else{
                return back()->with('msg',trans('com.system_error'));
            }
        }
        $data = DkGame::where('cardid',$id)->first();
        return view('admin.dk.dk_game_edit',compact('data'));
    }

    /**
     * @param $cardid
     * 点卡游戏面值
     */
    public function dk_game_faceValue($cardid)
    {
        if(!is_numeric($cardid)){
            abort(404);
        }
        $data = DkGameFaceValue::where('pid',$cardid)->get();
        return view('admin.dk.dk_game_faceValue',compact('data'));
    }
    /**
     * 点卡设置
     */
    public function dk_config()
    {
        if(Input::method()=='POST'){
            $input = Input::except('_token');
            $this->putFile($input);
            return back()->with('msg','配置更新成功！');
        }
        return view('admin.dk.dk_config');
    }
    /**
     * @param $input
     * 点卡订单列表
     */
    public function dk_list()
    {
        $data = DkOrderModel::with('user')->orderBy('time','desc')->Paginate(15);
        return view('admin.dk.dk_list',compact('data'));
    }

    /**
     * @param $sporder_id
     * @return \Illuminate\Http\RedirectResponse
     * 更新订单状态
     */
    public function dk_sure($sporder_id)
    {
        $result = $this->order_confirm($sporder_id);
        $game_state = Input::get('game_state');
        if(!is_numeric($game_state)){
            return back()->with('msg',trans('com.not_allow_operation'));
        }
        if($result==-1){
            return back()->with('msg','查不到此订单，请联系欧飞人工核实');
        }
        if($game_state==$result){
            return back()->with('msg','订单状态暂无更新');
        }
        if(DkOrderModel::where('sporder_id',$sporder_id)->update(['game_state'=>$result])){
            return back()->with('msg','订单状态更新成功');
        }else{
            return back()->with('msg',trans('com.system_error'));
        }
    }

    /**
     * @param $sporder_id
     * 订单详情
     */
    public function dk_order_detail($id)
    {
        try{
            $data = DkOrderModel::with('user')->findOrFail($id);
        }catch(\Exception $e){
            return back()->with('msg','不存在的订单ID');
        }
        return view('admin.dk.dk_order_detail',compact('data'));
    }

    /**
     * @param $id
     * 退款
     */
    public function dk_order_refund($id)
    {
        try{
            $data = DkOrderModel::findOrFail($id);
        }catch(\Exception $e){
            return back()->with('msg','不存在的订单ID');
        }
        $result = $this->order_confirm($data['sporder_id']);
        if($result==9 || $data['pay_status']==2){   //允许退款
            try{
                DB::transaction(function () use($data){
                    $account['user_id'] = $data['user_id'];
                    $account['money'] = $data['ordercash'];
                    $account['change_time'] = time();
                    $account['change_desc'] = '点卡订单'.$data['sporder_id'].' 退款';
                    $account['change_type'] ='2';
                    DB::table('account_log')->insert($account);
                    DB::table('users')->where('id',$data['user_id'])->increment('money',$data['ordercash']);
                    DB::table('dk_order')->update(['order_status'=>2]);   //标识已退款
                });
            }catch(\Exception $e){
                return back()->with('msg',trans('com.system_error'));
            }
            Log::info(session('users.admin_name') . '订单='.$data['sporder_id'].'退款:'.$data['ordercash']);
            Event::fire(new SendMessage($data['user_id'],'user.order_refund',$data['sporder_id'],$data['ordercash'],'',''));
            Cache::forget('user_info_'.$data['user_id']);
            return back()->with('msg','退款成功');
        }else{
            return back()->with('msg','订单有误，请联系欧飞人工核实');
        }
    }
    /**
     * 改变状态  AJAX
     */
    public function change()
    {
        $id = intval(Input::get('id'));
        $status = intval(Input::get('status'));
        if ($status == '1') {
            $status = DB::table('dk_game_list')->where('id', $id)->update(['is_show' => '2']);
            Cache::forget('dk_game_list');  //清除缓存
        } else {
            $status = DB::table('dk_game_list')->where('id', $id)->update(['is_show' => '1']);
            Cache::forget('dk_game_list');  //清除缓存
        }
        if ($status) {
            return '1';
        } else {
            return '2';
        }
    }

    /**
     * @return string
     * 面值 上下架
     */
    public function change_on_sale()
    {
        $id = intval(Input::get('id'));
        $status = intval(Input::get('status'));
        $pid = intval(Input::get('pid'));
        $type = intval(Input::get('type'));
        switch($type){
            case 1;
                $where = 'is_on_sale';
                break;
            case 2;
                $where = 'is_recommend';
                break;
            case 3;
                $where = 'is_hot';
                break;
        }
        if ($status == '1') {
            $status = DB::table('dk_game_faceValue')->where('id', $id)->update(["$where" => '2']);
        } else {
            $status = DB::table('dk_game_faceValue')->where('id', $id)->update(["$where" => '1']);
        }
        if ($status) {
            Cache::forget('dk_game_list');  //清除缓存
            Cache::forget('dk_game_list_faceValue_'.$pid);
            Cache::forget('dk_hot');
            Cache::forget('rand_12');
            return '1';
        } else {
            return '2';
        }
    }

    /**
     * @param $cardid
     * 修改面值
     */
    public function dk_game_faceValue_edit($cardid)
    {
        $cardid = intval($cardid);
        $data = DkGameFaceValue::where('cardid',$cardid)->first();
        if(Input::method()=='POST'){
            $input = Input::except('_token');
            $status = DkGameFaceValue::where('cardid',$cardid)->update($input);
            if($status){
                Cache::forget('dk_game_list_faceValue_'.$data['pid']);
                return redirect('admin/dk_game_faceValue/'.$data['pid'])->with('msg','点卡面值修改成功');
            }else{
                return back()->with('msg',trans('com.system_error'));
            }
        }
        return view('admin.dk.dk_game_faceValue_edit',compact('data'));
    }
    /**
     * 点卡订单搜索
     */
    public function search()
    {
        $input = Input::all();
        $where = '';
        if($input['order_sn']!=='' && $input['user_name']=='' && $input['order_status']==''){
            $where = ["sporder_id"=>$input['order_sn']];
        }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']==''){
            $user_id = $this->UserId($input['user_name']);
            $where = ["sporder_id"=>$input['order_sn'],'user_id'=>$user_id];
        }elseif($input['order_sn']!='' && $input['user_name']!='' && $input['order_status']!=''){
            $user_id = $this->UserId($input['user_name']);
            $where = ["sporder_id"=>$input['order_sn'],'user_id'=>$user_id,'game_state'=>$input['order_status']];
        }elseif($input['order_sn']!='' && $input['user_name']=='' && $input['order_status']!=''){
            $where = ["sporder_id"=>$input['order_sn'],'game_state'=>$input['order_status']];
        }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']==''){
            $user_id = $this->UserId($input['user_name']);
            $where = ['user_id'=>$user_id];
        }elseif($input['order_sn']=='' && $input['user_name']!='' && $input['order_status']!=''){
            $user_id = $this->UserId($input['user_name']);
            $where = ['user_id'=>$user_id,'game_state'=>$input['order_status']];
        }elseif($input['order_sn']=='' && $input['user_name']=='' && $input['order_status']!=''){
            $where = ['game_state'=>$input['order_status']];
        }
        $data = DkOrderModel::where($where)->Paginate(15);
        return view('admin.dk.dk_list',compact('data'));
    }

    /**
     * 游戏搜索
     */
    public function game_search()
    {
        $keywords = Input::get('cardname');
        if(Input::get('is_show')!==null){
            $is_show = Input::get('is_show');
            $data = DB::table('dk_game_list')->where('is_show',$is_show)->Paginate(13);
        }else{
            $data = DB::table('dk_game_list')->where('cardname','like','%'.$keywords.'%')->Paginate(13);
        }
        return view('admin.dk.dk_game_list',compact('data'));
    }

    /**
     * 同步游戏列表
     * @param $input
     */
    public function update_dk_game_list()
    {
        $arr = $this->getGameDkList();
        DB::table('dk_game_list')->delete(); //删除所有
        DB::table('dk_game_faceValue')->delete(); //删除所有

        foreach($arr as $v){
            DB::table('dk_game_list')->insert(['cardid'=>$v['cardid'],'cardname'=>$v['cardname']]);
            $data = $this->getGameInfoByCardId($v['cardid']);
            Cache::forget('dk_game_list_faceValue_'.$v['cardid']);
            if (count($data) == count($data, 1)) {
                if(isset($data['retcode']) && $data['retcode']!=1){
                    DkGameFaceValue::insert(['pid'=>$v['cardid'],'cardname'=>$data['err_msg']]);
                }else{
                    DkGameFaceValue::insert(['pid'=>$data['subclassid'],'cardid'=>$data['cardid'],'innum'=>$data['innum'],'cardname'=>$data['cardname'],'amounts'=>$data['amounts'],'memberprice'=>$data['memberprice'],'pervalue'=>$data['pervalue'],'accountdesc'=>serialize($data['accountdesc'])]);
                }
            }else{
                foreach($data as $n){
                    DkGameFaceValue::insert(['pid'=>$n['subclassid'],'cardid'=>$n['cardid'],'innum'=>$n['innum'],'cardname'=>$n['cardname'],'amounts'=>$n['amounts'],'memberprice'=>$n['memberprice'],'pervalue'=>$n['pervalue'],'accountdesc'=>serialize($n['accountdesc'])]);
                }
            }
        }
        Cache::forget('dk_game_list');  //清除缓存
        return back()->with('msg','同步成功');
    }

    /**
     * 将配置信息写入文件
     * @param $input
     */
    protected function putFile($input)
    {
        $config = $input;
        $path = base_path().'\config\dk_config.php';
        $str = '<?php return '.var_export($config,true).';';
        file_put_contents($path,$str);
    }


    public function order_confirm($sporder_id)
    {
        $url = 'http://apitest.ofpay.com/api/query.do';
        $data['userid'] = $this->userid;
        $data['spbillid'] = $sporder_id;
        $result = $this->curl_post($url,$data);
        return $result;
    }
    /**
     * 点卡 订单查询接口
     * @param string $starttime  查询开始时间
     * @param string $endtime    结束时间
     * @param string $cardid     订单编号  不填查询为全部
     * @param string $orderstat  订单状态 0:充值中 1:成功 2:失败 3:成功和失败 4:所有 5:充值中和成功 (不传默认为5)
     * @param string $classtype  类目编号 0:所有1:话费 2:流量 3:游戏 4:卡密 5:加油卡 6:金融 7:公共事业 8:交通罚款 （不传默认为0）
     */
    public function dk_order($starttime='',$endtime='',$cardid='',$orderstat=4,$classtype=3)
    {
        $url = 'http://apitest.ofpay.com/querybill.do';
        $starttime = $starttime==''?'20161201':$starttime;
        $endtime = $endtime==''?date('Ymd',time()):$endtime;
        $data['userid'] = $this->userid;
        $data['userpws'] = md5($this->userpws);
        $data['cardid'] = $cardid;
        $data['orderstat'] = $orderstat;
        $data['classtype'] = $classtype;
        $data['starttime'] = $starttime;
        $data['endtime'] = $endtime;
        $data['version'] = '6.0';
        //md5 加密字符串
        $str = $data['userid'].$data['userpws'].$data['cardid'].$data['starttime'].$data['endtime'];
        $str_add = $str.$this->keystr;
        //userid+userpws+cardid+starttime+endtime
        $data['md5_str'] = strtoupper(md5($str_add));
        $result = $this->curl_post($url,$data);
        //dd($result);
        $result = mb_convert_encoding($result, "utf-8", "gb2312");
       // $result = $this->xmlToArray($result);
        return $result;
    }

    /**
     * 游戏直冲游戏列表
     * $cardid  需查询商品的编码（支持2位，4位编码，2位表示该大类下的所有商品，4位是具体的小类商品） (21 游戏卡密、22 游戏直充)
     */
    public function getGameDkList($cardid=22)
    {
        $url = "http://apitest.ofpay.com/querylist.do";
        $data['cardid'] = $cardid;
        $data['userid'] = $this->userid;
        $data['userpws'] = md5($this->userpws);
        $data['version'] = '6.0';
        $result = $this->curl_post($url,$data);
        $result = $this->xmlToArray($result);
        if($result['retcode']==1){
            return $result['ret_cardinfos']['card'];
        }else{
            return $result['err_msg'];
        }
    }

    /**
     * 取得商品具体信息
     * @param $game_id
     */
    public function getGameInfo()
    {
        $game_id = Input::get('game_id');
        $callback = Input::get('callback');
        $url = 'http://apitest.ofpay.com/querycardinfo.do';
        $data['cardid'] = $game_id;
        $data['userid'] = $this->userid;
        $data['userpws'] = md5($this->userpws);
        $data['version'] = '6.0';
        $result = $this->curl_post($url,$data);
        $result = $this->xmlToArray($result);
        if(isset($result['err_msg']) && $result['err_msg']){
            $arr[0]['cardname'] = $result['err_msg'];
            $arr[0]['cardid'] = '';
            echo $callback.'('.json_encode($arr).')';
            die;
        }
        if(count($result['ret_cardinfos']['card']) == count($result['ret_cardinfos']['card'],1)) {
            $result_arr[0] = $result['ret_cardinfos']['card'];//  echo "是一维";
        }else{
            $result_arr = $result['ret_cardinfos']['card'];
        }
        echo $callback.'('.json_encode($result_arr).')';
        die;
        //return $result;
    }

    /**
     * 取得商品具体信息
     * @param $game_id
     */
    public function getGameInfoLocal()
    {
        $game_id = Input::get('game_id');
        $callback = Input::get('callback');
        if(!Cache::has('dk_game_list_faceValue_'.$game_id)){
            $result_arr = DkGameFaceValue::where('pid',$game_id)->get()->toArray();
            Cache::forever('dk_game_list_faceValue_'.$game_id,$result_arr);
        }
        $result_arr = Cache::get('dk_game_list_faceValue_'.$game_id);
        echo $callback.'('.json_encode($result_arr).')';
        die;
        //return $result;
    }
    /**
     * 取得商品具体信息
     * @param $game_id
     */
    public function getGameInfoByCardId($cardid)
    {
        $url = 'http://apitest.ofpay.com/querycardinfo.do';
        $data['cardid'] = $cardid;
        $data['userid'] = $this->userid;
        $data['userpws'] = md5($this->userpws);
        $data['version'] = '6.0';
        $result = $this->curl_post($url,$data);
        $result = $this->xmlToArray($result);

        if($result['retcode']!=1){
            return $result;
            die;
        }else{
            $result_arr = $result['ret_cardinfos']['card'];
            return $result_arr;
        }
        //return $result;
    }

    /**
     * 取得某个游戏的面值列表
     */
    public function getDkFaceValueList()
    {
        $cardid = intval(Input::get('cardid'));
        $callback = Input::get('callback');
        $data = DkGameFaceValue::where('pid',$cardid)->where('is_on_sale',1)->get()->toArray();
        echo $callback.'('.json_encode($data).')';
        die;
    }
    /**
     * 获取具体区服信息
     * @param $game_id
     */
    public function getGameQu($game_id)
    {
        $url = 'http://apitest.ofpay.com/getareaserver.do';
        $data['gameid'] = $game_id;
        $result = $this->curl_post($url,$data);
        $result = $this->xmlToArray($result);
        if(isset($result['ERR_MSG'])!=''){
            return $result;
            die;
        }
        return $result;
    }

    /**
     * 充值接口
     * @param $cardid
     * @param $cardnum   数量
     * @param $sporder_id   订单id
     * @param $game_userid  充值账户
     */
    public function sendOrder($cardid,$cardnum,$game_userid)
    {
        $url = 'http://apitest.ofpay.com/onlineorder.do';
        $data['userid'] = $this->userid;
        $data['userpws'] = md5($this->userpws);
        $data['version'] = '6.0';
        $data['cardid'] = $cardid;
        $data['cardnum'] = $cardnum;
        $data['sporder_id'] = 'DK'.date('YmdHis',time()).mt_rand(10000,100000);
        $data['sporder_time'] = date('YmdHis',time());
        $data['game_userid'] = $game_userid;
        //包体=userid+userpws+cardid+cardnum+sporder_id+sporder_time+ game_userid+ game_area+ game_srv
        $str = $data['userid'].$data['userpws'].$data['cardid'].$data['cardnum'].$data['sporder_id'].$data['sporder_time'].$data['game_userid'];
        $str_add = $str.$this->keystr;
        $data['md5_str'] = strtoupper(md5($str_add));
        $result = $this->curl_post($url,$data);
        $result = $this->xmlToArray($result);
        if(isset($result['ERR_MSG'])!=''){
            return $result;
            die;
        }else{
            return $result;  //如果成功为1，澈消(充值失败)为9，充值中为0,只能当状态为9时，商户才可以退款给用户。
        }
    }
    /**
     * 发起HTTPS请求
     *
     * @param string $url
     * @param mixed $data
     * @param mixed $header
     * @param mixed $post
     *
     * @return mixed
     */
    public function curl_post($url, $data=array(), $post = 1)
    {
        ini_set('max_execution_time', '0');
        $header =  array("charset=GBK");
        //初始化curl
        $ch = curl_init();
        //参数设置
        $res = curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, $post);
        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_TIMEOUT,600);   //只需要设置一个秒的数量就可以
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        //连接失败
        if ($result === false) {
            if ($this->BodyType === 'json') {
                $result = '{"statusCode":"172001","statusMsg":"网络错误"}';
            } else {
                $result = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Response><statusCode>172001</statusCode><statusMsg>网络错误</statusMsg></Response>';
            }
        }
        curl_close($ch);
        return $result;
    }


    public function curl_get($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT,30);   //设置超时
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        if ($output === false) {
            $output = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Response><statusCode>172001</statusCode><statusMsg>网络错误</statusMsg></Response>';
        }
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
       // $output = mb_convert_encoding($output,"utf-8","gbk");
        $xml = simplexml_load_string($output);
        $data = json_decode(json_encode($xml),TRUE);
        return $data;
    }


    /**
     *   解析xml到数组
     */
    function xmlToArray($xml){
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }

    //根据用户名取得用户id
    public function UserId($name)
    {
        $user = User::where('name',$name)->select('id')->first();
        if($user){
            return $user->id;
        }else{
           return '';
        }
    }
}
