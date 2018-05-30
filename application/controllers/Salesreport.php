<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Salesreport extends Secure_Controller {

    public function __construct() {
        parent::__construct('salesreport');

        $this->load->library('sale_lib');
        $this->load->library('tax_lib');
        $this->load->library('barcode_lib');
        $this->load->library('email_lib');
        $this->load->library('token_lib');
    }

    public function index() {
        
    }

    public function sale_customer() {
        $data['page_title'] = 'salesreport_sales_by_customer';
        $data['table_headers'] = $this->xss_clean(get_sale_customer_list());
        $data['search_term'] = 'sale_customer_search';
        $data['method1'] = "sale_item";
        $data['method2'] = "sale_person";
        $data['button_title1'] = "salesreport_sales_by_item";
        $data['button_title2'] = "salesreport_sales_by_salesperson";
        $this->load->view('salesreport/saleslist', $data);
    }

    public function sale_item() {
        $data['page_title'] = 'salesreport_sales_by_item';
        $data['table_headers'] = $this->xss_clean(get_sale_item_list());
        $data['search_term'] = 'sale_item_search';
        $data['method1'] = "sale_customer";
        $data['method2'] = "sale_person";
        $data['button_title1'] = "salesreport_sales_by_customer";
        $data['button_title2'] = "salesreport_sales_by_salesperson";
        $this->load->view('salesreport/saleslist', $data);
    }

    public function sale_person() {
        $data['page_title'] = 'salesreport_sales_by_salesperson';
        $data['table_headers'] = $this->xss_clean(get_sale_person_list());
        $data['search_term'] = 'sale_person_search';
        $data['method1'] = "sale_customer";
        $data['method2'] = "sale_item";
        $data['button_title1'] = "salesreport_sales_by_customer";
        $data['button_title2'] = "salesreport_sales_by_item";
        $this->load->view('salesreport/saleslist', $data);
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'sale_customer_search':
                $this->sale_customer_search();
                break;
            case 'sale_item_search':
                $this->sale_item_search();
                break;
            case 'sale_person_search':
                $this->sale_person_search();
                break;
            default:
                break;
        }
    }

    public function sale_customer_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date')
        );

        $saleslist = $this->Sale_report->sale_customer_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Sale_report->get_sale_customer_found_rows($search, $filters);

        $data_rows = array();
        foreach ($saleslist->result() as $sales_row) {
            $data_rows[] = get_sale_customer_data_row($sales_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function sale_item_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date')
        );

        $saleslist = $this->Sale_report->sale_item_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Sale_report->get_sale_item_found_rows($search, $filters);

        $data_rows = array();
        foreach ($saleslist->result() as $sales_row) {
            $data_rows[] = get_sale_item_data_row($sales_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function sale_person_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date')
        );

        $saleslist = $this->Sale_report->sale_person_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Sale_report->get_sale_person_found_rows($search, $filters);

        $data_rows = array();
        foreach ($saleslist->result() as $sales_row) {
            $data_rows[] = get_sale_person_data_row($sales_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
