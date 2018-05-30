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
        $("#item_locations").change(function () {
            table_support.refresh();
        });
        $("#trans_type").change(function () {
            table_support.refresh();
        });
        $("#account_type").change(function () {
            table_support.refresh();
        });

<?php $this->load->view('partial/bootstrap_tables_locale'); ?>
        table_support.init({
            resource: '<?php echo site_url($controller_name); ?>',
            headers: <?php echo $table_headers; ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            uniqueId: 'receiving_id',
            queryParams: function () {
                return $.extend(arguments[0], {
                    search_term: '<?php echo $search_term; ?>',
                    start_date: start_date,
                    end_date: end_date,
                    item_locations: $("#item_locations").val(),
                    trans_type: $("#trans_type").val(),
                    account_type: $("#account_type").val()
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
<div id="page_title" class="text-center"><?php echo $this->lang->line($page_title); ?></div>
<br>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
        <?php
        if (isset($item_locations))
            if (count($item_locations) > 0) {
                echo form_multiselect('item_locations[]', $item_locations, '', array('id' => 'item_locations', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
            }
        if (isset($trans_type))
            if (count($trans_type) > 0) {
                echo form_multiselect('trans_type[]', $trans_type, '', array('id' => 'trans_type', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
            }
        if (isset($accountdetails))
            if (count($accountdetails) > 0) {
                echo form_dropdown('account_type', $accountdetails, $account_type, array('id' => 'account_type', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
            }
        ?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>