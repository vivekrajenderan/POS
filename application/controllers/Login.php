<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email_lib');
        $this->load->helper('cookie');
    }

    public function index() {
        if ($this->Employee->is_logged_in()) {
            redirect('home');
        } else {
            $this->form_validation->set_rules('username', 'lang:login_undername', 'callback_login_check');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

            if ($this->form_validation->run() == FALSE && !$this->login_check('')) {
                $this->load->view('login');
            } else {
//				if($this->config->item('statistics'))
//				{
//					$this->load->library('tracking_lib');
//					
//					$this->tracking_lib->track_page('login', 'login');
//					
//					$this->tracking_lib->track_event('Stats', 'Theme', $this->config->item('theme'));
//					$this->tracking_lib->track_event('Stats', 'Language', $this->config->item('language'));
//					$this->tracking_lib->track_event('Stats', 'Timezone', $this->config->item('timezone'));
//					$this->tracking_lib->track_event('Stats', 'Currency', $this->config->item('currency_symbol'));
//					$this->tracking_lib->track_event('Stats', 'Customer Sales Tax Support', $this->config->item('customer_sales_tax_support'));
//					$this->tracking_lib->track_event('Stats', 'Tax Included', $this->config->item('tax_included'));
//					$this->tracking_lib->track_event('Stats', 'Thousands Separator', $this->config->item('thousands_separator'));
//					$this->tracking_lib->track_event('Stats', 'Currency Decimals', $this->config->item('currency_decimals'));
//					$this->tracking_lib->track_event('Stats', 'Tax Decimals', $this->config->item('tax_decimals'));
//					$this->tracking_lib->track_event('Stats', 'Quantity Decimals', $this->config->item('quantity_decimals'));
//					$this->tracking_lib->track_event('Stats', 'Invoice Enable', $this->config->item('invoice_enable'));
//					$this->tracking_lib->track_event('Stats', 'Date or Time Format', $this->config->item('date_or_time_format'));
//				}

                redirect('home');
            }
        }
    }

    public function login_check($username) {
        $password = $this->input->post('password');
        if (!empty(get_cookie('remember_username'))) {
            $username = get_cookie('remember_username');
            $password = get_cookie('remember_password');
        }
        //if (!$this->Employee->login($data['username'], $data['password'])) {
        if (!$this->Employee->login($username, $password)) {
            $this->form_validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
            return FALSE;
        }

        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
            $cookiedata = array(
                'name' => 'remember_username',
                'value' => $username,
                'expire' => '86400',
            );
            set_cookie($cookiedata);
            $cookiedata = array(
                'name' => 'remember_password',
                'value' => $password,
                'expire' => '86400',
            );
            set_cookie($cookiedata);
        }
        return TRUE;
    }

    public function recovery_details() {
        $data = array();
        $this->load->view('forget_password', $data);
    }

    public function resetpassword() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'lang:login_username', 'trim|required|callback_checkusername');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('forget_password');
        } else {
            $row = $this->Employee->checkusername(array('username' => $_POST['username']));
            $to = $row['email'];
            //$subject = $this->lang->line('sales_invoice') . ' ' . $sale_data['invoice_number'];
            $subject = 'Reset Password';
            $text = 'Dear $name,\n\n Welcome Sokxay Reset Password \n\n Change password link : $link, \n\n If you have any questions, please contact our support team.';
//            $text = $this->config->item('invoice_email_message');
            $text = str_replace('$name', $row['first_name'] . ' ' . $row['last_name'], $text);
            $text = str_replace('$link', base_url() . 'login/getnewpassword/' . md5($row['person_id'] . '-' . $row['username']), $text);
            $employee = array('forgotpassword' => md5($row['person_id'] . '-' . $row['username']));
            $this->Employee->change_password($employee, $row['person_id']);
            $result = $this->email_lib->sendEmail($to, $subject, $text);
            $data['forgetpassword_status'] = true;
            $this->load->view('forget_password', $data);
        }
    }

    public function getnewpassword($id) {
        $employeedata = $this->Employee->checkusername(array("forgotpassword" => $id));
        $data['resetpassword_status'] = (!$employeedata) ? true : false;
        $data['person_id'] = $id;
        if ($_POST) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('newpassword', 'lang:login_newpassword', 'trim|required');
            $this->form_validation->set_rules('retypepassword', 'lang:login_retypepassword', 'trim|required|matches[newpassword]');
            if ($this->form_validation->run() == FALSE) {
                $data['error'] = $this->form_validation->error_array();
            } else {
                $employee = array('password' => password_hash($_POST['newpassword'], PASSWORD_DEFAULT),'forgotpassword'=>'');
                $this->Employee->change_password($employee, $employeedata['person_id']);
                redirect('/login');
            }
        }
        $this->load->view('reset_password', $data);
    }

    public function checkusername($username) {
        if (isset($_POST['username']) && $_POST['username'] != '') {
            if (!$this->Employee->checkusername(array('username' => $username))) {
                $this->form_validation->set_message('checkusername', $this->lang->line('login_invalid_email'));
                return FALSE;
            }
            return TRUE;
        }
        return TRUE;
    }

    private function _security_check($username, $password) {
        return preg_match('~\b(Copyright|(c)|©|All rights reserved|Developed|Crafted|Implemented|Made|Powered|Code|Design|unblockUI|blockUI|blockOverlay|hide|opacity)\b~i', file_get_contents(APPPATH . 'views/partial/footer.php'));
    }

}

?>
