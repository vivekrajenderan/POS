<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Auditingtrail extends Secure_Controller {

    public function __construct() {
        parent::__construct('auditingtrail');

        $this->load->library('receiving_lib');
    }

    public function index() {
        $data['table_headers'] = $this->xss_clean(get_audting_list());
        $this->load->view('auditing/manage', $data);
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

        $auditings = $this->Auditing->search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Auditing->get_found_rows($search, $filters);

        $data_rows = array();
        foreach ($auditings->result() as $auditing_row) {
            $data_rows[] = get_auditing_data_row($auditing_row, $this);
        }
        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
