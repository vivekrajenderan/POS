<?php $this->load->view("partial/header"); ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<div id="page_title" class="page_title text-center">
    <?php echo $title ?>
</div>

<?php echo form_open('#', array('id' => 'currency_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')); ?>
<div class="form-group form-group-sm">
    <?php echo form_label($this->lang->line('reports_date_range'), 'report_date_range_label', array('class' => 'control-label col-xs-2 required')); ?>
    <div class="col-xs-3">
        <?php echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker')); ?>
    </div>
    <?php echo form_label($this->lang->line('currency'), 'currency_id', array('class' => 'control-label col-xs-1 required')); ?>
    <div class="col-xs-3">
        <?php echo form_dropdown('currency_id', $currency_list, '', array('class' => 'form-control input-sm', 'id' => 'currency_id')); ?>
    </div>

    <?php
    echo form_submit(array(
        'name' => 'submit_form',
        'id' => 'submit_form',
        'value' => $this->lang->line('common_submit'),
        'class' => 'btn btn-primary btn-sm'));
    ?>
</div>
<?php echo form_close(); ?>


<div id="page_subtitle">

    <?php echo $subtitle ?>
</div>


<div class="ct-chart ct-golden-section" id="chart1"></div>

<?php $this->load->view($chart_type); ?>


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript">
<?php $this->load->view('partial/daterangepicker'); ?>
    $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'),01,date('Y'))); ?>");
    $(document).ready(function ()
    {
        $('#currency_form').validate({
            submitHandler: function (form)
            {
                window.location = "<?php echo base_url() . 'currency/graph/'; ?>" + start_date + "/" + end_date + "/" + $("#currency_id").val();

            },
            errorLabelContainer: "#error_message_box",
            wrapper: "li",
            rules:
                    {
                        currency_id:
                                {
                                    required: true
                                }
                    },
            messages:
                    {
                        currency_id:
                                {
                                    required: "<?php echo $this->lang->line('currency_currency_type_required'); ?>"

                                }

                    }
        });

    });
</script>
