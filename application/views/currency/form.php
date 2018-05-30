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

<?php echo form_open('currency/save/' . ((isset($id)) ? $id : ''), array('id' => 'currency_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<fieldset id="item_basic_info">


    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('currency_name'), 'name', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-6'>
            <?php
            echo form_input(array(
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control input-sm',
                'value' => (isset($name)) ? $name : '')
            );
            echo form_hidden('id', (isset($id)) ? $id : '')
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('currency_symbol'), 'symbol', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-6'>
            <?php
            echo form_input(array(
                'name' => 'symbol',
                'id' => 'symbol',
                'class' => 'form-control input-sm',
                'value' => (isset($symbol)) ? $symbol : '')
            );
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('currency_code'), 'code', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-6'>
            <?php
            echo form_input(array(
                'name' => 'code',
                'id' => 'code',
                'class' => 'form-control input-sm',
                'value' => (isset($code)) ? $code : '')
            );
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('currency_rate'), 'rate', array('class' => 'required control-label col-xs-3')); ?>
        <div class="col-xs-6">
            <?php
            echo form_input(array(
                'name' => 'rate',
                'id' => 'rate',
                'class' => 'form-control input-sm',
                'value' => (isset($rate)) ? to_currency_no_money($rate) : '')
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


        $("#new").click(function () {
            stay_open = true;
            $("#currency_form").submit();
        });
        $("#submit").click(function () {
            stay_open = false;
        });
        var no_op = function (event, data, formatted) {
        };
        $('#currency_form').validate($.extend({
            submitHandler: function (form, event) {
                $('#error_message_box').html('')
                $(form).ajaxSubmit({
                    success: function (response) {
                        if (response.success) {
                            var stay_open = dialog_support.clicked_id() != 'submit';
                            if (stay_open) {
                                // set action of item_form to url without item id, so a new one can be created
                                $("#currency_form").attr("action", "<?php echo site_url("currency/save/") ?>");
                                // use a whitelist of fields to minimize unintended side effects
                                $('#name,#code,#rate,#symbol').val('');
                                // de-select any checkboxes, radios and drop-down menus
                                $('#tax_available').removeAttr('checked').removeAttr('selected');
                            }
                            else {
                                dialog_support.hide();
                            }
                            table_support.handle_submit('<?php echo site_url('currency'); ?>', response, stay_open);
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
                        name: "required",
                        code: "required",
                        symbol: "required",
                        rate: {
                            required: true,
                            remote: "<?php echo site_url($controller_name . '/check_numeric') ?>"
                        },
                    },
            messages:
                    {
                        name: "<?php echo $this->lang->line('currency_name_required'); ?>",
                        code: "<?php echo $this->lang->line('currency_code_required'); ?>",
                        symbol: "<?php echo $this->lang->line('currency_symbol_required'); ?>",
                        rate: {
                            required: "<?php echo $this->lang->line('currency_rate_required'); ?>",
                            number: "<?php echo $this->lang->line('currency_rate_required'); ?>"
                        }

                    }
        }, form_support.error));
    });
</script>

