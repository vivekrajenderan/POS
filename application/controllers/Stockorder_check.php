<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Stockorder_check extends Secure_Controller {

    public function __construct() {
        parent::__construct('stockorder_check');
        $this->load->library('barcode_lib');
        $this->load->library('stockordercheck_lib');
    }

    public function index() {
        $this->_reload();
    }

    public function change_mode() {
        $this->stockordercheck_lib->clear_all();
        $stock_source = $this->input->post('store');
        $this->stockordercheck_lib->set_stock_source($stock_source);
        $this->_reload();
    }

    public function stock_order_search() {
        $iteml_location = $this->stockordercheck_lib->get_stock_source();
        $where=array(
            'receiving_mode'=>'requisition',
            'item_location'=>$iteml_location,
            'receiving_status'=>array('open', 'partially')   
        );
        $suggestions = $this->Po->get_search_suggestions_items($this->input->get('term'),25,$where);
        $suggestions = $this->xss_clean($suggestions);
        echo json_encode($suggestions);
    }

    public function select_supplier() {
        $supplier_id = $this->input->post('supplier');
        if ($this->Supplier->exists($supplier_id)) {
            $this->stockordercheck_lib->set_supplier($supplier_id);
        }

        $this->_reload();
    }

    public function set_comment() {
        $this->stockordercheck_lib->set_comment($this->input->post('comment'));
    }

    public function set_print_after_sale() {
        $this->stockordercheck_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function add() {
        $data = array();
        $mode = 'requisition';
        $stock_order_id = $this->input->post('item');
        if (!$this->stockordercheck_lib->add_item($stock_order_id)) {
            $data['error'] = $this->lang->line('stockordercheck_unable_to_req_ref');
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
            $this->stockordercheck_lib->edit_item($item_id, $receiving_quantity);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }

        $this->_reload($data);
    }

    public function delete_item($item_number) {
        $this->stockordercheck_lib->delete_item($item_number);

        $this->_reload();
    }

    public function remove_supplier() {
        $this->stockordercheck_lib->clear_reference();
        $this->stockordercheck_lib->remove_supplier();

        $this->_reload();
    }

    public function complete() {
        $data = array();

        $data['cart'] = $this->stockordercheck_lib->get_cart();
        $data['receipt_title'] = $this->lang->line('stockordercheck_receipt');
        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'));
        $data['mode'] = 'requisition';
        $data['comment'] = $this->stockordercheck_lib->get_comment();
        $data['stock_location'] = $this->stockordercheck_lib->get_stock_source();

        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $employee_info = $this->Employee->get_info($employee_id);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $data['location_name'] = $supplier_id = $this->stockordercheck_lib->get_supplier();
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

        $dy_prefix = 'SOC ';
        $stock_order_id = $this->stockordercheck_lib->get_currentid();
        //SAVE receiving to database
        $data['receiving_id'] = getRefId('SOC', 'stockorder_check');
        $receiving_id = $this->Receiving->save_soc($data['cart'], $supplier_id, $employee_id, $data['comment'], $stock_order_id, $data['receiving_id']);
        $po_id = $this->Po->get_element($this->stockordercheck_lib->get_currentid(), array('draft', 'open', 'partially', 'closed', 'void'), 'requisition');
        $data['stock_order_id'] = $po_id['receiving_ref'];
        $data = $this->xss_clean($data);

        if ($receiving_id == '-1') {
            $data['error_message'] = $this->lang->line('receivings_transaction_failed');
        } else {
            InjAuditLog(array(
                'action' => $this->lang->line('stockordercheck_register'),
                'ref_text' => $data['receiving_id'],
                'ref_id' => $receiving_id,
                'ref_to' => $supplier_id,
                'url' => uri_string()
            ));
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        }

        $data['print_after_sale'] = $this->stockordercheck_lib->is_print_after_sale();

        $this->load->view("stockorder_check/receipt", $data);

        $this->stockordercheck_lib->clear_all();
    }

    public function requisition_complete() {
        if ($this->stockordercheck_lib->get_stock_source() != $this->stockordercheck_lib->get_stock_destination()) {
            foreach ($this->stockordercheck_lib->get_cart() as $item) {
                $this->stockordercheck_lib->delete_item($item['line']);
                $this->stockordercheck_lib->add_item($item['item_id'], $item['quantity'], $this->stockordercheck_lib->get_stock_destination());
                $this->stockordercheck_lib->add_item($item['item_id'], -$item['quantity'], $this->stockordercheck_lib->get_stock_source());
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
            $this->stockordercheck_lib->copy_entire_receiving($receiving_id, $receiving_info['po_ref'], $received_qty);
            $data['cart'] = $this->stockordercheck_lib->get_cart();
            //$data['mode'] = $this->stockordercheck_lib->get_mode();
            $data['mode'] = 'receive';
            $data['receipt_mode'] = true;
            $data['receipt_title'] = $this->lang->line('stockordercheck_receipt');
            $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
            $data['show_stock_locations'] = $this->Stock_location->show_locations('grn');
//        $data['payment_type'] = $receiving_info['payment_type'];
            $data['reference'] = $this->stockordercheck_lib->get_reference();
            $data['receiving_id'] = $receiving_info['receiving_ref'];
            $po_info = $this->Receiving->get_info($receiving_info['po_ref'])->row_array();
            $data['stock_order_id'] = $po_info['receiving_ref'];
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
            $employee_info = $this->Employee->get_info($receiving_info['employee_id']);
            $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;
            $data['location_name'] = $supplier_id = $this->stockordercheck_lib->get_supplier();
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
        } else {
            $data['error_message'] = $this->lang->line('grn_bill_unsuccessfully_updated');
        }
        $data['print_after_sale'] = FALSE;

        $data = $this->xss_clean($data);

        $this->load->view("stockorder_check/receipt", $data);

        $this->stockordercheck_lib->clear_all();
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->stockordercheck_lib->get_cart();
        $po_id = $this->Po->get_element($this->stockordercheck_lib->get_currentid(), array('draft', 'open', 'partially', 'closed', 'void'), 'requisition');
        $data['stock_order_id'] = $po_id['receiving_ref'];
        $data['modes'] = array('receive' => $this->lang->line('receivings_receiving'));
        $supplier_id = $data['stock_location'] = $this->stockordercheck_lib->get_stock_source();
        //$data['stock_locations'] = $this->Stock_location->get_allowed_locations('requisition', 'warehouse');;
        $data['items_module_allowed'] = $this->Employee->has_grant('requisition', $this->Employee->get_logged_in_employee_info()->role_id);

        $data['comment'] = $this->stockordercheck_lib->get_comment();

        $data['store_locations'] = $this->Stock_location->get_allowed_locations('stockorder_check', 'store');
        $data['show_store_locations'] = count($data['store_locations']) > 1;
        if ($data['show_store_locations']) {
            $data['stock_source'] = $this->stockordercheck_lib->get_stock_source();
        }

        $data['print_after_sale'] = $this->stockordercheck_lib->is_print_after_sale();

        $data = $this->xss_clean($data);

        $this->load->view("stockorder_check/receiving", $data);
    }

    public function cancel_receiving() {
        $this->stockordercheck_lib->clear_all();

        $this->_reload();
    }
    public function lists() {
        $data['table_headers'] = $this->xss_clean(get_soc_list());
        $data['item_source'] = '';
        $data['item_source'] = '';
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('stockorder_check', 'store');
        $data['supplier'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $this->load->view('stockorder_check/manage', $data);
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

        $receivings = $this->Po->stock_search($search, $filters, $limit, $offset, $sort, $order,'stockorder_check');
        $total_rows = $this->Po->get_stock_found_rows($search, $filters,'stockorder_check');
        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_soc_data_row($receiving_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }
}

?>
