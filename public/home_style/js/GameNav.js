//鼠标hover延迟jquery插件
/*! 
* jQuery.mouseDelay.js v1.2 
* http://www.planeart.cn/?p=1073 
* Copyright 2011, TangBin 
* Dual licensed under the MIT or GPL Version 2 licenses. 
*/ 
(function ($, plugin) { 
var data = {}, id = 1, etid = plugin + 'ETID'; 
// 延时构造器 
$.fn[plugin] = function (speed, group) { 
id ++; 
group = group || this.data(etid) || id; 
speed = speed || 150; 
// 缓存分组名称到元素 
if (group === id) this.data(etid, group); 
// 暂存官方的hover方法 
this._hover = this.hover; 
// 伪装一个hover函数，并截获两个回调函数交给真正的hover函数处理 
this.hover = function (over, out) { 
over = over || $.noop; 
out = out || $.noop; 
this._hover(function (event) { 
var elem = this; 
clearTimeout(data[group]); 
data[group] = setTimeout(function () { 
over.call(elem, event); 
}, speed); 
}, function (event) { 
var elem = this; 
clearTimeout(data[group]); 
data[group] = setTimeout(function () { 
out.call(elem, event); 
}, speed); 
}); 
return this; 
}; 
return this; 
}; 
// 冻结选定元素的延时器 
$.fn[plugin + 'Pause'] = function () { 
clearTimeout(this.data(etid)); 
return this; 
}; 
// 静态方法 
$[plugin] = { 
// 获取一个唯一分组名称 
get: function () { 
return id ++; 
}, 
// 冻结指定分组的延时器 
pause: function (group) { 
clearTimeout(data[group]); 
} 
}; 
})(jQuery, 'mouseDelay'); 

//GameNav
(function(window,$,undefined){
	var searBase = $("#baseurl").val();
	var gameUrl = "/category/id";
	var getGameUrl = function(gameid){
	    return searBase + (gameUrl.replace('id', gameid));
	};
	var game=function(attr,value,flag){
		$.extend(Array.prototype,{
			indexOf:function( val ){ for(var i=0;i<this.length;i++){ if(this[i]==val){ return i; } } return -1; },
			contains:function( val ){ return this.indexOf(val)!=-1;},
			put:function( val ){ if(this.contains(val)) return; else this.push(val); },
			remove:function( val ){ var index = this.indexOf(val); if(index==-1) return; this.splice(index,1); } 
		});
		this.inited = false;
		this.cacheSlectData = {};
		this.init();
	}
	$.extend(game.prototype,{
		init : function () {
			if(this.inited){
				return ;
			}

			var href = window.location.href;
			href = href.substring(href.indexOf("?s=")).replace("?s=","");
			this.key = "热门";
			if (/^[a-zA-Z]$/.test(href)) {
			    this.key = href;
			}

			this.evenBind();
			if (this.key != "热门") {
			    this.getGames(this.key);
			}
			this.inited = true;
		},
		getGames:function(key){
		    var rets = [], that = this;
			var cache = that.cacheSlectData["game" + key];
			if (cache) { that.setGameData(cache); } else {
                
			    $.ajax({
			        type: 'get',
			        url: searBase+'/all_game/GetGameByKey',
			        data: { key: key },
			        dataType: 'jsonp',
			        jsonp: "callback",
			        success: function (data) {
			            that.cacheSlectData["game" + key] = data;
			            rets = data;
			            that.setGameData(data);
			        }
			    });
			}
		},
		evenBind: function () {
		    var that = this;
		    $("#hotgame_content_tab a").hover(function () {
		        that.getGames($(this).attr("ref"));
		        $("#hotgame_content_tab a.current").removeClass("current");
		        $(this).addClass("current");
		        $('#hotgame_content').show();
		    });
		    $("#hotgame_section").unbind().bind("mouseleave", function () {
		        $('#hotgame_content').hide();
		        $("#hotgame_content_tab a.current").removeClass("current");
		    });
			//this.getGames(that.key);
			
		},
		setGameData: function (hots) {
		    var Html = '';
		    $.each(hots, function (i, item) {
		        var cls = "";
		        if ((item.is_hot) == '1') { cls = "class='red'" };
		        Html += '<li><a ' + cls + ' href="' + getGameUrl(item.id) + '" >' + item.game_name + '</a></li>';
		    });
		    if (Html == "") {
		        Html = "<li><a href='javascript:void(0);'>暂无游戏</a></li>";
		    }
		    $('#hotgame_content').html(Html);
		}
	});
	window.GameNav = game;
})(window,jQuery);