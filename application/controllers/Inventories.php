<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Inventories extends Secure_Controller {

    public function __construct() {
        parent::__construct('inventories');
    }

    public function index($location_id = 'all', $item_count = 'all') {
        $inputs = array('location_id' => $location_id, 'item_count' => $item_count);

        $this->load->model('reports/Inventory_summary');
        $model = $this->Inventory_summary;

        $report_data = $model->getData($inputs);

        $tabular_data = array();
        foreach ($report_data as $row) {
            $tabular_data[] = $this->xss_clean(array(
                'item_name' => $row['name'],
                'item_number' => $row['item_number'],
                'quantity' => to_quantity_decimals($row['quantity']),
                'reorder_level' => to_quantity_decimals($row['reorder_level']),
                'location_name' => $row['location_name'],
                'cost_price' => to_currency($row['cost_price']),
                'unit_price' => to_currency($row['unit_price']),
                'subtotal' => to_currency($row['sub_total_value']),
                'details' => anchor("inventories/details/" . $row['item_id'] . '/' . $row['location_id'], '<span class="glyphicon glyphicon-list-alt"></span>', array('class' => 'modal-dlg', 'title' => $this->lang->line('inventories_details_count')))
            ));
        }

        $data = array(
            'title' => $this->lang->line('inventory_summary_report'),
            'subtitle' => '',
            'headers' => $this->xss_clean($model->getDataColumns()),
            'data' => $tabular_data,
            'summary_data' => $this->xss_clean($model->getSummaryData($report_data)),
            'title1' => 'inventory_low',
            'title2' => 'inventory_valuation',
            'method1' => 'low',
            'method2' => 'summaryvaluation'
        );
        $item_locations = $this->xss_clean($this->Stock_location->get_all_locations(''));
        $item_locations['all'] = $this->lang->line('reports_all');
        $data['item_locations'] = array_reverse($item_locations, TRUE);

        $data['item_location'] = ($location_id == 'all') ? 'all' : $location_id;
        $data['item_count_id'] = ($item_count == 'all') ? 'all' : $item_count;
        $data['item_count'] = $model->getItemCountDropdownArray();

        $this->load->view('inventory/manage', $data);
    }

    public function summary_input() {
        $this->load->model('reports/Inventory_summary');
        $model = $this->Inventory_summary;

        $data = array();
        $data['item_count'] = $model->getItemCountDropdownArray();

        $item_locations = $this->xss_clean($this->Stock_location->get_all_locations(''));
        $item_locations['all'] = $this->lang->line('reports_all');
        $data['item_locations'] = array_reverse($item_locations, TRUE);

        $this->load->view('inventory/summary_input', $data);
    }

    public function low($location_id = 'all') {
        $inputs = array('location_id' => $location_id);

        $this->load->model('reports/Inventory_low');
        $model = $this->Inventory_low;

        $report_data = $model->getData($inputs);

        $tabular_data = array();
        foreach ($report_data as $row) {
            $tabular_data[] = $this->xss_clean(array(
                'item_name' => $row['name'],
                'item_number' => $row['item_number'],
                'quantity' => to_quantity_decimals($row['quantity']),
                'reorder_level' => to_quantity_decimals($row['reorder_level']),
                'location_name' => $row['location_name']
            ));
        }

        $data = array(
            'title' => $this->lang->line('inventory_low_report'),
            'subtitle' => '',
            'headers' => $this->xss_clean($model->getDataColumns()),
            'data' => $tabular_data,
            'summary_data' => $this->xss_clean($model->getSummaryData($inputs)),
            'title1' => 'inventory_summary',
            'title2' => 'inventory_valuation',
            'method1' => '',
            'method2' => 'summaryvaluation'
        );

        $item_locations = $this->xss_clean($this->Stock_location->get_all_locations(''));
        $item_locations['all'] = $this->lang->line('reports_all');
        $data['item_locations'] = array_reverse($item_locations, TRUE);
        $data['item_location'] = ($location_id == 'all') ? 'all' : $location_id;
        $this->load->view('inventory/manage', $data);
    }

    public function summaryvaluation($item_location = NULL) {
        $inputs = array();
        $item_locations = $this->xss_clean($this->Stock_location->get_all_locations(''));
        $item_locations['all'] = $this->lang->line('reports_all');
        // $item_locations = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $this->load->model('reports/Inventory_valuation');
        $model = $this->Inventory_valuation;
        $details_data = array();
        $inputs = array(
            'item_location' => (!empty($item_location)) ? $item_location : key($item_locations)
        );
        $report_data = $model->getData($inputs);
        //echo $this->db->last_query();
        $tabular_data = array();
        foreach ($report_data as $row) {
            $getSingleData = array();
            $tabular_data[] = $this->xss_clean(array(
                'item_id' => $row['item_id'],
                'item_name' => $row['name'],
                'item_number' => $row['item_number'],
                'location_name' => $row['location_name'],
                'total_quantity' => to_quantity_decimals($row['total_quantity']),
                'total_price' => to_currency($row['total_price']),
            ));
            $getSingleData = $model->getSingleData($row['item_id'], $inputs);
            foreach ($getSingleData as $drow) {
                $details_data[$row['item_id']][] = $this->xss_clean(array($drow['receiving_time'], $drow['receiving_ref'], $drow['location_name'], $drow['receiving_quantity'], $drow['total_price']));
            }
        }

        $data = array(
            'title' => $this->lang->line('inventory_valuation_report'),
            'subtitle' => '',
            'headers' => $this->xss_clean($model->getDataColumns()),
            'data' => $tabular_data,
            'summary_data' => $this->xss_clean($model->getSummaryData($inputs)),
            'details_data' => $details_data,
            'item_locations' => array_reverse($item_locations, TRUE),
            'item_location' => ($item_location == 'all') ? 'all' : $item_location
        );

        $this->load->view('inventory/valuation_details', $data);
    }

    public function details($item_id, $location_id) {
        $item_info = $this->Item->get_info($item_id);
        foreach (get_object_vars($item_info) as $property => $value) {
            $item_info->$property = $this->xss_clean($value);
        }
        $data['item_info'] = $item_info;
        $data['location_id'] = $location_id;
        $data['stock_locations'] = array();
        $stock_locations_sub = $this->Stock_location->get_undeleted_all()->result_array();
        $warehouse_locations = $this->Stock_location->get_undeleted_all('items', 'warehouse')->result_array();
        $stock_locations = merge($stock_locations_sub, $warehouse_locations);

        foreach ($stock_locations as $location) {
            $location = $this->xss_clean($location);
            $quantity = $this->xss_clean($this->Item_quantity->get_item_quantity($item_id, $location['location_id'])->quantity);

            $data['stock_locations'][$location['location_id']] = $location['location_name'];
            $data['item_quantities'][$location['location_id']] = $quantity;
        }
        $data['inventory_array'] = $this->Inventory->get_inventory_data_for_item($item_id, $location_id)->result_array();
        $data['print_after_sale'] = FALSE;
        $this->load->view('inventory/view_details_count', $data);
    }

    public function log() {
        $data['table_headers'] = $this->xss_clean(get_inventory_log_list());
        $data['item_locations'] = $this->Stock_location->get_allowed_locations('purchase_order', 'warehouse');
        $this->load->view('inventory/loglist', $data);
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
        $filters['item_locations'] = $this->input->get('item_locations');


        $receivings = $this->Inventory->inventory_log_search($search, $filters, $limit, $offset, $sort, $order);
        $total_rows = $this->Inventory->get_inventory_log_rows($search, $filters);

        $data_rows = array();
        foreach ($receivings->result() as $receiving_row) {
            $data_rows[] = get_inventory_log_data_row($receiving_row, $this);
        }
        $data_rows = $this->xss_clean($data_rows);

        echo json_encode(array('total' => $total_rows, 'rows' => $data_rows));
    }

}

?>
