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
    <?php echo $this->lang->line('module_stock_order'); ?>
    <?php echo anchor($controller_name . "/lists", $this->lang->line('so_history'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;')); ?>

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
                    <?php echo $this->lang->line('receivings_find_or_scan_item'); ?>		
                </label>
            </li>
            <li class="pull-left">
                <?php echo form_input(array('name' => 'item', 'id' => 'item', 'class' => 'form-control input-sm', 'size' => '50', 'tabindex' => '1')); ?>
            </li>            
        </ul>
    </div>
    <?php echo form_close(); ?>
    <!-- Receiving Items List -->

    <table class="sales_table_100 table-responsive" id="register">
        <thead>
            <tr>
                <th ><?php echo $this->lang->line('common_delete'); ?></th>
                <th ><?php echo $this->lang->line('receivings_item_name'); ?></th>
                <th ><?php echo $this->lang->line('receivings_quantity'); ?></th>
                <th ><?php echo $this->lang->line('receivings_update'); ?></th>
            </tr>
        </thead>

        <tbody id="cart_contents">
            <?php
            if (count($cart) == 0) {
                ?>
                <tr>
                    <td colspan='4'>
                        <div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
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
                        <td data-parent="<?php echo 'cart_' . $line; ?>"><?php echo form_input(array('name' => 'quantity', 'class' => 'form-control quantity input-sm', 'value' => to_quantity_decimals($item['quantity']))); ?></td>
                        <td><a href="javascript:$('#<?php echo 'cart_' . $line ?>').submit();" title=<?php echo $this->lang->line('receivings_update') ?> ><span class="glyphicon glyphicon-refresh"></span></a></td>
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
        if (isset($location_names) && $location_names != '') {
            ?>

            <table class="sales_table_100">
                <tr>
                    <th style='width: 55%;'><?php echo $this->lang->line("config_warehouse_name"); ?></th>
                    <th style="width: 45%; text-align: right;"><?php echo $location_names; ?></th>
                </tr>
                <?php
                if (!empty($phone_number)) {
                    ?>
                    <tr>
                        <th style='width: 55%;'><?php echo $this->lang->line("config_warehouse_phonenumber"); ?></th>
                        <th style="width: 45%; text-align: right;"><?php echo $phone_number; ?></th>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if (!empty($supplier_location)) {
                    ?>
                    <tr>
                        <th style='width: 55%;'><?php echo $this->lang->line("receivings_supplier_location"); ?></th>
                        <th style="width: 45%; text-align: right;"><?php echo $supplier_location; ?></th>
                    </tr>
                    <?php
                }
                ?>
            </table>

            <?php echo anchor($controller_name . "/remove_supplier", '<span class="glyphicon glyphicon-remove">&nbsp</span>' . $this->lang->line('common_remove') . ' ' . $this->lang->line('config_warehouse_name'), array('class' => 'btn btn-danger btn-sm', 'id' => 'remove_supplier_button', 'title' => $this->lang->line('common_remove') . ' ' . $this->lang->line('config_warehouse_name')));
            ?>
            <?php
        } else {
            ?>
            <?php echo form_open($controller_name . "/select_supplier", array('id' => 'select_supplier_form', 'class' => 'form-horizontal')); ?>
            <div class="form-group" id="select_customer">
                <label id="supplier_label" for="supplier" class="control-label" style="margin-bottom: 1em; margin-top: -1em;"><?php echo $this->lang->line('so_select_supplier'); ?></label>
                <?php echo form_input(array('name' => 'supplier', 'id' => 'supplier', 'class' => 'form-control input-sm', 'value' => $this->lang->line('so_start_typing_supplier_name'))); ?>
            </div>
            <?php echo form_close(); ?>
            <?php
        }
        ?>

        <div id="finish_sale">
            <?php echo form_open($controller_name . "/complete", array('id' => 'finish_receiving_form', 'class' => 'form-horizontal')); ?>
            <div class="form-group form-group-sm">
                <label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?></label>
                <?php echo form_textarea(array('name' => 'comment', 'id' => 'comment', 'class' => 'form-control input-sm', 'value' => $comment, 'rows' => '4')); ?>

                <?php if ($this->Employee->is_headoffice_in()) { ?>
                    <label for="receiving_status"><?php echo $this->lang->line('receivings_status'); ?></label>
                    <?php echo form_dropdown('receiving_status', array('open' => $this->lang->line('receivings_status_open'), 'draft' => $this->lang->line('receivings_status_draft')), $receiving_status, 'id="receiving_status" class="form-control input-sm"'); ?>
                <?php } else { ?>
                    <input type="hidden" name="receiving_status" value="draft" />
                <?php } ?>

                <?php
                if (count($cart) > 0) {
                    ?>
                    <div class="btn btn-sm btn-danger pull-left" id='cancel_receiving_button'><span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('receivings_cancel_receiving'); ?></div>

                    <div class="btn btn-sm btn-success pull-right" id='finish_receiving_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $this->lang->line('so_complete_receiving'); ?></div>
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
                    source: '<?php echo site_url($controller_name . "/stock_item_search"); ?>',
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
            $(this).attr('value', "<?php echo $this->lang->line('sales_start_typing_item_name'); ?>");
        });

        $('#receiving_status').change(function () {
            $.post('<?php echo site_url($controller_name . "/set_receiving_status"); ?>', {receiving_status: $('#receiving_status').val()});
        })

        $('#comment').keyup(function ()
        {
            $.post('<?php echo site_url($controller_name . "/set_comment"); ?>', {comment: $('#comment').val()});
        });


        $("#recv_print_after_sale").change(function ()
        {
            $.post('<?php echo site_url($controller_name . "/set_print_after_sale"); ?>', {recv_print_after_sale: $(this).is(":checked")});
        });

        $('#item,#supplier,#store').click(function ()
        {
            $(this).attr('value', '');
        });

        $("#supplier").autocomplete(
                {
                    source: '<?php echo site_url($controller_name . "/suggest_warehouse"); ?>',
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
            $(this).attr('value', "<?php echo $this->lang->line('so_start_typing_supplier_name'); ?>");
        });

        dialog_support.init("a.modal-dlg, button.modal-dlg");


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
        $('.quantity').on('blur', function () {
            $value = $(this).val();
            $value = $value.replace(new RegExp(',', 'g'), '');
            if (parseFloat($value) > 0) {
                var index = $(this).parent().attr('data-parent');
                $("#" + index).submit();
            } else {
                $(this).val('1');
                var index = $(this).parent().attr('data-parent');
                $("#" + index).submit();
            }
        });
        $(".quantity").keydown(function (e) {
            if (e.keyCode == 109 || e.keyCode == 173) {
                e.preventDefault();
            }
        });
    });

</script>

<?php $this->load->view("partial/footer"); ?>
