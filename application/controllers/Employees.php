<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Persons.php");

class Employees extends Persons {

    public function __construct() {
        parent::__construct('employees');
    }

    /*
      Returns employee table data rows. This will be called with AJAX.
     */

    public function search() {



        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        if (isset($_GET['searchlist']) && !empty($_GET['searchlist'])) {
            if ($_GET['searchlist'] == "depositlists") {
                $filters = array('start_date' => $this->input->get('start_date'),
                    'end_date' => $this->input->get('end_date'),
                    'trans_type' => $this->input->get('trans_type'),
                    'account_id' => $this->input->get('account_id')
                );
                $employees = $this->Employee->depositsearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Employee->get_deposit_found_rows($search, $filters);

                $data_rows = array();
                foreach ($employees->result() as $person) {
                    $data_rows[] = get_employee_deposit_data_row($person, $this);
                }
            }
        }
        if (isset($_GET['searchlist']) && !empty($_GET['searchlist'])) {
            if ($_GET['searchlist'] == "rolelists") {
                $filters=array();
                $roles = $this->Employee->employee_role_search($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Employee->get_employee_role_found_rows($search, $filters);

                $data_rows = array();
                foreach ($roles->result() as $list) {
                    $data_rows[] = get_employee_roles_data_row($list, $this);
                }
            }
        } else {
            $employees = $this->Employee->search($search, $limit, $offset, $sort, $order);
            $total_rows = $this->Employee->get_found_rows($search);

            $data_rows = array();
            foreach ($employees->result() as $person) {
                $data_rows[] = get_person_data_row($person, $this);
            }
        }
        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    /*
      Gives search suggestions based on what is being searched for
     */

    public function suggest_search() {
        $suggestions = $this->xss_clean($this->Employee->get_search_suggestions($this->input->post('term')));

        echo json_encode($suggestions);
    }

    /*
      Loads the employee edit form
     */

    public function view($employee_id = -1) {
        $person_info = $this->Employee->get_info($employee_id);
        foreach (get_object_vars($person_info) as $property => $value) {
            $person_info->$property = $this->xss_clean($value);
        }
        $data['person_info'] = $person_info;

        $data['role'] = array(
            'headoffice' => $this->lang->line('common_headoffice'),
            'warehouse' => $this->lang->line('config_warehouse'),
            'store' => $this->lang->line('config_location'),
        );
        $modules = array();
        foreach ($this->Module->get_all_modules()->result() as $module) {
            $module->module_id = $this->xss_clean($module->module_id);
            $module->grant = $this->xss_clean($this->Employee->has_grant($module->module_id, $person_info->person_id));

            $modules[] = $module;
        }
        $data['all_modules'] = $modules;
        $data['account_number'] = $this->Employee->get_account_data($data['person_info']);

        $permissions = array();
        foreach ($this->Module->get_all_subpermissions()->result() as $permission) {
            $permission->module_id = $this->xss_clean($permission->module_id);
            $permission->permission_id = $this->xss_clean($permission->permission_id);
            $permission->grant = $this->xss_clean($this->Employee->has_grant($permission->permission_id, $person_info->person_id));
            $permission->location_type = ($permission->location_id) ? $this->xss_clean($this->Stock_location->get_location_type($permission->location_id)) : '';

            $permissions[] = $permission;
        }
        $data['all_subpermissions'] = $permissions;

        $data['selected_employees_login'] = $person_info->employees_login;

        $data['roles_type'] = $this->Employee->role_lists();
        $data['selected_role_id'] = $person_info->role_id;

        $this->load->view('employees/form', $data);
    }

    /*
      Inserts/updates an employee
     */

    public function save($employee_id = -1) {
        if ($this->input->post('current_password') != '') {
            if ($this->Employee->check_password($this->input->post('username'), $this->input->post('current_password'))) {
                $employee_data = array(
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'employees_login' => $this->input->post('employees_login'),
                    'hash_version' => 2
                );

                if ($this->Employee->change_password($employee_data, $employee_id)) {
                    echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('employees_successful_change_password'), 'id' => $employee_id));
                } else {//failure
                    echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_unsuccessful_change_password'), 'id' => -1));
                }
            } else {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_current_password_invalid'), 'id' => -1));
            }
        } else {
            $first_name = $this->xss_clean($this->input->post('first_name'));
            $last_name = $this->xss_clean($this->input->post('last_name'));
            $email = $this->xss_clean(strtolower($this->input->post('email')));

            // format first and last name properly
            $first_name = $this->nameize($first_name);
            $last_name = $this->nameize($last_name);

            $person_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $this->input->post('gender'),
                'email' => $email,
                'phone_number' => $this->input->post('phone_number'),
                'address_1' => $this->input->post('address_1'),
                'address_2' => $this->input->post('address_2'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip' => $this->input->post('zip'),
                'country' => $this->input->post('country'),
                'comments' => $this->input->post('comments'),
            );
            //$grants_data = $this->input->post('grants') != NULL ? $this->input->post('grants') : array();
            // pre($_POST);
            if (!isset($_POST['account_id'])) {
                $account_data = array(
                    'name' => $first_name . ' ' . $last_name,
                    'parent' => '16',
                    'employee_id' => $this->session->userdata('person_id')
                );
                $account_insert_id = $this->Account->insert($account_data);
            }

            //Password has been changed OR first time password set
            if ($this->input->post('password') != '') {
                $employee_data = array(
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                    'employees_login' => $this->input->post('employees_login'),
                    'hash_version' => 2,
                    'role_id' => $this->input->post('role_id')
                );
            } else { //Password not changed
                $employee_data = array('username' => $this->input->post('username'), 'employees_login' => $this->input->post('employees_login'), 'role_id' => $this->input->post('role_id'));
            }

            if (isset($account_insert_id)) {
                $employee_data['account_id'] = $account_insert_id;
            }
            if ($this->Employee->save_employee($person_data, $employee_data, $employee_id)) {
                // New employee
                if ($employee_id == -1) {
                    echo json_encode(array('success' => TRUE,
                        'message' => $this->lang->line('employees_successful_adding') . ' ' . $first_name . ' ' . $last_name,
                        'id' => $this->xss_clean($employee_data['person_id'])));
                    InjAuditLog(array(
                        'action' => $this->lang->line('employees_new'),
                        'ref_text' => $employee_data['person_id'],
                        'ref_id' => $employee_data['person_id'],
                        'url' => uri_string()
                    ));
                } else { // Existing employee
                    echo json_encode(array('success' => TRUE,
                        'message' => $this->lang->line('employees_successful_updating') . ' ' . $first_name . ' ' . $last_name,
                        'id' => $employee_id));
                    InjAuditLog(array(
                        'action' => $this->lang->line('employees_update'),
                        'ref_text' => $employee_id,
                        'ref_id' => $employee_id,
                        'url' => uri_string()
                    ));
                }
            } else { // Failure
                echo json_encode(array('success' => FALSE,
                    'message' => $this->lang->line('employees_error_adding_updating') . ' ' . $first_name . ' ' . $last_name,
                    'id' => -1));
            }
        }
    }

