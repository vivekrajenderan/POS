<?php $this->load->view("partial/header"); ?>
<?php $this->load->view('partial/print_receipt', array('print_after_sale', $print_after_sale, 'selected_printer' => 'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
    <a href="javascript:printdoc();"><div class="btn btn-info btn-sm" id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
</div>
<div id="page_title" class="text-center"><?php echo $this->lang->line('inventory_details'); ?></div>
<br>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-4 form-group">
            <label><?php echo $this->lang->line('inventory_item_number'); ?></label>
            <?php echo $item_info->item_number; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 form-group">
            <label><?php echo $this->lang->line('inventory_item_name'); ?></label>
            <?php echo $item_info->name; ?>
        </div></div>
    <div class="row">   
        <div class="col-xs-4 form-group">
            <label><?php echo $this->lang->line('inventory_category'); ?></label>
            <?php echo $item_info->category; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-4 form-group">
            <label><?php echo $this->lang->line('inventory_stock_location'); ?></label>
            <?php echo (isset($stock_locations[$location_id])) ? $stock_locations[$location_id] : ''; ?>
        </div></div>
    <div class="row">
        <div class="col-xs-4 form-group">
            <label><?php echo $this->lang->line('inventory_current_quantity'); ?></label>
            <b><?php echo to_quantity_decimals(current($item_quantities)); ?></b>
        </div>    
    </div>
</div>
<div class="panel-body">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr style="background-color: #999 !important;">
                    <th colspan="7" class="text-center"><?php echo $this->lang->line('inventory_details_heading')." ".changeDateTime(date('Y-m-d H:i:s')); ?></th>
                </tr>
                <tr>
                    <th width="20%"><?php echo $this->lang->line('inventory_date'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('inventory_employeename'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('inventory_in_out_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('inventory_balance'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('inventory_price_qty'); ?></th>
                    <th width="10%"><?php echo $this->lang->line('inventory_total'); ?></th>
                    <th width="20%"><?php echo $this->lang->line('inventory_remarks'); ?></th>
                </tr>
            </thead>
            <tbody id="inventory_result">
                <?php
                /*
                 * the tbody content of the table will be filled in by the javascript (see bottom of page)
                 */

                //$inventory_array = $this->Inventory->get_inventory_data_for_item($item_info->item_id, $location_id)->result_array();
                foreach ($inventory_array as $row) {
                    $employee = $this->Employee->get_info($row['trans_user']);
                    ?>
                    <tr>
                        <td><?php echo $row['trans_date']; ?></td>
                        <td><?php echo $employee->first_name . ' ' . $employee->last_name; ?></td>
                        <td><?php echo $row['trans_inventory']; ?></td>
                        <td><?php echo $row['balance']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo ($row['price'] * $row['trans_inventory']); ?></td>
                        <td><?php echo $row['trans_comment']; ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>

