<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>
<?php
if (isset($list) && !empty($list)) {
    ?>
    <?php echo form_open('stock_order/save_status/' . $list['receiving_id'], array('id' => 'item_form', 'class' => 'form-horizontal')); ?>
    <fieldset id="inv_item_basic_info">

        <div class="form-group form-group-sm">
            <?php echo form_label($this->lang->line('so_ref'), 'receiving_ref', array('class' => 'control-label col-xs-3')); ?>
            <div class="col-xs-8">
                <div class="input-group">
                    <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-barcode"></span></span>
                    <?php
                    echo form_input(array(
                        'name' => 'receiving_ref',
                        'id' => 'receiving_ref',
                        'class' => 'form-control input-sm',
                        'disabled' => '',
                        'value' => $list['receiving_ref'])
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group form-group-sm">
            <?php echo form_label($this->lang->line('so_statuschange'), 'receiving_status', array('class' => 'control-label col-xs-3')); ?>
            <div class='col-xs-8'>
                <?php echo form_dropdown('receiving_status', $status_list, $list['receiving_status'], array('class' => 'form-control', 'id' => 'receiving_status')); ?>
            </div>
        </div>

    </fieldset>
    <?php
    echo form_close();
}
?>
<script type="text/javascript">
//validation and submit handling
    $(document).ready(function ()
    {
        $('#item_form').validate({
            submitHandler: function (form)
            {
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        dialog_support.hide();
                        table_support.handle_submit('<?php echo site_url('stock_order'); ?>', response);
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        receiving_status:
                                {
                                    required: true
                                }
                    },
            messages:
                    {
                        receiving_status:
                                {
                                    required: "<?php echo $this->lang->line('so_statuschange_required'); ?>"
                                }
                    }
        });
    });
</script>