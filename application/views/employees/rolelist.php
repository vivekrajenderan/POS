<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    $(document).ready(function()
    {
<?php $this->load->view('partial/bootstrap_tables_locale'); ?>

        table_support.init({
            resource: '<?php echo site_url($controller_name); ?>',
            headers: <?php echo $table_headers; ?>,
            pageSize: <?php echo $this->config->item('lines_per_page'); ?>,
            uniqueId: 'id',
            queryParams: function () {
                return $.extend(arguments[0], {                   
                    searchlist: "<?php echo $listfunction; ?>"                    
                });
            }
        });
        

    });

</script>
<div id="page_title" class=" text-center">
    <?php echo $this->lang->line('employees_employee_role'); ?>     
   
    <?php echo anchor($controller_name,  $this->lang->line('employees_history'), array('class' => 'btn btn-info btn-sm pull-right')); ?>

    <button class='btn btn-info btn-sm pull-right modal-dlg' data-btn-submit='<?php echo $this->lang->line('common_submit') ?>' data-href='<?php echo site_url($controller_name . "/viewrole"); ?>'
            title='<?php echo $this->lang->line('employees_new_role'); ?>' style="margin-right: 10px;">
        <span class="glyphicon glyphicon-user">&nbsp</span><?php echo $this->lang->line('employees_new_role'); ?>
    </button>

</div>

<div id="toolbar">
    <div class="pull-left btn-toolbar">
        
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<?php $this->load->view("partial/footer"); ?>
