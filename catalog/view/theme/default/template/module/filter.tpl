
<link type="text/css" rel="stylesheet" href="/catalog/view/javascript/jquery/jquery-ui.min.css" />
<link type="text/css" rel="stylesheet" href="/catalog/view/javascript/jquery/jquery-ui/jquery-ui.theme.min.css" />
<script src="/catalog/view/javascript/jquery/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript">

    function format(value){
        var suymbol_left = "$";
        if(suymbol_left){
            var returns = value+suymbol_left;
        }else{
            var returns = value+"";
        }
        return returns;
    }
    function initializeSlider(selectedMin, selectedMax, slideMin, slideMax) {
        jQuery("#slider-range").slider({
            animate: true,
            range: true,
            min: slideMin,
            max: slideMax,
            step: 5,
            values: [selectedMin, selectedMax],
            slide: function(event, ui) {
                if (ui) {
                    jQuery("#amount").html(format(ui.values[0]) + ' - ' + format(ui.values[1]) );
                    jQuery("#priceMin").val(ui.values[0]);
                    jQuery("#priceMax").val(ui.values[1]);
                }
            },
            stop: function(event, ui) {
                filterChanged('price');
            }
        });

        jQuery("#amount").html(format(jQuery("#slider-range").slider("values", 0) )  + ' - ' + format(jQuery("#slider-range").slider("values", 1)));

        jQuery("#priceMin").val(selectedMin);
        jQuery("#priceMax").val(selectedMax);

        jQuery("table.color-tbl td input:checkbox").each(
                function() {
                    (this.checked) ? jQuery("table.color-tbl td rel[this.id]").addClass('fakechecked') : jQuery("table.color-tbl td rel[this.id]").removeClass('fakechecked');
                }
        );
    }

    jQuery(document).ready(
            function() {
                //jQuery("#slider-range").slider();//'destroy'
                //initializeSlider(10, 200, 1, 500);

                $('#slider-range').slider({
                    range: true,
                    values: [17, 67]
                });

            }
    );
</script>
<!--
<div class="lnav-category-container" id="lnav-price-container" rel="show">
    <div class="lnav-banner">
        <h3 style="display: block;">Price:</h3>
        <div class="expand-collapse-container lnav-collapse" style="display: block;">
        </div>
        <div class="expand-collapse-container lnav-expand active" style="display: none;">
        </div>
    </div>
    <div class="panel panel-default">
        <div class="ui-slider ui-slider-horizontal" id="slider-range">
            <div class="ui-slider-range ui-widget-header" style="left: 17.03%; width: 58.11%;"></div>
            <a class="ui-slider-handle ui-state-default" style="left: 10.03%;" href="#"></a>
            <a class="ui-slider-handle ui-state-default" style="left: 20.15%;" href="#"></a>
        </div>

        <div class="clear-both"></div>
        <div class="price-range" id="amount">86$ - 376$</div>
        <input name="price" id="priceMin" type="hidden" value="86">
        <input name="price" id="priceMax" type="hidden" value="376">
        <input id="priceLowBound" type="hidden" value="86">
        <input id="priceHighBound" type="hidden" value="376">
        <div id="lnav-bottom-link-container">
            <a class="plain" id="clearMoneyRange" onclick="onClearMoneyRange(1, 500, 1, 500);" href="javascript:;">
                Clear</a>
        </div>
    </div>
</div>
-->

<div class="panel panel-default">

  <div class="panel-heading"><?php echo $heading_title; ?></div>



  <div class="list-group">
    <?php foreach ($filter_groups as $filter_group) { ?>
    <a class="list-group-item"><?php echo $filter_group['name']; ?></a>
    <div class="list-group-item">
      <div id="filter-group<?php echo $filter_group['filter_group_id']; ?>">
        <?php foreach ($filter_group['filter'] as $filter) { ?>
        <div class="checkbox">
          <label>
            <?php if (in_array($filter['filter_id'], $filter_category)) { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" checked="checked" />
            <?php echo $filter['name']; ?>
            <?php } else { ?>
            <input type="checkbox" name="filter[]" value="<?php echo $filter['filter_id']; ?>" />
            <?php echo $filter['name']; ?>
            <?php } ?>
          </label>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="panel-footer text-right">
    <button type="button" id="button-filter" class="btn btn-primary"><?php echo $button_filter; ?></button>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filter').on('click', function() {
	filter = [];
	
	$('input[name^=\'filter\']:checked').each(function(element) {
		filter.push(this.value);
	});
	
	location = '<?php echo $action; ?>&filter=' + filter.join(',');
});
//--></script> 
