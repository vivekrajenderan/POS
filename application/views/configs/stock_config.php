<?php echo form_open('config/save_locations/store', array('id' => 'stocklocations_config_form', 'class' => 'form-horizontal')); ?>
<div id="config_wrapper">
    <fieldset id="config_info">
        <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
        <ul id="stocklocations_error_message_box" class="error_message_box"></ul>

        <div id="stocklocations">
            <?php $this->load->view('partial/stock_locations', array('stock_locations' => $stock_locations)); ?>
        </div>

        <?php
        echo form_submit(array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => $this->lang->line('common_submit'),
            'class' => 'btn btn-primary btn-sm pull-right'));
        ?>
    </fieldset>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function(){
    var location_count = <?php echo sizeof($stock_locations); ?>;
            var hide_show_remove = function() {
            if ($(".stocklocations_name_input").length > 1){
            $(".remove_stocklocations").show();
            }
            else{
            $(".remove_stocklocations").hide();
            }
            };
            var add_stocklocations = function() {
            var id = $(this).parent().find('.stocklocations_name_input').attr('id');
                    id = id.replace(/.*?_(\d+)$/g, "$1");
                    var block = $(this).parent().clone(true);
                    var new_block = block.insertAfter($(this).parent());
                    ++id;
                    var new_block_name = "stocklocations_name_" + id;
                    var new_block_phone = "stocklocations_phone_" + id;
                    var new_block_address1 = "stocklocations_address1_" + id;
                    var new_block_address2 = "stocklocations_address2_" + id;
                    var new_block_city = "stocklocations_city_" + id;
                    var new_block_state = "stocklocations_state_" + id;
                    var new_block_zip = "stocklocations_zip_" + id;
                    var new_block_country = "stocklocations_country_" + id;
                    $(new_block).find('.stocklocations_name_label').html("<?php echo $this->lang->line('config_warehouse_name'); ?> ").attr('for', new_block_name).attr('class', 'control-label col-xs-2 stocklocations_name_label');
                    $(new_block).find('.stocklocations_name_input').attr('id', new_block_name).removeAttr('disabled').attr('name', "" + new_block_name).attr('class', 'form-control input-sm stocklocations_name_input').val('');
                    $(new_block).find('.stocklocations_phone_label').html("<?php echo $this->lang->line('config_warehouse_phonenumber'); ?> ").attr('for', new_block_phone).attr('class', 'control-label col-xs-2 stocklocations_phone_label');
                    $(new_block).find('.stocklocations_phone_input').attr('id', new_block_phone).removeAttr('disabled').attr('name', new_block_phone).attr('class', 'form-control input-sm stocklocations_phone_input').val('');
                    $(new_block).find('.stocklocations_address1_label').html("<?php echo $this->lang->line('config_warehouse_address1'); ?> ").attr('for', new_block_address1).attr('class', 'control-label col-xs-2 stocklocations_address1_label');
                    $(new_block).find('.stocklocations_address1_input').attr('id', new_block_address1).removeAttr('disabled').attr('name', new_block_address1).attr('class', 'form-control input-sm stocklocations_address1_input').val('');
                    $(new_block).find('.stocklocations_address2_label').html("<?php echo $this->lang->line('config_warehouse_address2'); ?> ").attr('for', new_block_address2).attr('class', 'control-label col-xs-2 stocklocations_address2_label');
                    $(new_block).find('.stocklocations_address2_input').attr('id', new_block_address2).removeAttr('disabled').attr('name', new_block_address2).attr('class', 'form-control input-sm stocklocations_address2_input').val('');
                    $(new_block).find('.stocklocations_city_label').html("<?php echo $this->lang->line('config_warehouse_city'); ?> ").attr('for', new_block_city).attr('class', 'control-label col-xs-2 stocklocations_city_label');
                    $(new_block).find('.stocklocations_city_input').attr('id', new_block_city).removeAttr('disabled').attr('name', new_block_city).attr('class', 'form-control input-sm stocklocations_city_input').val('');
                    $(new_block).find('.stocklocations_state_label').html("<?php echo $this->lang->line('config_warehouse_state'); ?> ").attr('for', new_block_state).attr('class', 'control-label col-xs-2 stocklocations_state_label');
                    $(new_block).find('.stocklocations_state_input').attr('id', new_block_state).removeAttr('disabled').attr('name', new_block_state).attr('class', 'form-control input-sm stocklocations_state_input').val('');
                    $(new_block).find('.stocklocations_zip_label').html("<?php echo $this->lang->line('config_warehouse_zip'); ?> ").attr('for', new_block_zip).attr('class', 'control-label col-xs-2 stocklocations_zip_label');
                    $(new_block).find('.stocklocations_zip_input').attr('id', new_block_zip).removeAttr('disabled').attr('name', new_block_zip).attr('class', 'form-control input-sm stocklocations_zip_input').val('');
                    $(new_block).find('.stocklocations_country_label').html("<?php echo $this->lang->line('config_warehouse_country'); ?> ").attr('for', new_block_country).attr('class', 'control-label col-xs-2 stocklocations_country_label');
                    $(new_block).find('.stocklocations_country_input').attr('id', new_block_country).removeAttr('disabled').attr('name', new_block_country).attr('class', 'form-control input-sm stocklocations_country_input').val('');
                    hide_show_remove();
            };
            var remove_stocklocations = function() {
            $(this).parent().remove();
                    hide_show_remove();
            };
            var init_add_remove_locations = function() {
            $('.add_stocklocations').click(add_stocklocations);
                    $('.remove_stocklocations').click(remove_stocklocations);
                    hide_show_remove();
            };
            init_add_remove_locations();
            var duplicate_found = false;
            // run validator once for all fields
            $.validator.addMethod('stocklocations', function(value, element) {
            var value_count = 0;
                    $(".stocklocations_name_input").each(function() {
            value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
                    return value_count < 2;
            }, "<?php echo $this->lang->line('config_stock_location_duplicate'); ?>");
            $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === - 1;
            }, "<?php echo $this->lang->line('config_stock_location_invalid_chars'); ?>");
            $('#stocklocations_config_form').validate($.extend(form_support.handler, {
    submitHandler: function(form) {
    $(form).ajaxSubmit({
    success: function(response)	{
    $.notify({ message: response.message }, { type: response.success ? 'success' : 'danger'});
            $("#stocklocations").load('<?php echo site_url("config/stock_locations"); ?>', init_add_remove_locations);
    },
            dataType: 'json'
    });
    },
            errorLabelContainer: "#stocklocations_error_message_box",
            rules:{
<?php
$i = 0;
if (count($stock_locations) > 0) {
    foreach ($stock_locations as $location => $location_data) {
        $i = $location_data['location_id'];;
        ?>
        <?php echo 'stocklocations_name_' . $i ?>:
                    {
                    required: true,
                            stocklocations: true,
                            valid_chars: true
                    },
        <?php echo 'stocklocations_phone_' . $i ?>:
                    {
                    number: true
                    },
        <?php
    }
} else {
    $i = 1;
    ?>
    <?php echo 'stocklocations_name_' . $i ?>:
                {
                required: true,
                        stocklocations: true,
                        valid_chars: true
                },
    <?php echo 'stocklocations_phone_' . $i ?>:
                {
                number: true
                },
    <?php
}
?>
            },
            messages:{
<?php
$i = 0;
if (count($stock_locations) > 0) {
    foreach ($stock_locations as $location => $location_data) {
        $i = $location_data['location_id'];;
        ?>
        <?php echo 'stocklocations_name_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_name_required'); ?>",
        <?php echo 'stocklocations_phone_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_phonenumber_invalid'); ?>",
        <?php
    }
} else {
    $i = 1;
    ?>
    <?php echo 'stocklocations_name_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_name_required'); ?>",
    <?php echo 'stocklocations_phone_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_phonenumber_invalid'); ?>",
    <?php
}
?>
            }
    }));
    });
</script>
