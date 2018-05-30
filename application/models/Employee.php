<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Employee class
 *
 * @link    github.com/jekkos/opensourcepos
 * @since   1.0
 * @author  N/A
 */
class Employee extends Person {
    /*
      Determines if a given person_id is an employee
     */

    public function exists($person_id) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('employees.person_id', $person_id);

        return ($this->db->get()->num_rows() == 1);
    }

    /*
      Gets total of rows
     */

    public function get_total_rows() {
        $this->db->from('employees');
        $this->db->where('deleted', 0);

        return $this->db->count_all_results();
    }

    /*
      Returns all the employees
     */

    public function get_all($limit = 10000, $offset = 0) {
        $this->db->from('employees');
        $this->db->where('deleted', 0);
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->order_by('last_name', 'asc');
        $this->db->limit($limit);
        $this->db->offset($offset);

        return $this->db->get();
    }

    /*
      Returns  get account data
     */

    public function get_account_data($data = array()) {
        $account = array('data' => $this->Account->get_info($data->account_id), 'id' => $data->account_id);
        return $account;
    }

    /*
      Gets information about a particular employee
     */

    public function get_info($employee_id) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('employees.person_id', $employee_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $employee_id is NOT an employee
            $person_obj = parent::get_info(-1);

            //Get all the fields from employee table
            //append those fields to base parent object, we we have a complete empty object
            foreach ($this->db->list_fields('employees') as $field) {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Gets information about multiple employees
     */

    public function get_multiple_info($employee_ids) {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where_in('employees.person_id', $employee_ids);
        $this->db->order_by('last_name', 'asc');

        return $this->db->get();
    }

    /*
      Inserts or updates an employee
     */

    public function save_employee(&$person_data, &$employee_data, $employee_id = FALSE) {
        $success = FALSE;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        if (parent::save($person_data, $employee_id)) {
            if (!$employee_id || !$this->exists($employee_id)) {
                $employee_data['person_id'] = $employee_id = $person_data['person_id'];
                $success = $this->db->insert('employees', $employee_data);
            } else {
                $this->db->where('person_id', $employee_id);
                $success = $this->db->update('employees', $employee_data);
            }

            //We have either inserted or updated a new employee, now lets set permissions. 
            /* if ($success) {
              //First lets clear out any grants the employee currently has.
              $success = $this->db->delete('grants', array('person_id' => $employee_id));

              //Now insert the new grants
              if ($success) {
              foreach ($grants_data as $permission_id) {
              $success = $this->db->insert('grants', array('permission_id' => $permission_id, 'person_id' => $employee_id));
              }
              }
              } */
        }

        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    /*
      Deletes one employee
     */

    public function delete($employee_id) {
        $success = FALSE;

        //Don't let employees delete theirself
        if ($employee_id == $this->get_logged_in_employee_info()->person_id) {
            return FALSE;
        }

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        //Delete permissions
        if ($this->db->delete('grants', array('person_id' => $employee_id))) {
            $this->db->where('person_id', $employee_id);
            $success = $this->db->update('employees', array('deleted' => 1));
        }

        $this->db->trans_complete();

        return $success;
    }

    /*
      Deletes a list of employees
     */

    public function delete_list($employee_ids) {
        $success = FALSE;

        //Don't let employees delete theirself
        if (in_array($this->get_logged_in_employee_info()->person_id, $employee_ids)) {
            return FALSE;
        }

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->where_in('person_id', $employee_ids);
        //Delete permissions
        if ($this->db->delete('grants')) {
            //delete from employee table
            $this->db->where_in('person_id', $employee_ids);
            $success = $this->db->update('employees', array('deleted' => 1));
        }

        $this->db->trans_complete();

        return $success;
    }

    /*
      Get search suggestions to find employees
     */

    public function get_search_suggestions($search, $limit = 5) {
        $suggestions = array();

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->group_start();
        $this->db->like('first_name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->or_like('CONCAT(first_name, " ", last_name)', $search);
        $this->db->group_end();
        $this->db->where('deleted', 0);
        $this->db->order_by('last_name', 'asc');
        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->first_name . ' ' . $row->last_name);
        }

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like('email', $search);
        $this->db->order_by('email', 'asc');
        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->email);
        }

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like('username', $search);
        $this->db->order_by('username', 'asc');
        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->username);
        }

        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like('phone_number', $search);
        $this->db->order_by('phone_number', 'asc');
        foreach ($this->db->get()->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;
    }

    /*
      Gets rows
     */

    public function get_found_rows($search) {
        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->group_start();
        $this->db->like('first_name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone_number', $search);
        $this->db->or_like('username', $search);
        $this->db->or_like('CONCAT(first_name, " ", last_name)', $search);
        $this->db->group_end();
        $this->db->where('deleted', 0);

        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on employees
     */

    public function search($search, $rows = 0, $limit_from = 0, $sort = 'last_name', $order = 'asc') {
        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->group_start();
        $this->db->like('first_name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone_number', $search);
        $this->db->or_like('username', $search);
        $this->db->or_like('CONCAT(first_name, " ", last_name)', $search);
        $this->db->group_end();
        $this->db->where('deleted', 0);
        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }

        return $this->db->get();
    }

    /*
      Attempts to login employee and set session. Returns boolean based on outcome.
     */

    public function login($username, $password) {
        $query = $this->db->get_where('employees', array('username' => $username, 'deleted' => 0), 1);

        if ($query->num_rows() == 1) {
            $row = $query->row();

            // compare passwords depending on the hash version
            if ($row->hash_version == 1 && $row->password == md5($password)) {
                $this->db->where('person_id', $row->person_id);
                $this->session->set_userdata('person_id', $row->person_id);
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                return $this->db->update('employees', array('hash_version' => 2, 'password' => $password_hash));
            } elseif ($row->hash_version == 2 && password_verify($password, $row->password)) {
                $this->session->set_userdata('person_id', $row->person_id);
                $this->session->set_userdata('employees_login', $row->employees_login);
                $this->session->set_userdata('language_code', $row->language_code);

                return TRUE;
            }
        }

        return FALSE;
    }

    /*
      Logs out a user by destorying all session data and redirect to login
     */

    public function logout() {
        $this->session->sess_destroy();

        redirect('login');
    }

    /*
      Determins if a employee is logged in
     */

    public function is_logged_in() {
        return ($this->session->userdata('person_id') != FALSE);
    }

    public function is_headoffice_in() {
        return ($this->session->userdata('employees_login') == 'headoffice');
    }

    /*
      Gets information about the currently logged in employee.
     */

    public function get_logged_in_employee_info() {
        if ($this->is_logged_in()) {
            return $this->get_info($this->session->userdata('person_id'));
        }

        return FALSE;
    }

    /*
      Determines whether the employee has access to at least one submodule
     */

    public function has_module_grant($permission_id, $person_id) {
        $this->db->from('grants');
        $this->db->like('permission_id', $permission_id, 'after');
        $this->db->where('person_id', $person_id);
//        $this->db->join('employees_role', 'employees_role.id  = grants.person_id', 'left');
//        $this->db->join('employees', 'employees.role_id = employees_role.id', 'left');
//        $this->db->where('employees.person_id', $person_id);
        $result_count = $this->db->get()->num_rows();
        //pre($result_count);
        if ($result_count != 1) {
            return ($result_count != 0);
        }

        return $this->has_subpermissions($permission_id);
    }

    /*
      Checks permissions
     */

    public function has_subpermissions($permission_id) {
        $this->db->from('permissions');
        $this->db->like('permission_id', $permission_id . '_', 'after');

        return ($this->db->get()->num_rows() == 0);
    }

    /*
      Determines whether the employee specified employee has access the specific module.
     */

    public function has_grant($permission_id, $person_id) {
        //if no module_id is null, allow access
        if ($permission_id == NULL) {
            return TRUE;
        }

        $query = $this->db->get_where('grants', array('person_id' => $person_id, 'permission_id' => $permission_id), 1);

        return ($query->num_rows() == 1);
    }

    /*
      Gets employee permission grants
     */

    public function get_employee_grants($person_id) {
        $this->db->from('grants');
        $this->db->where('person_id', $person_id);

        return $this->db->get()->result_array();
    }

    /*
      Attempts to login employee and set session. Returns boolean based on outcome.
     */

    public function check_password($username, $password) {
        $query = $this->db->get_where('employees', array('username' => $username, 'deleted' => 0), 1);

        if ($query->num_rows() == 1) {
            $row = $query->row();

            // compare passwords
            if (password_verify($password, $row->password)) {
                return TRUE;
            }
        }

        return FALSE;
    }

    /*
      Change password for the employee
     */

    public function change_password($employee_data, $employee_id = FALSE) {
        $success = FALSE;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->where('person_id', $employee_id);
        $success = $this->db->update('employees', $employee_data);

        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    /*
      Change Language code for the employee
     */

    public function change_language_code($language_code, $employee_id = FALSE) {
        $success = FALSE;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->where('person_id', $employee_id);
        $success = $this->db->update('employees', array('language_code' => $language_code));
        $this->session->set_userdata('language_code', $language_code);
        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    public function get_deposit_found_rows($search, $filters) {
        $this->db->select('at.id,at.trans_type,at.trans_date,at.reference,at.amount as creditamount,at.amount as debitamount,CONCAT(cp.first_name, " ", cp.last_name) AS employeename');
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->join('people as cp', 'at.employee_id = cp.person_id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('at.reference', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        if ($filters['trans_type']) {
            $this->db->where_in('at.trans_type', $filters['trans_type']);
        }
        $this->db->where('ac.id', $filters['account_id']);

        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        //$this->db->where('at.trans_type', 'debit');
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function depositsearch($search, $filters, $rows = 0, $limit_from = 0, $sort = 'rc.receiving_id', $order = 'asc') {
        $this->db->select('at.id,at.trans_type,at.trans_date,at.reference,at.amount as creditamount,at.amount as debitamount,CONCAT(cp.first_name, " ", cp.last_name) AS employeename');
        $this->db->from('account_trans as at');
        $this->db->join('account as ac', 'at.account_id = ac.id');
        $this->db->join('people as cp', 'at.employee_id = cp.person_id');
        $this->db->group_start();
        $this->db->or_like('at.id', $search);
        $this->db->or_like('at.amount', $search);
        $this->db->like('at.trans_type', $search);
        $this->db->or_like('at.trans_date', $search);
        $this->db->or_like('cp.first_name', $search);
        $this->db->or_like('cp.last_name', $search);
        $this->db->or_like('at.reference', $search);
        $this->db->or_like('CONCAT(cp.first_name, " ", cp.last_name)', $search);
        $this->db->group_end();
        //$this->db->where('at.trans_type', 'debit');
        if ($filters['trans_type']) {
            $this->db->where_in('at.trans_type', $filters['trans_type']);
        }

        $this->db->where('ac.id', $filters['account_id']);

        if (empty($this->config->item('date_or_time_format'))) {
            $this->db->where('DATE_FORMAT(at.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($filters['start_date']) . ' AND ' . $this->db->escape($filters['end_date']));
        } else {
            $this->db->where('at.trans_date BETWEEN ' . $this->db->escape(rawurldecode($filters['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($filters['end_date'])));
        }
        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

    public function checkusername($where) {
        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id = people.person_id');
        $this->db->where($where);
        $this->db->where('employees.deleted', '0');
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $row = $query->row_array();
        }
        return FALSE;
    }

    public function resetusername($param) {
        
    }

    public function role_lists($data = array()) {

        $this->db->select('*');
        $this->db->from('employees_role');
        $this->db->where('deleted', 0);
        if (isset($data['login_type']) && !empty($data['login_type'])) {
            $this->db->where('login_type', $data['login_type']);
        }
        $query = $this->db->get();
        $role_list = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $list) {
                $role_list[$list['id']] = $list['name'];
            }
            return $role_list;
        } else {
            return $role_list;
        }
    }

    public function get_role_info($role_id = '') {

        $this->db->select('*');
        $this->db->from('employees_role');
        $this->db->where('id', $role_id);

        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $employee_id is NOT an employee
            $role_obj = new stdClass;
            //Get all the fields from employee table
            //append those fields to base parent object, we we have a complete empty object
            foreach ($this->db->list_fields('employees_role') as $field) {
                $role_obj->$field = '';
            }

            return $role_obj;
        }
    }

    public function save_role(&$role_data, &$grants_data, $role_id = FALSE) {
        $success = FALSE;
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();


        if (!$role_id || !$this->roleexists($role_id)) {
            $success = $this->db->insert('employees_role', $role_data);
            $role_id = $this->db->insert_id();
        } else {
            $this->db->where('id', $role_id);
            $success = $this->db->update('employees_role', $role_data);
        }

        //We have either inserted or updated a new employee, now lets set permissions. 
        if ($success) {
            //First lets clear out any grants the employee currently has.
            $success = $this->db->delete('grants', array('person_id' => $role_id));

            //Now insert the new grants
            if ($success) {
                foreach ($grants_data as $permission_id) {
                    $success = $this->db->insert('grants', array('permission_id' => $permission_id, 'person_id' => $role_id));
                }
            }
        }


        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    public function roleexists($role_id) {
        $this->db->from('employees_role');
        $this->db->where('id', $role_id);

        return ($this->db->get()->num_rows() == 1);
    }

    public function check_exist_role($data) {
        $this->db->select('*');
        $this->db->from('employees_role');
        $this->db->where('name', trim($data['name']));
        if (isset($data['login_type']) && !empty($data['login_type'])) {
            $this->db->where('login_type', trim($data['login_type']));
        }
        if (isset($data['role_id']) && !empty($data['role_id'])) {
            $this->db->where('id !=', trim($data['role_id']));
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
            return array();
        } else {
            return array();
        }
    }

    public function get_employee_role_found_rows($search, $filters) {
        $this->db->select('*');
        $this->db->from('employees_role');
        $this->db->group_start();
        $this->db->or_like('name', $search);
        $this->db->or_like('login_type', $search);
        $this->db->group_end();
        $this->db->where('deleted', 0);
        return $this->db->get()->num_rows();
    }

    /*
      Performs a search on customers
     */

    public function employee_role_search($search, $filters, $rows = 0, $limit_from = 0, $sort = 'name', $order = 'asc') {
        $this->db->select('*');
        $this->db->from('employees_role');
        $this->db->group_start();
        $this->db->or_like('name', $search);
        $this->db->or_like('login_type', $search);
        $this->db->group_end();
        $this->db->where('deleted', 0);
        $this->db->order_by($sort, $order);

        if ($rows > 0) {
            $this->db->limit($rows, $limit_from);
        }
        return $this->db->get();
    }

}

?>
