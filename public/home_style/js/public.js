/**
 * Created by guowx on 2016/9/10.
 */
$(function(){
    $(".dk-box ul li").on("mouseenter", function () {
        $(this).addClass("current").siblings().removeClass("current");
        $(this).find(".hide").show();
    }).mouseleave(function(){
        $(this).find(".hide").hide();
    })

    var letter;
    $("#letter li").mouseenter(function () {
        $(this).addClass("active").siblings().removeClass("active");
        var text=$(this).text();
        $("[class=gamenamebyfirst]").show();
        $("[class=gamenamebyfirst] li").each(function(){
            var cur=$(this).attr("type").toUpperCase();
            if(text==cur){
                $(this).css("display","block");
            }else {
                $(this).css("display","none");
            }
        })
    }).mouseleave(function(){
        $(this).removeClass("active");
    })

    $(".recharge-box .shop_tb li").click(function(){
        $(".shop-box .hide").eq($(this).index()).show().siblings().hide();
    })
    $(".shop_tb2 li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".shop-new .hide").eq($(this).index()).show().siblings().hide();
    })
    $(".account-buy .box-tab li").click(function(){
        $(".account-buy .sbox .hide").eq($(this).index()).show().siblings().hide();
    })
    $(".account-tab ul li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".account-list .hide").eq($(this).index()).show().siblings().hide();
    })
	$("[name=rbtj] ul li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".reco_list .hide").eq($(this).index()).show().siblings().hide();
    })
	$("[name=jesp] ul li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".recoo_list .hide").eq($(this).index()).show().siblings().hide();
    })
	$("[name=jksc] ul li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".ckk .hide").eq($(this).index()).show().siblings().hide();
    })
	$("[name=zhjy] ul li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".yield .hide").eq($(this).index()).show().siblings().hide();
    })
    $(".hot-hot li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".account-hot .sbox .hide").eq($(this).index()).show().siblings().hide();
    })
    $(".list-tab li").click(function(){
        $(this).addClass("current").siblings().removeClass("current");
        $(".list-main .hide").eq($(this).index()).show().siblings().hide();
    })

    $("[name=shop-cate] li:gt(10)").hide();
    $("[name=shop-cate] li[class=red]").show();
    $("[name=list-more]").click(function(){
       if($(this).hasClass("on")){
           $(this).text("查看更多>");
           $(this).removeClass("on");
           $("[name=shop-cate] li:gt(10)").hide();
           $("[name=shop-cate] li[class=red]").show();
       }else {
           $(this).addClass("on");
           $(this).text("收起>");
           $("[name=shop-cate] li:gt(10)").show();
       }
    })
    $("[name=shop-area] li:gt(10)").hide();
    $("[name=shop-area] li[class=red]").show();
    $("[name=area-more]").click(function(){
        if($(this).hasClass("on")){
            $(this).text("查看更多>");
            $(this).removeClass("on");
            $("[name=shop-area] li:gt(10)").hide();
            $("[name=shop-area] li[class=red]").show();
        }else {
            $(this).addClass("on");
            $(this).text("收起>");
            $("[name=shop-area] li:gt(10)").show();
        }
    })

    /*游戏*/
    $("[name=dk]").mouseenter(function(){
        $(this).addClass("common-red");
        $("#blue9_hide_dk").show();
    }).mouseleave(function(){
        $(this).removeClass("common-red");
        $("#blue9_hide_dk").hide();
    })
    $("#blue9_hide_dk").mouseenter(function(){
        $(this).show();
        $("[name=dk]").addClass("common-red");
    }).mouseleave(function(){
        $(this).hide();
        $("[name=dk]").removeClass("common-red");
    })
    $("[name=qq]").mouseenter(function(){
        $(this).addClass("common-red");
        $("#blue9_hide_qq").show();
    }).mouseleave(function(){
        $(this).removeClass("common-red");
        $("#blue9_hide_qq").hide();
    })
    $("#blue9_hide_qq").mouseenter(function(){
        $(this).show();
        $("[name=qq]").addClass("common-red");
    }).mouseleave(function(){
        $(this).hide();
        $("[name=qq]").removeClass("common-red");
    })
    $("[name=yx]").mouseenter(function(){
        $(this).addClass("common-red");
        $("#blue9_hide_hf").show();
    }).mouseleave(function(){
        $(this).removeClass("common-red");
        $("#blue9_hide_hf").hide();
    })
    $("#blue9_hide_hf").mouseenter(function(){
        $(this).show();
        $("[name=yx]").addClass("common-red");
    }).mouseleave(function(){
        $(this).hide();
        $("[name=yx]").removeClass("common-red");
    })

    $("[name=gm-yx] li").mouseenter(function () {
        $(this).addClass("active").siblings().removeClass("active");
        var text=$(this).text();
        $("[name=cagegory]").show();
        $("[name=cagegory] li").each(function(){
            var cur=$(this).attr("type").toUpperCase();
            if(text==cur){
                $(this).css("display","block");
            }else {
                $(this).css("display","none");
            }
        })
    })

    $(".letter-nav").unbind().bind("mouseleave", function () {
        $("[name=gm-yx] li.active").removeClass("active");
        $("[name=cagegory]").hide();
    });

    $("[name=select-game]").mouseenter(function () {
        $(this).addClass("active").siblings().removeClass("active");
        var text=$(this).text();
        $("[name=cagegory] li").show();
        $("[name=cagegory]").show();
    });
    $(".gamelist-top").mouseleave(function(){
        $("[name=cagegory]").hide();
    })


    $(".warriors").hide();
    $(".game_top ul li").mouseenter(function(){
        $(".game_top ul li a").removeClass("current")
        $(this).find("a").addClass("current");
        var text=$(this).find("a").text();
        $(".warriors").show();
        $(".warriors ul li").each(function(){
            var cur=$(this).attr("type").toUpperCase();
            if(text==cur){
                $(this).css("display","inline-block");
            }else {
                $(this).css("display","none");
            }
        })
    })

    $(".warriors").unbind().bind("mouseleave", function () {
        $(".game_top ul li a.current").removeClass("current");
        $(".warriors").hide();
    });
    $(".game_list_left").unbind().bind("mouseleave", function () {
        $(".game_top ul li a.current").removeClass("current");
        $(".warriors").hide();
    });

    $('#toptips_btn').click(function () {
        $('#toptips').slideUp();
    });
  
})
