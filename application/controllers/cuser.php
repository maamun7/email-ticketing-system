<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cuser extends CI_Controller {
	
	function __construct() {
      parent::__construct();
	  
	  $this->template->current_menu = 'user';
    }
	public function index()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('manage_user');
		$CI->load->library('user');
		$CI->load->model('users');
		
		$config = array();
		$config["base_url"] = base_url()."user/index";
		$config["total_rows"] = $this->users->count_user();	  
		$config["per_page"] = 50;
		$config["uri_segment"] = 3;	
		$config['full_tag_open'] = '<div id="pagination">';
		$config['full_tag_close'] = '</div>';
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$limit = $config["per_page"];
	    $links = $this->pagination->create_links();
		
        $content = $CI->user->generate_list($limit,$page,$links);
        $sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'user','class' =>'active'),
				array('label'=> 'Add User', 'url' => 'user/add'),
				array('label'=> 'Manage Role ', 'url' => 'role'),
				array('label'=> 'Add Role ', 'url' => 'role/add_role')
			);
		$this->template->full_html_view($content,$sub_menu);
	}
	//user Add Form
	public function add()
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('add_user');
		$CI->load->library('user');
		$content = $CI->user->new_user();
		$sub_menu = array(
				array('label'=> 'Manage User ', 'url' => 'user'),
				array('label'=> 'Add User', 'url' => 'user/add','class' =>'active'),
				array('label'=> 'Manage Role ', 'url' => 'role'),
				array('label'=> 'Add Role ', 'url' => 'role/add_role')
			);
		$this->template->full_html_view($content,$sub_menu);
	}
	//Insert user and uload
	public function insert_user()
	{
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('add_user');
		$CI->load->model('users');
		$basic_data = array(
			'user_id' 		=> Null,
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'designition' 	=> $this->input->post('designation'),
			'address' 		=> $this->input->post('address'),
			'status' 		=> 1
		);
		$user_id = $CI->users->insert_basic_info($basic_data);
		$login_data = array(
			'user_id' 		=> $user_id,
			'username' 		=> $this->input->post('email'),
			'password' 		=> md5("onexam".$this->input->post('password')),
			'user_type' 	=> 2,
			'is_active' 	=> $this->input->post('is_active'),
			'can_login' 	=> $this->input->post('can_login')
		);
		$CI->users->insert_login_info($login_data);
		
		$role_relation = array(
			'id' 		=> null,
			'user_id' 	=> $user_id,
			'role_id' 	=> $this->input->post('role_id')
		);
		$CI->users->insert_user_role_relation($role_relation);
		
		$this->session->set_userdata(array('message'=>"New User Added Successfully!"));
		redirect(base_url('user'));
		exit;
	}
	//user Update Form
	public function edit($user_id = Null)
	{	
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('edit_user');
		$CI->load->library('user');
		if(!$user_id){
			$this->session->set_userdata(array('message'=>"You didn't Select User !"));
			redirect(base_url('user'));
		}
		$content = $CI->user->get_edit_data($user_id);
		$sub_menu = array(
			array('label'=> 'Manage User ', 'url' => 'user'),
			array('label'=> 'Add User', 'url' => 'user/add'),
			array('label'=> 'Edit User', 'url' => 'user/edit/'.$user_id,'class' =>'active'),
			array('label'=> 'Manage Role ', 'url' => 'role'),
			array('label'=> 'Add Role ', 'url' => 'role/add_role')
		);
		$this->template->full_html_view($content,$sub_menu);
	}
	// user Update
	public function user_update()
	{
		$CI =& get_instance();
		$CI->auth->check_auth();
		$this->auth->check_permission('edit_user');
		$CI->load->model('users');
		$user_id  = $this->input->post('user_id');
		$basic_data = array(
			'first_name' 	=> $this->input->post('first_name'),
			'last_name' 	=> $this->input->post('last_name'),
			'designition' 	=> $this->input->post('designation'),
			'address' 		=> $this->input->post('address'),
			'status' 		=> 1
		);
		$CI->users->update_basic_info($basic_data,$user_id);
		$login_data = array(
			'username' 		=> $this->input->post('email'),
			//'password' 		=> md5("matroak".$this->input->post('password')),
			'user_type' 	=> 2,
			'is_active' 	=> $this->input->post('is_active'),
			'can_login' 	=> $this->input->post('can_login')
		);
		$CI->users->update_login_info($login_data,$user_id);
		
		$role_relation=array(
			'user_id' 	=> $user_id,
			'role_id' 	=> $this->input->post('role_id')
		);
		$CI->users->update_user_role_relation($role_relation,$user_id);
		$this->session->set_userdata(array('message'=>"User Successfully Edited!"));
		redirect(base_url('user'));
		exit;
	}

	public function user_delete()
	{	
		$CI =& get_instance();
		$this->auth->check_admin_auth();
		$CI->load->model('users');
		$user_id =  $_POST['user_id'];
		$CI->users->delete_user($user_id);
		return true;			
	}

	//Edit Profile
	public function edit_profile()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_profile');
		$CI->load->library('user');
		$content = $CI->user->edit_profile_form();
		$this->template->full_html_view($content);
	}

	public function update_profile()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('edit_profile');
		$CI->load->model('users');
		$this->users->profile_update();
		$this->session->set_userdata(array('message'=>"Successfully Updated !"));
		redirect(base_url('cdashboard'));
	}

	public function change_password_form()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('change_password');
		$content = $CI->parser->parse('user/change_password',array('title'=>"Change Password"),true);
		$this->template->full_html_view($content);
	}
	//Update Profile
	public function change_password()
	{	
		$CI =& get_instance();
		$this->auth->check_auth();
		$this->auth->check_permission('change_password');
		$CI->load->model('users'); 
		
		$error = '';
		$email = $this->input->post('email');
		$old_password = $this->input->post('old_password');
		$new_password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		
		if ( $email == '' || $old_password == '' || $new_password == '')
		{
			$error = "Blank field doesn't accept";
		}else if($email != $this->session->userdata('user_name')){
			$error = "You put wrong email address";
		}else if(strlen($new_password)<6 ){
			$error = "New Password At least 6 Characters";
		}else if($new_password != $repassword ){
			$error = "Password and Re-password doesn't Match";
		}else if($CI->users->change_password($email,$old_password,$new_password) === FALSE ){
			$error = "You are not a_authorized person";
		}
		if ( $error != '' )
		{
			$this->session->set_userdata(array('error_message'=>$error));
			$this->output->set_header("Location: ".base_url().'user/change_password_form', TRUE, 302);
		}else{
			$this->session->set_userdata(array('message'=>"Successfully Changed Password"));
			$this->output->set_header("Location: ".base_url().'dashboard', TRUE, 302);
        }
	}
}