<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Grn extends Secure_Controller {

    public function __construct() {
        parent::__construct('grn');
        $this->load->library('barcode_lib');
        $this->load->library('grn_lib');
    }

    public function index($po_id = -1) {
        if ($po_id != -1) {
            //$this->grn_lib->set_currentid($po_id);
            $this->grn_lib->clear_all();
            $this->grn_lib->add_item($po_id);
        }
        $this->_reload();
    }

    public function po_search() {
        $warehouse=$this->grn_lib->get_stock_source();
        $where=array(
            'receiving_mode'=>'po',
            'item_location'=>$warehouse,
            'receiving_status'=>array('open', 'partially')   
        );
        $suggestions = $this->Po->get_search_suggestions_items($this->input->get('term'),25,$where);
        $suggestions = $this->xss_clean($suggestions);
        echo json_encode($suggestions);
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
            $this->grn_lib->set_supplier($supplier_id);
        }

        $this->_reload();
    }

    public function change_mode() {
        $stock_destination = $this->input->post('stock_destination');
        $stock_source = $this->input->post('stock_source');
        $this->grn_lib->clear_all();
        if ((!$stock_source || $stock_source == $this->grn_lib->get_stock_source()) &&
                (!$stock_destination || $stock_destination == $this->grn_lib->get_stock_destination())) {
            $this->grn_lib->clear_reference();
            $mode = $this->input->post('mode');
            $this->grn_lib->set_mode($mode);
        } elseif ($this->Stock_location->is_allowed_location($stock_source, 'grn')) {
            $this->grn_lib->set_stock_source($stock_source);
            $this->grn_lib->set_stock_destination($stock_destination);
        }

        $this->_reload();
    }

    public function set_comment() {
        $this->grn_lib->set_comment($this->input->post('comment'));
    }

    public function set_print_after_sale() {
        $this->grn_lib->set_print_after_sale($this->input->post('recv_print_after_sale'));
    }

    public function set_reference() {
        $this->grn_lib->set_reference($this->input->post('recv_reference'));
    }

    public function add() {
        $data = array();

        $mode = $this->grn_lib->get_mode();
        $mode = 'receive';
        $po_id = $this->input->post('item');
        if (!$this->grn_lib->add_item($po_id)) {
            $data['error'] = $this->lang->line('receivings_unable_to_add_item');
        }

        $this->_reload($data);
    }

    public function edit_item($item_id) {
        $data = array();

        $this->form_validation->set_rules('price', 'lang:items_price', 'required|callback_numeric');
        $this->form_validation->set_rules('receiving_quantity', 'lang:grn_receiving_qty', 'required|callback_numeric');
        $this->form_validation->set_rules('requested_quantity', 'lang:grn_requesting_qty', 'required|callback_numeric');
        $this->form_validation->set_rules('discount', 'lang:items_discount', 'required|callback_numeric');

        $description = $this->input->post('description');
        $serialnumber = $this->input->post('serialnumber');
        $price = parse_decimals($this->input->post('price'));
        $receiving_quantity = parse_decimals($this->input->post('receiving_quantity'));
        $requested_quantity = parse_decimals($this->input->post('requested_quantity'));
        $discount = parse_decimals($this->input->post('discount'));
        $item_location = $this->input->post('location');

        if ($this->form_validation->run() != FALSE && ($requested_quantity >= $receiving_quantity && $receiving_quantity > 0)) {
            $this->grn_lib->edit_item($item_id, $description, $serialnumber, $receiving_quantity, $discount, $price);
        } else {
            $data['error'] = $this->lang->line('receivings_error_editing_item');
        }

        $this->_reload($data);
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

        $this->load->view('grn/form', $data);
    }

    public function generate_bill($receiving_id = -1) {
        $list = $this->Grn_modal->get_element($receiving_id, array('draft'));
        if (isset($list['receiving_id'])) {
            $payment_ref = getRefId('BILL', 'receive', array('receiving_status' => 'closed'));
            if ($this->Receiving->update_bill(array('receiving_status' => 'closed', 'payment_status' => 'unpaid', 'payment_ref' => $payment_ref), $receiving_id,$list)) {

                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('grn_bill_successfully_updated'), 'ids' => $receiving_id));
            } else {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('grn_bill_unsuccessfully_updated')));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('grn_bill_unsuccessfully_updated')));
        }
    }

    public function delete_item($item_number) {
        $this->grn_lib->delete_item($item_number);

        $this->_reload();
    }

    public function delete_action($receiving_id = -1) {
        $list = $this->Grn_modal->get_element($receiving_id, array('draft'));
        if (isset($list['receiving_id'])) {
            if ($this->Receiving->update(array('receiving_status' => 'void'), $receiving_id)) {
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('grn_delete_successfully_updated'), 'ids' => $receiving_id));
            } else {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('grn_delete_unsuccessfully_updated')));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('grn_delete_unsuccessfully_updated')));
        }
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

    public function remove_supplier() {
        $this->grn_lib->clear_reference();
        $this->grn_lib->remove_supplier();

        $this->_reload();
    }

    public function complete() {
        $data = array();

        $data['cart'] = $this->grn_lib->get_cart();
        $data['total'] = $this->grn_lib->get_total();
        $data['receipt_title'] = $this->lang->line('grn_receipt');
        $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'));
        //$data['mode'] = $this->grn_lib->get_mode();
        $data['mode'] = 'receive';
        $data['comment'] = $this->grn_lib->get_comment();
        $data['reference'] = $this->grn_lib->get_reference();
//        $data['payment_type'] = $this->input->post('payment_type');
        $data['show_stock_locations'] = $this->Stock_location->show_locations('grn');
        $data['stock_location'] = $this->grn_lib->get_stock_source();
//        if ($this->input->post('amount_tendered') != NULL) {
//            $data['amount_tendered'] = $this->input->post('amount_tendered');
//            $data['amount_change'] = to_currency($data['amount_tendered'] - $data['total']);
//        }

        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $employee_info = $this->Employee->get_info($employee_id);
        $data['employee'] = $employee_info->first_name . ' ' . $employee_info->last_name;

        $supplier_info = '';
        $supplier_id = $this->grn_lib->get_supplier();
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
        $dy_prefix = 'GRN ';
        $po_id = $this->grn_lib->get_currentid();
        //SAVE receiving to database
        //save_grn($items, $supplier_id, $employee_id, $comment,$po_ref, $receiving_id = FALSE, $dy_prefix = 'GRN ')    
        $data['receiving_id'] = getRefId('GRN', 'receive');
        $receiving_id = $this->Receiving->save_grn($data['cart'], $supplier_id, $employee_id, $data['comment'], $po_id, $data['receiving_id']);
        $po_info = $this->Receiving->get_info($po_id)->row_array();
        $data['po_id'] = $po_info['receiving_ref'];
        $data = $this->xss_clean($data);

        if ($receiving_id == '-1') {
            $data['error_message'] = $this->lang->line('receivings_transaction_failed');
        } else {
            InjAuditLog(array(
                'action' => $this->lang->line('grn_register'),
                'ref_text' => $data['receiving_id'],
                'ref_id' => $receiving_id,
                'ref_to' => $supplier_id,
                'url' => uri_string()
            ));
            $data['barcode'] = $this->barcode_lib->generate_receipt_barcode($data['receiving_id']);
        }

        $data['print_after_sale'] = $this->grn_lib->is_print_after_sale();

        $this->load->view("grn/receipt", $data);

        $this->grn_lib->clear_all();
    }

    public function po_complete() {
        if (-1) {
            $this->complete();
        } else {
            $data['error'] = $this->lang->line('receivings_error_requisition');

            $this->_reload($data);
        }
    }

    public function requisition_complete() {
        if ($this->grn_lib->get_stock_source() != $this->grn_lib->get_stock_destination()) {
            foreach ($this->grn_lib->get_cart() as $item) {
                $this->grn_lib->delete_item($item['line']);
                $this->grn_lib->add_item($item['item_id'], $item['quantity'], $this->grn_lib->get_stock_destination());
                $this->grn_lib->add_item($item['item_id'], -$item['quantity'], $this->grn_lib->get_stock_source());
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
            $this->grn_lib->copy_entire_receiving($receiving_id, $receiving_info['po_ref'], $received_qty);
            $data['cart'] = $this->grn_lib->get_cart();
            $data['total'] = $this->grn_lib->get_total();
            //$data['mode'] = $this->grn_lib->get_mode();
            $data['mode'] = 'receive';
            $data['receipt_mode'] = true;
            $data['receipt_title'] = $this->lang->line('grn_receipt');
            $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
            $data['show_stock_locations'] = $this->Stock_location->show_locations('grn');
//        $data['payment_type'] = $receiving_info['payment_type'];
            $data['reference'] = $this->grn_lib->get_reference();
            $data['receiving_id'] = $receiving_info['receiving_ref'];
            $po_info = $this->Receiving->get_info($receiving_info['po_ref'])->row_array();
            $data['po_id'] = $po_info['receiving_ref'];
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
        } else {
            $data['error_message'] = $this->lang->line('grn_bill_unsuccessfully_updated');
        }
        $data['print_after_sale'] = FALSE;

        $data = $this->xss_clean($data);

        $this->load->view("grn/receipt", $data);

        $this->grn_lib->clear_all();
    }

    public function billreceipt($receiving_id) {
        $receiving_info = $this->Grn_modal->get_element($receiving_id, array('closed'));
        if (isset($receiving_info['receiving_id'])) {
            $result = $this->Receiving->get_receiving_items($receiving_id)->result_array();
            $received_qty = array();
            $data['price'] = array();
            foreach ($result as $row) {
                $data['price'][$row['item_id']] = $row['item_cost_price'];
                $received_qty[$row['item_id']] = $row['receiving_quantity'];
            }
            $this->grn_lib->copy_entire_receiving($receiving_id, $receiving_info['po_ref'], $received_qty);
            $data['cart'] = $this->grn_lib->get_cart();
            $data['total'] = $this->grn_lib->get_total();
            $data['mode'] = 'receive';
            $data['receipt_mode'] = true;
            $data['receipt_title'] = $this->lang->line('grn_bill');
            $data['transaction_time'] = date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime($receiving_info['receiving_time']));
            $data['show_stock_locations'] = $this->Stock_location->show_locations('grn');
//        $data['payment_type'] = $receiving_info['payment_type'];
            $data['reference'] = $this->grn_lib->get_reference();
            $data['receiving_id'] = $receiving_info['receiving_ref'];
            $data['payment_ref'] = $receiving_info['payment_ref'];
            $po_info = $this->Receiving->get_info($receiving_info['po_ref'])->row_array();
            $data['po_id'] = $po_info['receiving_ref'];
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
        } else {
            $data['error_message'] = $this->lang->line('grn_bill_unsuccessfully_updated');
        }
        $data['print_after_sale'] = FALSE;

        $data = $this->xss_clean($data);

        $this->load->view("grn/receipt_bill", $data);

        $this->grn_lib->clear_all();
    }

    private function _reload($data = array()) {
        $data['cart'] = $this->grn_lib->get_cart();
        $po_id = $this->Po->get_element($this->grn_lib->get_currentid());
        $data['po_id'] = $po_id['receiving_ref'];
        $data['modes'] = array('receive' => $this->lang->line('receivings_receiving'));
        $data['mode'] = $this->grn_lib->get_mode();

        $data['stock_locations'] = $this->Stock_location->get_allowed_locations('grn', 'warehouse');
        $data['show_stock_locations'] = count($data['stock_locations']) > 1;
        if ($data['show_stock_locations']) {
            $data['modes']['requisition'] = $this->lang->line('receivings_requisition');
            $data['stock_source'] = $this->grn_lib->get_stock_source();
            $data['stock_destination'] = $this->grn_lib->get_stock_destination();
        }

        $data['total'] = $this->grn_lib->get_total();
        $data['items_module_allowed'] = $this->Employee->has_grant('items', $this->Employee->get_logged_in_employee_info()->role_id);
        $data['comment'] = $this->grn_lib->get_comment();
        $data['reference'] = $this->grn_lib->get_reference();
        $data['payment_options'] = $this->Receiving->get_payment_options();

        $supplier_id = $this->grn_lib->get_supplier();
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

        $data['print_after_sale'] = $this->grn_lib->is_print_after_sale();

        $data = $this->xss_clean($data);

        $this->load->view("grn/receiving", $data);
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
        $this->grn_lib->clear_all();

        $this->_reload();
    }

    public function lists() {
        $data['table_headers'] = $this->xss_clean(get_grn_list());
        $data['item_source'] = $this->grn_lib->get_stock_source();
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('grn', 'warehouse');
        $this->load->view('grn/manage', $data);
    }

    public function search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array('start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'item_location' => $this->input->get('item_location')
        );

        $receivings = $this->Po->grn_search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Po->get_grn_found_rows($search, $filters);

        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_grn_data_row($receiving_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function grn_view_details($receiving_id) {
        if (!empty($receiving_id)) {
            $report_data = $this->Grn_modal->getGrnData($receiving_id);
            $data = array(
                'title' => $this->lang->line('grn_view_details'),
                'report_data' => $report_data
            );

            $this->load->view('grn/view_grn', $data);
        }
    }

}

?>
