<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Model\AdModel;
use App\Http\Model\DkGame;
use App\Http\Model\ExchangeOrder;
use App\Http\Model\Game;
use App\Http\Model\GameQu;
use App\Http\Model\GameType;
use App\Http\Model\GoodsGame;
use App\Http\Model\MailLog;
use App\Http\Model\Order;
use App\Http\Model\OrderAction;
use App\Http\Model\User;
use App\Http\Model\UserRank;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Vinkla\Hashids\Facades\Hashids;
use PhpSms;
use Toplan\Sms\Facades\SmsManager;
require app_path().'/Common/base.php';
require_once app_path().'\org\code\Code.class.php';


/**
 * Class CommonController
 * @package App\Http\Controllers\Home
 * 前台 公用
 */
class CommonController extends Controller
{
    /**
     * 检测用户名是否存在
     */
    protected function check_name()
    {
        $name = Input::get('name');
        if(User::where('name',$name)->first()){
            return 'y';
        }
    }

    /**
     *   广告代码
     *   $id 广告位id
     */
    protected function getAdByPosition($id,$num=1)
    {
        $num = $num==1?'':$num;
        if($num){
            $ad ='';
            $ewm = AdModel::with('position')->where('position_id',$id)->where('is_open','0')->get()->toArray();
            foreach ($ewm as $v){
                $ad[] = "<a href='".$v['ad_url']."' target='_black'><img src='".$v['ad_code']."'  width='".$v['position']['adp_width']."' height='".$v['position']['adp_height']."' alt='".$v['ad_name']."'></a>";
            }
        }else{
            $ewm = AdModel::with('position')->where('position_id',$id)->where('is_open','0')->first()->toArray();
            $ad = "<a href='".$ewm['ad_url']."' target='_black'><img src='".$ewm['ad_code']."'  width='".$ewm['position']['adp_width']."' height='".$ewm['position']['adp_height']."' alt='".$ewm['ad_name']."'></a>";
        }
        return $ad;
    }

    /**
     *   广告代码
     *   $id 广告id
     */
    protected function getAdById($id)
    {
        $ewm = AdModel::with('position')->where('id',$id)->where('is_open','0')->first()->toArray();
        $ad = "<a href='".$ewm['ad_url']."' target='_black'><img src='".$ewm['ad_code']."'  width='".$ewm['position']['adp_width']."' height='".$ewm['position']['adp_height']."' alt='".$ewm['ad_name']."'></a>";
        return $ad;
    }

    /**
     * 参数加密
     * @param $str
     * @return mixed
     */
    protected function newbase64_en($str){
        $str = str_replace('/','@',str_replace('+','-',base64_encode($str)));
        return $str;
    }
    /**
     * 参数解密
     * @param $str
     * @return mixed
     */
    protected function newbase64_de($str){
        $encode_arr = array('UTF-8','ASCII','GBK','GB2312','BIG5','JIS','eucjp-win','sjis-win','EUC-JP');
        $str = base64_decode(str_replace('@','/',str_replace('-','+',$str)));
        $encoded = mb_detect_encoding($str, $encode_arr);
        $str = iconv($encoded,"utf-8",$str);
        return $str;
    }

    /**
     * 取得游戏 根据首字母,根据类型
     */
    protected function getGameByFirst($type){
        $str = letter;
        $data = '';
        if(!Cache::has('getGameByFirst')){
            $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->where('cate_id',$type)->orderBy('is_recommend','desc')->get()->toArray();
            foreach ($gameData as $k=>$v){
                $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
            }
            foreach ($gameData as $k=>$v){
                for ($i=0;$i<26;$i++){
                    if(substr($v['display_name'],0,1)==$str[$i]){
                        $data[$str[$i]][] = $v;
                    }else{
                        $data[$str[$i]][] = '';
                    }
                }
            }
            foreach($data as $k=>$v){
                $data[$k] = array_filter($v);
            }
            ksort($data);
            Cache::forever('getGameByFirst',$data);
        }
        $data = Cache::get('getGameByFirst');
        return $data;
    }

