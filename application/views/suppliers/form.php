<div id="required_fields_message"><?php echo $this->lang->line('common_fields_required_message'); ?></div>

<ul id="error_message_box" class="error_message_box"></ul>

<?php echo form_open($controller_name . '/save/' . $person_info->person_id, array('id' => 'supplier_form', 'class' => 'form-horizontal')); ?>
<fieldset id="supplier_basic_info">
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('suppliers_company_name'), 'company_name', array('class' => 'required control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'company_name',
                'id' => 'company_name_input',
                'class' => 'form-control input-sm',
                'value' => $person_info->company_name)
            );
            ?>
        </div>
    </div>

    <div class="form-group form-group-sm">	
        <?php echo form_label($this->lang->line('suppliers_agency_name'), 'agency_name', array('class' => 'control-label col-xs-3')); ?>
        <div class='col-xs-8'>
            <?php
            echo form_input(array(
                'name' => 'agency_name',
                'id' => 'agency_name_input',
                'class' => 'form-control input-sm',
                'value' => $person_info->agency_name)
            );
            ?>
        </div>
    </div>

    <?php $this->load->view("people/form_basic_info"); ?>

    <div class="form-group form-group-sm">	
        <?php echo form_label($this->lang->line('suppliers_account_number'), 'account_number', array('class' => 'control-label col-xs-3 required')); ?>
        <div class='col-xs-8'>
            <?php
            if (isset($account_number) && (isset($account_number['data']) && !empty($account_number['data']))) {
                echo form_input(array(
                    'name' => 'account_id',
                    'id' => 'account_id',
                    'type' => 'hidden',
                    'class' => 'form-control input-sm',
                    'value' => $account_number['data']->name)
                );
            }
            echo form_input(array(
                'name' => 'account_number',
                'id' => 'account_number',
                'class' => 'form-control input-sm',
                'value' => ((isset($account_number) && (isset($account_number['data']) && !empty($account_number['data'])))) ? $account_number['data']->text : '')
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
        $('#supplier_form').validate($.extend({
            submitHandler: function (form)
            {
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        dialog_support.hide();
                        table_support.handle_submit('<?php echo site_url('suppliers'); ?>', response);
                    },
                    dataType: 'json'
                });

            },
            rules:
                    {
                        company_name: "required",
                        first_name: "required",
                        last_name: "required",
                        email: "email",
                        account_number: "required"
                    },
            messages:
                    {
                        company_name: "<?php echo $this->lang->line('suppliers_company_name_required'); ?>",
                        first_name: "<?php echo $this->lang->line('common_first_name_required'); ?>",
                        last_name: "<?php echo $this->lang->line('common_last_name_required'); ?>",
                        account_number: "<?php echo $this->lang->line('common_account_number_required'); ?>"
                    }
        }, form_support.error));
    });

</script>