<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_first_name'), 'first_name', array('class' => 'required control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'first_name',
            'id' => 'first_name',
            'class' => 'form-control input-sm',
            'value' => $person_info->first_name)
        );
        ?>

    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_last_name'), 'last_name', array('class' => 'required control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'last_name',
            'id' => 'last_name',
            'class' => 'form-control input-sm',
            'value' => $person_info->last_name)
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
            <?php echo form_dropdown('employees_login', $role, $selected_employees_login, array('class' => 'form-control', 'id' => 'employees_login')); ?>
        </div>
    </div>
    <div class="form-group form-group-sm">
        <?php echo form_label($this->lang->line('suppliers_account_number'), 'employees_login', array('class' => 'control-label col-xs-3')); ?>
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
                echo form_label($account_number['data']->name, 'name', array('class' => 'control-label'));
            }
            ?>
        </div>
    </div>
    <?php
}
?>
<div class="form-group form-group-sm">
    <?php echo form_label($this->lang->line('employees_role_type'), 'role_type', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <select class="form-control input-sm" name="role_id" id="role_id">

        </select>
    </div>
</div>


<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_gender'), 'gender', !empty($basic_version) ? array('class' => 'required control-label col-xs-3') : array('class' => 'control-label col-xs-3')); ?>
    <div class="col-xs-4">
        <label class="radio-inline">
            <?php
            echo form_radio(array(
                'name' => 'gender',
                'type' => 'radio',
                'id' => 'gender',
                'value' => 1,
                'checked' => $person_info->gender === '1')
            );
            ?> <?php echo $this->lang->line('common_gender_male'); ?>
        </label>
        <label class="radio-inline">
            <?php
            echo form_radio(array(
                'name' => 'gender',
                'type' => 'radio',
                'id' => 'gender',
                'value' => 0,
                'checked' => $person_info->gender === '0')
            );
            ?> <?php echo $this->lang->line('common_gender_female'); ?>
        </label>

    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_email'), 'email', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <div class="input-group">
            <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-envelope"></span></span>
            <?php
            echo form_input(array(
                'name' => 'email',
                'id' => 'email',
                'class' => 'form-control input-sm',
                'value' => $person_info->email)
            );
            ?>
        </div>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_phone_number'), 'phone_number', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <div class="input-group">
            <span class="input-group-addon input-sm"><span class="glyphicon glyphicon-phone-alt"></span></span>
            <?php
            echo form_input(array(
                'name' => 'phone_number',
                'id' => 'phone_number',
                'class' => 'form-control input-sm',
                'value' => $person_info->phone_number)
            );
            ?>
        </div>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_address_1'), 'address_1', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'address_1',
            'id' => 'address_1',
            'class' => 'form-control input-sm',
            'value' => $person_info->address_1)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_address_2'), 'address_2', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'address_2',
            'id' => 'address_2',
            'class' => 'form-control input-sm',
            'value' => $person_info->address_2)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_city'), 'city', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'city',
            'id' => 'city',
            'class' => 'form-control input-sm',
            'value' => $person_info->city)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_state'), 'state', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'state',
            'id' => 'state',
            'class' => 'form-control input-sm',
            'value' => $person_info->state)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_zip'), 'zip', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'zip',
            'id' => 'postcode',
            'class' => 'form-control input-sm',
            'value' => $person_info->zip)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_country'), 'country', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_input(array(
            'name' => 'country',
            'id' => 'country',
            'class' => 'form-control input-sm',
            'value' => $person_info->country)
        );
        ?>
    </div>
</div>

<div class="form-group form-group-sm">	
    <?php echo form_label($this->lang->line('common_comments'), 'comments', array('class' => 'control-label col-xs-3')); ?>
    <div class='col-xs-8'>
        <?php
        echo form_textarea(array(
            'name' => 'comments',
            'id' => 'comments',
            'class' => 'form-control input-sm',
            'value' => $person_info->comments)
        );
        ?>
    </div>
</div>

<script type="text/javascript">
//validation and submit handling
    $(document).ready(function ()
    {
        nominatim.init({
            fields: {
                postcode: {
                    dependencies: ["postcode", "city", "state", "country"],
                    response: {
                        field: 'postalcode',
                        format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                    }
                },
                city: {
                    dependencies: ["postcode", "city", "state", "country"],
                    response: {
                        format: ["postcode", "village|town|hamlet|city_district|city", "state", "country"]
                    }
                },
                state: {
                    dependencies: ["state", "country"]
                },
                country: {
                    dependencies: ["state", "country"]
                }
            },
            language: '<?php echo current_language_code(); ?>',
            country_codes: '<?php echo $this->config->item('country_codes'); ?>'
        });

        $("#employees_login").change(function () {
            $.ajax({
                url: "<?php echo base_url(); ?>employees/get_role_list",
                type: 'GET',
                data: {login_type: $(this).val()},
                dataType: 'json',
                success: function (response) {
                    var select = $('#role_id');
                    select.empty();
                    if (response.success)
                    {
                        
                        $.each(response.role_list, function (index, value) {
                            select.append(
                                    $('<option></option>').val(index).html(value)
                                    );
                        });
                    }
                    $('#role_id').val("<?php echo $selected_role_id;?>");
                }
            });
        });
    });
</script>