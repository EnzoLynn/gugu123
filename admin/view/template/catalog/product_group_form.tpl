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
            <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip"><?php echo $entry_option_value_ids; ?></span></label>
            <div class="col-sm-10">
              <input type="text" name="option_value" value="" placeholder="<?php echo $entry_option_value_ids; ?>" id="input-option-value" class="form-control" />
              <div id="option_value" class="well well-sm" style="height: 220px; overflow: auto;">
                <?php foreach ($option_values as $option_value) { ?>
                <div id="option_value<?php echo $option_value['option_value_id']; ?>" class="col-md-3"><i class="fa fa-minus-circle"></i> <?php echo $option_value['name']; ?>
                  <input type="hidden" name="option_value[]" value="<?php echo $option_value['option_value_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
  $('input[name=\'option_value\']').autocomplete({
    'source': function(request, response) {
      $.ajax({
        url: 'index.php?route=catalog/option/autocomplete_option_name&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
        dataType: 'json',
        success: function(json) {
          response($.map(json, function(item) {
            return {
              label: item['group'] + ' &gt; ' + item['name'],
              value: item['option_value_id']
            }
          }));
        }
      });
    },
    'select': function(item) {
      //$('input[name=\'filter\']').val('');

      $('#option_value' + item['value']).remove();

      $('#option_value').append('<div id="option_value' + item['value'] + '" class="col-xs-3"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="option_value[]" value="' + item['value'] + '" /></div>');
    }
  });

  $('#option_value').delegate('.fa-minus-circle', 'click', function() {
    $(this).parent().remove();
  });
  //--></script>
<?php echo $footer; ?>