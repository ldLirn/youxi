(function (window, $, undefined) {
    var game = function () {
        $.extend(Array.prototype, {
            indexOf: function (val) { for (var i = 0; i < this.length; i++) { if (this[i] == val) { return i; } } return -1; },
            contains: function (val) { return this.indexOf(val) != 1; },
            put: function (val) { if (this.contains(val)) return; else this.push(val); },
            remove: function (val) { var index = this.indexOf(val); if (index == 1) return; this.splice(index, 1); }
        });
        this.inited = false;
        this.item = ["game", "area", "server", "kind", "trade", ""];
        this.stepList = ["game", "area", "server", "kind", "trade"];
        this.length = this.item.length - 1;
        this.show = false;
        this.current = "";
        this.param = {};
        this.searchClass = { "gj": { "defult": "gj", "select": "gj_red" }, "bt": { "defult": "pt", "select": "pt_blue" } };
        this.searchType = "bt";
        this.gameIndex = {};
        this.cacheSlectData = {};
        this.gameProperty = "全部游戏";
        this.selectData = {
            "game": { "hasSelected": false, "text": "请先选择游戏", "title": "历史选择：", "val": "请先选择游戏", "tel": "历史选择：" },
            "area": { "hasSelected": false, "text": "请先选择分区", "title": "请选择分区：", "val": "请先选择游戏平台", "tel": "请选择游戏平台：" },
            "server": { "hasSelected": false, "text": "请先选择服务器", "title": "请选择服务器", "val": "请先选择运营商", "tel": "请选择运营商：" },
            "kind": { "hasSelected": false, "text": "请先选择分类", "title": "请选择分类", "val": "请先选择区服", "tel": "请选择区服：" },
            "trade": { "hasSelected": false, "text": "请先选择商品", "title": "请选择商品", "val": "请先选择分类", "tel": "请选择分类：" }
        };
        this.init();
    }
    $.extend(game.prototype, {
        init: function () {
            if (this.inited) {
                return;
            }
            this.baseSearchUrl = $("#baseurl").val();
            if ($("#search_change").attr("small") == "true") {
                this.searchClass = { "gj": { "defult": "", "select": "ahover" }, "bt": { "defult": "", "select": "ahover" } };
                this.simpleSearch = true;
            }
            this.evenBind();

            //选中当前查询条件
            var stepList = this.stepList;
            for (var i=0;i<stepList.length;i++) {
                this.initParam(stepList[i]);
            }
            if ($("#game").attr("vid")) {
                $("#search_gj").click();
            }
            var href = window.location.href;
            var arr = /k=((?=ID|JS|DB|ZH|SY).*)$/.exec(href);
            if (arr && arr.length > 0) {
                $("#search_input_gj,#search_input_bt").val(arr[1]);
            }
            this.inited = true;
        },
        initParam: function (gt) {
            //gt=游戏分类
            var _gt = $("#" + gt);
            if (_gt.attr("lang")) {
                $("#" + gt).html(_gt.attr("lang"));
                this.param[gt] = _gt.attr("identity");
                this.selectData[gt].hasSelected = true;
                if (gt == "kind") {
                    this.param["kindprop"] = _gt.attr("prop");
                }
            }
        },
        showSelect: function (show, type) {
            this.show = show;
            if (show) {
                $("#game_select").show();
                this.current = type;
            } else {
                $("#game_select").hide();
            }
        },
        reset: function () {
            this.clear(this.item[0]);
        },
        clear: function (type) {
            var item = this.item;
            for (var i = item.indexOf(type) ; i < this.length; i++) {
                var tt = item[i];
                var t = $("#" + tt);
                if (this.gameProperty == "手机游戏")
                    t.text(t.attr("ref1"));
                else
                    t.text(t.attr("ref"));
                this.param[tt] = "";
                this.selectData[tt].hasSelected = false;
            }
        },
        showParam: function () {
            var str = "";
            for (var i in this.param) {
                str = str + "," + i + ":" + this.param[i];
            }
            if (str.length > 0)
                str = str.substring(1);
            //		alert(str);
        },
        getParam: function () {
            var str = "";
            for (var i in this.param) {
                str = str + "&" + this.paramKey[i] + "=" + this.param[i];
            }
            if (str.length > 0)
                str = str.substring(1);
            return str;
        },
        bindSelect: function () {
            var that = this;
            //select_ul
            $("#select_ul li[id]").unbind().bind("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                var ele = $(e.target),
				Otype = ele.attr("id");
                if (that.current === Otype && that.show) {
                    that.showSelect(false);//连续点击隐藏
                    return;
                }
                var pidEle = Otype == "kind" ? $("#game") : ele.prev("li");
                that.showSelect(true, Otype);
                if (Otype == "game") {//太复杂，直接调事件
                    $("#quick_btn_back").click();
                    $("#sstabs .current").click();
                    $("#select_content_tab .current").parent().click();
                } else {
                    that.gameProperty = $("#game").attr("proper") == "mobile" ? "手机游戏" : that.gameProperty;
                    that.showSelectCont({ type: Otype, id: pidEle.attr("vid") || "" });//当前内容
                }
            });
        },
        showSelect: function (show, type) {
            this.show = show;
            if (show) {
                $("#game_select").show();
                this.current = type;
            } else {
                $("#game_select").hide();
            }
        },
        isShopNum: function (kw) {
            // return kw.indexOf("ID") == 0 || kw.indexOf("JS") == 0
            // || kw.indexOf("DB") == 0 || kw.indexOf("ZH") == 0 || kw.indexOf("SY") == 0;
            return true;
        },
        evenBind: function () {
            var that = this;

            //select_ul
            this.bindSelect();
            //搜索切换
            $("#search_change").unbind().bind("click", function (e) {
                e.stopPropagation();
                var type = $(e.target).attr("ref");
                that.search(type);
            });
            //search_input
            //高级搜索
            $("#search_button_gj").unbind().bind("click", function (e) {
                that.search('gj');
                e.preventDefault();
                var kw = $("#search_input_gj").val();
                if (!that.param["game"] && !that.isShopNum(kw)) { alert("请输入游戏关键词"); return; }
                that.gameProperty = $("#game").attr("proper") == "mobile" ? "手机游戏" : that.gameProperty;
                window.location.href = that.getSearchUrl(kw);

            });
            //普通搜索.gamesamall只有这一个
            $("#search_button_bt").unbind().bind("click", function (e) {
                that.search(that.searchType);
                e.preventDefault();
                var kw = that.param["keyword"];
                if (!that.param["game"] && !that.isShopNum(kw)) { alert("请选择高级搜索或填写商品编号"); return; }
                window.location.href = that.getSearchUrl(kw);
            });
            //关闭选择
            $("#game_select_close").unbind().bind("click", function (e) {
                that.showSelect(false);
                //				that.reset();
            });

            //快速搜索
            $("#quick_btn").unbind().bind("click", function (e) {
                var searchVal = $("#quick_input").val();
                that.quickSearch();
                //				alert(searchVal);
            });
            $('#quick_input').keyup(function (e) {
                if (e.which==13) {//回车事件
                    $("#quick_btn").click();
                }
            });
            $("#select_content_tab li").unbind().click(function () {
                var key = $(this).find("a").html();
                var proptype = $("#sstabs .current a").html();
                that.getData({ type: "game", proptype: proptype }, key);
                $(this).parent().find(".current").removeClass("current");
                $(this).find("a").addClass("current");
            });
            $("#sstabs li").unbind().click(function () {
                var type = $(this).find("a").html();
                $(this).parent().find(".current").removeClass("current");
                $(this).addClass("current");
                that.gameProperty = type
                if (type != "点卡充值" && $("#game").attr("proper")=="mobile"){
                    that.gameProperty = "手机游戏";
                }
                $("#select_content_tab .current").click();//选中之前的
            });
            //返回搜索
            $("#quick_btn_back").unbind().bind("click", function (e) {
                $("#quick_input").val("");
                $("#quick_btn_back").hide();
                $("#fastletter").hide();
                $("#sstabs").show();
                that.showSelectCont({ type: that.item[0] });//游戏 
            })
            //自动关闭游戏选择
            $(document).click(function (e) {
                var $ele = $(e.target);
                if (!$ele.parents().hasClass("header_box")) {
                    that.showSelect(false);
                }
            });
            //历史选择
            that.resetHistoryEvent();
        },
        resetHistoryEvent: function () {
            var that = this;
            //历史选择
            $("#gs_history").html(getGameHistory());
            $("#gs_history a").unbind().click(function (e) {
                e.stopPropagation();
                e.preventDefault();
                var params = {
                    type: "game",
                    id: $(this).attr("vid"),
                    name: $(this).html(),
                    identity: $(this).attr("identity"),
                    proper: $(this).attr("proper")
                };
                that.setSelectVal(params);

                params.type = "area";
                that.gameProperty = $(this).attr("proper") == "mobile" ? "手机游戏" :"网络游戏";
                that.showSelectCont(params);
            });

        },
        copyGame: function (game) {
            var ret = {};
            ret.gamename = game.gamename;
            ret.id = game.id;
            //			alert(ret.gamename)
            return ret;
        },
        showSelectCont: function (params) {
            var that = this;
            var type = params.type;
            that.clear(type);
            if (type != "game") {
                $("#quick_div").hide();
                $("#select_content_tab").hide();
                $("#sstabs").hide();
            } else {
                $("#quick_div").show();
                $("#quick_btn_back").hide();//快速搜索返回按钮
                $("#select_content_tab").show();
                $("#sstabs").show();
            }
            that.getDataList(params);
        },
        setArrowPostion: function (type) {//设置位置
            var that = this;
            var eleItem = $("#" + type);
            var eleLeft = (eleItem.offset().left - ($("html,body").width() - $("#game_select").width()) / 2) + eleItem.width() / 3;
            that.selectData[type].hasSelected = false;
            $("#searchbar_arrow").animate({//mark
                "left": eleLeft
            }, 150);
        },
        setData: function (Data, type) {
            var that = this;
            var Html = that.liGenerator(Data, type);
            if (this.item.indexOf(type) == -1) {//排除A-B-C-D
                type = "game";
            }
            $("#gs_title").html(that.gameProperty == "手机游戏" ? that.selectData[type].tel : that.selectData[type].title);
            that.setArrowPostion(type);
            if (type == "game") {
                $("#gs_history").show();
            } else {
                $("#gs_history").hide();
            }
            $("#select_content").html(Html);
            that.resetBindEvent();
        },
        getData: function (opt, key) {
            var searBase = $("#baseurl").val();
            var that = this;
            var type = opt.type;
            if (type == "game") {
                if (key == null) { key = "热门游戏" }
                var proptype = opt.proptype||"";
                var url = searBase+'/all_game/GetGameByKey';
                var cache = that.cacheSlectData["game" + key + "_" + proptype];
                if (cache) { that.setData(cache, type); } else {
                    that.waitting();
                    $.ajax({
                        type: 'get',
                        url: url,
                        data: { key: key, type: proptype },
                        dataType: 'jsonp',
                        jsonp: "callback",
                        success: function (data) {
                            that.setData(data, type);
                            that.cacheSlectData["game" + key + "_" + proptype] = data;
                            that.completed();
                        }
                    });
                }
            } else {
                if (type == "trade" && that.gameProperty != "手机游戏") {
                    var Data = [{ "id": "", "game_name": "所有商品 " }, { "id": "s", "game_name": "寄售交易 " }, { "id": "d", "game_name": "担保交易" }, { "id": "q", "game_name": "求购交易" }];
                    that.setData(Data, type);
                } else {
                    var level = that.item.indexOf(type) + 1;
                    var id = opt.id;
                    if (level == 4) {
                        id = that.gameProperty == "手机游戏" ? $("#server").attr("vid") : $("#game").attr("vid");
                        level = that.gameProperty == "手机游戏" ? 7 : 4;
                    }
                    if (level == 5 && that.gameProperty == "手机游戏") {
                        id = $("#area").attr("vid");
                        level = 4;
                    }
                    if (that.gameProperty == "手机游戏" && type == "area") {
                        $("#area").text("游戏平台");
                        $("#server").text("运营商");
                        $("#kind").text("游戏区服");
                        $("#trade").text("全部分类");
                    }
                    else if (that.gameProperty != "手机游戏" && type == "area") {
                        $("#area").text("游戏区");
                        $("#server").text("游戏服务");
                        $("#kind").text("全部分类");
                        $("#trade").text("所有商品");
                    }
                    var cache = that.cacheSlectData[type + id];
                    if (cache) { that.setData(cache, type); } else {
                        var searBase = $("#baseurl").val();
                        that.waitting();
                        $.ajax({
                            type: 'get',
                            url: searBase+'/all_game/GetGameByLevel',
                            data: { level: level, parentId: id },
                            dataType: 'jsonp',
                            jsonp: "callback",
                            success: function (data) {
                                that.setData(data, type);
                                that.cacheSlectData["game" + key] = data;
                                that.completed();
                            }
                        });
                    }
                }
            }
        },
        waitting:function(){
            $("#select_content").addClass("loading_bg");
        },
        completed: function () {
            $("#select_content").removeClass("loading_bg");
        },
        getDataList: function (opt) {
            var that = this;
            var type = opt.type;
            var prevType = that.prevType(type);
            //that.selectData
            var Html = "";
            that.showSelect(true, type);
            if (type !== that.item[0] && !that.selectData[prevType].hasSelected) {//没按步骤选择
                Html = '<li class="">' + (that.gameProperty == "手机游戏" ? that.selectData[prevType].val : that.selectData[prevType].text) + '</li>';
                $("#select_content").html(Html);
                that.setArrowPostion(type);
            } else {
                that.getData(opt);
            }
        },
        liGenerator: function (Data, type) {
            var Html = '';
            if (Data == null) {
                return;
            }
            if (Data == -1) {
                return '<li class="">请先选择游戏</li>';
            }
            var that = this;
            $.each(Data, function (i, item) {
                if (type == "trade") {
                    Html += '<li><a href="' + that.getTradeUrl(item.id) + '">' + item["game_name"] + '</a></li>';
                } else if (type == "game" && that.gameProperty == "点卡充值") {
                    var hotStr = (item.is_hot) == "1" ? " class='gs_red' " : "";
                    Html += '<li><a href="' + that.getDkczUrl(item.id) + '" ' + hotStr + '>' + item["game_name"] + '</a></li>';
                } else if (type == "kind" && item.Properties == "直冲点券") {
                    Html += '<li><a href="' + that.getDqUrl(item.id) + '">' + item["game_name"] + '</a></li>';
                } else {
                    var hotStr = type == "game" && (item.is_hot) == "1" ? " class='gs_red' " : "";
                    if(item.pid>=0 || item.fee){
                        Html += '<li vid="' + item.id + '" identity=' + item['game_name'] + ' lang="' + type + '" level="' + item.Level + '"proper="' + (item.Properties == "手机游戏" ? "mobile" : "") + '" ><a ' + hotStr + 'href="javascript:;">' + item["game_name"] + '</a></li>';
                    }else{
                        Html += '<li vid="' + item.id + '" identity=' + item.id + ' lang="' + type + '" level="' + item.Level + '"proper="' + (item.Properties == "手机游戏" ? "mobile" : "") + '" ><a ' + hotStr + 'href="javascript:;">' + item["game_name"] + '</a></li>';
                    }
                }
            })
            if (Data.length > 0 && (Data[0].Level == 2 || Data[0].Level == 3)) {
                Html += '<li><a style="color:#999;" href="" target="_blank">找不到游戏、区服？</a></li>';
            }
            if (Data.length == 0) {
                Html = '<li class="">暂无数据</li>'
            }
            return Html;
        },
        getAccountUrl:function () {
            var param = this.param;
            var url = "/s/" + (param["game"] || "0") + "-" + (param["area"] || "0") + "-" + (param["server"] || "0") + "-0-0-c-0-0-0-0-0-0.html";
            return this.baseSearchUrl + url;
        },
        getTradeUrl: function (type) {
            var param = this.param;
            var that = this;
            if (that.gameProperty == "手机游戏")
            {
                var url = (param["game"] || "0") + "-" + (param["area"] || "0") + "-" + (param["server"] || "0") + "-" + (param["kind"] || "0") + "-"+ type + "-0-0-0-a-a-0-0.html";
                return "http://sy.dd373.com/s/"+url;
            }
            else
                if(type){
                    var url = '/category/'+(param["game"] || "0") + "?qu=" + (param["area"] || "0") + "&fwq=" + (param["server"] || "0")+"&type="+ (param['kind']) + "&traded_type=" + type;
                }else{
                    var url = '/category/'+(param["game"] || "0") + "?qu=" + (param["area"] || "0") + "&fwq=" + (param["server"] || "0")+"&type="+ (param['kind']) ;
                }


            if (type == "b") {
                preUrl = "/needdeal/";
            }
            return this.baseSearchUrl + url;
        },
        getDqUrl: function (kind) {
            var param = this.param;
            var url = (param["game"] || "0") + "-0-0-" + kind + "-0-0-0-0-0-0-0-0.html";
            var preUrl = "/dq/";
            return this.baseSearchUrl + preUrl + url;
        },
        getDkczUrl: function (guid) {
            var url = "http://dk.dd373.com/Cards/GameOrder1?guid=";            
            return url + guid;
        },
        resetBindEvent: function () {
            var that = this;
            $("a[href^=javascript]", "#select_content").unbind().bind("click", function (e) {
                e.stopPropagation();
                e.preventDefault();
                var ele = $(e.target);
                var nextType = that.nextType(that.current);
                var prevType = that.prevType(that.current);
                var selectName = ele.text(), vid = ele.parent().attr("vid"),
				type = ele.parent().attr("lang");
                if (type == "game") {
                    that.gameProperty = ele.parent().attr("proper") == "mobile" ? "手机游戏" : "";
                }
                //				$("#select_ul li.current").removeClass("current");
                //				$("#select_ul a[class='"+ nextType +"']").parent("li").addClass("current");
                that.setSelectVal({
                    "name": selectName,
                    "id": vid,
                    "identity": ele.parent().attr("identity"),
                    "type": type,
                    "proper": ele.parent().attr("proper")
                });
                if (type == "trade") {
                    that.showSelect(false);
                    return;
                }
                var params = {
                    "name": selectName,
                    "id": vid,
                    "type": nextType//显示下个类型内容
                };
                that.showSelectCont(params);
            });
        },
        getSearchUrl: function (kw) {
            var that = this, ret = this.baseSearchUrl, stepList = this.stepList, param = that.param;
            var Tagtype = window.tagtype;
            var url = "";
            if (that.param["kindprop"] == "直冲点券") {
                return that.getDqUrl(that.param["kind"]);
            } else {
                if (that.searchType == "bt") {
                    url = "/category/" + (kw == "" ? "" : "?k=" + kw);
                    if (Tagtype== "sy") {
                        url = "/s/" + (param["game"] || "0") + "-" + (param["area"] || "0") + "-" + (param["server"] || "0") + "-" + (param["kind"] || "0") + "-" + (param["trade"] || "0")  + (kw == "" ? "" : "?k=" + kw);
                        return  "/sy" + url;
                    }
                }
                else {
                    var selectgame = param["game"] || "0";
                    if (that.gameProperty == "手机游戏" || (Tagtype == "sy" && selectgame=="0")) {
                        url = "/s/" + (param["game"] || "0") + "-" + (param["area"] || "0") + "-" + (param["server"] || "0") + "-" + (param["kind"] || "0") + "-" + (param["trade"] || "0")  + (kw == "" ? "" : "?k=" + kw);
                        return "/sy/" + url;
                    }
                    if (param["trade"] == "b") {
                        url = "/needdeal/" + (param["game"] || "0") + "-" + (param["area"] || "0") + "-" + (param["server"] || "0") + "-" + (param["kind"] || "0") + (kw == "" ? "" : "&k=" + kw);
                    } else {
                        if (param["kind"] == "c") {//帐号
                            url = "/category/" + (param["game"] || "") + "-" + (param["area"] || "") + "-" + (param["server"] || "")  + (kw == "" ? "" : "&k=" + kw);
                        } else {
                            if(param["game"]){}
                            url = "/category/" + (param["game"] || "") + "?qu=" + (param["area"] || "") + "&fwq=" + (param["server"] || "") + "&type=" + (param["kind"] || "")  + (kw == "" ? "" : "&k=" + kw);
                        }
                    }
                }
            }
            return ret+url;
        },
        prevType: function (type) {
            var index = this.item.indexOf(type);
            var ret = this.item[0];
            if (this.gameProperty != "手机游戏" && (type == "kind" || type == "trade")) {//这俩只需选游戏
                return ret;
            }
            if (this.gameProperty == "手机游戏" && type == "trade") {//这俩只需选游戏
                return "area";
            }
            if (index > 0)
                return this.item[index - 1];
            else
                return ret;
        },
        nextType: function (type) {
            var index = this.item.indexOf(type);
            var ret = "all";
            if (index != -1 && index != this.length)
                return this.item[index + 1];
            else
                return ret;
        },
        search: function (type) {
            this.searchType = type;
            var bt = this.searchClass.bt;
            var gj = this.searchClass.gj;
            if (type == "bt") {
                $("#select_div_gj").hide();
                $("#game_select").hide();
                //				this.reset();
                $("#select_div_pt").show();
                $("#search_bt").attr("class", bt.select);
                $("#search_gj").attr("class", gj.defult);
                this.param["state"] = 0;
                this.param["keyword"] = $("#search_input_bt").val();
            } else if (type == "gj") {
                $("#select_div_gj").show();
                $("#select_div_pt").hide();
                $("#search_bt").attr("class", bt.defult);
                $("#search_gj").attr("class", gj.select);
                this.param["state"] = 1;
                this.param["keyword"] = $("#search_input_gj").val();
            }
        },
        quickSearch: function () {
            var that = this, _t = $("#quick_input"), _val = _t.val();
            if ($.trim(_val) == '') {
                return;
            }
            if (/^[\u4e00-\u9fa5]+$/.test(_val)===false){
                alert('只能输入中文');
                return;
            }
            $("#select_content_tab").hide();
            $("#select_content").hide();
            $("#quick_btn_back").show();
            that.showQuickCont(_val);
        },
        showQuickCont: function (cont) {
            var that = this;
            $("#fastletter").show();
            $("#select_content").show();
            $("#sstabs").hide();
            that.waitting();
            $.ajax({
                type: 'get',
                url: that.baseSearchUrl+'/all_game/GameByKeyword',
                data: { keyword: cont },
                dataType: 'jsonp',
                jsonp: "callback",
                success: function (data) {
                    that.setData(data, "game");
                    that.completed();
                }
            });
        },
        setSelectVal: function (opt) {
            var type = opt.type;
            var that = this;
            $("#" + type).attr({
                "vid": opt.id,
                "lang": opt.name,
                "identity": opt.identity,
                "proper": opt.proper
            });
            //			alert("type:"+type);
            $("#" + type).text(opt.name);
            this.param[type] = opt.identity;
            this.selectData[type].hasSelected = true;
            if (type == "game") {
                var _game = $("#game");//历史搜索
                addGameToHistory(_game.attr("vid"), _game.attr("identity"), _game.attr("lang"), _game.attr("proper"));
                $("#gs_history").hide();
                that.resetHistoryEvent();
            }
        }
    });
    $(function () {
        var tagtype = window.tagtype;
        //拼接html
        $("#quick_div").after(GetGameProps(tagtype) + GetSelectContent());
        new game();
    });

})(window, jQuery);
function GetGameProps(tagtype) {
    var ret = "<div class=\"sstabs\" id=\"sstabs\"><ul>";
    var props = "全部游戏,网络游戏,手机游戏,网页游戏".split(',');
    var y = 1;
    if (tagtype == "sy") {
        y = 2;
    }
    for (var i = 0; i < props.length; i++) {
        if (i == y) {
            ret += "<li class=\"current\"><a href=\"javascript:void(0);\">" + props[i] + "</a></li>";
        } else {
            ret += "<li><a href=\"javascript:void(0);\">" + props[i] + "</a></li>";
        }
    }
    ret += "</ul></div>";
    return ret;
}
function GetSelectContent() {
    var ret = "<ul class=\"gs_nav\" id=\"select_content_tab\"><li class=\"first_line\"></li><li id=\"hotgame\" class=\"w_70\"><a href=\"javascript:;\" class=\"current\">热门游戏</a></li>";
    for (var c = 65; c <= 90; c++)
    {
        ret += "<li><a href=\"javascript:;\">" + String.fromCharCode(c) + "</a></li>";
    }
    ret += "<li class=\"last_line\"></li></ul><ul class=\"gs_list gs_name\" id=\"select_content\" ></ul>";
    return ret;
}
function addGameToHistory(gameID, gameidentify, name,prop) {
    var gameHistory = getCookie("gmHistory");
    //没有记录历史
    if (gameHistory == null || gameHistory == "") {
        gameHistory = gameID + "," + gameidentify + "," + name + "," + prop;
        SetCookie("gmHistory", gameHistory);
        return;
    }
    //有重复记录
    var games = gameHistory.split('|');
    var i;
    for (i = 0; i < games.length; i++) {
        if (games[i].split(',')[0] == gameID) {
            var temp = games[i];
            for (j = i; j < games.length - 1; j++) {
                games[j] = games[j + 1];
            }
            games[j] = temp;
            SetCookie("gmHistory", games.join("|").toString());
            return;
        }
    }
    //记录过5条
    if (games.length < 5) {
        gameHistory += "|" + gameID + "," + gameidentify + "," + name + "," + prop;
        SetCookie("gmHistory", gameHistory);
        return;
    }
    else {
        gameHistory = gameHistory.substring(gameHistory.indexOf("|") + 1) + "|" + gameID + "," + gameidentify + "," + name + "," + prop;
        SetCookie("gmHistory", gameHistory);
    }
}
function getGameHistory() {
    var gameHistory = getCookie("gmHistory");
    if (gameHistory == null || gameHistory == "") {
        return "";
    }
    var games = gameHistory.split('|');
    var lineHeight = 24;
    var returnStr = "";
    for (var i = games.length - 1; i >= 0; i--) {
        if (games[i].split(',').length == 4)
            returnStr += "<a class=\"GameHistory\" vid=\"" + games[i].split(',')[0] + "\" identity=\"" + games[i].split(',')[1] + "\"proper=\"" + games[i].split(',')[3] + "\">" + games[i].split(',')[2] + "</a>&nbsp;&nbsp;";
    }
    return returnStr;
}

function SetCookie(name, value)//两个参数，一个是cookie的名子，一个是值
{
    var Days = 30; //此 cookie 将被保存 30 天
    var exp = new Date();    //new Date("December 31, 9998");
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";domain=sfzx;path=/;expires=" + exp.toGMTString();
}
function getCookie(name)//读取cookies函数        
{
    var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
    if (arr != null) return unescape(arr[2]); return null;
}
