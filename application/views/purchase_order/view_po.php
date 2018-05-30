<table id="items_count_details" class="table table-striped table-hover">
    <thead>
        <tr style="background-color: #999 !important;">
            <th colspan="4"><?php echo $title;?></th>
        </tr>
        <tr>
            <th width="30%"><?php echo $this->lang->line('grn_ref');?></th>
            <th width="30%"><?php echo $this->lang->line('grn_employee_name');?></th>
            <th width="40%"><?php echo $this->lang->line('grn_date');?></th>            
        </tr>
    </thead>
    <tbody id="inventory_result">
        <?php    
        foreach ($report_data as $row) {?>
        <tr>
            <td><?php echo $row['receiving_ref'];?></td>
            <td><?php echo $row['employeename'];?></td>
            <td><?php echo changeDateTime($row['receiving_time']);?></td>
        </tr>    
        <?php }
        ?>
    </tbody>
</table>