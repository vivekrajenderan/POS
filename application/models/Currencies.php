<?php

class Currencies extends CI_Model {
    /*
      Inserts or updates a expense
     */

    public function save($currency_data, $currency_id = '') {
        if ($currency_id == '') {
            if ($this->db->insert('currency', $currency_data)) {
                $currency_id = $this->db->insert_id();
                $rate_data = array(
                    'currency_id' => $currency_id,
                    'employee_id' => $this->session->userdata('person_id'),
                    'rate' => $currency_data['rate'],
                    'note' => 'initial'
                );
                $this->db->insert('currency_rate', $rate_data);
                return $currency_id;
            }
            return FALSE;
        } else {
            $this->db->where('id', $currency_id);
            $this->db->update('currency', $currency_data);
            $rate_data = array(
                'currency_id' => $currency_id,
                'employee_id' => $this->session->userdata('person_id'),
                'rate' => $currency_data['rate'],
                'note' => 'initial'
            );
            $this->db->where('currency_id', $currency_id);
            $this->db->insert('currency_rate', $rate_data);
            return $currency_id;
        }
    }

    public function exists($where) {
        $this->db->from('currency');
        $i = 1;
        foreach ($where as $key => $value) {
            if ($i == 1)
                $this->db->like($key, $value);
            $this->db->or_like($key, $value);
            $i++;
        }
        return ($this->db->get()->num_rows() > 0);
    }

    public function updateexportdata($currency_data) {
        $this->db->select('*');
        $this->db->from('currency');
        $this->db->where('code', $currency_data['code']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            $update = $this->update_currency($currency_data, $results[0]['id']);
            return $update;
        } else {
            return false;
        }
    }

    public function update_currency($currency_data, $currency_id) {
        $updatecurrency = array('rate' => $currency_data['rate']);
        $this->db->where('id', $currency_id);
        $this->db->update('currency', $updatecurrency);
        $rate_data = array(
            'currency_id' => $currency_id,
            'employee_id' => $this->session->userdata('person_id'),
            'rate' => $currency_data['rate'],
            'date' => $currency_data['date']
        );
        $this->db->where('currency_id', $currency_id);
        $this->db->insert('currency_rate', $rate_data);
        return $currency_id;
    }

    public function currency_found_rows($search, $filters) {
        $this->db->select('currency.id,currency.name,currency.symbol,currency.base_currency,currency.code,currency.rate,currency_rate.date');
        $this->db->from('currency as currency');
        $this->db->join('currency_rate as currency_rate', 'currency.rate = currency_rate.rate');
        $this->db->group_start();
        $this->db->or_like('currency.name', $search);
        $this->db->or_like('currency.symbol', $search);
        $this->db->or_like('currency.code', $search);
        $this->db->or_like('currency.rate', $search);
        $this->db->or_like('currency_rate.date', $search);
        $this->db->group_end();

        $this->db->group_by('currency.id');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function currency_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'currency_rate.date', $order = 'asc') {
        $this->db->select('currency.id,currency.name,currency.symbol,currency.base_currency,currency.code,currency.rate,currency_rate.date');
        $this->db->from('currency as currency');
        $this->db->join('currency_rate as currency_rate', 'currency.rate = currency_rate.rate');
        $this->db->group_start();
        $this->db->or_like('currency.name', $search);
        $this->db->or_like('currency.symbol', $search);
        $this->db->or_like('currency.code', $search);
        $this->db->or_like('currency.rate', $search);
        $this->db->or_like('currency_rate.date', $search);
        $this->db->group_end();
        if (empty($sort)) {
            $this->db->order_by('currency_rate.date', 'DESC');
        } else {
            $this->db->order_by($sort, $order);
        }
        $this->db->group_by('currency.id');
        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    /*
      Performs a search on customers
     */

    public function getGrapData($inputs = array()) {
        $this->db->select('currency.name,currency_rate.rate,currency_rate.date,currency_rate.currency_id');
        $this->db->from('currency_rate as currency_rate');
        $this->db->join('currency as currency', 'currency.id = currency_rate.currency_id');
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where(' DATE(currency_rate.date) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
        } else {
            $this->db->where(' currency_rate.date BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
        }

        if (isset($inputs['currency_id'])) {
            $this->db->where('currency_rate.currency_id', $inputs['currency_id']);
        }

        $this->db->order_by('currency_rate.date');
        $this->db->group_by('currency_rate.date');
        return $this->db->get();
    }

    public function get_currency_list() {
        $currency_list = array();
        $this->db->select('*');
        $this->db->from('currency');
        $this->db->where('base_currency', '0');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rows = $query->result_array();
            foreach ($rows as $list) {
                $currency_list[$list['id']] = $list['name'];
            }
            return $currency_list;
        } else {
            return array();
        }
    }

    public function getCurrencyName($id = 1) {
        $this->db->select('name');
        $this->db->from('currency');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $rows = $query->row();
            return $rows->name;
        } else {
            return '';
        }
    }

}

?>
