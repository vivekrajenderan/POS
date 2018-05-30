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
                    searchlist: "<?php echo $listfunction; ?>",
                    account_id: $("#account_id").val()
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
    $(document).ready(function ()
    {
        $('#deposit_form').validate({
            submitHandler: function (form)
            {
                $(form).ajaxSubmit({
                    success: function (response)
                    {
                        $.notify(response.message, {type: response.success ? 'success' : 'danger'});
                        if (response.status == 1)
                        {
                            $('#deposit_form')[0].reset();
                            table_support.refresh();
                        }
                    },
                    dataType: 'json'
                });

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        amount:
                                {
                                    required: true,
                                    number: true
                                },
                        reference:
                                {
                                    required: true
                                },
                        account_type:
                                {
                                    required: true
                                }
                    },
            messages:
                    {
                        amount:
                                {
                                    required: "<?php echo $this->lang->line('employees_deposit_amount_required'); ?>",
                                    number: "<?php echo $this->lang->line('employees_deposit_amount_number'); ?>"
                                },
                        reference:
                                {
                                    required: "<?php echo $this->lang->line('employees_deposit_reference_required'); ?>"

                                },
                        account_type:
                                {
                                    required: "<?php echo $this->lang->line('employees_deposit_type_required'); ?>"

                                }

                    }
        });

    });
</script>
<div id="page_title" class="text-center"><?php echo $this->lang->line($page_title); ?></div>
<br>
<?php echo form_open($controller_name . '/savedeposit/' . $employee_details->person_id . '/' . $employee_details->account_id, array('id' => 'deposit_form', 'autocomplete' => 'off', 'class' => 'form-horizontal')); ?>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-2">
            <label><?php echo $this->lang->line('employees_employee'); ?></label>
            <?php echo $employee_details->first_name . " " . $employee_details->last_name; ?>

        </div>
        <div class="col-xs-2">
            <?php echo form_dropdown('trans_type', $trans_type, '', array('id' => 'trans_type', 'class' => 'form-control input-sm')); ?>
        </div>
        <div class='col-xs-2'>
            <?php
            echo '<select name="account_type" id="account_type" class="form-control input-sm"> ';
            echo $account_types;
            echo "</select>";
            ?>
        </div>
        <div class="col-xs-2">
            <?php
            echo form_input(array(
                'name' => 'amount',
                'id' => 'amount',
                'class' => 'form-control input-sm',
                'placeholder' => $this->lang->line('employees_deposit_amount'),
                'value' => '')
            );
            ?>
        </div>
        <div class="col-xs-3">
            <?php
            echo form_input(array(
                'name' => 'reference',
                'id' => 'reference',
                'placeholder' => $this->lang->line('employees_deposit_reference'),
                'class' => 'form-control input-sm',
                'value' => '')
            );
            ?>
        </div>

        <div>      
            <label>&nbsp;</label>
            <?php
            echo form_submit(array(
                'name' => 'submit_form',
                'id' => 'submit_form',
                'value' => $this->lang->line('common_submit'),
                'class' => 'btn btn-primary btn-sm'));
            ?>
        </div>    
    </div>
</div>
<?php echo form_close(); ?>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>     
        <?php echo form_input(array('name' => 'account_id', 'id' => 'account_id', 'value' => $account_id, 'class' => 'form-control input-sm', 'type' => 'hidden')); ?>    
        <?php
        /*
          if (isset($trans_type))
          if (count($trans_type) > 0) {
          echo form_multiselect('trans_type', $trans_type, '', array('id' => 'trans_type', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
          }

          if (isset($accountdetails))
          if (count($accountdetails) > 0) {
          echo form_dropdown('account_type', $accountdetails, '', array('id' => 'account_type', 'class' => 'selectpicker show-menu-arrow', 'data-style' => 'btn-default btn-sm', 'data-width' => 'fit'));
          }
         */
        ?>
    </div>
</div>
<div id="table_holder">
    <table id="table"></table>
</div>
<?php $this->load->view("partial/footer"); ?>

