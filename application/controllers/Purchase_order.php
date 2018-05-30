<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Purchase_order extends Secure_Controller {

    public function __construct() {
        parent::__construct('purchase_order');

        $this->load->library('receiving_lib');
        $this->load->library('barcode_lib');
    }

    public function index($receiving_id = -1) {
        if ($receiving_id != -1) {
            $this->receiving_lib->clear_all();
            $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
            $receiving_items = $this->Po->get_po_items($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'));
            $this->receiving_lib->set_supplier($receiving_info['supplier_id']);
            foreach ($receiving_items as $key => $value) {
                $this->receiving_lib->add_item($value['item_id'], $value['request_quantity'], $value['item_location']);
            }
        }
        $this->_reload();
    }

    public function item_search() {
        $suggestions = $this->Item->get_search_suggestions($this->input->get('term'), array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);
        $suggestions = array_merge($suggestions, $this->Item_kit->get_search_suggestions($this->input->get('term')));

        $suggestions = $this->xss_clean($suggestions);

        echo json_encode($suggestions);
    }

    public function stock_item_search() {
        $suggestions = $this->Item->get_stock_search_suggestions($this->input->get('term'), array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);
        $suggestions = array_merge($suggestions, $this->Item_kit->get_search_suggestions($this->input->get('term')));

        $suggestions = $this->xss_clean($suggestions);

        echo json_encode($suggestions);
    }

    public function select_supplier() {
        $supplier_id = $this->input->post('supplier');
        if ($this->Supplier->exists($supplier_id)) {
            $this->receiving_lib->set_supplier($supplier_id);
        }

        $this->_reload();
    }

    public function set_comment() {
        $this->receiving_lib->set_comment($this->input->post('comment'));
    }

    public function set_print_after_sale() {
        $this->receiving_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function set_receiving_status() {
        $this->receiving_lib->set_receiving_status($this->input->post('receiving_status'));
    }
    
    public function set_reference() {
        $this->receiving_lib->set_reference($this->input->post('recv_reference'));
    }

    public function add() {
        $data = array();

        $mode = $this->receiving_lib->get_mode();
        $item_id_or_number_or_item_kit_or_receipt = $this->input->post('item');
        $quantity = ($mode == 'receive' || $mode == 'requisition') ? 1 : -1;
        $item_location = $this->receiving_lib->get_stock_source('warehouse');
        if ($mode == 'return' && $this->Receiving->is_valid_receipt($item_id_or_number_or_item_kit_or_receipt)) {
            $this->receiving_lib->return_entire_receiving($item_id_or_number_or_item_kit_or_receipt);
        } elseif ($this->Item_kit->is_valid_item_kit($item_id_or_number_or_item_kit_or_receipt)) {
            $this->receiving_lib->add_item_kit($item_id_or_number_or_item_kit_or_receipt, $item_location);
        } elseif (!$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity, $item_location)) {
            $data['error'] = $this->lang->line('receivings_unable_to_add_item');
        }

        $this->_reload($data);
    }

    public function edit_item($item_id) {
        $data = array();

        $this->form_validation->set_rules('price', 'lang:items_price', 'required|callback_numeric');
        $this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|callback_numeric');
        $this->form_validation->set_rules('discount', 'lang:items_discount', 'required|callback_numeric');

        $description = $this->input->post('description');
        $serialnumber = $this->input->post('serialnumber');
        $price = parse_decimals($this->input->post('price'));
        $quantity = parse_decimals($this->input->post('quantity'));
        $discount = parse_decimals($this->input->post('discount'));
        $item_location = $this->input->post('location');

        if ($this->form_validation->run() != FALSE) {
            $this->receiving_lib->edit_item($item_id, $description, $serialnumber, $quantity, $discount, $price);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }

        $this->_reload($data);
    }

    public function change_mode() {
        $stock_destination = $this->input->post('stock_destination');
        $stock_source = $this->input->post('stock_source');
        $this->receiving_lib->clear_all();
        if ((!$stock_source || $stock_source == $this->receiving_lib->get_stock_source()) &&
                (!$stock_destination || $stock_destination == $this->receiving_lib->get_stock_destination())) {
            $this->receiving_lib->clear_reference();
            $mode = 'po';
            $this->receiving_lib->set_mode($mode);
        } elseif ($this->Stock_location->is_allowed_location($stock_source, 'purchase_order')) {
            $this->receiving_lib->set_stock_source($stock_source);
            $this->receiving_lib->set_stock_destination($stock_destination);
        }

        $this->_reload();
    }

    public function edit($receiving_id) {
        $data = array();

        $data['suppliers'] = array('' => 'No Supplier');
        foreach ($this->Supplier->get_all()->result() as $supplier) {
            $data['suppliers'][$supplier->person_id] = $this->xss_clean($supplier->first_name . ' ' . $supplier->last_name);
        }

        $data['employees'] = array();
        foreach ($this->Employee->get_all()->result() as $employee) {
            $data['employees'][$employee->person_id] = $this->xss_clean($employee->first_name . ' ' . $employee->last_name);
        }

        $receiving_info = $this->xss_clean($this->Receiving->get_info($receiving_id)->row_array());
        $data['selected_supplier_name'] = !empty($receiving_info['supplier_id']) ? $receiving_info['company_name'] : '';
        $data['selected_supplier_id'] = $receiving_info['supplier_id'];
        $data['receiving_info'] = $receiving_info;

        $this->load->view('purchase_order/form', $data);
    }

    public function delete_item($item_number) {
        $this->receiving_lib->delete_item($item_number);

        $this->_reload();
    }

    public function delete($receiving_id = -1, $update_inventory = TRUE) {
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $receiving_ids = $receiving_id == -1 ? $this->input->post('ids') : array($receiving_id);

        if ($this->Receiving->delete_list($receiving_ids, $employee_id, $update_inventory)) {
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('receivings_successfully_deleted') . ' ' .
                count($receiving_ids) . ' ' . $this->lang->line('receivings_one_or_multiple'), 'ids' => $receiving_ids));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('receivings_cannot_be_deleted')));
        }
    }

    public function delete_action($receiving_id = -1) {
        $list = $this->Po->get_element($receiving_id, array('draft'));
        if (isset($list['receiving_id'])) {
            if ($this->Receiving->update(array('receiving_status' => 'void'), $receiving_id)) {
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('po_delete_successfully_updated'), 'ids' => $receiving_id));
            } else {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('po_delete_unsuccessfully_updated')));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('po_delete_unsuccessfully_updated')));
        }
    }

    public function remove_supplier() {
        $this->receiving_lib->clear_reference();
        $this->receiving_lib->remove_supplier();

        $this->_reload();
    }

    public function complete() {
        $data = array();

        $data['cart'] = $this->receiving_lib->get_cart();
        $data['total'] = $this->receiving_lib->get_total();

        $data['receipt_title'] = $this->lang->line('po_receipt');
        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'));
        //$data['mode'] = $this->receiving_lib->get_mode();
        $data['mode'] = 'po';
        $data['comment'] = $this->receiving_lib->get_comment();
        $data['receiving_status'] = $this->input->post('receiving_status');
        //$data['reference'] = $this->receiving_lib->get_reference();
        //$data['payment_type'] = $this->input->post('payment_type');
        $data['show_stock_locations'] = $this->Stock_location->show_locations('po');
        $data['stock_location'] = $this->receiving_lib->get_stock_source();
//        if ($this->input->post('amount_tendered') != NULL) {
//            $data['amount_tendered'] = $this->input->post('amount_tendered');
//            $data['amount_change'] = to_currency($data['amount_tendered'] - $data['total']);
//        }

        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $employee_info = $this->Employee->get_info($employee_id);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $supplier_info = '';
        $supplier_id = $this->receiving_lib->get_supplier();
        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $supplier_info->company_name;
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
        $dy_prefix = 'PO ';
        $data['receiving_id'] = getRefId('PO', 'po');
        $receiving_id = $this->Receiving->savepo($data['cart'], $supplier_id, $employee_id, $data['comment'], $data['mode'], $data['receiving_status'], $data['receiving_id']);

        $data = $this->xss_clean($data);

        if ($receiving_id == '-1') {
            $data['error_message'] = $this->lang->line('po_transaction_failed');
        } else {
            InjAuditLog(array(
                'action' => $this->lang->line('po_register'),
                'ref_text' => $data['receiving_id'],
                'ref_id' => $receiving_id,
                'ref_to' => $supplier_id,
                'url' => uri_string()
            ));
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        }

        $data['print_after_sale'] = $this->receiving_lib->is_print_after_sale();

        $this->load->view("purchase_order/receipt", $data);

        $this->receiving_lib->clear_all();
    }

    public function po_complete() {
        if (-1) {
            $this->complete();
        } else {
            $data['error'] = $this->lang->line('receivings_error_requisition');

            $this->_reload($data);
        }
    }

    public function statuschange($receiving_id = -1) {
        $data = array();
        $data['status_list'] = array(
            'draft' => $this->lang->line('po_draft'),
            'open' => $this->lang->line('po_open'),
            'partially' => $this->lang->line('po_partially'),
            'closed' => $this->lang->line('po_closed'),
            'void' => $this->lang->line('po_void')
        );
        if ($receiving_id != -1) {
            $data['list'] = $this->Po->get_element($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'));
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
        $this->load->view("purchase_order/form_statuschage", $data);
    }

    public function save_status($receiving_id = -1) {
        $data = array();
        $this->form_validation->set_rules('receiving_status', 'lang:po_statuschange', 'required');
        if ($this->form_validation->run() != FALSE) {
            if ($receiving_id != -1) {
                $data['list'] = $this->Receiving->update(array('receiving_status' => $_POST['receiving_status']), $receiving_id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('purchase_order_statuschange_success'), 'ids' => $receiving_id));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('purchase_order_statuschange_error')));
        }
    }

    public function requisition_complete() {
        if ($this->receiving_lib->get_stock_source() != $this->receiving_lib->get_stock_destination()) {
            foreach ($this->receiving_lib->get_cart() as $item) {
                $this->receiving_lib->delete_item($item['line']);
                $this->receiving_lib->add_item($item['item_id'], $item['quantity'], $this->receiving_lib->get_stock_destination());
                $this->receiving_lib->add_item($item['item_id'], -$item['quantity'], $this->receiving_lib->get_stock_source());
            }

            $this->complete();
        } else {
            $data['error'] = $this->lang->line('receivings_error_requisition');

            $this->_reload($data);
        }
    }

    public function receipt($receiving_id) {
        $receiving_info = $this->Receiving->get_info($receiving_id)->row_array();
        $receiving_items = $this->Po->get_po_items($receiving_id, array('draft', 'open', 'partially', 'closed', 'void'));
        foreach ($receiving_items as $key => $value) {
            $this->receiving_lib->add_item($value['item_id'], $value['request_quantity'], $value['item_location']);
        }
        //$this->receiving_lib->copy_entire_receiving($receiving_id);
        //$this->receiving_lib->add_item($item_id_or_number_or_item_kit_or_receipt, $quantity, $item_location)
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['total'] = $this->receiving_lib->get_total();
        $data['mode'] = 'po';
        $data['receipt_title'] = $this->lang->line('po_receipt');

        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
        $data['show_stock_locations'] = $this->Stock_location->show_locations('po');
        $data['stock_location'] = $this->receiving_lib->get_stock_source();
        //pr($receiving_info);
        //$data['payment_type'] = $receiving_info['payment_type'];
        //$data['reference'] = $this->receiving_lib->get_reference();
        $data['receiving_id'] = $receiving_info['receiving_ref'];
        $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        $employee_info = $this->Employee->get_info($receiving_info['employee_id']);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $supplier_id = $receiving_info['supplier_id'];
        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $supplier_info->company_name;
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

        $data['print_after_sale'] = FALSE;
        $data['from_receipt'] = 1;

        $data = $this->xss_clean($data);

        $this->load->view("purchase_order/receipt", $data);

        $this->receiving_lib->clear_all();
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->receiving_lib->get_cart();
        $data['modes'] = array('po' => $this->lang->line('receivings_po'), 'receive' => $this->lang->line('receivings_receiving'), 'return' => $this->lang->line('receivings_return'));
        $data['mode'] = 'po';
        $data['stock_locations'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data['show_stock_locations'] = count($data['stock_locations']) > 1;
        if ($data['show_stock_locations']) {
            $data['modes']['requisition'] = $this->lang->line('receivings_requisition');
            $data['stock_source'] = $this->receiving_lib->get_stock_source('warehouse');
            $data['stock_destination'] = $this->receiving_lib->get_stock_destination('warehouse');
        }
        $data['receiving_status'] = $this->receiving_lib->get_receiving_status();
        $data['total'] = $this->receiving_lib->get_total();
        $data['items_module_allowed'] = $this->Employee->has_grant('items', $this->Employee->get_logged_in_employee_info()->role_id);
        $data['comment'] = $this->receiving_lib->get_comment();
        $data['reference'] = $this->receiving_lib->get_reference();
        $data['payment_options'] = $this->Receiving->get_payment_options();

        $supplier_id = $this->receiving_lib->get_supplier();
        $supplier_info = '';
        if ($supplier_id != -1) {
            $supplier_info = $this->Supplier->get_info($supplier_id);
            $data['supplier'] = $supplier_info->company_name;
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

        $data['print_after_sale'] = $this->receiving_lib->is_print_after_sale();

        $data = $this->xss_clean($data);

        $this->load->view("purchase_order/receiving", $data);
    }

    public function save($receiving_id = -1) {
        $newdate = $this->input->post('date');

        $date_formatter = date_create_from_format($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), $newdate);

        $receiving_data = array(
            'receiving_time' => $date_formatter->format('Y-m-d H:i:s'),
            'supplier_id' => $this->input->post('supplier_id') ? $this->input->post('supplier_id') : NULL,
            'employee_id' => $this->input->post('employee_id'),
            'comment' => $this->input->post('comment'),
            'reference' => $this->input->post('reference') != '' ? $this->input->post('reference') : NULL
        );

        if ($this->Receiving->update($receiving_data, $receiving_id)) {
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('receivings_successfully_updated'), 'id' => $receiving_id));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('receivings_unsuccessfully_updated'), 'id' => $receiving_id));
        }
    }

    public function cancel_receiving() {
        $this->receiving_lib->clear_all();

        $this->_reload();
    }

    public function lists() {
        $data['table_headers'] = $this->xss_clean(get_procurement_list());
        $data['item_source'] = $this->receiving_lib->get_stock_source();
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $data['receiving_default'] = '';
        $data['receiving_status'] = array('draft' => 'Draft', 'open' => 'Open', 'partially' => 'Partially', 'closed' => 'Closed', 'void' => 'Void');
        $this->load->view('purchase_order/manage', $data);
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


        $receivings = $this->Po->po_search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Po->get_po_found_rows($search, $filters);

        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_procurement_data_row($receiving_row, $this);
        }
        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function po_view_details($receiving_id) {
        if (!empty($receiving_id)) {            
            $report_data = $this->Po->getPoData($receiving_id);  
            $data = array(
                'title' => $this->lang->line('po_view_details'), 
                'report_data' => $report_data
            );

            $this->load->view('purchase_order/view_po', $data);
        }
    }

}

?>
