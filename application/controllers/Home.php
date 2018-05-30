<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once("Secure_Controller.php");

class Home extends Secure_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
    }

    public function index() {
        $data = array();
        $employee_id = $this->Employee->get_logged_in_employee_info()->person_id;
        $data['total_sales'] = $this->Homemodel->gettotal_sales($employee_id);
        $data['total_pay_sublier'] = $this->Homemodel->gettotal_pay_supplier($employee_id);
        $data['inventories'] = array('low' => 0, 'hand' => 0, 'to_be_received' => 0);

      
        $data['inventories']['low'] = to_decimals($this->Homemodel->getItemsCounts(),0);
        $data['inventories']['hand'] =  to_decimals($this->Homemodel->getHandCounts(),0);
        $data['inventories']['to_be_received'] =  to_decimals($this->Homemodel->getToBeReceived(),0);
        $data['total_stock_value']=  $this->Homemodel->getTotalStockValue();
        
        $data['total_profit_loss_value']=  $this->Homemodel->getProfitLossValue();
        
        $start_date='2017-06-01';
        $end_date='2017-06-09';
        
        $data['sales_report']=  $this->Homemodel->sales_report($start_date,$end_date);     
        $data['sales_store_report']=  $this->Homemodel->sales_store_report($start_date,$end_date);     
        $data['purchase_report']=  $this->Homemodel->purchase_report($start_date,$end_date);        
        $this->load->view('home', $data);
    }

    public function logout() {
        $this->track_page('logout', 'logout');
        if (!empty(get_cookie('remember_username'))) {
            delete_cookie('remember_username');
            delete_cookie('remember_password');
        }
        $this->Employee->logout();
    }

}

?>