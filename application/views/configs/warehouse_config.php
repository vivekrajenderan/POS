<?php echo form_open('config/save_locations/warehouse', array('id' => 'warehouse_config_form', 'class' => 'form-horizontal')); ?>
<div id="config_wrapper">
    <fieldset id="config_info">
        <div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
        <ul id="warehouse_error_message_box" class="error_message_box"></ul>

        <div id="warehouse">
            <?php $this->load->view('partial/warehouse', array('warehouse' => $warehouse)); ?>
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
    var location_count = <?php echo sizeof($warehouse); ?>;
            var hide_show_remove = function() {
            if ($(".warehouse_name_input").length > 1){
            $(".remove_warehouse").show();
            }
            else{
            $(".remove_warehouse").hide();
            }
            };
            var add_warehouse = function() {
            var id = $(this).parent().find('.warehouse_name_input').attr('id');
                    id = id.replace(/.*?_(\d+)$/g, "$1");
                    var block = $(this).parent().clone(true);
                    var new_block = block.insertAfter($(this).parent());
                    ++id;
                    var new_block_name = "warehouse_name_" + id;
                    var new_block_phone = "warehouse_phone_" + id;
                    var new_block_address1 = "warehouse_address1_" + id;
                    var new_block_address2 = "warehouse_address2_" + id;
                    var new_block_city = "warehouse_city_" + id;
                    var new_block_state = "warehouse_state_" + id;
                    var new_block_zip = "warehouse_zip_" + id;
                    var new_block_country = "warehouse_country_" + id;
                    $(new_block).find('.warehouse_name_label').html("<?php echo $this->lang->line('config_warehouse_name'); ?> ").attr('for', new_block_name).attr('class', 'control-label col-xs-2 warehouse_name_label');
                    $(new_block).find('.warehouse_name_input').attr('id', new_block_name).removeAttr('disabled').attr('name', "" + new_block_name).attr('class', 'form-control input-sm warehouse_name_input').val('');
                    $(new_block).find('.warehouse_phone_label').html("<?php echo $this->lang->line('config_warehouse_phonenumber'); ?> ").attr('for', new_block_phone).attr('class', 'control-label col-xs-2 warehouse_phone_label');
                    $(new_block).find('.warehouse_phone_input').attr('id', new_block_phone).removeAttr('disabled').attr('name', new_block_phone).attr('class', 'form-control input-sm warehouse_phone_input').val('');
                    $(new_block).find('.warehouse_address1_label').html("<?php echo $this->lang->line('config_warehouse_address1'); ?> ").attr('for', new_block_address1).attr('class', 'control-label col-xs-2 warehouse_address1_label');
                    $(new_block).find('.warehouse_address1_input').attr('id', new_block_address1).removeAttr('disabled').attr('name', new_block_address1).attr('class', 'form-control input-sm warehouse_address1_input').val('');
                    $(new_block).find('.warehouse_address2_label').html("<?php echo $this->lang->line('config_warehouse_address2'); ?> ").attr('for', new_block_address2).attr('class', 'control-label col-xs-2 warehouse_address2_label');
                    $(new_block).find('.warehouse_address2_input').attr('id', new_block_address2).removeAttr('disabled').attr('name', new_block_address2).attr('class', 'form-control input-sm warehouse_address2_input').val('');
                    $(new_block).find('.warehouse_city_label').html("<?php echo $this->lang->line('config_warehouse_city'); ?> ").attr('for', new_block_city).attr('class', 'control-label col-xs-2 warehouse_city_label');
                    $(new_block).find('.warehouse_city_input').attr('id', new_block_city).removeAttr('disabled').attr('name', new_block_city).attr('class', 'form-control input-sm warehouse_city_input').val('');
                    $(new_block).find('.warehouse_state_label').html("<?php echo $this->lang->line('config_warehouse_state'); ?> ").attr('for', new_block_state).attr('class', 'control-label col-xs-2 warehouse_state_label');
                    $(new_block).find('.warehouse_state_input').attr('id', new_block_state).removeAttr('disabled').attr('name', new_block_state).attr('class', 'form-control input-sm warehouse_state_input').val('');
                    $(new_block).find('.warehouse_zip_label').html("<?php echo $this->lang->line('config_warehouse_zip'); ?> ").attr('for', new_block_zip).attr('class', 'control-label col-xs-2 warehouse_zip_label');
                    $(new_block).find('.warehouse_zip_input').attr('id', new_block_zip).removeAttr('disabled').attr('name', new_block_zip).attr('class', 'form-control input-sm warehouse_zip_input').val('');
                    $(new_block).find('.warehouse_country_label').html("<?php echo $this->lang->line('config_warehouse_country'); ?> ").attr('for', new_block_country).attr('class', 'control-label col-xs-2 warehouse_country_label');
                    $(new_block).find('.warehouse_country_input').attr('id', new_block_country).removeAttr('disabled').attr('name', new_block_country).attr('class', 'form-control input-sm warehouse_country_input').val('');
                    hide_show_remove();
            };
            var remove_warehouse = function() {
            $(this).parent().remove();
                    hide_show_remove();
            };
            var init_add_remove_locations = function() {
            $('.add_warehouse').click(add_warehouse);
                    $('.remove_warehouse').click(remove_warehouse);
                    hide_show_remove();
            };
            init_add_remove_locations();
            var duplicate_found = false;
            // run validator once for all fields
            $.validator.addMethod('warehouse', function(value, element) {
            var value_count = 0;
                    $(".warehouse_name_input").each(function() {
            value_count = $(this).val() == value ? value_count + 1 : value_count;
            });
                    return value_count < 2;
            }, "<?php echo $this->lang->line('config_warehouse_duplicate'); ?>");
            $.validator.addMethod('valid_chars', function(value, element) {
            return value.indexOf('_') === - 1;
            }, "<?php echo $this->lang->line('config_warehouse_invalid_chars'); ?>");
            $('#warehouse_config_form').validate($.extend(form_support.handler, {
    submitHandler: function(form) {
    $(form).ajaxSubmit({
    success: function(response)	{
    $.notify({ message: response.message }, { type: response.success ? 'success' : 'danger'});
            $("#warehouse").load('<?php echo site_url("config/warehouse"); ?>', init_add_remove_locations);
    },
            dataType: 'json'
    });
    },
            errorLabelContainer: "#warehouse_error_message_box",
            rules:{
<?php
$i = 0;
if (count($warehouse) > 0) {
    foreach ($warehouse as $location => $location_data) {
        $location_id = $location_data['location_id'];;
        ?>
        <?php echo 'warehouse_name_' . $location_id ?>:
                    {
                    required: true,
                            warehouse: true,
                            valid_chars: true
                    },
        <?php echo 'warehouse_phone_' . $location_id ?>:
                    {
                    number: true
                    },
        <?php
    }
} else {
    $i = 1;
    ?>
    <?php echo 'warehouse_name_' . $i ?>:
                {
                required: true,
                        warehouse: true,
                        valid_chars: true
                },
    <?php echo 'warehouse_phone_' . $i ?>:
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
if (count($warehouse) > 0) {
    foreach ($warehouse as $location => $location_data) {
        $location_id = $location_data['location_id'];;;
        ?>
        <?php echo 'warehouse_name_' . $location_id ?>: "<?php echo $this->lang->line('config_warehouse_name_required'); ?>",
        <?php echo 'warehouse_phone_' . $location_id ?>: "<?php echo $this->lang->line('config_warehouse_phonenumber_invalid'); ?>",
        <?php
    }
} else {
    $i = 1;
    ?>
    <?php echo 'warehouse_name_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_name_required'); ?>",
    <?php echo 'warehouse_phone_' . $i ?>: "<?php echo $this->lang->line('config_warehouse_phonenumber_invalid'); ?>",
    <?php
}
?>
            }
    }));
    });
</script>
