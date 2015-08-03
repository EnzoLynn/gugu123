<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product-group" class="form-horizontal">

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_group_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="group_name" value="<?php echo $product_group_info['group_name']; ?>" placeholder="<?php echo $entry_group_name; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_option_ids; ?></label>
            <div class="col-sm-10 form-inline">
              <?php foreach ($product_options as $product_option) { ?>
              <div class="checkbox" style="margin-left: 10px;">
                <label>
                  <input type="checkbox" name="product_option_id[]" value="<?php echo $product_option['option_id'];?>" <?php if(in_array($product_option['option_id'], $product_option_ids)){ echo 'checked';} ?>> <?php echo $product_option['name'];?>
                </label>
              </div>
              <?php } ?>

            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>