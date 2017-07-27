//加载第一级游戏
$(function() {
    GetGame(1, "");
    $("#G").val("");
    $("#TP").val("");
    $(".SGameType .Box .Bitem :text").keyup(function() {
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
});
function GetGame(gC, pI) {
    var base_url = $('#base_url').val();
    if (gC == 4) {
        $(".SGameType .Box .Bitem:gt(1) div").html("");
        $(".SGameType .Box .Bitem:gt(1)").hide();
        $(".SelectGame a:gt(0)").remove();
    }
    else if (gC == 1) {
        $(".SGameType .Box .Bitem:gt(" + (gC - 1) + ") div").html("");
        $(".SGameType .Box .Bitem:gt(" + (gC - 1) + ")").hide();
        $(".SelectGame a:gt(" + gC + ")").remove();
    }
    else {
        $(".SGameType .Box .Bitem:gt(" + gC + ") div").html("");
        $(".SGameType .Box .Bitem:gt(" + gC + ")").hide();
        $(".SelectGame a:gt(" + (gC - 2) + ")").remove();
    }
    $.ajax({
        type: 'get',
        url: base_url+'/all_game/pushGame',
        data: { gCase: gC, pID: pI},
        dataType: 'jsonp',
        jsonp: "callback",
        success: function (data) {
            var t = data;
            var html = "";
            $.each(t, function (i, v) {
                var shoreName = v.display_name;
                shoreName = shoreName.toLowerCase();
                html += "<a href='#' pi='" + v.id + "' parId='" + v.game_id + "' area=" + (v.type == "激活码" || v.type == "直冲点券" ? "1" : "0") + " gc=" + gC + " class='" + shoreName + "'>" + v.game_name + "</a>";
            });
            var gObj = null;
            if (gC == 4) {
                $(".SGameType .Box .Bitem:eq(1) div").html(html == "" ? "没有分类" : html);
                $(".SGameType .Box .Bitem:eq(1)").show();
                gObj = "type";
            }
            else if (gC == 1) {
                $(".SGameType .Box .Bitem:eq(" + (gC - 1) + ") div").html(html == "" ? "没有分类" : html);
                $(".SGameType .Box .Bitem:eq(" + (gC - 1) + ")").show();
                gObj = "game";
            }
            else {
                $(".SGameType .Box .Bitem:eq(" + gC + ") div").html(html == "" ? "没有分类" : html);
                $(".SGameType .Box .Bitem:eq(" + gC + ")").show();
                gObj = gC == 2 ? "area" : "server";
            }

            AttEvent();
            var _reqobj = $("#reqobj");
            var guid = _reqobj.attr("data-" + gObj);
            if (guid) {
                $(".SGameType").find("a[gc=" + gC + "][pi=" + guid + "]").click();
                _reqobj.removeAttr("data-" + gObj);
            }
        }
    });
}

function AttEvent() {
    $(".SGameType .Box .Bitem a").each(function(i, v) {
        $(v).unbind("click").click(function() {
            if ($(this).attr("gc") == "1")
                GetGame(4, $(this).attr("pi"));
            else if ($(this).attr("gc") == "4") {
                if ($(this).attr("area") == "0") {
                    GetGame(2, $(this).attr("parId"));
                }
                else {
                    $(".SGameType .Box .Bitem:gt(1) div").html("");
                    $(".SGameType .Box .Bitem:gt(1)").hide();
                    $(".SelectGame a:gt(1)").remove();
                }
            }
            else if ($(this).attr("gc") != "3")
                GetGame(parseInt($(this).attr("gc")) + 1, $(this).attr("pi"));
            if ($(this).attr("gc") == 1) {
                $("#TP").val("");
                $("#HG").val($(this).attr("pi")); //当选择1级将游戏ID保存隐藏控件
            }
            else if ($(this).attr("gc") == 3) {
                $("#G").val($(this).attr("pi")); //当选择3级将服ID保存隐藏控件
            }
            else if ($(this).attr("gc") == 4) {
                $("#TP").val($(this).attr("pi")); //当选择4级（即类型）将类型ID赋值给TP
                if ($(this).attr("area") == "1")//当选择4级（即类型且为激活码）
                {
                    $("#G").val($("#HG").val()); //当选择1级将游戏ID保存隐藏控件
                }
                else {
                    $("#G").val("");
                }

            }
            else {
                $("#G").val("");
            }
            $(this).parent().find(".ahover").removeClass("ahover");
            $(this).addClass("ahover");
            var obj;
            if ($(this).attr("gc") == "4")
                obj = $(".SelectGame a:eq(1)");
            else if ($(this).attr("gc") == "1")
                obj = $(".SelectGame a:eq(" + (parseInt($(this).attr("gc")) - 1) + ")");
            else
                obj = $(".SelectGame a:eq(" + $(this).attr("gc") + ")");

            var tag = $(this).attr("gc") == 4 ? "" : " &gt; ";
            if ($(this).attr("gc") == "3")
                tag = "";
            else if ($(this).attr("gc") == "4" && $(this).attr("area") == "1")
                tag = "";
            else
                tag = " &gt; ";
            if (obj.length < 1)

                $(".SelectGame").append("<a href='javascript:void(0);'>" + $(this).text() + tag + "</a>");

            else {
                obj.html($(this).text() + tag);
            }


            return false;
        });
    });
}