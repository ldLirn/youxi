/**
 * Created by Administrator on 2016/9/12.
 */
$(function(){
    //��������
    $(".Help_left dl dt").click(function(){
        $(".Help_left dl dt").removeClass("on");
        $(".Help_left dl dd").hide();
        var p_id = $(this).attr('id');
      if($(this).hasClass("on")){
          $(this).removeClass("on");
          $(".menu_"+p_id).hide();
      }else{
          $(this).addClass("on");
          $(".menu_"+p_id).show();
      }
    })
    //��������-qq��ֵ
    $(".sidebar dl dd").hide();
    $(".sidebar dl dt").click(function(){
        $(".sidebar dl dt").removeClass("on");
        $(".sidebar dl dd").hide();
        if($(this).hasClass("on")){
            $(this).removeClass("on");
            $(this).parent().find("dd").hide();
        }else{
            $(this).addClass("on");
            $(this).parent().find("dd").show();
        }
    })

    //ע��2
   $(".como_tab a").click(function(){
       $(this).addClass("current").siblings("a").removeClass("current");
       $(".reg [name=regbox]").eq($(this).index()-1).show().siblings().hide();
   })
   var lett=$("[name=letter] a");
    lett.click(function(){
        lett.removeClass("red");
        $(this).addClass("red");
        var text=$(this).text();
        $(".cklter a").each(function(){
            var cur=$(this).attr("type").toUpperCase();
            if(text==cur){
                $(this).css("display","inline-block");
            }else {
                $(this).css("display","none");
            }
        })
    })
   $("[name=buyer]").mouseenter(function(){
       $(".sd01").show();
   }).mouseleave(function(){
       $(".sd01").hide();
   })
    $("[class=sd01]").mouseenter(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).hide();
    })
    $("[name=seller]").mouseenter(function(){
        $(".sd02").show();
    }).mouseleave(function(){
        $(".sd02").hide();
    })
    $("[class=sd02]").mouseenter(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).hide();
    })
    $("[name=help]").mouseenter(function(){
        $(".sd03").show();
    }).mouseleave(function(){
        $(".sd03").hide();
    })
    $("[class=sd03]").mouseenter(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).hide();
    })
    $("[name=daohang]").mouseenter(function(){
        $(".sd04").show();
    }).mouseleave(function(){
        $(".sd04").hide();
    })
    $("[class=sd04]").mouseenter(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).hide();
    })
    $("[name=weibo]").mouseenter(function(){
        $(".sd05").show();
    }).mouseleave(function(){
        $(".sd05").hide();
    })
    $("[class=sd05]").mouseenter(function(){
        $(this).show();
    }).mouseleave(function(){
        $(this).hide();
    })
    $('[name=password]').keyup(function(e) {
        var strongRegex = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#$]).{6,20}$");
        var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
        var enoughRegex = new RegExp("(?=.{6,}).*", "g");
        var pw=$('.passstrength');
        if (false == enoughRegex.test($(this).val())) {
            pw.addClass('small');
            pw.removeClass('medium');
            pw.removeClass('strong');
        } else if (strongRegex.test($(this).val())) {
            pw.removeClass('small');
            pw.removeClass('medium');
            pw.addClass('strong');
        } else if (mediumRegex.test($(this).val())) {
            pw.removeClass('small');
            pw.addClass('medium');
            pw.removeClass('strong');
        } else {
            pw.addClass('small');
            pw.removeClass('medium');
            pw.removeClass('strong');
        }
        return true;
    });
})