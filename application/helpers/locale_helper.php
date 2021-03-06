<?php

/*
 * Currency locale
 */

function current_language_code() {
    $CI = & get_instance();
    $language_code = 'en';
    if ($CI->session->userdata('language_code')) {
        $language_code = $CI->session->userdata('language_code');
    }
    return $language_code;
}

function current_language() {
    return get_instance()->config->item('language');
}

function currency_side() {
    $config = get_instance()->config;
    $fmt = new \NumberFormatter($config->item('number_locale'), \NumberFormatter::CURRENCY);
    $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $config->item('currency_symbol'));
    return !preg_match('/^¤/', $fmt->getPattern());
}

function quantity_decimals() {
    $config = get_instance()->config;
    return $config->item('quantity_decimals') ? $config->item('quantity_decimals') : 0;
}

function totals_decimals() {
    $config = get_instance()->config;
    return $config->item('currency_decimals') ? $config->item('currency_decimals') : 0;
}

function to_currency($number, $currency_symbol = '') {
    if ($currency_symbol != '')
        return to_decimals($number, 'currency_decimals', \NumberFormatter::CURRENCY, $currency_symbol);
    else
        return to_decimals($number, 'currency_decimals', \NumberFormatter::CURRENCY, $currency_symbol);
}

function to_currency_no_money($number) {
    return to_decimals($number, 'currency_decimals');
}

function to_tax_decimals($number) {
    // taxes that are NULL, '' or 0 don't need to be displayed
    // NOTE: do not remove this line otherwise the items edit form will show a tax with 0 and it will save it
    if (empty($number)) {
        return $number;
    }

    return to_decimals($number, 'tax_decimals');
}

function to_quantity_decimals($number) {
    return to_decimals($number, 'quantity_decimals');
}

function to_decimals($number, $decimals, $type = \NumberFormatter::DECIMAL, $currency_symbol = '') {
    // ignore empty strings and return
    // NOTE: do not change it to empty otherwise tables will show a 0 with no decimal nor currency symbol
    if (!isset($number)) {
        return $number;
    }

    $config = get_instance()->config;
    $fmt = new \NumberFormatter($config->item('number_locale'), $type);
    $fmt->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $config->item($decimals));
    $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $config->item($decimals));
    if (empty($config->item('thousands_separator'))) {
        $fmt->setAttribute(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL, '');
    }
    $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $config->item('currency_symbol'));
    if ($currency_symbol != '')
        $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $currency_symbol);
    return $fmt->format($number);
}

function parse_decimals($number) {
    // ignore empty strings and return
    if (empty($number)) {
        return $number;
    }

    $config = get_instance()->config;
    $fmt = new \NumberFormatter($config->item('number_locale'), \NumberFormatter::DECIMAL);
    if (empty($config->item('thousands_separator'))) {
        $fmt->setAttribute(\NumberFormatter::GROUPING_SEPARATOR_SYMBOL, '');
    }
    return $fmt->parse($number);
}

/*
 * Time locale conversion utility
 */

function dateformat_momentjs($php_format) {
    $SYMBOLS_MATCHING = array(
        'd' => 'DD',
        'D' => 'ddd',
        'j' => 'D',
        'l' => 'dddd',
        'N' => 'E',
        'S' => 'o',
        'w' => 'e',
        'z' => 'DDD',
        'W' => 'W',
        'F' => 'MMMM',
        'm' => 'MM',
        'M' => 'MMM',
        'n' => 'M',
        't' => '', // no equivalent
        'L' => '', // no equivalent
        'o' => 'YYYY',
        'Y' => 'YYYY',
        'y' => 'YY',
        'a' => 'a',
        'A' => 'A',
        'B' => '', // no equivalent
        'g' => 'h',
        'G' => 'H',
        'h' => 'hh',
        'H' => 'HH',
        'i' => 'mm',
        's' => 'ss',
        'u' => 'SSS',
        'e' => 'zz', // deprecated since version $1.6.0 of moment.js
        'I' => '', // no equivalent
        'O' => '', // no equivalent
        'P' => '', // no equivalent
        'T' => '', // no equivalent
        'Z' => '', // no equivalent
        'c' => '', // no equivalent
        'r' => '', // no equivalent
        'U' => 'X'
    );

    return strtr($php_format, $SYMBOLS_MATCHING);
}

