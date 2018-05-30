<?php

class Stockorder extends CI_Model {

    public function get_stock_order_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('stock_order');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,stl.location_name as stock_location_name');
        $this->db->from('receivings as rc');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('stock_locations as stl', 'rc.supplier_id = stl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('stl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['item_location']) {
            $this->db->where_in('stl.location_id', $filters['item_location']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'stock_order');
        $this->db->where_in('sl.location_id', $employee_ids_all);
        $this->db->group_by('ri.receiving_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function stock_order_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'desc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('stock_order');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,stl.location_name as stock_location_name');
        $this->db->from('receivings as rc');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('stock_locations as stl', 'rc.supplier_id = stl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('stl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['item_location']) {
            $this->db->where_in('stl.location_id', $filters['item_location']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'stock_order');
        $this->db->where_in('sl.location_id', $employee_ids_all);
        $this->db->group_by('ri.receiving_id');
        if (empty($sort)) {
            $this->db->order_by('rc.receiving_id', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }
        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    public function get_element($receiving_id, $receiving_status = array('open', 'partially')) {
        if (ctype_digit($receiving_id)) {
            $this->db->from('receivings');
            $this->db->where('receiving_id', (int) $receiving_id);
            $this->db->where('receiving_mode', 'stock_order');
            $this->db->where_in('receiving_status', $receiving_status);
            return $this->db->get()->row_array();
        }

        return FALSE;
    }

}

?>