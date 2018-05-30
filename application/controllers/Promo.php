<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Promo extends Secure_Controller {

    public function __construct() {
        parent::__construct('promo');
    }

    public function index() {
        $data['table_headers'] = $this->xss_clean(get_promotion_list());
        $data['page_title'] = $this->lang->line('page_title');
        $data['search_term'] = 'promo_search';
        $this->load->view("promo_code/manage", $data);
    }

    public function view($id = '') {
        $data = array();
        $data['promo_type_list'] = array(
            'price' => $this->lang->line('promo_type_price'),
            'percentage' => $this->lang->line('promo_type_percentage')
        );
        $item_locations['all'] = $this->lang->line('reports_all');
        $item_locations = merge($item_locations, $this->xss_clean($this->Stock_location->get_all_locations('store')));
        $data['promo_store'] = array_keys($item_locations);
        $data['stores'] = $item_locations;
        $data['promo_type'] = 'price';
        $data['promo_items'] = array();
        $data = $this->xss_clean($data);
        $this->load->view("promo_code/form", $data);
    }

    public function save($id = '') {
        $this->form_validation->set_rules('promo_name', 'lang:promo_name', 'trim|required|min_length[3]|max_length[199]');
        $this->form_validation->set_rules('promo_fromdate', 'lang:promo_fromdate', 'trim|required|callback_validatedate');
        $this->form_validation->set_rules('promo_todate', 'lang:promo_todate', 'trim|required|callback_validatedate|callback_compareDate');
        $this->form_validation->set_rules('promo_price', 'lang:promo_price', 'trim|required|callback_numeric');
        $this->form_validation->set_rules('promo_type', 'lang:promo_type', 'trim|required');
        $this->form_validation->set_rules('promo_store[]', 'lang:promo_store', 'trim|required');
        $this->form_validation->set_rules('product[]', 'lang:promo_add_item', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $key = array_search('all', $_POST["promo_store"]);

            if (in_array('all', $_POST["promo_store"]))
                unset($_POST["promo_store"][$key]);

            $insert_array = array(
                "promo_name" => $_POST["promo_name"],
                "id" => $_POST["id"],
                "fromdate" => date('Y-m-d', strtotime($_POST["promo_fromdate"])),
                "todate" => date('Y-m-d', strtotime($_POST["promo_todate"])),
                "promo_type" => $_POST["promo_type"],
                "price" => $_POST["promo_price"],
                "location_id" => $_POST["promo_store"],
                "item_id" => $_POST["product"],
                "date_time" => date('Y-m-d H:i:s'),
                "employee_id" => $this->Employee->get_logged_in_employee_info()->person_id
            );
            $this->Promo_modal->save($insert_array);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('promo_insert_successfull')));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }
    
    public function updatepromo($id = '') {
        $this->form_validation->set_rules('promo_fromdate', 'lang:promo_fromdate', 'trim|required|callback_validatedate');
        $this->form_validation->set_rules('promo_todate', 'lang:promo_todate', 'trim|required|callback_validatedate|callback_compareDate');
        $this->form_validation->set_rules('promo_price', 'lang:promo_price', 'trim|required|callback_numeric');
        $this->form_validation->set_rules('promo_type', 'lang:promo_type', 'trim|required');
        if ($this->form_validation->run() != FALSE) {
            $insert_array = Array
                (
                "id" => $id,
                "fromdate" => date('Y-m-d', strtotime($_POST["promo_fromdate"])),
                "todate" => date('Y-m-d', strtotime($_POST["promo_todate"])),
                "promo_type" => $_POST["promo_type"],
                "price" => $_POST["promo_price"],
                "date_time" => date('Y-m-d H:i:s'),
                "employee_id" => $this->Employee->get_logged_in_employee_info()->person_id
            );
            $this->Promo_modal->save($insert_array);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('promo_update_successfull')));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }
    
    function compareDate() {
        $startDate = strtotime($_POST['promo_fromdate']);
        $endDate = strtotime($_POST['promo_todate']);
        if ($endDate >= $startDate)
            return True;
        else {
            $this->form_validation->set_message('compareDate', $this->lang->line('promo_startenddate_invalid'));
            return False;
        }
    }
    
    function validatedate($str) {
        if (parent::validdate($str))
            return True;
        else {
            $this->form_validation->set_message('validatedate', $this->lang->line('promo_fromdate_invalid'));
            return False;
        }
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'promo_search':
                $this->promo_search();
                break;
            default:
                break;
        }
    }

    public function promo_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array();
        $incomes = $this->Promo_modal->promo_search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Promo_modal->promo_found_rows($search, $filters);

        $data_rows = array();
        foreach ($incomes->result_array() as $incomes_row) {
            $data_rows[] = get_promotion_data_row($incomes_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function viewpromo($id = NULL) {
        if (!empty($id)) {
            $data = $this->Promo_modal->get_data(array('item_promo.id' => $id));
            $data['promo_type_list'] = array(
                'price' => $this->lang->line('promo_type_price'),
                'percentage' => $this->lang->line('promo_type_percentage')
            );
            $this->load->view("promo_code/updatepromo", $data);
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('currency_success_update')));
        }
    }

}

?>
