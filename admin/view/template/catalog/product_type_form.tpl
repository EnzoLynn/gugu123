<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product-type" class="form-horizontal">

                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_type_name; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="type_name" value="<?php echo $product_type_info['type_name']; ?>" placeholder="<?php echo $entry_type_name; ?>" id="input-sort-order" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="col-sm-2 control-label"><?php echo $entry_filter_group_ids; ?></label>
                        <div class="col-sm-10 form-inline">
                            <?php foreach ($filter_groups as $filter_group) { ?>
                            <div class="checkbox" style="margin-left: 10px;">
                                <label>
                                    <input type="checkbox" name="filter_group_id[]" value="<?php echo $filter_group['filter_group_id'];?>" <?php if(in_array($filter_group['filter_group_id'], $filter_groups_ids)){ echo 'checked';} ?>> <?php echo $filter_group['name'];?>
                                </label>
                            </div>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="col-sm-2 control-label"><?php echo $entry_attribute_ids; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="attribute" value="" placeholder="<?php echo $entry_attribute_ids; ?>" class="form-control" />
                            <div id="attribute" class="well well-sm">
                                <?php foreach ($attributes as $attribute) { ?>
                                <div id="attribute_id<?php echo $attribute['attribute_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $attribute['name']; ?>
                                    <input type="hidden" name="attribute_id[]" value="<?php echo $attribute['attribute_id']; ?>" />
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
<script type="text/javascript">
    // Filter
    $("input[name='attribute']").autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?route=catalog/attribute/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            category: item.attribute_group,
                            label: item.name,
                            value: item.attribute_id
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            //$("input[name='attribute']").val('');
            //$('#attribute_id' + item['value']).remove();

            $('#attribute').append('<div id="attribute_id' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['category'] + ' &gt; ' + item['label'] + '<input type="hidden" name="attribute_id[]" value="' + item['value'] + '" /></div>');
        }
    });

    $('#attribute').delegate('.fa-minus-circle', 'click', function() {
        $(this).parent().remove();
    });
</script>
<?php echo $footer; ?>