    protected function getDkGameByFirst(){
        $str = Letter;
        $data = '';
        if(!Cache::has('getDkGameByFirst')){
            $gameData = $this->getDkGameList();
            foreach($gameData as $k=>$v){
                $gameData[$k]->display_name = $this->getfirstchar($v->cardname);
            }
            foreach ($gameData as $k=>$v){
                for ($i=0;$i<26;$i++){
                    if(substr($v->display_name,0,1)==$str[$i]){
                        $data[$str[$i]][] = $v;
                    }else{
                        $data[$str[$i]][] = '';
                    }
                }
            }
            foreach($data as $k=>$v){
                $data[$k] = array_filter($v);
            }
            ksort($data);
            Cache::forever('getDkGameByFirst',$data);
        }
        $data = Cache::get('getDkGameByFirst');
        return $data;
    }
    /**
     * 取得所有游戏 根据首字母
     */
    protected function getAllGameByFirst(){
        $str = letter;
        $data = '';

        if(!Cache::has('gameData_all')){
            $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->orderBy('is_recommend','desc')->get()->toArray();
            foreach ($gameData as $k=>$v){
                $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
            }
            foreach ($gameData as $k=>$v){
                for ($i=0;$i<26;$i++){
                    if(substr($v['display_name'],0,1)==$str[$i]){
                        $data[$str[$i]][] = $v;
                    }
                }
            }
            ksort($data);

            Cache::forever('gameData_all',$data);
        }
        $gameData = Cache::get('gameData_all');

        return $gameData;
    }

    /**
     * 取得免费游戏
     */
    protected function getGameByFree(){
        if(!Cache::has('freeGame')){
            $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot','is_free')->where('is_free','1')->where('cate_id','1')->orderBy('is_recommend','desc')->get()->toArray();
            foreach ($gameData as $k=>$v){
                $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
            }
            Cache::forever('freeGame',$gameData);
        }
        $gameData = Cache::get('freeGame');
        return $gameData;
    }

    /**
     * 返回热门游戏数据
     *
     */
    protected function returnHot($game,$callback){
        if(empty($game)){
            echo $callback.'([])';
        }else{
            echo $callback.'('.json_encode($game).')';
        }
    }
    /**
     * 游戏列表 by 游戏首字母
     */
    public function GetGameByKey()
    {
        $key = strtolower(Input::get('key'));
        $callback = Input::get('callback');
        if($key=='免费游戏'){
            $game = $this->getGameByFree();
            $this->returnHot($game,$callback);
        }elseif ($key=='热门游戏'){
            if(Input::get('type')===null){
                $game = $this->getGameByHot(1);
                $this->returnHot($game,$callback);
            }else{
                if(Input::get('type')=='全部游戏'){
                    $game = $this->getAllGameByHot();
                    $this->returnHot($game,$callback);
                }elseif(Input::get('type')=='网络游戏'){
                    $game = $this->getGameByHot(1);
                    $this->returnHot($game,$callback);
                }elseif (Input::get('type')=='手机游戏'){
                    $game = $this->getGameByHot(3);
                    $this->returnHot($game,$callback);
                }elseif(Input::get('type')=='网页游戏'){
                    $game = $this->getGameByHot(2);
                    $this->returnHot($game,$callback);
                }
            }
        }else{
            $game = $this->getGameByFirst(1);
            if(isset($game[$key]) && $game[$key]!=''){
                echo $callback.'('.json_encode($game[$key]).')';
            }else{
                echo $callback.'([])';
            }
        }
    }
    /**
     * 游戏搜索  根据；level
     */
    public function GetGameByLevel()
    {
        $level = intval(Input::get('level'));
        $game_id = $this->getId(Input::get('parentId'));
        $callback = Input::get('callback');
       // dd(Input::all());
        if($level=='2'){   //查找大区数据
           $game_qu = $this->getGameDu($game_id);
            if(empty($game_qu)){
                echo $callback.'([])';
            }else{
                echo $callback.'('.json_encode($game_qu).')';
            }
        }elseif ($level=='3'){
            $game_qu = $this->getGameFwq($game_id);
            if(empty($game_qu)){
                echo $callback.'([])';
            }else{
                echo $callback.'('.json_encode($game_qu).')';
            }
        }elseif ($level=='4'){
            $game_qu = $this->getGameType($game_id);
            if(empty($game_qu)){
                echo $callback.'([])';
            }else{
                echo $callback.'('.json_encode($game_qu).')';
            }
        }
    }

