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

<?php echo form_open('currency/updatecurrency/' . ((isset($id)) ? $id : ''), array('id' => 'currency_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<fieldset id="item_basic_info">



    <?php echo form_hidden('id', (isset($id)) ? $id : '')
    ?>
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('expenses_date'), 'expense_date', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-6'>
            <?php
            echo form_input(array(
                'name' => 'currency_date',
                'id' => 'currency_date',
                'class' => 'form-control input-sm',
                'value' => changeDateTime(date('Y-m-d H:i:s'))));
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
                'value' => ''
            ));
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

        $('#currency_date').datetimepicker({
            format: "<?php echo dateformat_bootstrap($this->config->item("dateformat") . " " . $this->config->item("timeformat")); ?>",
            startDate: "<?php echo date($this->config->item('dateformat'), mktime(date('H'), date('m'), date('s'), 1, 1, 2010)); ?>",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: "<?php echo current_language_code(); ?>"
        });
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
                            } else {
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
                        currency_date: "required",
                        rate: {
                            required: true,
                            number: true,
                            remote: "<?php echo site_url($controller_name . '/check_numeric') ?>"
                        },
                    },
            messages:
                    {
                        currency_date: "<?php echo $this->lang->line('currency_date_required'); ?>",
                        rate: {
                            required: "<?php echo $this->lang->line('currency_rate_required'); ?>",
                            number: "<?php echo $this->lang->line('currency_rate_number_required'); ?>",
                        }

                    }
        }, form_support.error));
    });
</script>

