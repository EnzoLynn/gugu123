<?php echo $header; ?><?php echo $column_left; ?>
<link href="view/javascript/sku/liandong.css" type="text/css" rel="stylesheet" />
<script src="view/javascript/sku/liandong.js" type="text/javascript"></script>
<div id="content" style="margin-left: 240px;">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_copy; ?>" class="btn btn-default" onclick="$('#form-product-group').attr('action', '<?php echo $copy; ?>').submit()"><i class="fa fa-copy"></i></button>
      </div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form>

          <div class="tab-content">
          <div class="tab-pane active" id="tab-general">
            <div class="tab-content">
              <div class="tab-pane form-horizontal div_contentlist" style="display: block; visibility: visible;">
              <?php foreach($option_data as $key => $option){ ?>
                <div class="form-group">
                  <span class="col-sm-2 control-label Father_Title"><?php echo $option['option_name']; ?></span>
                  <div class="">
                    <ul class="Father_Item<?php echo $key; ?>">
                      <?php foreach($option['option_value_data'] as $option_value) { ?>
                      <li class="li_width"><label><input id="Checkbox1" class="chcBox_Width" value="<?php echo $option_value['name']; ?>" type="checkbox"><?php echo $option_value['name']; ?><span class="li_empty"> </span></label></li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              <?php } ?>

              <div class="form-group">
                <span class="col-sm-2 control-label">商品链接</span>
                <div class="col-sm-10" style="padding-left: 0;">
                  <div id="createTable" class="table"></div>
                </div>
              </div>

              </div>
            </div>
          </div>



        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>