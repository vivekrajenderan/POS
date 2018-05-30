<?php

class Stock_location extends CI_Model {

    public function exists($location_name = '', $storefor = 'store') {
        $this->db->from('stock_locations');
        if ($storefor != '')
            $this->db->where('location_type', $storefor);
        $this->db->where('location_name', $location_name);

        return ($this->db->get()->num_rows() >= 1);
    }

    public function get_row($location_id = '', $storefor = 'store') {
        $this->db->from('stock_locations');
        if ($storefor != '')
            $this->db->where('location_type', $storefor);
        $this->db->where('location_id', $location_id);
        return ($this->db->get()->row_array());
    }

    public function get_search_suggestions($search = '', $locationtype = 'store', $limit = 25) {
        $suggestions = array();
        $this->db->from('stock_locations');
        if ($locationtype != '')
            $this->db->where('location_type', $locationtype);
        $this->db->where('deleted', 0);
        $this->db->group_start();
        $this->db->or_like('location_name', $search);
        $this->db->or_like('location_type', $search);
        $this->db->or_like('phone_number', $search);
        $this->db->or_like('address_1', $search);
        $this->db->or_like('address_2', $search);
        $this->db->or_like('city', $search);
        $this->db->or_like('state', $search);
        $this->db->or_like('zip', $search);
        $this->db->or_like('country', $search);
        $this->db->group_end();
        $this->db->order_by('location_name', 'asc');
        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->location_id, 'label' => $row->location_name);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    public function get_all($locationtype = 'store', $limit = 10000, $offset = 0) {
        $this->db->from('stock_locations');
        if ($locationtype != '') {
            $this->db->where('location_type', $locationtype);
            $this->db->where('deleted', '0');
        }
        $this->db->limit($limit);
        $this->db->offset($offset);

        return $this->db->get();
    }

