<?php $this->load->view("partial/header"); ?>

<div id="page_title" class="text-center">
    <?php echo $title ?> As of Date <?php echo changeDateTime(date('Y-m-d H:i:s'));?>
    <?php echo anchor("inventories/all/all",  $this->lang->line('inventory_summary'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button','style'=>'margin-left: 3px;')); ?>
    <?php echo anchor("inventories/low/all",  $this->lang->line('inventory_low'), array('class' => 'btn btn-info btn-sm pull-right', 'id' => 'show_sales_button')); ?>

</div>

<div id="page_subtitle"><?php echo $subtitle ?></div>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php //echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
        <?php
        if (count($item_locations) > 0) {
            echo form_dropdown('item_location', $item_locations, $item_location, array('id' => 'item_location', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
        }
        ?>
    </div>
</div>
<div id="table_holder">
    <table id="table"></table>
</div>

<div id="report_summary">
<?php foreach ($summary_data as $name => $value) { ?>
        <div class="summary_row"><?php echo $this->lang->line('inventory_' . $name) . ': ' . to_currency($value); ?></div>
<?php } ?>
</div>

<script type="text/javascript">

    $(document).ready(function()
    {
<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        var detail_data = <?php echo json_encode($details_data); ?>;


<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date        
        //$('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>");
        // update the hidden inputs with the selected dates before submitting the search data
        //var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>";
        //$("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            //window.location = '<?php echo site_url($controller_name); ?>/summaryvaluation/' + start_date + '/' + end_date + '/' + $("#item_location").val();

        //});

        $("#item_location").change(function() {
            window.location = '<?php echo site_url($controller_name); ?>/summaryvaluation/'+ $("#item_location").val();

        });

        $('#table').bootstrapTable({
            columns: <?php echo transform_headers($headers['summary'], TRUE,FALSE); ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            striped: true,
            pagination: true,
            sortable: true,
            showColumns: true,
            uniqueId: 'id',
            showExport: true,
            data: <?php echo json_encode($data); ?>,
            iconSize: 'sm',
            paginationVAlign: 'bottom',
            detailView: true,
            uniqueId: 'id',
                    escape: false,
            onPostBody: function() {
                dialog_support.init("a.modal-dlg");
            },
            onExpandRow: function(index, row, $detail) {
                console.log(row);
                $detail.html('<table></table>').find("table").bootstrapTable({
                    columns: <?php echo transform_headers_readonly($headers['details']); ?>,
                    data: detail_data[(!isNaN(row.item_id) && row.item_id) || $(row[0] || row.item_id).text().replace(/(POS|RECV)\s*/g, '')]
                });
            }
        });

    });
</script>

<?php $this->load->view("partial/footer"); ?>