<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error . "</div>";
}

if (!empty($warning)) {
    echo "<div class='alert alert-dismissible alert-warning'>" . $warning . "</div>";
}

if (isset($success)) {
    echo "<div class='alert alert-dismissible alert-success'>" . $success . "</div>";
}
?>
<div id="page_title" class="text-center">
    <?php echo $this->lang->line('module_stockorder_check');?>
    <?php echo anchor($controller_name."/lists",  $this->lang->line('stockordercheck_list'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button','style'=>'margin-left: 3px;')); ?>

</div>
<div id="register_wrapper">
    <?php
    if ($show_store_locations) {
        ?>
        <?php echo form_open($controller_name . "/change_mode", array('id' => 'mode_form', 'class' => 'form-horizontal panel panel-default')); ?>
        <div class="panel-body form-group">
            <ul>
                <li class="pull-left first_li"> <label class="control-label"><?php echo $this->lang->line('receivings_stock_source'); ?></label></li>
                <li class="pull-left ">
                    <?php echo form_dropdown('store', $store_locations, $stock_source, array('onchange' => "$('#mode_form').submit();", 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit')); ?>
                </li>
            </ul>
        </div>
        <?php echo form_close(); ?>
        <?php
    }
    ?>
    <?php echo form_open($controller_name . "/add", array('id' => 'add_item_form', 'class' => 'form-horizontal panel panel-default')); ?>
    <div class="panel-body form-group">
        <ul>
            <li class="pull-left first_li">
                <label for="item" class='control-label'>
                    <?php echo $this->lang->line('stockordercheck_find_or_scan_req'); ?>
                </label>
            </li>
            <li class="pull-left">
                <?php echo form_input(array('name' => 'item', 'id' => 'item', 'class' => 'form-control input-sm', 'size' => '50', 'tabindex' => '1')); ?>
            </li>
            <?php if ((isset($stock_order_id) && $stock_order_id != '') && count($cart) > 0) { ?>
                <li class="pull-left">
                    <label for="item" class='control-label'>
                        <?php echo $this->lang->line('stockordercheck_req_ref') . ' : ' . $stock_order_id; ?> 
                    </label>
                </li>
            <?php } ?>            
        </ul>
    </div>
    <?php echo form_close(); ?>
    <?php //pr($cart); ?>
    <!-- Receiving Items List -->
    <table class="sales_table_100" id="register">
        <thead>
            <tr>
                <th style="width:5%;"><?php echo $this->lang->line('common_delete'); ?></th>
                <th style="width:45%;"><?php echo $this->lang->line('receivings_item_name'); ?></th>
                <th style="width:10%;"><?php echo $this->lang->line('grn_requested_quantity'); ?></th>
                <th style="width:10%;"><?php echo $this->lang->line('grn_receiving_qty'); ?></th>
                <th style="width:10%;"><?php echo $this->lang->line('grn_requesting_qty'); ?></th>
                <th style="width:5%;"><?php echo $this->lang->line('receivings_update'); ?></th>
            </tr>
        </thead>

        <tbody id="cart_contents">
            <?php
            if (count($cart) == 0) {
                ?>
                <tr>
                    <td colspan='6'>
                        <div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('stockordercheck_no_req_in_cart'); ?></div>
                    </td>
                </tr>
                <?php
            } else {
                foreach (array_reverse($cart, TRUE) as $line => $item) {
                    ?>
                    <?php echo form_open($controller_name . "/edit_item/$line", array('class' => 'form-horizontal', 'id' => 'cart_' . $line)); ?>
                    <tr>
                        <td><?php echo anchor($controller_name . "/delete_item/$line", '<span class="glyphicon glyphicon-trash"></span>'); ?></td>
                        <td style="align:center;">
                            <?php echo $item['name']; ?>
                        </td>
                        <td><?php echo form_hidden('requested_quantity', to_quantity_decimals($item['requested_quantity'])); ?><?php echo to_quantity_decimals($item['requested_quantity']); ?></td>
                        <td><?php echo form_hidden('received_quantity', to_quantity_decimals($item['received_quantity'])); ?><?php echo to_quantity_decimals($item['received_quantity']); ?></td>
                        <td data-parent="<?php echo 'cart_' . $line; ?>"><?php echo form_input(array('name' => 'receiving_quantity', 'class' => 'form-control input-sm receiving_quantity', 'value' => to_quantity_decimals($item['receiving_quantity']))); ?></td>
                        <td ><a href="javascript:$('#<?php echo 'cart_' . $line ?>').submit();" title=<?php echo $this->lang->line('receivings_update') ?> ><span class="glyphicon glyphicon-refresh"></span></a></td>
                    </tr>
                    <?php echo form_close(); ?>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Overall Receiving -->

<div id="overall_sale" class="panel panel-default">
    <div class="panel-body">
        <?php
        if (isset($store_location_names) && count($cart) > 0) {
            ?>
            <table class="sales_table_100">
                <tr>
                    <th style='width: 55%;'><?php echo $this->lang->line("config_warehouse_name"); ?></th>
                    <th style="width: 45%; text-align: right;"><?php echo $store_location_names; ?></th>
                </tr>
                <?php
                if (!empty($store_phone_number)) {
                    ?>
                    <tr>
                        <th style='width: 55%;'><?php echo $this->lang->line("config_warehouse_phonenumber"); ?></th>
                        <th style="width: 45%; text-align: right;"><?php echo $store_phone_number; ?></th>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($supplier_location)) {
                    ?>
                    <tr>
                        <th style='width: 55%;'><?php echo $this->lang->line("receivings_supplier_location"); ?></th>
                        <th style="width: 45%; text-align: right;"><?php echo $store_location; ?></th>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        ?>
        <div id="finish_sale">
            <?php echo form_open($controller_name . "/complete", array('id' => 'finish_receiving_form', 'class' => 'form-horizontal')); ?>
            <div class="form-group form-group-sm">
                <label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?></label>
                <?php echo form_textarea(array('name' => 'comment', 'id' => 'comment', 'class' => 'form-control input-sm', 'value' => $comment, 'rows' => '4')); ?>
                <?php
                if (count($cart) > 0) {
                    ?>

                    <div class='btn btn-sm btn-danger pull-left' id='cancel_receiving_button'><span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('receivings_cancel_receiving') ?></div>

                    <div class='btn btn-sm btn-success pull-right' id='finish_receiving_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $this->lang->line('stockordercheck_send') ?></div>
                    <?php
                }
                ?>
            </div>
            <?php echo form_close(); ?>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#item").autocomplete(
                {
                    source: '<?php echo site_url($controller_name . "/stock_order_search"); ?>',
                    minChars: 0,
                    delay: 10,
                    autoFocus: false,
                    select: function (a, ui) {
                        $(this).val(ui.item.value);
                        $("#add_item_form").submit();
                        return false;
                    }
                });

        $('#item').focus();

        $('#item').keypress(function (e) {
            if (e.which == 13) {
                $('#add_item_form').submit();
                return false;
            }
        });

        $('#item').blur(function ()
        {
            $(this).attr('value', "<?php echo $this->lang->line('stockordercheck_start_typing_req_ref'); ?>");
        });

        $('#comment').keyup(function ()
        {
            $.post('<?php echo site_url($controller_name . "/set_comment"); ?>', {comment: $('#comment').val()});
        });

        $('#recv_reference').keyup(function ()
        {
            $.post('<?php echo site_url($controller_name . "/set_reference"); ?>', {recv_reference: $('#recv_reference').val()});
        });

        $("#recv_print_after_sale").change(function ()
        {
            $.post('<?php echo site_url($controller_name . "/set_print_after_sale"); ?>', {recv_print_after_sale: $(this).is(":checked")});
        });

        $('#item,#supplier').click(function ()
        {
            $(this).attr('value', '');
        });

        $("#supplier").autocomplete(
                {
                    source: '<?php echo site_url("suppliers/suggest"); ?>',
                    minChars: 0,
                    delay: 10,
                    select: function (a, ui) {
                        $(this).val(ui.item.value);
                        $("#select_supplier_form").submit();
                    }
                });

        dialog_support.init("a.modal-dlg, button.modal-dlg");

        $('#supplier').blur(function ()
        {
            $(this).attr('value', "<?php echo $this->lang->line('receivings_start_typing_supplier_name'); ?>");
        });

        $("#finish_receiving_button").click(function ()
        {
            $('#finish_receiving_form').submit();
        });

        $("#cancel_receiving_button").click(function ()
        {
            if (confirm('<?php echo $this->lang->line("receivings_confirm_cancel_receiving"); ?>'))
            {
                $('#finish_receiving_form').attr('action', '<?php echo site_url($controller_name . "/cancel_receiving"); ?>');
                $('#finish_receiving_form').submit();
            }
        });

        $("#cart_contents input").keypress(function (event)
        {
            if (event.which == 13)
            {
                $(this).parents("tr").prevAll("form:first").submit();
            }
        });

        table_support.handle_submit = function (resource, response, stay_open)
        {
            if (response.success)
            {
                if (resource.match(/suppliers$/))
                {
                    $("#supplier").attr("value", response.id);
                    $("#select_supplier_form").submit();
                }
                else
                {
                    $("#item").attr("value", response.id);
                    if (stay_open)
                    {
                        $("#add_item_form").ajaxSubmit();
                    }
                    else
                    {
                        $("#add_item_form").submit();
                    }
                }
            }
        }

        $('[name="price"],[name="discount"],[name="description"],[name="serialnumber"]').blur(function () {
            var index = $(this).parents("tr").index();
            $("#cart_" + index).submit();
        });
        $('.receiving_quantity').on('blur', function () {
            var index = $(this).parent().attr('data-parent');
            $("#" + index).submit();
        });
        $(".receiving_quantity").keydown(function (e) {
            if (e.keyCode == 109 || e.keyCode == 173) {
                e.preventDefault();
            }
        });
    });

</script>

<?php $this->load->view("partial/footer"); ?>
