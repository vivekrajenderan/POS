<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>
<div id="page_title" class="text-center"><?php echo $this->lang->line('module_reports'); ?></div>
<br>
<?php
if (isset($error)) {
    echo "<div class='alert alert-dismissible alert-danger'>" . $error . "</div>";
}
?>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('menu_purchase'); ?></h3>
            </div>
            <div class="list-group">
                <?php echo anchor( "pay/itemlists", $this->lang->line('reports_purchases_by_item') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/supplierlists", $this->lang->line('reports_purchase_by_supplier') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/locationlists", $this->lang->line('reports_purchases_by_location') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/purchase_order_history", $this->lang->line('reports_purchase_order_history') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "grn/lists", $this->lang->line('reports_receive_history') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/bill", $this->lang->line('reports_bill_details') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/lists", $this->lang->line('reports_payments_made') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "pay/supplier_balance", $this->lang->line('reports_supplier_balance') , array('class' => 'list-group-item')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('module_inventories'); ?></h3>
            </div>
            <div class="list-group">
                <?php echo anchor( "inventories", $this->lang->line('inventory_summary_report') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "inventories/low", $this->lang->line('inventory_low_report') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "inventories/summaryvaluation", $this->lang->line('inventory_total_inventory_value') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "inventories/log", $this->lang->line('inventory_log_report') , array('class' => 'list-group-item')); ?>
                <?php //echo anchor( "inventories/trans", $this->lang->line('inventory_trans_report') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "stock_order/lists", $this->lang->line('reports_stock_order_history') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "requisition/lists", $this->lang->line('reports_supply_history') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "stockorder_check/lists", $this->lang->line('reports_stock_order_check_history') , array('class' => 'list-group-item')); ?>
            
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('reports_financial_report'); ?></h3>
            </div>
            <div class="list-group">
                <?php echo anchor( "accounts/profit_and_loss", $this->lang->line('reports_profit_and_loss') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "accounts/account_transactions", $this->lang->line('reports_account_transactions') , array('class' => 'list-group-item')); ?>
                <?php //echo anchor( "accounts/aging_summary", $this->lang->line('reports_aging_summary') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "accounts/trial_balance", $this->lang->line('reports_trial_balance') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "accounts/general_ledger", $this->lang->line('reports_general_ledger') , array('class' => 'list-group-item')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('module_activityl'); ?></h3>
            </div>
            <div class="list-group">
                <?php echo anchor( "auditingtrail", $this->lang->line('module_auditingtrail') , array('class' => 'list-group-item')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('reports_taxes'); ?></h3>
            </div>
            <div class="list-group">
                <?php echo anchor( "taxes/summary_taxes", $this->lang->line('reports_taxes_summary_report') , array('class' => 'list-group-item')); ?>
                <?php echo anchor( "taxes/summary_taxes_detail/".date('Y-m-d').'/'.date('Y-m-d'), $this->lang->line('reports_taxes_details_report') , array('class' => 'list-group-item')); ?>
            </div>
        </div>
    </div>
 
    
<!--    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-stats">&nbsp</span><?php echo $this->lang->line('reports_graphical_reports'); ?></h3>
            </div>
            <div class="list-group">
                <?php
                foreach ($grants as $grant) {
                    if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(inventory|receivings)/', $grant['permission_id'])) {
                        show_report('graphical_summary', $grant['permission_id']);
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-list">&nbsp</span><?php echo $this->lang->line('reports_summary_reports'); ?></h3>
            </div>
            <div class="list-group">
                <?php
                foreach ($grants as $grant) {
                    if (preg_match('/reports_/', $grant['permission_id']) && !preg_match('/(inventory|receivings)/', $grant['permission_id'])) {
                        show_report('summary', $grant['permission_id']);
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="glyphicon glyphicon-list-alt">&nbsp</span><?php echo $this->lang->line('reports_detailed_reports'); ?></h3>
            </div>
            <div class="list-group">
                <?php
                $person_id = $this->session->userdata('person_id');
                show_report_if_allowed('detailed', 'sales', $person_id);
                show_report_if_allowed('detailed', 'receivings', $person_id);
                show_report_if_allowed('specific', 'customer', $person_id, 'reports_customers');
                show_report_if_allowed('specific', 'discount', $person_id, 'reports_discounts');
                show_report_if_allowed('specific', 'employee', $person_id, 'reports_employees');
                ?>
            </div>
        </div>

        <?php
        if ($this->Employee->has_grant('reports_inventory', $this->session->userdata('person_id'))) {
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-book">&nbsp</span><?php echo $this->lang->line('reports_inventory_reports'); ?></h3>
                </div>
                <div class="list-group">
                    <?php
                    show_report('', 'reports_inventory_low');
                    show_report('', 'reports_inventory_summary');
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>-->
</div>

<?php $this->load->view("partial/footer"); ?>