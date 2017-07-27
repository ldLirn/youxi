var gameType = 0;
var arr = ["游戏区", "游戏服", "分类", " "];
var SellType = [{ "TypeName": "所有商品", "Type": "a" }, { "TypeName": "寄售商品", "Type": "s" }, { "TypeName": "担保商品", "Type": "d" }, { "TypeName": "账号交易", "Type": "c" }];
$(function () {
    var base_url  = $('#base_url').val();
	$.browser = {};
	$.browser.mozilla = /firefox/.test(navigator.userAgent.toLowerCase());
	$.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
	$.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
	$.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
    //ie6 div覆盖input
    (function ($) { $.fn.bgiframe = ($.browser.msie && /msie 6\.0/i.test(navigator.userAgent) ? function (s) { s = $.extend({ top: 'auto', left: 'auto', width: 'auto', height: 'auto', opacity: true, src: 'javascript:false;' }, s); var html = '<iframe class="bgiframe"frameborder="0"tabindex="-1"src="' + s.src + '"' + 'style="display:block;position:absolute;z-index:-1;' + (s.opacity !== false ? 'filter:Alpha(Opacity=\'0\');' : '') + 'top:' + (s.top == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderTopWidth)||0)*-1)+\'px\')' : prop(s.top)) + ';' + 'left:' + (s.left == 'auto' ? 'expression(((parseInt(this.parentNode.currentStyle.borderLeftWidth)||0)*-1)+\'px\')' : prop(s.left)) + ';' + 'width:' + (s.width == 'auto' ? 'expression(this.parentNode.offsetWidth+\'px\')' : prop(s.width)) + ';' + 'height:' + (s.height == 'auto' ? 'expression(this.parentNode.offsetHeight+\'px\')' : prop(s.height)) + ';' + '"/>'; return this.each(function () { if ($(this).children('iframe.bgiframe').length === 0) this.insertBefore(document.createElement(html), this.firstChild); }); } : function () { return this; }); $.fn.bgIframe = $.fn.bgiframe; function prop(n) { return n && n.constructor === Number ? n + 'px' : n; } })(jQuery);
    $("#game_select").bgiframe();
    $("#game_select_close").click(function () { $("#game_select").hide(); });
    //var ismall = window.ismall || 0;//0普通1会员商城2点券商城 3批量发布游戏配置
    $("#search_ul .select").each(function (i, v) {
        $(v).attr("_id", i);
        if (i == 0) {
            $(v).click(function () {
                gameType = $(v).attr("_id");
                $("#game_select").show().find("#select_content_tab").show();
                $("#select_content_tab a").unbind("click").click(function () {
                    $("#select_content").html('游戏读取中...<br/>&nbsp;');
                    $("#select_content_tab .current").removeClass("current");
                    $(this).addClass("current");
                    $.ajax({
						url:base_url+'/all_game/GetGameByKey',
						data: { key: $(this).text() },
						dataType:"jsonp",
						jsonp:"callback",
						success:function (val) {
                        var temp = "";
                        var level = i + 1;
                        $.each(val, function (i, v) {
                            temp += "<li><a id='" + v.id + "' level='" + level + "' go='" + v.id + "' g='" + v.id + "' " + (v.is_hot=="1" ? " class='dark-red'" : "") + " title='" + v.game_name + "'>" + SubString(v.game_name, 9) + "</a></li>";
                        });
                        $("#select_content").html(temp == "" ? "<li style='background:none;'>没有游戏</li>" : temp);
                        AttrGameTypeEvent();
                    }
					});
                });
                $("#select_content_tab a").eq(0).click();
            });
        }
        else if (i > 0) {
            $(v).click(function () {
                gameType = $(v).attr("_id");
                $("#game_select").show().find("#select_content_tab").hide();
                if (gameType == 4) {
                    var SellTypehtml = "";
                    $.each(SellType, function (i, v) {
                        SellTypehtml += "<li><a id='" + v.Type + "' go='" + v.Type + "' title='" + v.TypeName + "'>" + SubString(v.TypeName, 9) + "</a></li>";
                    });
                    $("#select_content").html(SellTypehtml);
                    AttrGameTypeEvent();
                    return;
                }
                $("#select_content").html(" 游戏读取中...<br/>&nbsp;");
                var pid = $("#search_ul .select").eq(i - 1).attr('_gid') == "" ? "没有分类" : $("#search_ul .select").eq(i - 1).attr('_gid');
                var gameid = $("#search_ul .select").eq(0).attr('_gid') == "" ? "没有分类" : $("#search_ul .select").eq(0).attr('_gid');
                if (i == 3)
                    pid = gameid;
				$.ajax({
						url:base_url+'/all_game/GetGameByLevel',
						data: { level: i + 1, parentId: pid },//ismall = 3批量发布游戏配置,显示商品属性为游戏币和点券的商品类型，和会员商城属性相同
						dataType:"jsonp",
						jsonp:"callback",
						success:function (data) {
							var level = i + 1;
							var html = "";
							$.each(data, function (i, v) {
							   // if (v.Properties != "直冲点券") { return true; }//点券商城跳过非直冲点券属性的
								html += "<li><a id='" + v.id + "' level='" + level + "' go='" + v.id + "' g='" + v.id + "' " + (v.is_hot=='1' ? " class='dark-red'" : "") + " title='" + v.game_name + "'>" + SubString(v.game_name, 9) + "</a></li>";
							});
							html = html == "" ? "<li><span>暂无对应" + arr[gameType - 1] + "</span></li>" : html;
							$("#select_content").html(html);
							AttrGameTypeEvent();
						}
					});
            });
        }
    });

    var dataref = $("#search_ul").attr("data-ref");
    if (dataref == "1") {
        SellType = [{ "TypeName": "寄售商品", "Type": "s" }, { "TypeName": "担保商品", "Type": "d" }];
    }

    //游戏类型事件
    function AttrGameTypeEvent() {
        $("#select_content a").unbind("click").click(function () {
            var v = $(this);
            $("#search_ul .select").eq(gameType).attr("_gid", gameType < 5 ? v.attr("g") : v.attr("id")).html("<span class=\"w70\">" + v.text() + "</span>");
            for (var i = parseInt(gameType) + 1; i < 4; i++) {
                $("#search_ul .select").eq(i).html("选择" + arr[i - 1]);
                $("#search_ul .select").eq(i).attr("_gid","");
            }
            if ($(this).attr("level") == 1) {
                $("#searchgame").val($(this).attr("go"));
                $("#searcharea").val("");
                $("#searchserver").val("");
                $("#searchtype").val("");
                //$("#SellType").val("");
            }
            else if ($(this).attr("level") == 2) {
                $("#searcharea").val($(this).attr("go"));
                $("#searchserver").val("");
                //$("#SellType").val("");
            }
            else if ($(this).attr("level") == 3) {
                $("#searchserver").val($(this).attr("go"));
                //$("#SellType").val("");
            }
            else if ($(this).attr("level") == 4) {
                $("#searchtype").val($(this).attr("go"));
                //$("#SellType").val("");
            } else {
                $("#SellType").val($(this).attr("go"));
            }
            $("#game_select").hide();
            if (gameType != 3)
                $("#search_ul .select").eq(gameType).next().click();
            return false;
        });
    }
    function SubString(res, n) {
        if (res.length > n) {
            return res.substr(0, n) + "...";
        }
        else return res;
    }
});
