define(function(require,exports,module){var $=require("jquery");require("debug/jquery.fancybox")(window,document,$,void 0),require("modules/jquery.fancybox-buttons")($),$(function(){function pushBtnClick(){var imgList=$("#productImgList a").clone(),last=imgList.first();$("#productImgList").html(""),$.each(imgList,function(index,item){0!=index&&$("#productImgList").append(item)}),$("#productImgList").append(last)}$("#pushNext").on("click",pushBtnClick),$("#pushPre").on("click",pushBtnClick);var fancyboxOpts={prevEffect:"none",nextEffect:"none",closeBtn:!1,scrolling:"visible",helpers:{title:{type:"inside"},buttons:{},overlay:{el:$("#gugumain")}}};$(".fancybox-button").fancybox(fancyboxOpts)})});