var sellHistoryCookieName = "_sell_his";
function addSellHistory(name) {
    var gameHistory = getCookie(sellHistoryCookieName);
    var sellparam = "";
    $(".Bitem a.ahover").each(function () {
        var obj = $(this);
        var gc = GetGcType(obj.attr("gc"));
        var guid = obj.attr("guid");
        sellparam += gc + "=" + guid + "&";
    });
    //没有记录历史
    if (gameHistory == null || gameHistory == "") {
        gameHistory = sellparam + "," + name;
        SetCookie(sellHistoryCookieName, gameHistory);
        return;
    }
    //有重复记录
    var games = gameHistory.split('|');
    var i;
    for (i = 0; i < games.length; i++) {
        if (games[i].split(',')[0] == sellparam) {
            var temp = games[i];
            for (j = i; j < games.length - 1; j++) {
                games[j] = games[j + 1];
            }
            games[j] = temp;
            SetCookie(sellHistoryCookieName, games.join("|").toString());
            return;
        }
    }
    //记录过5条
    if (games.length < 5) {
        gameHistory = sellparam + "," + name + "|" + gameHistory;
        SetCookie(sellHistoryCookieName, gameHistory);
        return;
    }
    else {
        gameHistory = sellparam + "," + name + "|" + gameHistory.substring(gameHistory.indexOf("|") + 1);
        SetCookie(sellHistoryCookieName, gameHistory);
    }
}
function getSellHistory() {

    var selectHtml = "";
    var sellCookies = (getCookie(sellHistoryCookieName) || "").split("|");
    //cookie格式，param,text|param,text
    if (sellCookies != "") {
        for (var i = 0; i < sellCookies.length; i++) {
            var spiti = sellCookies[i].split(",");
            selectHtml += '<li p="' + spiti[0] + '">' + spiti[1] + '</li>';
        }
    }
    return selectHtml;
}

function SetCookie(name, value)//两个参数，一个是cookie的名，一个是值
{
    var Days = 30;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function getCookie(name)//读取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null) return unescape(arr[2]); return null;
}
//加载第一级游戏
$(function () {
    GetGame(1, "", "");
    $("#G").val("");
    $("#TP").val("");
    $("#TPC").val("");
    $("#T").val("");
    $(".SGameType .Box .Bitem :text").keyup(function () {
        var objs = $(this).next().find("a");
        var key = $(this).val().toLowerCase();
        for (i = 0; i < objs.length; i++) {
            var obj = $(objs[i]);
            if (obj.attr("class").indexOf(key) < 0)
                obj.hide();
            else
                obj.show();
        }
    });
    var hhtml = getSellHistory();
    if (hhtml != "") {
        $("#sell_history").html(hhtml);
    } else {
        $("#sell_history_memo").html("暂无历史记录");
    }
    var getNameValues = function (param) {
        var ret = {};
        //var reg = /(?:^|&)([^=]+?)=([^&]*)(&|$)/g;
        //var match = reg.exec(param);
        //while (match != null && match.length > 0) {
        //    ret.push({ name: match[1], value: match[2] });
        //    match = reg.exec(param);
        //}
        var pas = param.split("&");
        var npVal = "";
        for (var i = 0; i < pas.length; i++) {
            npVal = pas[i].split("=")
            ret[npVal[0]] = npVal[1];
        }
        return ret;
    }
    $("#sell_history li").click(function () {
        var param = $(this).attr("p");
        var nvs = getNameValues(param);
        var _reqobj = $("#reqobj");
        for (var name in nvs) {
            _reqobj.attr("data-" + name, nvs[name]);
        }
        $("#sell_history_memo").html($(this).text());
        $("#sell_history").hide();
        GetGame(1,"","");
    });
    $("#sell_history_title").click(function () {
        if ($("#sell_history li").length == 0) {
            return;
        }
        $("#sell_history").toggle();
    });
    $("#del_history").click(function () {
        $("#sell_history").html("暂无历史记录").hide();
        $("#sell_history_memo").html("暂无历史记录");
        SetCookie(sellHistoryCookieName, "");
    });
    $(document).click(function (e) {//点击其他取消
        if ($(e.target).parents(".quick_search").length == 0) {
            $("#sell_history").hide();
        }
    });
    $("#jc-tsk,#db-tsk,#dbdmj-tsk").each(function () {
        $(this).attr("top", $(this).css("top"));
    });
    $("#nextdiv a").click(function () {
        if ($("#G").val() == "" || $("#T").val() == "" || $("#TP").val() == "") {
            alert("请选择类别.");
            return false;
        }
       var html = $("#buttom_text").text();
       addSellHistory(html);
       $("#nextFrom").submit();

       return false;
    });
});

