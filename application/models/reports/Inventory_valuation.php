<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Report.php");

class Inventory_valuation extends Report {

    function __construct() {
        parent::__construct();
    }

    public function getDataColumns() {

        return array(
            'summary' => array(
                array('item_name' => $this->lang->line('inventory_item_name')),
                array('item_number' => $this->lang->line('inventory_item_number')),
                array('location_name' => $this->lang->line('inventory_stock_location')),
                array('total_quantity' => $this->lang->line('inventory_quantity')),
                array('total_price' => $this->lang->line('inventory_average_price'), 'sorter' => 'number_sorter')),
            'details' => array(
                $this->lang->line('inventory_grn_date'),
                $this->lang->line('inventory_grn_ref'),
                $this->lang->line('inventory_stock_location'),
                $this->lang->line('inventory_quantity'),
                $this->lang->line('inventory_price'))
        );
    }

    public function getData(array $inputs) {
        $this->db->select('items.name, items.item_number,items.item_id,inventory.trans_items, SUM(inventory.price*inventory.trans_inventory) as total_price,SUM(inventory.trans_inventory) as total_quantity,stock_locations.location_name');
        $this->db->from('inventory as inventory');
        $this->db->join('stock_locations as stock_locations', 'inventory.trans_location = stock_locations.location_id');
        $this->db->join('items as items', 'items.item_id = inventory.trans_items');

        if (!empty($inputs['start_date']) && !empty($inputs['end_date'])) {
            if (empty($this->config->item('date_or_time_format'))) {
                $this->db->where('DATE_FORMAT(inventory.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
            } else {
                $this->db->where('inventory.trans_date BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
            }
        }        
        if ($inputs['item_location'] != 'all') {
            $this->db->where('inventory.trans_location', $inputs['item_location']);
        }
        
        $this->db->order_by('items.name');
        $this->db->group_by('inventory.trans_items');
        return $this->db->get()->result_array();
    }

    public function getSingleData($item_id, $inputs) {
        $this->db->select('receivings.receiving_ref,items.name, items.item_number,receivings_items.item_id, receivings_items.item_cost_price,receivings_items.receiving_quantity,(receivings_items.item_cost_price*receivings_items.receiving_quantity) as total_price,DATE_FORMAT(receivings.receiving_time,"%d/%m/%Y") AS receiving_time,stock_locations.location_name');
        $this->db->from('receivings as receivings');
        $this->db->join('receivings_items as receivings_items', 'receivings.receiving_id = receivings_items.receiving_id');
        $this->db->join('stock_locations as stock_locations', 'receivings_items.item_location = stock_locations.location_id');
        $this->db->join('items as items', 'items.item_id = receivings_items.item_id');
        $this->db->where('receivings_items.item_id', $item_id);
        $this->db->where('receivings.receiving_status', 'closed');
        $this->db->where('receivings.receiving_mode', 'receive');
        if (!empty($inputs['start_date']) && !empty($inputs['end_date'])) {
            if (empty($this->config->item('date_or_time_format'))) {
                $this->db->where('DATE_FORMAT(receivings.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
            } else {
                $this->db->where('receivings.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
            }
        }
        if (!empty($inputs['item_location']) && !empty($inputs['item_location'])) {
            $this->db->where('receivings_items.item_location', $inputs['item_location']);
        }
        $this->db->order_by('items.name');
        return $this->db->get()->result_array();
    }

    public function getSummaryData(array $inputs) {
        return array();
    }

}

?>
