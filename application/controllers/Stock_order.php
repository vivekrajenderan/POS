<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Stock_order extends Secure_Controller {

    public function __construct() {
        parent::__construct('stock_order');
        $this->load->library('stock_order_lib');
        $this->load->library('barcode_lib');        
    }

    public function index($receiving_id = -1) {
        if ($receiving_id != -1) {
            $this->stock_order_lib->clear_all();
            $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
            $receiving_items = $this->Po->get_po_items($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'),'stock_order');
            $this->stock_order_lib->set_supplier($receiving_info['supplier_id']);
            foreach ($receiving_items as $key => $value) {
                $this->stock_order_lib->set_stock_source($value['item_location']);
                $this->stock_order_lib->add_item($value['item_id'], $value['request_quantity'], $value['item_location']);
            }
        }
        $this->_reload();
    }

    public function change_mode() {
        $this->stock_order_lib->clear_all();
        $stock_source = $this->input->post('store');
        $this->stock_order_lib->set_stock_source($stock_source);
        $this->_reload();
    }

    public function stock_item_search() {
        $suggestions = $this->Item->get_stock_search_suggestions($this->input->get('term'), array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);
        $suggestions = array_merge($suggestions, $this->Item_kit->get_search_suggestions($this->input->get('term')));

        $suggestions = $this->xss_clean($suggestions);

        echo json_encode($suggestions);
    }

    public function set_comment() {
        $this->stock_order_lib->set_comment($this->input->post('comment'));
    }

    public function set_print_after_sale() {
        $this->stock_order_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function set_receiving_status() {
        $this->stock_order_lib->set_receiving_status($this->input->post('receiving_status'));
    }
    
    public function add() {
        $data = array();

        $item_id = $this->input->post('item');
        $quantity = 1;
        $item_location = $this->stock_order_lib->get_stock_source();
        if (!$this->stock_order_lib->add_item($item_id, $quantity, $item_location)) {
            $data['error'] = $this->lang->line('receivings_unable_to_add_item');
        }
        $this->_reload($data);
    }

    public function edit_item($item_id) {
        $data = array();
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|callback_numeric');

        $quantity = parse_decimals($this->input->post('quantity'));
        $item_location = $this->input->post('location');

        if ($this->form_validation->run() != FALSE) {
            $this->stock_order_lib->edit_item($item_id, $quantity);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }
        $this->_reload($data);
    }

    public function delete_item($item_number) {
        $this->stock_order_lib->delete_item($item_number);
        $this->_reload();
    }

    public function suggest_warehouse() {
        $suggestions = $this->xss_clean($this->Stock_location->get_search_suggestions($this->input->get('term'), 'warehouse'));
        echo json_encode($suggestions);
    }

    public function suggest_store() {
        $suggestions = $this->xss_clean($this->Stock_location->get_allowed_locations_search('stock_order', 'store', $this->input->get('term')));
        echo json_encode($suggestions);
    }

    public function select_supplier() {
        $supplier_id = $this->input->post('supplier');
        $this->stock_order_lib->set_supplier($supplier_id);
        $this->_reload();
    }

    public function remove_supplier() {
        $this->stock_order_lib->remove_supplier();
        $this->_reload();
    }

    public function complete() {
        $data = array();
        $suplier_id = $this->stock_order_lib->get_supplier();
        if ($suplier_id != -1) {
            $data['cart'] = $this->stock_order_lib->get_cart();
            //$data['total'] = $this->stock_order_lib->get_total();

            $data['receipt_title'] = $this->lang->line('so_receipt');
            $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'));
            $data['comment'] = $this->stock_order_lib->get_comment();
            $data['receiving_status'] = $this->input->post('receiving_status');
            $data['stock_location'] = $this->stock_order_lib->get_stock_source();


            $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;

            $data['receiving_id'] = getRefId('SO', 'stock_order');
            $receivings_data = array(
                'receiving_time' => date('Y-m-d H:i:s'),
                'supplier_id' => $this->stock_order_lib->get_supplier(),
                'employee_id' => $employee_id,
                'receiving_mode' => 'stock_order',
                'receiving_ref' => $data['receiving_id'],
                'receiving_status' => $data['receiving_status'],
                'comment' => $data['comment'],
                'reference' => ''
            );
            
            $receiving_id = $this->Receiving->save_so($data['cart'], $receivings_data);
            $data = $this->xss_clean($data);

            if ($receiving_id == '-1') {
                $data['error_message'] = $this->lang->line('so_transaction_failed');
                $this->_reload($data);
            } else {
                InjAuditLog(array(
                    'action' => $this->lang->line('so_register'),
                    'ref_text' => $data['receiving_id'],
                    'ref_id' => $receiving_id,
                    'ref_to' => $this->stock_order_lib->get_supplier(),
                    'url' => uri_string()
                ));
                $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
                $this->stock_order_lib->clear_all();
                $this->receipt($receiving_id);
            }
        }else{
            $data['error'] = $this->lang->line('so_err_supplier');
            $this->_reload($data);
        }
    }

    public function cancel_receiving() {
        $this->stock_order_lib->clear_all();
        $this->_reload();
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->stock_order_lib->get_cart();
        $data['store_locations'] = $this->Stock_location->get_allowed_locations('stock_order', 'store');
        $data['show_store_locations'] = count($data['store_locations']) > 1;

        $data['stock_locations'] = $this->Stock_location->get_all('warehouse')->result_array();
        $data['show_stock_locations'] = count($data['stock_locations']) > 1;
        
        if ($data['show_store_locations']) {
            $data['stock_source'] = $this->stock_order_lib->get_stock_source();
            $stock_source_info = $this->Stock_location->get_row($data['stock_source']);
            $data['stock_source_names'] = $stock_source_info['location_name'];
        }
        $data['receiving_status'] = $this->stock_order_lib->get_receiving_status();
        $data['total'] = 0;

        $data['items_module_allowed'] = $this->Employee->has_grant('stock_order', $this->Employee->get_logged_in_employee_info()->role_id);
        $data['location_name'] = $supplier_id = $this->stock_order_lib->get_supplier();
        if ($supplier_id != -1) {
            $supplier_info = $this->Stock_location->get_row($supplier_id, 'warehouse');
            $data['location_names'] = $supplier_info['location_name'];
            $data['phone_number'] = $supplier_info['phone_number'];
            if (!empty($supplier_info['zip']) or ! empty($supplier_info['city'])) {
                $data['supplier_location'] = $supplier_info['zip'] . ' ' . $supplier_info['city'];
            } else {
                $data['supplier_location'] = '';
            }
        }

        $data['comment'] = $this->stock_order_lib->get_comment();

        $data['print_after_sale'] = $this->stock_order_lib->is_print_after_sale();

        $data = $this->xss_clean($data);

        $this->load->view("stock_order/receiving", $data);
    }

    public function lists() {
        $data['table_headers'] = $this->xss_clean(get_stock_order_list());
        $data['item_source'] = $this->stock_order_lib->get_stock_source();
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('stock_order', 'warehouse');
        $data['receiving_default'] = '';
        $data['receiving_status'] = array('draft' => 'Draft', 'open' => 'Open', 'partially' => 'Partially', 'closed' => 'Closed', 'void' => 'Void');
        $this->load->view('stock_order/manage', $data);
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
        $filters['receiving_status'] = $this->input->get('receiving_status');
        $filters['item_location'] = $this->input->get('item_location');


        $receivings = $this->Stockorder->stock_order_search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Stockorder->get_stock_order_found_rows($search, $filters);

        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_stock_order_data_row($receiving_row, $this);
        }
        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function statuschange($receiving_id = -1) {
        $data = array();
        $data['status_list'] = array(
            'draft' => $this->lang->line('so_draft'),
            'open' => $this->lang->line('so_open'),
            'partially' => $this->lang->line('so_partially'),
            'closed' => $this->lang->line('so_closed'),
            'void' => $this->lang->line('so_void')
        );
        if ($receiving_id != -1) {
            $data['list'] = $this->Stockorder->get_element($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'));
            if ($data['list'] && isset($data['list']['receiving_id'])) {
                if ($data['list']['receiving_status'] == 'draft') {
                    unset($data['status_list']['partially']);
                    unset($data['status_list']['closed']);
                    unset($data['status_list']['void']);
                } else if ($data['list']['receiving_status'] == 'open') {
                    unset($data['status_list']['draft']);
                    unset($data['status_list']['partially']);
                    unset($data['status_list']['void']);
                } else if ($data['list']['receiving_status'] == 'partially') {
                    unset($data['status_list']['draft']);
                    unset($data['status_list']['open']);
                    unset($data['status_list']['void']);
                } else if ($data['list']['receiving_status'] == 'closed') {
                    unset($data['status_list']['draft']);
                    unset($data['status_list']['open']);
                    unset($data['status_list']['partially']);
                    unset($data['status_list']['void']);
                } else {
                    unset($data['status_list']['draft']);
                    unset($data['status_list']['open']);
                    unset($data['status_list']['partially']);
                    unset($data['status_list']['closed']);
                }
            }
        }
        $this->load->view("stock_order/form_statuschage", $data);
    }

    public function save_status($receiving_id = -1) {
        $data = array();
        $this->form_validation->set_rules('receiving_status', 'lang:so_statuschange', 'required');
        if ($this->form_validation->run() != FALSE) {
            if ($receiving_id != -1) {
                $data['list'] = $this->Receiving->update(array('receiving_status' => $_POST['receiving_status']), $receiving_id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('so_order_statuschange_success'), 'ids' => $receiving_id));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('so_order_statuschange_error')));
        }
    }

    public function receipt($receiving_id) {
        $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
        $receiving_items = $this->Stock_location->get_so_items($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'));
        foreach ($receiving_items as $key => $value) {
            $this->stock_order_lib->add_item($value['item_id'], $value['request_quantity'], $value['item_location']);
        }
        //$this->receiving_lib->copy_entire_receiving($receiving_id);
        //$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity, $item_location)
        $data['cart'] = $this->stock_order_lib->get_cart(); 
        $data['total'] = 0;
        $data['mode'] = 'so';
        $data['receipt_title'] = $this->lang->line('so_receipt');

        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
        $data['show_stock_locations'] = $this->Stock_location->show_locations('stock_order');
        $data['stock_location'] = $this->stock_order_lib->get_stock_source();
        //pr($receiving_info);
        //$data['payment_type'] = $receiving_info['payment_type'];
        //$data['reference'] = $this->receiving_lib->get_reference();
        $data['receiving_id'] = $receiving_info['receiving_ref'];
        $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        $employee_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $data['location_name'] = $supplier_id = $this->stock_order_lib->get_supplier();
        $supplier_info = '';
        if ($supplier_id != -1) {
            $supplier_info = $this->Stock_location->get_row($supplier_id, 'warehouse');
            $data['location_names'] = $supplier_info['location_name'];
            $data['phone_number'] = $supplier_info['phone_number'];
            if (!empty($supplier_info['zip']) or ! empty($supplier_info['city'])) {
                $data['supplier_location'] = $supplier_info['zip'] . ' ' . $supplier_info['city'];
            } else {
                $data['supplier_location'] = '';
            }
        }


        $data['print_after_sale'] = FALSE;
        $data['from_receipt'] = 1;

        $data = $this->xss_clean($data);

        $this->load->view("stock_order/receipt", $data);

        $this->stock_order_lib->clear_all();
    }

}

?>
