<?php

class Grn_modal extends CI_Model {

    public function get_element($grn_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'receive') {
        if (ctype_digit($grn_id)) {
            $this->db->from('receivings');
            $this->db->where('receiving_id', (int) $grn_id);
            $this->db->where('receiving_mode', $receiving_mode);
            $this->db->where_in('receiving_status', $receiving_status);
            return $this->db->get()->row_array();
        }

        return FALSE;
    }

    public function get_items($receiving_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'receive') {
        $suggestions = array();
        $this->db->select('receivings.receiving_ref as po_id,items.name,items.item_id,receivings_items.request_quantity,receivings_items.balance_quantity,receivings.supplier_id,receivings_items.item_location');
        $this->db->from('items as items');
        $this->db->join('receivings_items as receivings_items', 'receivings_items.item_id = items.item_id', 'left');
        $this->db->join('receivings as receivings', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        $this->db->where_in('receivings.receiving_status', $receiving_status);
        $this->db->where('receivings.receiving_mode', $receiving_mode);
        $this->db->where('receivings.receiving_id', $receiving_id);
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function get_bill($receiving_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'receive') {
        $suggestions = array();
        $this->db->select('receivings.payment_ref,receivings.receiving_id,sum(receivings_items.receiving_quantity) as quantity,sum(receivings_items.receiving_quantity*receivings_items.item_cost_price) as cost,receivings_items.item_cost_price as costperqty,receivings.supplier_id,receivings_items.item_location');
        $this->db->from('receivings_items as receivings_items');
        $this->db->join('receivings as receivings', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        $this->db->where_in('receivings.receiving_status', $receiving_status);
        $this->db->where('receivings.receiving_mode', $receiving_mode);
        $this->db->where('receivings.receiving_id', $receiving_id);
        $this->db->group_by('receivings.receiving_id');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function get_search_suggestions($search, $searchfor, $receiving_status = array('open', 'partially'), $receiving_mode = 'receive', $limit = 25, $condition = array()) {
        if ($searchfor == 'payment_ref') {
            $stock_source = $this->pay_lib->get_stock_source();
            $supplier = $this->pay_lib->get_supplier();
        }
        $suggestions = array();
        $this->db->select('receivings.receiving_id, receivings.payment_ref');
        $this->db->from('receivings as receivings');
        $this->db->join('receivings_items as receivings_items', 'receivings_items.receiving_id = receivings.receiving_id', 'left');
        if (isset($search) && $search != '')
            $this->db->like($searchfor, $search);
        $this->db->where_in('receivings.receiving_status', $receiving_status);
        $this->db->where_in('receivings.payment_status', array('unpaid', 'partially'));
        $this->db->where('receiving_mode', $receiving_mode);
        if ($searchfor == 'payment_ref') {
            $this->db->where('receivings_items.item_location', $stock_source);
            if ($supplier != '-1')
                $this->db->where('receivings.supplier_id', $supplier);
        }
        $this->db->group_by('receivings.receiving_id');
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $suggestions[] = array('value' => $row->receiving_id, 'label' => $row->payment_ref);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    public function getGrnData($receiving_id) {
        $this->db->select('receivings_items.receiving_quantity,items.name,items.category,items.cost_price');
        $this->db->from('receivings');
        $this->db->join('receivings_items', 'receivings.receiving_id = receivings_items.receiving_id');
        $this->db->join('items', 'receivings_items.item_id = items.item_id');
        $this->db->where('receivings.receiving_id', $receiving_id);
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
