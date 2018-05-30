<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pay_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function get_cart() {
        if (!$this->CI->session->userdata('pay_cart')) {
            $this->set_cart(array());
        }
        return $this->CI->session->userdata('pay_cart');
    }

    public function set_cart($cart_data) {
        $this->CI->session->set_userdata('pay_cart', $cart_data);
    }

    public function empty_cart() {
        $this->CI->session->unset_userdata('pay_cart');
    }

    public function get_supplier() {
        if (!$this->CI->session->userdata('pay_supplier')) {
            $this->set_supplier(-1);
        }
        return $this->CI->session->userdata('pay_supplier');
    }

    public function set_supplier($supplier_id) {
        if ($supplier_id < 1) {
            $this->CI->session->set_userdata('pay_supplier', $this->CI->Supplier->get_to_pay_supplier_id());
        } else {
            $this->CI->session->set_userdata('pay_supplier', $supplier_id);
        }
    }

    public function remove_supplier() {
        $this->CI->session->unset_userdata('pay_supplier');
    }

    public function get_currentid() {
        if (!$this->CI->session->userdata('pay_currentid')) {
            return '';
        }
        return $this->CI->session->userdata('pay_currentid');
    }

    public function set_currentid($po_id) {
        $this->CI->session->set_userdata('pay_currentid', $po_id);
    }

    public function clear_currentid() {
        $this->CI->session->unset_userdata('pay_currentid');
    }

    public function get_stock_source() {
        if (!$this->CI->session->userdata('pay_stock_source')) {
            $this->set_stock_source($this->CI->Stock_location->get_default_location_id('warehouse'));
        }

        return $this->CI->session->userdata('pay_stock_source');
    }

    public function get_comment() {
        // avoid returning a NULL that results in a 0 in the comment if nothing is set/available
        $comment = $this->CI->session->userdata('pay_comment');

        return empty($comment) ? '' : $comment;
    }

    public function set_comment($comment) {
        $this->CI->session->set_userdata('pay_comment', $comment);
    }

    public function clear_comment() {
        $this->CI->session->unset_userdata('pay_comment');
    }

    public function get_reference() {
        return $this->CI->session->userdata('pay_reference');
    }

    public function set_reference($reference) {
        $this->CI->session->set_userdata('pay_reference', $reference);
    }

    public function clear_reference() {
        $this->CI->session->unset_userdata('pay_reference');
    }
    
    public function get_currency() {
        if (!$this->CI->session->userdata('pay_currency')) {
            $currency = $this->CI->Bills->getCurrency(array('base_currency' => '1'));
            $this->set_currency((isset($currency['currency_id'])) ? $currency['currency_id'] : '1');
        }
        return $this->CI->session->userdata('pay_currency');
    }

    public function set_currency($reference) {
        $this->CI->session->set_userdata('pay_currency', $reference);
    }

    public function clear_currency() {
        $this->CI->session->unset_userdata('pay_currency');
    }

    public function is_print_after_sale() {
        return $this->CI->session->userdata('pay_print_after_sale') == 'true' ||
                $this->CI->session->userdata('pay_print_after_sale') == '1';
    }

    public function set_print_after_sale($print_after_sale) {
        return $this->CI->session->set_userdata('pay_print_after_sale', $print_after_sale);
    }

    public function set_stock_source($stock_source) {
        $this->CI->session->set_userdata('pay_stock_source', $stock_source);
    }

    public function clear_stock_source() {
        $this->CI->session->unset_userdata('pay_stock_source');
    }

    public function get_stock_destination() {
        if (!$this->CI->session->userdata('pay_stock_destination')) {
            $this->set_stock_destination($this->CI->Stock_location->get_default_location_id());
        }

        return $this->CI->session->userdata('pay_stock_destination');
    }

    public function set_stock_destination($stock_destination) {
        $this->CI->session->set_userdata('pay_stock_destination', $stock_destination);
    }

    public function clear_stock_destination() {
        $this->CI->session->unset_userdata('pay_stock_destination');
    }

    public function add_bill($bill_id) {
        $bill_list = $this->CI->Grn_modal->get_bill($bill_id, array('closed'));
        if (!$bill_list) {
            return FALSE;
        } else {
            $this->set_currentid($bill_id);
            foreach ($bill_list as $key => $value) {
                //Get items in the receiving so far.
                $items = $this->get_cart();
                $this->set_supplier($value['supplier_id']);
                $maxkey = 0;     //Highest key so far
                $itemalreadyinsale = FALSE;  //We did not find the item yet.
                $insertkey = 0;     //Key to use for new entry.
                $updatekey = 0;     //Key to use to update(quantity)

                foreach ($items as $item) {
                    if ($maxkey <= $item['line']) {
                        $maxkey = $item['line'];
                    }
                    if ($item['receiving_id'] == $value['receiving_id']) {
                        $itemalreadyinsale = TRUE;
                    }
                }

                $insertkey = $maxkey + 1;
                
                $already_paid_amount = $this->already_paid_amount($value);
                $item = array(  $insertkey => array(
                        'payment_ref' => $value['payment_ref'],
                        'receiving_id' => $value['receiving_id'],
                        'line' => $insertkey,
                        'total_quantity' => $value['quantity'],
                        'totl_billcost' => $value['cost'] - $already_paid_amount,
                        'costperqty' => $value['costperqty'],
                        'supplier_id' => $value['supplier_id'],
                        'item_location' => $this->CI->Stock_location->get_location_name($value['item_location']),
                        'sending_quantity' => $value['quantity'],
                        'sending_price' => $value['cost'] - $already_paid_amount,
                        'total' => $value['cost']
                    ));
                if (!$itemalreadyinsale) {
                    $items += $item;
                    $this->set_cart($items);
                }
            }
        }
        return TRUE;
    }

    public function already_paid_amount($value = array()) {
        $this->CI->db->select('sum(amount) as amount');
        $this->CI->db->from('recpayment_made_receivings');
        $this->CI->db->where_in('receivings_id', $value['receiving_id']);
        $paid = $this->CI->db->get()->row();
        return $paid->amount;
    }

    public function edit_bill($line, $sending_quantity, $price) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $line = &$items[$line];
            $line['sending_quantity'] = $sending_quantity;
            $line['sending_price'] = $price;
            $line['total'] = $price;
            $this->set_cart($items);
        }

        return FALSE;
    }

    public function edit_item($line, $description, $serialnumber, $receiving_quantity, $discount, $price) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $line = &$items[$line];
            $line['description'] = $description;
            $line['serialnumber'] = $serialnumber;
            $line['receiving_quantity'] = $receiving_quantity;
            $line['discount'] = $discount;
            $line['price'] = $price;
            $line['total'] = $this->get_item_total($receiving_quantity, $price, $discount);
            $this->set_cart($items);
        }

        return FALSE;
    }

    public function delete_item($line) {
        $items = $this->get_cart();
        unset($items[$line]);
        $this->set_cart($items);
    }

    public function return_entire_receiving($receipt_receiving_id) {
        //RECV #
        $pieces = explode(' ', $receipt_receiving_id);
        if (preg_match("/(RECV|KIT)/", $pieces[0])) {
            $receiving_id = $pieces[1];
        } else {
            $receiving_id = $this->CI->Receiving->get_receiving_by_reference($receipt_receiving_id)->row()->receiving_id;
        }

        $this->empty_cart();
        $this->remove_supplier();
        $this->clear_comment();

        foreach ($this->CI->Receiving->get_receiving_items($receiving_id)->result() as $row) {
            $this->add_item($row->item_id, -$row->quantity_purchased, $row->item_location, $row->discount_percent, $row->item_unit_price, $row->description, $row->serialnumber, $row->receiving_quantity, TRUE);
        }

        $this->set_supplier($this->CI->Receiving->get_supplier($receiving_id)->person_id);
    }

    public function add_item_kit($external_item_kit_id, $item_location) {
        //KIT #
        $pieces = explode(' ', $external_item_kit_id);
        $item_kit_id = $pieces[1];

        foreach ($this->CI->Item_kit_items->get_info($item_kit_id) as $item_kit_item) {
            $this->add_item($item_kit_item['item_id'], $item_kit_item['quantity'], $item_location);
        }
    }

    public function copy_entire_receiving($receiving_id, $po_id, $received_qty) {
        $this->empty_cart();
        $this->remove_supplier();
        $this->add_item($po_id, $received_qty);
        //$this->set_reference($this->CI->Receiving->get_info($receiving_id)->row()->reference);
    }

    public function clear_all() {
        $this->clear_currentid();
        $this->empty_cart();
        $this->remove_supplier();
        $this->clear_comment();
        $this->clear_reference();
        $this->clear_currency();
    }

    public function get_item_total($quantity, $price, $discount_percentage) {
        $total = bcmul($quantity, $price);
        $discount_fraction = bcdiv($discount_percentage, 100);
        $discount_amount = bcmul($total, $discount_fraction);

        return bcsub($total, $discount_amount);
    }

    public function get_total() {
        $total = 0;
        foreach ($this->get_cart() as $item) {
            $total += $item['sending_price'];
        }

        return $total;
    }

}

?>
