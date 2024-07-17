<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model','master');
		$this->load->model('Alter_model','alter');
		$this->load->model('user_model','peserta');
		$this->_init();
	}

	private function _init()
	{
		if(isonline() || isadmin() || issuper()){
			
		}else{
			redirect('Muka');
		}
	}

	public function index()
	{
	
		$data['PageTitle']="Daftar Project";
		$this->output->set_template('dashboard');
		$where=array('status'=>'aktif');
		if(isadmin()){
			$project=$this->master->getallproject();
		}else{
			$project=$this->master->getproject($where);
		}
	
		$data['project']=$project;
		$where=array('is_aktif'=>'aktif');
		$data['perusahaan']=$this->master->getperusahaan($where);
		$this->load->view('page/project_data',$data);
	}


	function listproject(){
		$data['PageTitle']="Evaluasi Tersedia";
		$this->output->set_template('dashboard');
		$where=array('status'=>'aktif');
		if(isadmin()){ 
			$project=$this->master->getallproject();
		}else{
			$project=$this->master->getproject($where);
		}
		
		$data['project']=$project;
		$where=array('is_aktif'=>'aktif');
		$this->load->view('page/list_project',$data);
	}
	
	function addproject(){
		$res=$this->master->addproject();
		echo json_encode($res);
	}

	function searchproject(){
		$where=array('p.id'=>$this->encryption->decrypt($_GET['token']));
		$res=$this->master->getproject($where);
		echo json_encode($res);
	}

	function editproject(){
		$res=$this->master->editproject();
		echo json_encode($res);
	}
	
	function projectcompany(){
		$where=array('p.perusahaan'=>$_GET['company']);
		$res=$this->master->getproject($where);
		echo json_encode($res);
	}


	//// Registrasi peserta ke project
	function daftarregistrasi(){
		$data['PageTitle']="Registrasi Project Peserta";
		$data['PageName']="Daftar registrasi peserta project";
		$this->output->set_template('dashboard');
		$where=array('pp.is_aktif'=>'aktif');
		if(isadmin()){
			$regis=$this->alter->getpesertaproject();
		}else{
			$regis=$this->alter->getpesertaproject($where);
		}
		$wherepro=array('is_aktif'=>'aktif');
		if(isadmin()){
			$project=$this->master->getallproject();
		}else{
			$project=$this->master->getproject($wherepro);
		}

		$whereper=array('is_aktif'=>'aktif');
		$data['perusahaan']=$this->master->getperusahaan($whereper);

		if(isadmin()){
		$wherepeserta=array('u.isaktif'=>"1");
		}else{
		
		$wherepeserta=array('u.isaktif'=>"1");
		}
		$peserta = $this->peserta->getwherepeserta($wherepeserta);
		$data['peserta'] = $peserta;
		$data['project']=$project;
		$data['regis']=$regis;
		$where=array('is_aktif'=>'aktif');
		$this->load->view('page/project_user',$data);
	}

	function addregistrasi(){
		
	
		if(empty($_POST['remolis'])){
			$result=$this->alter->registrasipeserta($_POST['project']);
		}else if(empty($_POST['peserta']))
		{
			$result=$this->alter->removepeserta($_POST['project']);
		}else{
			$this->alter->registrasipeserta($_POST['project']);
			$this->alter->removepeserta($_POST['project']);
			$pesan= "data berhasil diubah";
			$result=array('pesan'=>$pesan,'res'=>'ok');
			$this->session->set_flashdata('success', $pesan);
		}
	
		echo json_encode($result);
	}

	
}
