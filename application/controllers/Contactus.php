<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Contactus extends Secure_Controller {

    public function __construct() {
        parent::__construct('contactus');
    }

    public function index() {
        $this->load->view('contactus/form');
    }

    public function savecontact() {

        if (($this->input->server('REQUEST_METHOD') == 'POST')) {
            $this->form_validation->set_rules('fullname', 'lang:contactus_fullname', 'trim|required');
            $this->form_validation->set_rules('email', 'lang:common_email', 'trim|required');
            $this->form_validation->set_rules('phone', 'lang:common_phone_number', 'trim|required|callback_numeric');
            $this->form_validation->set_rules('subject', 'lang:contactus_subject', 'trim|required');
            $this->form_validation->set_rules('message', 'lang:contactus_message', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(array('success' => FALSE, 'message' => validation_errors()));
                return false;
            } else {
                $account_trans_data = array('fullname' => trim($this->input->post('fullname')),
                    'email' => trim($this->input->post('email')),
                    'phone' => trim($this->input->post('phone')),
                    'subject' => trim($this->input->post('subject')),
                    'message' => trim($this->input->post('message')),
                    'employee_id' => $this->session->userdata('person_id')
                );
                $add_contactus = $this->Contact_us->save_contact($account_trans_data);
                if ($add_contactus != "") {
                    echo json_encode(array('success' => TRUE, 'status' => 1, 'message' => $this->lang->line('contactus_insert_success')));
                } else {
                    echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('contactus_insert_error')));
                }
            }
        }
    }

    public function lists() {

        $data['table_headers'] = $this->xss_clean(get_contact_list());
        $data['page_title'] = 'contactus_title';
        $this->load->view('contactus/manage', $data);
    }

    public function search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array();

        $contacts = $this->Contact_us->search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Contact_us->get_found_rows($search, $filters);

        $data_rows = array();
        foreach ($contacts->result() as $contact_row) {
            $data_rows[] = get_contact_data_row($contact_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
