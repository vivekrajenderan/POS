<?php

class Bills extends CI_Model {
    /*
      Gets rows
     */

    public function get_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $this->db->select('rc.receiving_id,'
                . 'rc.payment_ref,'
                . 'rc.receiving_ref,'
                . 'rc.receiving_time,'
                . 'sl.location_name,'
                . 'CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,'
                . 'SUM(ri.receiving_quantity) as receiving_quantity'
        );
        $this->db->from('receivings as rc');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('rc.payment_ref', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if ($filters['stock_locations']) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        }
        $this->db->where('rc.receiving_status', 'closed');
        $this->db->where('rc.receiving_mode', 'receive');
        $this->db->where('rc.payment_status !=""');
        $this->db->where_in('sl.location_id', $employee_ids_all);
        $this->db->group_by('rc.receiving_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $this->db->select('rc.receiving_id,rc.payment_ref,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,SUM(ri.receiving_quantity) as receiving_quantity,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('rc.payment_ref', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        $this->db->where_in('sl.location_id', $employee_ids_all);
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rc.receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rc.receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if ($filters['stock_locations']) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        }
        $this->db->where('rc.receiving_status', 'closed');
        $this->db->where('rc.receiving_mode', 'receive');
        $this->db->where('rc.payment_status !=""');
        $this->db->order_by($sort, $order);
        if ($sort == '') {
            $this->db->order_by('rc.receiving_id', 'desc');
        }

        $this->db->group_by('rc.receiving_id');

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_paylist_found_rows($search, $filters) {
        $this->db->select('rm.payment_date,rm.payment_reference,rm.payment_notes,rm.payment_type,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,SUM(rmr.amount) as amount');
        $this->db->from('recpayment_made as rm');
        $this->db->join('recpayment_made_receivings as rmr', 'rm.id = rmr.recpayment_made_id');
        $this->db->join('people as sp', 'rm.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rm.employee_id = cp.person_id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('rm.payment_reference', $search);
        $this->db->or_like('rm.payment_notes', $search);
        $this->db->or_like('rmr.amount', $search);
        $this->db->or_like('rm.payment_type', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if ($filters['payment_options']) {
            $this->db->where_in('rm.payment_type', $filters['payment_options']);
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function paylistsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rm.id', $order = 'asc') {
        $this->db->select('rm.payment_date,rm.payment_reference,rm.payment_notes,rm.payment_type,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename,SUM(rmr.amount*rm.currency_rate) as amount,currency.symbol');
        $this->db->from('recpayment_made as rm');
        $this->db->join('recpayment_made_receivings as rmr', 'rm.id = rmr.recpayment_made_id');
        $this->db->join('people as sp', 'rm.supplier_id = sp.person_id');
        $this->db->join('people as cp', 'rm.employee_id = cp.person_id');
        $this->db->join('currency as currency', 'currency.id = rm.currency_id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->or_like('rm.payment_reference', $search);
        $this->db->or_like('rm.payment_notes', $search);
        $this->db->or_like('rmr.amount', $search);
        $this->db->or_like('rm.payment_type', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if ($filters['payment_options']) {
            $this->db->where_in('rm.payment_type', $filters['payment_options']);
        }
        $this->db->group_by('rm.id');
        if ($sort == '') {
            $this->db->order_by('rm.id', 'desc');
        } else {
            $this->db->order_by($sort, $order);
        }


        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_paysupplierlist_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['stock_locations']) && !empty($filters['stock_locations'])) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        $this->db->where_in('rc.payment_status', $payment_status);

        $this->db->group_by('rc.supplier_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function paysupplierlistsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rm.id', $order = 'asc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['stock_locations']) && !empty($filters['stock_locations'])) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        $this->db->where_in('rc.payment_status', $payment_status);
        $this->db->group_by('rc.supplier_id');
        if ($sort == '') {
            $this->db->order_by('rm.id', 'desc');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_payitemlist_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,it.name as item_name,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('items as it', 'it.item_id = ri.item_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('it.name', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['stock_locations']) && !empty($filters['stock_locations'])) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        $this->db->where_in('rc.payment_status', $payment_status);
        $this->db->group_by('ri.item_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function payitemlistsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rm.id', $order = 'asc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,it.name as item_name,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('items as it', 'it.item_id = ri.item_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('it.name', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['stock_locations']) && !empty($filters['stock_locations'])) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        $this->db->where_in('rc.payment_status', $payment_status);

        $this->db->group_by('ri.item_id');
        if ($sort == '') {
            $this->db->order_by('rm.id', 'desc');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_paylocationlist_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where_in('rc.payment_status', $payment_status);
        $this->db->where_in('sl.location_id', $employee_ids_all);
        $this->db->group_by('ri.item_location');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function paylocationlistsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rm.id', $order = 'asc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $payment_status = array('paid', 'partially');
        $this->db->select('rm.payment_date,SUM(ri.item_cost_price*ri.receiving_quantity) as total_price,SUM(ri.receiving_quantity) as total_quantity,sl.location_name');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->join('recpayment_made as rm', 'rmr.recpayment_made_id = rm.id');
        $this->db->group_start();
        $this->db->or_like('rm.payment_date', $search);
        $this->db->or_like('ri.item_cost_price', $search);
        $this->db->or_like('ri.receiving_quantity', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(rm.payment_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('rm.payment_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where_in('rc.payment_status', $payment_status);
        $this->db->where_in('sl.location_id', $employee_ids_all);
        $this->db->group_by('ri.item_location');
        if ($sort == '') {
            $this->db->order_by('rm.id', 'desc');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_payorderhistory_found_rows($search, $filters) {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,sl.location_name,SUM(ri.request_quantity) as request_quantity,(SUM(ri.request_quantity) - SUM(ri.balance_quantity)) as total_received');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['stock_locations']) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
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
      Performs a search on Bill
     */

    public function payorderhistorysearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $employee_ids_all = $this->Stock_location->get_employee_ids_all('pay');
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,sl.location_name,SUM(ri.request_quantity) as request_quantity,(SUM(ri.request_quantity) - SUM(ri.balance_quantity)) as total_received');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('stock_locations as sl', 'ri.item_location = sl.location_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rc.receiving_ref', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('sl.location_name', $search);
        $this->db->group_end();
        if ($filters['receiving_status']) {
            $this->db->where_in('rc.receiving_status', $filters['receiving_status']);
        }
        if ($filters['stock_locations']) {
            $this->db->where_in('sl.location_id', $filters['stock_locations']);
        } else {
            $this->db->where_in('sl.location_id', $employee_ids_all);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'po');
        $this->db->group_by('rc.receiving_id');
        if ($sort == '') {
            $this->db->order_by('rc.receiving_id', 'desc');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function get_paysupplierbalance_found_rows($search, $filters) {
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,SUM(ri.receiving_quantity*ri.item_cost_price) as bill_amount,SUM(rmr.amount) as paid_amount,(SUM(ri.receiving_quantity*ri.item_cost_price) - SUM(rmr.amount)) as balance_amount');
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rmr.amount', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'receive');
        $this->db->where('rc.receiving_status', 'closed');
        $this->db->group_by('rc.supplier_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on Bill
     */

    public function paysupplierbalancesearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select('rc.receiving_id,rc.receiving_status,rc.receiving_ref,rc.receiving_time,'
                . 'CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,'
                . 'SUM(ri.receiving_quantity*ri.item_cost_price) as bill_amount,SUM(rmr.amount) as paid_amount,'
                . '(SUM(ri.receiving_quantity*ri.item_cost_price) - SUM(rmr.amount)) as balance_amount'
        );
        $this->db->from('receivings as rc');
        $this->db->join('receivings_items as ri', 'rc.receiving_id = ri.receiving_id');
        $this->db->join('people as sp', 'rc.supplier_id = sp.person_id');
        $this->db->join('recpayment_made_receivings as rmr', 'rc.receiving_id = rmr.receivings_id');
        $this->db->group_start();
        $this->db->or_like('rc.receiving_id', $search);
        $this->db->like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('rc.receiving_time', $search);
        $this->db->or_like('rc.receiving_status', $search);
        $this->db->or_like('rmr.amount', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(receiving_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('receiving_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->where('rc.receiving_mode', 'receive');
        $this->db->where('rc.receiving_status', 'closed');
        $this->db->group_by('rc.supplier_id');

        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function getCurrencyDropdown($condition = array()) {
        $this->db->select('concat(name," (",symbol,") ") as curr, id');
        if (!empty($condition))
            $this->db->where($condition);
        $re = $this->db->get('currency')->result_array();
        $result = array();
        foreach ($re as $key => $value) {
            $result[$value['id']] = $value['curr'];
        }
        return $result;
    }

    public function getCurrency($condition = array()) {
        $this->db->select('currency_rate.rate,currency_rate.id as rateid,currency_id,symbol ');
        $this->db->from('currency_rate as currency_rate');
        $this->db->join('currency as currency', 'currency_rate.currency_id = currency.id', 'left');
        if (!empty($condition))
            $this->db->where($condition);
        $this->db->order_by("date", "desc");
        $this->db->limit(1);
        $re = $this->db->get()->row_array();
        return $re;
    }

}

?>
