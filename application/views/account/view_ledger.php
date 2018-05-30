<?php $this->load->view("partial/header"); ?>


<div id="page_title" class="text-center"><?php echo $title." ".changeDateTime(date('Y-m-d H:i:s'),strtotime($start_date))." - ".changeDateTime(date('Y-m-d H:i:s'),strtotime($end_date)) ?>
    <?php echo anchor($controller_name.'/general_ledger', $this->lang->line('account_general_ledger_title'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;')); ?>

</div>
<div id="table_holder">
    <table id="table"></table>
    <div class="pull-right"><?php echo $this->lang->line('account_closing_balance')." : ".$closing_balance;?>  </div>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {

<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        $('#table').bootstrapTable({
            columns: <?php echo transform_headers($headers, TRUE, FALSE); ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            striped: true,
            sortable: true,
            showExport: true,
            pagination: true,
            showColumns: true,
            showExport: true,
                    data: <?php echo json_encode($data); ?>,
            iconSize: 'sm',
            paginationVAlign: 'bottom',
            escape: false
        });

    });
</script>

<?php $this->load->view("partial/footer"); ?>