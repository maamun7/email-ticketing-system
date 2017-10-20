<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cpayment extends CI_Controller {
	
	function __construct() {
      parent::__construct();	  
	  $this->template->current_menu = 'payment';
    }
	public function index()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_payment');
		$CI->load->library('payment');
		$CI->load->model('payments');

		$base_url = base_url()."payment/index";
		$total_rows = 500;//$this->payments->total_payment();	
		$limit_per_page = 25;
		$config = get_pagination_config($base_url,$total_rows,$limit_per_page,$uri_segment='');
		$this->pagination->initialize($config);	
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;		
	    $links = $this->pagination->create_links();
		
        $content = '';//$CI->payment->get_list_view($limit_per_page,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage Subject', 'url' => 'payment','class' =>'active'),
				array('label'=> 'New Subject', 'url' => 'payment/add')
			);
		$this->template->full_html_view($content,$sub_menu);
	}
	
	public function add()
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('add_payment');
		$CI->load->library('payment');
		$CI->load->model('payments');
		
		if($this->payment->validateForm()){
		
			
			$payment_data = $this->input->post('transaction_data');
			$payment_data = htmlspecialchars_decode($payment_data);
			
			//$lastSpace = strrpos($payment_data," ");
			
			//$payment_data = strval($payment_data);
			//$payment_data = "S81135584 15-Oct-14 CWDR/0006/1540202500968001 8500 6500";
			
			$input = str_replace(","," // ", $payment_data);
			//$to_mail_list = explode(' ',$input);
			echo "<br/>====";
			print_r($input);
			echo "<br/>====";
			exit();
			
		
		
		
		
			$data = array(
				'id' 	=> null, 
				'subject_id' 		=> $this->input->post('subject_id'), 
				'payment_name' 		=> $this->input->post('payment_name'),
				'published' 		=> $this->input->post('published_sts'),
				'ordering'			=> $this->input->post('ordering'),
				'created_at' 		=> current_bd_date_time(),
				'creator_id' 		=> $this->auth->get_user_id()
			);	

			$CI->payments->insert($data);

			$this->session->set_userdata(array('message'=>"Successfully Added !"));
			if(isset($_POST['add-payment'])){
				redirect(base_url('payment'));
				exit;
			}elseif(isset($_POST['add-payment-another'])){
				redirect(base_url('payment/add'));
				exit;
			}				
		}else{
			$content = $CI->payment->add_form();
			$sub_menu = array(
				array('label'=> 'Manage Subject', 'url' => 'payment'),
				array('label'=> 'New Subject', 'url' => 'payment/add','class' =>'active')
			);
			$this->template->full_html_view($content,$sub_menu);
		}
	}
	
	public function edit($category_id=null)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_payment');
		$CI->load->library('payment');
		$CI->load->model('payments');
		if (!$category_id) {			
			$this->session->set_userdata(array('error_message'=>"Did not select Subject !"));
			redirect(base_url('payment'));
			exit();
		}
		
		if($this->payment->validateForm()){

			$payment_id = $this->input->post('payment_id');
			$data = array(
				'subject_id' 		=> $this->input->post('subject_id'), 
				'payment_name' 		=> $this->input->post('payment_name'),
				'published' 		=> $this->input->post('published_sts'),
				'ordering'			=> $this->input->post('ordering'),
				'edited_at' 		=> current_bd_date_time(),
				'editor_id' 		=> $this->auth->get_user_id()
			);
			$CI->payments->update($data,$payment_id);
			$this->session->set_userdata(array('message'=>"Successfully Updated !"));
			redirect(base_url('payment'));
		}else{
			$content = $CI->payment->edit_form($category_id);
			$sub_menu = array(
				array('label'=> 'Manage Subject', 'url' => 'payment'),
				array('label'=> 'New Subject', 'url' => 'payment/add'),
				array('label'=> 'Edit Subject', 'url' => 'payment/edit/'.$category_id,'class' =>'active')
			);
			$this->template->full_html_view($content,$sub_menu);
		}
	}
	
	public function sub_categories()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_payment');
		$CI->load->model('payments');
		
		$cat_id =  $_POST['cat_id'];	
		$categories = $CI->payments->get_categories($cat_id);
		if ($categories) {
			echo"<option value=''>...Select Sub Category...</option>";
			foreach($categories as $category)
			{		
				echo "<option value='$category->id'>$category->name</option>";
			}
		} else {			
			echo"<option value=''>..No Sub Category Found..</option>";
		}
		
	}
	
	public function subjects()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_payment');
		$CI->load->model('payments');
		
		$sub_cat_id =  $_POST['sub_cat_id'];	
		$subjects = $CI->payments->get_subjects($sub_cat_id);
		if ($subjects) {
			echo"<option value=''>...Select Sub Category...</option>";
			foreach($subjects as $subject)
			{		
				echo "<option value='$subject->id'>$subject->subject_name</option>";
			}
		} else {			
			echo"<option value=''>..No Sub Category Found..</option>";
		}
		
	}

	public function change_status()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('change_payment_status');
		$CI->load->model('payments');
		$payment_id =  $_POST['payment_id'];
		$CI->payments->do_change_status($payment_id);
		$this->session->set_userdata(array('message'=>"Successfully Status Changed !"));
		redirect(base_url('payment'));
		return true;	
	}	

	public function delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_payment');
		$CI->load->model('payments');
		$payment_id =  $_POST['payment_id'];
		$CI->payments->do_delete($payment_id);
		$this->session->set_userdata(array('message'=>"Successfully Deleted !"));
		redirect(base_url('payment'));
		return true;	
	}	
	
	public function search_item()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('payment');
		$CI->load->library('payment');	
		$key_word = $this->input->post('key_word');	
		if($key_word =="") {
			$this->session->set_userdata(array('warning_message'=>"You didn't type any keyword !"));
			redirect(base_url('payment'));
		}		
        $content = $CI->payment->get_search_view($key_word);
        $sub_menu = array(
				array('label'=> 'Manage Subject', 'url' => 'payment'),
				array('label'=> 'New Subject', 'url' => 'payment/add'),
				array('label'=> 'Search Subject', 'url' => 'payment','class' =>'active')
			);
		$this->template->full_html_view($content,$sub_menu);
	}	

}