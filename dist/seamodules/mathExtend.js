define(function(require,exports,module){Number.prototype.toFixed=function(fractionDigits){return(parseInt(Math.accMul(this,Math.pow(10,fractionDigits)))/Math.pow(10,fractionDigits)).toString()},exports.div=function(arg1,arg2){var r1,r2,t1=0,t2=0;try{t1=arg1.toString().split(".")[1].length}catch(e){}try{t2=arg2.toString().split(".")[1].length}catch(e){}with(Math)return r1=Number(arg1.toString().replace(".","")),r2=Number(arg2.toString().replace(".","")),r1/r2*pow(10,t2-t1)},exports.mul=function(num1,num2){var m=0,s1=num1.toString(),s2=num2.toString();try{m+=s1.split(".")[1].length}catch(e){}try{m+=s2.split(".")[1].length}catch(e){}return Number(s1.replace(".",""))*Number(s2.replace(".",""))/Math.pow(10,m)},exports.add=function(arg1,arg2){var r1,r2,m;try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}return m=Math.pow(10,Math.max(r1,r2)),(arg1*m+arg2*m)/m},exports.sub=function(arg1,arg2){var r1,r2,m,n;try{r1=arg1.toString().split(".")[1].length}catch(e){r1=0}try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}return m=Math.pow(10,Math.max(r1,r2)),n=r1>=r2?r1:r2,((arg1*m-arg2*m)/m).toFixed(n)}});