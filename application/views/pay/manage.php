<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function()
    {

<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, 01, 01, 2010)); ?>");
        // update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, 01, 01, 2010)); ?>";
        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            table_support.refresh();
        });

        $("#receiving_status").change(function() {
            table_support.refresh();
        });
        $("#item_location").change(function() {
            console.log("cam");
            table_support.refresh();
        });

<?php $this->load->view('partial/bootstrap_tables_locale'); ?>
        table_support.init({
            resource: '<?php echo site_url($controller_name); ?>',
            headers: <?php echo $table_headers; ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            uniqueId: 'receiving_id',
            queryParams: function() {
                return $.extend(arguments[0], {
                    start_date: start_date,
                    end_date: end_date,
                    receiving_status: $("#receiving_status").val(),
                    item_location: $("#item_location").val()
                });
            },
            onLoadSuccess: function(response) {
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

<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
        <?php
        if (count($item_locations) > 1) {
            echo form_multiselect('item_location[]', $item_locations, $item_source, array('id' => 'item_location', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
        }
        ?>
        <?php
        if (count($receiving_status) > 1) {
            echo form_multiselect('receiving_status[]', $receiving_status, $receiving_default, array('id' => 'receiving_status', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
        }
        ?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>
<?php $this->load->view("partial/footer"); ?>