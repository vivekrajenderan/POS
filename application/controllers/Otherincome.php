<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Otherincome extends Secure_Controller {

    public function __construct() {
        parent::__construct('otherincome');

        $this->load->library('barcode_lib');
        $this->load->library('pay_lib');
    }

    public function index() {
        $data['table_headers'] = $this->xss_clean(get_income_list());
        $data['supplier_list'] = $this->Supplier->get_dropdown();
        $data['supplier_list']['all'] = 'All';
        $data['default_supplier'] = 'all';
        $data['page_title'] = 'otherincome_income_details';
        $data['search_term'] = 'income_search';
        $this->load->view("otherincome/manage", $data);
    }

    public function view($data = array()) {
        $data['supplier_list'] = $this->Supplier->get_dropdown();
        $data['supplier_list'][''] = $this->lang->line('otherincome_select_people');
        $data['supplier'] = '';

        $fromaccount_list = $this->Account->getDetailsDropdownTree('4');
        $data['fromaccount_list'] = $this->Account->build_option($fromaccount_list, 4);
        $data['fromaccount'] = '';

        $toaccount_list = $this->Account->getDetailsDropdownTree('2');
        $data['toaccount_list'] = $this->Account->build_option($toaccount_list, 2);
        $data['toaccount'] = '';

        $data['tax_name'] = '';
        $data['otherincome_date'] = date($this->config->item('dateformat'));
        $data['currency_list'] = $this->Bills->getCurrencyDropdown();
        $data['basecurrency'] = $this->pay_lib->get_currency();
        // $data['tax_list'] = array();
        $data['tax_list'] = array('' => $this->lang->line('expenses_select_tax'));
        if ($this->config->item('default_tax_1_name') != '' && $this->config->item('default_tax_1_rate') != '')
            $data['tax_list'][$this->config->item('default_tax_1_name') . '_' . $this->config->item('default_tax_1_rate')] = $this->config->item('default_tax_1_name') . '( ' . $this->config->item('default_tax_1_rate') . ' % )';
        if ($this->config->item('default_tax_2_name') != '' && $this->config->item('default_tax_2_rate') != '')
            $data['tax_list'][$this->config->item('default_tax_2_name') . '_' . $this->config->item('default_tax_2_rate')] = $this->config->item('default_tax_1_name') . '( ' . $this->config->item('default_tax_2_rate') . ' % )';

        $data = $this->xss_clean($data);
        $this->load->view("otherincome/form", $data);
    }

    public function save($id = '') {
        $this->form_validation->set_rules('otherincome_date', 'lang:otherincome_date_required', 'required|callback_validdate');
        $this->form_validation->set_rules('from_account', 'lang:otherincome_account', 'required');
        $this->form_validation->set_rules('tax_id', 'lang:otherincome_tax', 'required');
        $this->form_validation->set_rules('tax_available', 'lang:otherincome_tax_available_required', 'required');
        $this->form_validation->set_rules('to_account', 'lang:otherincome_paidthrough', 'required');
        $this->form_validation->set_rules('people_id', 'lang:otherincome_people_id', 'required');
        $this->form_validation->set_rules('reference', 'lang:otherincome_reference', 'required');
        $this->form_validation->set_rules('amount', 'lang:otherincome_amount', 'required|callback_numeric');
        $this->form_validation->set_rules('payment_currency', 'lang:otherincome_currency', 'required');
        if ($this->form_validation->run() != FALSE) {
            $temp = explode('_', $_POST['tax_id']);
            $getcurrencyrate = $this->Bills->getCurrency(array('currency_id' => $_POST['payment_currency']));

            $currencyrate = (isset($getcurrencyrate['rate'])) ? $getcurrencyrate['rate'] : 1;
            $insert_array = array(
                'income_date' => (isset($_POST['otherincome_date'])) ? date('Y-m-d', strtotime($_POST['otherincome_date'])) : date('Y-m-d'),
                'from_account' => $_POST['from_account'],
                'to_account' => $_POST['to_account'],
                'amount' => floatval($_POST['amount'] / $currencyrate),
                'tax_id' => $temp[0],
                'tax_available' => $_POST['tax_available'],
                'tax_amount' => $temp[1],
                'people_id' => $_POST['people_id'],
                'reference' => $_POST['reference'],
                'note' => $_POST['note'],
                'currency_id' => $_POST['payment_currency'],
                'currency_rate' => $currencyrate,
                'currency_rate_id' => (isset($getcurrencyrate['rateid'])) ? $getcurrencyrate['rateid'] : 1
            );
            
            $item_id = $this->Expense->save_income($insert_array, $id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('otherincome_success'), 'id' => $item_id));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'income_search':
                $this->income_search();
                break;
            case 'income_category_search':
                $this->income_category_search();
                break;
            default:
                break;
        }
    }

    public function income_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'supplier_list' => $this->input->get('supplier_list')
        );

        $incomes = $this->Expense->income_details_search($search, $filters, $limit, $offset, $sort, $order);        
        $total_rows = $this->Expense->income_details_found_rows($search, $filters);

        $data_rows = array();
        foreach ($incomes->result() as $incomes_row) {
            $data_rows[] = get_income_data_row($incomes_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function category() {
        $data['table_headers'] = $this->xss_clean(get_income_category_list());
        $account_list = $this->Account->getDetailsDropdownTree('4');
        $fromaccount_list = array();
        foreach ($account_list as $list) {
            $fromaccount_list[$list['id']] = $list['name'];
        }
        $data['fromaccount_list'] = $fromaccount_list;
        $data['fromaccount_list']['all'] = 'ALLL';
        $data['default_fromaccount'] = 'all';
        $data['page_title'] = 'otherincome_income_category';
        $data['search_term'] = 'income_category_search';
        $this->load->view("otherincome/manage", $data);
    }

    public function income_category_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'fromaccount_list' => $this->input->get('fromaccount_list')
        );

        $incomes = $this->Expense->income_details_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Expense->income_details_found_rows($search, $filters);

        $data_rows = array();
        foreach ($incomes->result() as $incomes_row) {
            $data_rows[] = get_income_data_row($incomes_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
