define(function(){function getClass(className){if(document.getElementsByClassName)return document.getElementsByClassName(className);for(var tags=document.getElementsByTagName("*"),tagArr=[],i=0;i<tags.length;i++)tags[i]["class"]==className&&(tagArr[tagArr.length]=tags[i]);return tagArr}return{Focus:function(){function byclass(classname){return getClass(classname)[0]}function bytag(tag,obj){return("object"==typeof obj?obj:byclass(obj)).getElementsByTagName(tag)}function inlize(){oPicLis[0].style.filter="alpha(opacity:100)",oPicLis[0].style.opacity=100,oPicLis[0].style.zIndex=5}function changePic(){for(var i=0;i<oPicLis.length;i++)doMove(oPicLis[i],"opacity",0),oPicLis[i].style.zIndex=0,oBtnLis[i].className="",simgLis[i].style.width="73px",simgLis[i].style.height="45px",oBtnLis[i].style.width="77px",oBtnLis[i].style.height="49px";doMove(oPicLis[iActive],"opacity",100),oPicLis[iActive].style.zIndex=5,oBtnLis[iActive].className="active";var color=oPicLis[iActive].getAttribute("data-color");byclass("include-bannerPlay").style.backgroundColor=color?color:"black",simgLis[iActive].style.width="87px",simgLis[iActive].style.height="55px",oBtnLis[iActive].style.width="90px",oBtnLis[iActive].style.height="59px",0==iActive?doMove(bytag("ul",oBtn)[0],"left",0):iActive>=oPicLis.length-2?doMove(bytag("ul",oBtn)[0],"left",-(oPicLis.length-3)*(oBtnLis[0].offsetWidth+4)):doMove(bytag("ul",oBtn)[0],"left",-(iActive-1)*(oBtnLis[0].offsetWidth+4))}function autoplay(){iActive>=oPicLis.length-1?iActive=0:iActive++,changePic()}function getStyle(obj,attr){return obj.currentStyle?obj.currentStyle[attr]:getComputedStyle(obj,!1)[attr]}function doMove(obj,attr,iTarget){clearInterval(obj.timer),obj.timer=setInterval(function(){var iCur=0;iCur="opacity"==attr?parseInt(100*parseFloat(getStyle(obj,attr))):parseInt(getStyle(obj,attr));var iSpeed=(iTarget-iCur)/6;iSpeed=iSpeed>0?Math.ceil(iSpeed):Math.floor(iSpeed),iCur==iTarget?clearInterval(obj.timer):"opacity"==attr?(obj.style.filter="alpha(opacity:"+(iCur+iSpeed)+")",obj.style.opacity=(iCur+iSpeed)/100):obj.style[attr]=iCur+iSpeed+"px"},30)}for(var oPic=(byclass("tFocus"),byclass("tFocus-pic")),oPicLis=bytag("li",oPic),oBtn=byclass("tFocus-btn"),oBtnLis=bytag("li",oBtn),simgLis=bytag("img",oBtn),iActive=0,i=0;i<oPicLis.length;i++)oBtnLis[i].sIndex=i,oBtnLis[i].onclick=function(){this.sIndex!=iActive&&(iActive=this.sIndex,changePic())};byclass("tFocus-leftbtn").onclick=byclass("prev").onclick=function(){iActive--,-1==iActive&&(iActive=oPicLis.length-1),changePic()},byclass("tFocus-rightbtn").onclick=byclass("next").onclick=function(){iActive++,iActive==oPicLis.length&&(iActive=0),changePic()},aTimer=setInterval(autoplay,2e3),inlize(),byclass("tFocus").onmouseover=function(){clearInterval(aTimer)},byclass("tFocus").onmouseout=function(){aTimer=setInterval(autoplay,2e3)}}}});