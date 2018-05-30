<?php

class Receiving extends CI_Model {

    public function get_info($receiving_id) {
        $this->db->from('receivings');
        $this->db->join('people', 'people.person_id = receivings.supplier_id', 'LEFT');
        $this->db->join('suppliers', 'suppliers.person_id = receivings.supplier_id', 'LEFT');
        $this->db->where('receiving_id', $receiving_id);

        return $this->db->get();
    }

    public function get_receiving_by_reference($reference) {
        $this->db->from('receivings');
        $this->db->where('reference', $reference);

        return $this->db->get();
    }

    public function is_valid_receipt($receipt_receiving_id) {
        if (!empty($receipt_receiving_id)) {
            //RECV #
            $pieces = explode(' ', $receipt_receiving_id);

            if (count($pieces) == 2 && preg_match('/(RECV|KIT)/', $pieces[0])) {
                return $this->exists($pieces[1]);
            } else {
                return $this->get_receiving_by_reference($receipt_receiving_id)->num_rows() > 0;
            }
        }

        return FALSE;
    }

    public function exists($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id', $receiving_id);

        return ($this->db->get()->num_rows() == 1);
    }

    public function update($receiving_data, $receiving_id) {
        $this->db->where('receiving_id', $receiving_id);

        return $this->db->update('receivings', $receiving_data);
    }

    public function update_bill($receiving_data, $receiving_id, $receivingarray) {
        $account_trans_data = array('amount' => $this->get_receiving_items_amount($receiving_id),
            'account_id' => '9',
            'reference' => $receiving_data['payment_ref'],
            'reference_type' => 'grn',
            'reference_table' => 'receivings',
            'reference_id' => $receiving_id,
            'location_id' => $this->get_receiving_location_id($receiving_id),
            'trans_type' => 'debit',
            'url' => 'grn/receipt/' . $receiving_id
        );
        $this->Account->insert_trans($account_trans_data);
        $account_trans_data['trans_type'] = 'credit';
        $account_trans_data['account_id'] = '10';
        $this->Account->insert_trans($account_trans_data);

        $this->db->where('receiving_id', $receiving_id);
        return $this->db->update('receivings', $receiving_data);
    }

    public function save($items, $supplier_id, $employee_id, $comment, $reference, $payment_type, $receiving_id = FALSE, $dy_prefix = 'RECV ') {
        if (count($items) == 0) {
            return -1;
        }

        $receivings_data = array(
            'receiving_time' => date('Y-m-d H:i:s'),
            'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : NULL,
            'employee_id' => $employee_id,
            'payment_type' => $payment_type,
            'comment' => $comment,
            'reference' => $reference
        );

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();

        foreach ($items as $line => $item) {
            $cur_item_info = $this->Item->get_info($item['item_id']);

            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'description' => $item['description'],
                'serialnumber' => $item['serialnumber'],
                'quantity_purchased' => $item['quantity'],
                'receiving_quantity' => $item['receiving_quantity'],
                'discount_percent' => $item['discount'],
                'item_cost_price' => $cur_item_info->cost_price,
                'item_unit_price' => $item['price'],
                'item_location' => $item['item_location']
            );

            $this->db->insert('receivings_items', $receivings_items_data);

            $items_received = $item['receiving_quantity'] != 0 ? $item['quantity'] * $item['receiving_quantity'] : $item['quantity'];

            // update cost price, if changed AND is set in config as wanted
            if ($cur_item_info->cost_price != $item['price'] && $this->config->item('receiving_calculate_average_price') != FALSE) {
                $this->Item->change_cost_price($item['item_id'], $items_received, $item['price'], $cur_item_info->cost_price);
            }

            //Update stock quantity
            $item_quantity = $this->Item_quantity->get_item_quantity($item['item_id'], $item['item_location']);
            $this->Item_quantity->save(array('quantity' => $item_quantity->quantity + $items_received, 'item_id' => $item['item_id'],
                'location_id' => $item['item_location']), $item['item_id'], $item['item_location']);

            $recv_remarks = $dy_prefix . $receiving_id;
            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item['item_id'],
                'trans_user' => $employee_id,
                'trans_location' => $item['item_location'],
                'trans_comment' => $recv_remarks,
                'trans_inventory' => $items_received
            );

