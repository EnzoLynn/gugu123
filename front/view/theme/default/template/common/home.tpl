<!DOCTYPE html>
<html lang="zh-CN" class="no-js">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="/framework/sea.js"></script>
  <script type="text/javascript" src="/framework/seajs-text.js"></script>
  <script type="text/javascript" src="/framework/seajs-css.js"></script>
  <script type="text/javascript" src="/js/seaConfig.js"></script>
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
  <?php echo $commonSubMenu; ?>
</div>
<!-- 顶部 -->
<div class="include-topNavigator container-fluid hidden-sm hidden-xs">
  <?php echo $commonTopNavigator; ?>
</div>
<!-- Log -->
<div class="logfloor-container container-fluid">
  <div class="include-indexLogFloor container-fluid">
    <?php echo $commonTopMenu; ?>
  </div>
</div>
<div class="clearfix"></div>

<!-- 固定最大宽度 -->
<div class="container-fluid bodyMain">
  <div class="flexsidediv"></div>
  <!-- 页面主体 -->
  <div id="gugumain">
    <!-- 搜索条 -->
    <!--  <div class="include-indexCategory container-fluid">
    </div> -->
    <!-- 全幅Banner -->
    <div class="include-bannerPlay container-fluid">
      <?php echo $indexBannerPlay; ?>
    </div>
    <!-- 热卖商品 -->
    <div class="include-hotProductFloor container-fluid">
      <?php echo $indexHotProduct; ?>
    </div>
    <!-- 商城品牌 -->
    <div class="include-indexBrandFloor container-fluid">
      <?php echo $indexBannerIndex; ?>
    </div>
    <!-- 商城活动 -->
    <!-- <div class="include-indexActivity container-fluid">
    </div> -->
    <!-- 谷谷互动 -->
    <div class="include-interactiveFloor container-fluid">
      <?php echo $indexInteractive; ?>
    </div>
  </div>
  <div class="flexsidediv"></div>
  <!-- 底部 -->
  <div class="container-fluid indexBottom ">
    <div class="include-indexBottom container-fluid">
      <?php echo $commonBottom; ?>
    </div>
  </div>
</div>


</body>

</html>