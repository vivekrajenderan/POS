<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Bill extends Secure_Controller {

    public function __construct() {
        parent::__construct('bill');

        $this->load->library('receiving_lib');
    }

    public function index() {
        
    }

    public function lists() {
        
        $data['table_headers'] = $this->xss_clean(get_bills_list());
        $this->load->view('bills/manage', $data);
    }

    public function search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date')            
        );

        $billings = $this->Bills->search($search, $filters, $limit, $offset, $sort, $order);        
        $total_rows = $this->Bills->get_found_rows($search, $filters);

        $data_rows = array();
        foreach ($billings->result() as $bill_row) {
            $data_rows[] = get_bills_data_row($bill_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
