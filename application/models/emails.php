<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Emails extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function count_email()
	{
		return $this->db->count_all("inbox_email");
	}
	
	public function get_email_list($table_name)
	{
		$this->db->select('a.*,b.estimate_time,b.is_done,b.message,c.first_name,c.last_name');
		$this->db->from($table_name." a");
		$this->db->join('response_by_support b','b.email_id = a.email_id','left');
		$this->db->join('users c','c.user_id = b.response_by_id','left');
		$this->db->order_by('a.id','asc');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}
	
	public function existency_status($mesg_uid)
	{
		$this->db->select('email_id');
		$this->db->from('inbox_email');
		$this->db->where('email_id',$mesg_uid);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return true;	
		}
		return false;
	}
	
	public function get_last_id($current_foldeer)
	{
		switch ($current_foldeer) {
			case 'JUNK':
				$table_name="junk_email";
				break;	
			case 'SENT':
				$table_name="sent_email";
				break;
			case 'DRAFTS':
				$table_name="drafts_email";
				break;			
			default:
				$table_name="inbox_email";
				break;
		}

		$this->db->select_max('email_id');
		$this->db->from($table_name);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->email_id;
		}
		return false;
	}

	public function insert($current_foldeer,$data)
	{
		switch ($current_foldeer) {
			case 'JUNK':
				$table_name="junk_email";
				break;	
			case 'SENT':
				$table_name="sent_email";
				break;
			case 'DRAFTS':
				$table_name="drafts_email";
				break;			
			default:
				$table_name="inbox_email";
				break;
		}
		$this->db->insert($table_name,$data);
		return true;
	}

	public function email_existency_cheeck($email_id)
	{
		$this->db->select('*');
		$this->db->from('contact_list');
		$this->db->where('email_id',$email_id);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return false;
		}else{
			return true;
		}
	}

	public function get_last_ticket_no($current_foldeer)
	{
		switch ($current_foldeer) {
			case 'JUNK':
				$table_name="junk_email";
				break;				
			default:
				$table_name="inbox_email";
				break;
		}

		$this->db->select_max('ticket_no');
		$this->db->from($table_name);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$row = $query->row();
			return $row->ticket_no;
		}
		return false;
	}

	public function contact_insert($contact_list)
	{
		$this->db->insert('contact_list',$contact_list);
		return true;
	}
	
	public function get_email_detail($email_no)
	{
		$this->change_new_sts($email_no);

		$this->db->select('*');
		$this->db->from('inbox_email');
		$this->db->where('email_id',$email_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		return false;
	}

	public function get_response_edit_data($email_no)
	{
		$this->db->select('*');
		$this->db->from('response_by_support');
		$this->db->where('email_id',$email_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}
		$this->change_new_sts($email_no);
		return false;
	}

	public function do_edit_response()
	{

		$email_id = $this->input->post('email_id');
		$estimate_time = $this->input->post('estimate_time');
		$message = $this->input->post('message');
		
		date_default_timezone_set('Asia/Dhaka');
   		$date = date('Y-m-d H:i:s');

   		$exist=$this->get_response_edit_data($email_id);
		if (!$exist) {
			$data=array(
				"email_id"=>$email_id,
				"response_by_id"=>$this->auth->get_user_id(),
				"estimate_time"=>$estimate_time,
				"message"=>$message,
				"response_at"=>$date
			);
			$this->db->insert('response_by_support',$data);
		}else{
			$data=array(				
				"response_by_id"=>$this->auth->get_user_id(),
				"estimate_time"=>$estimate_time,
				"message"=>$message,
				"edited_at"=>$date
			);
			$this->db->where('email_id',$email_id);
			$this->db->update('response_by_support',$data);
		}
		return true;
	}

	public function get_sender_detail($email_no)
	{
		$this->db->select('from_email_id,ticket_no');
		$this->db->from('inbox_email');
		$this->db->where('email_id',$email_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->result_array();	
		}else{
			$this->db->select('from_email_id,ticket_no');
			$this->db->from('junk_email');
			$this->db->where('email_id',$email_no);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result_array();	
			}
		}
		return false;
	}

	public function get_estimate_time($email_no)
	{
		$this->db->select_sum('estimate_time');
		$this->db->from('response_by_support');
		$this->db->where('email_id <=',$email_no);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$result = $query->result_array();	
			return $result[0]['estimate_time'];	
		}
		return false;
	}

	public function change_new_sts($email_id)
	{
		date_default_timezone_set('Asia/Dhaka');
   		$date = date('Y-m-d H:i:s');
		$data=array(			
			"type"=>0,
			"read_date"=>$date
		);
		$this->db->where('email_id',$email_id);
		$this->db->update('inbox_email',$data);
	}
	
	public function change_done_sts($email_id)
	{
		date_default_timezone_set('Asia/Dhaka');
   		$date = date('Y-m-d H:i:s');
		$data=array(			
			"is_done"=>1,
			"estimate_time"=>0,
			"done_at"=>$date
		);
		$this->db->where('email_id',$email_id);
		$this->db->update('response_by_support',$data);
	}

	public function update_json_contact_page()
	{
		$this->db->select('*');
		$this->db->from('contact_list');
		$query = $this->db->get();
		foreach ($query->result() as $row) {
			$json_contacs[] = array('label'=>$row->full_name,'value'=>$row->email_id);
		}
		$cache_file = $_SERVER['DOCUMENT_ROOT'].'/email_ticketing/my-assets/js/json/contact_list.json';
		$contactList = json_encode($json_contacs);
		file_put_contents($cache_file,$contactList);
	}

}