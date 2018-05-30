<?php $this->load->view("partial/header"); ?>


<div id="page_title" class="text-center"><?php echo $title ?> As of Date <?php echo changeDateTime(date('Y-m-d H:i:s')); ?>
    <a class='btn btn-info btn-sm pull-right' style="margin-left: 3px;" href='<?php echo site_url($controller_name . "/" . $method1); ?>'       title='<?php echo $this->lang->line($title1); ?>'>
        <?php echo $this->lang->line($title1); ?>
    </a>
    <a class='btn btn-info btn-sm pull-right' href='<?php echo site_url($controller_name . "/" . $method2); ?>'       title='<?php echo $this->lang->line($title2); ?>'>
        <?php echo $this->lang->line($title2); ?>
    </a>
</div>

<div id="page_subtitle"><?php echo $subtitle ?></div>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">

        <?php if ($method1 != '') { ?>
            <?php //echo form_label($this->lang->line('reports_item_count'), 'reports_item_count_label', array('class' => 'control-label col-xs-4')); ?>

            <?php echo form_dropdown('item_count', $item_count, $item_count_id, array('id' => 'item_count', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit')); ?>

        <?php } ?>
        <?php //echo form_label($this->lang->line('reports_stock_location'), 'reports_stock_location_label', array('class' => 'control-label col-xs-4')); ?>

        <?php
        echo form_dropdown('item_location', $item_locations, $item_location, array('id' => 'item_location', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
        ?>

    </div>

</div>
<div id="table_holder">
    <table id="table"></table>
</div>

<div id="report_summary">
    <?php
    foreach ($summary_data as $name => $value) {
        ?>
        <div class="summary_row"><?php echo $this->lang->line('inventory_' . $name) . ': ' . to_currency($value); ?></div>
        <?php
    }
    ?>
</div>
<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>
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

<?php if ($method1 == '') { ?>
            $("#item_location").change(function () {
                window.location = '<?php echo site_url($controller_name); ?>/low/' + $("#item_location").val();
            });

<?php } else { ?>
            $("#item_location").change(function () {
                window.location = '<?php echo site_url($controller_name); ?>/' + $("#item_location").val() + '/' + $("#item_count").val();
            });
            $("#item_count").change(function () {
                window.location = '<?php echo site_url($controller_name); ?>/' + $("#item_location").val() + '/' + $("#item_count").val();
            });
<?php } ?>


    });


</script>

<?php $this->load->view("partial/footer"); ?>