<?php

require_once("reports/Summary_report.php");

class Tax extends Summary_report {
    /*
      Determines if a given tax_code is on file
     */

    public function exists($tax_code) {
        $this->db->from('tax_codes');
        $this->db->where('tax_code', $tax_code);

        return ($this->db->get()->num_rows() == 1);
    }

    public function tax_rate_exists($tax_code, $tax_category_id) {
        $this->db->from('tax_code_rates');
        $this->db->where('rate_tax_code', $tax_code);
        $this->db->where('rate_tax_category_id', $tax_category_id);

        return ($this->db->get()->num_rows() == 1);
    }

    /*
      Gets total of rows
     */

    public function get_total_rows() {
        $this->db->from('tax_codes');

        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular tax_code
     */

    public function get_info($tax_code) {
        $this->db->from('tax_codes');
        $this->db->join('tax_code_rates', 'tax_code = rate_tax_code and rate_tax_category_id = 0', 'LEFT');
        $this->db->join('tax_categories', 'rate_tax_category_id = tax_category_id');
        $this->db->where('tax_code', $tax_code);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object
            $tax_code_obj = new stdClass();

            //Get all the fields from tax_codes table
            foreach ($this->db->list_fields('tax_codes') as $field) {
                $tax_code_obj->$field = '';
            }
            foreach ($this->db->list_fields('tax_code_rates') as $field) {
                $tax_code_obj->$field = '';
            }

            return $tax_code_obj;
        }
    }

    /*
      Gets information about a particular tax_code
     */

    public function get_rate_info($tax_code, $tax_category_id) {
        $this->db->from('tax_code_rates');
        $this->db->join('tax_categories', 'rate_tax_category_id = tax_category_id');
        $this->db->where('rate_tax_code', $tax_code);
        $this->db->where('rate_tax_category_id', $tax_category_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object
            $tax_rate_obj = new stdClass();

            //Get all the fields from tax_codes table
            foreach ($this->db->list_fields('tax_code_rates') as $field) {
                $tax_rate_obj->$field = '';
            }
            //Get all the fields from tax_code_rates table
            foreach ($this->db->list_fields('tax_categories') as $field) {
                $tax_rate_obj->$field = '';
            }

            return $tax_rate_obj;
        }
    }

    /*
     * Gets the tax code to use for a given customer
     */

    public function get_sales_tax_code($city = '', $state = '') {
        // if tax code using both city and state cannot be found then  try again using just the state
        // if the state tax code cannot be found then try again using blanks for both
        $this->db->from('tax_codes');
        $this->db->where('city', $city);
        $this->db->where('state', $state);
        $this->db->where('tax_code_type', '0'); // sales tax

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row()->tax_code;
        } else {
            $this->db->from('tax_codes');
            $this->db->where('city', '');
            $this->db->where('state', $state);
            $this->db->where('tax_code_type', '0'); // sales tax

            $query = $this->db->get();

            if ($query->num_rows() == 1) {
                return $query->row()->tax_code;
            } else {
                return $this->config->item('default_origin_tax_code');
            }
        }