function dateformat_bootstrap($php_format) {
    $SYMBOLS_MATCHING = array(
        // Day
        'd' => 'dd',
        'D' => 'd',
        'j' => 'd',
        'l' => 'dd',
        'N' => '',
        'S' => '',
        'w' => '',
        'z' => '',
        // Week
        'W' => '',
        // Month
        'F' => 'MM',
        'm' => 'mm',
        'M' => 'M',
        'n' => 'm',
        't' => '',
        // Year
        'L' => '',
        'o' => '',
        'Y' => 'yyyy',
        'y' => 'yy',
        // Time
        'a' => 'p',
        'A' => 'P',
        'B' => '',
        'g' => 'H',
        'G' => 'h',
        'h' => 'HH',
        'H' => 'hh',
        'i' => 'ii',
        's' => 'ss',
        'u' => ''
    );

    return strtr($php_format, $SYMBOLS_MATCHING);
}

function pre($param) {
    echo "<pre>";
    print_r($param);
    echo "</pre>";
    exit();
}

function pr($param) {
    echo "<pre>";
    print_r($param);
    echo "</pre>";
}

function getRefId($prefix, $receive_mode, $condition = array()) {
    $CI = & get_instance();
    $CI->load->database();
    $CI->db->select('count(*) as ref_count');
    $CI->db->where('receiving_mode', $receive_mode);
    if (!empty($condition))
        $CI->db->where($condition);
    $result = $CI->db->get('receivings')->row_array();
    if (isset($result['ref_count'])) {
        return $prefix . ' ' . str_pad((int) $result['ref_count'] + 1, 4, 0, STR_PAD_LEFT);
    }
    return $prefix . ' ' . str_pad(1, 4, 0, STR_PAD_LEFT);
}

function changeDateTime($date, $format = 'Y-m-d H:i:s', $from_format = 'Y-m-d H:i:s', $dateformat = false) {
    $CI = & get_instance();
    if (!empty($CI->config->item('dateformat'))) {
        if (!$dateformat)
            $format = $CI->config->item('dateformat') . ' ' . $CI->config->item('timeformat');
        else {
            $format = $CI->config->item('dateformat');
        }
    }
    $d = DateTime::createFromFormat($from_format, $date);
    if ($d) {
        return $d->format($format);
    } else {
        return false;
    }
}

// ---------Injecting a Audit Log
function InjAuditLog($dataArr = array()) {
    $CI = & get_instance();
    $CI->load->database();
    $dataArr["date_time"] = date('Y-m-d H:i:s');
    $dataArr['employee_id'] = $CI->Employee->get_logged_in_employee_info()->person_id;

    if (!isset($dataArr['location']))
        $dataArr['location'] = '';

    if (!isset($dataArr['action']))
        $dataArr['action'] = '';

    if (!isset($dataArr['ref_text']))
        $dataArr['ref_text'] = '';

    if (!isset($dataArr['ref_id']))
        $dataArr['ref_id'] = '';

    if (!isset($dataArr['url']))
        $dataArr['url'] = '';

    $CI->db->insert('audit_trail', $dataArr);
}

function merge($arr1, $arr2) {
    if (!is_array($arr1))
        $arr1 = array();
    if (!is_array($arr2))
        $arr2 = array();
    $keys1 = array_keys($arr1);
    $keys2 = array_keys($arr2);
    $keys = array_merge($keys1, $keys2);
    $vals1 = array_values($arr1);
    $vals2 = array_values($arr2);
    $vals = array_merge($vals1, $vals2);
    $ret = array();

    foreach ($keys as $key) {
        list($unused, $val) = each($vals);
        $ret[$key] = $val;
    }

    return $ret;
}

?>
