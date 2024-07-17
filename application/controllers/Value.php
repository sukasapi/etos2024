<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Value extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model','master');
		$this->_init();
	}

	private function _init()
	{
		if(isonline() || isadmin() || issuper()){
			
		}else{
			redirect('Muka');
		}
	}

	public function listvalue()
	{
		$data['PageTitle']="Daftar Value";
		$this->output->set_template('dashboard');
		$where=array('is_aktif'=>'aktif');
		if(isadmin()){
			$value=$this->master->getallvalue();
		}else{
			$value=$this->master->getvalue($where);
		}
		
		$data['value']=$value;
		$where=array('is_aktif'=>'aktif');
		$this->load->view('page/value_data',$data);
	}

	
	function addvalue(){
		$res=$this->master->addvalue();
		echo json_encode($res);
	}

	function searchvalue(){
		$where=array('id'=>$this->encryption->decrypt($_GET['token']));
		$res=$this->master->getvalue($where);
		echo json_encode($res);
	}

	function editvalue(){
		$res=$this->master->editvalue();
		echo json_encode($res);
	}
}