function GetGcType(gC) {
    var gObj = "";
    if (gC == 4) {
        gObj = "type";
    }
    else if (gC == 1) {
        gObj = "game";
    }
    else if (gC == 0) {
        gObj = "t";
    }
    else if (gC == 6) {
        gObj = "stype";
    }
    else {
        gObj = gC == 2 ? "area" : "server";
    }
    return gObj;
}

var sgc = 0;//子分类
function GetGame(gC, pI, isarea, cateType) {
    if (gC == 4) {
        $(".SGameType .Box .Bitem:gt(1) div").html("");
        $(".SGameType .Box .Bitem:gt(1)").hide();
        $(".SelectGame a:gt(0)").remove();
    }
    else if (gC == 1) {
        $(".SGameType .Box .Bitem:gt(0) div").html("");
        $(".SGameType .Box .Bitem:gt(0)").hide();
        $(".SelectGame a:gt(0)").remove();
    }
    else if (gC == 0) {
        $(".SGameType .Box .Bitem:gt(" + (1 + sgc) + ") div").html("");
        $(".SGameType .Box .Bitem:gt(" + (1 + sgc) + ")").hide();
        $(".SelectGame a:gt(" + (1 + sgc) + ")").remove();
    }
    else if (gC == 2) {
        $(".SGameType .Box .Bitem:gt(" + (gC + sgc) + ") div").html("");
        $(".SGameType .Box .Bitem:gt(" + (gC + sgc) + ")").hide();
        $(".SelectGame a:gt(" + (gC + sgc) + ")").remove();
    }
    else if (gC == 6) {
        $(".SGameType .Box .Bitem:gt(2) div").html("");
        $(".SGameType .Box .Bitem:gt(2)").hide();
        $(".SelectGame a:gt(2)").remove();

    }
    else {
        $(".SGameType .Box .Bitem:gt(" + (gC + sgc + 1) + ") div").html("");
        $(".SGameType .Box .Bitem:gt(" + (gC + sgc + 1) + ")").hide();
        $(".SelectGame a:gt(" + (gC + sgc + 1) + ")").remove();
    }
    var data = { gCase: gC, pID: pI };
    if (cateType) {
        data.cateType = cateType;
    }

    var InitCateItems = function (datas) {
        var html = "";
        $.each(datas, function (i, v) {
            var shoreName = v.display_name;
            shoreName = shoreName.toLowerCase();
            if (gC == "4" || gC == "6")
                html += "<a href='#' pi='" + v.game_id + "' guid='" + v.id + "' area=" + (v.is_free == "1" || isarea == "1" ? "1" : "0") + " gc=" + gC + " class='" + shoreName + "' prop='" + v.Properties + "' ma='" + v.MA + "'>" + v.game_name + "</a>";
            else if (gC == "0")
                html += "<a href='#' pi='" + v.pID + "' guid='" + v.id + "' area=" + (v.is_free == "1" || isarea == "1" ? "1" : "0") + " gc='' class='" + shoreName + "'>" + v.game_name + "</a>";
            else
                html += "<a href='#' pi='" + v.id + "' guid='" + v.id + "' gc=" + gC + " class='" + shoreName + "'>" + v.game_name + "</a>";
        });
        var gObj = GetGcType(gC);
        if (gC == 4) {
            $(".SGameType .Box .Bitem:eq(1) div").html(html == "" ? "没有分类" : html);
            $(".SGameType .Box .Bitem:eq(1)").show();
        }
        else if (gC == 1) {
            $(".SGameType .Box .Bitem:eq(0) div").html(html == "" ? "没有分类" : html);
            $(".SGameType .Box .Bitem:eq(0)").show();
        }
        else if (gC == 0) {
            $(".SGameType .Box .Bitem:eq(" + (2 + sgc) + ") div").html(html == "" ? "没有分类" : html);
            $(".SGameType .Box .Bitem:eq(" + (2 + sgc) + ")").show();
            HoverShowTradeTypeInfo(datas.length);
        }
        else if (gC == 6) {
            if (html == "") {
                GetGame(0, pI, isarea, cateType);
                sgc = 0;
            }
            else {
                $(".SGameType .Box .Bitem:eq(2) div").html(html);
                $(".SGameType .Box .Bitem:eq(2)").show();
                sgc = 1;
            }
        }
        else {
            $(".SGameType .Box .Bitem:eq(" + (gC + sgc + 1) + ") div").html(html == "" ? "没有分类" : html);
            $(".SGameType .Box .Bitem:eq(" + (gC + sgc + 1) + ")").show();
        }
        AttEvent();

        var _reqobj = $("#reqobj");
        var guid = _reqobj.attr("data-" + gObj);
        if (guid) {
            if (gC == 0) { gC = ""; }
            var objc = $(".SGameType").find("a[gc='" + gC + "'][guid=" + guid + "]");
            objc.click();
            var len = objc.parent().find("a").length;
            if (len > 10) {
                objc.parent()[0].scrollTop = (objc.index()) * 24;
            }

            _reqobj.removeAttr("data-" + gObj);
        }
        if ($("#NF1").length < 1) {
            $(".SGameType").find("a[gc=2]").parent().append('<a id="NF1" href="" target="_blank" style="color:#999;" >找不到游戏、区服？</a>');
        }
        if ($("#NF2").length < 1) {
            $(".SGameType").find("a[gc=3]").parent().append('<a id="NF2" href="" target="_blank" style="color:#999;" >找不到游戏、区服？</a>');
        }
    }
    $.ajax({
        type: 'get',
        url: 'http://sfzx.bb.com/all_game/pushGame',
        data: data,
        dataType: 'jsonp',
        jsonp: "callback",
        success: function (data) {

            InitCateItems(data);
        }
    });
}
function SetNextBtn(usable) {
    if (usable) {
        $("#BtSub").removeClass("grey_btn blue_btn").addClass("blue_btn");
    } else {
        $("#BtSub").removeClass("grey_btn blue_btn").addClass("grey_btn");
    }
}

