<!DOCTYPE html>
<html lang="zh-CN" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="/framework/sea.js"></script>
  <script type="text/javascript" src="/framework/seajs-text.js"></script>
  <script type="text/javascript" src="/framework/seajs-css.js"></script>
  <script type="text/javascript" src="js/seaConfig.js"></script>
  <script type="text/javascript">
    seajs.use("modules/main-index");
  </script>

  <title><?php echo $title; ?></title>
  <base href="<?php echo $base; ?>" />
  <?php if ($description) { ?>
  <meta name="description" content="<?php echo $description; ?>" />
  <?php } ?>
  <?php if ($keywords) { ?>
  <meta name="keywords" content= "<?php echo $keywords; ?>" />
  <?php } ?>
</head>

<body style="display: none;">
<script type="text/javascript">
  window.onresize = function() {
    //console.log(document.body.clientWidth);
  };
</script>

<!-- 分类菜单 侧滑式-->
<!--  <div class="include-indexCategory-Menu container-fluid">
</div> -->
<!-- 新分类菜单 -->
<div class="include-logheadCategoryDiv container-fluid">
</div>
<!-- 顶部 -->
<div class="include-topNavigator container-fluid hidden-sm hidden-xs">
</div>
<!-- Log -->
<div class="include-indexLogFloor container-fluid">
</div>
<div class="clearfix"></div>
<!-- 搜索条 -->
<!--  <div class="include-indexCategory container-fluid">
        </div> -->
<!-- 全幅Banner -->
<div class="include-bannerPlay container-fluid hidden-sm hidden-xs"></div>
<!-- 固定最大宽度 -->
<div class="container-fluid bodyMain">
  <div class="flexsidediv"></div>
  <!-- 页面主体 -->
  <div id="gugumain">
    <!-- 商城品牌 -->
    <div class="include-indexBrandFloor container-fluid">
      <?php echo $indexBrandFloor; ?>
    </div>
    <!-- 商城活动 -->
    <!-- <div class="include-indexActivity container-fluid">
    </div> -->
    <!-- 谷谷互动 -->
    <div class="include-interactiveFloor container-fluid">
    </div>
  </div>
  <div class="flexsidediv"></div>
  <!-- 底部 -->
  <div class="container-fluid indexBottom ">
    <div class="include-indexBottom container-fluid">
    </div>
  </div>
</div>
<!--  <div class="container-fluid indexBottom " >
    <div style="width:100%;min-height: 1px;"></div>

    <div style="width:100%;min-height: 1px;"></div>
</div> -->
</body>

</html>