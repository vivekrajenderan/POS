<?php

function get_sales_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('sale_id' => $CI->lang->line('common_id')),
        array('sale_time' => $CI->lang->line('sales_sale_time')),
        array('customer_name' => $CI->lang->line('customers_customer')),
        array('amount_due' => $CI->lang->line('sales_amount_due')),
        array('amount_tendered' => $CI->lang->line('sales_amount_tendered')),
        array('change_due' => $CI->lang->line('sales_change_due')),
        array('payment_type' => $CI->lang->line('sales_payment_type'))
    );

    if ($CI->config->item('invoice_enable') == TRUE) {
        $headers[] = array('invoice_number' => $CI->lang->line('sales_invoice_number'));
        $headers[] = array('invoice' => '&nbsp', 'sortable' => FALSE);
    }

    return transform_headers(array_merge($headers, array(array('receipt' => '&nbsp', 'sortable' => FALSE))));
}

/*
  Gets the html data rows for the sales.
 */

function get_sale_data_last_row($sales, $controller) {
    $CI = & get_instance();
    $sum_amount_due = 0;
    $sum_amount_tendered = 0;
    $sum_change_due = 0;

    foreach ($sales->result() as $key => $sale) {
        $sum_amount_due += $sale->amount_due;
        $sum_amount_tendered += $sale->amount_tendered;
        $sum_change_due += $sale->change_due;
    }

    return array(
        'sale_id' => '-',
        'sale_time' => '<b>' . $CI->lang->line('sales_total') . '</b>',
        'amount_due' => '<b>' . to_currency($sum_amount_due) . '</b>',
        'amount_tendered' => '<b>' . to_currency($sum_amount_tendered) . '</b>',
        'change_due' => '<b>' . to_currency($sum_change_due) . '</b>'
    );
}

