<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function ()
    {

<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), ($listfunction == "historylists" ? date('d') : 01), date('Y'))); ?>");
        // update the hidden inputs with the selected dates before submitting the search data

        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), ($listfunction == "historylists" ? date('d') : 01), date('Y'))); ?>";
        $("#daterangepicker").on('apply.daterangepicker', function (ev, picker) {
            table_support.refresh();
        });
        $("#receiving_status").change(function () {
            table_support.refresh();
        });
        $("#payment_options").change(function () {
            table_support.refresh();
        });
        $("#stock_locations").change(function () {
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
                    start_date: start_date,
                    end_date: end_date,
                    receiving_status: $("#receiving_status").val(),
                    payment_options: $("#payment_options").val(),
                    stock_locations: $("#stock_locations").val(),
                    searchlist: "<?php echo $listfunction; ?>"
                });
            },
            onLoadSuccess: function (response) {
                $('a.rollover').imgPreview({
                    imgCSS: {width: 200},
                    distanceFromCursor: {top: 10, left: -210}
                })
                $('.deleteaction').click(function (e) {
                    e.preventDefault();
                    if (confirm('<?php echo $this->lang->line('purchase_order_delete_confirmation_message'); ?>')) {
                        $href = $(this).attr('href');
                        $.ajax({
                            type: 'GET',
                            url: $href,
                            dataType: 'json',
                            success: function (response)
                            {
                                $.notify(response.message, {type: response.success ? 'success' : 'danger'});
                                table_support.refresh();
                            }
                        });
                    }
                })
            }
        });


    });
</script>
<div id="page_title" class="text-center">
    <?php
    echo $this->lang->line($page_title);
    if (isset($button_list))
        if ($button_list == 1) {
            echo anchor($controller_name . "/" . $method1, $this->lang->line($button_title1), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;'));
            echo anchor($controller_name . "/" . $method2, $this->lang->line($button_title2), array('class' => 'btn btn-info btn-sm pull-right', 'id' => 'show_sales_button'));
        } else if ($button_list == 0) {
            echo anchor($controller_name, '<span class="glyphicon glyphicon-plus">&nbsp</span>' . $this->lang->line('module_pay'), array('class' => 'btn btn-info btn-sm  pull-right', 'id' => 'show_sales_button', 'style' => 'margin-left: 3px;'));
        }
    ?>

</div>
<br>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
<?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
<?php
if (isset($payment_options))
    if (count($payment_options) > 0) {
        echo form_multiselect('payment_options[]', $payment_options, '', array('id' => 'payment_options', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
    }
if (isset($stock_locations))
    if (count($stock_locations) > 0) {
        echo form_multiselect('stock_locations[]', $stock_locations, '', array('id' => 'stock_locations', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
    }
if (isset($receiving_status))
    if (count($receiving_status) > 0) {
        echo form_multiselect('receiving_status[]', $receiving_status, '', array('id' => 'receiving_status', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
    }
?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>
<?php $this->load->view("partial/footer"); ?>