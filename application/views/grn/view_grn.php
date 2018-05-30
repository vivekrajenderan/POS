<table id="items_count_details" class="table table-striped table-hover">
    <thead>
        <tr style="background-color: #999 !important;">
            <th colspan="4"><?php echo $title;?></th>
        </tr>
        <tr>
            <th width="30%"><?php echo $this->lang->line('items_name');?></th>
            <th width="30%"><?php echo $this->lang->line('items_category');?></th>
            <th width="30%"><?php echo $this->lang->line('items_quantity');?></th>
            <th width="40%"><?php echo $this->lang->line('items_cost_price');?></th>            
        </tr>
    </thead>
    <tbody id="inventory_result">
        <?php    
        foreach ($report_data as $row) {?>
        <tr>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['category'];?></td>
            <td><?php echo to_quantity_decimals($row['receiving_quantity']);?></td>
            <td><?php echo $row['cost_price'];?></td>
        </tr>    
        <?php }
        ?>
    </tbody>
</table>