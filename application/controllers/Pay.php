<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Pay extends Secure_Controller {

    public function __construct() {
        parent::__construct('pay');
        $this->load->library('pay_lib');
        $this->load->library('barcode_lib');
        $this->load->library('receiving_lib');
    }

    public function index() {
        $this->_reload();
    }

    public function bill() {
        $data['stock_locations'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data['table_headers'] = $this->xss_clean(get_bills_list());
        $data['page_title'] = 'pay_bill_history';
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
        $data_rows = array();
        $total_rows = array();
        if (isset($_GET['searchlist']) && !empty($_GET['searchlist'])) {
            if ($_GET['searchlist'] == "lists") {
                //Payment Lists                
                $filters['payment_options'] = $this->input->get('payment_options');
                $paylists = $this->Bills->paylistsearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_paylist_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_paylist_data_row($receiving_row, $this);
                }
            }
            if ($_GET['searchlist'] == "supplierlists") {
                //Payment Supplier Lists                
                $filters['payment_options'] = $this->input->get('payment_options');
                $filters['stock_locations'] = $this->input->get('stock_locations');
                $paylists = $this->Bills->paysupplierlistsearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_paysupplierlist_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_payment_supplier_data_row($receiving_row, $this);
                }
            }
            if ($_GET['searchlist'] == "itemlists") {
                //Payment Supplier Lists                
                $filters['payment_options'] = $this->input->get('payment_options');
                $filters['stock_locations'] = $this->input->get('stock_locations');
                $paylists = $this->Bills->payitemlistsearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_payitemlist_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_payment_item_data_row($receiving_row, $this);
                }
            }
            if ($_GET['searchlist'] == "locationlists") {
                //Payment Supplier Lists                
                $filters['payment_options'] = $this->input->get('payment_options');
                $paylists = $this->Bills->paylocationlistsearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_paylocationlist_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_payment_location_data_row($receiving_row, $this);
                }
            }
            if ($_GET['searchlist'] == "historylists") {
                //Payment Supplier Lists                
                $filters['receiving_status'] = $this->input->get('receiving_status');
                $filters['stock_locations'] = $this->input->get('stock_locations');
                $paylists = $this->Bills->payorderhistorysearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_payorderhistory_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_payment_history_data_row($receiving_row, $this);
                }
            }
            if ($_GET['searchlist'] == "supplierbalance") {
                //Payment Supplier Lists                
                $paylists = $this->Bills->paysupplierbalancesearch($search, $filters, $limit, $offset, $sort, $order);
                $total_rows = $this->Bills->get_paysupplierbalance_found_rows($search, $filters);
                foreach ($paylists->result() as $receiving_row) {
                    $data_rows[] = get_payment_supplier_balance_data_row($receiving_row, $this);
                }
            }
        } else {
            $filters['stock_locations'] = $this->input->get('stock_locations');
            $billings = $this->Bills->search($search, $filters, $limit, $offset, $sort, $order);
            $total_rows = $this->Bills->get_found_rows($search, $filters);


            foreach ($billings->result() as $bill_row) {
                $data_rows[] = get_bills_data_row($bill_row, $this);
            }
        }
        $data_rows = $this->xss_clean($data_rows);
        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function change_mode() {
        $this->pay_lib->clear_all();
        $supplier = $this->input->post('supplier');
        $stock_source = $this->input->post('stock_source');
        $this->pay_lib->set_supplier($supplier);
        $this->pay_lib->set_stock_source($stock_source);
        $this->pay_lib->set_cart(array());
        //redirect('pay');
        $this->add_default();
        $this->_reload();
    }

    public function bill_search() {
        $suggestions = $this->Grn_modal->get_search_suggestions($this->input->get('term'), 'payment_ref', array('closed'));
        $suggestions = $this->xss_clean($suggestions);
        echo json_encode($suggestions);
    }

    public function add() {
        $data = array();
        $mode = 'receive';
        $bill_id = $this->input->post('item');
        if (!$this->pay_lib->add_bill($bill_id)) {
            $data['error'] = $this->lang->line('receivings_unable_to_add_item');
        }
        $this->_reload($data);
    }

    public function add_default() {
        $suggestions = $this->Grn_modal->get_search_suggestions('b', 'payment_ref', array('closed'));

        $data = array();
        $mode = 'receive';
        foreach ($suggestions as $key => $value) {
            if (isset($value['value'])) {
                if (!$this->pay_lib->add_bill($value['value'])) {
                    $data['error'] = $this->lang->line('receivings_unable_to_add_item');
                }
            }
        }
    }

    public function add_default_in() {
        $suggestions = $this->Grn_modal->get_search_suggestions('b', 'payment_ref', array('closed'));

        $data = array();
        $mode = 'receive';
        foreach ($suggestions as $key => $value) {
            if (isset($value['value'])) {
                if (!$this->pay_lib->add_bill($value['value'])) {
                    $data['error'] = $this->lang->line('receivings_unable_to_add_item');
                }
            }
        }
        $this->_reload($data);
    }

    public function edit_item($item_id) {
        $data = array();
        $this->form_validation->set_rules('price', 'lang:items_price', 'required|callback_numeric');
        $price = parse_decimals($this->input->post('price'));
        $total_quantity = parse_decimals($this->input->post('total_quantity'));

        if ($this->form_validation->run() != FALSE) {
            $this->pay_lib->edit_bill($item_id, $total_quantity, $price);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }

        $this->_reload($data);
    }

    public function delete_item($item_number) {
        $this->pay_lib->delete_item($item_number);
        $this->_reload();
    }

    public function set_comment() {
        $this->pay_lib->set_comment($this->input->post('comment'));
    }

    public function set_currency() {
        $currency_id = $this->input->post('payment_currency');
        $this->pay_lib->set_currency($currency_id);
        $this->_reload();
    }

    public function set_print_after_sale() {
        $this->pay_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function set_reference() {
        $this->pay_lib->set_reference($this->input->post('recv_reference'));
    }

    public function cancel_receiving() {
        $this->pay_lib->clear_all();
        $this->_reload();
    }

    public function complete() {
        $cart = $this->pay_lib->get_cart();
        $this->form_validation->set_rules('recv_reference', 'lang:pay_payment_reference', 'required');
        $this->form_validation->set_rules('payment_type', 'lang:pay_payment_type', 'required');
        $this->form_validation->set_rules('payment_date', 'lang:pay_payment_date', 'required');
        if ($this->form_validation->run() != FALSE && count($cart) > 0) {
            $data['payment_notes'] = ($this->pay_lib->get_comment() != '') ? $this->pay_lib->get_comment() : $this->input->post('comment');
            $data['payment_reference'] = ($this->pay_lib->get_reference() != '') ? $this->pay_lib->get_reference() : $this->input->post('recv_reference');
            $data['payment_type'] = $this->input->post('payment_type');
            $basecurrency= $this->pay_lib->get_currency();
            $rate = $this->Bills->getCurrency(array('currency_id' => $basecurrency));
            $data['currency_rate']=$rate['rate'];
            $data['currency_rate_id']=$rate['rateid'];
            $data['currency_id']=$rate['currency_id'];
            $data['payment_date'] = date('Y-m-d H:i:s', strtotime($this->input->post('payment_date')));
            $data['employee_id'] = $this->Employee->get_logged_in_employee_info()->person_id;
            $data['supplier_id'] = $this->pay_lib->get_supplier();
            $recpayment_made_id = $this->Receiving->save_payment($data, $cart);
            if ($recpayment_made_id == '-1') {
                $data['error_message'] = $this->lang->line('receivings_transaction_failed');
            } else {
                $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($recpayment_made_id);
            }
            $this->pay_lib->clear_all();
        } else {
            $data['error_list'] = $this->form_validation->error_array();
        }
        $this->_reload($data);
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->pay_lib->get_cart();
        $receiving_info = $this->Receiving->get_info($this->pay_lib->get_currentid())->row_array();
        $data['po_id'] = $receiving_info['receiving_ref'];

        $data['stock_locations'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data['supplier_list'] = $this->Supplier->get_to_pay_dropdown();
        $data['show_stock_locations'] = count($data['stock_locations']) > 1;
        if ($data['show_stock_locations']) {
            $data['stock_source'] = $this->pay_lib->get_stock_source();
            $data['supplier'] = $this->pay_lib->get_supplier();
        }
        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));

        $data['payment_type'] = '';
        $data['payment_date'] = date('Y-m-d');

        $data['currency_list'] = $this->Bills->getCurrencyDropdown();
        $data['basecurrency'] = $this->pay_lib->get_currency();
        $data['total'] = $this->pay_lib->get_total();
        $data['rate'] = $this->Bills->getCurrency(array('currency_id' => $data['basecurrency']));

        $data['reference'] = $this->pay_lib->get_reference();
        $data['items_module_allowed'] = $this->Employee->has_grant('items', $this->Employee->get_logged_in_employee_info()->role_id);
        $data['comment'] = $this->pay_lib->get_comment();
        $data['reference'] = $this->pay_lib->get_reference();
        $data['payment_options'] = $this->Receiving->get_payment_options();

        $data['supplier'] = $supplier_id = $this->pay_lib->get_supplier();
        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['suppliers'] = $supplier_info->company_name;
            $data['first_name'] = $supplier_info->first_name;
            $data['last_name'] = $supplier_info->last_name;
            $data['supplier_email'] = $supplier_info->email;
            $data['supplier_address'] = $supplier_info->address_1;
            if (!empty($supplier_info->zip) or ! empty($supplier_info->city)) {
                $data['supplier_location'] = $supplier_info->zip . ' ' . $supplier_info->city;
            } else {
                $data['supplier_location'] = '';
            }
        }

        $data['print_after_sale'] = $this->pay_lib->is_print_after_sale();
        $data = $this->xss_clean($data);
        $this->load->view("pay/receiving", $data);
    }

    public function lists() {
        $data = array('table_headers' => $this->xss_clean(get_payment_list()),
            'page_title' => "pay_list",
            'payment_options' => $this->Receiving->get_payment_options(),
            'listfunction' => 'lists',
            'button_list' => '0'
        );

        $this->load->view('pay/paymentlist', $data);
    }

    public function supplierlists() {
        $stock_locations = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data = array('table_headers' => $this->xss_clean(get_payment_supplier_list()),
            'page_title' => "pay_supplier_list",
            'listfunction' => 'supplierlists',
            'button_list' => '1',
            'method1' => 'itemlists',
            'method2' => 'locationlists',
            'button_title1' => 'pay_item',
            'button_title2' => 'pay_location',
            'stock_locations' => $stock_locations
        );
        $this->load->view('pay/paymentlist', $data);
    }

    public function itemlists() {
        $stock_locations = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data = array('table_headers' => $this->xss_clean(get_payment_item_list()),
            'page_title' => "pay_item_list",
            'listfunction' => 'itemlists',
            'button_list' => '1',
            'method1' => 'supplierlists',
            'method2' => 'locationlists',
            'button_title1' => 'pay_supplier',
            'button_title2' => 'pay_location',
            'stock_locations' => $stock_locations
        );
        $this->load->view('pay/paymentlist', $data);
    }

    public function locationlists() {
        $data = array('table_headers' => $this->xss_clean(get_payment_location_list()),
            'page_title' => "pay_location_list",
            'listfunction' => 'locationlists',
            'button_list' => '1',
            'method1' => 'supplierlists',
            'method2' => 'itemlists',
            'button_title1' => 'pay_supplier',
            'button_title2' => 'pay_item'
        );

        $this->load->view('pay/paymentlist', $data);
    }

    public function purchase_order_history() {
        $receiving_status = array('draft' => 'Draft', 'open' => 'Open', 'partially' => 'Partially', 'closed' => 'Closed', 'void' => 'Void');
        $stock_locations = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');

        $data = array('table_headers' => $this->xss_clean(get_payment_order_history_list()),
            'page_title' => "pay_order_history",
            'listfunction' => 'historylists',
            'button_list' => '0',
            'receiving_status' => $receiving_status,
            'stock_locations' => $stock_locations
        );

        $this->load->view('pay/paymentlist', $data);
    }

    public function supplier_balance() {
        $data = array('table_headers' => $this->xss_clean(get_payment_supplier_balance_list()),
            'page_title' => "pay_supplier_balance",
            'listfunction' => 'supplierbalance',
            'button_list' => '0'
        );

        $this->load->view('pay/supplierbalance', $data);
    }

}

?>