    /**
     *  游戏搜索  by  高级搜索 关键词
     */
    public function GameByKeyword()
    {
        $keyword = Input::get('keyword');
        $callback = Input::get('callback');
        if(preg_match("/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u",$keyword)){
            $game = Game::where('game_name','like','%'.$keyword.'%')->select('id','game_name','display_name','is_recommend','is_hot')->get()->toArray();
            foreach ($game as $k=>$v){
                $game[$k]['id'] = Hashids::encode($game[$k]['id']);
            }
            echo $callback.'('.json_encode($game).')';
        }else{
            echo $callback.'([])';
        }
    }

    /**
     *     发布商品接口
     */
    public function pushGame(){
        $gCase =  Input::get('gCase');
        $pID = Input::get('pID');
        $callback = Input::get('callback');
        switch ($gCase){
            case '1':   //取得所有游戏数据
                if(!Cache::has('all_game')){
                    $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot','is_free')->orderBy('display_name','asc')->get()->toArray();
                    foreach ($gameData as $k=>$v){
                        $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
                    }
                    Cache::forever('all_game',$gameData);
                }
                $game = Cache::get('all_game');
                break;
            case '2':   //获取大区数据
                $game_id = $this->getId($pID);
                $game = $this->getGameDu($game_id);
                break;
            case '3': //获取服务器
                $game_id = $this->getId($pID);
                $game = $this->getGameFwq($game_id);
                break;
            case '4':   //获取选中游戏的类型
                $game_id = $this->getId($pID);
                $game = $this->getGameType($game_id);
                break;
            case '0':   //交易类型
                $game = array(0=>['id'=>'s','game_name'=>'寄售交易','display_name'=>'jsjy','is_free'=>'0','Level'=>'0','pID'=>$pID],1=>['id'=>'d','game_name'=>'担保交易','display_name'=>'dbjy','is_free'=>'0','Level'=>'0','pID'=>$pID]);
                break;
        }
        if(!empty($game)){
            echo $callback.'('.json_encode($game).')';
        }else{
            echo $callback.'([])';
        }
    }

    /**
     * 取得订单原因接口
     */
    public function GetOrderReason()
    {
        $callback = Input::get('callback');
        $order_id =  Input::get('OrderId');
        $order_status = Input::get('orderSt');
        if($order_status=='-1'){
            $res = GoodsGame::where('id',$order_id)->select('error_reson')->first();
        }elseif ($order_status=='-2'){
            $res = ExchangeOrder::where('id',$order_id)->select('note')->first();
        }else{
            $res = OrderAction::where('order_id',$order_id)->where('order_status',$order_status)->select('action_note')->first();
        }
        echo $callback.'('.json_encode($res).')';
    }
    /**
     * 游戏所有大区数据
     */
    protected function getGameDu($id){
        $game_qu = GameQu::where('game_id',$id)->where('pid','0')->get()->toArray();
        foreach ($game_qu as $k=>$v){
            $game_qu[$k]['game_name'] = $v['qu_name'];
            $game_qu[$k]['id'] = Hashids::encode($game_qu[$k]['id']);
            $game_qu[$k]['display_name'] = $this->Pinyin($v['qu_name']);
        }
        return $game_qu;
    }

    /**
     * 游戏所有服务器数据
     */
    protected function getGameFwq($qu_id){
        $game_qu = GameQu::where('pid',$qu_id)->get()->toArray();
        foreach ($game_qu as $k=>$v){
            $game_qu[$k]['game_name'] = $v['qu_name'];
            $game_qu[$k]['id'] = Hashids::encode($game_qu[$k]['id']);
            $game_qu[$k]['display_name'] = $this->Pinyin($v['qu_name']);
        }
        return $game_qu;
    }

    /**
     * 商品类型
     */
    protected function getGameType($game_id){
        $game_qu = GameType::where('game_id',$game_id)->get()->toArray();
        foreach ($game_qu as $k=>$v){
            $game_qu[$k]['game_name'] = $v['type'];
            $game_qu[$k]['id'] = Hashids::encode($game_qu[$k]['id']);
            $game_qu[$k]['display_name'] = $this->Pinyin($v['type']);
            $game_qu[$k]['game_id'] = Hashids::encode($game_id);
        }
        return $game_qu;
    }

