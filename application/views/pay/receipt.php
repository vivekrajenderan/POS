<?php $this->load->view("partial/header"); ?>

<?php
if (isset($error_message)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error_message . "</div>";
    exit;
}
?>

<?php $this->load->view('partial/print_receipt', array('print_after_sale', $print_after_sale, 'selected_printer' => 'receipt_printer')); ?>

<div class="print_hide" id="control_buttons" style="text-align:right">
    <a href="javascript:printdoc();"><div class="btn btn-info btn-sm" id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
    <a href="javascript:history.go(-1)"><div class="btn btn-info btn-sm" id="show_print_button"><?php echo '<span class="glyphicon glyphicon-arrow-left">&nbsp</span>' . $this->lang->line('common_back'); ?></div></a>
    <?php echo anchor("purchase_order", '<span class="glyphicon glyphicon-save">&nbsp</span>' . $this->lang->line('po_register'), array('class' => 'btn btn-info btn-sm', 'id' => 'show_sales_button')); ?>
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
        if (isset($supplier)) {
            ?>
            <div id="customer"><?php echo $this->lang->line('suppliers_supplier') . ": " . $supplier; ?></div>
            <?php
        }
        ?>
        <div id="sale_id"><?php echo $this->lang->line('po_id') . ": " . $receiving_id; ?></div>
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
            <th style="width:20%;" class="hidden"><?php echo $this->lang->line('common_price'); ?></th>
            <th style="width:20%;text-align:right;"><?php echo $this->lang->line('sales_quantity'); ?></th>
            <th style="width:15%;text-align:right;" class="hidden"><?php echo $this->lang->line('sales_total'); ?></th>
        </tr>

        <?php
        $total = 0;
        foreach (array_reverse($cart, TRUE) as $line => $item) {
            $total+=$item['quantity'];
            ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td class="hidden"> <?php echo to_currency($item['price']); ?></td>
                <td style='text-align:right;'><?php echo to_quantity_decimals($item['quantity']); ?></td>
                <td class="hidden"><div class="total-value"><?php echo to_currency($item['total']); ?></div></td>
            </tr>
            <tr>
                <td ><?php echo $item['serialnumber']; ?></td>
            </tr>
            <?php
            if ($item['discount'] > 0) {
                ?>
                <tr class="hidden">
                    <td colspan="3" style="font-weight: bold;"> <?php echo number_format($item['discount'], 0) . " " . $this->lang->line("sales_discount_included") ?> </td>
                </tr>
                <?php
            }
            ?>
            <?php
        }
        ?>	
        <tr>
            <td colspan="3" style='text-align:right;border-top:2px solid #000000;'><?php echo $this->lang->line('po_total_quantity'); ?></td>
            <td style='border-top:2px solid #000000;'><div class="total-value"><?php echo $total; ?></div></td>
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
