<?php

class Contact_us extends CI_Model {

    public function save_contact($set_data) {
        $this->db->insert('contactus', $set_data);
        return ($this->db->affected_rows() > 0);
    }

    public function get_found_rows($search, $filters) {
        $this->db->select('*');
        $this->db->from('contactus');
        $this->db->group_start();
        $this->db->like('fullname', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('subject', $search);
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    public function search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'id', $order = 'asc') {
        $this->db->select('*');
        $this->db->from('contactus');
        $this->db->group_start();
        $this->db->like('fullname', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('subject', $search);
        $this->db->group_end();
        $this->db->order_by($sort, $order);
        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

}

?>