    /**
     * 取得热门游戏   by  游戏平台类型
     */
    protected function getGameByHot($type){

        $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->where('is_hot','1')->where('cate_id',$type)->orderBy('is_recommend','desc')->get()->toArray();
            foreach ($gameData as $k=>$v){
                $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
            }
        return $gameData;
    }

    /**
     * 取得推荐游戏   by  类型名
     * type      类型名
     * cate_id  平台类型id
     * $limit   读取条数
     */
    protected function getRecommendGameByType($type,$cate_id,$limit){
        $game_id = GameType::where('type',$type)->lists('game_id')->toArray();
        $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->where('is_recommend','1')->where('cate_id',$cate_id)->whereIn('id',$game_id)->orderBy('is_recommend','desc')->limit($limit)->get()->toArray();
        foreach ($gameData as $k=>$v){
            $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
        }
        return $gameData;
    }

    /**
     * 取得 新增游戏  by 平台类型id
     */
    protected function getNewGameByType($cate_id,$limit){
        $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->where('is_recommend','1')->where('cate_id',$cate_id)->orderBy('created_at','desc')->limit($limit)->get()->toArray();
        foreach ($gameData as $k=>$v){
            $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
        }
        return $gameData;
    }

    /**
     * 取得所有热门游戏
     */
    protected function getAllGameByHot(){
        if(!Cache::has('hotGame_all')){
            $gameData = Game::select('id','game_name','display_name','is_recommend','is_hot')->where('is_hot','1')->orderBy('is_recommend','desc')->get()->toArray();
            foreach ($gameData as $k=>$v){
                $gameData[$k]['id'] = Hashids::encode($gameData[$k]['id']);
            }
            Cache::forever('hotGame_all',$gameData);
        }
        $gameData = Cache::get('hotGame_all');
        return $gameData;
    }
    /**
     * top 5
     * 卖的最好的
     */
    public function top5()
    {
        $id = DB::select('select goods_id,count(*) from sf_order group by goods_id order by count(*) desc limit 5 ');
        if($id){
            foreach ($id as $v){
                $aa[] = $v->goods_id;
            }
            $game_id = GoodsGame::whereIn('id',$aa)->lists('game_id')->toArray();
            return Game::whereIn('id',$game_id)->select('id','game_name')->get()->toArray();
        }else{
            return Game::where('is_hot',1)->select('id','game_name')->orderBy('game_order','asc')->limit(3)->get()->toArray();
        }

    }
    
    /**
     * 游戏数据缓存
     */
    protected function getCondition($id)
    {
        if (Game::where('id', $id)->first()) {
            if (!Cache::has('condition_'.$id)) {   //判断筛选信息缓存
                $condition = (new Game())->with('hasManyQu', 'hasManyType','hasManySType')->where('id', $id)->select('id', 'game_name')->first()->toArray();
                foreach($condition['has_many_s_type'] as $m=>$n){
                    $condition['has_many_s_type'][$m]['data'] = $this->getQuData($n['data']);
                }
                Cache::forever('condition_'.$id, $condition);
            }
            $condition = Cache::get('condition_'.$id);  //筛选信息数据
            return $condition;
        }else{
            return abort(503);
        }
    }
    
    /**
     * 判断交易类型
     */
    protected function traded_type($input){
        if($input=='s')
        {
            $traded_type='0';
        }elseif ($input=='d')
        {
            $traded_type='1';
        }elseif ($input=='q')
        {
            $traded_type='2';
        }else{
            return abort(503);
        }
        return $traded_type;
    }
    

    
    /**
     * 解密id 字符串
     */
    protected function getId($id){
        try{
            $id = Hashids::decode($id);
            $id = $id[0];
            $data =  $id;
        }catch(\Exception $e){
            $data = 'NOT FOUND';
        }
           return $data;
    }

    /**
     * 缓存游戏详细信息
     */
    protected function GetGameById($id){
        if(!Cache::has('goods_detail_'.$id)){
            try{
                GoodsGame::findOrFail($id);
                $data = GoodsGame::with('DaQu', 'XiaQu','game', 'game_user_info', 'hasManyType','goods_pic')->where('id', $id)->where('is_trash', '0')->select()->first()->toArray();
                Cache::forever('goods_detail_'.$id,$data);
            }catch(\Exception $e){
                return [];
            }
        }
        $data = Cache::get('goods_detail_'.$id);
        return $data;
    }