function get_sale_data_row($sale, $controller) {
    $CI = & get_instance();
    $controller_name = $CI->uri->segment(1);

    $row = array(
        'sale_id' => $sale->sale_id,
        'sale_time' => date($CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat'), strtotime($sale->sale_time)),
        'customer_name' => $sale->customer_name,
        'amount_due' => to_currency($sale->amount_due),
        'amount_tendered' => to_currency($sale->amount_tendered),
        'change_due' => to_currency($sale->change_due),
        'payment_type' => $sale->payment_type
    );

    if ($CI->config->item('invoice_enable')) {
        $row['invoice_number'] = $sale->invoice_number;
        $row['invoice'] = empty($sale->invoice_number) ? '' : anchor($controller_name . "/invoice/$sale->sale_id", '<span class="glyphicon glyphicon-list-alt"></span>', array('title' => $CI->lang->line('sales_show_invoice'))
        );
    }

    $row['receipt'] = anchor($controller_name . "/receipt/$sale->sale_id", '<span class="glyphicon glyphicon-usd"></span>', array('title' => $CI->lang->line('sales_show_receipt'))
    );
    $row['edit'] = anchor($controller_name . "/edit/$sale->sale_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg print_hide', 'data-btn-delete' => $CI->lang->line('common_delete'), 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    );

    return $row;
}

/*
  Get the sales payments summary
 */

function get_sales_manage_payments_summary($payments, $sales, $controller) {
    $CI = & get_instance();
    $table = '<div id="report_summary">';

    foreach ($payments as $key => $payment) {
        $amount = $payment['payment_amount'];

        // WARNING: the strong assumption here is that if a change is due it was a cash transaction always
        // therefore we remove from the total cash amount any change due
        if ($payment['payment_type'] == $CI->lang->line('sales_cash')) {
            foreach ($sales->result_array() as $key => $sale) {
                $amount -= $sale['change_due'];
            }
        }
        $table .= '<div class="summary_row">' . $payment['payment_type'] . ': ' . to_currency($amount) . '</div>';
    }
    $table .= '</div>';

    return $table;
}

function transform_headers_readonly($array) {
    $result = array();
    foreach ($array as $key => $value) {
        $result[] = array('field' => $key, 'title' => $value, 'sortable' => $value != '', 'switchable' => !preg_match('(^$|&nbsp)', $value));
    }

    return json_encode($result);
}

function transform_headers($array, $readonly = FALSE, $editable = TRUE) {
    $result = array();

    if (!$readonly) {
        $array = array_merge(array(array('checkbox' => 'select', 'sortable' => FALSE)), $array);
    }

    if ($editable) {
        $array[] = array('edit' => '');
    }

    foreach ($array as $element) {
        reset($element);
        $result[] = array('field' => key($element),
            'title' => current($element),
            'switchable' => isset($element['switchable']) ?
                    $element['switchable'] : !preg_match('(^$|&nbsp)', current($element)),
            'sortable' => isset($element['sortable']) ?
                    $element['sortable'] : current($element) != '',
            'checkbox' => isset($element['checkbox']) ?
                    $element['checkbox'] : FALSE,
            'class' => isset($element['checkbox']) || preg_match('(^$|&nbsp)', current($element)) ?
                    'print_hide' : '',
            'sorter' => isset($element['sorter']) ?
                    $element ['sorter'] : '');
    }
    return json_encode($result);
}

function get_people_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('people.person_id' => $CI->lang->line('common_id')),
        array('last_name' => $CI->lang->line('common_last_name')),
        array('first_name' => $CI->lang->line('common_first_name')),
        array('email' => $CI->lang->line('common_email')),
        array('employees_login' => $CI->lang->line('employees_login')),
        array('phone_number' => $CI->lang->line('common_phone_number')),
        array('edit' => '', 'sortable' => FALSE),
        array('deposit' => '', 'sortable' => FALSE)
    );

    if ($CI->Employee->has_grant('messages', $CI->session->userdata('person_id'))) {
        $headers[] = array('messages' => '', 'sortable' => FALSE);
    }

    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_person_data_row($person, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'people.person_id' => $person->person_id,
        'last_name' => $person->last_name,
        'first_name' => $person->first_name,
        'email' => empty($person->email) ? '' : mailto($person->email, $person->email),
        'employees_login' => $person->employees_login,
        'phone_number' => $person->phone_number,
        'messages' => empty($person->phone_number) ? '' : anchor("Messages/view/$person->person_id", '<span class="glyphicon glyphicon-phone"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line('messages_sms_send'))),
        'edit' => anchor($controller_name . "/view/$person->person_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))),
        'deposit' => anchor($controller_name . "/deposit/$person->person_id", '<span class="glyphicon glyphicon-upload"></span>', array('class' => '', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_deposit')))
    );
}

function get_customer_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('people.person_id' => $CI->lang->line('common_id')),
        array('last_name' => $CI->lang->line('common_last_name')),
        array('first_name' => $CI->lang->line('common_first_name')),
        array('email' => $CI->lang->line('common_email')),
        array('phone_number' => $CI->lang->line('common_phone_number')),
        array('total' => $CI->lang->line('common_total_spent'), 'sortable' => FALSE)
    );

    if ($CI->Employee->has_grant('messages', $CI->session->userdata('person_id'))) {
        $headers[] = array('messages' => '', 'sortable' => FALSE);
    }

    return transform_headers($headers);
}

function get_customer_data_row($person, $stats, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'people.person_id' => $person->person_id,
        'last_name' => $person->last_name,
        'first_name' => $person->first_name,
        'email' => empty($person->email) ? '' : mailto($person->email, $person->email),
        'phone_number' => $person->phone_number,
        'total' => to_currency($stats->total),
        'messages' => empty($person->phone_number) ? '' : anchor("Messages/view/$person->person_id", '<span class="glyphicon glyphicon-phone"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line('messages_sms_send'))),
        'edit' => anchor($controller_name . "/view/$person->person_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    ));
}

function get_suppliers_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('people.person_id' => $CI->lang->line('common_id')),
        array('company_name' => $CI->lang->line('suppliers_company_name')),
        array('agency_name' => $CI->lang->line('suppliers_agency_name')),
        array('last_name' => $CI->lang->line('common_last_name')),
        array('first_name' => $CI->lang->line('common_first_name')),
        array('email' => $CI->lang->line('common_email')),
        array('phone_number' => $CI->lang->line('common_phone_number'))
    );

    if ($CI->Employee->has_grant('messages', $CI->session->userdata('person_id'))) {
        $headers[] = array('messages' => '');
    }

    return transform_headers($headers);
}

function get_supplier_data_row($supplier, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'people.person_id' => $supplier->person_id,
        'company_name' => $supplier->company_name,
        'agency_name' => $supplier->agency_name,
        'last_name' => $supplier->last_name,
        'first_name' => $supplier->first_name,
        'email' => empty($supplier->email) ? '' : mailto($supplier->email, $supplier->email),
        'phone_number' => $supplier->phone_number,
        'messages' => empty($supplier->phone_number) ? '' : anchor("Messages/view/$supplier->person_id", '<span class="glyphicon glyphicon-phone"></span>', array('class' => "modal-dlg", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line('messages_sms_send'))),
        'edit' => anchor($controller_name . "/view/$supplier->person_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => "modal-dlg", 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update')))
    );
}

function get_items_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('items.item_id' => $CI->lang->line('common_id')),
        array('item_number' => $CI->lang->line('items_item_number')),
        array('name' => $CI->lang->line('items_name')),
        array('category' => $CI->lang->line('items_category')),
        array('company_name' => $CI->lang->line('suppliers_company_name')),
        array('cost_price' => $CI->lang->line('items_cost_price')),
        array('tax_percents' => $CI->lang->line('items_tax_percents'), 'sortable' => FALSE),
        array('item_pic' => $CI->lang->line('items_image'), 'sortable' => FALSE),
        array('inventory' => ''),
        array('stock' => '')
    );

    return transform_headers($headers);
}

