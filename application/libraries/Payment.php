<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Payment {
	var $error = array();
	public function get_list_view($limit,$page,$links)
	{
		$CI =& get_instance();
		$CI->load->model('payments');		
		$all_payment = $CI->payments->get_list($limit,$page);
		if(!empty($all_payment)){
			$i = $page;
			foreach($all_payment as $k=>$val){
				$i++;
				$all_payment[$k]['sl']= $i;
				if($val['published']==1){
					$all_payment[$k]['sts_class']="fa-check-square-o";
				}else{
					$all_payment[$k]['sts_class']="fa-times";
				}
			}
		}	

		$data = array(
			'title' => 'payment List',
			'payment_lists' => $all_payment,
			'links' => $links
		);
		$list_view =  $CI->parser->parse('payment/index',$data,true);
		return $list_view;
	}
	
	public function get_search_view($key_words)
	{
		$CI =& get_instance();
		$CI->load->model('payments');
		$all_payment = $CI->payments->get_search_items($key_words);
		$i=0;
		if(!empty($all_payment)){
			$i = 0;
			foreach($all_payment as $k=>$val){
				$i++;
				$all_payment[$k]['sl']= $i;
				if($val['published']==1){
					$all_payment[$k]['sts_class']="fa-check-square-o";
				}else{
					$all_payment[$k]['sts_class']="fa-times";
				}
			}
		}	
		$data = array(
				'title' => 'payment List',
				'payment_lists' => $all_payment,
			);
		$paymentList = $CI->parser->parse('payment/index',$data,true);
		return $paymentList;
	}

	public function add_form()
	{
		$CI =& get_instance();
		$CI->load->model('payments');
		$this->data['error_warning'] = "";
			
		if (isset($this->error['error_transaction_data'])) {
			$this->data['error_transaction_data'] = $this->error['error_transaction_data'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_transaction_data'] = '';
		}

		
		$this->data['transaction_data_value'] = $CI->input->post('transaction_data');

		$this->data['title'] = 'Add New payment';
		$this->data['action'] = base_url().'payment/add';

		$html_view = $CI->parser->parse('payment/add',$this->data,true);
		return $html_view;
	}

	public function edit_form($payment_id)
	{
		$CI =& get_instance();
		$CI->load->model('payments');
		if (isset($this->error['error_category_id'])) {
			$this->data['error_category_id'] = $this->error['error_category_id'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_category_id'] = '';
		}

		if (isset($this->error['error_sub_cat_id'])) {
			$this->data['error_sub_cat_id'] = $this->error['error_sub_cat_id'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_sub_cat_id'] = '';
		}

		if (isset($this->error['error_subject_id'])) {
			$this->data['error_subject_id'] = $this->error['error_subject_id'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_subject_id'] = '';
		}	
			
		if (isset($this->error['error_transaction_data'])) {
			$this->data['error_transaction_data'] = $this->error['error_transaction_data'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_transaction_data'] = '';
		}
			
		if (isset($this->error['error_ordering'])) {
			$this->data['error_ordering'] = $this->error['error_ordering'];
			$this->data['error_warning'] = "Warning: Please check the form carefully for errors !";
		} else {
			$this->data['error_ordering'] = '';
		}

		$edit_data = $CI->payments->get_edit_data($payment_id);

		if(!empty($edit_data)){
			$this->data['parent_cat_value'] = $edit_data[0]['category_id'];
			$sub_cat_id_value = $edit_data[0]['sub_category_id'];
			$subject_id_value = $edit_data[0]['subject_id'];
			$this->data['transaction_data_value'] = $edit_data[0]['transaction_data'];
			$this->data['ordering_value'] = $edit_data[0]['ordering'];
			$this->data['published_sts_value'] = $edit_data[0]['published'];
			$this->data['parent_categories'] = $CI->payments->get_parent();

			$get_sub_categories= $CI->payments->get_sub_category($edit_data[0]['category_id']);
			if(isset($_POST['sub_cat_id'])){
				$sub_cat_id_value = $CI->input->post('sub_cat_id');
			}
			foreach($get_sub_categories as $key=>$value){
				if($sub_cat_id_value == $value['id']){
					$get_sub_categories[$key]['selected']='selected="selected"';
				} else{
					$get_sub_categories[$key]['selected']='';
	            }
			}
			$this->data['sub_categories'] = $get_sub_categories;

			$subjects= $CI->payments->get_all_subject($edit_data[0]['subject_id']);	
						
			if(isset($_POST['subject_id'])){
				$subject_id_value = $CI->input->post('subject_id');
			}
			
			foreach($subjects as $k=>$val){
				if($subject_id_value == $val['id']){
					$subjects[$k]['selected']='selected="selected"';
				}else{
					$subjects[$k]['selected']='';
	            }
			}
			$this->data['subjects'] = $subjects;
		}

		$this->data['payment_id'] = $payment_id;

		if(isset($_POST['transaction_data'])){
			$this->data['transaction_data_value'] = $CI->input->post('transaction_data');
		}

		if(isset($_POST['category_id'])){
			$this->data['parent_cat_value'] = $CI->input->post('category_id');
		}

		if(isset($_POST['ordering'])){
			$this->data['ordering_value'] = $CI->input->post('ordering');
		}

		if(isset($_POST['published_sts'])){
			$this->data['published_sts_value'] = $CI->input->post('published_sts');
		}
		$this->data['title'] = 'Edit payment';
		$this->data['action'] = base_url().'payment/edit/'.$payment_id;
		$html_view = $CI->parser->parse('payment/edit',$this->data,true);
		return $html_view;
	}

	public function validateForm()
	{	
		$CI =& get_instance();
/*
		if(isset($_POST['category_id'])){
			if(strlen($CI->input->post('category_id'))==''){
				$this->error['error_category_id']="Select Category Name";
			} 
		} else {
			$this->error['error_category_id']="";
		}	

		if(isset($_POST['sub_cat_id'])){
			if(strlen($CI->input->post('sub_cat_id'))==''){
				$this->error['error_sub_cat_id']="Select Sub Category Name";
			} 
		} else {
			$this->error['error_sub_cat_id']="";
		}	

		if(isset($_POST['subject_id'])){
			if(strlen($CI->input->post('subject_id'))==''){
				$this->error['error_subject_id']="Select Subject Name";
			} 
		} else {
			$this->error['error_subject_id']="";
		}
*/
		if(isset($_POST['transaction_data'])){
			if(strlen($CI->input->post('transaction_data'))==''){
				$this->error['error_transaction_data']="Payment data is required";
			} elseif(strlen($CI->input->post('transaction_data'))<3 || strlen($CI->input->post('transaction_data'))>140){
				$this->error['error_transaction_data']="Payment name must be between 3 to 140 characters";
			}
		} else {
			$this->error['error_transaction_data']="";
		}
		
		if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
	}
}
