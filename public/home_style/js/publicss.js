/**
 * Created by guowx on 2016/9/10.
 */
$(function(){
    $(".dk-box ul li").live("mouseenter", function () {
        $(this).addClass("current").siblings().removeClass("current");
        $(this).find(".hide").show();
    }).mouseleave(function(){
        $(this).find(".hide").hide();
    })

    var letter;
    $("#letter li").mouseenter(function () {
        $(this).addClass("current").siblings().removeClass("current");
         letter=$(this).find("a").text();
        $(".dk-box ul li").each(function(){
            var cur=$(this).find("dd").attr("type").toUpperCase();
            if(letter==cur){
                $(this).css("display","block");
            }else {
                $(this).css("display","none");
            }
        })
    }).eq(1).mouseenter();

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

    $("#gm-yx li").mouseenter(function () {
        $(this).addClass("current").siblings().removeClass("current");
        var text=$(this).text();
        $.ajax({
            //请求方式为get
            type:"GET",
            //json文件位置
            url:"js/package.json",
            //返回数据格式为json
            dataType: "json",
            //请求成功完成后要执行的方法
            success: function(data){
                //使用$.each方法遍历返回的数据date,插入到id为#result中
                var html="";
                var cate=$("#cagegory");
                cate.html("");
                $.each(data,function(i,item){
                    var type=item.type.toUpperCase();
                    if(text==type){
                        html+="<li><a href='#'>"+item.title+"</a></li>";
                    }
                })
                cate.append(html).show();
            }
        })
    });
    $("#select-game").mouseenter(function () {
        $(this).addClass("current").siblings().removeClass("current");
        $.ajax({
            //请求方式为get
            type:"GET",
            //json文件位置
            url:"js/package.json",
            //返回数据格式为json
            dataType: "json",
            //请求成功完成后要执行的方法
            success: function(data){
                //使用$.each方法遍历返回的数据date,插入到id为#result中
                var html="";
                var cate=$("#cagegory");
                cate.html("");
                $.each(data,function(i,item){
                    var type=item.type.toUpperCase();
                    html+="<li><a href='#'>"+item.title+"</a></li>";
                })
                cate.append(html).show();
            }
        })
    });
    $(".gamenamebyfirst").mouseleave(function(){
        $(this).hide();
    })
})
