<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Expenses extends Secure_Controller {

    public function __construct() {
        parent::__construct('expenses');
        $this->load->library('barcode_lib');
        $this->load->library('pay_lib');
    }

    public function index() {
        $data['table_headers'] = $this->xss_clean(get_expenses_list());
        $data['supplier_list'] = $this->Supplier->get_dropdown();
        $data['supplier_list']['all'] = 'All';
        $data['default_supplier'] = 'all';
        $data['page_title'] = 'expenses_expense_details';
        $data['search_term'] = 'expenses_search';
        $this->load->view("expenses/manage", $data);
    }

    public function view($data = array()) {
        $data['supplier_list'] = $this->Supplier->get_dropdown();
        $data['supplier_list'][''] = $this->lang->line('expenses_select_name');
        $data['supplier'] = '';

        $fromaccount_list = $this->Account->getDetailsDropdownTree('5');
        $data['fromaccount_list'] = $this->Account->build_option($fromaccount_list, 5);
        $data['fromaccount'] = '';

        $toaccount_list = $this->Account->getDetailsDropdownTree('2');
        $data['toaccount_list'] = $this->Account->build_option($toaccount_list, 2);
        $data['toaccount'] = '';

        $data['tax_name'] = '';
        $data['currency_list'] = $this->Bills->getCurrencyDropdown();
        $data['basecurrency'] = $this->pay_lib->get_currency();

        $data['expenses_date'] = date($this->config->item('dateformat'));
        $data['tax_list'] = array('' => $this->lang->line('expenses_select_tax'));
        if ($this->config->item('default_tax_1_name') != '' && $this->config->item('default_tax_1_rate') != '')
            $data['tax_list'][$this->config->item('default_tax_1_name') . '_' . $this->config->item('default_tax_1_rate')] = $this->config->item('default_tax_1_name') . '( ' . $this->config->item('default_tax_1_rate') . ' % )';
        if ($this->config->item('default_tax_2_name') != '' && $this->config->item('default_tax_2_rate') != '')
            $data['tax_list'][$this->config->item('default_tax_2_name') . '_' . $this->config->item('default_tax_2_rate')] = $this->config->item('default_tax_1_name') . '( ' . $this->config->item('default_tax_2_rate') . ' % )';

        $data = $this->xss_clean($data);
        $this->load->view("expenses/form", $data);
    }

    public function save($id = '') {
        $this->form_validation->set_rules('expenses_date', 'lang:expenses_date_required', 'trim|required|callback_validdate');
        $this->form_validation->set_rules('from_account', 'lang:expenses_account', 'required');
        $this->form_validation->set_rules('tax_id', 'lang:expenses_tax', 'required');
        $this->form_validation->set_rules('tax_available', 'lang:expenses_tax_available', 'required');
        $this->form_validation->set_rules('to_account', 'lang:expenses_paidthrough', 'required');
        $this->form_validation->set_rules('supplier_id', 'lang:items_supplier', 'required');
        $this->form_validation->set_rules('reference', 'lang:expenses_reference', 'required');
        $this->form_validation->set_rules('amount', 'lang:expenses_amount', 'required|callback_numeric');
        $this->form_validation->set_rules('payment_currency', 'lang:expenses_currency', 'required');
        if ($this->form_validation->run() != FALSE) {
            $getcurrencyrate = $this->Bills->getCurrency(array('currency_id' => $_POST['payment_currency']));

            $currencyrate = (isset($getcurrencyrate['rate'])) ? $getcurrencyrate['rate'] : 1;
            $temp = explode('_', $_POST['tax_id']);
            $insert_array = array(
                'expense_date' => (isset($_POST['expenses_date'])) ? date('Y-m-d', strtotime($_POST['expenses_date'])) : date('Y-m-d'),
                'from_account' => $_POST['from_account'],
                'to_account' => $_POST['to_account'],
                'amount' => floatval($_POST['amount'] / $currencyrate),
                'tax_id' => $temp[0],
                'tax_available' => $_POST['tax_available'],
                'tax_amount' => $temp[1],
                'supplier_id ' => $_POST['supplier_id'],
                'reference' => $_POST['reference'],
                'note' => $_POST['note'],
                'currency_id' => $_POST['payment_currency'],
                'currency_rate' => $currencyrate,
                'currency_rate_id' => (isset($getcurrencyrate['rateid'])) ? $getcurrencyrate['rateid'] : 1
            );
            $item_id = $this->Expense->save($insert_array, $id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('expenses_success'), 'id' => $item_id));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'expenses_search':
                $this->expenses_search();
                break;
            case 'expenses_category_search':
                $this->expenses_category_search();
                break;
            default:
                break;
        }
    }

    public function expenses_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'supplier_list' => $this->input->get('supplier_list')
        );

        $expenses = $this->Expense->expense_details_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Expense->expense_details_found_rows($search, $filters);

        $data_rows = array();
        foreach ($expenses->result() as $expenses_row) {
            $data_rows[] = get_expenses_data_row($expenses_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function category() {
        $data['table_headers'] = $this->xss_clean(get_expenses_category_list());
        $account_list = $this->Account->getDetailsDropdownTree('5');
        $fromaccount_list = array();
        foreach ($account_list as $list) {
            $fromaccount_list[$list['id']] = $list['name'];
        }
        $data['fromaccount_list'] = $fromaccount_list;
        $data['fromaccount_list']['all'] = 'ALLL';
        $data['default_fromaccount'] = 'all';
        $data['page_title'] = 'expenses_expense_category';
        $data['search_term'] = 'expenses_category_search';
        $this->load->view("expenses/manage", $data);
    }

    public function expenses_category_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'fromaccount_list' => $this->input->get('fromaccount_list')
        );

        $expenses = $this->Expense->expense_details_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Expense->expense_details_found_rows($search, $filters);

        $data_rows = array();
        foreach ($expenses->result() as $expenses_row) {
            $data_rows[] = get_expenses_category_data_row($expenses_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
