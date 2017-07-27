/**
 * Created by l on 2016/9/26.
 */
$(function() {
    $("#ThirdSelect").click(function () {
        var tselect = $(".ThirdParty .current").attr("alt");
        if (tselect == "支付宝付款") {
            $("#PayForm").attr("action", "/pay/PayDirectly");
            $("#PayForm").submit();
        }
        else if (tselect == "微信付款") {
            $("#PayForm").attr("action", "/pay/PayDirectly");
            $("#PayForm").submit();
        }

        return false;

    });

});