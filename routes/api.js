var express = require('express');
var router = express.Router();
var apiConfig = require('../routes/apiConfig.js');
//var path = require('path'); 

/* get 咨询 */
router.get('/getSupportMore', function(req, res, next) { 
	res.status(200).sendfile(apiConfig.apiConfig.getSupportMore);
	//res.sendfile(path.join(__dirname,apiConfig.apiConfig.getSupportMore)); 
});
// get 评价
router.get('/getEvaMore', function(req, res, next) { 
	res.status(200).sendfile(apiConfig.apiConfig.getEvaMore); 
});

// post one 加入购物车
router.post('/postOneJoinCart', function(req, res, next) { 
	res.status(200).send({suc:true}); 
});

// post  提交咨询
router.post('/postSupport', function(req, res, next) { 
	res.status(200).send({suc:true}); 
});

//post detail 加入购物车
router.post('/postDetailJoinCart', function(req, res, next) { 
	res.status(200).send({suc:true}); 
});


//post logfloor 删除购物车项目
router.post('/postDelCartItem', function(req, res, next) { 
	res.status(200).sendfile(apiConfig.apiConfig.postDelCartItem); 
});

//get 购物车项目
router.get('/getCartInfo',function(req, res, next){
	res.status(200).sendfile(apiConfig.apiConfig.getCartInfo); 
});

module.exports = router;
