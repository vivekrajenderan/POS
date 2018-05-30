<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock_order_lib {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function get_cart() {
        if (!$this->CI->session->userdata('SO_cart')) {
            $this->set_cart(array());
        }
        return $this->CI->session->userdata('SO_cart');
    }

    public function set_cart($cart_data) {
        $this->CI->session->set_userdata('SO_cart', $cart_data);
    }

    public function empty_cart() {
        $this->CI->session->unset_userdata('SO_cart');
    }

    public function get_receiving_status() {
        if (!$this->CI->session->userdata('SO_receiving_status')) {
            $this->set_receiving_status('draft');
        }
        return $this->CI->session->userdata('SO_receiving_status');
    }

    public function set_receiving_status($reference) {
        $this->CI->session->set_userdata('SO_receiving_status', $reference);
    }

    public function clear_receiving_status() {
        $this->CI->session->unset_userdata('SO_receiving_status');
    }    
    
    public function get_supplier() {
        if (!$this->CI->session->userdata('SO_supplier')) {
            $this->set_supplier(-1);
        }
        return $this->CI->session->userdata('SO_supplier');
    }

    public function set_supplier($supplier_id) {
        $this->CI->session->set_userdata('SO_supplier', $supplier_id);
    }

    public function remove_supplier() {
        $this->CI->session->unset_userdata('SO_supplier');
    }

    public function get_stock_source($storefor = 'store') {
        if (!$this->CI->session->userdata('SO_stock_source')) {
            $this->set_stock_source($this->CI->Stock_location->get_default_location_id($storefor));
        }
        return $this->CI->session->userdata('SO_stock_source');
    }

    public function get_comment() {
        $comment = $this->CI->session->userdata('SO_comment');
        return empty($comment) ? '' : $comment;
    }

    public function set_comment($comment) {
        $this->CI->session->set_userdata('SO_comment', $comment);
    }

    public function clear_comment() {
        $this->CI->session->unset_userdata('SO_comment');
    }

    public function is_print_after_sale() {
        return $this->CI->session->userdata('SO_print_after_sale') == 'true' ||
                $this->CI->session->userdata('SO_print_after_sale') == '1';
    }

    public function set_print_after_sale($print_after_sale) {
        return $this->CI->session->set_userdata('SO_print_after_sale', $print_after_sale);
    }

    public function set_stock_source($stock_source) {
        $this->CI->session->set_userdata('SO_stock_source', $stock_source);
    }

    public function clear_stock_source() {
        $this->CI->session->unset_userdata('SO_stock_source');
    }

    public function get_stock_destination($storefor = 'warehouse') {
        if (!$this->CI->session->userdata('SO_stock_destination')) {
            $this->set_stock_destination($this->CI->Stock_location->get_default_location_id($storefor));
        }

        return $this->CI->session->userdata('SO_stock_destination');
    }

    public function set_stock_destination($stock_destination) {
        $this->CI->session->set_userdata('SO_stock_destination', $stock_destination);
    }

    public function clear_stock_destination() {
        $this->CI->session->unset_userdata('SO_stock_destination');
    }

    public function add_item($item_id, $quantity = 1, $item_location = NULL, $price = NULL, $description = NULL, $serialnumber = NULL) {

        if (!$this->CI->Item->exists($item_id, FALSE)) {
            $item_id = $this->CI->Item->get_item_id($item_id, FALSE);
            if (!$item_id) {
                return FALSE;
            }
        }

        //Get items in the receiving so far.
        $items = $this->get_cart();

        $maxkey = 0;     //Highest key so far
        $itemalreadyinsale = FALSE;  //We did not find the item yet.
        $insertkey = 0;     //Key to use for new entry.
        $updatekey = 0;     //Key to use to update(quantity)

        foreach ($items as $item) {

            if ($maxkey <= $item['line']) {
                $maxkey = $item['line'];
            }

            if ($item['item_id'] == $item_id && $item['item_location'] == $item_location) {
                $itemalreadyinsale = TRUE;
                $updatekey = $item['line'];
            }
        }

        $insertkey = $maxkey + 1;
        $item_info = $this->CI->Item->get_info($item_id, $item_location);

        $price = $price != NULL ? $price : $item_info->cost_price;
        $item = array($insertkey => array(
                'item_id' => $item_id,
                'item_location' => $item_location,
                'stock_name' => $this->CI->Stock_location->get_location_name($item_location),
                'description' => $item_info->description,
                'line' => $insertkey,
                'name' => $item_info->name,
                'serialnumber' => $serialnumber != NULL ? $serialnumber : '',
                'in_stock' => $this->CI->Item_quantity->get_item_quantity($item_id, $item_location)->quantity,
                'price' => $price,
                'quantity' => ($quantity==1 && $item_info->receiving_quantity>0)?$item_info->receiving_quantity:$quantity,
                'total' => 0
            )
        );

        //Item already exists
        if ($itemalreadyinsale) {
            $items[$updatekey]['quantity'] += $quantity;
            $items[$updatekey]['total'] = 0;
        } else {
            //add to existing array
            $items += $item;
        }

        $this->set_cart($items);

        return TRUE;
    }

    public function edit_item($line, $quantity) {
        $items = $this->get_cart();
        if (isset($items[$line])) {
            $line = &$items[$line];
            $line['quantity'] = $quantity;
            $line['total'] = 0;
            $this->set_cart($items);
        }

        return FALSE;
    }

    public function delete_item($line) {
        $items = $this->get_cart();
        unset($items[$line]);
        $this->set_cart($items);
    }

    public function copy_entire_receiving($receiving_id) {
        $this->empty_cart();
    }
    
    public function clear_all() {
        $this->empty_cart();
        $this->clear_comment();
        $this->clear_stock_source();
        $this->clear_receiving_status();
        $this->remove_supplier();
    }

}

?>
