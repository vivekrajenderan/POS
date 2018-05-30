<?php

class Expense extends CI_Model {
    /*
      Inserts or updates a expense
     */

    public function save($item_data, $item_id = '') {
        if ($item_id == '') {
            if ($this->db->insert('expenses', $item_data)) {
                $item_data['item_id'] = $this->db->insert_id();
                $account_trans_data = array(
                    'amount' => ($item_data['tax_available'] == '1') ? ($item_data['amount'] * $item_data['tax_amount']) : $item_data['amount'],
                    'account_id' => $item_data['from_account'],
                    'reference' => $this->lang->line('expenses_account'),
                    'reference_type' => 'expenses',
                    'reference_table' => 'expenses',
                    'reference_id' => $item_data['item_id'],
                    'location_id' => 0,
                    'trans_type' => 'credit'
                );
                $this->Account->insert_trans($account_trans_data);

                $account_trans_data = array(
                    'amount' => ($item_data['tax_available'] == '1') ? ($item_data['amount'] * $item_data['tax_amount']) : $item_data['amount'],
                    'account_id' => $item_data['to_account'],
                    'reference' => $this->lang->line('expenses_account'),
                    'reference_type' => 'expenses',
                    'reference_table' => 'expenses',
                    'reference_id' => $item_data['item_id'],
                    'location_id' => 0,
                    'trans_type' => 'debit'
                );
                $this->Account->insert_trans($account_trans_data);
                return TRUE;
            }
            return FALSE;
        } else {
            $this->db->where('id', $item_id);
            return $this->db->update('expenses', $item_data);
        }
    }

    /*
      Inserts or updates a income
     */

    public function save_income($item_data, $item_id = '') {
        if ($item_id == '') {
            if ($this->db->insert('income', $item_data)) {
                $item_data['item_id'] = $this->db->insert_id();
                $account_trans_data = array(
                    'amount' => ($item_data['tax_available'] == '1') ? ($item_data['amount'] * $item_data['tax_amount']) : $item_data['amount'],
                    'account_id' => $item_data['from_account'],
                    'reference' => $this->lang->line('otherincome_account'),
                    'reference_type' => 'income',
                    'reference_table' => 'income',
                    'reference_id' => $item_data['item_id'],
                    'location_id' => 0,
                    'trans_type' => 'credit'
                );
                $this->Account->insert_trans($account_trans_data);

                $account_trans_data = array(
                    'amount' => ($item_data['tax_available'] == '1') ? ($item_data['amount'] * $item_data['tax_amount']) : $item_data['amount'],
                    'account_id' => $item_data['to_account'],
                    'reference' => $this->lang->line('otherincome_account'),
                    'reference_type' => 'income',
                    'reference_table' => 'income',
                    'reference_id' => $item_data['item_id'],
                    'location_id' => 0,
                    'trans_type' => 'debit'
                );
                $this->Account->insert_trans($account_trans_data);
                return TRUE;
            }
            return FALSE;
        } else {
            $this->db->where('id', $item_id);
            return $this->db->update('otherincome', $item_data);
        }
    }

