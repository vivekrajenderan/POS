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
<style>
    .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){
        width:100%;
    }
</style>
<?php echo form_open('promo/updatepromo/' . ((isset($id)) ? $id : ''), array('id' => 'update_promo_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<fieldset id="item_basic_info">

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('promo_name'), 'promo_name', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'promo_name',
                'id' => 'promo_name',
                'class' => 'form-control input-sm',
                'disabled' => 'disabled',
                'value' => (isset($promo_name)) ? $promo_name : '')
            );
            echo form_hidden('id', (isset($id)) ? $id : '')
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('promo_fromdate'), 'promo_fromdate', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-3'>
            <?php
            echo form_input(array(
                'name' => 'promo_fromdate',
                'id' => 'promo_fromdate',
                'class' => 'form-control input-sm',
                'value' => date($this->config->item('dateformat'),strtotime($fromdate)),
            ));
            ?>
        </div>
        <?php echo form_label($this->lang->line('promo_todate'), 'promo_todate', array('class' => 'required control-label col-xs-2')); ?>
        <div class='col-xs-3'>
            <?php
            echo form_input(array(
                'name' => 'promo_todate',
                'id' => 'promo_todate',
                'class' => 'form-control input-sm',
                'value' => date($this->config->item('dateformat'),  strtotime($todate))
            ));
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('promo_type'), 'promo_type', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-3'>
            <?php echo form_dropdown('promo_type', $promo_type_list, $promo_type, array('id' => 'promo_type', 'class' => 'form-control')); ?>
        </div>
        <?php echo form_label($this->lang->line('promo_price'), 'promo_price', array('class' => 'required control-label col-xs-2')); ?>
        <div class="col-xs-3">
            <div class="input-group input-group-sm">
                <?php if (!currency_side()): ?>
                    <span class="input-group-addon input-sm symbol">
                        <b id="change_symbol"><?php echo $this->config->item('currency_symbol'); ?></b>
                    </span>
                <?php endif; ?>
                <?php
                echo form_input(array(
                    'name' => 'promo_price',
                    'id' => 'promo_price',
                    'class' => 'form-control input-sm',
                    'value' => (isset($price)) ? to_currency_no_money($price) : '')
                );
                ?>
                <?php if (currency_side()): ?>
                    <span class="input-group-addon input-sm symbol">
                        <b><?php echo $this->config->item('currency_symbol'); ?></b>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <table id="item_kit_items" class="table table-striped table-hover">
        <thead>
            <tr>
                <th width="50%"><?php echo $this->lang->line('promo_store'); ?></th>
                <th width="50%"><?php echo $this->lang->line('promo_item'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $location_name; ?></td>
                <td><?php echo $itemname; ?></td>
            </tr>
        </tbody>
    </table>
</fieldset>
<?php echo form_close(); ?>
<script type="text/javascript">
    //validation and submit handling
    $(document).ready(function ()
    {
<?php $this->load->view('partial/datepicker_locale'); ?>
        $('#promo_fromdate').datetimepicker({
            format: "<?php echo dateformat_bootstrap($this->config->item("dateformat")); ?>",
            startDate: "<?php echo date($this->config->item('dateformat')); ?>",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: "<?php echo current_language_code(); ?>"
        });
        $('#promo_store').selectpicker();
        
        $('#promo_todate').datetimepicker({
            format: "<?php echo dateformat_bootstrap($this->config->item("dateformat")); ?>",
            startDate: "<?php echo date($this->config->item('dateformat')); ?>",
            autoclose: true,
            todayBtn: true,
            todayHighlight: true,
            bootcssVer: 3,
            language: "<?php echo current_language_code(); ?>"
        });
        
        $('#promo_store').change(function () {
            var control=$(this);
            var allOptionIsSelected = (control.val() || []).indexOf("all") > -1;
            function valuesOf(elements) {
                return $.map(elements, function (element) {
                    return element.value;
                });
            }

            if (control.data('allOptionIsSelected') != allOptionIsSelected) {
                // User clicked 'All' option
                if (allOptionIsSelected) {
                    // Can't use .selectpicker('selectAll') because multiple "change" events will be triggered
                    control.selectpicker('val', valuesOf(control.find('option')));
                } else {
                    control.selectpicker('val', []);
                }
            } else {
                // User clicked other option
                if (allOptionIsSelected && control.val().length != control.find('option').length) {
                    // All options were selected, user deselected one option
                    // => unselect 'All' option
                    control.selectpicker('val', valuesOf(control.find('option:selected[value!=All]')));
                    allOptionIsSelected = false;
                } else if (!allOptionIsSelected && control.val().length == control.find('option').length - 1) {
                    // Not all options were selected, user selected all options except 'All' option
                    // => select 'All' option too
                    control.selectpicker('val', valuesOf(control.find('option')));
                    allOptionIsSelected = true;
                }
            }
            control.data('allOptionIsSelected', allOptionIsSelected);
        })

        $("#item").autocomplete({
            source: '<?php echo site_url("items/suggest"); ?>',
            minChars: 0,
            autoFocus: false,
            delay: 10,
            appendTo: ".modal-content",
            select: function (e, ui) {
                if ($("#item_seq_" + ui.item.value).length == 0)
                {
                    $("#item_kit_items").append("<tr>" +
                            "<td><a href='#' class='delete_promo_item_row'><span class='glyphicon glyphicon-trash'></span></a></td>" +
                            "<td><input type='hidden' class='form-control input-sm' id='item_seq_" + ui.item.value + "' name='product[" + ui.item.value + "]' value='" + ui.item.value + "'/>" + ui.item.label + "</td>" +
                            "</tr>");
                }
                $("#item").val("");
                return false;
            }
        });

        $('#item_kit_items').on('click', '.delete_promo_item_row', function (e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        });
        
        $('#promo_type').change(function(){
            if($(this).val()=='price'){
                $('#change_symbol').text('<?php echo $this->config->item('currency_symbol'); ?>');
            }else{
                $('#change_symbol').text('%');
            }
        });
        $('#promo_type').trigger("change");
        $("#new").click(function () {
            stay_open = true;
            $("#update_promo_form").submit();
        });
        $("#submit").click(function () {
            stay_open = false;
        });
        var no_op = function (event, data, formatted) {
        };
        $('#update_promo_form').validate($.extend({
            submitHandler: function (form, event) {
                $('#error_message_box').html('')
                $(form).ajaxSubmit({
                    success: function (response) {
                        if (response.success) {
                            var stay_open = dialog_support.clicked_id() != 'submit';
                            if (stay_open) {
                                // set action of item_form to url without item id, so a new one can be created
                                $("#update_promo_form").attr("action", "<?php echo site_url("promo/save/") ?>");
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
                        promo_fromdate: "required",
                        promo_todate: "required",
                        promo_price: {
                            required: true,
                            remote: "<?php echo site_url($controller_name . '/check_numeric') ?>"
                        },
                    },
            messages:
                    {
                        promo_fromdate: "<?php echo $this->lang->line('promo_fromdate_required'); ?>",
                        promo_todate: "<?php echo $this->lang->line('promo_todate_required'); ?>",
                        promo_price: {
                            required: "<?php echo $this->lang->line('promo_price_required'); ?>",
                            number: "<?php echo $this->lang->line('promo_price_invalid'); ?>"
                        }

                    }
        }, form_support.error));
    });
</script>