    /**
     * 得到用户信息
     */
    protected function getUser($id=''){
        if($id===0){
            $user['id'] = 0;
            return $user;
        }
        if($id==''){
            $id = Auth::user()->id;
        }
        if($id==''){
            return redirect('/login?redirectUrl='.url()->full());
        }
        if(!Cache::has('user_info_'.$id)){
            $user = User::where('id',Auth::user()->id)->first()->toArray();
            Cache::forever('user_info_'.$id,$user);
        }
        $user = Cache::get('user_info_'.$id);
        $userNotified = User::find($user['id']);
        $user['messages'] = $userNotified->countNotificationsNotRead();
        return $user;
    }


    /**
     *  订单号生成
     */
    public function orderSn($type='')
    {
        $order_sn = $type. date('YmdHis',time()).'-'.mt_rand(10000,100000);  //生成订单编号
        return $order_sn;
    }
    /**
     * @param $_String
     * @param string $_Code
     * @return string
     * 商品编号生成
     */
    public function GoodsCode($game_goods_type_id)
    {
        $chinese = GameType::where('id',$game_goods_type_id)->pluck('type')->toArray();
        $re = $this->Pinyin($chinese[0]);
        $goods_code =  strtoupper($re). date('YmdHis',time()).'-'.mt_rand(10000,100000);  //生成商品编号
        return $goods_code;
    }

    //汉字转拼音
    public function Pinyin($_String, $_Code='utf-8')
    {
        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
            "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
            "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
            "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
            "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
            "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
            "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
            "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
            "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
            "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
            "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
            "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
            "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
            "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
            "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
            "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
            "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
            "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
            "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
            "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
            "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
            "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
            "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
            "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
            "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
            "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
            "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
            "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
            "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
            "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
            "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
            "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
            "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
            "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
            "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
            "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
            "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
            "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
            "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
            "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
            "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
            "|-10270|-10262|-10260|-10256|-10254";
        $_TDataKey = explode('|', $_DataKey);
        $_TDataValue = explode('|', $_DataValue);
        $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : $this->_Array_Combine($_TDataKey, $_TDataValue);
        //-------------------中文转拼音--------------------------------//
        arsort($_Data);
        reset($_Data);
        if($_Code != 'gb2312') $_String = $this->_U2_Utf8_Gb($_String);
        $_Res = '';
        for($i=0; $i<strlen($_String); $i++)
        {
            $_P = ord(substr($_String, $i, 1));
            if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
            $_Res .= substr($this->zh_to_py($_P, $_Data),0,1);
        }
        return strtoupper(preg_replace("/[^a-z0-9]*/", '', $_Res));

    }
    function _Pinyin($_Num, $_Data)
    {
        if ($_Num>0 && $_Num<160 ) return chr($_Num);
        elseif($_Num<-20319 || $_Num>-10247) return '';
        else {
            foreach($_Data as $k=>$v){ if($v<=$_Num) break; }
            return $k;
        }
    }

    //-------------------中文转拼音--------------------------------// 
    function zh_to_py($num, $_Data) {
        if($num>0 && $num<160 ) {
            return chr($num);
        } elseif ($num<-20319||$num>-10247) {
            return '';
        } else {
            foreach ($_Data as $py => $code) {
                if($code <= $num) break;
            }
            return $py;
        }
    }

