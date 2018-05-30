
<ul id="permission_list">
    <?php
    foreach ($all_modules as $module) {
        ?>
        <li data-value="<?php echo $module->module_id; ?>">	
            <?php echo form_checkbox("grants[]", $module->module_id, $module->grant, "class='module'"); ?>
            <span class="medium"><?php echo $this->lang->line('module_' . $module->module_id); ?>:</span>
            <span class="small"><?php echo $this->lang->line('module_' . $module->module_id . '_desc'); ?></span>
         
            <?php
            foreach ($all_subpermissions as $permission) {
                $exploded_permission = explode('_', $permission->permission_id);
                if ($permission->module_id == $module->module_id) {
                    $lang_key = $module->module_id . '_' . $exploded_permission[count($exploded_permission) -1];
                    $lang_line = $this->lang->line($lang_key);
                    $lang_line = ($this->lang->line_tbd($lang_key) == $lang_line) ? $exploded_permission[count($exploded_permission) -1] : $lang_line;
                    if (!empty($lang_line)) {
                        ?>
                        <ul>
                            <li data-location_type='<?php echo $permission->location_type ?>'>
                                <?php echo form_checkbox("grants[]", $permission->permission_id, $permission->grant); ?>
                                <span class="medium"><?php echo $lang_line ?></span>
                            </li>
                        </ul>
                        <?php
                    }
                }
            }
            ?>
        </li>
        <?php
    }
    ?>
</ul>
