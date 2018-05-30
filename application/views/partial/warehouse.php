<div class="form-group form-group-sm" >
    <?php echo form_label($this->lang->line('config_warehouse_name'), 'warehouse_name', array('class' => 'required control-label col-xs-2 padding-3 text-left warehouse_name_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_phonenumber'), 'warehouse_phone', array('class' => ' control-label col-xs-1 padding-3 text-left warehouse_phone_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_address1'), 'warehouse_address1', array('class' => ' control-label col-xs-2 padding-3 text-left warehouse_address1_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_address2'), 'warehouse_address2', array('class' => ' control-label col-xs-2 padding-3 text-left warehouse_address2_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_city'), 'warehouse_city', array('class' => ' control-label col-xs-1 padding-3 text-left warehouse_city_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_state'), 'warehouse_state', array('class' => ' control-label col-xs-1 padding-3 text-left warehouse_state_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_zip'), 'warehouse_zip', array('class' => ' control-label col-xs-1 padding-3 text-left warehouse_zip_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_country'), 'warehouse_country', array('class' => ' control-label col-xs-1 padding-3 text-left warehouse_country_label')); ?>
    <span>&nbsp;&nbsp;</span>
</div>

<?php
$i = 0;
    foreach ($warehouse as $location => $location_data) {
        $location_id = $location_data['location_id'];
        $location_name = $location_data['location_name'];
        ++$i;
        ?>
        <div class="form-group form-group-sm" >
            <?php //echo form_label($this->lang->line('config_warehouse_name'), 'warehouse_name_' . $i, array('class' => 'required control-label col-xs-2 warehouse_name_label')); ?>
            <div class='col-xs-2  padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'warehouse_name_' . $location_id,
                    'id' => 'warehouse_name_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm required warehouse_name_input',
                    'value' => $location_name
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_phonenumber'), 'warehouse_phone_' . $i, array('class' => ' control-label col-xs-2 warehouse_phone_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'warehouse_phone_' . $location_id,
                    'id' => 'warehouse_phone_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_phone_input',
                    'value' => $location_data['phone_number'],
                    'pattern' => "[0-9]+"
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_address1'), 'warehouse_address1_' . $i, array('class' => ' control-label col-xs-2 warehouse_address1_label')); ?>
            <div class='col-xs-2 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'warehouse_address1_' . $location_id,
                    'id' => 'warehouse_address1_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_address1_input',
                    'value' => $location_data['address_1']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_address2'), 'warehouse_address2_' . $i, array('class' => ' control-label col-xs-2 warehouse_address2_label')); ?>
            <div class='col-xs-2 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'warehouse_address2_' . $location_id,
                    'id' => 'warehouse_address2_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_address2_input',
                    'value' => $location_data['address_2']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_city'), 'warehouse_city_' . $i, array('class' => ' control-label col-xs-2 warehouse_city_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'warehouse_city_' . $location_id,
                    'id' => 'warehouse_city_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_city_input',
                    'value' => $location_data['city']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_state'), 'warehouse_state_' . $i, array('class' => ' control-label col-xs-2 warehouse_state_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'warehouse_state_' . $location_id,
                    'id' => 'warehouse_state_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_state_input',
                    'value' => $location_data['state']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_zip'), 'warehouse_zip_' . $i, array('class' => ' control-label col-xs-2 warehouse_zip_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'warehouse_zip_' . $location_id,
                    'id' => 'warehouse_zip_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_zip_input',
                    'value' => $location_data['zip']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_country'), 'warehouse_country_' . $i, array('class' => ' control-label col-xs-2 warehouse_country_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'warehouse_country_' . $location_id,
                    'id' => 'warehouse_country_' . $location_id,
                    'class' => 'warehouse valid_chars form-control input-sm  warehouse_country_input',
                    'value' => $location_data['country']
                );
                echo form_input($form_data);
                ?>
            </div>
            <span>&nbsp;&nbsp;</span>
            <span class="add_warehouse glyphicon glyphicon-plus" style="padding-top: 0.5em;"></span>
            <span>&nbsp;&nbsp;</span>
            <span class="remove_warehouse glyphicon glyphicon-minus" style="padding-top: 0.5em;"></span>
        </div>
        <?php
    }
?>
