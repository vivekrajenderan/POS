<?php

class Account extends CI_Model {

    public $dropdownlist = [];

    public function insert($account_data = array()) {
        $this->db->insert('account', $account_data);
        return $this->db->insert_id();
    }

    public function get_info($account_id = -1) {
        $this->db->from('account');
        $this->db->where('id', $account_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_employee_account_id($person_id = -1) {
        $this->db->from('employees');
        $this->db->where('person_id', $person_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->account_id;
        } else {
            return $person_id;
        }
    }

    public function get_supplier_account_id($person_id = -1) {
        $this->db->from('suppliers');
        $this->db->where('person_id', $person_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->account_id;
        } else {
            return $person_id;
        }
    }

    public function insert_trans($account_data = array()) {
        $account_data['employee_id'] = $this->session->userdata('person_id');
        $account_data['trans_date'] = date('Y-m-d H:i:s');
        $this->db->insert('account_trans', $account_data);
        return $this->db->insert_id();
    }

    public function getDetails($parent_id = '') {

        $this->db->select('*');
        $this->db->from('account');
        if ($parent_id != '') {
            $this->db->where('parent', $parent_id);
        }
        $query = $this->db->get();
        $account_details = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $details) {
                $account_details[$details['id']] = $details['name'];
            }
            return $account_details;
        } else {
            return array();
        }
    }

    function getDetailsDropdownTree($parent_id) {
        $this->db->select('*');
        $this->db->from('account');
        if ($parent_id != '') {
            $this->db->where('parent', $parent_id);
        }
        $rows = $this->db->get()->result_array();
        foreach ($rows as $row) {
            $this->dropdownlist[] = $row;
            if ($this->has_childrendropdown($rows, $row['id']))
                $this->dropdownlist = $this->getDetailsDropdownTree($row['id']);
        }
        return $this->dropdownlist;
    }
    
    function getdropdowns($parent_id) {
        $this->db->select('id,name');
        $this->db->from('account');
        if ($parent_id != '') {
            $this->db->where('parent', $parent_id);
        }
        $rows = $this->db->get()->result_array();
        foreach ($rows as $row) {
            $this->dropdownlist[$row['id']] = $row['name'];
            if ($this->has_childrendropdown($rows, $row['id']))
                $this->dropdownlist = $this->getdropdowns($row['id']);
        }
        return $this->dropdownlist;
    }

    function has_childrendropdown($rows, $id) {
        $this->db->select('count(*) as count');
        $this->db->from('account');
        $this->db->where('parent', $id);
        $row = $this->db->get()->row_array();
        //$this->dropdownlist='';
        if ($row['count'] > 0)
            return true;
        return false;
    }

    function has_children($rows, $id) {
        foreach ($rows as $row) {
            if ($row['parent'] == $id)
                return true;
        }
        return false;
    }

    function build_option($rows, $parent = 0, $selected = '') {
        $result = "";
        foreach ($rows as $row) {
            if ($row['parent'] == $parent) {
                if ($this->has_children($rows, $row['id'])) {
                    $result.= "<optgroup label='" . $row['name'] . "'>";
                } else {
                    if ($selected == $row['id'])
                        $result.= "<option value='" . $row['id'] . "' selected>" . $row['name'];
                    else
                        $result.= "<option value='" . $row['id'] . "'>" . $row['name'];
                }
                if ($this->has_children($rows, $row['id']))
                    $result.= $this->build_option($rows, $row['id']);
                if ($this->has_children($rows, $row['id'])) {
                    $result.= "</optgroup>";
                } else {
                    $result.= "</option>";
                }
            }
        }
        return $result;
    }