function get_item_data_row($item, $controller) {
    $CI = & get_instance();
    $item_tax_info = $CI->Item_taxes->get_info($item->item_id);
    $tax_percents = '';
    foreach ($item_tax_info as $tax_info) {
        $tax_percents .= to_tax_decimals($tax_info['percent']) . '%, ';
    }
    // remove ', ' from last item
    $tax_percents = substr($tax_percents, 0, -2);
    $controller_name = strtolower(get_class($CI));

    $image = NULL;
    if ($item->pic_filename != '') {
        $ext = pathinfo($item->pic_filename, PATHINFO_EXTENSION);
        if ($ext == '') {
            // legacy
            $images = glob('./uploads/item_pics/' . $item->pic_filename . '.*');
        } else {
            // preferred
            $images = glob('./uploads/item_pics/' . $item->pic_filename);
        }

        if (sizeof($images) > 0) {
            $image .= '<a class="rollover" href="' . base_url($images[0]) . '"><img src="' . site_url('items/pic_thumb/' . pathinfo($images[0], PATHINFO_BASENAME)) . '"></a>';
        }
    }

    return array(
        'items.item_id' => $item->item_id,
        'item_number' => $item->item_number,
        'name' => $item->name,
        'category' => $item->category,
        'company_name' => $item->company_name,
        'cost_price' => to_currency($item->cost_price),
        'tax_percents' => !$tax_percents ? '-' : $tax_percents,
        'item_pic' => $image,
        'inventory' => anchor($controller_name . "/inventory/$item->item_id", '<span class="glyphicon glyphicon-pushpin"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_count'))
        ),
        'stock' => anchor($controller_name . "/count_details/$item->item_id", '<span class="glyphicon glyphicon-list-alt"></span>', array('class' => 'modal-dlg', 'title' => $CI->lang->line($controller_name . '_details_count'))
        ),
        'edit' => anchor($controller_name . "/view/$item->item_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    ));
}

function get_giftcards_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('giftcard_id' => $CI->lang->line('common_id')),
        array('last_name' => $CI->lang->line('common_last_name')),
        array('first_name' => $CI->lang->line('common_first_name')),
        array('giftcard_number' => $CI->lang->line('giftcards_giftcard_number')),
        array('value' => $CI->lang->line('giftcards_card_value'))
    );

    return transform_headers($headers);
}

function get_taxes_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('tax_code' => $CI->lang->line('taxes_tax_code')),
        array('tax_code_name' => $CI->lang->line('taxes_tax_code_name')),
        array('tax_code_type_name' => $CI->lang->line('taxes_tax_code_type')),
        array('tax_rate' => $CI->lang->line('taxes_tax_rate')),
        array('rounding_code_name' => $CI->lang->line('taxes_rounding_code')),
        array('city' => $CI->lang->line('common_city')),
        array('state' => $CI->lang->line('common_state'))
    );

    return transform_headers($headers);
}

function get_giftcard_data_row($giftcard, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'giftcard_id' => $giftcard->giftcard_id,
        'last_name' => $giftcard->last_name,
        'first_name' => $giftcard->first_name,
        'giftcard_number' => $giftcard->giftcard_number,
        'value' => to_currency($giftcard->value),
        'edit' => anchor($controller_name . "/view/$giftcard->giftcard_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    ));
}

function get_tax_data_row($tax_code_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'tax_code' => $tax_code_row->tax_code,
        'tax_code_name' => $tax_code_row->tax_code_name,
        'tax_code_type' => $tax_code_row->tax_code_type,
        'tax_rate' => $tax_code_row->tax_rate,
        'rounding_code' => $tax_code_row->rounding_code,
        'tax_code_type_name' => $CI->Tax->get_tax_code_type_name($tax_code_row->tax_code_type),
        'rounding_code_name' => $CI->get_rounding_code_name($tax_code_row->rounding_code),
        'city' => $tax_code_row->city,
        'state' => $tax_code_row->state,
        'edit' => anchor($controller_name . "/view/$tax_code_row->tax_code", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    ));
}

function get_item_kits_manage_table_headers() {
    $CI = & get_instance();

    $headers = array(
        array('item_kit_id' => $CI->lang->line('item_kits_kit')),
        array('name' => $CI->lang->line('item_kits_name')),
        array('description' => $CI->lang->line('item_kits_description')),
        array('cost_price' => $CI->lang->line('items_cost_price'), 'sortable' => FALSE),
        array('unit_price' => $CI->lang->line('items_unit_price'), 'sortable' => FALSE)
    );

    return transform_headers($headers);
}

function get_item_kit_data_row($item_kit, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'item_kit_id' => $item_kit->item_kit_id,
        'name' => $item_kit->name,
        'description' => $item_kit->description,
        'cost_price' => to_currency($item_kit->total_cost_price),
        'unit_price' => to_currency($item_kit->total_unit_price),
        'edit' => anchor($controller_name . "/view/$item_kit->item_kit_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))
    ));
}

