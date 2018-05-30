<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error . "</div>";
}

if (isset($error_list)) {
    foreach ($error_list as $key => $value) {
        echo "<div class='alert alert-dismissible alert-danger'>" . $value . "</div>";
    }
}

if (!empty($warning)) {
    echo "<div class='alert alert-dismissible alert-warning'>" . $warning . "</div>";
}

if (isset($success)) {
    echo "<div class='alert alert-dismissible alert-success'>" . $success . "</div>";
}
?>
<div id="page_title" class="text-center">
    <?php echo $this->lang->line('module_pay'); ?>
    <?php echo anchor($controller_name . "/lists", ' <span class="glyphicon glyphicon-list">&nbsp</span>' . $this->lang->line('pay_list'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;')); ?>
    <?php echo anchor($controller_name . "/bill", ' <span class="glyphicon glyphicon-list">&nbsp</span>' . $this->lang->line('bill_list'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;')); ?>

</div>

<?php if (count($supplier_list) > 0) { ?>
    <div id="register_wrapper">

        <!-- Top register controls -->
        <?php
        if ($show_stock_locations || count($supplier_list) > 0) {
            ?>
            <?php echo form_open($controller_name . "/change_mode", array('id' => 'mode_form', 'class' => 'form-horizontal panel panel-default')); ?>
            <div class="panel-body form-group">
                <ul>

                    <?php if ($show_stock_locations) { ?>
                        <li class="pull-left">
                            <label class="control-label"><?php echo $this->lang->line('receivings_stock_source'); ?></label>
                        </li>
                        <li class="pull-left">
                            <?php echo form_dropdown('stock_source', $stock_locations, $stock_source, array('onchange' => "$('#mode_form').submit();", 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit')); ?>
                        </li>
                    <?php } ?>
                    <li class="pull-left">
                        <label class="control-label"><?php echo $this->lang->line('receivings_supplier'); ?></label>
                    </li>
                    <li class="pull-left">
                        <?php echo form_dropdown('supplier', $supplier_list, $supplier, array('onchange' => "$('#mode_form').submit();", 'id' => 'supplier', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit')); ?>
                    </li>

                </ul>

            </div>
            <?php
            echo form_close();
        }
        ?>
        <?php echo form_open($controller_name . "/add", array('id' => 'add_item_form', 'class' => 'form-horizontal panel panel-default')); ?>
        <div class="panel-body form-group">
            <ul>
                <li class="pull-left first_li">
                    <label for="item" class='control-label'>
                        <?php echo $this->lang->line('pay_find_or_scan_bill'); ?>		
                    </label>
                </li>
                <li class="pull-left">
                    <?php echo form_input(array('name' => 'item', 'id' => 'item', 'class' => 'form-control input-sm', 'size' => '50', 'tabindex' => '1')); ?>
                </li>
            </ul>
        </div>
        <?php echo form_close(); ?>
        <!-- Receiving Items List -->

        <table class="sales_table_100" id="register">
            <thead>
                <tr>
                    <th style="width:5%;"><?php echo $this->lang->line('common_delete'); ?></th>
                    <th style="width:45%;"><?php echo $this->lang->line('pay_item_name'); ?></th>
                    <th style="width:10%;"><?php echo $this->lang->line('receivings_quantity'); ?></th>
                    <th style="width:10%;" ><?php echo $this->lang->line('receivings_cost'); ?></th>
                    <th style="width:10%;" ><?php echo $this->lang->line('receivings_total'); ?></th>
                    <th style="width:5%;" ><?php echo $this->lang->line('receivings_update'); ?></th>
                </tr>
            </thead>

            <tbody id="cart_contents">
                <?php
                if (count($cart) == 0) {
                    ?>
                    <tr>
                        <td colspan='6'>
                            <div class='alert alert-dismissible alert-info'><?php echo $this->lang->line('pay_no_bill_in_cart'); ?></div>
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
                                <?php echo $item['payment_ref']; ?>
                                <?php echo form_hidden('location', $item['item_location']); ?>
                            </td>
                            <td >
                                <?php echo $item['total_quantity']; ?>
                                <?php echo form_hidden('total_quantity', to_currency_no_money($item['total_quantity'])); ?>
                            </td>
                            <td >
                                <?php echo $item['totl_billcost']; ?>
                                <?php echo form_hidden('totl_billcost', to_currency($item['totl_billcost'])); ?>
                            </td>
                            <td data-parent="<?php echo 'cart_' . $line; ?>"><?php echo form_input(array('name' => 'price', 'class' => 'form-control price input-sm', 'value' => to_currency_no_money($item['sending_price']))); ?></td>
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
    <?php
//if (count($cart) > 0) {
    ?>
    <div id="overall_sale" class="panel panel-default">
        <div class="panel-body">
            <?php
            if (isset($supplier) && $supplier != -1) {
                ?>
                <table class="sales_table_100">
                    <tr>
                        <th style='width: 55%;'><?php echo $this->lang->line("receivings_supplier"); ?></th>
                        <th style="width: 45%; text-align: right;"><?php echo $suppliers; ?></th>
                    </tr>
                    <?php
                    if (!empty($supplier_email)) {
                        ?>
                        <tr>
                            <th style='width: 55%;'><?php echo $this->lang->line("receivings_supplier_email"); ?></th>
                            <th style="width: 45%; text-align: right;"><?php echo $supplier_email; ?></th>
                        </tr>
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($supplier_address)) {
                        ?>
                        <tr>
                            <th style='width: 55%;'><?php echo $this->lang->line("receivings_supplier_address"); ?></th>
                            <th style="width: 45%; text-align: right;"><?php echo $supplier_address; ?></th>
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
                <?php
            }
            ?>




            <table class="sales_table_100" id="sale_totals">
                <tr>
                    <th style="width: 55%;" ><?php echo $this->lang->line('sales_total'); ?></th>
                    <th style="width: 45%; text-align: right;" ><?php echo $rate['symbol'] . to_quantity_decimals($rate['rate'] * $total); ?></th>
                </tr>
            </table>
            <div id="finish_sale">
                <?php echo form_open($controller_name . "/set_currency", array('id' => 'set_currency', 'class' => 'form-horizontal')); ?>
                <div class="form-group form-group-sm">
                    <label id="comment_label" for="payment_currency"><?php echo $this->lang->line('currency'); ?></label>
                    <?php echo form_dropdown('payment_currency', $currency_list, $basecurrency, array('id' => 'payment_currency', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'auto')); ?>
                </div>
                <?php echo form_close(); ?>

                <?php echo form_open($controller_name . "/complete", array('id' => 'finish_receiving_form', 'class' => 'form-horizontal')); ?>
                <div class="form-group form-group-sm">
                    <label id="comment_label" for="comment"><?php echo $this->lang->line('common_comments'); ?></label>
                    <?php echo form_textarea(array('name' => 'comment', 'id' => 'comment', 'class' => 'form-control input-sm', 'value' => $comment, 'rows' => '4')); ?>

                    <table class="sales_table_100" id="payment_details">
                        <tr>
                            <td><?php echo $this->lang->line('receivings_print_after_sale'); ?></td>
                            <td>
                                <?php echo form_checkbox(array('name' => 'recv_print_after_sale', 'id' => 'recv_print_after_sale', 'class' => 'checkbox', 'value' => 1, 'checked' => $print_after_sale)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo form_label($this->lang->line('receivings_reference'), 'recv_reference', array('class' => 'required control-label')); ?>
                            </td>
                            <td>
                                <?php echo form_input(array('name' => 'recv_reference', 'id' => 'recv_reference', 'class' => 'form-control input-sm', 'value' => $reference, 'size' => 5)); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo form_label($this->lang->line('sales_payment'), 'payment_type', array('class' => 'required control-label')); ?>
                            </td>
                            <td>
                                <?php echo form_dropdown('payment_type', $payment_options, array(), array('id' => 'payment_types', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'auto')); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo form_label($this->lang->line('pay_payment_date'), 'payment_date', array('class' => 'required control-label')); ?>
                            </td>
                            <td>
                                <?php echo form_input(array('name' => 'payment_date', 'value' => date($this->config->item('dateformat') . ' ' . $this->config->item("timeformat")), 'id' => 'datetime', 'class' => 'form-control input-sm', 'readonly' => 'true')); ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                    if (count($cart) > 0) {
                        ?>
                        <div class='btn btn-sm btn-danger pull-left' id='cancel_receiving_button'><span class="glyphicon glyphicon-remove">&nbsp</span><?php echo $this->lang->line('receivings_cancel_receiving') ?></div>

                        <div class='btn btn-sm btn-success pull-right' id='finish_receiving_button'><span class="glyphicon glyphicon-ok">&nbsp</span><?php echo $this->lang->line('receivings_complete_receiving') ?></div>
                    <?php } ?>
                </div>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
    <?php
//}
    ?>
    <script type="text/javascript">
        $(document).ready(function ()
        {


            $("#item").autocomplete(
                    {
                        source: '<?php echo site_url($controller_name . "/bill_search"); ?>',
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
            $('#datetime').datetimepicker({
            format: "<?php echo dateformat_bootstrap($this->config->item("dateformat")) . ' ' . dateformat_bootstrap($this->config->item("timeformat")); ?>",
                    startDate: "<?php echo date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat')); ?>",
    <?php
    $t = $this->config->item('timeformat');
    $m = $t[strlen($t) - 1];
    if (strpos($this->config->item('timeformat'), 'a') !== false || strpos($this->config->item('timeformat'), 'A') !== false) {
        ?>
                showMeridian: true,
        <?php
    } else {
        ?>
                showMeridian: false,
        <?php
    }
    ?>
            minuteStep: 1,
                    autoclose: true,
                    todayBtn: true,
                    todayHighlight: true,
                    bootcssVer: 3,
                    language: "<?php echo current_language_code(); ?>"
        });
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
        $('#payment_currency').change(function () {
            $("#set_currency").submit();
        })
        $('#item,#supplier').click(function ()
        {
            $(this).attr('value', '');
        });
        $("#supplier").autocomplete({
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

        $('[name="discount"],[name="description"],[name="serialnumber"]').blur(function () {
            var index = $(this).parents("tr").index();
            $("#cart_" + index).submit();
        });
        $('.price').on('blur', function () {
            var index = $(this).parent().attr('data-parent');
            $("#" + index).submit();
        });
        $(".price").keydown(function (e) {
            if (e.keyCode == 109 || e.keyCode == 173) { 
                e.preventDefault();
            }
        });
        });    </script>
        <?php if (count($supplier_list) > 0 && count($cart) == 0 && empty($supplier)) { ?>
        <script>
                    $(document).ready(function () {

                setTimeout(function () {
                    $("#supplier").trigger("change");
                }, 1000);

            });
        </script>
    <?php } ?>
<?php } else { ?>
    <div class='alert alert-dismissible alert-success'>
        <?php echo $this->lang->line('pay_list_empty'); ?>
    </div>
<?php } ?>
<?php $this->load->view("partial/footer"); ?>
