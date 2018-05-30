<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div id="page_title" class="text-center"><?php echo $title ?>
    <?php echo anchor($controller_name."/summary_taxes", '<span class="glyphicon glyphicon-plus">&nbsp</span>' . $this->lang->line('module_taxes'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;')); ?>

</div>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>

    </div>
</div>
<div id="table_holder">
    <table id="table"></table>
</div>

<div id="report_summary">
    <?php
    foreach ($summary_data as $name => $value) {
        ?>
        <div class="summary_row"><?php echo $this->lang->line('taxes_' . $name) . ': ' . to_currency($value); ?></div>
        <?php
    }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function ()
    {
<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date        
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>");
        // update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>";
        $("#daterangepicker").on('apply.daterangepicker', function (ev, picker) {
            window.location = '<?php echo site_url($controller_name) . "/summary_tax_view/" . $item_id; ?>/' + start_date + '/' + end_date;

        });

<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        $('#table').bootstrapTable({
            columns: <?php echo transform_headers($headers['summary'], TRUE, FALSE); ?>,
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