<?php

class Inventory extends CI_Model {

    public function insert($inventory_data) {
        if (!isset($inventory_data['price'])) {
            $inventory_data['price'] = $this->Item->get_info($inventory_data['trans_items'], $inventory_data['trans_location'])->cost_price;
        }
        if (!isset($inventory_data['balance'])) {
            $inventory_data['balance'] = $inventory_data['trans_inventory'] + $this->get_item_location_total_quantity($inventory_data['trans_items'], $inventory_data['trans_location']);
        }
        $inventory_data['employee_id'] = $this->session->userdata('person_id');
        return $this->db->insert('inventory', $inventory_data);
    }

    public function get_inventory_data_for_item($item_id, $location_id = FALSE) {
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        if ($location_id != FALSE) {
            $this->db->where('trans_location', $location_id);
        }
        $this->db->order_by('trans_date', 'desc');

        return $this->db->get();
    }
    
    public function get_inventoryadjustment_dd() {
        $this->db->from('inventory_adjustments');
        $result= $this->db->get()->result_array();
        $data=array();
        foreach ($result as $key => $value) {
            $data[$value['id']] = $value['text'];
        }
        return $data;
    }

    public function get_item_location_total_quantity($item_id, $location_id = FALSE) {
        $this->db->select('sum(trans_inventory) as total');
        $this->db->from('inventory');
        $this->db->where('trans_items', $item_id);
        if ($location_id != FALSE) {
            $this->db->where('trans_location', $location_id);
        }
        return $this->db->get()->row()->total;
    }

    public function get_inventory_log_rows($search, $filters) {
        $this->db->select('iy.trans_date,iy.trans_comment,iy.trans_inventory,iy.price,iy.balance,(iy.price*iy.trans_inventory) as inventory_total,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name');
        $this->db->from('inventory as iy');
        $this->db->join('people as cp', 'iy.trans_user = cp.person_id');
        $this->db->join('items as it', 'iy.trans_items = it.item_id');
        $this->db->join('stock_locations as sl', 'iy.trans_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('iy.trans_comment', $search);
        $this->db->or_like('iy.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('iy.trans_inventory', $search);
        $this->db->or_like('iy.price', $search);
        $this->db->or_like('iy.balance', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('it.name', $search);
        $this->db->group_end();
        if ($filters['item_locations']) {
            $this->db->where_in('sl.location_id', $filters['item_locations']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(iy.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('iy.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function inventory_log_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select('iy.trans_date,iy.trans_comment,iy.trans_inventory,iy.price,iy.balance,(iy.price*iy.trans_inventory) as inventory_total,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,it.name as item_name');
        $this->db->from('inventory as iy');
        $this->db->join('people as cp', 'iy.trans_user = cp.person_id');
        $this->db->join('items as it', 'iy.trans_items = it.item_id');
        $this->db->join('stock_locations as sl', 'iy.trans_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('iy.trans_comment', $search);
        $this->db->or_like('iy.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('iy.trans_inventory', $search);
        $this->db->or_like('iy.price', $search);
        $this->db->or_like('iy.balance', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('it.name', $search);
        $this->db->group_end();
        if ($filters['item_locations']) {
            $this->db->where_in('sl.location_id', $filters['item_locations']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(iy.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('iy.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

}

?>