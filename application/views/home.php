<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<h3 class="text-center"><?php //echo $this->lang->line('common_welcome_message');   ?></h3>
<?php /*
  <div id="home_module_list">
  <?php
  foreach ($allowed_modules->result() as $module) {
  ?>
  <div class="module_item" title="<?php echo $this->lang->line('module_' . $module->module_id . '_desc'); ?>">
  <a href="<?php echo site_url("$module->module_id"); ?>"><img src="<?php echo base_url() . 'images/menubar/' . $module->module_id . '.png'; ?>" border="0" alt="Menubar Image" /></a>
  <a href="<?php echo site_url("$module->module_id"); ?>"><?php echo $this->lang->line("module_" . $module->module_id) ?></a>
  </div>
  <?php
  }
  ?>
  </div>
 */ ?>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-body text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_sales);  ?>"><?php echo to_currency($total_sales);  ?></h2>
                <br />
                <?php echo $this->lang->line('common_today_sales'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-body  text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_pay_sublier);  ?>"><?php echo to_currency($total_pay_sublier);  ?></h2>
                <br />
                <?php echo $this->lang->line('common_today_purchase'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body  text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_stock_value);  ?>"><?php echo to_currency($total_stock_value); ?></h2>
                <br />
                <?php echo $this->lang->line('common_total_stock_value'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-warning">
            <div class="list-group panel-body no-padding">
                <?php echo anchor("inventories/low", $this->lang->line('common_low_stock_items') . '<span style=" width:100px;text-align: right" class="pull-right ellipsis-text-overflow" title="'.$inventories['low'] .'">' . $inventories['low'] . '<span>', array('class' => 'list-group-item' ,'style'=>'padding: 13px;')); ?>
                <?php echo anchor("inventories", $this->lang->line('common_quantity_in_hand') . '<span style=" width:100px;text-align: right"  class="pull-right ellipsis-text-overflow" title="'.$inventories['hand'] .'">' . $inventories['hand'] . '<span>', array('class' => 'list-group-item' ,'style'=>'padding: 13px;')); ?>
                <?php echo anchor("pay/purchase_order_history", $this->lang->line('common_quantity_to_be_received') . '<span style=" width:100px;text-align: right"  class="pull-right ellipsis-text-overflow" title="'.$inventories['to_be_received'] .'">' . $inventories['to_be_received'] . '<span>', array('class' => 'list-group-item' ,'style'=>'padding: 13px;')); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-body  text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_profit_loss_value['purchase']);  ?>"><?php echo to_currency($total_profit_loss_value['purchase']); ?></h2>
                <br />
                <?php echo $this->lang->line('common_profit_loss_purchase'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-body  text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_profit_loss_value['stock']);  ?>"><?php echo to_currency($total_profit_loss_value['stock']); ?></h2>
                <br />
                <?php echo $this->lang->line('common_profit_loss_stock'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-body  text-center">
                <h2 class="ellipsis-text-overflow" title="<?php echo to_currency($total_profit_loss_value['sale']);  ?>"><?php echo to_currency($total_profit_loss_value['sale']); ?></h2>
                <br />
                <?php echo $this->lang->line('common_profit_loss_sales'); ?>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-body  text-center">
                <a href="<?php echo site_url("accounts/profit_and_loss"); ?>">
                    <h2 class="ellipsis-text-overflow <?php echo ($total_profit_loss_value['profit'] > 0)?'text-success':'text-danger'; ?>" title="<?php echo to_currency($total_profit_loss_value['profit']);  ?>"><?php echo to_currency($total_profit_loss_value['profit']); ?></h2>
                </a>
                <br />
                <?php echo $this->lang->line('common_profit_loss_profit'); ?>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("partial/footer"); ?>