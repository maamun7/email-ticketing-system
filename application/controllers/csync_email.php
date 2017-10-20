<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Csync_email extends CI_Controller {
	
	function __construct() {
      parent::__construct();
      $this->template->current_menu = 'new_mail';
    }

	
}