    /*
      This deletes employees from the employees table
     */

    public function delete() {
        $employees_to_delete = $this->xss_clean($this->input->post('ids'));

        if ($this->Employee->delete_list($employees_to_delete)) {
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('employees_successful_deleted') . ' ' .
                count($employees_to_delete) . ' ' . $this->lang->line('employees_one_or_multiple')));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_cannot_be_deleted')));
        }
    }

    /*
      Loads the change password form
     */

    public function change_password($employee_id = -1) {
        $person_info = $this->Employee->get_info($employee_id);
        foreach (get_object_vars($person_info) as $property => $value) {
            $person_info->$property = $this->xss_clean($value);
        }
        $data['person_info'] = $person_info;

        $this->load->view('employees/form_change_password', $data);
    }

    public function change_languagecode($employee_id = -1) {
        if ($this->input->post('language_code') != '') {
            $this->Employee->change_language_code($_POST['language_code'], $this->session->userdata('person_id'));
            if (isset($_SERVER['HTTP_REFERER'])) {
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function deposit($employee_id = -1) {
        $data['employee_details'] = $this->Employee->get_info($employee_id);
        $data['table_headers'] = $this->xss_clean(get_employee_deposit_list());
        $data['trans_type'] = array('1' => $this->lang->line('employees_deposit'), '2' => $this->lang->line('employees_withdraw'));
        $data['page_title'] = 'employee_deposit_form';
        $data['listfunction'] = 'depositlists';
        $account_list = $this->Account->getDetailsDropdownTree('19');
        $data['default_account'] = (isset($account_list[0]['id'])) ? $account_list[0]['id'] : '';
        $data['account_types'] = $this->Account->build_option($account_list, 19, $data['default_account']);

        $data['account_id'] = $this->Account->get_employee_account_id($employee_id);

        $this->load->view('employees/deposit_form', $data);
    }

    public function savedeposit($employee_id, $account_id) {
        if (!empty($employee_id) && !empty($account_id)) {
            if (($this->input->server('REQUEST_METHOD') == 'POST')) {
                $this->form_validation->set_rules('amount', 'lang:employees_deposit_amount', 'trim|required|callback_numeric');
                $this->form_validation->set_rules('reference', 'lang:employees_deposit_reference', 'trim|required');
                $this->form_validation->set_rules('account_type', 'lang:employees_deposit_account', 'trim|required');
                if ($this->form_validation->run() == FALSE) {
                    echo json_encode(array('success' => FALSE, 'message' => validation_errors()));
                    return false;
                } else {
                    $account_trans_data = array('amount' => trim($this->input->post('amount')),
                        'account_id' => $account_id,
                        'reference' => trim($this->input->post('reference')),
                        'reference_type' => 'deposit',
                        'trans_type' => 'debit');

                    if ($_POST['trans_type'] == '2') {
                        $account_trans_data['trans_type'] = 'credit';
                    }

                    $add_trans = $this->Account->insert_trans($account_trans_data);
                    $account_trans_data['trans_type'] = 'credit';
                    if ($_POST['trans_type'] == '2') {
                        $account_trans_data['trans_type'] = 'debit';
                    }
                    $account_trans_data['account_id'] = trim($this->input->post('account_type'));
                    $add_trans = $this->Account->insert_trans($account_trans_data);

                    if ($add_trans != "") {
                        echo json_encode(array('success' => TRUE, 'status' => 1, 'message' => $this->lang->line('employees_deposit_insert_success')));
                    } else {
                        echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_deposit_insert_error')));
                    }
                }
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_deposit_insert_error')));
            return false;
        }
    }

    public function viewrole($role_id = -1) {
        $role_info = $this->Employee->get_role_info($role_id);
        foreach (get_object_vars($role_info) as $property => $value) {
            $role_info->$property = $this->xss_clean($value);
        }
        $data['role_info'] = $role_info;
        $data['role'] = array(
            'headoffice' => $this->lang->line('common_headoffice'),
            'warehouse' => $this->lang->line('config_warehouse'),
            'store' => $this->lang->line('config_location'),
        );
        $modules = array();
        foreach ($this->Module->get_all_modules()->result() as $module) {
            $module->module_id = $this->xss_clean($module->module_id);
            $module->grant = $this->xss_clean($this->Employee->has_grant($module->module_id, $role_info->id));

            $modules[] = $module;
        }
        $data['all_modules'] = $modules;

        $permissions = array();
        foreach ($this->Module->get_all_subpermissions()->result() as $permission) {
            $permission->module_id = $this->xss_clean($permission->module_id);
            $permission->permission_id = $this->xss_clean($permission->permission_id);
            $permission->grant = $this->xss_clean($this->Employee->has_grant($permission->permission_id, $role_info->id));
            $permission->location_type = ($permission->location_id) ? $this->xss_clean($this->Stock_location->get_location_type($permission->location_id)) : '';

            $permissions[] = $permission;
        }
        $data['all_subpermissions'] = $permissions;

        $data['selected_login_type'] = $role_info->login_type;
        $this->load->view('employees/roleform', $data);
    }

    /*
      Inserts/updates an employee
     */

    public function saverole($role_id = -1) {
        if (($this->input->server('REQUEST_METHOD') == 'POST')) {
            $this->form_validation->set_rules('name', 'lang:employees_role_name', 'trim|required');
            $this->form_validation->set_rules('login_type', 'lang:common_role', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                $data['error_list'] = $this->form_validation->error_array();
                echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
                return false;
            } else {

                $name = $this->xss_clean($this->input->post('name'));
                $role_data = array(
                    'name' => $this->input->post('name'),
                    'login_type' => $this->input->post('login_type')
                );
                $grants_data = $this->input->post('grants') != NULL ? $this->input->post('grants') : array();

                if ($this->Employee->save_role($role_data, $grants_data, $role_id)) {
                    // New employee
                    if ($role_id == -1) {
                        echo json_encode(array('success' => TRUE,
                            'message' => $this->lang->line('employees_role_insert_success') . ' ' . $name));
                    } else { // Existing employee
                        echo json_encode(array('success' => TRUE,
                            'message' => $this->lang->line('employees_role_update_success') . ' ' . $name,
                            'id' => $role_id));
                    }
                } else { // Failure
                    echo json_encode(array('success' => FALSE,
                        'message' => $this->lang->line('employees_role_error_adding_updating') . ' ' . $name,
                        'id' => -1));
                }
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('employees_role_insert_error')));
            return false;
        }
    }

    public function check_role_exist() {
        if (($this->input->server('REQUEST_METHOD') == 'GET')) {
            $check_exist = $this->Employee->check_exist_role($_GET);
            if (count($check_exist)) {
                echo "1";
            } else {
                echo "0";
            }
        }
    }

    public function get_role_list() {
        $role_list = $this->Employee->role_lists($_GET);
        if (count($role_list)) {
            echo json_encode(array('success' => TRUE,
                'role_list' => $role_list));
        } else {
            echo json_encode(array('success' => FALSE,
                'role_list' => $role_list));
        }
    }

    public function rolelists() {
        $data['table_headers'] = $this->xss_clean(get_employee_roles_list());
        $data['listfunction'] = 'rolelists';
        $this->load->view('employees/rolelist', $data);
    }

}

?>
