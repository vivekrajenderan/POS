<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Requisition extends Secure_Controller {

    public function __construct() {
        parent::__construct('requisition');
        $this->load->library('barcode_lib');
        $this->load->library('requisition_lib');
    }

    public function index() {
        $this->_reload();
    }

    public function change_mode() {
        //$stock_source = $this->input->post('store');
        $this->requisition_lib->clear_all();
        $stock_source = $this->input->post('stock_source');
        $this->requisition_lib->set_stock_source($stock_source);
        
        $this->_reload();
    }

    public function stock_order_search() {
        $supplier_id = $this->requisition_lib->get_stock_source('warehouse');
        $where=array(
            'receiving_mode'=>'stock_order',
            'supplier_id'=>$supplier_id,
            'receiving_status'=>array('open', 'partially')
                
        );
        $suggestions = $this->Po->get_search_suggestions($this->input->get('term'),25,$where);
        $suggestions = $this->xss_clean($suggestions);
        echo json_encode($suggestions);
    }

    public function select_supplier() {
        $supplier_id = $this->input->post('supplier');
        if ($this->Supplier->exists($supplier_id)) {
            $this->requisition_lib->set_supplier($supplier_id);
        }

        $this->_reload();
    }

    public function set_comment() {
        $this->requisition_lib->set_comment($this->input->post('comment'));
    }

    public function set_print_after_sale() {
        $this->requisition_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function add() {
        $data = array();
        $mode = 'requisition';
        $stock_order_id = $this->input->post('item');
        if (!$this->requisition_lib->add_item($stock_order_id)) {
            $data['error'] = $this->lang->line('requisition_unable_to_so_ref');
        }

        $this->_reload($data);
    }

    public function edit_item($item_id) {
        $data = array();

        $this->form_validation->set_rules('receiving_quantity', 'lang:grn_receiving_qty', 'required|callback_numeric');
        $this->form_validation->set_rules('requested_quantity', 'lang:grn_requesting_qty', 'required|callback_numeric');

        $receiving_quantity = parse_decimals($this->input->post('receiving_quantity'));
        $requested_quantity = parse_decimals($this->input->post('requested_quantity'));

        if ($this->form_validation->run() != FALSE && ($requested_quantity >= $receiving_quantity && $receiving_quantity > 0)) {
            $this->requisition_lib->edit_item($item_id, $receiving_quantity);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }

        $this->_reload($data);
    }

    public function delete_item($item_number) {
        $this->requisition_lib->delete_item($item_number);

        $this->_reload();
    }

    public function remove_supplier() {
        $this->requisition_lib->clear_reference();
        $this->requisition_lib->remove_supplier();

        $this->_reload();
    }

    public function complete() {
        $data = array();

        $data['cart'] = $this->requisition_lib->get_cart();
        $data['receipt_title'] = $this->lang->line('requisition_receipt');
        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'));
        $data['mode'] = 'requisition';
        $data['comment'] = $this->requisition_lib->get_comment();
        $data['stock_location'] = $this->requisition_lib->get_stock_source('warehouse');

        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $employee_info = $this->Employee->get_info($employee_id);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $data['location_name'] = $supplier_id = $this->requisition_lib->get_supplier();
        $supplier_info = '';

        if ($supplier_id != -1) {
            $supplier_info = $this->Stock_location->get_row($supplier_id, 'warehouse');
            $data['location_names'] = $supplier_info['location_name'];
            $data['phone_number'] = $supplier_info['phone_number'];
            if (!empty($supplier_info['zip']) or !empty($supplier_info['city'])) {
                $data['supplier_location'] = $supplier_info['zip'] . ' ' . $supplier_info['city'];
            } else {
                $data['supplier_location'] = '';
            }
        }

        $dy_prefix = 'REQ ';
        $stock_order_id = $this->requisition_lib->get_currentid();
        //SAVE receiving to database
        $data['receiving_id'] = getRefId('REQ', 'requisition');
        $receiving_id = $this->Receiving->save_requisition($data['cart'], $supplier_id, $employee_id, $data['comment'], $stock_order_id, $data['receiving_id']);
        $po_id = $this->Po->get_element($this->requisition_lib->get_currentid(), array('draft', 'open', 'partially', 'closed', 'void'), 'stock_order');
        $data['stock_order_id'] = $po_id['receiving_ref'];
        $data = $this->xss_clean($data);

        if ($receiving_id == '-1') {
            $data['error_message'] = $this->lang->line('receivings_transaction_failed');
        } else {
            InjAuditLog(array(
                'action' => $this->lang->line('requisition_register'),
                'ref_text' => $data['receiving_id'],
                'ref_id' => $receiving_id,
                'ref_to' => $supplier_id,
                'url' => uri_string()
            ));
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        }

        $data['print_after_sale'] = $this->requisition_lib->is_print_after_sale();

        $this->load->view("requisition/receipt", $data);

        $this->requisition_lib->clear_all();
    }

    public function requisition_complete() {
        if ($this->requisition_lib->get_stock_source() != $this->requisition_lib->get_stock_destination()) {
            foreach ($this->requisition_lib->get_cart() as $item) {
                $this->requisition_lib->delete_item($item['line']);
                $this->requisition_lib->add_item($item['item_id'], $item['quantity'], $this->requisition_lib->get_stock_destination());
                $this->requisition_lib->add_item($item['item_id'], -$item['quantity'], $this->requisition_lib->get_stock_source());
            }

            $this->complete();
        } else {
            $data['error'] = $this->lang->line('receivings_error_requisition');

            $this->_reload($data);
        }
    }

    public function receipt($receiving_id) {
        $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
        if (isset($receiving_info['receiving_id'])) {
            $result = $this->Receiving->get_receiving_items($receiving_id)->result_array();
            $received_qty = array();
            foreach ($result as $row) {
                $received_qty[$row['item_id']] = $row['receiving_quantity'];
            }
            $this->requisition_lib->copy_entire_receiving($receiving_id, $receiving_info['po_ref'], $received_qty);
            $data['cart'] = $this->requisition_lib->get_cart();
            //$data['mode'] = $this->requisition_lib->get_mode();
            $data['mode'] = 'receive';
            $data['receipt_mode'] = true;
            $data['receipt_title'] = $this->lang->line('requisition_receipt');
            $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
            $data['show_stock_locations'] = $this->Stock_location->show_locations('grn');
//        $data['payment_type'] = $receiving_info['payment_type'];
            $data['reference'] = $this->requisition_lib->get_reference();
            $data['receiving_id'] = $receiving_info['receiving_ref'];
            $po_info = $this->Receiving->get_info($receiving_info['po_ref'])->row_array();
            $data['stock_order_id'] = $po_info['receiving_ref'];
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
            $employee_info = $this->Employee->get_info($receiving_info['employee_id']);
            $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

            $data['location_name'] = $supplier_id = $this->requisition_lib->get_supplier();
            $supplier_info = '';

            if ($supplier_id != -1) {
                $supplier_info = $this->Stock_location->get_row($supplier_id, 'warehouse');
                $data['location_names'] = $supplier_info['location_name'];
                $data['phone_number'] = $supplier_info['phone_number'];
                if (!empty($supplier_info['zip']) or !empty($supplier_info['city'])) {
                    $data['supplier_location'] = $supplier_info['zip'] . ' ' . $supplier_info['city'];
                } else {
                    $data['supplier_location'] = '';
                }
            }
        } else {
            $data['error_message'] = $this->lang->line('grn_bill_unsuccessfully_updated');
        }
        $data['print_after_sale'] = FALSE;

        $data = $this->xss_clean($data);

        $this->load->view("requisition/receipt", $data);

        $this->requisition_lib->clear_all();
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->requisition_lib->get_cart();
        $po_id = $this->Po->get_element($this->requisition_lib->get_currentid(), array('draft', 'open', 'partially', 'closed', 'void'), 'stock_order');
        $data['stock_order_id'] = $po_id['receiving_ref'];
        
        $data['stock_locations'] = $this->Stock_location->get_allowed_locations('requisition', 'warehouse');
        $data['show_stock_locations'] = count($data['stock_locations']) > 1;
        if ($data['show_stock_locations']) {
            $data['stock_source'] = $this->requisition_lib->get_stock_source('warehouse');
        }
        $data['modes'] = array('receive' => $this->lang->line('receivings_receiving'));
        //$supplier_id = $data['stock_location'] = $this->requisition_lib->get_stock_source('warehouse');
        //$data['stock_locations'] = $this->Stock_location->get_allowed_locations('requisition', 'warehouse');;
        $data['items_module_allowed'] = $this->Employee->has_grant('requisition', $this->Employee->get_logged_in_employee_info()->role_id);
        $data['comment'] = $this->requisition_lib->get_comment();
        $data['print_after_sale'] = $this->requisition_lib->is_print_after_sale();

        $data = $this->xss_clean($data);

        $this->load->view("requisition/receiving", $data);
    }

    public function cancel_receiving() {
        $this->requisition_lib->clear_all();

        $this->_reload();
    }
    
    public function lists() {
        $data['table_headers'] = $this->xss_clean(get_requisition_list());
        $data['item_source'] = '';
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('stockorder_check', 'store');
        $data['supplier'] = $this->Stock_location->get_allowed_locations('requisition', 'warehouse');
        $this->load->view('requisition/manage', $data);
    }

    public function search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'item_location' => $this->input->get('item_location'),
            'supplier' => $this->input->get('supplier')
        );

        $receivings = $this->Po->stock_search($search, $filters, $limit, $offset, $sort, $order,'requisition');
        $total_rows = $this->Po->get_stock_found_rows($search, $filters,'requisition');
        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_requisition_data_row($receiving_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }
    
}

?>
