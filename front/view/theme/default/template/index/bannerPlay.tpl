<div class="bannerPlayContainer row hidden-sm hidden-xs" style="background-color: <?php echo $banner_image_first['background']; ?>;">
  <div class="flexsidediv"></div>
  <div class="tFocus" style="width:100%;max-width: 1200px;">
    <div class="prev" id="prev"></div>
    <div class="next" id="next"></div>
    <ul class="tFocus-pic">
      <?php foreach($banner_images as $banner_image) { ?>
      <li data-color="<?php echo $banner_image['background']; ?>">
        <a href="<?php echo $banner_image['link']; ?>" <?php if($banner_image['is_blank']=='1') { echo 'target="_blank"'; } ?> ><img class="img-responsive" lazy_src="<?php echo $banner_image['origin_image']; ?>" alt="<?php echo $banner_image['title']; ?>" /></a>
      </li>
      <?php } ?>
    </ul>
    <div class="tFocusBtn col-md-70 col-md-offset-50   col-lg-offset-50">
      <a href="javascript:void(0);" class="tFocus-leftbtn">上一张</a>
      <div class="tFocus-btn">
        <ul>
          <?php foreach($banner_images as $key=>$banner_image) { ?>
          <?php if($key==0){ ?>
          <li class="active">
            <img lazy_src="<?php echo $banner_image['thumb']; ?>" width="87" height="55" alt="<?php echo $banner_image['title']; ?>" /></li>
          </li>
          <?php }else{ ?>
          <li>
          <img lazy_src="<?php echo $banner_image['thumb']; ?>" width="73" height="45" alt="<?php echo $banner_image['title']; ?>" /></li>
          </li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      <a href="javascript:void(0);" class="tFocus-rightbtn">下一张</a>
    </div>
  </div>
  <!--tFocus end-->
  <div class="flexsidediv"></div>
</div>
