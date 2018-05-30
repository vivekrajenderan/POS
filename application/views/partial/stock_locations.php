<div class="form-group form-group-sm" >
    <?php echo form_label($this->lang->line('config_warehouse_name'), 'stocklocations_name', array('class' => 'required control-label col-xs-2 padding-3 text-left stocklocations_name_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_phonenumber'), 'stocklocations_phone', array('class' => ' control-label col-xs-1 padding-3  text-left stocklocations_phone_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_address1'), 'stocklocations_address1', array('class' => ' control-label col-xs-2 padding-3 text-left stocklocations_address1_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_address2'), 'stocklocations_address2', array('class' => ' control-label col-xs-2 padding-3 text-left stocklocations_address2_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_city'), 'stocklocations_city', array('class' => ' control-label col-xs-1 padding-3  text-left stocklocations_city_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_state'), 'stocklocations_state', array('class' => ' control-label col-xs-1 padding-3  text-left stocklocations_state_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_zip'), 'stocklocations_zip', array('class' => ' control-label col-xs-1 padding-3  text-left stocklocations_zip_label')); ?>
    <?php echo form_label($this->lang->line('config_warehouse_country'), 'stocklocations_country', array('class' => ' control-label col-xs-1 padding-3  text-left stocklocations_country_label')); ?>
</div>
<?php
$i = 0;

    foreach ($stock_locations as $location => $location_data) {
        $location_id = $location_data['location_id'];
        $location_name = $location_data['location_name'];
        ++$i;
        ?>
        <div class="form-group form-group-sm" >
            <?php //echo form_label($this->lang->line('config_warehouse_name'), 'stocklocations_name_' . $i, array('class' => 'required control-label col-xs-2 stocklocations_name_label')); ?>
            <div class='col-xs-2 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_name_' . $location_id,
                    'id' => 'stocklocations_name_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm required stocklocations_name_input',
                    'value' => $location_name
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_phonenumber'), 'stocklocations_phone_' . $i, array('class' => ' control-label col-xs-2 stocklocations_phone_label')); ?>
            <div class='col-xs-1 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_phone_' . $location_id,
                    'id' => 'stocklocations_phone_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_phone_input',
                    'value' => $location_data['phone_number'],
                    'pattern' => "[0-9]+"
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_address1'), 'stocklocations_address1_' . $i, array('class' => ' control-label col-xs-2 stocklocations_address1_label')); ?>
            <div class='col-xs-2 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_address1_' . $location_id,
                    'id' => 'stocklocations_address1_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_address1_input',
                    'value' => $location_data['address_1']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_address2'), 'stocklocations_address2_' . $i, array('class' => ' control-label col-xs-2 stocklocations_address2_label')); ?>
            <div class='col-xs-2 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_address2_' . $location_id,
                    'id' => 'stocklocations_address2_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_address2_input',
                    'value' => $location_data['address_2']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_city'), 'stocklocations_city_' . $i, array('class' => ' control-label col-xs-2 stocklocations_city_label')); ?>
            <div class='col-xs-1 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_city_' . $location_id,
                    'id' => 'stocklocations_city_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_city_input',
                    'value' => $location_data['city']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_state'), 'stocklocations_state_' . $i, array('class' => ' control-label col-xs-2 stocklocations_state_label')); ?>
            <div class='col-xs-1 padding-3'>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_state_' . $location_id,
                    'id' => 'stocklocations_state_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_state_input',
                    'value' => $location_data['state']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_zip'), 'stocklocations_zip_' . $i, array('class' => ' control-label col-xs-2 stocklocations_zip_label')); ?>
            <div class='col-xs-1 padding-3 '>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_zip_' . $location_id,
                    'id' => 'stocklocations_zip_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_zip_input',
                    'value' => $location_data['zip']
                );
                echo form_input($form_data);
                ?>
            </div>
            <?php //echo form_label($this->lang->line('config_warehouse_country'), 'stocklocations_country_' . $i, array('class' => ' control-label col-xs-2 stocklocations_country_label')); ?>
            <div class='col-xs-1  padding-3'>
                <?php
                $form_data = array(
                    'name' => 'stocklocations_country_' . $location_id,
                    'id' => 'stocklocations_country_' . $location_id,
                    'class' => 'stocklocations valid_chars form-control input-sm  stocklocations_country_input',
                    'value' => $location_data['country']
                );
                echo form_input($form_data);
                ?>
            </div>
            <span>&nbsp;&nbsp;</span>
            <span class="add_stocklocations glyphicon glyphicon-plus" style="padding-top: 0.5em;"></span>
            <span>&nbsp;&nbsp;</span>
            <span class="remove_stocklocations glyphicon glyphicon-minus" style="padding-top: 0.5em;"></span>
        </div>
        <?php
    }
?>
