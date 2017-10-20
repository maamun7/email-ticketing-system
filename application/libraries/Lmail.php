<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lmail{
	var $error = array();	
	
	public function send_mail_form()
	{
		$CI =& get_instance();
		if (isset($this->error['error_to_email'])) {
			$this->data['error_to_email'] = $this->error['error_to_email'];
		} else {
			$this->data['error_to_email'] = '';
		}
		
		$this->data['to_email_value'] = $CI->input->post('to_email');
		$this->data['email_subject_value'] = $CI->input->post('email_subject');
		$this->data['cc_email_value'] = $CI->input->post('cc_email');
		$this->data['bcc_email_value'] = $CI->input->post('bcc_email');
		$this->data['message_value'] = $CI->input->post('message');

		$this->data['title'] = 'Compose New Mail';
		$this->data['action'] = base_url().'email/compose_mail';
		$html_view = $CI->parser->parse('email/new_email',$this->data,true);
		return $html_view;
	}

	public function validateForm()
	{	
		$CI =& get_instance();
		if(isset($_POST['to_email'])){
			if(strlen($CI->input->post('to_email'))==''){
				$this->error['error_to_email']="Provide recipient email address !";
			} elseif($this->valid_email_check($CI->input->post('to_email'))){
				$this->error['error_to_email']="Provided invalid email address !";
			}
		} else {
			$this->error['error_to_email']="";
		}
		
		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
	}
	
	private function valid_email_check($to_mail_list)
	{	
		$CI =& get_instance();
		$CI->load->helper('email');
		$flag = FALSE;
		$to_mail_list = str_replace(' ','',$to_mail_list); 
		$last_chr = substr($to_mail_list, -1, 1);
		if($last_chr==","){
			$to_mail_list = substr($to_mail_list,0, -1);
		}
		$to_mail_list = explode(',',$to_mail_list);
		
		foreach ($to_mail_list as $value)
		{
			trim($value);
			if($value !="")
			{
				if(valid_email($value))
				{
				//
				}else{
					$flag = TRUE;
				}
			}
		}
		return $flag;
	}

	public function auto_reply($ticket_no,$email_id)
	{			
		$CI =& get_instance();
		$this->load->library('email');
		$this->load->model('emails');

		$this->email->from('mamun@logic-thought.com','Mamun Ahmed');
		$email_subject = "";
		$full_message = "";
		
		$this->email->to($email_id);
		$this->email->subject($email_subject);
		$this->email->message($full_message); 
		$this->email->send(); 	

	}

	public function get_view_detail($email_no)
	{
		$CI =& get_instance();
		$CI->load->model('emails');
		$email_detail = $CI->emails->get_email_detail($email_no);

		$data = array(
			'title' => 'Email Detail View',
			'email_no' 			=> "",
			'from' 				=> "",
			'from_email_id' 	=> "",
			'cc_email_id' 		=> "",
			'reply_to_email' 	=> "",
			'date' 				=> "",
			'subject' 			=> "",
			'message' 			=> ""
		);

		if(!empty($email_detail)){	

			$cc_ids = json_decode($email_detail[0]['cc_email_ids']);
			if (! empty($cc_ids)) {
				$cc_ids = implode(",", $cc_ids);
			}
			$data = array(
				'title'  			=> 'Email Detail View',
				'email_no' 			=> $email_no,
				'from' 				=> $email_detail[0]['email_from'],
				'from_email_id' 	=> $email_detail[0]['from_email_id'],
				'cc_email_id' 		=> $cc_ids,
				'reply_to_email' 	=> $email_detail[0]['reply_to_email'],
				'date' 				=> substr($email_detail[0]['MailDate'],0,17),
				'subject' 			=> $email_detail[0]['subject'],
				'message' 			=> html_entity_decode($email_detail[0]['message'])
			);
		}

		$supplierList = $CI->parser->parse('email/email_detail_view',$data,true);
		return $supplierList;
	}

	public function get_reply_to_view($email_no,$reply_to=FALSE)
	{
		$CI =& get_instance();
		$CI->load->model('emails');
		$email_detail = $CI->emails->get_email_detail($email_no);
		$data = array();
		if(!empty($email_detail)){	
			$cc_ids = json_decode($email_detail[0]['cc_email_ids']);
			if (! empty($cc_ids)) {
				$cc_ids = implode(",", $cc_ids);
			}
			$action = base_url()."email/reply_to_all/".$email_no;
			if(!$reply_to){
				$cc_ids = "";
				$action = base_url()."email/reply_to/".$email_no;
			}
			$data = array(
				'title'  				=> 'Reply Email',
				'email_no' 				=> $email_no,
				'action' 				=> $action,
				'to_email_id' 			=> $email_detail[0]['to_email_id'],
				'from_email_id' 		=> $email_detail[0]['from_email_id'],
				'to_email_value' 		=> $email_detail[0]['from_email_id'].",",
				'cc_email_value' 		=> $cc_ids,
				'reply_to_email' 		=> $email_detail[0]['reply_to_email'],
				'date' 					=> substr($email_detail[0]['MailDate'],0,17),
				'email_subject_value' 	=> "Re: ".$email_detail[0]['subject'],
				'subject' 				=> $email_detail[0]['subject'],
				'message' 				=> html_entity_decode($email_detail[0]['message'])
			);
		}

		$supplierList = $CI->parser->parse('email/reply_to',$data,true);
		return $supplierList;
	}

	public function do_done($email_no)
	{
		$CI =& get_instance();
		$CI->load->model('emails');
		$email_detail = $CI->emails->get_email_detail($email_no);
		$data = array();
		if(!empty($email_detail)){	
			$cc_ids = json_decode($email_detail[0]['cc_email_ids']);
			if (! empty($cc_ids)) {
				$cc_ids = implode(",", $cc_ids);
			}
			$action = base_url()."email/done/".$email_no;
			$data = array(
				'title'  				=> 'Done Process',
				'email_no' 				=> $email_no,
				'action' 				=> $action,
				'to_email_id' 			=> $email_detail[0]['to_email_id'],
				'from_email_id' 		=> $email_detail[0]['from_email_id'],
				'to_email_value' 		=> $email_detail[0]['to_email_id'].",",
				'cc_email_value' 		=> $cc_ids,
				'reply_to_email' 		=> $email_detail[0]['reply_to_email'],
				'date' 					=> substr($email_detail[0]['MailDate'],0,17),
				'email_subject_value' 	=> "Re: ".$email_detail[0]['subject'],
				'subject' 				=> $email_detail[0]['subject'],
				'message' 				=> html_entity_decode($email_detail[0]['message'])
			);
		}

		$supplierList = $CI->parser->parse('email/reply_to',$data,true);
		return $supplierList;
	}

}
