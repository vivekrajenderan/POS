<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>");
        // update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>";
        $("#daterangepicker").on('apply.daterangepicker', function (ev, picker) {
            table_support.refresh();
        });
        $("#supplier_list").change(function () {
            table_support.refresh();
        });
        $("#fromaccount_list").change(function () {
            table_support.refresh();
        });
<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        table_support.init({
            employee_id: <?php echo $this->Employee->get_logged_in_employee_info()->person_id; ?>,
            resource: '<?php echo site_url($controller_name); ?>',
            headers: <?php echo $table_headers; ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            uniqueId: 'items.item_id',
            queryParams: function () {
                return $.extend(arguments[0], {
                    start_date: start_date,
                    end_date: end_date,
                    search_term: "<?php echo $search_term; ?>",
                    supplier_list: $("#supplier_list").val(),
                    fromaccount_list: $("#fromaccount_list").val()
                });
            },
            onLoadSuccess: function (response) {
                $('a.rollover').imgPreview({
                    imgCSS: {width: 200},
                    distanceFromCursor: {top: 10, left: -210}
                })
            }
        });
    });
</script>
<div id="page_title" class=" text-center">
    <?php echo $this->lang->line($page_title); ?>
    <button class='btn btn-info btn-sm pull-right modal-dlg' data-btn-submit='<?php echo $this->lang->line('common_submit') ?>' data-btn-new='<?php echo $this->lang->line('common_new') ?>' data-href='<?php echo site_url($controller_name . "/view"); ?>'
            title='<?php echo $this->lang->line($controller_name . '_new'); ?>'>
        <span class="glyphicon glyphicon-tag">&nbsp</span><?php echo $this->lang->line($controller_name . '_new'); ?>
    </button>

</div>

<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
        <?php
        if (isset($supplier_list))
            if (count($supplier_list) > 0) {
                echo form_dropdown('supplier_list', $supplier_list, $default_supplier, array('id' => 'supplier_list', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
            }
        ?>
        <?php
        if (isset($fromaccount_list))
            if (count($fromaccount_list) > 0) {
                echo form_dropdown('fromaccount_list', $fromaccount_list, $default_fromaccount, array('id' => 'fromaccount_list', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
            }
        ?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
