<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsGame extends Model
{
    protected $table="goods_game";
    //protected $primaryKey="";
    protected $guarded=[];
    public $timestamps = true;


    //游戏
    public function game()
    {
        return $this->hasOne('App\Http\Model\Game', 'id', 'game_id');
    }
    //游戏区服信息
    public function DaQu()
    {
        return $this->hasOne('App\Http\Model\GameQu', 'id', 'qu_id');
    }
    public function XiaQu()
    {
        return $this->hasOne('App\Http\Model\GameQu', 'id', 'game_qu_id');
    }
    //游戏类型
    public function hasManyType()
    {
        return $this->hasOne('App\Http\Model\GameType', 'id', 'goods_type_id');
    }
    //商品游戏帐号信息
    public function game_user_info()
    {
        return $this->hasOne('App\Http\Model\GameUserInfo', 'goods_id', 'id');
    }

    //商品图片信息
    public function goods_pic()
    {
        return $this->hasMany('App\Http\Model\GoodsPicture', 'goods_id', 'id');
    }
    
    //发布人
    public function user()
    {
        return $this->hasOne('App\Http\Model\User', 'id', 'user_id');
    }
    
    //游戏分类
    public function game_cate()
    {
        return $this->hasOne('App\Http\Model\CateGame','id','cate_id');
    }

    /**
     * @return array
     * 添加数据处理
     */
//    public function lists($where)
//    {
//        return DB::table('goods_game')->
//        join('game', 'goods_game.game_id', '=', 'game.id')->
//        //join('game_qu', 'goods_game.qu_id', '=', 'game_qu.id')->
//        join('game_qu', 'goods_game.game_qu_id', '=', 'game_qu.id')->
//        join('game_type', 'goods_game.goods_type_id', '=', 'game_type.id')->
//        join('users', 'goods_game.user_id', '=', 'users.id')->
//        select('goods_game.*','game.game_name','game_qu.qu_name','game_type.type','users.name')->
//        where('traded_type',$where)->where('is_trash','0')->Paginate(1);
//    }
}
