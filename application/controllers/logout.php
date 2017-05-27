<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class logout extends CI_Controller {

	public function __construct() 
 {
	   parent::__construct();
	   $this->load->helper('form');
	   $this->load->library('form_validation');
	   $this->load->library('session');
	   $this->load->model('model');
 }
	public function index()
	{
		$array_items = array('username', 'role','logged_in');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		redirect('home');
	}
}