            $this->Inventory->insert($inv_data);

            $supplier = $this->Supplier->get_info($supplier_id);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    public function save_payment($data, $cart) {
        if (count($data) == 0 && count($data_recpayment_made_receivings) == 0) {
            return -1;
        }

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('recpayment_made', $data);
        $recpayment_made = $this->db->insert_id();

        if (!empty($cart)) {
            $amount = 0;
            foreach ($cart as $key => $value) {
                $amount+=$value['sending_price'];
                $data_recpayment_made_receivings['recpayment_made_id'] = $recpayment_made;
                $data_recpayment_made_receivings['receivings_id'] = $value['receiving_id'];
                $data_recpayment_made_receivings['amount'] = $value['sending_price'];
                $this->db->insert('recpayment_made_receivings', $data_recpayment_made_receivings);

                $receiving = array(
                    'payment_type' => $data['payment_type'],
                    'payment_status' => ($value['totl_billcost'] == $value['sending_price']) ? 'paid' : 'partially'
                );
                $this->db->where('receiving_id', $value['receiving_id']);
                $this->db->update('receivings', $receiving);
                $account_trans_data = array('amount' => $value['sending_price'],
                    'account_id' => '10',
                    'reference' => $value['payment_ref'],
                    'reference_type' => 'bill',
                    'reference_table' => 'receivings',
                    'reference_id' => $value['receiving_id'],
                    'location_id' => $this->get_receiving_location_id($value['receiving_id']),
                    'trans_type' => 'debit',
                    'url' => 'grn/billreceipt/' . $value['receiving_id']
                );
                $this->Account->insert_trans($account_trans_data);
                $account_trans_data['trans_type'] = 'credit';
                $account_trans_data['account_id'] = $this->Account->get_supplier_account_id($data['supplier_id']);
                $this->Account->insert_trans($account_trans_data);
            }
            $this->db->where('id', $recpayment_made);
            $this->db->update('recpayment_made', array('amount' => $amount));
        }



        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $recpayment_made;
    }

    public function save_grn($items, $supplier_id, $employee_id, $comment, $po_ref, $receiving_id, $dy_prefix = 'GRN ') {
        $account_trans_amount = 0;

        if (count($items) == 0) {
            return -1;
        }

        $flag = 0;
        foreach ($items as $line => $item) {
            if ($item['balance_quantity'] == $item['receiving_quantity']) {
                $flag++;
            }
        }
        $recv_remarks = $receiving_id;

        $receivings_data = array(
            'receiving_time' => date('Y-m-d H:i:s'),
            'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : NULL,
            'employee_id' => $employee_id,
            'comment' => $comment,
            'po_ref' => $po_ref,
            'receiving_ref' => $receiving_id,
            'receiving_status' => 'draft'
        );


        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();
        foreach ($items as $line => $item) {
            $cur_item_info = $this->Item->get_info($item['item_id']);

            $account_trans_amount += ($item['price'] * $item['receiving_quantity']);

            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'description' => $item['description'],
                'serialnumber' => $item['serialnumber'],
//                'quantity_purchased' => $item['quantity'],
                'receiving_quantity' => $item['receiving_quantity'],
//                'discount_percent' => $item['discount'],
                'item_unit_price' => $cur_item_info->cost_price,
                'item_cost_price' => $item['price'],
                'item_location' => $item['item_location']
            );
            $this->db->where('receiving_id', $po_ref);
            $this->db->where('item_id', $item['item_id']);
            $this->db->update('receivings_items', array('balance_quantity' => ($item['balance_quantity'] - $item['receiving_quantity'])));

            $this->db->insert('receivings_items', $receivings_items_data);

            $items_received = $item['receiving_quantity'] != 0 ? $item['quantity'] * $item['receiving_quantity'] : $item['quantity'];


            //Update stock quantity
            $item_quantity = $this->Item_quantity->get_item_quantity($item['item_id'], $item['item_location']);
            $this->Item_quantity->save(array('quantity' => $item_quantity->quantity + $items_received, 'item_id' => $item['item_id'],
                'location_id' => $item['item_location']), $item['item_id'], $item['item_location']);

            //$recv_remarks = $dy_prefix . $receiving_id;
            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item['item_id'],
                'trans_user' => $employee_id,
                'trans_location' => $item['item_location'],
                'price' => $item['price'],
                'trans_comment' => $recv_remarks,
                'trans_inventory' => $items_received
            );

