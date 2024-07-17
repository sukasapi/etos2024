<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model','master');
		$this->_init();
	}

	private function _init()
	{
		if(isonline() || isadmin() ||issuper()){
			
		}else{
			redirect('Muka');
		}
	}

	public function index()
	{
	
		$data['PageTitle']="Daftar Perusahaan";
		$this->output->set_template('dashboard');
		$where=array('is_aktif'=>'aktif');
		if(isadmin()){
			$perusahaan=$this->master->getallperusahaan();
		}else{
			$perusahaan=$this->master->getperusahaan($where);
		}
		
		$data['perusahaan']=$perusahaan;
		$this->load->view('page/perusahaan_data',$data);
	} 

	function dashboard(){
		$this->output->set_template('dashboard');
		$this->load->view('page/admin_dash');
	}

	function addcompany(){
		$res=$this->master->addcompany();
		echo json_encode($res);
	}

	function searchcompany(){
		$where=array('id'=>$this->encryption->decrypt($_GET['token']));
		$res=$this->master->getperusahaan($where);
		echo json_encode($res);
	}
 

	function searchcompany2(){
		$stat=$_SESSION['logged_in']['status'];
		$res=$stat;
		switch($stat){
			case 'superadmin':
				$res=$this->master->getallperusahaan();
			break;
			case 'admin':
				$res=$this->master->getallperusahaan();
			break;
			case 'admin unit':
				$where=array('id'=>$this->encryption->decrypt($_GET['token']));
				$res=$this->master->getperusahaan($where);
				
			break;
			default:
				$where=array('id'=>$this->encryption->decrypt($_GET['token']));
				$res=$this->master->getperusahaan($where);
			break;
		}

		$opt = array();
	    foreach($res as $pr){
			if($pr->id == $_SESSION['logged_in']['perusahaan']){
				$opt[]=array("id"=>$pr->id,"nama"=>$pr->nama,"stat"=>"selected");
			}else{
				$opt[]=array("id"=>$pr->id,"nama"=>$pr->nama,"stat"=>"");
			}
		}
		
		echo json_encode($opt);
	}
	function editcompany(){
		$res=$this->master->editcompany();
		echo json_encode($res);
	}
}
