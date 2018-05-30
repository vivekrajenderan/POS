<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Accounts extends Secure_Controller {

    public function __construct() {
        parent::__construct('accounts');

        $this->load->library('receiving_lib');
    }

    public function index() {
        
    }

    public function account_transactions() {        
        $data['item_locations'] =$this->xss_clean($this->Stock_location->get_all_locations(''));        
        $data['trans_type'] = array('credit' => 'Credit', 'debit' => 'Debit');
        $data['page_title'] = 'account_page_title';
        $data['accountdetails'] = $this->Account->getDetails();
        $data['accountdetails']['all'] = 'All';
        $data['account_type'] = 'all';
        $data['table_headers'] = $this->xss_clean(get_account_transactions_list());
        $data['search_term'] = 'account_transactions_search';
        $this->load->view('account/manage', $data);
    }

    public function general_ledger() {
        $data['page_title'] = 'account_general_ledger_title';
        $data['table_headers'] = $this->xss_clean(get_general_ledger_list());
        $data['search_term'] = 'general_ledger_search';
        $this->load->view('account/manage', $data);
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'account_transactions_search':
                $this->account_transactions_search();
                break;
            case 'trial_balance_search':
                $this->trial_balance_search();
                break;
            case 'general_ledger_search':
                $this->general_ledger_search();
                break;
            default:
                break;
        }
    }

    public function account_transactions_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'item_location' => $this->input->get('item_locations'),
            'trans_type' => $this->input->get('trans_type'),
            'account_type' => $this->input->get('account_type')
        );

        $billings = $this->Account->transactionsearch($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Account->get_transactionsearch_found_rows($search, $filters);

        $data_rows = array();
        foreach ($billings->result() as $bill_row) {
            $data_rows[] = get_account_transactions_data_row($bill_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function trial_balance() {
        $data['page_title'] = 'account_trailbalence_title';
        $data['table_value'] = $this->trial_balance_search();
        $data['search_term'] = 'trial_balance_search';
        $this->load->view('account/manage_trailbalance', $data);
    }

    public function trial_balance_search() {
        $filters = array('start_date' => (isset($_POST['startdate'])) ? $_POST['startdate'] : date('Y-m-d'),
            'end_date' => (isset($_POST['enddate'])) ? $_POST['enddate'] : date('Y-m-d', strtotime('today - 30 days'))
        );
        $billings = $this->Account->trialbalancesearch($filters);
        return $billings;
    }

    public function general_ledger_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date')
        );

        $ledgers = $this->Account->general_ledger_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Account->get_general_ledger_search_found_rows($search, $filters);

        $data_rows = array();
        foreach ($ledgers->result() as $ledger_row) {
            $data_rows[] = get_general_ledger_data_row($ledger_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function viewledger($account_id, $start_date = NULL, $end_date = NULL) {

        $filters = array('start_date' => (!empty($start_date)) ? $start_date : date('Y-m-01'),
            'end_date' => (!empty($end_date)) ? $end_date : date('Y-m-t'),
            'account_id' => (!empty($account_id)) ? $account_id : ''
        );

        $report_data = $this->Account->viewledger($filters);
        $closing_balance = 0;
        $account_name = '';
        $tabular_data = array();
        foreach ($report_data as $receiving_row) {
            $debit_amount = "";
            if ($receiving_row['trans_type'] == "debit") {
                $debit_amount = $receiving_row['debitamount'];
            }
            $credit_amount = "";

            if ($receiving_row['trans_type'] == "credit") {
                $credit_amount = $receiving_row['creditamount'];
            }
            $tabular_data[] = $this->xss_clean(array(
                'trans_date' => changeDateTime($receiving_row['trans_date']),
                'account_name' => $receiving_row['account_name'],
                'employeename' => $receiving_row['employeename'],
                'location_name' => $receiving_row['location_name'],
                'reference' => $receiving_row['reference'],
                'debitamount' => $debit_amount,
                'creditamount' => $credit_amount
            ));
            $account_name = $receiving_row['account_name'];
            $closing_balance+=$credit_amount;
        }
        $data = array(
            'title' => $account_name,
            'headers' => $this->xss_clean($this->Account->getledgerDataColumns()),
            'data' => $tabular_data,
            'closing_balance' => $closing_balance,
            'start_date' => $start_date,
            'end_date' => $end_date
        );
        $this->load->view('account/view_ledger', $data);
    }

    public function profit_and_loss() {


        $data = array('purchase' => 0, 'stock' => 0, 'sales' => 0, 'profit' => 0);
        $data['page_title'] = 'account_profit_and_loss_title';
        $this->db->select("if(" . $this->db->dbprefix('inventory') . ".trans_comment like 'SOK%','sales','purchase') as actions,SUM(" . $this->db->dbprefix('inventory') . ".trans_inventory * " . $this->db->dbprefix('inventory') . ".price) as amount");
        $this->db->from('inventory');
        $this->db->join('items', 'items.item_id = inventory.trans_items');
        $this->db->where('items.deleted', 0);
        $this->db->where('items.stock_type', 0);
        $data['stock_source'] = 'all';
        if (isset($_POST['stock_source']) && $_POST['stock_source'] != 'all') {
            $this->db->where_in($this->db->dbprefix('inventory') . ".trans_location", $_POST['stock_source']);
            $data['stock_source'] = $_POST['stock_source'];
        }
        if (isset($_POST['startdate']) && isset($_POST['enddate'])) {
            if (empty($this->config->item('date_or_time_format'))) {
                $this->db->where('DATE_FORMAT(' . $this->db->dbprefix('inventory') . '.trans_date, "%Y-%m-%d") BETWEEN ' . $this->db->escape($_POST['startdate']) . ' AND ' . $this->db->escape($_POST['enddate']));
            } else {
                $this->db->where('' . $this->db->dbprefix('inventory') . '.trans_date BETWEEN ' . $this->db->escape(rawurldecode($_POST['startdate'])) . ' AND ' . $this->db->escape(rawurldecode($_POST['enddate'])));
            }
        }
        $this->db->group_by("" . $this->db->dbprefix('inventory') . ".trans_comment like 'SOK%' ", "", false);
        $re = $this->db->get()->result_array();
        foreach ($re as $key => $value) {
            if ($value['amount'] < 0)
                $value['amount'] = $value['amount'] * -1;
            $data[$value['actions']] = $value['amount'];
        }

        $data['profit'] = $data['purchase'] - $data['sales'];
        $data['stock'] = ($data['sales'] - $data['profit']);
        $data['print_after_sale'] = FALSE;

        $stock_locations = $this->xss_clean($this->Stock_location->get_allowed_locations());
        $warehouse_locations = $this->xss_clean($this->Stock_location->get_allowed_locations('items', 'warehouse'));
        $data['stock_locations'] = merge($stock_locations, $warehouse_locations);
        $data['stock_locations']['all'] = 'All';

        $this->load->view('account/profit_and_loss', $data);
    }

}

?>
