define(function(require,exports,module){var $=require("jquery");require("modules/jquery.loadmask")($);var common=require("modules/common");require("css/jquery.loadmask.css"),require("css/ladda.min.css"),require("handlebars"),require("modules/spin.min"),require("modules/ladda.min"),common.handlerbarsCompare(),$(function(){function shareDisFun(e,type){var fdiv=($(this),$(".share-fdiv"));return type?void("show"==type?($(".share-title").addClass("s-hover"),fdiv.removeClass("hidden")):(fdiv.addClass("hidden"),$(".share-title").removeClass("s-hover"))):void(fdiv.hasClass("hidden")?(fdiv.removeClass("hidden"),$(".share-title").addClass("s-hover")):(fdiv.addClass("hidden"),$(".share-title").removeClass("s-hover")))}function praiseInitFun(){$("#eva_all .contentContainer .praise").unbind("click").on("click",function(e){var me=$(this),praiseNum=$(".praise-num"),num=praiseNum.text().replace("(","").replace(")",""),url=common.createUrl("/data/pushpraise.php"),postdata={eva_id:1};if($.ajax({type:"get",url:url,data:postdata,beforeSend:function(XMLHttpRequest){$("#evaluation").mask(" ")},success:function(data,textStatus){var data=$.toJSONObj(data);return data.suc?(praiseNum.text("("+data.data+")"),void me.unbind("click")):void alert(data.code+":"+data.msg)},complete:function(XMLHttpRequest,textStatus){$("#evaluation").unmask()},error:function(){}}),""==num)praiseNum.text(1);else{var newNum=parseInt(num)+1;praiseNum.text("("+newNum+")")}})}if($(".productIntroFloor .share").on({click:shareDisFun,mouseenter:function(e){setTimeout(function(){shareDisFun(e,"show")},100)},mouseleave:function(e){setTimeout(function(){shareDisFun(e,"hide")},100)}}),$(window).on("scroll",function(){var scrollt=$(window).scrollTop(),com=$(".productIntroFloor .tab-title");scrollt>1e3?com.addClass("col-md-120 tabfixed"):com.removeClass("col-md-120 tabfixed")}),$(".productIntroFloor .tab-title ul li a").click(function(){var com=$(".productIntroFloor .tab-title");com.hasClass("tabfixed")&&$(window).scrollTop(990)}),global.debug){$(".include-pro-detail-group-list").html(require("template/pro-detail-group-list.tpl#")),$(".include-pro-detail-eva-tab").html(require("template/pro-detail-eva-tab.tpl#")),$(".include-pro-detail-speparam-tab").html(require("template/pro-detail-speparam-tab.tpl#")),$(".include-pro-detail-support-tab").html(require("template/pro-detail-support-tab.tpl#"));var tpl=require("template/pro-detail-eva-content.tpl#"),template=Handlebars.compile(tpl),html=template([{"content-text":"新的评论  新的评论新的评论新的新的论新的评论评论新的评论新的评论新的评论新的评论","content-pictrue":["picBase/4.png","picBase/4.png","picBase/4.png","picBase/4.png"],grade:"g-star5","eva-text":"好评",info:"DDD-ddd-cc",owner:"影帝A",praise:"99"}]);$("#eva_all .contentContainer").append(html);var tpl1=require("template/pro-detail-support-content.tpl#"),template1=Handlebars.compile(tpl1),html1=template1([{"owner-name":"adsd1123","owner-date":"2015-09-09 11:11:11",content:"sdfsdfsdf",reply:"好评dddd好好评dddd好评dddd好评dddd好好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd好评dddd评dddd好评dddd好评dddd好评dddd好评dddd","reply-date":"DDD-ddd-cc"}]);$("#support .supportlist-ct").append(html1)}$(".btn_eva_more").on("click",function(){var me=$(this),url=common.createUrl("/data/evaluationData.json"),postdata={};$.ajax({type:"get",url:url,data:postdata,beforeSend:function(XMLHttpRequest){$("#evaluation").mask(" ")},success:function(data,textStatus){var data=$.toJSONObj(data);if(!data.suc)return void alert(data.code+":"+data.msg);0==parseInt(data.nextCount)&&me.hide();var tpl=require("template/pro-detail-eva-content.tpl#"),template=Handlebars.compile(tpl),html=template(data.data);$("#eva_all .contentContainer").append(html),praiseInitFun()},complete:function(XMLHttpRequest,textStatus){$("#evaluation").unmask()},error:function(){alert("提交失败")}})}),praiseInitFun(),$(".btn_support_more").on("click",function(){var me=$(this),url=common.createUrl("/data/supportData.json"),postdata={};$.ajax({type:"get",url:url,data:postdata,beforeSend:function(XMLHttpRequest){$("#support").mask(" ")},success:function(data,textStatus){var data=$.toJSONObj(data);if(!data.suc)return void alert(data.code+":"+data.msg);0==parseInt(data.nextCount)&&me.hide();var tpl=require("template/pro-detail-support-content.tpl#"),template=Handlebars.compile(tpl),html=template(data.data);$("#support .supportlist-ct").append(html)},complete:function(XMLHttpRequest,textStatus){$("#support").unmask()},error:function(){alert("提交失败")}})}),Ladda.bind(".ladda-button"),$(".support-btn-commit").on("click",function(){var url=($(this),common.createUrl("/data/support-commit")),postdata={};$.ajax({type:"post",url:url,data:postdata,beforeSend:function(XMLHttpRequest){},success:function(data,textStatus){var data=$.toJSONObj(data);return data.suc?void alert("审核通过后将看到您的咨询。"):void alert(data.code+":"+data.msg)},complete:function(XMLHttpRequest,textStatus){Ladda.stopAll()},error:function(){}})})})});
//# sourceMappingURL=productIntro.js.map