        return FALSE;
    }

    /*
      Inserts or updates a tax_codes entry
     */

    public function save(&$tax_code_data, $tax_rate_data, $tax_code = -1) {
        if (!$this->exists($tax_code)) {
            if ($this->db->insert('tax_codes', $tax_code_data)) {
                $this->save_tax_rates($tax_rate_data, $tax_code);
                return TRUE;
            }

            return FALSE;
        }

        $this->db->where('tax_code', $tax_code);
        if ($this->db->update('tax_codes', $tax_code_data)) {
            $this->save_tax_rates($tax_rate_data, $tax_code);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function save_tax_rates(&$tax_rate_data, $tax_code) {
        if (!$this->tax_rate_exists($tax_code, $tax_rate_data['rate_tax_category_id'])) {
            if ($this->db->insert('tax_code_rates', $tax_rate_data)) {
                return TRUE;
            }

            return FALSE;
        }

        $this->db->where('rate_tax_code', $tax_code);
        $this->db->where('rate_tax_category_id', $tax_rate_data['rate_tax_category_id']);

        return $this->db->update('tax_code_rates', $tax_rate_data);
    }

    /*
      Inserts or updates an item kit's items
     */

    public function save_tax_rate_exceptions(&$tax_rate_data, $tax_code) {
        $success = TRUE;

        //Run these queries as a transaction, we want to make sure we do all or nothing

        $this->db->trans_start();

        // Delete all exceptions for the given tax_code
        $this->delete_tax_rate_exceptions($tax_code);

        if ($tax_rate_data != NULL) {
            foreach ($tax_rate_data as $row) {
                $row['rate_tax_code'] = $tax_code;
                $success &= $this->db->insert('tax_code_rates', $row);
            }
        }

        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    /*
      Deletes one tax_codes entry
     */

    public function delete($tax_code) {
        return $this->db->delete('tax_codes', array('tax_code' => $tax_code));
    }

    /*
      Deletes a list of tax codes
     */

    public function delete_list($tax_codes) {
        $this->db->where_in('tax_code', $tax_codes);

        return $this->db->delete('tax_codes');
    }

    /*
      Deletes all tax_rate_exceptions for given tax codes
     */

    public function delete_tax_rate_exceptions($tax_code) {
        $this->db->where('rate_tax_code', $tax_code);
        $this->db->where('rate_tax_category_id !=', 0);

        return $this->db->delete('tax_code_rates');
    }

    /*
      Performs a search on tax_codes
     */

    public function search($search, $rows = 0, $limit_from = 0, $sort = 'tax_code', $order = 'asc') {
        $this->db->from('tax_codes');
        $this->db->join('tax_code_rates', 'tax_code = rate_tax_code and rate_tax_category_id = 0', 'LEFT');
        if (!empty($search)) {
            $this->db->like('tax_code', $search);
            $this->db->or_like('tax_code_name', $search);
        }
        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    /*
      Gets tax_codes
     */

    public function get_found_rows($search) {
        $this->db->from('tax_codes');
        if (!empty($search)) {
            $this->db->like('tax_code', $search);
            $this->db->or_like('tax_code_name', $search);
        }

        return $this->db->get()->num_rows();
    }

    public function get_tax_code_type_name($tax_code_type) {
        if ($tax_code_type == '0') {
            return $this->lang->line('taxes_sales_tax');
        } else {
            return $this->lang->line('taxes_vat_tax');
        }
    }

    public function get_sales_tax_codes_search_suggestions($search, $limit = 25) {

        $suggestions = array();

        $this->db->from('tax_codes');
        if (!empty($search)) {
            $this->db->like('tax_code', $search);
            $this->db->or_like('tax_code_name', $search);
        }
        $this->db->order_by('tax_code_name', 'asc');

        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->tax_code, 'label' => ($row->tax_code . ' ' . $row->tax_code_name));
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    public function get_tax_category_suggestions($search) {
        $suggestions = array();

        $this->db->from('tax_categories');
        $this->db->where('tax_category_id !=', 0);
        if (!empty($search)) {
            $this->db->like('tax_category', '%' . $search . '%');
        }
        $this->db->order_by('tax_category', 'asc');

        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->tax_category_id, 'label' => $row->tax_category);
        }

        return $suggestions;
    }

    public function get_tax_category($tax_category_id) {
        $this->db->select('tax_category');
        $this->db->from('tax_categories');
        $this->db->where('tax_category_id', $tax_category_id);

        return $this->db->get()->row()->tax_category;
    }

    public function get_all_tax_categories() {
        $this->db->from('tax_categories');
        $this->db->order_by('tax_category_id');

        return $this->db->get();
    }

    public function get_tax_category_id($tax_category) {
        $this->db->select('tax_category_id');
        $this->db->from('tax_categories');

        return $this->db->get()->row()->tax_category_id;
    }

    public function get_tax_code_rate_exceptions($tax_code) {
        $this->db->from('tax_code_rates');
        $this->db->join('tax_categories', 'rate_tax_category_id = tax_category_id');
        $this->db->where('rate_tax_code', $tax_code);
        $this->db->where('rate_tax_category_id !=', 0);
        $this->db->order_by('tax_category', 'asc');

        return $this->db->get()->result_array();
    }

    protected function _get_data_columns() {
        return array(
            'summary' => array(
                array('tax_percent' => $this->lang->line('taxes_tax_percent'), 'sorter' => 'number_sorter'),
                array('report_count' => $this->lang->line('taxes_count')),
                array('subtotal' => $this->lang->line('taxes_subtotal'), 'sorter' => 'number_sorter'),
                array('tax' => $this->lang->line('taxes_tax'), 'sorter' => 'number_sorter'),
                array('total' => $this->lang->line('taxes_total'), 'sorter' => 'number_sorter')),
            'details' => array(
                $this->lang->line('taxes_tax_percent'),
                $this->lang->line('taxes_subtotal'),
                $this->lang->line('taxes_tax'),
                $this->lang->line('taxes_total')));
    }

    protected function _where(array $inputs) {
        if (isset($inputs['item_id']) && !empty($inputs['item_id'])) {
            $this->db->where('sales_items_taxes.item_id', $inputs['item_id']);
        }
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('sale_status = 0 AND DATE(sales.sale_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']));
        } else {
            $this->db->where('sale_status = 0 AND sales.sale_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date'])));
        }
    }

    public function getData(array $inputs) {
        $where = '';

        if (empty($this->config->item('date_or_time_format'))) {
            $where .= 'WHERE sale_status = 0 AND DATE(sale_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
        } else {
            $where .= 'WHERE sale_status = 0 AND sale_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
        }

        if ($this->config->item('tax_included')) {
            $sale_total = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100))';
            $sale_subtotal = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (100 / (100 + sales_items_taxes.percent)))';
            $sale_tax = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (1 - 100 / (100 + sales_items_taxes.percent)))';
        } else {
            $sale_total = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (1 + (sales_items_taxes.percent / 100)))';
            $sale_subtotal = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100))';
            $sale_tax = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (sales_items_taxes.percent / 100))';
        }

        $decimals = totals_decimals();

        $query = $this->db->query("SELECT item_id,percent, count(*) AS count, ROUND(SUM(subtotal), $decimals) AS subtotal, ROUND(SUM(tax), $decimals) AS tax, ROUND(SUM(total), $decimals) AS total
			FROM (
				SELECT sales_items.item_id,
					CONCAT(IFNULL(ROUND(percent, $decimals), 0), '%') AS percent,
					$sale_subtotal AS subtotal,
					IFNULL($sale_tax, 0) AS tax,
					IFNULL($sale_total, $sale_subtotal) AS total
					FROM " . $this->db->dbprefix('sales_items') . ' AS sales_items
					INNER JOIN ' . $this->db->dbprefix('sales') . ' AS sales
						ON sales_items.sale_id = sales.sale_id
					LEFT OUTER JOIN ' . $this->db->dbprefix('sales_items_taxes') . ' AS sales_items_taxes
						ON sales_items.sale_id = sales_items_taxes.sale_id AND sales_items.item_id = sales_items_taxes.item_id AND sales_items.line = sales_items_taxes.line
					' . $where . '
				) AS temp_taxes
			GROUP BY percent'
        );

        return $query->result_array();
    }

    public function getViewDataColumns() {
        return array(
            'summary' => array(
                array('tax_percent' => $this->lang->line('taxes_tax_percent'), 'sorter' => 'number_sorter'),
                array('subtotal' => $this->lang->line('taxes_subtotal'), 'sorter' => 'number_sorter'),
                array('tax' => $this->lang->line('taxes_tax'), 'sorter' => 'number_sorter'),
                array('total' => $this->lang->line('taxes_total'), 'sorter' => 'number_sorter')),
        );
    }

    public function getSingleData($item_id, array $inputs) {
        $where = '';

        if (empty($this->config->item('date_or_time_format'))) {
            $where .= 'WHERE sale_status = 0 AND DATE(sale_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
        } else {
            $where .= 'WHERE sale_status = 0 AND sale_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
        }
        if (!empty($item_id)) {
            $where.= "AND sales_items_taxes.item_id=" . $item_id;
        }

        if ($this->config->item('tax_included')) {
            $sale_total = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100))';
            $sale_subtotal = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (100 / (100 + sales_items_taxes.percent)))';
            $sale_tax = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (1 - 100 / (100 + sales_items_taxes.percent)))';
        } else {
            $sale_total = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (1 + (sales_items_taxes.percent / 100)))';
            $sale_subtotal = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100))';
            $sale_tax = '(sales_items.item_unit_price * sales_items.quantity_purchased * (1 - sales_items.discount_percent / 100) * (sales_items_taxes.percent / 100))';
        }

        $decimals = totals_decimals();

        $query = $this->db->query("SELECT percent, ROUND(subtotal, $decimals) AS subtotal, ROUND(tax, $decimals) AS tax, ROUND(total, $decimals) AS total
			FROM (
				SELECT
					CONCAT(IFNULL(ROUND(percent, $decimals), 0), '%') AS percent,
					$sale_subtotal AS subtotal,
					IFNULL($sale_tax, 0) AS tax,
					IFNULL($sale_total, $sale_subtotal) AS total
					FROM " . $this->db->dbprefix('sales_items') . ' AS sales_items
					INNER JOIN ' . $this->db->dbprefix('sales') . ' AS sales
						ON sales_items.sale_id = sales.sale_id
					LEFT OUTER JOIN ' . $this->db->dbprefix('sales_items_taxes') . ' AS sales_items_taxes
						ON sales_items.sale_id = sales_items_taxes.sale_id AND sales_items.item_id = sales_items_taxes.item_id AND sales_items.line = sales_items_taxes.line
					' . $where . '
				) AS temp_taxes
			'
        );

        return $query->result_array();
    }

}

?>
