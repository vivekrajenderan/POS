<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Currency extends Secure_Controller {

    public function __construct() {
        parent::__construct('currency');
        $this->load->library('item_lib');
        $this->load->library('barcode_lib');
    }

    public function index() {
        $data['table_headers'] = $this->xss_clean(get_currency_list());
        $data['page_title'] = 'currency';
        $data['search_term'] = 'currency_search';
        $this->load->view("currency/manage", $data);
    }

    public function view($data = array()) {
        $data = $this->xss_clean($data);
        $this->load->view("currency/form", $data);
    }

    public function save($id = '') {
        $this->form_validation->set_rules('name', 'lang:currency_name', 'trim|required|min_length[3]|max_length[254]');
        $this->form_validation->set_rules('symbol', 'lang:currency_symbol', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('code', 'lang:currency_code', 'trim|required|min_length[1]|max_length[10]');
        $this->form_validation->set_rules('rate', 'lang:currency_rate', 'trim|required|callback_numeric|callback_checkexists');
        if ($this->form_validation->run() != FALSE) {
            $insert_array = array(
                'name' => $_POST['name'],
                'symbol' => $_POST['symbol'],
                'code' => $_POST['code'],
                'rate' => $_POST['rate']
            );
            $currency_id = $this->Currencies->save($insert_array, $id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('currency_success'), 'id' => $currency_id));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }

    public function checkexists($str) {
        $re = true;
        if ($_POST['id'] == '') {
            $where = array();
            if (isset($_POST['name']) && $_POST['name'] != '') {
                $where['name'] = $_POST['name'];
            }
            if (isset($_POST['symbol']) && $_POST['symbol'] != '') {
                $where['symbol'] = $_POST['symbol'];
            }
            if (isset($_POST['code']) && $_POST['code'] != '') {
                $where['code'] = $_POST['code'];
            }
            $re = $this->Currencies->exists($where);
        } else {
            $re = FALSE;
        }
        if ($re) {
            $this->form_validation->set_message('checkexists', $this->lang->line('currency_already exist'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function search() {
        switch ($this->input->get('search_term')) {
            case 'currency_search':
                $this->currency_search();
                break;
            default:
                break;
        }
    }

    public function currency_search() {
        $search = $this->input->get('search');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');

        $filters = array();

        $incomes = $this->Currencies->currency_search($search, $filters, $limit, $offset, $sort, $order);

        $total_rows = $this->Currencies->currency_found_rows($search, $filters);

        $data_rows = array();
        foreach ($incomes->result() as $incomes_row) {
            $data_rows[] = get_currency_data_row($incomes_row, $this);
        }

        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

    public function viewcurrency($id = NULL) {
        if (!empty($id)) {
            $data['id'] = $id;
            $this->load->view("currency/updatecurrency", $data);
        } else {
            
        }
    }

    public function updatecurrency($id = '') {
        $this->form_validation->set_rules('currency_date', 'lang:currency_date', 'trim|required');
        $this->form_validation->set_rules('rate', 'lang:currency_rate', 'trim|required|callback_numeric');
        if ($this->form_validation->run() != FALSE) {
            $insert_array = array(
                'rate' => $_POST['rate'],
                'date' => date('Y-m-d H:i:s', strtotime($_POST['currency_date']))
            );
            $currency_id = $this->Currencies->update_currency($insert_array, $id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('currency_success_update'), 'id' => $currency_id));
        } else {
            $data['error_list'] = $this->form_validation->error_array();
            echo json_encode(array('success' => FALSE, 'error' => $data['error_list']));
        }
    }

    public function excel() {
        $name = 'import_currency_rate.csv';
        $data = file_get_contents('../' . $name);
        force_download($name, $data);
    }

    public function excel_import() {
        $this->load->view('currency/form_excel_import', NULL);
    }

    public function do_excel_import() {
        if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('currency_excel_import_failed')));
        } else {
            if (($handle = fopen($_FILES['file_path']['tmp_name'], 'r')) !== FALSE) {
// Skip the first row as it's the table description
                fgetcsv($handle);
                $i = 1;

                $failCodes = array();

                while (($data = fgetcsv($handle)) !== FALSE) {
// XSS file data sanity check
                    $data = $this->xss_clean($data);
                    $newDate = date('Y-m-d H:i:s');
                    if (sizeof($data) >= 3) {
                        if (isset($data[1]) && !empty($data[1])) {
                            $newDate = date("Y-m-d H:i:s", strtotime($data[1]));
                        }
                        $insert_array = array(
                            'code' => $data[0],
                            'rate' => $data[2],
                            'date' => $newDate
                        );
                        $invalidated = $this->Currencies->updateexportdata($insert_array);
                        if ($invalidated == "0") {
                            $failCodes[] = $i;
                        }
                    } else {
                        $failCodes[] = $i;
                    }
                    ++$i;
                }

                if (count($failCodes) > 0) {
                    $message = $this->lang->line('currency_excel_import_partially_failed') . ' (' . count($failCodes) . '): ' . implode(', ', $failCodes);

                    echo json_encode(array('success' => FALSE, 'message' => $message, 'status' => 0));
                } else {
                    echo json_encode(array('success' => TRUE, 'message' => $this->lang->line('currency_excel_import_success'), 'status' => 1));
                }
            } else {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('currency_excel_import_nodata_wrongformat'), 'status' => 0));
            }
        }
    }

    //Graphical summary sales report
    public function graph($start_date = '', $end_date = '', $currency_id = '2') {
        if (empty($start_date)) {
            $start_date = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
        }
        if (empty($end_date)) {
            $end_date = date('Y-m-d', mktime(0, 0, 0, date("m") + 1, 1, date("Y")) - 1);
        }

        $inputs = array('start_date' => $start_date, 'end_date' => $end_date, 'currency_id' => $currency_id);
        $currency_list = $this->Currencies->get_currency_list();
        //pre($currency_list);
        $report_data = $this->Currencies->getGrapData($inputs)->result_array();
        //pre($report_data);

        $labels = array();
        $series = array();

        foreach ($report_data as $row) {
            $row = $this->xss_clean($row);

            $date = date($this->config->item('dateformat'), strtotime($row['date']));
            $labels[] = $date;
            $series[] = array('meta' => $date, 'value' => $row['rate']);
        }

        $data = array(
            'title' => $this->lang->line('currency_graph_report'),
            'subtitle' => $this->_get_subtitle_report(array('start_date' => $start_date, 'end_date' => $end_date, 'currency_id' => $currency_id)),
            'chart_type' => 'reports/graphs/line',
            'labels_1' => $labels,
            'series_data_1' => $series,
            'yaxis_title' => $this->lang->line('reports_revenue'),
            'xaxis_title' => $this->lang->line('reports_date'),
            'show_currency' => TRUE,
            'currency_list' => $currency_list
        );

        $this->load->view('currency/graphical', $data);
    }

    public function showimportdata() {
        if (!empty($_FILES))
            if ($_FILES['file_path']['error'] != UPLOAD_ERR_OK) {
                echo json_encode(array('success' => FALSE, 'message' => $this->lang->line('currency_excel_import_failed')));
            } else {
                if (($handle = fopen($_FILES['file_path']['tmp_name'], 'r')) !== FALSE) {
// Skip the first row as it's the table description
                    fgetcsv($handle);
                    $check = 0;
                    $i = 1;
                    $failCodes = array();
                    $html_table = '<h4 id="page_title" class=" text-center">' . $this->lang->line('currency_import_items_table_header') . '</h2>';
                    $html_table.="<table class='table table-striped'><tr><th>Sl.No</th><th>Currency Code</th><th>Date</th><th>Exchange Rate</th></tr>";
                    while (($data = fgetcsv($handle)) !== FALSE) {
                        $error_msg = '';
                        $data = $this->xss_clean($data);

                        if (isset($data[0]) && !empty($data[0])) {
                            $check_code_exists = $this->Currencies->exists(array('code' => $data[0]));
                            if ($check_code_exists == "") {
                                $error_msg .= $this->lang->line('currency_code_invalid') . ",";
                                $check ++;
                            }
                        } else {
                            $error_msg .= $this->lang->line('currency_code_required') . ",";
                            $check ++;
                        }

                        if (isset($data[1]) && !empty($data[1])) {
                            $date = date_parse($data[1]);
                            if ($date["error_count"] == 0 && checkdate($date["month"], $date["day"], $date["year"])) {
                                
                            } else {
                                $error_msg .= $this->lang->line('currency_date_invalid') . ",";
                                $check ++;
                            }
                        } else {
                            $error_msg .=$this->lang->line('currency_date_required') . ",";
                            $check ++;
                        }

                        if (isset($data[2]) && !empty($data[2])) {
                            if (!ctype_digit((string) $data[2])) {
                                $error_msg .= $this->lang->line('currency_rate_invalid') . ",";
                                $check ++;
                            }
                        } else {
                            $error_msg .= $this->lang->line('currency_rate_required') . ",";
                            $check ++;
                        }
                        if (sizeof($data) >= 3) {
                            if ($error_msg == "") {
                                $html_table.="<tr><td>" . $i . "</td><td>" . $data[0] . "</td><td>" . $data[1] . "</td><td>" . $data[2] . "</td></tr>";
                            } else {
                                $html_table.="<tr style='border: 1px solid red;'><td>" . $i . "</td><td colspan='3'>" . rtrim($error_msg, ',') . "</td></tr>";
                            }
                        } else {
                            $check++;
                        }
                        $i++;
                    }
                    $html_table.="</table>";
                    echo json_encode(array('success' => TRUE, 'message' => $html_table, 'count' => $check));
                } else {
                    echo $this->lang->line('currency_excel_import_nodata_wrongformat');
                }
            }
    }

    //	Returns subtitle for the reports
    private function _get_subtitle_report($inputs) {
        $subtitle = '';
        
        if($inputs['currency_id']){
            $subtitle .=' 1 Laotian Kip equals to ' .$this->Currencies->getCurrencyName($inputs['currency_id']).' (';
        }
        
        if (empty($this->config->item('date_or_time_format'))) {
            $subtitle .= date($this->config->item('dateformat'), strtotime($inputs['start_date'])) . ' - ' . date($this->config->item('dateformat'), strtotime($inputs['end_date']));
        } else {
            $subtitle .= date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime(rawurldecode($inputs['start_date']))) . ' - ' . date($this->config->item('dateformat') . ' ' . $this->config->item('timeformat'), strtotime(rawurldecode($inputs['end_date'])));
        }

        return $subtitle. ') ';
    }

}

?>