            $this->Inventory->insert($inv_data);

            $supplier = $this->Supplier->get_info($supplier_id);
        }
//        $account_trans_data = array('amount' => $account_trans_amount,
//            'account_id' => $this->Account->get_employee_account_id($employee_id),
//            'reference' => $receivings_data['receiving_ref'],
//            'reference_type' => 'grn',
//            'reference_table' => 'receivings',
//            'reference_id' => $receiving_id,
//            'trans_type' => 'credit',
//            'url' => 'grn/receipt/' . $receiving_id
//        );
//        $this->Account->insert_trans($account_trans_data);
//        $account_trans_data['trans_type'] = 'debit';
//        $account_trans_data['account_id'] = '9';
//        $this->Account->insert_trans($account_trans_data);





        if ($flag == count($items)) {
            $this->update(array('receiving_status' => 'closed'), $po_ref);
        } else {
            $this->update(array('receiving_status' => 'partially'), $po_ref);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    public function save_requisition($items, $supplier_id, $employee_id, $comment, $stock_order_ref, $receiving_id) {
        if (count($items) == 0) {
            return -1;
        }

        $recv_remarks = $receiving_id;

        $receivings_data = array(
            'receiving_time' => date('Y-m-d H:i:s'),
            'supplier_id' => $supplier_id,
            'employee_id' => $employee_id,
            'comment' => $comment,
            'po_ref' => $stock_order_ref,
            'receiving_ref' => $receiving_id,
            'receiving_status' => 'open',
            'receiving_mode' => 'requisition'
        );


        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();
        foreach ($items as $line => $item) {
            $cur_item_info = $this->Item->get_info($item['item_id']);
            $item_cost_price = $this->Item_price->get_item_price($item['item_id'], $supplier_id);
            $item['item_cost_price'] = $item_cost_price->price;
            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'description' => $item['description'],
                'serialnumber' => $item['serialnumber'],
                'receiving_quantity' => $item['receiving_quantity'],
                'item_unit_price' => $item['item_unit_price'],
                'item_cost_price' => $item['item_cost_price'],
                'item_location' => $item['item_location']
            );
            $this->db->where('receiving_id', $stock_order_ref);
            $this->db->where('item_id', $item['item_id']);
            $this->db->update('receivings_items', array('balance_quantity' => ($item['balance_quantity'] - $item['receiving_quantity'])));

            $this->db->insert('receivings_items', $receivings_items_data);

            $items_received = $item['receiving_quantity'] != 0 ? $item['quantity'] * $item['receiving_quantity'] : $item['quantity'];


            //Update stock quantity
            $item_quantity = $this->Item_quantity->get_item_quantity($item['item_id'], $supplier_id);

            $this->Item_quantity->save(array('quantity' => $item_quantity->quantity - $items_received, 'item_id' => $item['item_id'],
                'location_id' => $supplier_id), $item['item_id'], $supplier_id);
//pre($item_quantity);
            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item['item_id'],
                'trans_user' => $employee_id,
                'trans_location' => $supplier_id,
                'trans_comment' => $recv_remarks,
                'trans_type' => 'sale',
                'price' => $item_cost_price->price,
                'trans_inventory' => -$items_received
            );

            $this->Inventory->insert($inv_data);




            $supplier = $this->Supplier->get_info($supplier_id);
            $account_trans_data = array('amount' => ($item_cost_price->price * $item['receiving_quantity']),
                'account_id' => '9',
                'reference' => $receivings_data['receiving_ref'],
                'reference_type' => 'REQ',
                'reference_table' => 'receivings',
                'reference_id' => $receiving_id,
                'location_id' => $supplier_id,
                'trans_type' => 'credit',
                'url' => 'grn/receipt/' . $receiving_id
            );
            $this->Account->insert_trans($account_trans_data);
            $account_trans_data['trans_type'] = 'debit';
            $account_trans_data['account_id'] = '18';
            $this->Account->insert_trans($account_trans_data);
        }

        $this->update(array('receiving_status' => 'closed'), $stock_order_ref);


        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    public function save_soc($items, $supplier_id, $employee_id, $comment, $stock_order_ref, $receiving_id) {
        if (count($items) == 0) {
            return -1;
        }

        $recv_remarks = $receiving_id;

        $receivings_data = array(
            'receiving_time' => date('Y-m-d H:i:s'),
            'supplier_id' => $supplier_id,
            'employee_id' => $employee_id,
            'comment' => $comment,
            'po_ref' => $stock_order_ref,
            'receiving_ref' => $receiving_id,
            'receiving_status' => 'closed',
            'receiving_mode' => 'stockorder_check'
        );


        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();
        foreach ($items as $line => $item) {
            $cur_item_info = $this->Item->get_info($item['item_id']);
            $item_cost_price = $this->Item_price->get_item_price($item['item_id'], $supplier_id);
            $item['item_cost_price'] = $item_cost_price->price;
            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'description' => $item['description'],
                'serialnumber' => $item['serialnumber'],
                'receiving_quantity' => $item['receiving_quantity'],
                'item_unit_price' => $item['item_unit_price'],
                'item_cost_price' => $item['item_cost_price'],
                'item_location' => $item['item_location']
            );
            $this->db->where('receiving_id', $stock_order_ref);
            $this->db->where('item_id', $item['item_id']);
            $this->db->update('receivings_items', array('balance_quantity' => ($item['balance_quantity'] - $item['receiving_quantity'])));

            $this->db->insert('receivings_items', $receivings_items_data);

            $items_received = $item['receiving_quantity'] != 0 ? $item['quantity'] * $item['receiving_quantity'] : $item['quantity'];


            //Update stock quantity
            $item_quantity = $this->Item_quantity->get_item_quantity($item['item_id'], $item['item_location']);
            $this->Item_quantity->save(array('quantity' => $item_quantity->quantity + $items_received, 'item_id' => $item['item_id'],
                'location_id' => $item['item_location']), $item['item_id'], $item['item_location']);

            $inv_data = array(
                'trans_date' => date('Y-m-d H:i:s'),
                'trans_items' => $item['item_id'],
                'trans_user' => $employee_id,
                'trans_location' => $item['item_location'],
                'price' => $item['item_cost_price'],
                'trans_comment' => $recv_remarks,
                'trans_inventory' => $items_received
            );

            $this->Inventory->insert($inv_data);

            $supplier = $this->Supplier->get_info($supplier_id);

            $account_trans_data = array('amount' => $item['item_cost_price'] * $item['receiving_quantity'],
                'account_id' => '18',
                'reference' => $receivings_data['receiving_ref'],
                'reference_type' => 'SOC',
                'reference_table' => 'receivings',
                'reference_id' => $receiving_id,
                'location_id' => $item['item_location'],
                'trans_type' => 'credit',
                'url' => 'grn/receipt/' . $receiving_id
            );
            $this->Account->insert_trans($account_trans_data);
            $account_trans_data['trans_type'] = 'debit';
            $account_trans_data['account_id'] = '9';
            $this->Account->insert_trans($account_trans_data);
        }

        $this->update(array('receiving_status' => 'closed'), $stock_order_ref);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    public function savepo($items, $supplier_id, $employee_id, $comment, $mode, $receiving_status, $po_ref) {
        if (count($items) == 0) {
            return -1;
        }

        $receivings_data = array(
            'receiving_time' => date('Y-m-d H:i:s'),
            'supplier_id' => $this->Supplier->exists($supplier_id) ? $supplier_id : NULL,
            'employee_id' => $employee_id,
            'receiving_mode' => $mode,
            'receiving_ref' => $po_ref,
            'receiving_status' => $receiving_status,
            'comment' => $comment,
            'reference' => ''
        );

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();
        //pre($items);
        foreach ($items as $line => $item) {

            $cur_item_info = $this->Item->get_info($item['item_id']);
            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'serialnumber' => $item['serialnumber'],
                'request_quantity' => $item['quantity'],
                'balance_quantity' => $item['quantity'],
                'receiving_quantity' => 0,
                'item_location' => $item['item_location']
            );
            $this->db->insert('receivings_items', $receivings_items_data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    /* Stock Order */

    public function save_so($items, $receivings_data = array()) {
        if (count($items) == 0) {
            return -1;
        }
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        $this->db->insert('receivings', $receivings_data);
        $receiving_id = $this->db->insert_id();
        //pre($receivings_data);
        foreach ($items as $line => $item) {

            $cur_item_info = $this->Item->get_info($item['item_id']);
            $item_cost_price = $this->Item_price->get_item_price($item['item_id'], $receivings_data['supplier_id']);
            $item['item_cost_price'] = $item_cost_price->price;

            $receivings_items_data = array(
                'receiving_id' => $receiving_id,
                'item_id' => $item['item_id'],
                'line' => $item['line'],
                'description' => $item['description'],
                'serialnumber' => $item['serialnumber'],
                'request_quantity' => $item['quantity'],
                'balance_quantity' => $item['quantity'],
                'receiving_quantity' => 0,
                'item_location' => $item['item_location'],
                'item_cost_price' => $item['item_cost_price']
            );
            $this->db->insert('receivings_items', $receivings_items_data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return -1;
        }

        return $receiving_id;
    }

    public function delete_list($receiving_ids, $employee_id, $update_inventory = TRUE) {
        $success = TRUE;

        // start a transaction to assure data integrity
        $this->db->trans_start();

        foreach ($receiving_ids as $receiving_id) {
            $success &= $this->delete($receiving_id, $employee_id, $update_inventory);
        }

        // execute transaction
        $this->db->trans_complete();

        $success &= $this->db->trans_status();

        return $success;
    }

    public function delete($receiving_id, $employee_id, $update_inventory = TRUE) {
        // start a transaction to assure data integrity
        $this->db->trans_start();

        if ($update_inventory) {
            // defect, not all item deletions will be undone??
            // get array with all the items involved in the sale to update the inventory tracking
            $items = $this->get_receiving_items($receiving_id)->result_array();
            foreach ($items as $item) {
                // create query to update inventory tracking
                $inv_data = array(
                    'trans_date' => date('Y-m-d H:i:s'),
                    'trans_items' => $item['item_id'],
                    'trans_user' => $employee_id,
                    'trans_comment' => 'Deleting receiving ' . $receiving_id,
                    'trans_location' => $item['item_location'],
                    'trans_inventory' => $item['quantity_purchased'] * -1
                );
                // update inventory
                $this->Inventory->insert($inv_data);

                // update quantities
                $this->Item_quantity->change_quantity($item['item_id'], $item['item_location'], $item['quantity_purchased'] * -1);
            }
        }

        // delete all items
        $this->db->delete('receivings_items', array('receiving_id' => $receiving_id));
        // delete sale itself
        $this->db->delete('receivings', array('receiving_id' => $receiving_id));

        // execute transaction
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function get_receiving_items($receiving_id) {
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);

        return $this->db->get();
    }

    public function get_receiving_items_amount($receiving_id) {
        $this->db->select('sum(receiving_quantity*item_cost_price) as total');
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->get()->row()->total;
    }

    public function get_receiving_location_id($receiving_id) {
        $this->db->select('item_location');
        $this->db->from('receivings_items');
        $this->db->where('receiving_id', $receiving_id);
        return $this->db->get()->row()->item_location;
    }

    public function get_supplier($receiving_id) {
        $this->db->from('receivings');
        $this->db->where('receiving_id', $receiving_id);

        return $this->Supplier->get_info($this->db->get()->row()->supplier_id);
    }

    public function get_payment_options() {
        return array(
            $this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
            $this->lang->line('sales_check') => $this->lang->line('sales_check'),
            $this->lang->line('sales_debit') => $this->lang->line('sales_debit'),
            $this->lang->line('sales_credit') => $this->lang->line('sales_credit')
        );
    }

    /*
      We create a temp table that allows us to do easy report/receiving queries
     */

    public function create_temp_table(array $inputs) {
        if (empty($inputs['receiving_id'])) {
            if (empty($this->config->item('date_or_time_format'))) {
                $where = 'WHERE DATE(receiving_time) BETWEEN ' . $this->db->escape($inputs['start_date']) . ' AND ' . $this->db->escape($inputs['end_date']);
            } else {
                $where = 'WHERE receiving_time BETWEEN ' . $this->db->escape(rawurldecode($inputs['start_date'])) . ' AND ' . $this->db->escape(rawurldecode($inputs['end_date']));
            }
        } else {
            $where = 'WHERE receivings_items.receiving_id = ' . $this->db->escape($inputs['receiving_id']);
        }

        $this->db->query('CREATE TEMPORARY TABLE IF NOT EXISTS ' . $this->db->dbprefix('receivings_items_temp') .
                ' (INDEX(receiving_date), INDEX(receiving_time), INDEX(receiving_id))
			(
				SELECT 
					MAX(DATE(receiving_time)) AS receiving_date,
					MAX(receiving_time) AS receiving_time,
					receivings_items.receiving_id,
					MAX(comment) AS comment,
					MAX(item_location) AS item_location,
					MAX(reference) AS reference,
					MAX(payment_type) AS payment_type,
					MAX(employee_id) AS employee_id, 
					items.item_id,
					MAX(receivings.supplier_id) AS supplier_id,
					MAX(quantity_purchased) AS quantity_purchased,
					MAX(receivings_items.receiving_quantity) AS receiving_quantity,
					MAX(item_cost_price) AS item_cost_price,
					MAX(item_unit_price) AS item_unit_price,
					MAX(discount_percent) AS discount_percent,
					receivings_items.line,
					MAX(serialnumber) AS serialnumber,
					MAX(receivings_items.description) AS description,
					MAX(item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent / 100) AS subtotal,
					MAX(item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent / 100) AS total,
					MAX((item_unit_price * quantity_purchased - item_unit_price * quantity_purchased * discount_percent / 100) - (item_cost_price * quantity_purchased)) AS profit,
					MAX(item_cost_price * quantity_purchased) AS cost
				FROM ' . $this->db->dbprefix('receivings_items') . ' AS receivings_items
				INNER JOIN ' . $this->db->dbprefix('receivings') . ' AS receivings
					ON receivings_items.receiving_id = receivings.receiving_id
				INNER JOIN ' . $this->db->dbprefix('items') . ' AS items
					ON receivings_items.item_id = items.item_id
				' . "
				$where
				" . '
				GROUP BY receivings_items.receiving_id, items.item_id, receivings_items.line
			)'
        );
    }

}

?>