    public function expense_details_found_rows($search, $filters) {
        $this->db->select('ep.status,ep.expense_date,ep.currency_rate,(ep.amount*ep.currency_rate),ep.reference,(ep.amount*ep.tax_amount*ep.currency_rate) as amountax,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,ac.name as account_name,cr.symbol');
        $this->db->from('expenses as ep');
        $this->db->join('people as sp', 'ep.supplier_id = sp.person_id');
        $this->db->join('account as ac', 'ep.from_account = ac.id');
         $this->db->join('currency as cr', 'cr.id = ep.currency_id');
        $this->db->group_start();
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('ep.status', $search);
        $this->db->or_like('ep.expense_date', $search);
        $this->db->or_like('ep.amount', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('cr.symbol', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(ep.expense_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('ep.expense_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['supplier_list']) && $filters['supplier_list'] != 'all') {
            $this->db->where('ep.supplier_id', $filters['supplier_list']);
        }
        if (isset($filters['fromaccount_list']) && $filters['fromaccount_list'] != 'all') {
            $this->db->where('ep.from_account', $filters['fromaccount_list']);
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function expense_details_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sl.sale_id', $order = 'asc') {
        $this->db->select('ep.status,ep.expense_date,ep.currency_rate,(ep.amount*ep.currency_rate) as amount,ep.reference,(ep.amount*ep.tax_amount*ep.currency_rate) as amountax,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,ac.name as account_name,cr.symbol');
        $this->db->from('expenses as ep');
        $this->db->join('people as sp', 'ep.supplier_id = sp.person_id');
        $this->db->join('account as ac', 'ep.from_account = ac.id');
        $this->db->join('currency as cr', 'cr.id = ep.currency_id');
        $this->db->group_start();
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('ep.status', $search);
        $this->db->or_like('ep.reference', $search);
        $this->db->or_like('ep.expense_date', $search);
        $this->db->or_like('ep.amount', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('cr.symbol', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(ep.expense_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('ep.expense_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['supplier_list']) && $filters['supplier_list'] != 'all') {
            $this->db->where('ep.supplier_id', $filters['supplier_list']);
        }
        if (isset($filters['fromaccount_list']) && $filters['fromaccount_list'] != 'all') {
            $this->db->where('ep.from_account', $filters['fromaccount_list']);
        }
        if (empty($sort)) {
            $this->db->order_by('ep.expense_date', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    public function income_details_found_rows($search, $filters) {
        $this->db->select('ic.status,ic.income_date,ic.currency_rate,(ic.amount*ic.currency_rate) as amount,ic.reference,(ic.amount*ic.tax_amount*ic.currency_rate) as amountax,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,ac.name as account_name,cr.symbol');
        $this->db->from('income as ic');
        $this->db->join('people as sp', 'ic.people_id = sp.person_id');
        $this->db->join('account as ac', 'ic.from_account = ac.id');
        $this->db->join('currency as cr', 'cr.id = ic.currency_id');
        $this->db->group_start();
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('ic.status', $search);
        $this->db->or_like('ic.reference', $search);
        $this->db->or_like('ic.income_date', $search);
        $this->db->or_like('ic.amount', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('cr.symbol', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(ic.income_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('ic.income_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['supplier_list']) && $filters['supplier_list'] != 'all') {
            $this->db->where('ic.people_id', $filters['supplier_list']);
        }
        if (isset($filters['fromaccount_list']) && $filters['fromaccount_list'] != 'all') {
            $this->db->where('ic.from_account', $filters['fromaccount_list']);
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function income_details_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'sl.sale_id', $order = 'asc') {
        $this->db->select('ic.status,ic.income_date,ic.currency_rate,(ic.amount*ic.currency_rate) as amount,ic.reference,(ic.amount*ic.tax_amount*ic.currency_rate) as amountax,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,ac.name as account_name,cr.symbol');
        $this->db->from('income as ic');
        $this->db->join('people as sp', 'ic.people_id = sp.person_id');
        $this->db->join('account as ac', 'ic.from_account = ac.id');
        $this->db->join('currency as cr', 'cr.id = ic.currency_id');
        $this->db->group_start();
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('ic.status', $search);
        $this->db->or_like('ic.reference', $search);
        $this->db->or_like('ic.income_date', $search);
        $this->db->or_like('ic.amount', $search);
        $this->db->or_like('ac.name', $search);
        $this->db->or_like('cr.symbol', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(ic.income_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('ic.income_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (isset($filters['supplier_list']) && $filters['supplier_list'] != 'all') {
            $this->db->where('ic.people_id', $filters['supplier_list']);
        }
        if (isset($filters['fromaccount_list']) && $filters['fromaccount_list'] != 'all') {
            $this->db->where('ic.from_account', $filters['fromaccount_list']);
        }
        if (empty($sort)) {
            $this->db->order_by('ic.income_date', 'DESC');
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
