define(function(require,exports,module){var $=require("jquery");$().ready(function(){var watch_cmDiv="",istouch=!1,watch_cateDiv="";$(".logmenu li").on({mouseover:function(e){watch_cateDiv&&""!=watch_cateDiv&&clearInterval(watch_cateDiv);var acTab=$(this).children("a").attr("tab"),tabpanelList=$(".logheadCategoryDiv>.tab-content>.tab-pane");$(tabpanelList).each(function(index,item){$(item).removeClass("active")}),$(acTab).addClass("active"),istouch=!0;var top=e.currentTarget.offsetParent.offsetTop+120,left=0;watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv=setInterval(function(){e.currentTarget.offsetParent&&(top=e.currentTarget.offsetParent.offsetTop+120),left=0,$("#logheadCategoryDiv").css({top:top,left:left})},50)},mouseleave:function(e){setTimeout(function(){istouch||(watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv="",$("#logheadCategoryDiv").css({left:"-10000px"}))},500),istouch=!1}}),$(".logheadCategoryDiv").on({mouseenter:function(){istouch=!0},mouseleave:function(){watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),watch_cmDiv="",$("#logheadCategoryDiv").css({left:"-10000px"}),istouch=!1}}),$(".catergroybtn").on("click",function(){watch_cmDiv&&""!=watch_cmDiv&&clearInterval(watch_cmDiv),$("#logheadCategoryDiv").hasClass("navLeft")?(watch_cateDiv&&""!=watch_cateDiv&&clearInterval(watch_cateDiv),$("#logheadCategoryDiv").removeClass("navLeft"),$(".bodyMain").removeClass("navRight")):($("#logheadCategoryDiv").addClass("navLeft"),$(".bodyMain").addClass("navRight"),watch_cateDiv=setInterval(function(){document.body.clientWidth<=global.smPx?($("#logheadCategoryDiv").addClass("navLeft"),$(".bodyMain").addClass("navRight")):($("#logheadCategoryDiv").removeClass("navLeft"),$(".bodyMain").removeClass("navRight"))},50))});var oldDiv="";$(".card").on("click",function(){var nextDiv=$(this).next("div");oldDiv&&oldDiv.hide();var tabpanelList=$(".logheadCategoryDiv>.tab-content>.tab-pane");$(tabpanelList).each(function(index,item){$(item).removeClass("active")});var flag=nextDiv.hasClass("hidden-sm");flag?(nextDiv.removeClass("hidden-sm hidden-xs"),$(nextDiv).addClass("active")):nextDiv.addClass("hidden-sm hidden-xs")})})});