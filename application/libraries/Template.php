<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template {
	var $current_menu = 'home';
	// View Message
	function flash_message()
	{
		$CI =& get_instance();
		$CI->load->library('parser');
		
		$message = '';
		$message_class = '';
		$html = '';
		
		if($CI->session->userdata('message') != '')
		{
			$message = $CI->session->userdata('message');
			$message_class = 'alert-success';
		}elseif($CI->session->userdata('info_message') != '')
		{
			$message = $CI->session->userdata('info_message');
			$message_class = 'alert-info';
		}elseif($CI->session->userdata('warning_message') != '')
		{
			$message = $CI->session->userdata('warning_message');
			$message_class = 'alert-warning';
		}elseif($CI->session->userdata('error_message') != '')
		{
			$message = $CI->session->userdata('error_message');
			$message_class = 'alert-danger';
		}

		$data = array(
			'message' => $message,
			'message_class' => $message_class
		);

		if($message != '')
			$html = $CI->parser->parse('include/message',$data,true);

		$CI->session->unset_userdata('message');
		$CI->session->unset_userdata('error_message');

		return $html;
	}
	//Html View....
	public function full_html_view($content,$sub_menu=''){
	
		$CI =& get_instance();
		$message = $this->flash_message();
		$logged_info='';
		$top_menu='';
		$left_menu='';
		
		if ($CI->auth->is_logged())
		{
			$menu_template = 'include/top_menu';
			$left_menu_template = 'include/left_menu';
			$logged_data = 'include/loggedin_info';
			//$full_name = $CI->auth->get_full_name();
		
			// parse menu
			$menu_data = array(
				'active' => $this->current_menu
			);
			$log_info = array(
				'email' => $CI->session->userdata('user_name'),
				'logout' => base_url().'dashboard/logout'
			); 
			$top_menu = $CI->parser->parse($menu_template,$menu_data,true);
			$left_menu = $CI->parser->parse($left_menu_template,$menu_data,true);
			$logged_info = $CI->parser->parse($logged_data,$log_info,true);
		}
		//Sub Menu
		if ($sub_menu != '')
		{
			// insert empty text to non assigned elments
			foreach($sub_menu as $k=>$sub){
				if(!isset($sub['title']))$sub_menu[$k]['title']='';
				if(!isset($sub['class']))$sub_menu[$k]['class']='';
			}
			$sub_menu = $CI->parser->parse('include/sub_menu', array('sub_menu'=>$sub_menu), true);
		}
		$data = array (
				'login_data' 	=> $logged_info,
				'main_menus' 	=> $top_menu,
				'left_menus' 	=> $left_menu,
				'sub_menu' 		=> $sub_menu,
				'content' 		=> $content,
				'msg_content' 	=> $message
			);
		$content = $CI->parser->parse('html_template',$data);
	}
	
	public function login_view(){
	
		$CI =& get_instance();
		$message = $this->flash_message();
		$data = array (
			'msg_content' 	=> $message
		);
		$content = $CI->parser->parse('include/login_form',$data);
	}
	
	
}