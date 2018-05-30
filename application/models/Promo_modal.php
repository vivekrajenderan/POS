<?php

class Promo_modal extends CI_Model {
    /*
      Inserts or updates a expense
     */

    public function save($data) {
        $currency_id = (isset($data['id'])) ? $data['id'] : '';
        if ($currency_id == '') {
            foreach ($data['location_id'] as $locationkey => $locationvalue) {
                foreach ($data['item_id'] as $itemkey => $itemvalue) {
                    $insert_array = Array
                        (
                        "promo_name" => $data["promo_name"],
                        "fromdate" => $data["fromdate"],
                        "todate" => $data["todate"],
                        "promo_type" => $data["promo_type"],
                        "price" => $data["price"],
                        "location_id" => $locationvalue,
                        "item_id" => $itemvalue,
                        "status" => '0',
                        "date_time" => $data["date_time"],
                        "employee_id" => $data["employee_id"]
                    );
                    $this->db->insert('item_promo', $insert_array);
                }
            }
        } else {
            $this->db->where('id', $currency_id);
            $this->db->update('item_promo', $data);
        }
    }

    public function get_data($filter_data = array(), $list = false) {
        $this->db->select('item_promo.*,stock_locations.location_name,items.name as itemname');
        $this->db->from('item_promo as item_promo');
        $this->db->join('stock_locations as stock_locations', 'stock_locations.location_id = item_promo.location_id', 'left');
        $this->db->join('items as items', 'items.item_id = item_promo.item_id', 'left');
        $this->db->where('stock_locations.deleted', '0');
        $this->db->where('items.deleted', '0');

        if (!empty($filter_data))
            $this->db->where($filter_data);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            if (!$list)
                $results = $query->row_array();
            else
                $results = $query->result_array();

            return $results;
        } else {
            return false;
        }
    }

    public function promo_found_rows($search, $filters) {
        $this->db->select('item_promo.id');
        $this->db->from('item_promo as item_promo');
        $this->db->join('stock_locations as stock_locations', 'stock_locations.location_id = item_promo.location_id', 'left');
        $this->db->join('items as items', 'items.item_id = item_promo.item_id', 'left');
        $this->db->where('stock_locations.deleted', '0');
        $this->db->where('items.deleted', '0');
        $this->db->group_start();
        $this->db->or_like('item_promo.promo_name', $search);
        $this->db->or_like('item_promo.fromdate', $search);
        $this->db->or_like('item_promo.todate', $search);
        $this->db->or_like('stock_locations.location_name', $search);
        $this->db->or_like('items.name', $search);
        $this->db->or_like('item_promo.price', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on promo
     */

    public function promo_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'item_promo.todate', $order = 'asc') {
        $this->db->select('item_promo.id,item_promo.promo_name,item_promo.fromdate,item_promo.todate,stock_locations.location_name,items.name as itemname,item_promo.price,item_promo.promo_type');
        $this->db->from('item_promo as item_promo');
        $this->db->join('stock_locations as stock_locations', 'stock_locations.location_id = item_promo.location_id', 'left');
        $this->db->join('items as items', 'items.item_id = item_promo.item_id', 'left');
        $this->db->where('stock_locations.deleted', '0');
        $this->db->where('items.deleted', '0');
        $this->db->group_start();
        $this->db->or_like('item_promo.promo_name', $search);
        $this->db->or_like('item_promo.fromdate', $search);
        $this->db->or_like('item_promo.todate', $search);
        $this->db->or_like('stock_locations.location_name', $search);
        $this->db->or_like('items.name', $search);
        $this->db->or_like('item_promo.price', $search);
        $this->db->group_end();
        if (empty($sort)) {
            $this->db->order_by('item_promo.todate', 'DESC');
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