    public function get_transactionsearch_found_rows($search, $filters) {
        $this->db->select('at.id,at.trans_type,at.trans_date,at.reference,at.amount as creditamount,at.amount as debitamount,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,ac.name as account_name,sl.location_name');
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->join('people as cp', 'at.employee_id = cp.person_id');
        $this->db->join('stock_locations as sl', 'at.location_id = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('at.reference', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['item_location']) {
            $this->db->where_in('sl.location_id', $filters['item_location']);
        }
        if ($filters['trans_type']) {
            $this->db->where_in('at.trans_type', $filters['trans_type']);
        }
        if ($filters['account_type'] && $filters['account_type'] != 'all') {
            $this->db->where('ac.id', $filters['account_type']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function transactionsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select('at.id,at.trans_type,at.trans_date,at.reference,at.amount as creditamount,at.amount as debitamount,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,ac.name as account_name,sl.location_name');
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->join('people as cp', 'at.employee_id = cp.person_id');
        $this->db->join('stock_locations as sl', 'at.location_id = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('at.reference', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['item_location']) {
            $this->db->where_in('sl.location_id', $filters['item_location']);
        }
        if ($filters['trans_type']) {
            $this->db->where_in('at.trans_type', $filters['trans_type']);
        }
        if ($filters['account_type'] && $filters['account_type'] != 'all') {
            $this->db->where('ac.id', $filters['account_type']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (!empty($sort))
            $this->db->order_by($sort, $order);
        else
            $this->db->order_by('at.trans_date', 'desc');

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    /*
      Trail balence search
     */

    public function trialbalancesearch($filters) {
        $this->db->select("if((sum(IF(trans_type = 'debit', `amount`, 0)) - sum(IF(trans_type = 'credit', `amount`, 0)))> 0,sum(IF(trans_type = 'debit', `amount`, 0)) - sum(IF(trans_type = 'credit', `amount`, 0)),0) as debit_amount,if((sum(IF(trans_type = 'credit', `amount`, 0)) - sum(IF(trans_type = 'debit', `amount`, 0)))> 0,sum(IF(trans_type = 'credit', `amount`, 0)) - sum(IF(trans_type = 'debit', `amount`, 0)),0) as credit_amount,ac.name,ac.parent,at.account_id");
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id', 'left');
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('at.account_id');
        $result_list = $this->db->get()->result_array();
        $this->db->select("name,id");
        $this->db->from('account');
        $this->db->where('parent', '0');
        $result_main = $this->db->get()->result_array();
        $main = array();
        foreach ($result_main as $mainkey => $mainvalue) {
            $main[$mainvalue['id']] = array('name' => $mainvalue['name']);
        }
        $result = array();
        $i = 0;
        foreach ($result_list as $listkey => $listvalue) {
            $result_parent_tree = $this->db->query('SELECT T2.id, T2.name
                            FROM (
                                SELECT
                                    @r AS _id,
                                    (SELECT @r := parent FROM ' . $this->db->dbprefix('account') . ' WHERE id = _id) AS parent_id,
                                    @l := @l + 1 AS lvl
                                FROM
                                    (SELECT @r := ' . $listvalue['parent'] . ', @l := 0) vars,
                                    ' . $this->db->dbprefix('account') . ' m
                                WHERE @r <> 0) T1
                            JOIN ' . $this->db->dbprefix('account') . ' T2
                            ON T1._id = T2.id
                            ORDER BY T1.lvl DESC')->result_array();
            $parent_key = 0;
            foreach ($result_parent_tree as $parent_treekey => $parent_treevalue) {
                if ($parent_treekey == 0)
                    $parent_key = $parent_treevalue['id'];
                $result[$parent_key][$parent_treevalue['id']] = array('name' => $parent_treevalue['name']);
            }
            if ($listvalue['account_id'] != $parent_key)
                $result[$parent_key][$listvalue['account_id']] = $listvalue;
        }
        return $result;
    }

    public function get_general_ledger_search_found_rows($search, $filters) {
        $this->db->select("at.id,at.account_id,at.trans_type,at.trans_date,sum(IF(at.trans_type='credit',amount,0)) as credit,sum(IF(at.trans_type='debit',amount,0)) as debit,ac.name as account_name");
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('at.account_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function general_ledger_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select("at.id,at.account_id,at.trans_type,at.trans_date,sum(IF(at.trans_type='credit',amount,0)) as credit,sum(IF(at.trans_type='debit',amount,0)) as debit,ac.name as account_name");
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('at.account_id');
        if (empty($sort)) {
            $this->db->order_by('ac.name', 'ASC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function getledgerDataColumns() {
        return array(
            array('trans_date' => $this->lang->line('account_date')),
            array('account_name' => $this->lang->line('account_name')),
            array('employeename' => $this->lang->line('account_employeename')),
            array('location_name' => $this->lang->line('account_location_name')),
            array('reference' => $this->lang->line('account_reference')),
            array('debitamount' => $this->lang->line('account_debit')),
            array('creditamount' => $this->lang->line('account_credit')));
    }

    public function viewledger($filters) {
        $this->db->select('at.id,at.trans_type,at.trans_date,at.reference,at.amount as creditamount,at.amount as debitamount,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,ac.name as account_name,sl.location_name');
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->join('people as cp', 'at.employee_id = cp.person_id');
        $this->db->join('stock_locations as sl', 'at.location_id = sl.location_id', 'LEFT');
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (!empty($filters['account_id'])) {
            $this->db->where('at.account_id', $filters['account_id']);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
            return array();
        } else {
            return array();
        }
    }

}

?>