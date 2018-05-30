<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        table_support.init({
            employee_id: <?php echo $this->Employee->get_logged_in_employee_info()->person_id; ?>,
            resource: '<?php echo site_url($controller_name); ?>',
            headers: <?php echo $table_headers; ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            uniqueId: 'items.item_id',
            queryParams: function () {
                return $.extend(arguments[0], {
                    search_term: "<?php echo $search_term; ?>"
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
    <?php echo $this->lang->line('module_' . $controller_name); ?>
    <button class='btn btn-info btn-sm pull-right modal-dlg' data-btn-submit='<?php echo $this->lang->line('common_submit') ?>' data-btn-new='<?php echo $this->lang->line('common_new') ?>' data-href='<?php echo site_url($controller_name . "/view"); ?>'
            title='<?php echo $this->lang->line($controller_name . '_new'); ?>'>
        <span class="glyphicon glyphicon-tag">&nbsp</span><?php echo $this->lang->line($controller_name . '_new'); ?>
    </button>

</div>

<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">

    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
