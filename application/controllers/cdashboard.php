<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cdashboard extends CI_Controller {
	
	function __construct() {
      parent::__construct();
    }
	
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_home');
		$this->template->current_menu = 'inbox_mail';
		$CI->load->library('dashboard');
		$CI->load->model('emails');
		if (!$this->auth->is_logged())
		{
			$this->output->set_header("Location: ".base_url().'dashboard/login', TRUE, 302);
		}
		$this->auth->check_auth();
		$content = $CI->dashboard->home_page("inbox_email");
		$sub_menu = array();
		$this->template->full_html_view($content,$sub_menu);
	}

	public function login()
	{	
		if ($this->auth->is_logged())
		{
			$this->output->set_header("Location: ".base_url().'dashboard', TRUE, 302);
		}
		$this->template->login_view();
	}
	
	//* Valid User Check..
	public function do_login()
	{	
		$error = '';
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if ( $username == '' || $password == '' || $this->auth->login($username, $password) === FALSE )
		{
			$error = 'Wrong user name or password';
		}
		if ( $error != '' )
		{
			$this->session->set_userdata(array('error_message'=>$error));
			$this->output->set_header("Location: ".base_url().'dashboard/login', TRUE, 302);
		}else{
			$this->output->set_header("Location: ".base_url().'dashboard/index', TRUE, 302);
        }
	}
	
	public function logout()
	{	
		if ($this->auth->logout())
		$this->output->set_header("Location: ".base_url().'dashboard/login', TRUE, 302);
	}

}