<?php echo $header; ?><?php echo $column_left; ?>
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
              <div class="tab-pane form-horizontal" style="display: block; visibility: visible;">
              <?php foreach($option_data as $key => $option){ ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $option['option_name']; ?></label>
                  <div class="col-sm-10">
                    <?php foreach($option['option_value_data'] as $option_value) { ?>
                    <label class="checkbox-inline">
                      <input type="checkbox" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" /><?php echo $option_value['name']; ?>
                    </label>
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>

              <div class="form-group">
                <span class="col-sm-2 control-label">商品链接</span>
                <div class="col-sm-10 table-responsive">
                  <table id="sku" class="table table-bordered"><!--table-striped table-hover-->
                    <thead>
                    <tr>
                      <?php foreach($option_data as $key => $option){ ?>
                      <td class="text-left" style="width: 20%;"><?php echo $option['option_name']; ?></td>
                      <?php } ?>
                      <td class="text-left">文字</td>
                      <td class="text-left">商品链接</td>
                    </tr>
                    </thead>
                    <tbody>
                      <?php $row_number = 0; ?>
                      <?php foreach($option_rows as $row) { ?>
                      <tr>
                        <?php echo $row['html']; ?>
                        <td class="text-left">
                          <input type="hidden" name="item[<?php echo $row_number; ?>][key]" value="<?php echo $row['key']; ?>" />
                          <input type="text" class="form-control" name="item[<?php echo $row_number; ?>][title]" value="<?php if(isset($option_items[$row['key']])) { echo $option_items[$row['key']]['title']; } ?>" />
                        </td>
                        <td class="text-left">
                          <input type="text" name="item[<?php echo $row_number; ?>][product_name]" value="<?php if(isset($option_items[$row['key']])) { echo $option_items[$row['key']]['product_name']; } ?>" class="form-control" />
                          <input type="hidden" name="item[<?php echo $row_number; ?>][product_id]" value="<?php if(isset($option_items[$row['key']])) { echo $option_items[$row['key']]['product_id']; } ?>" />
                        </td>
                      </tr>
                      <?php $row_number++; ?>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              </div>
            </div>
          </div>



      </form>
    </div>
  </div>
</div>
<script>
  function attributeautocomplete(item_id) {
    $('input[name=\'item[' + item_id + '][product_name]\']').autocomplete({
      'multiple' : false,
      'source': function(request, response) {
        $.ajax({
          url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item['name'],
                value: item['product_id']
              }
            }));
          }
        });
      },
      'select': function(item) {
        $('input[name=\'item[' + item_id + '][product_name]\']').val(item['label']);
        $('input[name=\'item[' + item_id + '][product_id]\']').val(item['value']);
      }
    });
  }

  $('#sku tbody tr').each(function(index, element) {
    attributeautocomplete(index);
  });

//合并行操作
  var trs = $("#sku tbody tr");
  var tds = trs.eq(0).find("td");
  var col_number = 0;

  for(var i=0; i<tds.length; i++) {
    var td = tds.eq(i).get(0);
    if(td.childNodes.length==1 && td.childNodes[0].nodeType == 3) {
      col_number++;
    }
  }

  for(var col_idx = col_number-1; col_idx>=0; col_idx--) {
    for (var i = 0; i < trs.length; ) {
      var td = trs.eq(i).children("td:eq("+ col_idx +")");
      var txt = td.text();
      var rowspan = 1;//默认为1
      for (var j = i+1; j < trs.length; j++) {
        if(txt == trs.eq(j).children("td:eq("+ col_idx +")").text()){
          rowspan++;
          trs.eq(j).children("td:eq("+ col_idx +")").remove();
        }else{
          break;
        }
      }
      td.attr('rowspan', rowspan);
      i += rowspan;
    }
  }
</script>
<?php echo $footer; ?>