    function _U2_Utf8_Gb($_C)
    {
        $_String = '';
        if($_C < 0x80) $_String .= $_C;
        elseif($_C < 0x800)
        {
            $_String .= chr(0xC0 | $_C>>6);
            $_String .= chr(0x80 | $_C & 0x3F);
        }elseif($_C < 0x10000){
            $_String .= chr(0xE0 | $_C>>12);
            $_String .= chr(0x80 | $_C>>6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        } elseif($_C < 0x200000) {
            $_String .= chr(0xF0 | $_C>>18);
            $_String .= chr(0x80 | $_C>>12 & 0x3F);
            $_String .= chr(0x80 | $_C>>6 & 0x3F);
            $_String .= chr(0x80 | $_C & 0x3F);
        }
        return iconv('UTF-8', 'GB2312', $_String);
    }
    function _Array_Combine($_Arr1, $_Arr2)
    {
        for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
        return $_Res;
    }

    private function getfirstchar($s0){
        $s=iconv('UTF-8','gb2312', $s0);
        if (ord($s0)>128) { //汉字开头
            $asc=ord($s{0})*256+ord($s{1})-65536;
            if($asc>=-20319 and $asc<=-20284)return "A";
            if($asc>=-20283 and $asc<=-19776)return "B";
            if($asc>=-19775 and $asc<=-19219)return "C";
            if($asc>=-19218 and $asc<=-18711)return "D";
            if($asc>=-18710 and $asc<=-18527)return "E";
            if($asc>=-18526 and $asc<=-18240)return "F";
            if($asc>=-18239 and $asc<=-17923)return "G";
            if($asc>=-17922 and $asc<=-17418)return "I";
            if($asc>=-17417 and $asc<=-16475)return "J";
            if($asc>=-16474 and $asc<=-16213)return "K";
            if($asc>=-16212 and $asc<=-15641)return "L";
            if($asc>=-15640 and $asc<=-15166)return "M";
            if($asc>=-15165 and $asc<=-14923)return "N";
            if($asc>=-14922 and $asc<=-14915)return "O";
            if($asc>=-14914 and $asc<=-14631)return "P";
            if($asc>=-14630 and $asc<=-14150)return "Q";
            if($asc>=-14149 and $asc<=-14091)return "R";
            if($asc>=-14090 and $asc<=-13319)return "S";
            if($asc>=-13318 and $asc<=-12839)return "T";
            if($asc>=-12838 and $asc<=-12557)return "W";
            if($asc>=-12556 and $asc<=-11848)return "X";
            if($asc>=-11847 and $asc<=-11056)return "Y";
            if($asc>=-11055 and $asc<=-10247)return "Z";
        }else if(ord($s)>=48 and ord($s)<=57){ //数字开头
            switch(substr($s,0,1))
            {
                case 1:return "Y";
                case 2:return "E";
                case 3:return "S";
                case 4:return "S";
                case 5:return "W";
                case 6:return "L";
                case 7:return "Q";
                case 8:return "B";
                case 9:return "J";
                case 0:return "L";
            }
        }else if(ord($s)>=65 and ord($s)<=90){ //大写英文开头
            return substr($s,0,1);
        }else if(ord($s)>=97 and ord($s)<=122){ //小写英文开头
            return strtoupper(substr($s,0,1));
        }
        else
        {
            return iconv_substr($s0,0,1,'utf-8');//中英混合的词语，不适合上面的各种情况，因此直接提取首个字符即可
        }

    }
    /**
     * 买家成交总数
     */
    protected function buy_sum($id){
        if($id==0){
            $buy_sum = 0;
        }else{
            $buy_sum = Order::where('user_id',$id)->where('order_status','3')->count();  //买家成交总数
        }
        return $buy_sum;
    }
    
    /**
     * 卖家成交总数
     */
    protected function sell_sum($id){
        $goods_id = GoodsGame::where('user_id',$id)->lists('id')->toArray();   //发布的商品id
        $sell_sum = Order::whereIn('goods_id',$goods_id)->where('order_status','3')->count();  //卖家成交总数
        return $sell_sum;
    }
    
    /**
     * 会员等级
     */
    protected function vip_level($point){
        $rank = UserRank::where('min_points','<=',$point)->where('max_points','>=',$point)->select('rank_name','rank_img','max_issue','max_time','max_changePrice')->first()->toArray();
        return $rank;
    }

    //图片上传功能
    public function upload()
    {
        $file = Input::file('Filedata');
        if($file -> isValid()){        //检验一下上传的文件是否有效.
            $clientName = $file -> getClientOriginalName();  //获取文件名称
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = md5(date('ymdhis').$clientName).".".$entension;
            $path = $file -> move(base_path().'/public/uploads',$newName);
            $img_url = '/public/uploads/'.$newName;
            return $img_url;
        }
    }
    
    /**
     * 短信验证码验证
     */
    protected function verifyCode($all){
        //验证数据
        $validator = Validator::make($all, [
            'verifyCode' => 'required|verify_code',
        ],[
            'verifyCode.required'=>trans('com.no_code'),
            'verifyCode.verify_code'=>trans('com.error_code'),
        ]);
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $validator;
        }else{
            return true;
        }
    }

