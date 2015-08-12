define(function(require,exports,module){var $=require("jquery");require("handlebars");var common=require("modules/common");require("css/global.css"),require("css/bootstrap.css"),require("css/bootstrapValidator.min.css"),require("css/ladda.min.css"),require("css/indexCategory.css"),require("css/indexLogFloor.css"),require("css/topNavigator.css"),require("css/register.css"),require("css/indexBottom.css");var common=(require("modules/bootstrapValidator.sea")($),require("modules/bootstrap.sea")($),require("modules/common"));require("modules/spin.min"),require("modules/ladda.min"),$(function(){global.debug&&($(".include-topNavigator").html(require("template/topNavigator.tpl")),$(".include-indexLogFloor").html(require("template/indexLogFloor.tpl")),$(".include-logheadCategoryDiv").html(require("template/logheadCategoryDiv.tpl")),$(".include-indexBottom").html(require("template/indexBottom.tpl"))),require("modules/indexTopNavigator"),require("modules/indexLogFloor"),require.async("modules/lazyLoad",function(imgLoad){imgLoad.init(["img","vidio"])}),$(".registerForm").bootstrapValidator({message:"验证失败",feedbackIcons:{valid:"glyphicon glyphicon-ok",invalid:"glyphicon glyphicon-remove",validating:"glyphicon glyphicon-refresh"},fields:{username:{message:"The username is not valid",validators:{notEmpty:{message:"不能为空"},stringLength:{min:6,max:30,message:"长度6~30"}}},email:{validators:{notEmpty:{message:"不能为空"},emailAddress:{message:"邮箱格式错误"}}}}});var form=$(".registerForm").data("bootstrapValidator");form.validate(),$(".submit").click(function(){form.isValid()?$.getJSON(common.createUrl("../testData.json"),function(data){console.log(data)}).done(function(){}).fail(function(){alert("error")}).always(function(){}):common.alertEx({msg:"false"})}),Ladda.bind(".ladda-button",{timeout:2e3})})});
//# sourceMappingURL=main-register.js.map