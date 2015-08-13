<div id="logheadCategoryDiv" class="container-fluid logheadCategoryDiv">
  <!-- <div class="col-md-10"></div> -->
  <div class="flexsidediv"></div>
  <!-- Tab panes -->
  <div class="tab-content container-fluid">
    <div class="card visible-sm-block visible-xs-block">吉他</div>
    <div role="tabpanel" class="tab-pane active row hidden-xs hidden-sm" id="tab1">
      <div class="row">
        <div class="col-md-10 hidden-sm hidden-xs"></div>
        <div class="col-md-20 col-sm-20 col-xs-120">
          <ul>
            <li class="title">主要商品</li>
            <?php foreach($guitar_main_product as $row) { ?>
            <li><a href="<?php echo $row['link']; ?>" <?php if($row['is_blank']=='1') { echo 'target="_blank"'; } ?> ><?php echo $row['title']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-md-20 col-sm-20 col-xs-120">
          <ul>
            <li class="title">相关商品</li>
            <?php foreach($guitar_relative_product as $row) { ?>
            <li><a href="<?php echo $row['link']; ?>" <?php if($row['is_blank']=='1') { echo 'target="_blank"'; } ?> ><?php echo $row['title']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-md-30 col-sm-30 col-xs-120">
          <ul class="row">
            <li class="title col-md-120">热门品牌</li>
            <?php foreach($guitar_hot_brand as $row) { ?>
            <li class="col-md-50"><a href="<?php echo $row['link']; ?>" <?php if($row['is_blank']=='1') { echo 'target="_blank"'; } ?> ><img src="<?php echo $row['image_thumb']; ?>" alt="<?php echo $row['title']; ?>"></a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="col-md-40 col-sm-50 col-xs-120 logColor">
          <div class="row">
            <div class="col-md-100 col-sm-120">
              <?php foreach($guitar_banner as $row) { ?>
              <a href="<?php echo $row['link']; ?>" <?php if($row['is_blank']=='1') { echo 'target="_blank"'; } ?> ><img class="img-responsive" src="<?php echo $row['image_thumb']; ?>" alt="<?php echo $row['title']; ?>"></a>
              <div style="word-wrap:break-word;color:#fff;"><?php echo $row['title']; ?> </div>
              <?php } ?>
            </div>
            <div class="col-md-20 hidden-sm hidden-xs"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="card visible-sm-block visible-xs-block">贝司</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab2">1111贝司</div>
    <div class="card visible-sm-block visible-xs-block">鼓</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab3">1111鼓</div>
    <div class="card visible-sm-block visible-xs-block">音箱</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab4">.1111音箱..</div>
    <div class="card visible-sm-block visible-xs-block">效果器</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab5">.111效果器1..</div>
    <div class="card visible-sm-block visible-xs-block">通用配件</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab6">.11通用配件1..</div>
    <div class="card visible-sm-block visible-xs-block">改装配件</div>
    <div role="tabpanel" class="tab-pane hidden-xs hidden-sm" id="tab7">.11改装配件1..</div>
  </div>
  <div class="flexsidediv"></div>
  <!-- <div class="col-md-10"></div> -->
</div>