    /**
     * @return array
     * 添加数据处理
     */
    public function getQuData($arr)
    {

        $quData = json_decode($arr,true);
        // dd($quData);
        /*
         * 对区服数据进行处理
         */
        $qu = '';
        foreach ($quData['name'] as $k=>$v) {
            $qu[$k][] = $v;

            foreach ($quData['value'] as $m => $n) {
                if ($k === $m) {
                    $n = array_filter($n); //去掉数组中的空元素
                    $qu[$k][]['son'] = $n;
                }
            }
        }
        return $qu;
    }
    
    /**
     * 实时验证验证码
     */
    public function VerifyMobileCode()
    {
        $all = Input::all();
        $validator = Validator::make($all, [
            'param' => 'required|verify_code',
        ],[
            'param.required'=>trans('com.no_code'),
            'param.verify_code'=>trans('com.error_code'),
            'param.zh_mobile'=>trans('com.error_mobile'),
        ]);
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $data=[
                'status'=>'n',
                'info' =>trans('com.error_code')
            ];
        }else{
            return $data=[
                'status'=>'y',
                'info' =>''
            ];
        }
    }

    /**
     * 实时验证邮箱验证码
     */
    public function VerifyEmailCode()
    {
        $code = Input::get('param');
        $email = Input::get('uid');
        $get_code = MailLog::where('email',$email)->first();
        if($get_code['activationcode']==$code){
            if(strtotime('-30minutes ')>$get_code['create_time']){
                return $data=[
                    'status'=>'n',
                    'info' =>trans('com.time_code')
                ];
            }else{
                MailLog::where('email',$email)->delete();
                return $data=[
                    'status'=>'y',
                    'info' =>''
                ];
            }
        }else{
            return $data=[
                'status'=>'n',
                'info' =>trans('com.error_code')
            ];
        }
    }

    /**
     * 实时验证  图像验证码
     */
    public function VerifyPicCode()
    {
        $verify = new \Code();
        $code = $verify->get();
        $userInput = Input::get('param');
        if ($code != strtoupper($userInput)) {
          return $data = [
              'status'=>'n',
              'info'  =>trans('com.error_code')
          ];
        }else{
            return $data = [
                'status'=>'y',
                'info'  =>''
            ];
        }
    }
    
    /**
     * 验证邮箱是否正确，是否唯一
     */
    public function VerifyEmailUnique()
    {
        $email = Input::get('e');
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            if(User::where('email',$email)->select('id')->first()){
                return $data = [
                    'status' =>'-2',
                    'info'   =>trans('com.has_email')
                ];
            }else{
                return $data = [
                    'status' =>'1',
                    'info'   =>$this->newbase64_en($email)
                ];
            }
        }else{
            return $data = [
                'status' =>'-1',
                'info'   =>trans('com.error_email')
            ];
        }
    }

    /**
     * 判断资料是否齐全
     */
    protected function is_($url){
        if(Auth::user()->pay_password=='' && Auth::user()->question==''){
            echo '<script> if(confirm( "请先完善资料，再进行操作 "))  location.href="/user/info/perfect?redirectUrl='.$url.'";else history.back(-1); </script>';
        }
    }
    
    /**
     * 数字转化为货币类型
     */
    function format_money( $STR )
    {
        if ( $STR == "" )
        {
            return "";
        }
        if ( $STR == ".00" )
        {
            return "0.00";
        }
        $TOK = strtok( $STR, "." );
        if ( strcmp( $STR, $TOK ) == "0" )
        {
            $STR .= ".00";
        }
        else
        {
            $TOK = strtok( "." );
            $I = 1;
            for ( ;    $I <= 2 - strlen( $TOK );    ++$I    )
            {
                $STR .= "0";
            }
        }
        if ( substr( $STR, 0, 1 ) == "." )
        {
            $STR = "0".$STR;
        }
        return $STR;
    }


    /**
     * 点卡游戏列表
     */
    public function getDkGameList()
    {
        if(!Cache::has('dk_game_list')){
            $data = DB::table('dk_game_list')->where('is_show',1)->get();
            Cache::forever('dk_game_list',$data);
        }
       $list = Cache::get('dk_game_list');
        return $list;
    }
    /**
     * 用户资金操作
     */
    protected function AccountUser(){
        
    }
}