function HoverShowTradeTypeInfo(length) {
    var left = 400;
    $(".SGameType a.jsjy").mouseover(function (e) {
        $("#jc-tsk").css({ left: left + sgc * 155 });
        $("#jc-tsk").show();
    }).mouseout(function() {
        $("#jc-tsk").hide();  
    });
    $(".SGameType a.dbjy").mouseover(function (e) {
        var top = parseInt($("#db-tsk").attr("top")) - (length > 2 ? 0 : 25);

        $("#db-tsk").css({ left: left + sgc * 155, top: top });
        $("#db-tsk").show();
    }).mouseleave(function() {
        $("#db-tsk").hide();  
    });
    // $(".SGameType a.dbdmj").mouseover(function (e) {
    //     var top = parseInt($("#dbdmj-tsk").attr("top")) - (length > 2 ? 0 : 25);
    //     $("#dbdmj-tsk").css({ left: left + sgc * 155, top: top });
    //     $("#dbdmj-tsk").show();
    // }).mouseout(function () {
    //     $("#dbdmj-tsk").hide();
    // });

    $("#jc-tsk,#db-tsk,#dbdmj-tsk").unbind().hover(function () {
        $(this).show();
    }, function () {
        $(this).hide();
    });
}
function AttEvent() {
    $(".SGameType .Box .Bitem a").each(function (i, v) {
        $(v).unbind("click").click(function () {
            if ($(this).attr("id") == "NF1") {
                window.open("");
            }
            else if ($(this).attr("gc") == "1"){
                GetGame(4, $(this).attr("pi"), $(this).attr("area"));
            }
            else if ($(this).attr("gc") == "4") {
                var prop = $(this).attr("prop");
                $("#TPC").val("");//清除子分类
                var ma = $(this).attr("ma");
                if (prop == "代练" || prop == "直冲点券" || prop == "增值服务") {//代练
                    var _this = this;
                    var type = prop == "代练" ? 7 : prop == "增值服务" ? 10 : 1;

                     GetGame(6, $(_this).attr("pi"), $(_this).attr("area"), $(_this).attr("guid"));

                }
                else if ($(this).attr("prop") == "帐号") {
                    $(".SGameType .Box .Bitem:gt(1) div").html("");
                    $(".SGameType .Box .Bitem:gt(1)").hide();
                    $(".SelectGame a:gt(1)").remove();
                    GetGame(2, $(this).attr("pi"), "");
                    $("#IsJh").val("0");
                }
                else if ($(this).attr("prop") == "激活帐号") {
                    $(".SGameType .Box .Bitem:gt(1) div").html("");
                    $(".SGameType .Box .Bitem:gt(1)").hide();
                    $(".SelectGame a:gt(1)").remove();
                    GetGame(2, $(this).attr("pi"), "");
                    $("#IsJh").val("1");
                }
                else if (ma != "") {
                    var _this = this;
                    var idx = ma.indexOf("|");
                    var type = ma.substring(idx + 1);
                    var typeName = ma.substring(0, idx);

                     GetGame(6, $(_this).attr("pi"), $(_this).attr("area"), $(_this).attr("guid"));

                }
                else{
                    GetGame(6, $(this).attr("pi"), $(this).attr("area"), $(this).attr("guid"));
                }

                if ($(this).attr("prop") == "帐号" || $(this).attr("prop") == "激活帐号") {
                    $("#BatchSellAccount").show();
                }
                else {
                    $("#BatchSellAccount").hide();
                }
            }
            else if ($(this).attr("gc") == "6") {
                GetGame(0, $(this).attr("pi"), $(this).attr("area"), $(".SGameType .Box .Bitem:eq(1) div a.ahover").attr("guid"));
            }
            else if ($(this).attr("gc") == "") {
                if ($(this).attr("area") != "1") {
                    if ($(this).attr("prop") == "激活帐号") {
                        $("#IsJh").val("1");
                    }
                    else {
                        $("#IsJh").val("0");
                    }
                    if ($(this).attr("guid") == "3") {//大卖家
                        var _this = this;

                      GetGame(2, $(_this).attr("pi"), $(_this).attr("area"));

                    } else {
                        GetGame(2, $(this).attr("pi"), $(this).attr("area"));
                    }
                }
                else {
                    $(".SGameType .Box .Bitem:gt(" + (2 + sgc) + ") div").html("");
                    $(".SGameType .Box .Bitem:gt(" + (2 + sgc) + ")").hide();
                    $(".SelectGame a:gt(" + (2 + sgc) + ")").remove();
                }
            }
            else if ($(this).attr("gc") != "3") {
                if ($(this).attr("gc") == "2" && $("#TP").val() == "") {
                    $(".SelectGame a:gt(1)").remove();
                }
                GetGame(parseInt($(this).attr("gc")) + 1, $(this).attr("pi"), $(this).attr("area"));
            }
            if ($(this).attr("gc") == "1") {
                $("#TP").val("");
                $("#T").val("");
                $("#G").val("");
                $("#HG").val($(this).attr("guid")); //当选择1级将游戏ID保存隐藏控件
                SetNextBtn(false);
            }
            else if ($(this).attr("gc") == "3") {
                $("#G").val($(this).attr("guid")); //当选择3级将服ID保存隐藏控件
                SetNextBtn(true);
            }
            else if ($(this).attr("gc") == "") {
                if ($(this).attr("guid") == "3") {//大卖家
                    $("#IsDbdmj").val("1");
                    $("#T").val(2);
                } else {
                    $("#IsDbdmj").val("0");
                    $("#T").val($(this).attr("guid"));
                }
                if ($(this).attr("area") == "1")//当选择交易类型级（即类型且为激活码）
                {
                    $("#G").val($("#HG").val()); //当选择1级将游戏ID保存隐藏控件
                    SetNextBtn(true);
                }
                else {
                    $("#G").val("");
                    SetNextBtn(false);
                }
            }
            else if ($(this).attr("gc") == "4" || $(this).attr("gc") == "0") {
                $("#TP").val($(this).attr("guid")); //当选择4级（即类型）将类型ID赋值给TP
                if ($(this).attr("prop") != "帐号" && $(this).attr("prop") != "激活帐号")
                    $("#T").val("");
                else
                    $("#T").val("3");
            }
            else if ($(this).attr("gc") == "6") {
                $("#TPC").val($(this).attr("guid")); //商品分类子类
            }
            else {
                $("#G").val("");
                SetNextBtn(false);
            }

            $(this).parent().find(".ahover").removeClass("ahover");
            $(this).addClass("ahover");

            var obj = [];
            $(".Bitem:visible a.ahover").each(function () {
                if ($(this).text() != "")
                {
                    obj.push("<a href='javascript:void(0);'>" + $(this).text() + "</a>");
                }
            });

            if (obj.length < 1)
                $(".SelectGame").html(obj.join(""));

            else {
                $(".SelectGame").html(obj.join(" &gt;"));
                if ($(this).attr("gc") == "3" || ($(this).attr("gc") == "" && $(this).attr("area") == "1")) {
                    SetNextBtn(true);
                }
                else {
                    SetNextBtn(false);
                    return false;
                }
            }
            return false;
        });

    });

}
