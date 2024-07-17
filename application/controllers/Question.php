<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model','master');
		$this->load->model('Question_model','ask');
		$this->_init();
	}

	private function _init()
	{
		if(isonline() || isadmin() || issuper()){
			
		}else{
			redirect('Muka');
		}
	}

	function listsoal(){
		$data['PageTitle']="Daftar Soal";
	
		$where=array('p.status'=>'aktif');
		//$value=$this->master->getvalue($where);
		if(isadmin()){
			$soal=$this->ask->listsoal();
		}else{
			$soal=$this->ask->searchsoal($where);
		}
		$data['soal']=$soal;
		//$data['value']=$value;
		$this->output->set_template('dashboard');
		$this->load->view('page/bank_soal',$data);
	}




	////SOAL 
	function addsoal(){
		$res=$this->ask->addsoal();
		echo json_encode($res);
	}


	///JAWABAN

	function searchjawab(){
		$idj=$this->encryption->decrypt($_GET['token']);
		$where=array("s.id"=>$idj,"j.is_aktif"=>"aktif");
		$res=$this->ask->searchjawab($where);
		echo json_encode($res);
	}
	function addjawab(){
		$data['PageTitle']="Daftar Jawaban";
		$soal = substr($this->uri->segment(2),7);
		$where=array("j.soal"=>$soal,"s.is_aktif"=>"aktif");
		$what=array("id"=>$soal,"is_aktif"=>"aktif");

		$soal=$this->ask->searchsoal($what);
		$listjawab=$this->ask->searchjawab($where);
		$data["jawab"]=$listjawab;
		$data["soal"]=$soal;
		$this->output->set_template('dashboard');
		$this->load->view('page/jawab_data',$data);
	}
	function addjawaban(){
		$res=$this->ask->addjawaban();
		echo json_encode($res);
	}

	function getdesk(){
		$soaltoken=$this->encryption->decrypt($_GET['token']);
		$deskripsi=$this->ask->desk($soaltoken);
		$res=$deskripsi;
		echo json_encode($res);
	}
}
