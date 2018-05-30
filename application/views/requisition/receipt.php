<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error_message . "</div>";
    exit;
}
?>

<?php $this->load->view('partial/print_receipt', array('print_after_sale', $print_after_sale, 'selected_printer' => 'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
    <a href="javascript:printdoc();"><div class="btn btn-info btn-sm", id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
 
    <?php echo anchor("requisition/lists", '<span class="glyphicon glyphicon-list">&nbsp</span>' . $this->lang->line('requisition_list'), array('class' => 'btn btn-info btn-sm', 'id' => 'show_sales_button')); ?>
    <?php echo anchor("requisition", '<span class="glyphicon glyphicon-save">&nbsp</span>' . $this->lang->line('requisition_register'), array('class' => 'btn btn-info btn-sm', 'id' => 'show_sales_button')); ?>
</div>

<div id="receipt_wrapper">
    <div id="receipt_header">
        <?php
        if ($this->config->item('company_logo') != '') {
            ?>
            <div id="company_name"><img id="image" src="<?php echo base_url('uploads/' . $this->config->item('company_logo')); ?>" alt="company_logo" /></div>
            <?php
        }
        ?>

        <?php
        if ($this->config->item('receipt_show_company_name')) {
            ?>
            <div id="company_name"><?php echo $this->config->item('company'); ?></div>
            <?php
        }
        ?>

        <div id="company_address"><?php echo nl2br($this->config->item('address')); ?></div>
        <div id="company_phone"><?php echo $this->config->item('phone'); ?></div>
        <div id="sale_receipt"><?php echo $receipt_title; ?></div>
        <div id="sale_time"><?php echo $transaction_time ?></div>
    </div>

    <div id="receipt_general_info">
<?php
if (isset($location_names)) {
    ?>
            <div id="customer"><?php echo $this->lang->line('config_warehouse_name') . ": " . $location_names; ?></div>
            <?php
        }
        ?>
        <div id="sale_id"><?php echo $this->lang->line('requisition_so_ref') . ": " . $stock_order_id; ?></div>
        <div id="sale_id"><?php echo $this->lang->line('requisition_req_ref') . ": " . $receiving_id; ?></div>
        <?php
        if (!empty($reference)) {
            ?>
            <div id="reference"><?php echo $this->lang->line('receivings_reference') . ": " . $reference; ?></div>	
            <?php
        }
        ?>
        <div id="employee"><?php echo $this->lang->line('employees_employee') . ": " . $employee; ?></div>
    </div>

    <table id="receipt_items">
        <tr>
            <th style="width:40%;"><?php echo $this->lang->line('items_item'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('grn_requested_quantity'); ?></th>
            <th style="width:20%;"><?php echo $this->lang->line('grn_requesting_qty'); ?></th>
        </tr>

<?php
$requested_quantity = 0;
$receiving_quantity = 0;
foreach (array_reverse($cart, TRUE) as $line => $item) {
    $requested_quantity+=$item['balance_quantity'];
    $receiving_quantity+=$item['receiving_quantity'];
    ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo to_quantity_decimals($item['requested_quantity']); ?></td>
                <td><div class=""><?php echo to_quantity_decimals($item['receiving_quantity']); ?></div></td>
            </tr>
            <tr>
                <td ><?php echo $item['serialnumber']; ?></td>
            </tr>
    <?php
}
?>	
        <tr>
            <td style='border-top:2px solid #000000;'></td>
            <td style='border-top:2px solid #000000;'></td>
            <td style='border-top:2px solid #000000;'><div class="pull-left"><?php echo $receiving_quantity; ?></div></td>
        </tr>
    </table>

    <div id="sale_return_policy">
<?php echo nl2br($this->config->item('return_policy')); ?>
    </div>

    <div id='barcode'>
        <img src='data:image/png;base64,<?php echo $barcode; ?>' /><br>
        <?php echo $receiving_id; ?>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>
