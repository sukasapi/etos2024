<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','user');
		$this->load->model('Alter_model','alter');
		$this->load->model('Master_model','master');
		$this->_init();
	}

	private function _init()
	{
	
	}

	function index(){
		redirect('User/Userpage');
	}
	function login(){
		if(!$_SESSION){
			redirect('muka');
		}else{
			
		}
	}

	function Userpage(){

		///Perusahaan
		$stat=$_SESSION['logged_in']['status'];
		$res=$stat;
		switch($stat){
			case 'superadmin':
				$res=$this->master->getallperusahaan();
				$datauser=$this->user->getdatauser();
			break;
			case 'admin':
				$res=$this->master->getallperusahaan();
				$datauser=$this->user->getdatauser();
			break;
			case 'admin unit':
				$where=array('id'=>$this->encryption->decrypt($_SESSION['logged_in']['perusahaan']));
				$res=$this->master->getperusahaan($where);
				$where2=array("u.company"=>$_SESSION['logged_in']['perusahaan']);
				$datauser=$this->user->getuserwhere($where2);
				
			break;
			default:
				$where=array('id'=>$this->encryption->decrypt($_SESSION['logged_in']['perusahaan']));
				$res=$this->master->getperusahaan();
				$where2=array("u.company"=>$_SESSION['logged_in']['perusahaan']);
				$datauser=$this->user->getuserwhere($where2);
			break;
		}
	
		$data['pageTitle']="Pengguna"; 
		$data['pageName']="Data Pengguna";
		$data['datauser']=$datauser;
		$data['perusahaan']=$res;
		$this->output->set_template('dashboard');
		$this->load->view('page/user_data',$data);

	}


	function adduser(){

		$res=$this->user->adduser();
		echo json_encode($res);
	}

	function edituser(){
		if($_GET){
			$idus=$this->encryption->decrypt($_GET['idus']);
			$search=$this->user->searchuser(array('u.id'=>$idus));
			$res=$search;
		}else if($_POST){
			$res=$this->user->edituser();
		}
		echo json_encode($res);
	} 

	function resetuser(){
		$res=$this->user->resetuser();
		echo json_encode($res);
	}


	///// PESERTA / KARYAWAN
	function peserta(){

		$data['pageTitle']="Peserta(karyawan)";
		$data['pageName']="Data Peserta";
		$data['perusahaan']=perusahaan();
		$datapeserta=array();
		switch($_SESSION['logged_in']['status']){
			case 'superadmin':
				$datapeserta=$this->user->getallpeserta();
			break;
			case 'admin':
				$datapeserta=$this->user->getallpeserta();
			break;
			case 'admin unit':
				$where=array("u.company"=>$_SESSION['logged_in']['perusahaan'],'p.status_peserta'=>'peserta');
				$datapeserta=$this->user->getwherepeserta2($where);
			break;
			case 'user':
				noakses();
			break;
		}
		$data['peserta']=$datapeserta;
		$this->output->set_template('dashboard');
		$this->load->view('page/peserta_data',$data);
		
	}

	function tambahpeserta(){
	
			///cek jika peserta sudah ada di tabel user
			$pesertacek=array("uname"=>$_POST['nopeg']);
            $ada=$this->user->getuser($pesertacek);
			if(count((array)$ada) > 0){
				//cek jika di data detail tidak ada maka masukkan ke user detail
				$idus=$ada->id;
				$res=array('pesan'=>"data user dengan nomor ".$_POST['nopeg']." sudah ada");
				$this->session->set_flashdata('error', $res['pesan']);
			}else{
				///insert ke userid
				$datainsert=array(
                    'uname'=>$_POST['nopeg'],
                    'upass'=>hashme('12345'),
                    'status'=>'user',
                    'date_create'=>date('Y-m-d H:i:s'),
                    'isonline'=>'0',
                    'isaktif'=>'1',
                    'company'=>$_POST['perusahaan']);
				$addu=$this->user->tb2user($datainsert);
				if($addu !='0'){
					//inputkan ke user detail
				
					$datapeserta=array('userid'=>$addu,
					"nopeg"=>$_POST['nopeg'],
					"nama"=>$_POST['nama'],
					'date_create'=>date('Y-m-d H:i:s'),
					"jabatan"=>$_POST['jabatan'],
					"perusahaan"=>$_POST['perusahaan'],
					"jenis_asisten"=>$_POST['asisten'],
					"komoditas"=>$_POST['komoditas'],
					"unitkerja"=>$_POST['nopeg'],
					"batch"=>$_POST['batch'],
					"jabatan_paska"=>$_POST['jabatanpaska'],
					"jenis_asisten_paska"=>$_POST['asistenpaska'],
					"komoditas_paska"=>$_POST['komoditaspaska'],
					"bagian_paska"=>$_POST['bagianpaska']);
					$addper=$this->user->tb2peserta($datapeserta);
					if($addper !='0'){
						$res=array('pesan'=>"data user dengan nomor ".$_POST['nopeg']." berhasil ditambahkan");
						$this->session->set_flashdata('success', $res['pesan']);
					}else{
						$res=array('pesan'=>"data peserta dengan nomor ".$_POST['nopeg']." gagal diinputkan");
						$this->session->set_flashdata('error', $res['pesan']);
					}
				}else{	
					//input ke user gagal
					$res=array('pesan'=>"data user dengan nomor ".$_POST['nopeg']."gagal diinputkan");
					$this->session->set_flashdata('error', $res['pesan']);
				}

			}
			redirect(base_url('listpeserta'));
		
	}

	function getpeserta(){
	
		$datapeserta=array();
		$datapesertaregis=array();
		$dttemp=array();
		$where=array("pp.project"=>$_GET['project']);
		$data=$this->user->getpesertanonregis($where);
		$dataregis =$this->user->getpesertaregis($where);
		foreach($dataregis as $dr){
			$label=$dr->nama."-".$dr->nopes."-".$dr->jabatan."-".$dr->bagian;
			$datapeserta['selected'][]=array("id"=>$dr->nopes,"label"=>$label);
		}
		foreach($data as $d){
			$label = $d->nama."-".$d->nopes."-".$d->jabatan."-".$d->bagian;
			$datapeserta['available'][]=array("id"=>$d->nopes,"label"=>$label);
		
		}

		echo json_encode($datapeserta);
	}
	function getuserpeserta(){
		$idus=$this->encryption->decrypt($_GET['idus']);
		$where=array("u.id"=>$idus);
		$res=$this->user->searchpeserta($where);
		echo json_encode($res);
	}
	function getpesertacompany(){
		$idus=$this->encryption->decrypt($_GET['idus']);
		
		//$where=array("u.id"=>$idus);
		//$res=$this->user->searchpeserta($where);
		$res=$idus;
		echo json_encode($res);
	}

	function importpeserta(){
		$res=$this->user->importdata();
		echo json_encode($res);
	}
	function editpeserta(){
		$res=$this->user->editpeserta();
		echo json_encode($res);
	}
	function editpeserta2(){
		$data = array("jenis_asisten" => $_POST['jenis'],
					  "komoditas" => $_POST['komoditas'],
					  "unitkerja" => $_POST['unit']);
		$where=array("userid"=>$this->encryption->decrypt($_SESSION['logged_in']['id']));
		$res=$this->user->editpeserta2($data,$where);

		if($res['res'] == "success"){
			redirect(base_url('profil'));
		}else{
			redirect(base_url('profil'));
		}
	}


	///// ATASAN

	function koneksi(){
		$data['pageTitle']="Koneksi Peserta";
		$data['pageName']="Koneksi Peserta";
		if(issuper()){
			$data['dtatasan']=$this->alter->getatasanall();
			$data['dtmitra']=$this->alter->getmitraall();
			$data['peserta']=$this->user->getallpeserta();
			$data['perusahaan']=perusahaan();
		}else{
			$where=array("perusahaan"=>$_SESSION['perusahaan']);
			$data['dtatasan']=$this->alter->getatasan($where);
			$data['dtmitra']=$this->alter->getmitra($where);
			$data['peserta']=$this->user->getpeserta($where);
			$where=array("nama"=>$_SESSION['perusahaan']);
			$data['perusahaan']=sperusahaan($where);
		}
		$this->output->set_template('dashboard');
		$this->load->view('page/koneksi_data',$data);
	}
	function searchpesertacompany(){
	
		$where=array("c.id"=>$_GET['company']);
		$data=$this->user->getwherepeserta($where);
		$syn="";
		foreach($data as $d){
			$syn .="<option value='".$d->id."'>".$d->nama."</option>";
		}
		$res=$syn;
		echo json_encode($res);
	} 

	function searchpesertacompany2(){
	
		$where=array("c.id"=>$_GET['company']);
		$data=$this->user->getwherepeserta($where);
	
		foreach($data as $d){
			if($d->id == $this->encryption->decrypt($_SESSION['logged_in']['id'])){

			}else{
				$res[]=array("id"=>$d->id,"name"=>$d->nopeg."-".$d->nama);
			}
			
		}
		echo json_encode($res);
	} 
	function addatasan(){
		$res =$this->alter->addatasan();
		echo json_encode($res);
	}
	function searchatasan(){
		$where=array("a.id"=>$this->encryption->decrypt($_GET['token']));
		$data=$this->alter->getatasan($where);
		$res=array();
		foreach ($data as $d){
			$res=array("idrel"=>$d->idrel,
						"idatasan"=>$d->idatasan,
						"idbawahan"=>$d->idpeserta,
						"idperusahaan"=>$d->idper,
						"status"=>$d->status);
		}
		echo json_encode($res);
	}
	function editatasan(){
		$res=$this->alter->editatasan();
		echo json_encode($res);

	}


	///PROFIL USER
	function profil(){

		$idus=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		$where=array('u.id'=>$idus);
		$data['user']=$this->user->getuser($where);
		$data['detail']=$this->user->getpeserta2($where);
		if(count((array)$data['user']) > 0){
			$this->output->set_template('dashboard');
			$this->load->view('page/user_profil',$data);
		}else{
			$this->session->set_flashdata('error', 'data peserta tidak dapat ditemukan di sistem.<br> Silahkan hubungi admin');
			logout();
		}
	
		
	}
	
	function changepass(){
		$res=$this->user->changepass();
		echo json_encode($res);
	}


	function getrelasi(){
		$res=$_GET['efor'] ." - ".$_GET['token'];
		$efor =$_GET['efor'];
		$token =$this->encryption->decrypt($_GET['token']);
		switch($efor){
			case 'atasan':
				$where=array('m.peserta'=>$token);
			break;
			case 'mitra':
				$where=array('m.peserta'=>$token);
			break;
			case 'bawahan':
				$where=array('m.leader'=>$token);
			break;
		}
		$data =$this->alter->getrelasi($efor,$where);
		$res=$data;
		echo json_encode($res);
	}

	function getrelasi2(){
	
		$token =$this->encryption->decrypt($_GET['token']);
		//
		$whereatasan=array('m.peserta'=>$token);
		$atasan=$this->alter->getrelasi('atasan',$whereatasan);
		$wheremitra=array('m.peserta'=>$token);
		$mitra=$this->alter->getrelasi('mitra',$wheremitra);
		$wherebawahan=array('m.leader'=>$token);
		$bawahan=$this->alter->getrelasi('bawahan',$wherebawahan);
		$str = "";
		foreach($bawahan as $b){
			$str .="<div class='col-lg-4 col-xs-3'>
						<div class='d-flex align-items-center'>
							<div class='avatar avatar-sm mx-4'>
								<img class='rounded-circle' style='max-height: 100px' src='".base_url()."assets/img/profile-2.png'>
							</div>
							<div class='ms-3'>
								<div class='fs-4 mb-2  text-dark fw-500'>".$b->koneksi."</div>
								<div class='small text-muted'>Bawahan</div>
							</div>
						</div>
					</div>";
		}
		foreach($atasan as $a){
			$str .=" <div class='col-lg-3 col-xs-3'>
						<div class='d-flex align-items-center'>
							<div class='avatar avatar-sm mx-4'>
								<img class='img-thumbnail img-fluid rounded-circle' style='max-height: 100px' src='".base_url()."assets/img/profile-2.png'>
							</div>
							<div class='ms-3'>
								<div class='fs-4 mb-2  text-dark fw-500'>".$a->koneksi."</div>
								<div class='small text-muted'>atasan</div>
							</div>
						</div>
					</div>";
		}
		foreach($mitra as $m){
			$str .=" <div class='col-lg-3 col-xs-3'>
						<div class='d-flex align-items-center'>
							<div class='avatar avatar-sm mx-4'>
								<img class='img-thumbnail img-fluid rounded-circle' style='max-height: 100px' src='".base_url()."assets/img/profile-2.png'>
							</div>
							<div class='ms-3'>
								<div class='fs-4 mb-2 text-dark fw-500'>".$m->koneksi."</div>
								<div class='small text-muted'>mitra</div>
							</div>
						</div>
					</div>";
		}

			$res=$str;
		echo json_encode($res);
	}

	function pilihobyekpenilaian(){
		$data['levelrelasi']=array("atasan","bawahan","mitra");
		$this->output->set_template('dashboard');
		$this->load->view('page/obyek_page',$data);

	}
 
	function addrelasi(){
		$res=$this->alter->addrelasi();
		echo json_encode($res);
	}

	function daftar_relasi(){
		$stat=$_SESSION['logged_in']['status'];
		$data['pageTitle']="Daftar Relasi";
		$data['pageName']="Daftar Relasi Peserta";
		$datadisplay=array();
		if($stat == "superadmin" || $stat == "admin" || $stat == "admin unit"){
			///pilih semua status peserta
			switch($stat){
				case 'superadmin':
					$wpeserta=array("p.status_peserta"=>"peserta","u.isaktif"=>'1');
				break;
				case 'admin':
					$wpeserta=array("p.status_peserta"=>"peserta","u.isaktif"=>'1');
				break;
				case 'admin unit':
					$entitas=$_SESSION['logged_in']['perusahaan'];
					$wpeserta=array("p.status_peserta"=>"peserta",'u.company'=>$entitas,"u.isaktif"=>'1');
				break;
			}
		
			$datapeserta=$this->user->getwherepeserta2($wpeserta);
			//print_r($datapeserta);
			$datarelasi=array();
			foreach ($datapeserta as $peserta){
				$idpeserta = $peserta->id;
				$wrelasi=array("m.peserta"=>$idpeserta,"m.status"=>"aktif");
				$atasan = $this->alter->getrelasi("atasan",$wrelasi);
				$dtatasan=array();
				$dtmitra=array();
				
				foreach ($atasan as $at){
					$dtatasan[]=array("nama_koneksi"=>ucfirst($at->koneksi),"nikkoneksi"=>$at->nikatasan,"idkoneksi"=>$at->idkoneksi);
				}
				$mitra =$this->alter->getrelasi("mitra",$wrelasi);
				foreach($mitra as $mt){
					$dtmitra[]=array("nama_koneksi"=>ucfirst($mt->koneksi),"nikkoneksi"=>$mt->nikmitra,"idkoneksi"=>$mt->idkoneksi);
				}
				$datadisplay[]=array(
							"idp"=>$this->encryption->encrypt($peserta->uid),
							"nama"=>$peserta->nama,
							"nopeg"=>$peserta->nopeg,
							"batch"=>$peserta->batch,
							"perusahaan"=>$peserta->perusahaan,
							"atasan"=>$dtatasan,
							"mitra"=>$dtmitra
							 );
							
			}
			///display ke tabel
			//print_r($datadisplay);
			$data['peserta']=$datadisplay;
			$this->output->set_template('dashboard');
			$this->load->view('page/relasi_daftar',$data);
		}else{
			logout();
		}

		
	} 

	 
	
}
