<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Enterprise extends CI_Controller {

	public function __construct() 
 {
	   parent::__construct();
	   $this->load->helper('form');
	   $this->load->helper('file_helper');
	   $this->load->library('form_validation');
	   $this->load->library('session');
	   $this->load->model('model');
	   $this->load->library("PHPExcel");
 }
	public function index()
	{
		
		$data['name']=$this->session->eusername;
		$message['message']=$this->session->flashdata('message');
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP',$message);

	}

	public function pick()
	{
		
		$this->session->unset_userdata('sourceid');
		$factory_id=$this->session->factory_id;
		$source['source']=$this->model->get_selected_source($factory_id);
		$data['name']=$this->session->eusername;
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_pick',$source);

	}

	public function picksubmit()
	{
		
		if(isset($this->session->logged_in))
		{
				$post=$this->input->post();

				if ( ! is_array($post) || empty($post))
				{
				redirect('Enterprise/pick');
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
					redirect('Enterprise/pick');
				}
				else
				{
					$choose=$post['sourceid'];
					$sourceid=preg_split("/ | /",$choose);
					$this->session->set_userdata("sourceid",$sourceid[0]);
					redirect('Enterprise/month');
				}
			
		}
		else
		{
			redirect('Home');
		}
	}

	public function month()
	{
        date_default_timezone_set("Asia/Ho_Chi_Minh");
		$this->session->unset_userdata('month');
		$sourceid=$this->session->sourceid;
		$source_detail=$this->model->get_source_selected($sourceid);
		$created_date=preg_split("/ /",$source_detail[0]['created_date']);
		$start    = new DateTime($created_date[0]);
		$end      = (new DateTime('Now'))->modify('first day of next month');
		$interval = DateInterval::createFromDateString('1 month');
		$period   = new DatePeriod($start, $interval, $end);
		$dr=array();
		foreach ($period as $dt) {
    		$dr[]=$dt->format("m-Y");
		}
		$source['month']=$dr;
		$source["cems"]=$this->model->get_list_cems($sourceid);
		
		$data['name']=$this->session->eusername;
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_month',$source);

	}

	public function monthsubmit()
	{
		
		if(isset($this->session->elogged_in))
		{
				$post=$this->input->post();

				if ( ! is_array($post) || empty($post))
				{
				redirect('Enterprise/month');
				}
				$config = array(
					array(
					  'field' => 'month',
					  'label' => 'month',
					  'rules' => 'trim|required',
					  
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					redirect('Enterprise/month');
				}
				else
				{
					$choose=$post['month'];
					$this->session->set_userdata("month",$choose);
					redirect('Enterprise/upload_cems');
				}
			
		}
		else
		{
			redirect('Home');
		}
	}


	public function upload_cems()
	{
		$data['name']=$this->session->eusername;
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_uploadcems');
	}

	public function sample(){
		if(isset($this->session->elogged_in))
		{
		$path="/assets/downloads/Demo.xlsx";
       $mime = get_mime_by_extension($path);

    // Build the headers to push out the file properly.
    header('Pragma: public');     // required
    header('Expires: 0');         // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
    header('Content-Disposition: attachment; filename="'.basename("Demo.xlsx").'"');  // Add the file name
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($path)); // provide file size
    header('Connection: close');
    readfile($path); // push it out
    exit();
			
		}
		else
	redirect('home');	
	}

	public function addcemsexcel()
	{
		if(isset($this->session->elogged_in))
		{
				date_default_timezone_set("Asia/Ho_Chi_Minh");
				$sourceid=$this->session->sourceid;
				$month=$this->session->month;
				$field_name = date("Y-M-d-H-i")."_".$sourceid.".xlsx";
				$config['upload_path']          = './assets/uploads/';
				$config['allowed_types']        = 'xlsx';
				$config['file_name']			=$field_name;
				$config['overwrite'] 			= FALSE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if ( ! $this->upload->do_upload('userfile'))
                {
                    $error = array('error' => $this->upload->display_errors());
					$data_user['name']=$this->session->username;
					$this->load->view('header',$data_user);
					$this->load->view('upload_fail', $error);
                }
                else
                {
					$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					//set to read only
					$objReader->setReadDataOnly(true);
					//load excel file
					$pow=pow(10,-9);
					$date=array();
   					$so2=array();
   					$no=array();
   					$dust=array();
   					$q=array();
   					$E_so2=array();
   					$E_no=array();
   					$E_dust=array();
					$objPHPExcel = $objReader->load("./assets/uploads/".$field_name);
					$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
					$highestRow = $objWorksheet->getHighestRow();
					$date_label = $objWorksheet->getCellByColumnAndRow(0,1)->getValue();
					$time_label = $objWorksheet->getCellByColumnAndRow(1,1)->getValue();
					$temp_label = $objWorksheet->getCellByColumnAndRow(2,1)->getValue();
					$so2_label = $objWorksheet->getCellByColumnAndRow(3,1)->getValue();
					$dust_label = $objWorksheet->getCellByColumnAndRow(4,1)->getValue();
					$no_label = $objWorksheet->getCellByColumnAndRow(5,1)->getValue();
					$p_label = $objWorksheet->getCellByColumnAndRow(6,1)->getValue();
					$q_label = $objWorksheet->getCellByColumnAndRow(7,1)->getValue();
					if($date_label=="Date"&&$time_label=="Time"&&$temp_label=="E-Temp (*C)"&&$so2_label=="SO2 (mg/Nm3)"&&$dust_label=="Dust (mg/Nm3)"&&$no_label=="NO (mg/Nm3)"&&$p_label=="P (mmHg)"&&$q_label=="Q (m3/h)"){
						for($i=2; $i<=$highestRow; $i++){
						   $date[] = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
						   $temp[] = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
						   $so2[] = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
						   $dust[] = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
						   $no[] = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
						   $q[] = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
						}
						
						for($k=0;$k<$highestRow-1;$k++){
							$E_so2[$k]=$so2[$k]*$q[$k]*0.25*$pow;
							$E_dust[$k]=$dust[$k]*$q[$k]*0.25*$pow;
							$E_no[$k]=$no[$k]*$q[$k]*0.25*$pow;	
						}

						$totalq=array_sum($q);
						$totalso2=(array_sum($so2))/($highestRow-1);
						$totalno=array_sum($no)/($highestRow-1);
						$totaldust=array_sum($dust)/($highestRow-1);
						$totalEso2=(array_sum($E_so2));
						$totalEno=array_sum($E_no);
						$totalEdust=array_sum($E_dust);
						$cems_id=$this->model->addcems($totalq,$sourceid,$month);
						if(!empty($cems_id)){
						$this->model->add_so2_cems($totalso2,$totalEso2,$cems_id);
						$this->model->add_no_cems($totalno,$totalEno,$cems_id);
						$this->model->add_dust_cems($totaldust,$totalEdust,$cems_id);
						
						redirect("Enterprise/detailcems"."/".$month);
						
						}
					}else
						redirect('Enterprise/addcemsexcel');
					
                }
			
		}else
				redirect('home');
	}

	public function detailcems($month)
	{
		$sourceid=$this->session->sourceid;
		$data['name']=$this->session->eusername;
		$total["source"]=$this->model->get_source_selected($sourceid);
		$total["cems"]=$this->model->get_cems($sourceid,$month);
		$total["month"]=$month;
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_detailcems',$total);

	}

	public function registersource()
	{
		$factory_id=$this->session->factory_id;
		$registersource["produce"] = $this->model->get_produce_for_register($factory_id);
		$registersource["method"] = $this->model->get_method();
		$data['name']=$this->session->eusername;
		$message['message']=$this->session->flashdata('message');
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_registersource',$registersource);

	}

	public function registersourcesubmit()
	{
		
		if(isset($this->session->elogged_in))
		{
				$post=$this->input->post();

				if ( ! is_array($post) || empty($post))
				{
				redirect('Enterprise/pick');
				}
				$config = array(
					array(
					  'field' => 'sourcename',
					  'label' => 'sourcename',
					  'rules' => 'trim|required',
					  'errors' => array(
						'required' => 'Admin không được phép để trống'
					)
					),
					array(
					  'field' => 'sourcelocation',
					  'label' => 'sourcelocation',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'produce',
					  'label' => 'produce',
					  'rules' => 'trim|required'
					),
					array(
					  'field' => 'method_id',
					  'label' => 'method_id',
					  'rules' => 'trim|required'
					)
					);
				$this->form_validation->set_rules($config);
				if ($this->form_validation->run() == FALSE)
				{
					redirect('Enterprise/registersource');
				}
				else
				{
					$sourcename=$post['sourcename'];
					$sourcelocation=$post['sourcelocation'];
					$produce_id=preg_split("/ | /",$post['produce']);
					$method_id=$post['method_id'];
					$is_working = isset($post['is_working']) && $post['is_working']  ? "1" : "0";
					$factory_id=$this->session->factory_id;
					$this->model->register_source($factory_id,$sourcename,$sourcelocation,$produce_id[0],$method_id,$is_working);
					redirect('Enterprise/listsource');
				}
			
		}
		else
		{
			redirect('Home');
		}
	}

	public function listsource()
	{
		$factory_id=$this->session->factory_id;
		$listsource['list']=$this->model->get_list_source($factory_id);
		$data['name']=$this->session->eusername;
		$message['message']=$this->session->flashdata('message');
		$this->load->view('Enterprise/header_CP',$data);
		$this->load->view('Enterprise/CP_listsource',$listsource);

	}
}