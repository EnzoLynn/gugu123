define(function(require,exports,module){var $=require("jquery");require("modules/jquery.loadmask")($);var common=require("modules/common");require("css/jquery.loadmask.css"),require("handlebars"),common.handlerbarsCompare(),require("modules/jquery.cookie")($),$(function(){function initCartItemsFun(data,noitems){if(noitems)return $(".joinCartGrop .cart-pro-item-ct tbody").append("<tr><td>没有任何物品.</td></tr>"),$(".cart-pro-total").html("0"),void $(".gotopay").addClass("disabled");var tpl=require("template/cart-pro-item.tpl#"),template=Handlebars.compile(tpl),html=template(data);$(".joinCartGrop .cart-pro-item-ct tbody").html(""),$(".joinCartGrop .cart-pro-item-ct tbody").append(html),$(".pro-num").text(data.length),$(".gotopay").removeClass("disabled"),$(".txtNum").numeral(),$(".addon-control").numcontrol(),$(".delpro a").click(function(){var me=$(this),url=common.createUrl("/data/control.php"),postdata={pid:me.attr("class")};$.ajax({type:"post",url:url,data:postdata,beforeSend:function(XMLHttpRequest){me.parents("tr").mask()},success:function(data,textStatus){var data=$.toJSONObj(data);return data.suc?($(".cart-pro-total").html(data["total-price"]),"0"==parseInt(data.total)?void initCartItemsFun(!1,!0):($("."+me.attr("class")).remove(),initCartItemsFun(data.data),void $.cookie("cart-pro-items",$.toJSONString(data.data)))):void alert(data.code+":"+data.msg)},complete:function(XMLHttpRequest,textStatus){me.parents("tr").unmask()},error:function(){}})})}var watch_cmDiv="",istouch=!1,watch_cateDiv="";$(".logmenu li").on({mouseover:function(e){watch_cateDiv&&""!=watch_cateDiv&&clearInterval(watch_cateDiv);var me=$(this);$(".cate-ul-container li").removeClass("active"),me.addClass("active");var acTab=$(this).children("a").attr("tab"),tabpanelList=$(".logheadCategoryDiv>.tab-content>.tab-pane");$(tabpanelList).each(function(index,item){$(item).removeClass("active")}),$(acTab).addClass("active"),istouch=!0;var top=e.currentTarget.offsetParent.offsetTop+95,left=0;watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv=setInterval(function(){e.currentTarget.offsetParent&&(top=e.currentTarget.offsetParent.offsetTop+95),left=0,$("#logheadCategoryDiv").css({top:top,left:left})},50)},mouseleave:function(e){var me=$(this);setTimeout(function(){istouch||(watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv="",$("#logheadCategoryDiv").css({left:"-10000px"}),me.removeClass("active"))},500),istouch=!1}}),$(".logheadCategoryDiv").on({mouseenter:function(){istouch=!0},mouseleave:function(){watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv="",$("#logheadCategoryDiv").css({left:"-10000px"}),istouch=!1,$(".cate-ul-container li").removeClass("active")}}),$(".catergroybtn").on("click",function(){watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),$("#logheadCategoryDiv").hasClass("navLeft")?(watch_cateDiv&&""!=watch_cateDiv&&clearInterval(watch_cateDiv),$("#logheadCategoryDiv").removeClass("navLeft"),$(".bodyMain").removeClass("navRight")):($("#logheadCategoryDiv").addClass("navLeft"),$(".bodyMain").addClass("navRight"),watch_cateDiv=setInterval(function(){document.body.clientWidth<=global.smPx?($("#logheadCategoryDiv").addClass("navLeft"),$(".bodyMain").addClass("navRight")):($("#logheadCategoryDiv").removeClass("navLeft"),$(".bodyMain").removeClass("navRight"))},50))});var oldDiv="";$(".card").on("click",function(){var nextDiv=$(this).next("div");oldDiv&&oldDiv.hide();var tabpanelList=$(".logheadCategoryDiv>.tab-content>.tab-pane");$(tabpanelList).each(function(index,item){$(item).removeClass("active")});var flag=nextDiv.hasClass("hidden-sm");flag?(nextDiv.removeClass("hidden-sm hidden-xs"),$(nextDiv).addClass("active")):nextDiv.addClass("hidden-sm hidden-xs")});var url=common.createUrl("/data/cart-proData.json"),postdata={};$.ajax({type:"get",url:url,data:postdata,beforeSend:function(XMLHttpRequest){$(".joinCartGrop .cart-pro-item-ct tbody").html("<tr><td>正在加载...</td></tr>")},success:function(data,textStatus){var data=$.toJSONObj(data);return data.suc?($(".cart-pro-total").html(data["total-price"]),"0"==parseInt(data.total)?void initCartItemsFun(!1,!0):(initCartItemsFun(data.data),void $.cookie("cart-pro-items",$.toJSONString(data.data)))):void alert(data.code+":"+data.msg)},complete:function(XMLHttpRequest,textStatus){},error:function(){$(".joinCartGrop .cart-pro-item-ct tbody").html("<tr><td>加载失败.</td></tr>")}}),$(".joinc").on({mouseover:function(e){var me=$(this);$(".cart-f-div").show(),me.hasClass("hovershadow")||me.addClass("hovershadow")},mouseleave:function(e){var me=$(this);$(".cart-f-div").hide(),me.hasClass("hovershadow")&&me.removeClass("hovershadow")}}),global.debug})});
//# sourceMappingURL=indexLogFloor.js.map