<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class model extends CI_Model {
	
	public function __construct() 
 {
	 parent::__construct();
 }
	 public function validate_admin($username,$pass){
			$this->db->select('password');
			$this->db->from('admin');
			$this->db->where('admin.username',$username);
			$query=$this->db->get()->row_array();
			if(isset($query)){
				if(password_verify($pass,$query["password"])){
					$this->db->select('*');
					$this->db->from('admin');
					$this->db->where('admin.username',$username);
					$result=$this->db->get()->row_array();
					return $result;
				}
			}
		}

	public function validate_user($username,$pass){
			$this->db->select('password');
			$this->db->from('factory_account');
			$this->db->where('factory_account.username',$username);
			$query=$this->db->get()->row_array();
			if(isset($query)){
				if(password_verify($pass,$query["password"])){
					$this->db->select('username,factory_id');
					$this->db->from('factory_account');
					$this->db->where('factory_account.username',$username);
					$result=$this->db->get()->row_array();
					return $result;
				}
			}
		}
		
 	public function get_unregister_number()
	{
		$this->db->select("is_read")
				 ->from("factory_wsource_register")
				 ->where("is_read",0);
		$query=$this->db->get()->result_array();
		return count($query);
	}

	public function get_unread_registration()
	{
		$this->db->select("*")
				 ->from("factory_registration")
				 ->where("is_approve",0);
		$query=$this->db->get()->result_array();
		return count($query);
	}

	public function addfactoryregistration($factoryname,$sector,$address,$other,$email,$capacity)
	{
		$data=array(
			'factory_name'=>$factoryname,
			'manufacturing_id'=>$sector,
			'location_code'=>$address,
			'email'=>$email,
			'capacity'=>$capacity,
			'other'=>$other
		);
		$this->db->insert('factory_registration',$data);
	}


	public function adduser($username,$password,$factoryid,$email)
	{
		$data=array(
			'username'=>$username,
			
			'password'=>$password,
			
			'email'=>$email,
			'factory_id'=>$factoryid
		);
		$this->db->insert('factory_account',$data);
	}

	public function addadmin($username,$password,$role)
	{
		$data=array(
			'username'=>$username,
			'password'=>$password,
			'role'=>$role
		);
		$this->db->insert('admin',$data);
		return $this->db->insert_id();
	}

	public function editbrand($sectorid,$sectorname,$old_id)
	{
		$data=array(
			'manufacturing_id'=>$sectorid,
			'sector_name'=>$sectorname
		);
		$this->db->set($data);
		$this->db->where('manufacturing_id',$old_id);
		$this->db->update('sector');
	}

	public function addbrand($sectorid,$sectorname)
	{
		$data=array(
			'manufacturing_id'=>$sectorid,
			'sector_name'=>$sectorname
		);
		$this->db->insert('sector',$data);
	}
	
	public function get_sector()
	{
		$this->db->select("*")
				 ->from("sector");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_method()
	{
		$this->db->select("*")
				 ->from("method")
				 ->join("waste","method.waste_id=waste.waste_id");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_location()
	{
		$this->db->select("*")
				 ->from("location");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_efactor()
	{
		$this->db->select("*")
				 ->from("hspt")
				 ->join("produce_tech","hspt.prod_id=produce_tech.prod_id");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_waste()
	{
		$this->db->select("*")
				 ->from("waste");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_factory()
	{
		$this->db->select("*")
				 ->from("factory")
				 ->join("sector","factory.manufacturing_id=sector.manufacturing_id");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function addfactory($factoryid,$name,$sector,$address,$capacity,$other)
	{
		$this->db->select("*")
				->from("factory")
				->where("factory_id",$factoryid);
		$query=$this->db->get()->result_array();
		if(count($query)>0){
		$data=array(
			'factory_name'=>$name,
			'manufacturing_id'=>$sector,
			'location_code'=>$address,
			'capacity'=>$capacity,
			'other'=>$other
		);
		$this->db->where("factory_id",$factoryid);
		$this->db->update('factory',$data);
		}else{
		$data=array(
			'factory_id'=>$factoryid,
			'factory_name'=>$name,
			'manufacturing_id'=>$sector,
			'location_code'=>$address,
			'capacity'=>$capacity,
			'other'=>$other
		);
		$this->db->insert('factory',$data);
		}
	}	

	public function add_technic($techid,$techname,$waste,$techeffect)
	{
		$this->db->select("*")
				->from("method")
				->where("method_id",$techid);
		$query=$this->db->get()->result_array();
		if(count($query)>0){
		$data=array(
			'method_name'=>$techname,
			'waste_id'=>$waste,
			'affectiveness'=>$techeffect
		);
		$this->db->where("method_id",$techid);
		$this->db->update('method',$data);
		}else{
		$data=array(
			'method_id'=>$techid,
			'method_name'=>$techname,
			'waste_id'=>$waste,
			'affectiveness'=>$techeffect
		);
		$this->db->insert('method',$data);	
		}
	}

	public function add_produce($techid,$techname,$manufacturing_id)
	{
		$this->db->select("*")
				->from("produce_tech")
				->where("prod_id",$techid);
		$query=$this->db->get()->result_array();
		if(count($query)>0){
		$data=array(
			'produce_name'=>$techname,
			'sector_id'=>$manufacturing_id
		);
		$this->db->where("prod_id",$techid);
		$this->db->update('produce_tech',$data);
		}else{
		$data=array(
			'prod_id'=>$techid,
			'produce_name'=>$techname,
			'sector_id'=>$manufacturing_id
		);
		$this->db->insert('produce_tech',$data);
		}
	}

	public function add_factor($factorid,$prod,$waste,$cons,$consbonus)
	{
		$this->db->select("*")
				->from("hspt")
				->where("HSPT_id",$factorid);
		$query=$this->db->get()->result_array();
		if(count($query)>0){
		$data=array(
			'prod_id'=>$prod,
			'waste_id'=>$waste,
			'HSPT_cons'=>$cons,
			'HSPT_cons_bonus'=>$consbonus
		);
		$this->db->where("HSPT_id",$factorid);
		$this->db->update('hspt',$data);
		}else{
		$data=array(
			'HSPT_id'=>$factorid,
			'prod_id'=>$prod,
			'waste_id'=>$waste,
			'HSPT_cons'=>$cons,
			'HSPT_cons_bonus'=>$consbonus
		);
		$this->db->insert('hspt',$data);	
		}
	}

	public function get_source()
	{
		$this->db->select("*")
				 ->from("factory_wsource");
				 
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_selected_source($factory_id)
	{
		$this->db->select("*")
				 ->from("factory_wsource")
				 ->where("factory_id",$factory_id);
				 
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_produce_tech()
	{
		$this->db->select("*")
				 ->from("produce_tech")
				 ->join("sector","sector.manufacturing_id=produce_tech.sector_id");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_produce_for_register($factory_id)
	{
		$this->db->select("prod_id,produce_name")
				 ->from("produce_tech")
				 ->join("sector","sector.manufacturing_id=produce_tech.sector_id")
				 ->join("factory","sector.manufacturing_id=factory.manufacturing_id")
				 ->where("factory_id",$factory_id);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function register_source($factory_id,$sourcename,$sourcelocation,$produce_id,$method_id,$is_working)
	{
		$data=array(
			'factory_id'=>$factory_id,
			'wsource_name'=>$sourcename,
			'method_id'=>$method_id,
			'prod_id'=>$produce_id,
			'location'=>$sourcelocation,
			'is_working'=>$is_working
		);
		$this->db->insert('factory_wsource_register',$data);
	}

	public function get_list_registration()
	{
		$this->db->select("*")
				 ->from("factory_registration")
				 ->join("sector","sector.manufacturing_id=factory_registration.manufacturing_id")
				 ->join("location","location.code=factory_registration.location_code");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_list_source($factory_id)
	{
		$this->db->select("wsource_register_id,wsource_name,location,status,is_working,created_date")
				 ->from("factory_wsource_register")
				 ->where("factory_id",$factory_id);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_all_unregister_list_source()
	{
		$this->db->select("wsource_register_id,wsource_name,location,status,is_working,factory_wsource_register.created_date,factory.factory_id,factory.factory_name,is_read")
				 ->from("factory_wsource_register")
				 ->join("factory","factory.factory_id=factory_wsource_register.factory_id")
				 ->where('status',1);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_selected_method($method_id)
	{
		$this->db->select("*")
				 ->from("method")
				 ->where("method_id",$method_id);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function seen($wsource_register_id)
	{
		$data=array(
			'is_read'=>1
		);
		$this->db->set($data);
		$this->db->where('wsource_register_id',$wsource_register_id);
		$this->db->update('factory_wsource_register');
	}

	public function confirm($wsource_register_id)
	{
		$confirm=array(
			'status'=>2,
			'is_working'=>1
		);
		$this->db->set($confirm);
		$this->db->where('wsource_register_id',$wsource_register_id);
		$this->db->update('factory_wsource_register');
		
	}

	public function add_source_method($source_id,$method_id)
	{
		$data=array(
			'factory_source_id'=>$source_id,
			'method_id'=>$method_id
		);
		$this->db->insert('factory_method',$data);
	}

	public function comfirm_source($factory_id,$source_id,$wsource_name,$wsource_name,$location,$produce_id)
	{
		$data=array(
			'factory_source_id'=>$source_id,
			'factory_id'=>$factory_id,
			'source_name'=>$wsource_name,
			'produce_tech_id'=>$produce_id,
			'source_location'=>$location,
			'is_working'=>1
		);
		$this->db->insert('factory_wsource',$data);
	}

	public function get_unregister_factory_detail($factory_register_id)
	{
		$this->db->select("*")
				 ->from("factory_registration")
				 ->where("factory_registration.id",$factory_register_id)
				 ->join("sector","sector.manufacturing_id=factory_registration.manufacturing_id")
				 ->join("location","location.code=factory_registration.location_code");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_unregister_list_source_detail($wsource_register_id)
	{
		$this->db->select("*")
				 ->from("factory_wsource_register")
				 ->where("wsource_register_id",$wsource_register_id)
				 ->join("factory","factory.factory_id=factory_wsource_register.factory_id")
				 ->join("produce_tech","produce_tech.prod_id=factory_wsource_register.prod_id");
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function addcems($totalq,$sourceid,$month)
	{
		$data=array(
			'flow'=>$totalq,
			'factory_source_id'=>$sourceid,
			'month'=>$month
		);
		$this->db->insert('factory_detail_cems',$data);
		return $this->db->insert_id();
	}

	public function add_so2_cems($totalso2,$E_so2,$cems_id)
	{
		$data=array(
			'concentration'=>$totalso2,
			'cems_id'=>$cems_id,
			'matter'=>"SO2",
			'Emount'=>$E_so2
		);
		$this->db->insert('factory_source_concentration',$data);
	}

	public function add_no_cems($totalno,$E_no,$cems_id)
	{
		$data=array(
			'concentration'=>$totalno,
			'cems_id'=>$cems_id,
			'matter'=>"NO",
			'Emount'=>$E_no
		);
		$this->db->insert('factory_source_concentration',$data);
	}

	public function add_dust_cems($totaldust,$E_dust,$cems_id)
	{
		$data=array(
			'concentration'=>$totaldust,
			'cems_id'=>$cems_id,
			'matter'=>"Dust",
			'Emount'=>$E_dust
		);
		$this->db->insert('factory_source_concentration',$data);
	}

	public function get_source_selected($sourceid)
	{
		$this->db->select("*")
				 ->from("factory_wsource")
				 ->where("factory_source_id",$sourceid);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_cems($sourceid,$month)
	{
		$this->db->select("*")
				 ->from("factory_detail_cems")
				 ->join("factory_source_concentration","factory_source_concentration.cems_id=factory_detail_cems.cems_id")
				 ->where("factory_source_id",$sourceid)
				 ->where("month",$month);
		$query=$this->db->get()->result_array();
		return $query;
	}

	public function get_list_cems($sourceid)
	{
		$this->db->select("*")
				 ->from("factory_detail_cems")
				 ->where("factory_source_id",$sourceid);
		$query=$this->db->get()->result_array();
		return $query;
	}
}