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
<div id="page_title" class="text-center"><?php echo $this->lang->line($page_title) . " " . changeDateTime(date('Y-m-d H:i:s')); ?>

</div>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>

    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>
<?php $this->load->view("partial/footer"); ?>