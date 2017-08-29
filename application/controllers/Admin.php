<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {

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
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{	
				$data['unread']=$this->model->get_unread_registration();
				$data['unregister']=$this->model->get_unregister_number();
				$data['name']=$this->session->username;
				$message['message']=$this->session->flashdata('message');
				$this->load->view('header_CP',$data);
				$this->load->view('CP',$message);
			}else{
				redirect('Home');
			}
		}else{
			redirect('Home');
		}
	}

	public function brand()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
		$data['message']=$this->session->flashdata("message");
		$data['unread']=$this->model->get_unread_registration();
		$data['unregister']=$this->model->get_unregister_number();
		$data['name']=$this->session->username;
		$sector['sector']=$this->model->get_sector();
		$this->load->view('header_CP',$data);
		$this->load->view('CP_addbrand',$sector);
		}else{
				redirect('Home');
			}
		}else{
			redirect('Home');
		}
	}

	public function addbrandsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  				
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/brand');
				}
				$config = array(
					array(
					  'field' => 'sectorid',
					  'label' => 'sectorid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'sectorname',
					  'label' => 'sectorname',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					
					$this->session->set_flashdata("message","Invalid input or blank field !");

					redirect('Admin/brand');
				}else
				{
					$sectorid=$post['sectorid'];
					$sectorname=$post['sectorname'];
					$this->model->addbrand($sectorid,$sectorname);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/brand');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function editbrandsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/brand');
				}
				$config = array(
					array(
					  'field' => 'sectorid',
					  'label' => 'sectorid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'sectorname',
					  'label' => 'sectorname',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/brand');
				}else
				{
					$sectorid=$post['sectorid'];
					$sectorname=$post['sectorname'];
					if(isset($post['choose'])){
					$choose=$post['choose'];
					$sectorid_old=preg_split("/ | /",$choose);
					$this->model->editbrand($sectorid,$sectorname,$sectorid_old[0]);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/brand');
					}
					else{
					redirect('Admin/brand');
					}
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function addadmin()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$data['unregister']=$this->model->get_unregister_number();
				$data['name']=$this->session->username;
				$data['unread']=$this->model->get_unread_registration();
				$data['message']=$this->session->flashdata('message');
				$this->load->view('header_CP',$data);
				$this->load->view('CP_addadmin',$message);
			}else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function adduser()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$data['message']=$this->session->flashdata("message");
				$data['unregister']=$this->model->get_unregister_number();
				$data['unread']=$this->model->get_unread_registration();
				$data['name']=$this->session->username;
				$factory['factory']=$this->model->get_factory();
				$this->load->view('header_CP',$data);
				$this->load->view('CP_adduser',$factory);
			}else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function addusersubmit(){
		if(isset($this->session->logged_in))
		{
			if($this->session->role=="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
					redirect('Admin/adduser');
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
						'rules' => 'trim|required'
					),
					array(
						'field' => 'email',
						'label' => 'email',
						'rules' => 'trim|required'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/adduser');
				}else
				{
					$username=$post['username'];
					$email=$post['email'];
					$factoryid=$post['factoryid'];
					$password=password_hash($post['password'],PASSWORD_DEFAULT);
					$this->model->adduser($username,$password,$factoryid,$email);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/adduser');
				}
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function addfactory()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$data['unread']=$this->model->get_unread_registration();
				$data['message']=$this->session->flashdata("message");
				$data['unregister']=$this->model->get_unregister_number();
				$data['name']=$this->session->username;
				$sector['sector']=$this->model->get_sector();
				$sector['factory']=$this->model->get_factory();
				$sector['location']=$this->model->get_location();
				$this->load->view('header_CP',$data);
				$this->load->view('CP_factory',$sector);
			}else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function addfactorysubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/factory');
				}
				$config = array(
					array(
					  'field' => 'factoryid',
					  'label' => 'factoryid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'name',
					  'label' => 'name',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'address',
					  'label' => 'address',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'capacity',
					  'label' => 'capacity',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/addfactory');
				}else
				{
					$factoryid=$post['factoryid'];
					$name=$post['name'];
					$capacity=$post['capacity'];
					$other=$post['other'];
					$address=$post['address'];
					$sector=$post['sector'];
					$this->model->addfactory($factoryid,$name,$sector,$address,$capacity,$other);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/factory');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function addadminsubmit(){
		if(isset($this->session->logged_in))
		{
			if($this->session->role=="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
					redirect('Admin/addadmin');
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
						'rules' => 'trim|required'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/addadmin');
				}else
				{
					$username=$post['username'];
					$role=$post['role'];
					$password=password_hash($post['password'],PASSWORD_DEFAULT);
					$this->model->addadmin($username,$password,$role);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/addadmin');
				}
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function pollution()
	{
		if(isset($this->session->logged_in))
		{
			$data['unregister']=$this->model->get_unregister_number();
			$data['name']=$this->session->username;
			$data['unread']=$this->model->get_unread_registration();
			$message['message']=$this->session->flashdata('message');
			$this->load->view('header_CP',$data);
			$this->load->view('CP_addpollution',$message);
		}
		else
		{
			redirect('Home');
		}
	}

	public function addpollutionsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/technic');
				}
				$config = array(
					array(
					  'field' => 'techid',
					  'label' => 'techid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'techname',
					  'label' => 'techname',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'waste',
					  'label' => 'waste',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'techeffect',
					  'label' => 'techeffect',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/brand');
				}else
				{
					$techid=$post['techid'];
					$techname=$post['techname'];
					$waste=$post['waste'];
					$techeffect=$post['techeffect'];
					$this->model->add_technic($techid,$techname,$waste,$techeffect);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/technic');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function technic()
	{
		if(isset($this->session->logged_in))
		{
			$data['unregister']=$this->model->get_unregister_number();
			$data['name']=$this->session->username;
			$data['unread']=$this->model->get_unread_registration();
			$data['message']=$this->session->flashdata('message');
			$tech["tech"]=$this->model->get_method();
			$tech["waste"]=$this->model->get_waste();
			$this->load->view('header_CP',$data);
			$this->load->view('CP_addtechnic',$tech);
		}
		else
		{
			redirect('Home');
		}
	}

	public function addtechnicsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/technic');
				}
				$config = array(
					array(
					  'field' => 'techid',
					  'label' => 'techid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'techname',
					  'label' => 'techname',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'waste',
					  'label' => 'waste',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'techeffect',
					  'label' => 'techeffect',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/technic');
				}else
				{
					$techid=$post['techid'];
					$techname=$post['techname'];
					$waste=$post['waste'];
					$techeffect=$post['techeffect'];
					$this->model->add_technic($techid,$techname,$waste,$techeffect);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/technic');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function producetech()
	{
		if(isset($this->session->logged_in))
		{
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$data['unread']=$this->model->get_unread_registration();
			$data['name']=$this->session->username;
			$tech["tech"]=$this->model->get_produce_tech();
			$tech["sector"]=$this->model->get_sector();
			$this->load->view('header_CP',$data);
			$this->load->view('CP_addprodtech',$tech);
		}
		else
		{
			redirect('Home');
		}
	}

	public function producetechsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/producetech');
				}

				$config = array(
					array(
					  'field' => 'techid',
					  'label' => 'techid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'techname',
					  'label' => 'techname',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'manufacturing_id',
					  'label' => 'manufacturing_id',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/producetech');
				}else
				{
					$techid=$post['techid'];
					$techname=$post['techname'];
					$manufacturing_id=$post['manufacturing_id'];
					$this->model->add_produce($techid,$techname,$manufacturing_id);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/producetech');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function listregistration()
	{
		if(isset($this->session->logged_in))
		{
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$data['unread']=$this->model->get_unread_registration();
			$listregistration['list']=$this->model->get_list_registration();
			$data['name']=$this->session->username;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_listregistration',$listregistration);
		}
		else
		{
			redirect('Home');
		}
	}


	public function factorywsource()
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$listsource['list']=$this->model->get_all_unregister_list_source();
			$data['name']=$this->session->username;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_listsource',$listsource);
		}
		else
		{
			redirect('Home');
		}
	}

	public function detailfactory($factory_register_id)
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$listsource['list']=$this->model->get_unregister_factory_detail($factory_register_id);
			$data['name']=$this->session->username;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_detail_factory',$listsource);
		}
		else
		{
			redirect('Home');
		}
	}

	public function detailsource($wsource_register_id)
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$factory_id=$this->session->factory_id;
			$listsource['list']=$this->model->get_unregister_list_source_detail($wsource_register_id);
			$this->model->seen($wsource_register_id);
			$method_array=$listsource['list'][0]['method_id'];
			$method_id=preg_split("/,/", $method_array);
			$method_name=array();
			for($i=0;$i<count($method_id);$i++){
				$method_name[]=$this->model->get_selected_method($method_id[$i]);
			}
			$listsource['method']=$method_name;
			$data['name']=$this->session->username;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_detail_source',$listsource);
		}
		else
		{
			redirect('Home');
		}
	}

	public function detailsourcesubmit(){
		if(isset($this->session->logged_in))
		{
			if($this->session->role=="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  		
				if ( ! is_array($post) || empty($post))
				{
					redirect('Admin/factorywsource');
				}
						
				$config = array(
					array(
					  'field' => 'factory_id',
					  'label' => 'factory_id',
					  'rules' => 'trim|required'
					),
					array(
						'field' => 'source_id',
						'label' => 'source_id',
						'rules' => 'trim|required'
					),
					array(
					  'field' => 'wsource_name',
					  'label' => 'wsource_name',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'location',
					  'label' => 'location',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'produce_id',
					  'label' => 'produce_name',
					  'rules' => 'trim|required'
					)
				);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/factorywsource');
				}
				else
				{
					
					$factory_id=$post['factory_id'];
					$source_id=$post['source_id'];
					$wsource_name=$post['wsource_name'];
					$location=$post['location'];
					$produce_id=$post['produce_id'];
					$method_id=$post['method_id'];
					$wsource_register_id=$post['wsource_register_id'];
					$this->model->comfirm_source($factory_id,$source_id,$wsource_name,$wsource_name,$location,$produce_id);
					for($k=0;$k<count($method_id);$k++){
						$this->model->add_source_method($source_id,$method_id[$k]);
					}
					$this->model->confirm($wsource_register_id);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/factorywsource');
				}
			}
		}
		else
		{
			redirect('Home');
		}
	}

	public function pick()
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['unregister']=$this->model->get_unregister_number();
			$source['source']=$this->model->get_source();
			$data['name']=$this->session->eusername;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_pick',$source);
		}
		else
		{
			redirect("Home");
		}
	}

	public function picksubmit()
	{
		
		if(isset($this->session->logged_in))
		{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  				
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/pick');
				}
				$config = array(
					array(
					  'field' => 'sourceid',
					  'label' => 'sourceid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					redirect('Admin/pick');
				}
				else
				{
					$choose=$post['sourceid'];
					$sourceid=preg_split("/ | /",$choose);
					$this->session->set_userdata("sourceid",$sourceid[0]);
					redirect('Admin/result');
				}
			
		}
		else
		{
			redirect('Home');
		}
	}

	public function result()
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['unregister']=$this->model->get_unregister_number();
			$sourceid=$this->session->sourceid;
			$source_detail=$this->model->get_source_selected($sourceid);
			$source["cems"]=$this->model->get_list_cems($sourceid);
			$data['name']=$this->session->eusername;
			$this->load->view('header_CP',$data);
			$this->load->view('CP_month',$source);
		}
		else
		{
			redirect('Home');
		}
	}

	public function efactor()
	{
		if(isset($this->session->logged_in))
		{
			$data['unread']=$this->model->get_unread_registration();
			$data['message']=$this->session->flashdata("message");
			$data['unregister']=$this->model->get_unregister_number();
			$data['name']=$this->session->username;
			$tech["factor"]=$this->model->get_efactor();
			$tech["tech"]=$this->model->get_produce_tech();
			$tech["waste"]=$this->model->get_waste();
			$this->load->view('header_CP',$data);
			$this->load->view('CP_hspt',$tech);
		}
		else
		{
			redirect('Home');
		}
	}

	public function addfactorsubmit()
	{
		if(isset($this->session->logged_in))
		{
			if($this->session->role =="gadmin")
			{
				$post=$this->input->post();
				$post=array_map("htmlspecialchars", $post);
				$post=array_map("stripslashes", $post);  				
				if ( ! is_array($post) || empty($post))
				{
				redirect('Admin/technic');
				}
				$config = array(
					array(
					  'field' => 'factorid',
					  'label' => 'factorid',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'prod',
					  'label' => 'prod',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'waste',
					  'label' => 'waste',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'cons',
					  'label' => 'cons',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'consbonus',
					  'label' => 'consbonus',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata("message","Invalid input or blank field !");
					redirect('Admin/efactor');
				}else
				{
					$factorid=$post['factorid'];
					$prod=$post['prod'];
					$waste=$post['waste'];
					$cons=$post['cons'];
					$consbonus=$post['consbonus'];
					$this->model->add_factor($factorid,$prod,$waste,$cons,$consbonus);
					$this->session->set_flashdata("message","Succeed !");
					redirect('Admin/efactor');
				}
			}
			else
			{
				redirect('Admin');
			}
		}
		else
		{
			redirect('Home');
		}
	}
}

