<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard {
	var $total_time;
	public function home_page($table_name)
	{
		$CI =& get_instance();
		$CI->load->model('emails');
		$email_list = $CI->emails->get_email_list($table_name);
		$i=0;
		if(!empty($email_list)){
			foreach($email_list as $k=>$v){$i++;
				//$email_list[$k]['sl']=$i;
				if($v['type']){
					$email_list[$k]['new']="<span class='new_mail'>new</span>";
				}else{
					$email_list[$k]['new']="";
				}
				$left_len=0;
				$sub_len=strlen($v['type']);
				if($sub_len<100){
					$left_len=100-$sub_len;
				}
				$email_list[$k]['show_subj_with']= $v['subject'];

				if(isset($v['estimate_time'])){
					$email_list[$k]['estimate_total_time']=  $this->total_time+$v['estimate_time'];
					$this->total_time = $email_list[$k]['estimate_total_time'];
				}
			}			
			
		}
		$title = "All Inbox Email";
		if ($table_name=="junk_email") {			
			$title = "All Junk Email";
		}

		$data = array(
			'title' => $title,
			'email_list' => $email_list
		);
		$supplierList = $CI->parser->parse('email/index',$data,true);
		return $supplierList;
	}

}