    public function get_undeleted_all($module_id = 'items', $storefor = 'store', $search = '') {
        $this->db->from('stock_locations');
        $this->db->join('permissions', 'permissions.location_id = stock_locations.location_id');
        $this->db->join('grants', 'grants.permission_id = permissions.permission_id');
        $this->db->where('person_id', $this->session->userdata('person_id'));
        if ($storefor != '')
            $this->db->where('stock_locations.location_type', $storefor);

        $this->db->like($this->db->dbprefix('permissions') . '.permission_id', $module_id, 'after', FALSE);
        $this->db->where('deleted', 0);
        if ($search != '') {
            $this->db->group_start();
            $this->db->or_like('location_name', $search);
            $this->db->or_like('location_type', $search);
            $this->db->or_like('phone_number', $search);
            $this->db->or_like('address_1', $search);
            $this->db->or_like('address_2', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('state', $search);
            $this->db->or_like('zip', $search);
            $this->db->or_like('country', $search);
            $this->db->group_end();
        }
        return $this->db->get();
    }

    public function get_employee_ids_all($module_id = 'items') {
        $return_id = array();
        $this->db->select("group_concat(" . $this->db->dbprefix('stock_locations') . ".location_id) as location_id");
        $this->db->from('stock_locations');
        $this->db->join('permissions', 'permissions.location_id = stock_locations.location_id');
        $this->db->join('grants', 'grants.permission_id = permissions.permission_id');
        $this->db->where('person_id', $this->session->userdata('person_id'));
        $this->db->like($this->db->dbprefix('permissions') . '.permission_id', $module_id, 'after', FALSE);
        $this->db->where('deleted', 0);
        $search = $this->db->get()->result_array();
        if (count($search) > 0)
            $return_id = explode(',', $search[0]['location_id']);


        return $return_id;
    }

    public function show_locations($module_id = 'items') {
        $stock_locations = $this->get_allowed_locations($module_id);

        return count($stock_locations) > 1;
    }

    public function multiple_locations() {
        return $this->get_all()->num_rows() > 1;
    }

    public function get_allowed_locations($module_id = 'items', $storefor = 'store') {
        $stock = $this->get_undeleted_all($module_id, $storefor)->result_array();
        $stock_locations = array();
        foreach ($stock as $location_data) {
            $stock_locations[$location_data['location_id']] = $location_data['location_name'];
        }

        return $stock_locations;
    }

    public function get_allowed_locations_search($module_id = 'items', $storefor = 'store', $search, $limit = 25) {
        $stock = $this->get_undeleted_all($module_id, $storefor, $search)->result_array();
        $suggestions = array();
        foreach ($stock as $location_data) {
            $suggestions[] = array('value' => $location_data['location_id'], 'label' => $location_data['location_name']);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    public function is_allowed_location($location_id, $module_id = 'items') {
        $this->db->from('stock_locations');
        $this->db->join('permissions', 'permissions.location_id = stock_locations.location_id');
        $this->db->join('grants', 'grants.permission_id = permissions.permission_id');
        //$this->db->where('person_id', $this->session->userdata('person_id'));
        $this->db->join('employees_role', 'employees_role.id  = grants.person_id', 'left');
        $this->db->join('employees', 'employees.role_id = employees_role.id', 'left');
        $this->db->where('employees.person_id', $this->session->userdata('person_id'));
        
        $this->db->like('permissions.permission_id', $module_id, 'after');
        
        $this->db->where('stock_locations.deleted', 0);
        $this->db->where('stock_locations.location_id', $location_id);

        return ($this->db->get()->num_rows() == 1);
    }

    public function get_default_location_id($storefor = 'store') {
        $this->db->from('stock_locations');
        $this->db->join('permissions', 'permissions.location_id = stock_locations.location_id');
        $this->db->join('grants', 'grants.permission_id = permissions.permission_id');
        //$this->db->where('person_id', $this->session->userdata('person_id'));

        $this->db->join('employees_role', 'employees_role.id  = grants.person_id', 'left');
        $this->db->join('employees', 'employees.role_id = employees_role.id', 'left');
        $this->db->where('employees.person_id', $this->session->userdata('person_id'));

        if ($storefor != '')
            $this->db->where('location_type', $storefor);
        $this->db->where('stock_locations.deleted', 0);
        $this->db->limit(1);
        return $this->db->get()->row()->location_id;
    }

    public function get_location_name($location_id) {
        $this->db->from('stock_locations');
        $this->db->where('location_id', $location_id);

        return $this->db->get()->row()->location_name;
    }

    public function get_location_type($location_id) {
        $this->db->from('stock_locations');
        $this->db->where('location_id', $location_id);
        return $this->db->get()->row()->location_type;
    }

    public function save(&$location_data, $location_id, $storefor = 'store') {

        $location_name = $location_data['location_name'];
        if (!$this->exists($location_name, $storefor)) {
            $this->db->trans_start();

            $location_data ['deleted'] = 0;
            if ($storefor != '')
                $location_data['location_type'] = $storefor;
            $this->db->insert('stock_locations', $location_data);
            $location_id = $this->db->insert_id();

            $this->_insert_new_permission('items', $location_id, $location_name);
            $this->_insert_new_permission('inventories', $location_id, $location_name);
            $this->_insert_new_permission('return', $location_id, $location_name);
            if ($storefor == 'store') {
                $this->_insert_new_permission('sales', $location_id, $location_name);
                $this->_insert_new_permission('invoice', $location_id, $location_name);
                $this->_insert_new_permission('stockorder_check', $location_id, $location_name);
                $this->_insert_new_permission('stock_order', $location_id, $location_name);
            } else {
                $this->_insert_new_permission('grn', $location_id, $location_name);
                $this->_insert_new_permission('pay', $location_id, $location_name);
                $this->_insert_new_permission('purchase_order', $location_id, $location_name);
                $this->_insert_new_permission('requisition', $location_id, $location_name);
            }
// insert quantities for existing items
            $items = $this->Item->get_all();
            foreach ($items->result_array() as $item) {
                $quantity_data = array('item_id' => $item['item_id'], 'location_id' => $location_id, 'quantity' => 0);
                $this->db->insert('item_quantities', $quantity_data);

                $price_data = array('item_id' => $item['item_id'], 'location_id' => $location_id, 'price' => $item['unit_price']);
                if ($storefor != 'store') {
                    $price_data['price'] = ($item['cost_price']) ? $item['cost_price'] : 0;
                }
                $this->db->insert('item_price', $price_data);
            }

            $this->db->trans_complete();

            return $this->db->trans_status();
        } else {
            $this->db->where('location_id', $location_id);

            return $this->db->update('stock_locations', $location_data);
        }
    }

    private function _insert_new_permission($module, $location_id, $location_name) {
// insert new permission for stock location
        $permission_id = $module . '_' . $location_name;
        $permission_data = array('permission_id' => $permission_id, 'module_id' => $module, 'location_id' => $location_id);
        $this->db->insert('permissions', $permission_data);

// insert grants for new permission
        $employees = $this->Employee->get_all();
        foreach ($employees->result_array() as $employee) {
            $grants_data = array('permission_id' => $permission_id, 'person_id' => $employee['person_id']);
            $this->db->insert('grants', $grants_data);
        }
    }

    /*
      Deletes one item
     */

    public function delete($location_id) {
        $this->db->trans_start();

        $this->db->where('location_id', $location_id);
        $this->db->update('stock_locations', array('deleted' => 1));

        $this->db->where('location_id', $location_id);
        $this->db->delete('permissions');

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_so_items($po_id, $receiving_status = array('open', 'partially'), $receiving_mode = 'stock_order') {
        $suggestions = array();
        $this->db->select('receivings.receiving_ref as po_id,items.name,items.item_id,receivings_items.request_quantity,receivings_items.balance_quantity,receivings.supplier_id,receivings_items.item_location,receivings_items.item_cost_price,receivings_items.item_unit_price');
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

    public function get_all_locations($storefor = 'store') {
        $this->db->from('stock_locations');
        if ($storefor != '')
            $this->db->where('location_type', $storefor);
        $this->db->where('deleted', '0');
        $stock = $this->db->get()->result_array();
        $stock_locations = array();
        foreach ($stock as $location_data) {
            $stock_locations[$location_data['location_id']] = $location_data['location_name'];
        }

        return $stock_locations;
    }

}

?>