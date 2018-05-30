<?php

class Auditing extends CI_Model {
    /*
      Gets rows
     */

    public function get_found_rows($search, $filters) {
        $this->db->select('a.audit_trail_id,a.ref_text,a.action,a.date_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename');
        $this->db->from('audit_trail as a');
        $this->db->join('people as cp', 'a.employee_id = cp.person_id', 'left');
        $this->db->join('people as sp', 'a.ref_to = sp.person_id', 'left');
        $this->db->group_start();
        $this->db->or_like('a.ref_text', $search);
        $this->db->or_like('a.action', $search);
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('a.date_time', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(a.date_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('a.date_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'a.date_time', $order = 'DESC') {
        $this->db->select('a.audit_trail_id,a.ref_text,a.action,a.date_time,CONCAT(sp.first_name, " ", sp.last_name) AS suppliername,CONCAT(cp.first_name, " ", cp.last_name) AS employeename');
        $this->db->from('audit_trail as a');
        $this->db->join('people as cp', 'a.employee_id = cp.person_id', 'left');
        $this->db->join('people as sp', 'a.ref_to = sp.person_id', 'left');
        $this->db->group_start();
        $this->db->or_like('a.ref_text', $search);
        $this->db->or_like('a.action', $search);
        $this->db->or_like('sp.first_name', $search);
        $this->db->or_like('sp.last_name', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('a.date_time', $search);
        $this->db->or_like('CONCAT(sp.first_name, " ", sp.last_name)', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(a.date_time, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('a.date_time BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        if (!empty($sort)) {
            $this->db->order_by($sort, $order);
        } else {
            $this->db->order_by('a.date_time', 'DESC');
        }
        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

}

?>
