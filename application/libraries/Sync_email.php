<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sync_email {
	var $email_stream;
	var $no_of_email;
	var $current_folder;
	var $start_point=1;
	var $from_email;	
	var $full_name;	
	
	public function imap_connection($access_folder=null)
	{
		$CI =& get_instance();
		//INBOX
		//SENT
		//DRAFTS
		//JUNK E-MAIL
		//Default access inbox folder
		if (!$access_folder) {			
			$CI->session->set_userdata(array('error_message'=>"Cant found access folder !"));
			redirect(base_url('email'));
			exit();
		}
		$hostname='{imap-mail.outlook.com:993/imap/ssl/novalidate-cert}'."INBOX";
		$login='maamun7@hotmail.com';
		$pass='Ahmed7MooN';
		$this->from_email = "maamun7@hotmail.com";
		$this->full_name = "Test Email Ticketing";
		
		$this->email_stream =imap_open($hostname, $login, $pass) or die('Cannot connect to mail server: ' . imap_last_error());
		if ($this->email_stream) {				
			$this->current_folder = $access_folder;		
			$this->no_of_email = $this->get_no_of_email();
			return true;
		}
		$CI->session->set_userdata(array('error_message'=>'Cannot connect to mail server: ' . imap_last_error()));
		redirect(base_url('email'));
		exit();
	}

	public function synchronization()
	{
		$CI =& get_instance();		
		$CI->load->model('emails');

		$folders = array("INBOX","JUNK");
		foreach ($folders as $folder) {
			if($this->imap_connection($folder)){
				if($this->no_of_email>0){
					$this->fetch_and_save();
				}
			}
			imap_close($this->email_stream);
		}
		//Update contact page
		$CI->emails->update_json_contact_page();
		$CI->session->set_userdata(array('message'=>"Synchronization done !"));
		redirect(base_url());
		exit();		
	}

	function fetch_and_save()
	{
		$CI =& get_instance();
		$CI->load->model('emails');
		//$this->establist_imap_connection();

		$per_loop=$this->no_of_email;
		//if($this->no_of_email<$per_loop){
			//$per_loop = $this->no_of_email;
		//}
		
		//$final_data = array();
		for($email_no=1; $email_no <= $per_loop; $email_no++){
			$mesg_uid = $this->get_uid($email_no);

			$max_id = $CI->emails->get_last_id($this->current_folder);
			if ($max_id){
					if ($mesg_uid>$max_id){
						$this->loop_execute($mesg_uid,$email_no);	
					}
			}else{
				$this->loop_execute($mesg_uid,$email_no);				
			}			
		} //end for

	}	
	
	private function loop_execute($mesg_uid,$email_no) ## CHECK THE TYPE
	{
		$CI =& get_instance();
		$CI->load->model('emails');

		$header = imap_header($this->email_stream, $email_no);
		//CC email id 
		$cc_email_id = array();
		if (isset($header->cc)) {	

			foreach ($header->cc as $key=>$value) {
				$cc_email_id[] = $value->mailbox ."@". $value->host;
			}

			if (! empty($cc_email_id)) {				
				$encoded_cc_ids=json_encode($cc_email_id,TRUE);
			} else {
				$encoded_cc_ids="";
			}
			
		} else {
			$encoded_cc_ids="";
		}

		$reply_to_name = "";
		if(isset($header->reply_to[0]->personal)){$reply_to_name = utf8_decode(imap_utf8($header->reply_to[0]->personal));} 

		
		$max_ticket_no = $CI->emails->get_last_ticket_no($this->current_folder);
		$ticket_no = generate_ticket_no($max_ticket_no);

		$unseen_sts = $this->get_unseen_mail_id($email_no);

		$final_data['email_id'] 		= $mesg_uid;
		$final_data['sender'] 			= utf8_decode(imap_utf8($header->from[0]->personal));
		$final_data['email_from'] 		= utf8_decode(imap_utf8($header->fromaddress));
		$final_data['from_email_id'] 	= $header->from[0]->mailbox."@".$header->from[0]->host;
		$final_data['email_to'] 		= utf8_decode(imap_utf8($header->toaddress));
		$final_data['to_email_id'] 		= $header->to[0]->mailbox."@".$header->to[0]->host;
		$final_data['reply_to_name'] 	= $reply_to_name;
		$final_data['reply_to_email'] 	= $header->reply_to[0]->mailbox."@".$header->reply_to[0]->host;
		$final_data['cc_email_ids'] 	= $encoded_cc_ids;
		$final_data['email_date'] 		= $header->date;
		$final_data['MailDate'] 		= substr($header->MailDate,0,20);
		$final_data['subject'] 			= utf8_decode(imap_utf8($header->subject));
		$final_data['msg_size'] 		= $header->Size;
		$final_data['ticket_no'] 		= $ticket_no;
		$final_data['type'] 			= $unseen_sts;
		$final_data['status'] 			= 1;
		
		$attachment = $this->extract_attachments($this->email_stream, $email_no);
			
		
		$body = $this->get_part($this->email_stream , $email_no, "TEXT/HTML");
		if ($body == "") {
		    $body = $this->get_part($this->email_stream, $email_no, "TEXT/PLAIN");
		}
		$final_data['message'] =htmlspecialchars($body);

		$CI->emails->insert($this->current_folder,$final_data);
		unset($final_data);	

		$email_id = $header->from[0]->mailbox."@".$header->from[0]->host;
		// if this one is new then will auto send mail 

		if($unseen_sts === TRUE){
			$this->auto_reply($ticket_no,$email_id);
		}

		$contact_list['full_name'] = utf8_decode(imap_utf8($header->from[0]->personal));
		$contact_list['email_id'] 	= $email_id;
		$contact_list['status'] 	= 1;

		if($CI->emails->email_existency_cheeck($email_id)){			
			$CI->emails->contact_insert($contact_list);
		}
	}

	private function get_mime_type(&$structure) {
	    $primary_mime_type = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
	    if($structure->subtype) {
	         return $primary_mime_type[(int) $structure->type] . '/' . $structure->subtype;
	    }
	    return "TEXT/PLAIN";
	}

	private function get_part($stream, $msg_number, $mime_type, $structure = false, $part_number = false) {
	    
	    if (!$structure) {
	         $structure = imap_fetchstructure($stream, $msg_number);
	    }

	    if($structure) {
			if($mime_type == $this->get_mime_type($structure)) {
				if(!$part_number) {
					$part_number = "1";
				}
				$text = imap_fetchbody($stream, $msg_number, $part_number);
				if($structure->encoding == 3) {
					return imap_base64($text);
				} else if ($structure->encoding == 4) {
					return imap_qprint($text);
				} else {
					return $text;
				}
			}
	        if ($structure->type == 1) { /* multipart */
	         	
	              while (list($index, $sub_structure) = each($structure->parts)) {
	                 $prefix="";
	                if ($part_number) {
	                    $prefix = $part_number . '.';
	                }
	                $data = $this->get_part($stream, $msg_number, $mime_type, $sub_structure, $prefix . ($index + 1));
	                if ($data) {
	                    return $data;
	                }
	            }
	        }
	    }
	    return false;
	}
	
	//Get Total No of Email
	private function get_no_of_email()
	{
		$total_no_of = imap_num_msg($this->email_stream);
		if($total_no_of){return $total_no_of;}
		return false;
	}
	
	//Get Email U id
	private function get_uid($email_no)
	{
		$msg_uid = imap_uid($this->email_stream,$email_no);
		if($msg_uid){return $msg_uid;}
		return false;
	}

	//Get Unseen/seen status
	private function get_unseen_mail_id($email_no)
	{
		 // return UNSEEN Message-------Array ( [0] => 17 [1] => 18 )
		$unseen_mail_ids = imap_search($this->email_stream, 'UNSEEN');
		if(!empty($unseen_mail_ids)){
			if (in_array($email_no, $unseen_mail_ids, TRUE))
			{
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
		//Auto Reply
		
			
	private function auto_reply($ticket_no,$email_id)
	{	
		$CI =& get_instance();
		$CI->load->library('email');

		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$CI->email->initialize($config);

		$email_subject="Auto reply from Cellex Limited";
		$full_message  ="Dear Concern,<br/>";
		$full_message .="<br/>";
		$full_message .="Greetings from Cellex Limited.<br/>";
		$full_message .="Thank you for your mail. We have received your quarry / complain with priority and opening a <strong>“Ticket”</strong> in to our <strong>‘Ticketing System’</strong> to resolve your issues asap.<br/>";
		$full_message .="You have received a <strong>Ticket Number: “".$ticket_no."”</strong> to use as a reference of your issue.<br/>";
		$full_message .="Thank you. We always appreciate your business with us.<br/>";
		$full_message .="Please feel free to contact for any query.<br/>";
		$full_message .="<br/>";
		$full_message .="Cellex_Noc contact details:-<br/>";
		$full_message .="Phone: <strong>(+88) 01790 33 22 00</strong><br/>";
		$full_message .="Skype ID: <strong>cellex_noc</strong><br/>";
		$full_message .="<a href='www.cellexltd.com' target='_blank'>www.cellexltd.com </a>";

		$full_message .="<br/>";
		$full_message .="<style='color:#ff0000'>Note: Do not reply this mail. It’s an auto generate e-mail.";

		$CI->email->from($this->from_email,$this->full_name);

		$CI->email->to($email_id);
		$CI->email->subject($email_subject);
		$CI->email->message($full_message); 
		$CI->email->send(); 
	}
	
				/* 20.12.2014 */
	function extract_attachments($connection, $message_number) {
	   
		$attachments = array();
		$structure = imap_fetchstructure($connection, $message_number);
	
		if(isset($structure->parts) && count($structure->parts)) {
	   
			for($i = 0; $i < count($structure->parts); $i++) {
	   
				$attachments[$i] = array(
					'is_attachment' => false,
					'filename' => '',
					'name' => '',
					'attachment' => ''
				);
			   
				if($structure->parts[$i]->ifdparameters) {
					foreach($structure->parts[$i]->dparameters as $object) {	
						if(strtolower($object->attribute) == 'filename') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['filename'] = $object->value;
						}
					}
				}

		
			  
				if($structure->parts[$i]->ifparameters) {
					foreach($structure->parts[$i]->parameters as $object) {
						if(strtolower($object->attribute) == 'name') {
							$attachments[$i]['is_attachment'] = true;
							$attachments[$i]['name'] = $object->value;
						}
					}
				}
			   
				if($attachments[$i]['is_attachment']) {
					$attachments[$i]['attachment'] = imap_fetchbody($connection, $message_number, $i+1);
					if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
						$attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
					}
					elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
						$attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
					}
				}
			   
			}
		}	   
		return $attachments;
	}

}
