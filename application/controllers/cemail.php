<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cemail extends CI_Controller {

	var $hostname;
	var $login;
	var $current_folder;
	var $host;	
	var $from_email;	
	var $full_name;
	
	function __construct() {
		parent::__construct();
		$this->template->current_menu = 'inbox_mail';

		$this->hostname='{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}';
		$this->login='test@cellexltd.com';
		$this->pass='practice_mail';
		$this->host = $this->hostname."SENT";
		$this->from_email = "test@cellexltd.com";
		$this->full_name = "Test Email Ticketing";
    }
    
	public function junk()
	{
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('junk_mail');
		$this->template->current_menu = 'junk_mail';
		$CI->load->library('dashboard');
		$CI->load->model('emails');
		$content = $CI->dashboard->home_page("junk_email");
		$sub_menu = array();
		$this->template->full_html_view($content,$sub_menu);
	}

	public function response($email_id=null)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('do_response');
		$CI->load->model('emails');
		$CI->load->library('email');
		
		if (!$email_id) {			
			$this->session->set_userdata(array('error_message'=>"Did not select email !"));
			redirect(base_url('email'));
			exit();
		}				
        $data = array("email_id"=>$email_id,"response_edit_data" =>$this->emails->get_response_edit_data($email_id));
		$CI->load->view("email/response_edit",$data);
	}

	public function do_response()
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('do_response');
		$CI->load->model('emails');
		$CI->load->library('email');
		$email_id = $this->input->post('email_id');
		$this->emails->do_edit_response();
		$this->response_to_client($email_id);
		$this->session->set_userdata(array('message'=>"Succesfully Updated !"));
		redirect(base_url('dashboard'));
		exit();
	}	
	
	public function response_to_client($email_id)
	{	
		$CI =& get_instance();
		$CI->load->library('email');
		$CI->load->model('emails');

		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$get_mail_info = $this->emails->get_sender_detail($email_id);

		if (! empty($get_mail_info)) {

			$estimate_time = $this->emails->get_estimate_time($email_id);

			$this->email->from($this->from_email,$this->full_name);
			$email_subject="Cellex Limited";

			$full_message  ="Dear Concern,<br/>";
			$full_message .="Greetings from Cellex Limited.<br/>";
			$full_message .="The status of your quarry / complain is: <br/>";
			$full_message .="<strong>Ticket Number: “".$get_mail_info[0]['ticket_no']."”</strong> [ Please keep the Ticket Number for further uses ]<br/>";
			$full_message .="<strong>Estimated Time Required :  “". $estimate_time ."”  Minutes</strong><br/>";
			$full_message .="[ Please conceder “Technical issues” if it takes longer then Estimated Time to resolve. Our team is working on it.] <br/>";
			$full_message .="Thank you. We always appreciate your business with us.<br/>";
			$full_message .="<br/>";
			$full_message .="Cellex_Noc contact details:-<br/>";
			$full_message .="Phone: <strong>(+88) 01790 33 22 00</strong><br/>";
			$full_message .="Skype ID: <strong>cellex_noc</strong><br/>";
			$full_message .="<a href='www.cellexltd.com' target='_blank'>www.cellexltd.com </a>";

			$this->email->to($get_mail_info[0]['from_email_id']);
			$this->email->subject($email_subject);
			$this->email->message($full_message); 
			$this->email->send(); 
		}

	}

	public function view_detail($email_no)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('view_detail_mail');
		$CI->load->library('lmail');
		
		$content = $CI->lmail->get_view_detail($email_no);
		$sub_menu = array();
		$this->template->full_html_view($content,$sub_menu);
	}

	public function compose_mail()
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('new_email');		
		$this->template->current_menu = 'new_mail';
		$CI->load->library('lmail');
		$this->load->library('email');
		$this->load->model('emails');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$this->email->from($this->from_email,$this->full_name);
		
		if($this->lmail->validateForm()){			
			$to_mail_list = $this->valid_email_check($this->input->post('to_email'));
			$cc_mail_list = $this->valid_email_check($this->input->post('cc_email'));
			$bcc_mail_list = $this->valid_email_check($this->input->post('bcc_email'));
			$email_subject = $this->input->post('email_subject');
			$full_message = $this->input->post('message');
			$full_message = htmlentities($full_message);
			$full_message = htmlspecialchars_decode($full_message, ENT_NOQUOTES);

			$this->email->to($to_mail_list);
			if(!empty($cc_mail_list)){
				$this->email->cc($cc_mail_list);
			}
			
			if(!empty($bcc_mail_list)){				
				$this->email->bcc($bcc_mail_list);
			}
			$this->email->subject($email_subject);
			$this->email->message($full_message); 
			$this->email->send(); 	
			
			$email_stream =imap_open($this->hostname, $this->login, $this->pass);

			imap_append($email_stream,$this->host
	                   , "From: ". $this->from_email ."\r\n"
	                   . "To: ". $this->input->post('to_email') ."\r\n"
	                   . "Subject:". $email_subject ."\r\n"	                   
	                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
	                   . "\r\n"
	                   . $full_message
	                   );
			// Entry to contact List
			$this->entry_to_contact($to_mail_list);

			$this->session->set_userdata(array('message'=>"Email Successfuly Send !"));
			redirect(base_url('dashboard'));
			exit();
		}else{
			$content = $CI->lmail->send_mail_form();
			$sub_menu = array();
			$this->template->full_html_view($content,$sub_menu);
		}
	}

	public function reply_to($email_no=null)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('reply_to');	
		$CI->load->library('lmail');
		$this->load->library('email');
		$this->load->model('emails');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$this->email->from($this->from_email,$this->full_name);
		
		if($this->lmail->validateForm()){			
			$to_mail_list = $this->valid_email_check($this->input->post('to_email'));
			$cc_mail_list = $this->valid_email_check($this->input->post('cc_email'));
			$bcc_mail_list = $this->valid_email_check($this->input->post('bcc_email'));
			$email_subject = $this->input->post('email_subject');
			$full_message = $this->input->post('message');
			$full_message = htmlentities($full_message);
			$full_message = htmlspecialchars_decode($full_message, ENT_NOQUOTES);

			$this->email->to($to_mail_list);
			if(!empty($cc_mail_list)){
				$this->email->cc($cc_mail_list);
			}
			
			if(!empty($bcc_mail_list)){				
				$this->email->bcc($bcc_mail_list);
			}
			$this->email->subject($email_subject);
			$this->email->message($full_message); 
			$this->email->send(); 	
			
			$email_stream =imap_open($this->hostname, $this->login, $this->pass);

			imap_append($email_stream,$this->host
	                   , "From: ". $this->from_email ."\r\n"
	                   . "To: ". $this->input->post('to_email') ."\r\n"
	                   . "Subject:". $email_subject ."\r\n"	                   
	                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
	                   . "\r\n"
	                   . $full_message
	                   );
			// Entry to contact List
			$this->entry_to_contact($to_mail_list);

			$this->session->set_userdata(array('message'=>"Email Successfuly Send !"));
			redirect(base_url('dashboard'));
			exit();
		}else{
			$content = $CI->lmail->get_reply_to_view($email_no,$reply_to=FALSE);
			$sub_menu = array();
			$this->template->full_html_view($content,$sub_menu);
		}
	}


	public function reply_to_all($email_no=null)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('reply_to_all');	
		$CI->load->library('lmail');
		$this->load->library('email');
		$this->load->model('emails');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$this->email->from($this->from_email,$this->full_name);
		
		if($this->lmail->validateForm()){			
			$to_mail_list = $this->valid_email_check($this->input->post('to_email'));
			$cc_mail_list = $this->valid_email_check($this->input->post('cc_email'));
			$bcc_mail_list = $this->valid_email_check($this->input->post('bcc_email'));
			$email_subject = $this->input->post('email_subject');
			$full_message = $this->input->post('message');
			$full_message = htmlentities($full_message);
			$full_message = htmlspecialchars_decode($full_message, ENT_NOQUOTES);

			$this->email->to($to_mail_list);
			if(!empty($cc_mail_list)){
				$this->email->cc($cc_mail_list);
			}
			
			if(!empty($bcc_mail_list)){				
				$this->email->bcc($bcc_mail_list);
			}
			$this->email->subject($email_subject);
			$this->email->message($full_message); 
			$this->email->send(); 	
			
			$email_stream =imap_open($this->hostname, $this->login, $this->pass);

			imap_append($email_stream,$this->host
	                   , "From: ". $this->from_email ."\r\n"
	                   . "To: ". $this->input->post('to_email') ."\r\n"
	                   . "Subject:". $email_subject ."\r\n"	                   
	                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
	                   . "\r\n"
	                   . $full_message
	                   );
			// Entry to contact List
			$this->entry_to_contact($to_mail_list);

			$this->session->set_userdata(array('message'=>"Email Successfuly Send !"));
			redirect(base_url('dashboard'));
			exit();
		}else{
			$content = $CI->lmail->get_reply_to_view($email_no,$reply_to=TRUE);
			$sub_menu = array();
			$this->template->full_html_view($content,$sub_menu);
		}
	}


	public function done($email_no=null)
	{			
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('done');	
		$CI->load->library('lmail');
		$this->load->library('email');
		$this->load->model('emails');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$this->email->initialize($config);

		$this->email->from($this->from_email,$this->full_name);
		
		if($this->lmail->validateForm()){			
			$to_mail_list = $this->valid_email_check($this->input->post('to_email'));
			$cc_mail_list = $this->valid_email_check($this->input->post('cc_email'));
			$bcc_mail_list = $this->valid_email_check($this->input->post('bcc_email'));
			$email_subject = $this->input->post('email_subject');
			$full_message = $this->input->post('message');
			$full_message = htmlentities($full_message);
			$full_message = htmlspecialchars_decode($full_message, ENT_NOQUOTES);

			$this->email->to($to_mail_list);
			if(!empty($cc_mail_list)){
				$this->email->cc($cc_mail_list);
			}
			
			if(!empty($bcc_mail_list)){				
				$this->email->bcc($bcc_mail_list);
			}
			$this->email->subject($email_subject);
			$this->email->message($full_message); 
			$this->email->send(); 	
			
			$email_stream =imap_open($this->hostname, $this->login, $this->pass);

			imap_append($email_stream,$this->host
	                   , "From: ". $this->from_email ."\r\n"
	                   . "To: ". $this->input->post('to_email') ."\r\n"
	                   . "Subject:". $email_subject ."\r\n"	                   
	                   . "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n"
	                   . "\r\n"
	                   . $full_message
	                   );
			// Entry to contact List
			$this->emails->change_done_sts($email_no);

			$this->session->set_userdata(array('message'=>"Email Successfuly Send !"));
			redirect(base_url('dashboard'));
			exit();
		}else{
			$content = $CI->lmail->do_done($email_no,$reply_to=TRUE);
			$sub_menu = array();
			$this->template->full_html_view($content,$sub_menu);
		}
	}

	private function valid_email_check($email_list)
	{	
		$email_list = str_replace(' ','',$email_list); 
		$last_chr = substr($email_list, -1, 1);
		if($last_chr==","){
			$to_mail_list = substr($email_list,0, -1);
		}
		$email_list = explode(',',$email_list);
		return $email_list;
	}

	private function entry_to_contact($email_list)
	{	
		$CI =& get_instance();
		$this->load->model('emails');

		foreach ($email_list as $value) {
			if($CI->emails->email_existency_cheeck($value)){	
				$contact_list['full_name'] 	= $value;
				$contact_list['email_id'] 	= $value;
				$contact_list['status'] 	= 1;		
				$CI->emails->contact_insert($contact_list);
			}
		}
		//Update contact page
		$CI->emails->update_json_contact_page();
	}

	public function delete()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('delete_email');
		$CI->load->model('emails');
		$email_id =  $_POST['email_id'];
		$CI->emails->do_delete($email_id);
		return true;	
	}

	public function check_for_new_mail()
	{	
		$CI =& get_instance();
		$CI->load->library('sync_email');
		$CI->sync_email->synchronization();
	}

}