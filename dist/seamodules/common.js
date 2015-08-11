define(function(require,exports,module){var $=require("jquery");exports.handlerbarsCompare=function(){Handlebars.registerHelper("compare",function(left,operator,right,options){if(arguments.length<3)throw new Error('Handlerbars Helper "compare" needs 2 parameters');var operators={"==":function(l,r){return l==r},"===":function(l,r){return l===r},"!=":function(l,r){return l!=r},"!==":function(l,r){return l!==r},"<":function(l,r){return r>l},">":function(l,r){return l>r},"<=":function(l,r){return r>=l},">=":function(l,r){return l>=r},"typeof":function(l,r){return typeof l==r}};if(!operators[operator])throw new Error('Handlerbars Helper "compare" doesn\'t know the operator '+operator);var result=operators[operator](left,right);return result?options.fn(this):options.inverse(this)})},exports.createUrl=function(url,host,protocol){var d=(new Date).getTime(),keyword="randomD",re=new RegExp("("+keyword+")+=(\\w+)","gi"),mc=url.match(re);mc&&mc.length>0&&(url=url.replace(re,""));var prefix="";return host&&(prefix+=protocol?protocol+host:"http://"+host),-1==url.indexOf("?")?prefix+url+"?"+keyword+"="+d:prefix+url+"&"+keyword+"="+d},exports.getNagavVersion=function(){var s,Sys={},ua=navigator.userAgent.toLowerCase();return(s=ua.match(/msie ([\d.]+)/))?Sys.isIE=s[1]:(s=ua.match(/firefox\/([\d.]+)/))?Sys.isGecko=s[1]:(s=ua.match(/chrome\/([\d.]+)/))?Sys.isWebkit=s[1]:(s=ua.match(/opera.([\d.]+)/))?Sys.IsOpera=s[1]:(s=ua.match(/version\/([\d.]+).*safari/))?Sys.isSafari=s[1]:0,Sys},exports.queue=[],exports.queueInit=function(fun){"function"==typeof fun&&exports.queue.push(fun)},$().ready(function(){$.each(exports.queue,function(index,fun){fun()})}),$.fn.numeral=function(){var me=$(this);me.css("ime-mode","disabled"),this.on("keypress",function(e){var code=e.keyCode?e.keyCode:e.which;if(exports.getNagavVersion().isIE||8!=e.keyCode)return code>=48&&57>=code}),this.on("blur",function(){this.value.lastIndexOf(".")==this.value.length-1?this.value=this.value.substr(0,this.value.length-1):isNaN(this.value)&&(this.value="")}),this.on("paste",function(){var s=clipboardData.getData("text");return!/\D/.test(s),value=s.replace(/^0*/,""),!1}),this.on("dragenter",function(){return!1}),this.on("keyup",function(){/(^0+)/.test(this.value)&&(this.value=this.value.replace(/^0*/,"")),""==this.value&&(this.value=parseInt(me.attr("data-min"))),this.value>parseInt(me.attr("data-max"))&&(this.value=parseInt(me.attr("data-max")))})},$.fn.numcontrol=function(){$(this).on({mousedown:function(e){function task(){if(me.attr("hover")&&"true"==me.attr("hover")){var now=(new Date).getTime(),interval=1e3,duration=now-me.attr("startime");duration/1e3>2&&(interval/=duration/1e3),console.log(interval),me.click(),me.task=setTimeout(task,interval)}}var me=$(this);me.attr("hover",!0),me.attr("startime",(new Date).getTime()),me.task=setTimeout(task,1e3)},mouseleave:function(){var me=$(this);me.attr("hover",!1),me.task&&(clearInterval(me.task),delete me.task)},mouseup:function(e){var me=$(this);me.attr("hover",!1),console,me.task&&(clearInterval(me.task),delete me.task)},click:function(e){var me=$(this),control=$("."+me.attr("controller")),limit=parseInt(me.attr("data-limit")),step=parseInt(me.attr("data-step")),val=parseInt(control.val());step>0?control.val(limit>val?val+step:limit):control.val(val>limit?val+step:limit)}})},Date.prototype.format=function(format){var o={"M+":this.getMonth()+1,"d+":this.getDate(),"h+":this.getHours(),"m+":this.getMinutes(),"s+":this.getSeconds(),"q+":Math.floor((this.getMonth()+3)/3),S:this.getMilliseconds()};/(y+)/.test(format)&&(format=format.replace(RegExp.$1,(this.getFullYear()+"").substr(4-RegExp.$1.length)));for(var k in o)new RegExp("("+k+")").test(format)&&(format=format.replace(RegExp.$1,1==RegExp.$1.length?o[k]:("00"+o[k]).substr((""+o[k]).length)));return format},Array.prototype.contains=function(item){for(i=0;i<this.length;i++)if(this[i]==item)return!0;return!1},Array.prototype.deleteIndex=function(n){return 0>n?this:this.slice(0,n).concat(this.slice(n+1,this.length))},Array.prototype.remove=function(obj){for(var i=0;i<this.length;i++){var temp=this[i];if(isNaN(obj)||(temp=i),temp==obj){for(var j=i;j<this.length;j++)this[j]=this[j+1];this.length=this.length-1}}},jQuery.extend({toJSONObj:function(strJson){var type=typeof strJson;if("string"!=type)return strJson;try{return eval("("+strJson+")")}catch(e){return[]}}}),jQuery.extend({toJSONString:function(object){var type=typeof object;switch("object"==type&&(type=Array==object.constructor?"array":RegExp==object.constructor?"regexp":"object"),type){case"undefined":case"unknown":return;case"function":case"boolean":case"regexp":return object.toString();case"number":return isFinite(object)?object.toString():"null";case"string":return'"'+object.replace(/(\\|\")/g,"\\$1").replace(/\n|\r|\t/g,function(){var a=arguments[0];return"\n"==a?"\\n":"\r"==a?"\\r":"	"==a?"\\t":""})+'"';case"object":if(null===object)return"null";var results=[];for(var property in object){var value=jQuery.toJSONString(object[property]);void 0!==value&&results.push(jQuery.toJSONString(property)+":"+value)}return"{"+results.join(",")+"}";case"array":for(var results=[],i=0;i<object.length;i++){var value=jQuery.toJSONString(object[i]);void 0!==value&&results.push(value)}return"["+results.join(",")+"]"}}}),exports.spellFilter=function(fkey,fvalue,change,del){for(var loadchange="boolean"==typeof change?change:!0,delfilter=del===!0?!0:!1,location=window.location,search=location.search.substring(1,location.search.length),url=location.protocol+"//"+location.host+location.pathname,serArr=search.split("&"),filterObj={},i=0;i<serArr.length;i++){var tempArr=serArr[i].split("=");tempArr[0]&&(filterObj[tempArr[0]]=tempArr[1])}if(delfilter&&delete filterObj[fkey],loadchange){var newSearch="";if(filterObj[fkey]&&!delfilter)for(key in filterObj){var mathRegex=new RegExp("^"+fkey+"$","gi");key.match(mathRegex)?(filterObj[key]=fvalue,newSearch+=key+"="+fvalue+"&"):newSearch+=key+"="+filterObj[key]+"&"}else{delfilter||(filterObj[fkey]=fvalue);for(key in filterObj)newSearch+=key+"="+filterObj[key]+"&"}""!=newSearch?window.location.href=url+"?"+newSearch.substring(0,newSearch.length-1):window.location.href=url}return filterObj}});
//# sourceMappingURL=common.js.map