<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>
<?php
if (isset($error_list)) {
    echo '<ul id="error_message_box" class="error_message_box"></ul>';
    foreach ($error_list as $key => $value) {
        echo "<li>" . $value . "</div>";
    }
    echo '</ul>';
} else {
    echo '<ul id="error_message_box" class="error_message_box"></ul>';
}
?>

<?php echo form_open('expenses/save/' . ((isset($id)) ? $id : ''), array('id' => 'expenses_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<fieldset id="item_basic_info">

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_date'), 'expense_date', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'expenses_date',
                'id' => 'expenses_date',
                'class' => 'form-control input-sm',
                'value' => (isset($expenses_date)) ? $expenses_date : '')
            );
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_account'), 'from_account', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
//              echo form_dropdown('from_account', $fromaccount_list, $fromaccount, array('class' => 'form-control')); 
            echo '<select name="from_account" id="from_account" class="form-control"> ';
            echo $fromaccount_list;
            echo "</select>";
            ?>
        </div>
    </div>
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_currency'), 'payment_currency', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php echo form_dropdown('payment_currency', $currency_list, $basecurrency, array('id' => 'payment_currency', 'class' => 'form-control')); ?>

        </div>



    </div>
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_amount'), 'amount', array('class' => 'required control-label col-xs-3')); ?>
        <div class="col-xs-3">
            <div class="input-group input-group-sm">
                <?php if (!currency_side()): ?>
                    <span class="input-group-addon input-sm"><b id="change_symbol"><?php echo $this->config->item('currency_symbol'); ?></b></span>
                <?php endif; ?>
                <?php
                echo form_input(array(
                    'name' => 'amount',
                    'id' => 'amount',
                    'class' => 'form-control input-sm',
                    'value' => (isset($amount)) ? to_currency_no_money($amount) : '')
                );
                ?>
                <?php if (currency_side()): ?>
                    <span class="input-group-addon input-sm"><b><?php echo $this->config->item('currency_symbol'); ?></b></span>
                <?php endif; ?>
            </div>
        </div>

        <?php echo form_label($this->lang->line('expenses_tax'), 'tax_id', array('class' => 'control-label col-xs-1')); ?>
        <div class='col-xs-4'>
            <?php echo form_dropdown('tax_id', $tax_list, $tax_name, array('class' => 'form-control')); ?>
        </div>
    </div>




    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_tax_available'), 'tax_available', !empty($basic_version) ? array('class' => 'required control-label col-xs-3') : array('class' => 'control-label col-xs-3')); ?>
        <div class="col-xs-8">
            <label class="radio-inline">
                <?php
                echo form_radio(array(
                    'name' => 'tax_available',
                    'type' => 'radio',
                    'id' => 'tax_available',
                    'value' => 1,
                    'checked' => (isset($tax_available)) ? $tax_available : '')
                );
                ?> <?php echo $this->lang->line('expenses_tax_include'); ?>
            </label>
            <label class="radio-inline">
                <?php
                echo form_radio(array(
                    'name' => 'tax_available',
                    'type' => 'radio',
                    'id' => 'tax_available',
                    'value' => 0,
                    'checked' => (isset($tax_available)) ? $tax_available : '')
                );
                ?> <?php echo $this->lang->line('expenses_tax_exclude'); ?>
            </label>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_paidthrough'), 'to_account', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            //echo form_dropdown('to_account', $toaccount_list, $toaccount, array('class' => 'form-control')); 
            echo '<select name="to_account" id="to_account" class="form-control"> ';
            echo $toaccount_list;
            echo "</select>";
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('items_supplier'), 'supplier_id', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php echo form_dropdown('supplier_id', $supplier_list, $supplier, array('class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_reference'), 'reference', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'reference',
                'id' => 'reference',
                'class' => 'form-control input-sm',
                'value' => isset($reference) ? $reference : '')
            );
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_note'), 'note', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_textarea(array(
                'name' => 'note',
                'id' => 'note',
                'class' => 'form-control input-sm',
                'value' => isset($note) ? $note : '')
            );
            ?>
        </div>
    </div>

</fieldset>
<?php echo form_close(); ?>

<script type="text/javascript">
    //validation and submit handling
    $(document).ready(function ()
    {
<?php $this->load->view('partial/datepicker_locale'); ?>

        $('#expenses_date').datetimepicker({
            format: "<?php echo dateformat_bootstrap($this->config->item("dateformat")); ?>",
            startDate: "<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, 1, 1, 2010)); ?>",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: "<?php echo current_language_code(); ?>"
        });


        $("#new").click(function () {
            stay_open = true;
            $("#expenses_form").submit();
        });
        $("#submit").click(function () {
            stay_open = false;
        });
        var no_op = function (event, data, formatted) {
        };
        $('#expenses_form').validate($.extend({
            submitHandler: function (form, event) {
                $('#error_message_box').html('')
                $(form).ajaxSubmit({
                    success: function (response) {
                        if (response.success) {
                            var stay_open = dialog_support.clicked_id() != 'submit';
                            if (stay_open) {
                                // set action of item_form to url without item id, so a new one can be created
                                $("#expenses_form").attr("action", "<?php echo site_url("expenses/save/") ?>");
                                // use a whitelist of fields to minimize unintended side effects
                                $('#item_form,#note').val('');
                                // de-select any checkboxes, radios and drop-down menus
                                $('#tax_available').removeAttr('checked').removeAttr('selected');
                            } else {
                                dialog_support.hide();
                            }
                            table_support.handle_submit('<?php echo site_url('expenses'); ?>', response, stay_open);
                        } else {
                            $(response.error).each(function (index, currProgram) {
                                $.each(currProgram, function (k, v) {
                                    $('#error_message_box').append('<li>' + v + '</li>')
                                });
                            });
                            $('#error_message_box').show();
                        }
                    },
                    dataType: 'json'
                });
            },
            rules:
                    {
                        expenses_date: "required",
                        to_account: "required",
                        from_account: "required",
                        tax_id: "required",
                        tax_available: "required",
                        supplier_id: "required",
                        reference: "required",
                        amount: {
                            required: true,
                            remote: "<?php echo site_url($controller_name . '/check_numeric') ?>"
                        },
                        payment_currency: "required"
                    },
            messages:
                    {
                        expenses_date: "<?php echo $this->lang->line('expenses_date_required'); ?>",
                        to_account: "<?php echo $this->lang->line('expenses_paidthrough_required'); ?>",
                        from_account: "<?php echo $this->lang->line('expenses_account_required'); ?>",
                        tax_id: "<?php echo $this->lang->line('expenses_tax_required'); ?>",
                        tax_available: "<?php echo $this->lang->line('expenses_tax_include_required'); ?>",
                        supplier_id: "<?php echo $this->lang->line('expenses_supplier_required'); ?>",
                        reference: "<?php echo $this->lang->line('expenses_reference_required'); ?>",
                        amount: {
                            required: "<?php echo $this->lang->line('expenses_amount_required'); ?>",
                            number: "<?php echo $this->lang->line('expenses_amount_required'); ?>"
                        },
                        payment_currency: "<?php echo $this->lang->line('expenses_currency_required'); ?>"
                    }
        }, form_support.error));

        $("#payment_currency").change(function () {
            var thisvalue = $(this).find("option:selected").text();
            var result = thisvalue.match(/\((.*)\)/);
            var checksymbol = (result != null) ? result[1] : "";
            $("#change_symbol").text(checksymbol);
        });
    });
</script>

