<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open($controller_name . '/saverole/' . $role_info->id, array('id' => 'employee_form', 'class' => 'form-horizontal')); ?>


<fieldset>
    <div class="form-group form-group-sm">	
        <?php echo form_label($this->lang->line('employees_role_name'), 'role_name', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'name',
                'id' => 'name',
                'class' => 'form-control input-sm',
                'value' => $role_info->name)
            );
            ?>

        </div>
    </div>
    <?php
    if (isset($role) && !empty($role)) {
        ?>
        <div class="form-group form-group-sm">
            <?php echo form_label($this->lang->line('common_role'), 'employees_login', array('class' => 'control-label col-xs-3')); ?>
            <div class='col-xs-8'>
                <?php echo form_dropdown('login_type', $role, $selected_login_type, array('class' => 'form-control', 'id' => 'login_type')); ?>
            </div>
        </div>
    <?php } ?>
</fieldset>



<fieldset>
    <div class="form-group form-group-sm">

        <p class="text-center"><?php echo $this->lang->line("employees_permission_desc"); ?></p>
        <div class="col-xs-12 col-md-8 col-sm-8 col-md-offset-3 col-sm-offset-3">
            <?php $this->load->view("employees/form_role"); ?>
        </div>
    </div>
</fieldset>

</div>
<?php echo form_close(); ?>
<script type="text/javascript">
//validation and submit handling
    $(document).ready(function ()
    {
        $.validator.setDefaults({ignore: []});
        $.validator.addMethod("module", function (value, element) {
            var result = $("#permission_list input").is(":checked");
            $(".module").each(function (index, element)
            {
                var parent = $(element).parent();
                var checked = $(element).is(":checked");
                if ($("ul", parent).length > 0 && result)
                {
                    result &= !checked || (checked && $("ul > li > input:checked", parent).length > 0);
                }
            });
            return result;
        }, '<?php echo $this->lang->line('employees_subpermission_required'); ?>');
        $("ul#permission_list > li > input[name='grants[]']").each(function ()
        {
            var $this = $(this);
            $("ul > li > input", $this.parent()).each(function ()
            {
                var $that = $(this);
                var updateCheckboxes = function (checked)
                {
                    $that.prop("disabled", !checked);
                    !checked && $that.prop("checked", false);
                }
                $this.change(function () {
                    updateCheckboxes($this.is(":checked"));
                });
                updateCheckboxes($this.is(":checked"));
            });
        });
        $('#employees_login').change(function () {
            $value = $(this).val();
            $access = [];
            $access['headoffice'] = '';
            $access['warehouse'] = ['customers', 'sales', 'employees', 'giftcards', 'messages', 'taxes', 'config', 'stockorder_check', 'stock_order'];
            $access['store'] = ['suppliers', 'purchase_order', 'grn', 'employees', 'giftcards', 'messages', 'taxes', 'config', 'pay', 'requisition'];
            $('#permission_list li').each(function () {
                if ($.inArray($(this).attr('data-value'), $access[$value]) >= 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
            if ($value != 'headoffice') {
                $('#permission_list li ul li').each(function () {
                    if ($(this).attr('data-location_type') != $value && $(this).attr('data-location_type') != '') {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            }
        });
        $('#employees_login').trigger('change');
        $('#employee_form').validate($.extend({
            submitHandler: function (form)
            {
                $('#error_message_box').html('')
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        if (response.success) {
                            dialog_support.hide();
                            table_support.handle_submit('<?php echo site_url('employees'); ?>', response);
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
                        name:
                                {
                                    required: true,
                                    Exist_role: true
                                },
                        login_type: "required",
                    },
            messages:
                    {
                        name:
                                {
                                    required: "<?php echo $this->lang->line('employees_role_name_required'); ?>"
                                },
                        login_type: "<?php echo $this->lang->line('employees_access_required'); ?>",
                    }
        }, form_support.error));
        $.validator.addMethod("Exist_role", function (value, element) {
            if (value.length >= 3)
            {
                var role_id = "<?php echo $role_info->id; ?>";
                var login_type = $("#login_type").val();
                var checkRole = check_exist_role(login_type, value, role_id);
                if (checkRole == "1")
                {
                    return false;
                }
            }
            return true;

        }, "Role Already Exists!");
    });
    function check_exist_role(login_type, role_name, role_id) {
        var isSuccess = 0;
        $.ajax({
            type: "GET",
            url: "<?php echo base_url(); ?>employees/check_role_exist",
            data: "login_type=" + login_type + "&name=" + role_name + "&role_id=" + role_id,
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "1" ? 1 : 0
                    }
        });
        return isSuccess;
    }
</script>