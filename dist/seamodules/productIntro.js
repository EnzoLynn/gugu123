define(function(require,exports,module){var $=require("jquery");require("modules/jquery.loadmask")($);var common=require("modules/common");require("css/jquery.loadmask.css"),require("handlebars"),Handlebars.registerHelper("compare",function(left,operator,right,options){if(arguments.length<3)throw new Error('Handlerbars Helper "compare" needs 2 parameters');var operators={"==":function(l,r){return l==r},"===":function(l,r){return l===r},"!=":function(l,r){return l!=r},"!==":function(l,r){return l!==r},"<":function(l,r){return r>l},">":function(l,r){return l>r},"<=":function(l,r){return r>=l},">=":function(l,r){return l>=r},"typeof":function(l,r){return typeof l==r}};if(!operators[operator])throw new Error('Handlerbars Helper "compare" doesn\'t know the operator '+operator);var result=operators[operator](left,right);return result?options.fn(this):options.inverse(this)}),$(function(){function shareDisFun(e,type){console.log(type);var fdiv=($(this),$(".share-fdiv"));return type?void("show"==type?($(".share-title").addClass("s-hover"),fdiv.removeClass("hidden")):(fdiv.addClass("hidden"),$(".share-title").removeClass("s-hover"))):void(fdiv.hasClass("hidden")?(fdiv.removeClass("hidden"),$(".share-title").addClass("s-hover")):(fdiv.addClass("hidden"),$(".share-title").removeClass("s-hover")))}if($(".btn_eva_more").on("click",function(){var me=$(this),url=common.createUrl("/data/evaluationData.json"),postdata={};$.ajax({type:"get",url:url,data:postdata,beforeSend:function(XMLHttpRequest){$("#evaluation").mask(" ")},success:function(data,textStatus){var data=$.toJSONObj(data);data.suc||alert(data.code+":"+data.msg),0==parseInt(data.nextCount)&&me.hide();var tpl=require("template/pro_eva_content.tpl#"),template=Handlebars.compile(tpl),html=template(data.data);$("#eva_all .contentContainer").append(html)},complete:function(XMLHttpRequest,textStatus){$("#evaluation").unmask()},error:function(){alert("提交失败")}})}),$(".productIntroFloor .share").on({click:shareDisFun,mouseenter:function(e){setTimeout(function(){shareDisFun(e,"show")},100)},mouseleave:function(e){shareDisFun(e,"hide")}}),global.debug){var tpl=require("template/pro_eva_content.tpl#"),template=Handlebars.compile(tpl),html=template([{"content-text":"新的评论  新的评论新的评论新的新的论新的评论评论新的评论新的评论新的评论新的评论","content-pictrue":["picBase/4.png","picBase/4.png","picBase/4.png","picBase/4.png"],grade:"g-star5","eva-text":"好评",info:"DDD-ddd-cc",owner:"影帝A",praise:"99"}]);$("#eva_all .contentContainer").append(html)}})});