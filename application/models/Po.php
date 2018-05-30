<?php

class Po extends CI_Model {

    public function exists($po_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'po') {
        if (ctype_digit($po_id)) {
            $this->db->from('receivings');
            $this->db->where('receiving_id', (int) $po_id);
            $this->db->where('receiving_mode', $receiving_mode);
            $this->db->where_in('receiving_status', $receiving_status);
            return ($this->db->get()->num_rows() == 1);
        }

        return FALSE;
    }

    public function get_element($po_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'po') {
        if (ctype_digit($po_id)) {
            $this->db->from('receivings');
            $this->db->where('receiving_id', (int) $po_id);
            $this->db->where('receiving_mode', $receiving_mode);
            $this->db->where_in('receiving_status', $receiving_status);
            return $this->db->get()->row_array();
        }

        return FALSE;
    }

    public function get_po_items($po_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'po') {
        $suggestions = array();
        $this->db->select('receivings.receiving_ref as po_id,items.name,items.item_id,receivings_items.request_quantity,receivings_items.balance_quantity,receivings.supplier_id,receivings_items.item_location,receivings_items.item_cost_price,receivings_items.item_unit_price,po_ref,receivings_items.receiving_quantity');
        $this->db->from('items as items');
        $this->db->join('receivings_items as receivings_items', 'receivings_items.item_id = items.item_id', 'left');
        $this->db->join('receivings as receivings', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        $this->db->where_in('receivings.receiving_status', $receiving_status);
        $this->db->where('receivings.receiving_mode', $receiving_mode);
        $this->db->where('receivings.receiving_id', $po_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function get_store_items($po_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'po') {
        $result = $this->get_po_items($po_id, $receiving_status, $receiving_mode);
        $data = array();
        if ($result) {
            foreach ($result as $key => $value) {
                $data[$value['item_id']] = array(
                    'balance_quantity' => $value['balance_quantity'],
                    'request_quantity' => $value['request_quantity']
                );
            }
        }
        return $data;
    }

    public function get_search_suggestions($search, $limit = 25, $where = array('receiving_mode' => 'po')) {
        $suggestions = array();
        $receiving_status = array('open', 'partially');
        $this->db->select('receivings.receiving_id, receivings.receiving_ref');
        $this->db->from('receivings as receivings');
        //$this->db->join('receivings_items as receivings_items', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        //$po_id = preg_replace("/.*?_(\d+)$/", "$1", $search);
        if (isset($search) && $search != '')
            $this->db->like('receivings.receiving_ref', $search);

        foreach ($where as $key => $value) {
            if (is_array($value)) {
                $this->db->where_in($key, $value);
            } else {
                $this->db->where($key, $value);
            }
        }

        //$this->db->group_by('receivings.receiving_id');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $suggestions[] = array('value' => $row->receiving_id, 'label' => $row->receiving_ref);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function get_search_suggestions_items($search, $limit = 25, $where = array('receiving_mode' => 'po')) {
        $suggestions = array();
        $receiving_status = array('open', 'partially');
        $this->db->select('receivings.receiving_id, receivings.receiving_ref');
        $this->db->from('receivings as receivings');
        $this->db->join('receivings_items as receivings_items', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        if (isset($search) && $search != '')
            $this->db->like('receivings.receiving_ref', $search);
//        if (isset($item_location) && $item_location != '')
//            $this->db->like('receivings_items.item_location', $item_location);
//        $this->db->where_in('receivings.receiving_status', $receiving_status);
//        $this->db->where('receiving_mode', $receiving_mode);
        foreach ($where as $key => $value) {
            if (is_array($value)) {
                $this->db->where_in($key, $value);
            } else {
                $this->db->where($key, $value);
            }
        }
        $this->db->group_by('receivings.receiving_id');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $suggestions[] = array('value' => $row->receiving_id, 'label' => $row->receiving_ref);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Gets rows
     */

    public function get_po_found_rows($search, $filters) {
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['item_location']) {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'po');
        $this->db->group_by('rc.receiving_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function po_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['item_location']) {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'po');
        $this->db->group_by('rc.receiving_id');
        if (empty($sort)) {
            $this->db->order_by('rc.receiving_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    /*
      Gets rows
     */

    public function get_stock_found_rows($search, $filters, $mode = 'receive') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all($mode);
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,sp.location_name AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,rp.receiving_ref as receiving_pref,rp.receiving_time AS po_time');
        $this->db->from('receivings as rc');
        $this->db->join('receivings as rp', 'rc.po_ref = rp.receiving_id');
        $this->db->join('stock_locations as sp', 'rc.supplier_id = sp.location_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->like('rc.receiving_id', $search);
        $this->db->like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('sp.location_name', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('rp.receiving_time', $search);
        $this->db->or_like('rp.receiving_ref', $search);
        $this->db->group_end();
        if (isset($filters['item_location']) && $filters['item_location'] != '') {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        if (isset($filters['supplier']) && $filters['supplier'] != '') {
            $this->db->where_in('rc.supplier_id', $filters['supplier']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', $mode);
        $this->db->group_by('rc.receiving_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function stock_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc', $mode = 'receive') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all($mode);
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,sp.location_name AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,rp.receiving_ref as receiving_pref,rp.receiving_time AS po_time');
        $this->db->from('receivings as rc');
        $this->db->join('receivings as rp', 'rc.po_ref = rp.receiving_id');
        $this->db->join('stock_locations as sp', 'rc.supplier_id = sp.location_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('sp.location_name', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('rp.receiving_time', $search);
        $this->db->or_like('rp.receiving_ref', $search);
        $this->db->group_end();
        if (isset($filters['item_location']) && $filters['item_location'] != '') {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        if (isset($filters['supplier']) && $filters['supplier'] != '') {
            $this->db->where_in('rc.supplier_id', $filters['supplier']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', $mode);
        $this->db->group_by('rc.receiving_id');
        if (empty($sort)) {
            $this->db->order_by('rc.receiving_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    /*
      Gets rows
     */

    public function get_grn_found_rows($search, $filters, $mode = 'receive') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('grn');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,rp.receiving_ref as receiving_pref,rp.receiving_time AS po_time');
        $this->db->from('receivings as rc');
        $this->db->join('receivings as rp', 'rc.po_ref = rp.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('rp.receiving_time', $search);
        $this->db->or_like('rp.receiving_ref', $search);
        $this->db->group_end();
        if (isset($filters['item_location']) && count($filters['item_location']) > 0 && $filters['item_location']) {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', $mode);
        $this->db->group_by('rc.receiving_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function grn_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc', $mode = 'receive') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('grn');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,sl.location_name,rp.receiving_ref as receiving_pref,rp.receiving_time AS po_time');
        $this->db->from('receivings as rc');
        $this->db->join('receivings as rp', 'rc.po_ref = rp.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rc.employee_id = cp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->or_like('rp.receiving_time', $search);
        $this->db->or_like('rp.receiving_ref', $search);
        $this->db->group_end();
        if (isset($filters['item_location']) && count($filters['item_location']) > 0 && $filters['item_location']) {
            $this->db->where_in('ri.item_location', $filters['item_location']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', $mode);
        $this->db->group_by('rc.receiving_id');
        if (empty($sort)) {
            $this->db->order_by('rc.receiving_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function getPoData($receiving_id) {
        $this->db->select('receivings.receiving_ref,receivings.receiving_time,CONCAT(people.first_name, " ", people.last_name) AS employeename');
        $this->db->from('receivings as receivings');
        $this->db->join('people as people', 'receivings.employee_id = people.person_id');
        $this->db->where('receivings.po_ref', $receiving_id);
        $this->db->order_by('receivings.receiving_id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return array();
        }
    }

}

?>
