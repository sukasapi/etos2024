<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kalkulasi extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','user');
		$this->load->model('Alter_model','alter');
		$this->load->model('Master_model','master');
		$this->load->model('Question_model','ask');
		$this->_init();
	}

	private function _init()
	{
	
	}

	public function index()
	{
	
	}

	function npsindividu(){
		$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
		$where=array("pe.userid"=>$id);
		$data=$this->alter->getevaluasi($where);
		
		foreach ($data as $d){
			$jumlah = count((array)$d->jenis);
			echo $d->jenis. " jumlah" . $jumlah."<br>";
			//$evaluasi[$d->jenis]["rsp"] =$resp++;
		}
		

	}


	/*
		** fungsi kalkulasi nilai NPS
		*** bisa pilih kalkulasi per batch, jika tidak ada maka kalkulasi semua batch
		*** filter batch menggunakan IN 
		*** data lama akan dinonaktifkan
		## authir : KDW
		## Date   : 08.12.2023
	*/

	function kalkulasi_ulang(){
		$this->output->set_template('dashboard');
		$this->load->view("page/v_kalkulasi");
	}

	function kalkulasi_NPS(){
		
		if(isset($_SESSION['logged_in']) && count((Array)$_SESSION['logged_in'])>0){
			//set pilihan
			if($_SESSION['logged_in']['perusahaan']=="all"){
				$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif"));
				$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
			}else{
				$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif","id"=>$_SESSION['logged_in']['perusahaan']));
				$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
			}

			//jika ada post data
			if(!isset($_POST)){
				if($_SESSION['logged_in']['perusahaan']=="all"){
					$batchchoose="all";
					$entitaschoose="all";
				}else{
					$batchchoose="all";
					$entitaschoose=$_SESSION['logged_in']['perusahaan'];
				}
			}else{
				$batchchoose=isset($_POST['batch'])?$_POST['batch']:"all";
				if($_SESSION['logged_in']['perusahaan']=="all"){
					$entitaschoose="all";
				}else{
					$entitaschoose=$_SESSION['logged_in']['perusahaan'];
				}
				
			}

			//filter
			if($entitaschoose=="all"){
				if($batchchoose =="all"){
					$where=array('u.isaktif'=>'1');
				}else{
					$where=array('u.isaktif'=>'1');
					$batchdraft=explode(',',$batchchoose);
					$where_in=$batchdraft;
				}
			}else{
				if($batchchoose =="all"){
					$where=array('u.isaktif'=>'1','u.company'=>$entitaschoose);
				}else{
					$where=array('u.isaktif'=>'1',"u.company"=>$entitaschoose);
					$batchdraft=explode(',',$batchchoose);
					$where_in=$batchdraft;
				}
			}


			$datacek=array();

			if(isset($where_in)){
				$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.id as idp,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($where)
				->where_in('p.batch',$where_in);
			}else{
				$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.id as idp,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($where);
			}

			$query1=$this->db->get()->result();

			$dnilai=array();

			$pesan="";

			$start = microtime(true);



			$proses =0;
			//nonaktifkan nilai kalkulasi sebelumnya
		
			foreach($query1 as $q){
				///rerata nilai etos individu
				$where2=array('status'=>'final','peserta'=>$q->userid,'jenis'=>1);
				$this->db->select ('AVG(nilai) as nilai')
						->from('tb_evaluasi')
						->where($where2);
				$query2=$this->db->get()->row();
				$etos=!empty($query2->nilai)?$query2->nilai:"0";
					///rerata nilai tradisi
				$where3=array('status'=>'final','peserta'=>$q->userid,'jenis'=>2);
				$this->db->select ('AVG(nilai) as nilai')
						->from('tb_evaluasi')
						->where($where3);
				$query3=$this->db->get()->row();
				$tradisi=!empty($query3->nilai)?$query3->nilai:"0";
					//rerata nilai tri tertib
				$where4=array('status'=>'final','peserta'=>$q->userid,'jenis'=>3);
				$this->db->select ('AVG(nilai) as nilai')
						->from('tb_evaluasi')
						->where($where4);
				$query4=$this->db->get()->row();
				$tritertib=!empty($query3->nilai)?$query4->nilai:"0";
				//atribut
				$where5=array('status'=>'final','peserta'=>$q->userid,'jenis'=>4);
				$this->db->select ('AVG(nilai) as nilai')
						->from('tb_evaluasi')
						->where($where5);
				$query5=$this->db->get()->row();
				$atribut=!empty($query5->nilai)?$query5->nilai:"0";
				

				///TANPA KINERJA
				
				//kinerja
				// kinerja baru
				$where7=array('status'=>'final','peserta'=>$q->userid,'jenis'=>5,'tahun !='=>'NULL','tahun'=>'2022');
				$this->db->select ('id')
				->from('tb_evaluasi')
				->where($where7);
				$query7=$this->db->get()->result();

				$sum=0;
				$count=count((Array)$query7);
				if($count > 0){
					foreach($query7 as $q7){
						$wherer=array("evaluasi"=>$q7->id);
						$this->db->select ('AVG(bobot) as nilai')
						->from('tb_jawaban')
						->where($wherer);
						$queryr=$this->db->get()->row();
					
						$sum+=$queryr->nilai;
					};
					$kinerja=($sum/$count);
				}else{
					$kinerja=0;
				}

				//kinerja 2021
				$where8=array('status'=>'final','peserta'=>$q->userid,'jenis'=>5,'tahun !='=>'NULL','tahun'=>'2021');
				$this->db->select ('id')
				->from('tb_evaluasi')
				->where($where8);
				$query8=$this->db->get()->result();

				$sum2021=0;
				$count2021=count((array)$query8);
				if($count2021 > 0){
					foreach($query8 as $q8){
						$wherer2021=array("evaluasi"=>$q8->id);
						$this->db->select ('AVG(bobot) as nilai')
						->from('tb_jawaban')
						->where($wherer2021);
						$queryr2021=$this->db->get()->row();
					
						$sum2021+=$queryr2021->nilai;
					}
					$kinerja2021=($sum2021/$count2021);
				}else{
					$kinerja2021=0;
				}

				//kinerja smkbk 2021
				$where8=array('status'=>'1','userid'=>$q->userid);
				$this->db->select ('smkbk2021 as nilai')
						->from('tb_komparasi_kinerja')
						->where($where8);
				$query8=$this->db->get()->row();
				$smkbk2021=!empty($query8->nilai)?$query8->nilai:"0";
				/**/

				//Nilai Kinerja sementara diabaikan
				//$kinerja = 0;
				//$smkbk2021=0;
				
				$npstotal=($etos+$tradisi+$tritertib+$atribut)/4;
				$npsgabungan=($npstotal+$kinerja)/2;
				$nilaigabungan=($npstotal+$kinerja)/2;
				$npssmkbk=($npstotal+$smkbk2021)/2;
				$npsbobot=$npstotal * 0.75;
				$kinbobot=$smkbk2021 * 0.25;
				$nilaibobot=round(($npsbobot+$kinbobot),2);


				///inputkan nilai di tabel nilai
				$calc_start=date('Y-m-d H:i:s');
				$datainput=array("id_user"=>$q->userid,
								 "nopeg"=>$q->nopeg,
								 "nama"=>$q->nama,
								 "perusahaan"=>$q->idp,
								 "unit"=>$q->unitusaha,
								 "jenis_asisten"=>$q->jenis_asisten,
								 "komoditas"=>$q->komoditas,
								 "batch"=>$q->batch,
								 "etos"=>$etos,
								 "tradisi"=>$tradisi,
								 "tritertib"=>$tritertib,
								 "atribut"=>$atribut,
								 "nps_gabung"=>$npsgabungan,
								 "nps_total"=>$npstotal,
								 "kinerja"=>$kinerja,
								 "kinerjasmkbk"=>$smkbk2021,
								 "skorgabung"=>$nilaigabungan,
								 "nilai_bobot"=>$nilaibobot,
								 "date_calc"=>$calc_start,
								 "status"=>"1");

				//update nilai lain jadi nonaktif
				$this->db->select('*')
						 ->from('tb_kalkulasi_nps')
						 ->where('id_user',$q->userid)		
						 ->limit(1);
				$qcekkalkulasi=$this->db->get()->result();
				if(count((Array)$qcekkalkulasi) > 0){
					$idkalkulasi=$qcekkalkulasi[0]->id;
					$this->db->where("id",$idkalkulasi);
					$this->db->update('tb_kalkulasi_nps',$datainput);
					$syntax=$this->db->last_query();
					$data['pesan'][]=$q->nopeg. " -->".$etos."-".$tradisi."-".$tritertib."-".$atribut."<br>";
				}else{
					$this->db->insert('tb_kalkulasi_nps',$datainput);
					$syntax=$this->db->last_query();
					$data['pesan'][]=$q->nopeg. " -->".$etos."-".$tradisi."-".$tritertib."-".$atribut."<br>";
				}

				$proses++;
				//insert nilai baru
			}
			$end = microtime(true);

			$executionTime = $end - $start;

			$data['xtime']=$executionTime;
			$data['proses']=$proses;
			$this->output->set_template('dashboard');
			$this->load->view("page/v_kalkulasi",$data);

		} else{
			redirect('Muka/logout');
		}
	}

	function kalkulasi_hasil(){
		if(isset($_SESSION['logged_in']) && count((Array)$_SESSION['logged_in'])>0){
			//set pilihan
			if($_SESSION['logged_in']['perusahaan']=="all"){
				$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif"));
				$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
			}else{
				$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif","id"=>$_SESSION['logged_in']['perusahaan']));
				$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
			}

			//jika ada post data
			if(!isset($_POST)){
				if($_SESSION['logged_in']['perusahaan']=="all"){
					$batchchoose="all";
					$entitaschoose="all";
				}else{
					$batchchoose="all";
					$entitaschoose=$_SESSION['logged_in']['perusahaan'];
				}
			}else{
				if($_SESSION['logged_in']['perusahaan']=="all"){
					$batchchoose="all";
					$entitaschoose=isset($_POST['entitas']) ?$_POST['entitas']:"all";
				}else{
					$batchchoose="all";
					$entitaschoose=$entitaschoose=isset($_POST['entitas']) ?$_POST['entitas']:$_SESSION['logged_in']['perusahaan'];
				}
			
			}

			//filter
			if($entitaschoose=="all"){
				if($batchchoose =="all"){
					$where=array('k.status'=>'1');
				}else{
					$where=array('k.status'=>'1');
					$batchdraft=explode(',',$batchchoose);
					$where_in=$batchdraft;
				}
			}else{
				if($batchchoose =="all"){
					$where=array('k.status'=>'1','k.perusahaan'=>$entitaschoose);
				}else{
					$where=array('k.status'=>'1',"k.perusahaan"=>$entitaschoose);
					$batchdraft=explode(',',$batchchoose);
					$where_in=$batchdraft;
				}
			}

			if(isset($where_in)){
				$this->db->select('*')
				->from('tb_kalkulasi_nps as k')
				->join('tb_perusahaan as c','c.id=k.perusahaan','left')
				->where($where)
				->where_in($where_in);
			}else{
				$this->db->select('*')
				->from('tb_kalkulasi_nps as k')
				->join('tb_perusahaan as c','c.id=k.perusahaan','left')
				->where($where);
			
			}

			$query = $this->db->get()->result();
			$data['display']=$query;
			

			$data['postentitas']=$entitaschoose;
			$data['postbatch']=$batchchoose;
			$this->output->set_template('dashboard');
			$this->load->view('page/v_kalkulasi_result',$data);
		} else{
			redirect('Muka/logout');
		}
		
	

	}
}
