<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grn_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function get_cart() {
        if (!$this->CI->session->userdata('grn_cart')) {
            $this->set_cart(array());
        }
        return $this->CI->session->userdata('grn_cart');
    }

    public function set_cart($cart_data) {
        $this->CI->session->set_userdata('grn_cart', $cart_data);
    }

    public function empty_cart() {
        $this->CI->session->unset_userdata('grn_cart');
    }

    public function get_supplier() {
        if (!$this->CI->session->userdata('grn_supplier')) {
            $this->set_supplier(-1);
        }
        return $this->CI->session->userdata('grn_supplier');
    }

    public function set_supplier($supplier_id) {
        $this->CI->session->set_userdata('grn_supplier', $supplier_id);
    }

    public function remove_supplier() {
        $this->CI->session->unset_userdata('grn_supplier');
    }

    public function get_mode() {
        if (!$this->CI->session->userdata('grn_mode')) {
            $this->set_mode('receive');
        }
        return $this->CI->session->userdata('grn_mode');
    }

    public function set_mode($mode) {
        $this->CI->session->set_userdata('grn_mode', $mode);
    }

    public function clear_mode() {
        $this->CI->session->unset_userdata('grn_mode');
    }

    public function get_currentid() {
        if (!$this->CI->session->userdata('grn_currentid')) {
            return '';
        }
        return $this->CI->session->userdata('grn_currentid');
    }

    public function set_currentid($po_id) {
        $this->CI->session->set_userdata('grn_currentid', $po_id);
    }

    public function clear_currentid() {
        $this->CI->session->unset_userdata('grn_currentid');
    }

    public function get_stock_source() {
        if (!$this->CI->session->userdata('grn_stock_source')) {
            $this->set_stock_source($this->CI->Stock_location->get_default_location_id('warehouse'));
        }

        return $this->CI->session->userdata('grn_stock_source');
    }

    public function get_comment() {
        // avoid returning a NULL that results in a 0 in the comment if nothing is set/available
        $comment = $this->CI->session->userdata('grn_comment');

        return empty($comment) ? '' : $comment;
    }

    public function set_comment($comment) {
        $this->CI->session->set_userdata('grn_comment', $comment);
    }

    public function clear_comment() {
        $this->CI->session->unset_userdata('grn_comment');
    }

    public function get_reference() {
        return $this->CI->session->userdata('grn_reference');
    }

    public function set_reference($reference) {
        $this->CI->session->set_userdata('grn_reference', $reference);
    }

    public function clear_reference() {
        $this->CI->session->unset_userdata('grn_reference');
    }

    public function is_print_after_sale() {
        return $this->CI->session->userdata('grn_print_after_sale') == 'true' ||
                $this->CI->session->userdata('grn_print_after_sale') == '1';
    }

    public function set_print_after_sale($print_after_sale) {
        return $this->CI->session->set_userdata('grn_print_after_sale', $print_after_sale);
    }

    public function set_stock_source($stock_source) {
        $this->CI->session->set_userdata('grn_stock_source', $stock_source);
    }

    public function clear_stock_source() {
        $this->CI->session->unset_userdata('grn_stock_source');
    }

    public function get_stock_destination() {
        if (!$this->CI->session->userdata('grn_stock_destination')) {
            $this->set_stock_destination($this->CI->Stock_location->get_default_location_id('warehouse'));
        }

        return $this->CI->session->userdata('grn_stock_destination');
    }

    public function set_stock_destination($stock_destination) {
        $this->CI->session->set_userdata('grn_stock_destination', $stock_destination);
    }

    public function clear_stock_destination() {
        $this->CI->session->unset_userdata('grn_stock_destination');
    }

    public function add_item($po_id, $received_qty = '') {
        //make sure item exists in database.
        if (!$this->CI->Po->exists($po_id, array('draft', 'open', 'partially', 'closed', 'void'))) {
            return FALSE;
        }
        $po_list = $this->CI->Po->get_po_items($po_id, array('draft', 'open', 'partially', 'closed', 'void'));
        if (!$po_list) {
            return FALSE;
        } else {
            $this->empty_cart();
            $this->set_currentid($po_id);
            foreach ($po_list as $key => $value) {
                if ($value['balance_quantity'] > 0) {
                    //Get items in the receiving so far.
                    $items = $this->get_cart();
                    $this->set_supplier($value['supplier_id']);
                    //We need to loop through all items in the cart.
                    //If the item is already there, get it's key($updatekey).
                    //We also need to get the next key that we are going to use in case we need to add the
                    //item to the list. Since items can be deleted, we can't use a count. we use the highest key + 1.

                    $maxkey = 0;     //Highest key so far
                    $itemalreadyinsale = FALSE;  //We did not find the item yet.
                    $insertkey = 0;     //Key to use for new entry.
                    $updatekey = 0;     //Key to use to update(quantity)

                    foreach ($items as $item) {
                        //We primed the loop so maxkey is 0 the first time.
                        //Also, we have stored the key in the element itself so we can compare.
                        //There is an array public function to get the associated key for an element, but I like it better
                        //like that!

                        if ($maxkey <= $item['line']) {
                            $maxkey = $item['line'];
                        }

                        if ($item['item_id'] == $value['item_id'] && $item['item_location'] == $value['item_location']) {
                            $itemalreadyinsale = TRUE;
                            $updatekey = $item['line'];
                        }
                    }

                    $insertkey = $maxkey + 1;
                    $item_info = $this->CI->Item->get_info($value['item_id'], $value['item_location']);
                    //array records are identified by $insertkey and item_id is just another field.
                    $price = $item_info->cost_price;
                    $item = array($insertkey => array(
                            'item_id' => $value['item_id'],
                            'item_location' => $value['item_location'],
                            'stock_name' => $this->CI->Stock_location->get_location_name($value['item_location']),
                            'line' => $insertkey,
                            'name' => $item_info->name,
                            'description' => $item_info->description,
                            'serialnumber' => '',
                            'allow_alt_description' => $item_info->allow_alt_description,
                            'is_serialized' => $item_info->is_serialized,
                            'quantity' => 1,
                            'requested_quantity' => $value['request_quantity'],
                            'balance_quantity' => $value['balance_quantity'],
                            'received_quantity' => $value['request_quantity'] - $value['balance_quantity'],
                            'discount' => 0,
                            'in_stock' => $this->CI->Item_quantity->get_item_quantity($value['item_id'], $value['item_location'])->quantity,
                            'price' => $price,
                            'receiving_quantity' => ($received_qty != '') ? $received_qty[$value['item_id']] : $value['balance_quantity'],
                            'total' => $this->get_item_total($value['request_quantity'], 0, 0)
                        )
                    );

                    //Item already exists
                    if ($itemalreadyinsale) {
                        $items[$updatekey]['quantity'] = $value['request_quantity'];
                        $items[$updatekey]['total'] = $this->get_item_total($items[$updatekey]['quantity'], 0, 0);
                    } else {
                        //add to existing array
                        $items += $item;
                    }

                    $this->set_cart($items);
                }
            }
        }


        return TRUE;
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
        $this->clear_mode();
        $this->clear_currentid();
        $this->empty_cart();
        $this->remove_supplier();
        $this->clear_comment();
        $this->clear_stock_source();
        $this->clear_stock_destination();
        $this->clear_reference();
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
            $total = bcadd($total, $this->get_item_total($item['quantity'], $item['price'], $item['discount']));
        }

        return $total;
    }

}

?>