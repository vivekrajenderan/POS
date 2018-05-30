<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
    $(document).ready(function()
    {

<?php $this->load->view('partial/daterangepicker'); ?>
        // set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>");
<?php if (isset($_POST['enddate'])) {
    ?>

            $('#daterangepicker').data('daterangepicker').setStartDate("<?php echo date($this->config->item('dateformat'), strtotime($_POST['startdate'])); ?>");
            $('#daterangepicker').data('daterangepicker').setEndDate("<?php echo date($this->config->item('dateformat'), strtotime($_POST['enddate'])); ?>");
    <?php
}
?>

        // update the hidden inputs with the selected dates before submitting the search data
        var start_date = "<?php echo date('Y-m-d', mktime(0, 0, 0, date('m'), 01, date('Y'))); ?>";
        $('input[name="startdate"]').val(start_date)
        $('input[name="enddate"]').val(end_date)
        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            $('input[name="startdate"]').val(start_date)
            $('input[name="enddate"]').val(end_date)
        });
    });
</script>
<div id="page_title" class="text-center"><?php echo $this->lang->line($page_title); ?></div>
<br>
<div id="toolbar">
    <div class="pull-left form-inline" role="toolbar">
        <?php
        echo form_open($controller_name . "/trial_balance", array('id' => 'mode_form', 'class' => 'form-horizontal panel panel-default'));
        echo form_input(array('name' => 'daterangepicker', 'class' => 'form-control input-sm', 'id' => 'daterangepicker'));
        $data = array(
            'name' => 'search',
            'id' => 'search',
            'class' => 'btn btn-sm btn-success',
            'type' => 'submit',
            'content' => $this->lang->line('common_search')
        );
        echo form_hidden('startdate', '');
        echo form_hidden('enddate', '');
        echo form_button($data);
        echo form_close();
        ?>

    </div>
</div>
<div id="table_holder">
    <table id="table" class="table table-hover  table-bordered"> 
        <thead>
            <tr>
                <th><?php echo $this->lang->line('account_name'); ?></th>
                <th><?php echo $this->lang->line('account_debit'); ?></th>
                <th><?php echo $this->lang->line('account_credit'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($table_value) > 0) {
                $debit_amount_total = 0;
                $credit_amount_total = 0;
                foreach ($table_value as $hkey => $hvalue) {

                    echo '<tr>';
                    echo '<th colspan="3">' . $hvalue[$hkey]['name'] . '</th>';
                    echo '</tr>';
                    foreach ($hvalue as $vkey => $vvalue) {
                        if (isset($vvalue['account_id'])) {
                            $debit_amount = (isset($vvalue['debit_amount'])) ? $vvalue['debit_amount'] : '';
                            $debit_amount_total += $debit_amount;
                            $credit_amount = (isset($vvalue['credit_amount'])) ? $vvalue['credit_amount'] : '';
                            $credit_amount_total += $credit_amount;
                            if ($vkey != $hkey) {
                                echo '<tr>';
                                echo '<td>' . $vvalue['name'] . '</td>';
                                echo '<td class="text-right">' . to_currency($debit_amount) . '</td>';
                                echo '<td class="text-right">' . to_currency($credit_amount) . '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                }
                echo '<tr>';
                echo '<th>' . $this->lang->line('account_total')  . '</th>';
                echo '<th class="text-right">' . to_currency($debit_amount_total) . '</th>';
                echo '<th class="text-right">' . to_currency($credit_amount_total) . '</th>';
                echo '</tr>';
            } else {
                echo '<tr>';
                echo '<td colspan="3">' . $this->lang->line('accounts_no_accounts_to_display') . '</td>';
                echo '<tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php $this->load->view("partial/footer"); ?>