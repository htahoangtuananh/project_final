<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {

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
		if($this->session->logged_in==TRUE){
		$data['name']=$this->session->username;
		$this->load->view('header',$data);
		$this->load->view('home');
		}else
		$this->load->view('header');
		$this->load->view('home');
	}

	public function login_admin()
	{
		if($this->session->logged_in==TRUE){
			if($this->session->role=="admin"||$this->session->role=="gadmin"){
				$data['name']=$this->session->username;
				redirect('Admin');
			}
		}
		else
		$post  = $this->input->post();
		if ( ! is_array($post) || empty($post))
		{
		  redirect('Home');
		}
		$config = array(
                array(
                  'field' => 'username',
                  'label' => 'username',
                  'rules' => 'trim|required'
                ),
                array(
                  'field' => 'password',
                  'label' => 'password',
                  'rules' => 'trim|required|min_length[5]',
                  'errors' => array(
                    'min_length' => 'Password phai nhieu hon 5 kí tu'
                ))
                );
	    $this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
	    {
			 redirect('Home');
	    }
		else
		{
			$username = $post['username'];
			$pass = $post['password'];
			$bool=$this->model->validate_admin($username,$pass);
			if(isset($bool)){
				$session_data = array(
				'username' =>$bool['username'],
				'role'=>$bool['role'],
				'logged_in'=>TRUE
				);
				$this->session->set_userdata($session_data);
			}
			redirect('Admin');
		}		
	}

	public function login_enterprise()
	{
		if($this->session->elogged_in==TRUE){
				$data['name']=$this->session->eusername;
				redirect('Enterprise');
			
		}
		else{
		$post  = $this->input->post();
		
		if ( ! is_array($post) || empty($post))
		{
		  redirect('Home');
		}
		$config = array(
                array(
                  'field' => 'username',
                  'label' => 'username',
                  'rules' => 'trim|required'
                ),
                array(
                  'field' => 'password',
                  'label' => 'password',
                  'rules' => 'trim|required|min_length[5]',
                  'errors' => array(
                    'min_length' => 'Password phai nhieu hon 5 kí tu'
                ))
                );
	    $this->form_validation->set_rules($config);
		if ($this->form_validation->run() == FALSE)
	    {
			 redirect('Home');
	    }
		else
		{
			$username = $post['username'];
			$pass = $post['password'];
			$bool=$this->model->validate_user($username,$pass);
			if(isset($bool)){
				$session_data = array(
				'eusername' =>$bool['username'],
				'factory_id'=>$bool['factory_id'],
				'elogged_in'=>TRUE
				);
				$this->session->set_userdata($session_data);
			}
			redirect('Enterprise');
		}		
	}
}
}