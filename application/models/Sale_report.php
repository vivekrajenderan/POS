<?php

class Sale_report extends CI_Model {
    /*
      Gets rows
     */

    public function get_sale_customer_found_rows($search, $filters) {
        $this->db->select('count(sl.customer_id) as invoice_count,SUM(it.item_tax_amount) as item_tax_amount,SUM(sp.payment_amount) as payment_amount,CONCAT(cp.first_name, " ", cp.last_name) AS customername');
        $this->db->from('sales as sl');
        $this->db->join('people as cp', 'sl.customer_id = cp.person_id');
        $this->db->join('sales_items_taxes as it', 'sl.sale_id = it.sale_id');
        $this->db->join('sales_payments as sp', 'sl.sale_id = sp.sale_id');
        $this->db->group_start();
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('it.item_tax_amount', $search);
        $this->db->or_like('sp.payment_amount', $search);
        $this->db->or_like('sl.sale_time', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('sl.customer_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function sale_customer_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sl.sale_id', $order = 'asc') {
        $this->db->select('count(sl.customer_id) as invoice_count,SUM(it.item_tax_amount) as item_tax_amount,SUM(sp.payment_amount) as payment_amount,CONCAT(cp.first_name, " ", cp.last_name) AS customername');
        $this->db->from('sales as sl');
        $this->db->join('people as cp', 'sl.customer_id = cp.person_id');
        $this->db->join('sales_items_taxes as it', 'sl.sale_id = it.sale_id');
        $this->db->join('sales_payments as sp', 'sl.sale_id = sp.sale_id');
        $this->db->group_start();
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('it.item_tax_amount', $search);
        $this->db->or_like('sp.payment_amount', $search);
        $this->db->or_like('sl.sale_time', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('sl.customer_id');
        if (empty($sort)) {
            $this->db->order_by('sl.sale_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    public function get_sale_item_found_rows($search, $filters) {
        $this->db->select('count(si.item_id) as quantity_sold,SUM(si.item_unit_price-(si.item_unit_price /100 * si.discount_percent)) AS average_price,it.name as item_name');
        $this->db->from('sales as sl');
        $this->db->join('sales_items as si', 'sl.sale_id = si.sale_id');
        $this->db->join('items as it', 'si.item_id = it.item_id');
        $this->db->group_start();
        $this->db->or_like('it.name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('si.item_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function sale_item_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sl.sale_id', $order = 'asc') {
        $this->db->select('count(si.item_id) as quantity_sold,SUM(si.item_unit_price-(si.item_unit_price /100 * si.discount_percent)) AS average_price,it.name as item_name');
        $this->db->from('sales as sl');
        $this->db->join('sales_items as si', 'sl.sale_id = si.sale_id');
        $this->db->join('items as it', 'si.item_id = it.item_id');
        $this->db->group_start();
        $this->db->or_like('it.name', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('si.item_id');
        if (empty($sort)) {
            $this->db->order_by('sl.sale_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    public function get_sale_person_found_rows($search, $filters) {
        $this->db->select('count(sl.employee_id) as invoice_count,SUM(it.item_tax_amount) as item_tax_amount,SUM(sp.payment_amount) as payment_amount,CONCAT(cp.first_name, " ", cp.last_name) AS personname');
        $this->db->from('sales as sl');
        $this->db->join('people as cp', 'sl.employee_id = cp.person_id');
        $this->db->join('sales_items_taxes as it', 'sl.sale_id = it.sale_id');
        $this->db->join('sales_payments as sp', 'sl.sale_id = sp.sale_id');
        $this->db->group_start();
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('it.item_tax_amount', $search);
        $this->db->or_like('sp.payment_amount', $search);
        $this->db->or_like('sl.sale_time', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('sl.employee_id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function sale_person_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sl.sale_id', $order = 'asc') {
        $this->db->select('count(sl.employee_id) as invoice_count,SUM(it.item_tax_amount) as item_tax_amount,SUM(sp.payment_amount) as payment_amount,CONCAT(cp.first_name, " ", cp.last_name) AS personname');
        $this->db->from('sales as sl');
        $this->db->join('people as cp', 'sl.employee_id = cp.person_id');
        $this->db->join('sales_items_taxes as it', 'sl.sale_id = it.sale_id');
        $this->db->join('sales_payments as sp', 'sl.sale_id = sp.sale_id');
        $this->db->group_start();
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('it.item_tax_amount', $search);
        $this->db->or_like('sp.payment_amount', $search);
        $this->db->or_like('sl.sale_time', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(sl.sale_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('sl.sale_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->group_by('sl.employee_id');
        if (empty($sort)) {
            $this->db->order_by('sl.sale_time', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

}

?>
