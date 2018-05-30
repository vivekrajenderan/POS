<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function()
    {

<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>");
<?php if (isset($_POST['enddate'])) {
    ?>

            $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), strtotime($_POST['startdate'])); ?>");
            $('#daterangepicker').data('daterangepicker').setEndDate("<?php echo date($this->config->item('dateformat'), strtotime($_POST['enddate'])); ?>");
    <?php
}
?>

        // update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>";
        $('input[name="startdate"]').val(start_date)
        $('input[name="enddate"]').val(end_date)
        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            $('input[name="startdate"]').val(start_date)
            $('input[name="enddate"]').val(end_date)
        });
    });
</script>
<?php $this->load->view('partial/print_receipt', array('print_after_sale',$print_after_sale, 'selected_printer' => 'receipt_printer')); ?>
<div id="page_title" class="text-center"><?php echo $this->lang->line($page_title); ?></div>
<br>
<div id="toolbar"  class="text-center">
    <div class="row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4 text-center">
            <div class=" pull-left form-inline" role="toolbar">
                <?php
                echo form_open($controller_name . "/profit_and_loss", array('id' => 'mode_form', 'class' => 'form-horizontal panel panel-default'));
                echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker'));
                echo form_dropdown('stock_source', $stock_locations, $stock_source, array( 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit')); 
                $data = array(
                    'name' => 'search',
                    'id' => 'search',
                    'class' => 'btn btn-sm btn-success',
                    'type' => 'submit',
                    'content' => $this->lang->line('common_search')
                );
                echo form_hidden('startdate', '');
                echo form_hidden('enddate', '');
                
                echo form_button($data);
                echo form_close();
                ?>

            </div>
        </div>
        <div class="col-lg-4">
            <div class="print_hide" id="control_buttons" style="text-align:right">
                <a href="javascript:printdoc();"><div class="btn btn-info btn-sm" id="show_print_button"><?php echo '<span class="glyphicon glyphicon-print">&nbsp</span>' . $this->lang->line('common_print'); ?></div></a>
            </div>  
        </div>
    </div>

</div>
<style>
    .total-value{
        border-top: 1px dotted !important;
    }
    .total-profit-value{
        border-top: 3px double #c6c6c6 !important;
        border-bottom: 3px double #c6c6c6 !important;
    }
</style>
<div class="panel-body">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-6">
        <div id="table_holder">
            <table id="table" class="table table-hover"> 
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('account_account'); ?></th>
                        <th class="text-right"><?php echo $this->lang->line('account_total'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $this->lang->line('account_total_sales'); ?></td>
                        <td class="text-right"><?php echo to_currency($sales); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('account_total_income'); ?></th>
                        <th class="text-right total-value"><?php echo to_currency($sales); ?></th>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right">&nbsp;</th>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('account_cost_of_goods_sold'); ?></td>
                        <td class="text-right"><?php echo to_currency($stock); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('account_total_cost_of_goods_sold'); ?></th>
                        <th class="text-right total-value"><?php echo to_currency($stock); ?></th>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right">&nbsp;</th>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line('account_direct_purchase'); ?></td>
                        <td class="text-right"><?php echo to_currency($purchase); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('account_total_expense'); ?></th>
                        <th class="text-right total-value"><?php echo to_currency($purchase); ?></th>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th class="text-right ">&nbsp;</th>
                    </tr>
                    <tr>
                        <th><?php echo $this->lang->line('account_net_profit_loss'); ?></th>
                        <th class="text-right total-profit-value <?php echo ($profit > 0)?'text-success':'text-danger'; ?>"><?php echo to_currency($profit); ?></th>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


<?php $this->load->view("partial/footer"); ?>