function get_procurement_list() {
    $CI = & get_instance();
    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('po_ref')),
        array('sp.first_name' => $CI->lang->line('po_supplier_name')),
        array('cp.first_name' => $CI->lang->line('po_employee_name')),
        array('rc.receiving_time' => $CI->lang->line('po_date')),
        array('rc.receiving_status' => $CI->lang->line('po_status')),
        array('sl.location_name' => $CI->lang->line('po_supplier_location')),
        array('print' => '', 'sortable' => FALSE),
        array('clone' => '', 'sortable' => FALSE),
        array('togrn' => '', 'sortable' => FALSE),
        array('view' => '', 'sortable' => FALSE)
    );
    if ($CI->Employee->is_headoffice_in()) {
        array_push($headers, array('edit' => '', 'sortable' => FALSE));
        array_push($headers, array('delete' => '', 'sortable' => FALSE));
    }

    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_procurement_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $return_array = array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'sp.first_name' => $receiving_row->suppliername,
        'cp.first_name' => $receiving_row->employeename,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rc.receiving_status' => $receiving_row->receiving_status,
        'sl.location_name' => $receiving_row->location_name,
        'print' => anchor($controller_name . "/receipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('po_receipt_print'))),
        'clone' => anchor($controller_name . "/index/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-paste"></span>', array('title' => $CI->lang->line('po_clone'))),
        'togrn' => (in_array($receiving_row->receiving_status, array('open', 'partially'))) ? anchor("grn/index/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-paste"></span>', array('title' => $CI->lang->line('po_to_grn'))) : '<span class="glyphicon glyphicon-paste"></span>',
        'view' => (in_array($receiving_row->receiving_status, array('closed', 'partially'))) ? anchor($controller_name . "/po_view_details/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-eye-open"></span>', array('class' => 'modal-dlg', 'title' => $CI->lang->line('po_view'))) : '<span class="glyphicon glyphicon-eye-open"></span>'
    );
    if ($CI->Employee->is_headoffice_in()) {
        $return_array['edit'] = anchor($controller_name . "/statuschange/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_statuschange')));
        $return_array['delete'] = anchor($controller_name . "/delete_action/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-trash"></span>', 'class="deleteaction" title ="' . $CI->lang->line('purchase_order_delete') . '"');
    }
    return $return_array;
}

function get_grn_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('grn_ref')),
        array('sp.first_name' => $CI->lang->line('grn_supplier_name')),
        array('cp.first_name' => $CI->lang->line('grn_employee_name')),
        array('rc.receiving_time' => $CI->lang->line('grn_date')),
        array('rp.receiving_ref' => $CI->lang->line('grn_po_ref')),
        array('sl.location_name' => $CI->lang->line('grn_supplier_location')),
        array('rp.receiving_time' => $CI->lang->line('grn_po_date')),
        array('printgrn' => '', 'sortable' => FALSE),
        array('bill' => '', 'sortable' => FALSE),
        array('view' => '', 'sortable' => FALSE)
    );
    if ($CI->Employee->is_headoffice_in()) {
        array_push($headers, array('delete' => '', 'sortable' => FALSE));
    }
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_grn_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    $return_array = array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'sp.first_name' => $receiving_row->suppliername,
        'cp.first_name' => $receiving_row->employeename,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rp.receiving_ref' => $receiving_row->receiving_pref,
        'sl.location_name' => $receiving_row->location_name,
        'rp.receiving_time' => changeDateTime($receiving_row->po_time),
        'printgrn' => anchor($controller_name . "/receipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('grn_receipt_print'))),
        'bill' => (in_array($receiving_row->receiving_status, array('closed'))) ? anchor($controller_name . "/billreceipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('grn_billreceipt_print'))) : anchor($controller_name . "/generate_bill/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-paste"></span>', array('title' => $CI->lang->line('grn_to_bill'), 'class' => 'grn_to_bill')),
        'view' => (in_array($receiving_row->receiving_status, array('closed'))) ? anchor($controller_name . "/grn_view_details/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-eye-open"></span>', array('class' => 'modal-dlg', 'title' => $CI->lang->line('grn_view'))) : '<span class="glyphicon glyphicon-eye-open"></span>'
    );
    if ($CI->Employee->is_headoffice_in()) {
        $return_array['delete'] = anchor($controller_name . "/delete_action/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-trash"></span>', 'class="deleteaction" title ="' . $CI->lang->line('grn_delete') . '"');
    }
    return $return_array;
}

function get_audting_list() {
    $CI = & get_instance();

    $headers = array(
        array('a.date_time' => $CI->lang->line('auditing_time')),
        array('a.ref_text' => $CI->lang->line('auditing_activity_details')),
        array('a.action' => $CI->lang->line('auditing_description'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_auditing_data_row($auditing_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $supplier_name = ((!empty($auditing_row->suppliername))) ? "<br> Supplier Name : " . $auditing_row->suppliername : "";
    $employee_name = ((!empty($auditing_row->employeename))) ? "<br> Employee Name : " . $auditing_row->employeename : "";
    return array(
        'a.date_time' => changeDateTime($auditing_row->date_time),
        'a.ref_text' => $auditing_row->ref_text . " " . $supplier_name,
        'a.action' => $auditing_row->action . " " . $employee_name,
    );
}

function get_bills_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_time' => $CI->lang->line('bill_date')),
        array('rc.payment_ref' => $CI->lang->line('bill_refno')),
        array('rc.receiving_ref' => $CI->lang->line('bill_ref')),
        array('sp.first_name' => $CI->lang->line('bill_supplier_name')),
        array('ri.receiving_quantity' => $CI->lang->line('bill_amount')),
        array('sl.location_name' => $CI->lang->line('pay_location_name'))
    );
    return transform_headers($headers, $readonly = TRUE);
}

function get_bills_data_row($bill_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rc.receiving_time' => changeDateTime($bill_row->receiving_time),
        'rc.payment_ref' => $bill_row->payment_ref,
        'rc.receiving_ref' => $bill_row->receiving_ref,
        'sp.first_name' => $bill_row->suppliername,
        'ri.receiving_quantity' => $bill_row->receiving_quantity,
        'sl.location_name' => $bill_row->location_name,
        'edit' => anchor("grn/billreceipt/$bill_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>'));
}

function get_payment_list() {
    $CI = & get_instance();

    $headers = array(
        array('rm.payment_date' => $CI->lang->line('pay_payment_date')),
        array('rm.payment_reference' => $CI->lang->line('pay_payment_reference')),
        array('rm.payment_notes' => $CI->lang->line('pay_payment_notes')),
        array('rm.payment_type' => $CI->lang->line('pay_payment_type')),
        array('amount' => $CI->lang->line('pay_amount')),
        array('suppliername' => $CI->lang->line('pay_supplier_name')),
        array('employeename' => $CI->lang->line('pay_employee_name'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_paylist_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rm.payment_date' => changeDateTime($receiving_row->payment_date),
        'rm.payment_reference' => $receiving_row->payment_reference,
        'rm.payment_notes' => $receiving_row->payment_notes,
        'rm.payment_type' => $receiving_row->payment_type,
        'amount' => to_currency($receiving_row->amount, $receiving_row->symbol),
        'suppliername' => $receiving_row->suppliername,
        'employeename' => $receiving_row->employeename
    );
}

function get_payment_supplier_list() {
    $CI = & get_instance();

    $headers = array(
        array('rm.payment_date' => $CI->lang->line('pay_payment_date')),
        array('suppliername' => $CI->lang->line('pay_supplier_name')),
        array('sl.location_name' => $CI->lang->line('pay_location_name')),
        array('total_quantity' => $CI->lang->line('pay_quantity')),
        array('total_price' => $CI->lang->line('pay_total_price'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_payment_supplier_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rm.payment_date' => changeDateTime($receiving_row->payment_date),
        'suppliername' => $receiving_row->suppliername,
        'sl.location_name' => $receiving_row->location_name,
        'total_quantity' => $receiving_row->total_quantity,
        'total_price' => to_currency($receiving_row->total_price)
    );
}

function get_payment_location_list() {
    $CI = & get_instance();

    $headers = array(
        array('rm.payment_date' => $CI->lang->line('pay_payment_date')),
        array('sl.location_name' => $CI->lang->line('pay_location_name')),
        array('total_quantity' => $CI->lang->line('pay_quantity')),
        array('total_price' => $CI->lang->line('pay_total_price'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_payment_location_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rm.payment_date' => changeDateTime($receiving_row->payment_date),
        'sl.location_name' => $receiving_row->location_name,
        'total_quantity' => $receiving_row->total_quantity,
        'total_price' => to_currency($receiving_row->total_price)
    );
}

function get_payment_item_list() {
    $CI = & get_instance();

    $headers = array(
        array('rm.payment_date' => $CI->lang->line('pay_payment_date')),
        array('item_name' => $CI->lang->line('pay_item_name')),
        array('sl.location_name' => $CI->lang->line('pay_location_name')),
        array('total_quantity' => $CI->lang->line('pay_quantity')),
        array('total_price' => $CI->lang->line('pay_total_price'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_payment_item_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rm.payment_date' => changeDateTime($receiving_row->payment_date),
        'item_name' => $receiving_row->item_name,
        'sl.location_name' => $receiving_row->location_name,
        'total_quantity' => $receiving_row->total_quantity,
        'total_price' => to_currency($receiving_row->total_price)
    );
}

function get_stock_order_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('so_ref')),
        array('stock_location_name' => $CI->lang->line('so_stock_location_name')),
        array('cp.first_name' => $CI->lang->line('so_employee_name')),
        array('rc.receiving_time' => $CI->lang->line('so_date')),
        array('rc.receiving_status' => $CI->lang->line('so_status')),
        array('sl.location_name' => $CI->lang->line('so_item_location')),
        array('print' => '', 'sortable' => FALSE),
        array('clone' => '', 'sortable' => FALSE)
    );
    if ($CI->Employee->is_headoffice_in()) {
        array_push($headers, array('edit' => '', 'sortable' => FALSE));
    }
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_stock_order_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    $return_array = array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'stock_location_name' => $receiving_row->stock_location_name,
        'cp.first_name' => $receiving_row->employeename,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rc.receiving_status' => $receiving_row->receiving_status,
        'sl.location_name' => $receiving_row->location_name,
        'print' => anchor($controller_name . "/receipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('so_receipt_print'))),
        'clone' => anchor($controller_name . "/index/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-paste"></span>', array('title' => $CI->lang->line('so_clone')))
    );
    if ($CI->Employee->is_headoffice_in()) {
        $return_array['edit'] = anchor($controller_name . "/statuschange/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_statuschange')));
    }
    return $return_array;
}

function get_requisition_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('requisition_req_ref')),
        array('sp.location_name' => $CI->lang->line('requisition_supplier_name')),
        array('cp.first_name' => $CI->lang->line('requisition_employee_name')),
        array('rc.receiving_time' => $CI->lang->line('requisition_date')),
        array('rp.receiving_ref' => $CI->lang->line('requisition_so_ref')),
        array('sl.location_name' => $CI->lang->line('requisition_store_location')),
        array('rp.receiving_time' => $CI->lang->line('requisition_po_date')),
        array('printgrn' => '', 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_requisition_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'sp.location_name' => $receiving_row->suppliername,
        'cp.first_name' => $receiving_row->employeename,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rp.receiving_ref' => $receiving_row->receiving_pref,
        'sl.location_name' => $receiving_row->location_name,
        'rp.receiving_time' => changeDateTime($receiving_row->po_time),
        'printgrn' => anchor($controller_name . "/receipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('requisition_receipt_print')))
    );
}

function get_soc_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('stockordercheck_soc_ref')),
        array('sp.location_name' => $CI->lang->line('stockordercheck_supplier_name')),
        array('cp.first_name' => $CI->lang->line('stockordercheck_employee_name')),
        array('rc.receiving_time' => $CI->lang->line('stockordercheck_date')),
        array('rp.receiving_ref' => $CI->lang->line('stockordercheck_req_ref')),
        array('sl.location_name' => $CI->lang->line('stockordercheck_store_location')),
        array('rp.receiving_time' => $CI->lang->line('stockordercheck_po_date')),
        array('printgrn' => '', 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_soc_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'sp.location_name' => $receiving_row->suppliername,
        'cp.first_name' => $receiving_row->employeename,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rp.receiving_ref' => $receiving_row->receiving_pref,
        'sl.location_name' => $receiving_row->location_name,
        'rp.receiving_time' => changeDateTime($receiving_row->po_time),
        'printgrn' => anchor($controller_name . "/receipt/$receiving_row->receiving_id", '<span class="glyphicon glyphicon-print"></span>', array('title' => $CI->lang->line('requisition_receipt_print')))
    );
}

function get_payment_order_history_list() {
    $CI = & get_instance();

    $headers = array(
        array('rc.receiving_ref' => $CI->lang->line('po_ref')),
        array('sp.first_name' => $CI->lang->line('po_supplier_name')),
        array('rc.receiving_time' => $CI->lang->line('po_date')),
        array('rc.receiving_status' => $CI->lang->line('po_status')),
        array('sl.location_name' => $CI->lang->line('po_supplier_location')),
        array('request_quantity' => $CI->lang->line('pay_order_quantity')),
        array('total_received' => $CI->lang->line('pay_received_quantity'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_payment_history_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'rc.receiving_ref' => $receiving_row->receiving_ref,
        'sp.first_name' => $receiving_row->suppliername,
        'rc.receiving_time' => changeDateTime($receiving_row->receiving_time),
        'rc.receiving_status' => $receiving_row->receiving_status,
        'sl.location_name' => $receiving_row->location_name,
        'request_quantity' => $receiving_row->request_quantity,
        'total_received' => $receiving_row->total_received
    );
}

function get_payment_supplier_balance_list() {
    $CI = & get_instance();

    $headers = array(
        array('sp.first_name' => $CI->lang->line('po_supplier_name')),
        array('bill_amount' => $CI->lang->line('pay_bill_amount')),
        array('paid_amount' => $CI->lang->line('pay_paid')),
        array('balance_amount' => $CI->lang->line('pay_balance'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_payment_supplier_balance_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'sp.first_name' => $receiving_row->suppliername,
        'bill_amount' => to_currency($receiving_row->bill_amount),
        'paid_amount' => to_currency($receiving_row->paid_amount),
        'balance_amount' => to_currency($receiving_row->balance_amount)
    );
}

function get_inventory_log_list() {
    $CI = & get_instance();

    $headers = array(
        array('iy.trans_date' => $CI->lang->line('inventory_date')),
        array('employeename' => $CI->lang->line('inventory_employeename')),
        array('iy.trans_inventory' => $CI->lang->line('inventory_in_out_qty')),
        array('iy.balance' => $CI->lang->line('inventory_balance')),
        array('iy.price' => $CI->lang->line('inventory_price_qty')),
        array('inventory_total' => $CI->lang->line('inventory_total')),
        array('iy.trans_comment' => $CI->lang->line('inventory_remarks')),
        array('item_name' => $CI->lang->line('inventory_item_name')),
        array('sl.location_name' => $CI->lang->line('inventory_stock_location'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_inventory_log_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'iy.trans_date' => changeDateTime($receiving_row->trans_date),
        'employeename' => $receiving_row->employeename,
        'iy.trans_inventory' => $receiving_row->trans_inventory,
        'iy.balance' => $receiving_row->balance,
        'iy.price' => $receiving_row->price,
        'inventory_total' => $receiving_row->inventory_total,
        'iy.trans_comment' => $receiving_row->trans_comment,
        'item_name' => $receiving_row->item_name,
        'sl.location_name' => $receiving_row->location_name
    );
}

function get_account_transactions_list() {
    $CI = & get_instance();

    $headers = array(
        array('at.trans_date' => $CI->lang->line('account_date')),
        array('account_name' => $CI->lang->line('account_name')),
        array('employeename' => $CI->lang->line('account_employeename')),
        array('location_name' => $CI->lang->line('account_location_name')),
        array('at.reference' => $CI->lang->line('account_reference')),
        array('debitamount' => $CI->lang->line('account_debit')),
        array('creditamount' => $CI->lang->line('account_credit'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_account_transactions_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $debit_amount = "";
    if ($receiving_row->trans_type == "debit") {
        $debit_amount = $receiving_row->debitamount;
    }
    $credit_amount = "";
    if ($receiving_row->trans_type == "credit") {
        $credit_amount = $receiving_row->creditamount;
    }
    return array(
        'at.trans_date' => changeDateTime($receiving_row->trans_date),
        'account_name' => $receiving_row->account_name,
        'employeename' => $receiving_row->employeename,
        'location_name' => $receiving_row->location_name,
        'at.reference' => $receiving_row->reference,
        'debitamount' => to_currency($debit_amount),
        'creditamount' => to_currency($credit_amount)
    );
}

function get_employee_deposit_list() {
    $CI = & get_instance();

    $headers = array(
        array('at.trans_date' => $CI->lang->line('account_date')),
        array('employeename' => $CI->lang->line('account_employeename')),
        array('at.reference' => $CI->lang->line('account_reference')),
        array('debitamount' => $CI->lang->line('account_debit')),
        array('creditamount' => $CI->lang->line('account_credit'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_employee_deposit_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $debit_amount = "";
    if ($receiving_row->trans_type == "debit") {
        $debit_amount = $receiving_row->debitamount;
    }
    $credit_amount = "";
    if ($receiving_row->trans_type == "credit") {
        $credit_amount = $receiving_row->creditamount;
    }
    return array(
        'at.trans_date' => changeDateTime($receiving_row->trans_date),
        'employeename' => $receiving_row->employeename,
        'at.reference' => $receiving_row->reference,
        'debitamount' => $debit_amount,
        'creditamount' => $credit_amount
    );
}

function get_general_ledger_list() {
    $CI = & get_instance();

    $headers = array(
        array('account_name' => $CI->lang->line('account_name')),
        array('debit' => $CI->lang->line('account_debit')),
        array('credit' => $CI->lang->line('account_credit')),
        array('balance' => $CI->lang->line('account_balance'), 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_general_ledger_data_row($receiving_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    $balance = $receiving_row->debit - $receiving_row->credit;
    if (!ctype_digit((string) $balance)) {
        $balance = '(' . abs($balance) . ')';
    }

    return array(
        'account_name' => $receiving_row->account_name,
        'debit' => "<a href='accounts/viewledger/" . $receiving_row->account_id . "/" . $CI->input->get('start_date') . "/" . $CI->input->get('end_date') . "'>" . to_currency($receiving_row->debit) . "</a>",
        'credit' => "<a href='accounts/viewledger/" . $receiving_row->account_id . "/" . $CI->input->get('start_date') . "/" . $CI->input->get('end_date') . "'>" . to_currency($receiving_row->credit) . "</a>",
        'balance' => "<a href='accounts/viewledger/" . $receiving_row->account_id . "/" . $CI->input->get('start_date') . "/" . $CI->input->get('end_date') . "'>" . to_currency($balance) . "</a>"
    );
}

function get_sale_customer_list() {
    $CI = & get_instance();

    $headers = array(
        array('customername' => $CI->lang->line('salesreport_customer')),
        array('invoice_count' => $CI->lang->line('salesreport_invoice_count')),
        array('payment_amount' => $CI->lang->line('salesreport_sales')),
        array('item_tax_amount' => $CI->lang->line('salesreport_sales_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_sale_customer_data_row($sale_customer_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'customername' => $sale_customer_row->customername,
        'invoice_count' => $sale_customer_row->invoice_count,
        'payment_amount' => $sale_customer_row->payment_amount,
        'item_tax_amount' => $sale_customer_row->item_tax_amount
    );
}

function get_sale_item_list() {
    $CI = & get_instance();

    $headers = array(
        array('item_name' => $CI->lang->line('salesreport_itemname')),
        array('quantity_sold' => $CI->lang->line('salesreport_quantity_sold')),
        array('average_price' => $CI->lang->line('salesreport_average_price'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_sale_item_data_row($sale_item_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'item_name' => $sale_item_row->item_name,
        'quantity_sold' => $sale_item_row->quantity_sold,
        'average_price' => $sale_item_row->average_price
    );
}

function get_sale_person_list() {
    $CI = & get_instance();

    $headers = array(
        array('personname' => $CI->lang->line('salesreport_person')),
        array('invoice_count' => $CI->lang->line('salesreport_invoice_count')),
        array('payment_amount' => $CI->lang->line('salesreport_sales')),
        array('item_tax_amount' => $CI->lang->line('salesreport_sales_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_sale_person_data_row($sale_person_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'personname' => $sale_person_row->personname,
        'invoice_count' => $sale_person_row->invoice_count,
        'payment_amount' => $sale_person_row->payment_amount,
        'item_tax_amount' => $sale_person_row->item_tax_amount
    );
}

function get_expenses_list() {
    $CI = & get_instance();

    $headers = array(
        array('ep.status' => $CI->lang->line('expenses_status')),
        array('ep.expense_date' => $CI->lang->line('expenses_date')),
        array('ep.reference' => $CI->lang->line('expenses_reference')),
        array('suppliername' => $CI->lang->line('expenses_supplier_name')),
        array('account_name' => $CI->lang->line('expenses_category')),
        array('amount' => $CI->lang->line('expenses_amount')),
        array('amountax' => $CI->lang->line('expenses_amount_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_expenses_data_row($expenses_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'ep.status' => $expenses_row->status,
        'ep.expense_date' => changeDateTime($expenses_row->expense_date),
        'ep.reference' => $expenses_row->reference,
        'suppliername' => $expenses_row->suppliername,
        'account_name' => $expenses_row->account_name,
        'amount' => to_currency($expenses_row->amount, $expenses_row->symbol),
        'amountax' => to_currency($expenses_row->amountax, $expenses_row->symbol)
    );
}

function get_expenses_category_list() {
    $CI = & get_instance();

    $headers = array(
        array('account_name' => $CI->lang->line('expenses_category')),
        array('amount' => $CI->lang->line('expenses_amount')),
        array('amountax' => $CI->lang->line('expenses_amount_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_expenses_category_data_row($expenses_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'account_name' => $expenses_row->account_name,
        'amount' => to_currency($expenses_row->amount, $expenses_row->symbol),
        'amountax' => to_currency($expenses_row->amountax, $expenses_row->symbol)
    );
}

function get_income_list() {
    $CI = & get_instance();

    $headers = array(
        array('ic.income_date' => $CI->lang->line('otherincome_date')),
        array('ic.reference' => $CI->lang->line('otherincome_reference')),
        array('suppliername' => $CI->lang->line('otherincome_people_id')),
        array('account_name' => $CI->lang->line('otherincome_category')),
        array('amount' => $CI->lang->line('otherincome_amount')),
        array('amountax' => $CI->lang->line('otherincome_amount_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_income_data_row($income_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));
    return array(
        'ic.income_date' => changeDateTime($income_row->income_date),
        'ic.reference' => $income_row->reference,
        'suppliername' => $income_row->suppliername,
        'account_name' => $income_row->account_name,
        'amount' => to_currency($income_row->amount, $income_row->symbol),
        'amountax' => to_currency($income_row->amountax, $income_row->symbol)
    );
}

function get_income_category_list() {
    $CI = & get_instance();

    $headers = array(
        array('account_name' => $CI->lang->line('otherincome_category')),
        array('amount' => $CI->lang->line('otherincome_amount')),
        array('amountax' => $CI->lang->line('otherincome_amount_tax'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_income_category_data_row($income_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'account_name' => $income_row->account_name,
        'amount' => to_currency($income_row->amount),
        'amountax' => to_currency($income_row->amountax)
    );
}

function get_currency_list() {
    $CI = & get_instance();

    $headers = array(
        array('currency.name' => $CI->lang->line('currency_name')),
        array('currency.symbol' => $CI->lang->line('currency_symbol')),
        array('currency.rate' => $CI->lang->line('currency_exchange')),
        array('currency_rate.date' => $CI->lang->line('currency_as_date')),
        array('edit' => '', 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_currency_data_row($currency_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'currency.name' => $currency_row->code . " - " . $currency_row->name,
        'currency.symbol' => $currency_row->symbol,
        'currency.rate' => floatval($currency_row->rate),
        'currency_rate.date' => changeDateTime($currency_row->date),
        'edit' => ($currency_row->base_currency != '1') ? anchor($controller_name . "/viewcurrency/$currency_row->id", '<span class="glyphicon glyphicon-usd"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))) : ''
    );
}

function get_contact_list() {
    $CI = & get_instance();

    $headers = array(
        array('fullname' => $CI->lang->line('contactus_fullname')),
        array('email' => $CI->lang->line('common_email')),
        array('phone' => $CI->lang->line('common_phone_number')),
        array('subject' => $CI->lang->line('contactus_subject'))
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_contact_data_row($contact_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'fullname' => $contact_row->fullname,
        'email' => $contact_row->email,
        'phone' => $contact_row->phone,
        'subject' => $contact_row->subject
    );
}

function get_employee_roles_list() {
    $CI = & get_instance();

    $headers = array(
        array('name' => $CI->lang->line('employees_role_name')),
        array('login_type' => $CI->lang->line('common_role')),
        array('edit' => '', 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_employee_roles_data_row($roles_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'name' => $roles_row->name,
        'login_type' => $roles_row->login_type,
        'edit' => anchor($controller_name . "/viewrole/$roles_row->id", '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update')))
    );
}

function get_promotion_list() {
    $CI = & get_instance();

    $headers = array(
        array('promo_name' => $CI->lang->line('promo_name')),
        array('location_name' => $CI->lang->line('promo_store')),
        array('itemname' => $CI->lang->line('promo_item')),
        array('fromdate' => $CI->lang->line('promo_fromdate')),
        array('todate' => $CI->lang->line('promo_todate')),
        array('price' => $CI->lang->line('promo_price')),
        array('edit' => '', 'sortable' => FALSE)
    );
    return transform_headers($headers, $readonly = TRUE, $editable = FALSE);
}

function get_promotion_data_row($data_row, $controller) {
    $CI = & get_instance();
    $controller_name = strtolower(get_class($CI));

    return array(
        'promo_name' => $data_row['promo_name'],
        'location_name' => $data_row['location_name'],
        'itemname' => $data_row['itemname'],
        'fromdate' => changeDateTime($data_row['fromdate'],'Y-m-d','Y-m-d H:i:s',true),
        'todate' => changeDateTime($data_row['todate'],'Y-m-d','Y-m-d H:i:s',true),
        'price' => ($data_row['promo_type']=='price')?to_currency($data_row['price']):(floatval($data_row['price']).'%'),
        'edit' => anchor($controller_name . "/viewpromo/".$data_row['id'], '<span class="glyphicon glyphicon-edit"></span>', array('class' => 'modal-dlg', 'data-btn-submit' => $CI->lang->line('common_submit'), 'title' => $CI->lang->line($controller_name . '_update'))) 
    );
}

?>
