	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('Master_model','master');
		$this->load->model('User_model','user');
		$this->load->model('Question_model','ask');
		$this->load->model('Alter_model','alter');
		$this->_init();
	}

	private function _init() 
	{
		if(isonline() || isadmin() || issuper()){
			
		}else{
			redirect('Muka');
		}
	}

	function evaluasipeserta(){
		if($_SESSION['logged_in']['status']!=""){
			$data['pageTitle']="Evaluasi Project";
			$data['pageName']="Evaluasi";
			$iduser=$this->encryption->decrypt($_SESSION['logged_in']['id']);
			$where=array('pe.userid'=>$iduser,'pp.is_aktif'=>'aktif');
			$data['project']=$this->alter->getpesertaproject($where);
			$data['jenis']=$this->master->getjenisevaluasi();
			$this->output->set_template('dashboard');
			$this->load->view('page/tes_userevaluasi',$data);

		}else{
			logout();
		}
	}


	function listsoal(){
		$data['PageTitle']="Daftar Soal";
		$this->output->set_template('dashboard');
		$where=array('is_aktif'=>'aktif');
		$value=$this->master->getvalue($where);
		if(isadmin()){
			$soal=$this->ask->listsoal();
		}else{
			$soal=$this->ask->searchsoal($where);
		}

		$data['soal']=$soal;
		$data['value']=$value;
		$this->load->view('page/bank_soal',$data);
	}

	function start(){
		$data['PageTitle']="MuLai Tes";
		$usernya=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		$project=$this->uri->segment(2);
		$eval=$this->uri->segment(3);
		$ternilai=$this->uri->segment(4);
		$metode="NPS";
		
		///input di tabel evaluasi
		
		$where=array("is_aktif"=>"aktif","jenis_evaluasi"=>$eval);
		$soal = $this->ask->searchsoal($where);
		$data['namates']="Tes 1";
		$wheretarget=array('u.id'=>$ternilai);
		$data['peserta']=$this->user->getwherepeserta($wheretarget);
		$wherepenilai=array("u.id"=>$this->encryption->decrypt($_SESSION['logged_in']['id']));
		$data['penilai']=$this->user->getwherepeserta($wherepenilai);
		$data['soal']=$soal;
		$data['jawaban']=NPSjawab(); 
		$data['project']=$project;
		$data['evaluasi']=$eval;

		$this->output->set_template('dashboard');
		$this->load->view('page/starttes',$data);

	}

	//// SEBELUM TES PILIH SIAPA YANG AKAN DINILAI
	function pilihtarget(){
		$project=$this->uri->segment(2);
		$eval=$this->uri->segment(3);
		$isme=$this->encryption->decrypt($_SESSION['logged_in']['id']);
	
		//Get atasan bawahan
		$where1=array('a.leader'=>$isme);
		$bawahan=$this->alter->getatasan($where1);
		$where2=array('mitra'=>$isme);
		$mitra=$this->alter->getmitra($where2);
	
		// data 
		$data['project']=$project;
		$data['eval']=$eval;
		$data['bawahan']=$bawahan;
		$data['mitra']=$mitra;
		$data['tipeeval']="NPS";
		//display
		$this->output->set_template('dashboard');
		$this->load->view('page/tes_pilihtarget',$data);


		
	}


	////TES
	function prepare(){
		$res=$this->alter->prepare2(); //--> edit disini, tidak perlu pake proyek
		echo json_encode($res);
	}

	function getsoal(){
		$token=$this->encryption->decrypt($_GET['token']);
		$dataevaluasi=$this->alter->getprepare2(array("e.id"=>$token));

		$daftar=array("value"=>1,
					  "idpertanyaan"=>1,
					  "pertanyaan"=>"apakah manfaaat dari ini",
					  "jawaban"=>array("A"=>"option 1","B"=>"option 2"));
		$where =array("jenis_evaluasi"=>$dataevaluasi[0]->jenis);
		if($dataevaluasi[0]->tipe_nilai =="NPS"){
			$ans=array("1"=>-1,"2"=>-1,"3"=>-1,"4"=>-1,"5"=>-1,"6"=>-1,"7"=>0,"8"=>0,"9"=> 1,"10"=> 1);
		}else{
			$ans=array();
		}
		$data=$this->ask->searchsoal($where);
		$j=1;
		foreach ($data as $d){
			$pertanyaan =$d->deskripsi;
			$pertanyaan .=" (Nilai ".$d->pertanyaan.")";
			$tokensoal=$this->encryption->encrypt($d->id);
			$nosoal=$j;
			$element[]=array("question"=>$pertanyaan,
							 "answer"=>$ans,
							 "id"=>$d->id);
			$j++;
		}
		$res=$element;

		echo json_encode($res);
	}
////////////////////////////////// LAMA DISINI /////////////////////
	function loadsoal(){
		$project=$_GET['pro'];
		$eval=$_GET['eval'];
		$where=array('jenis_evaluasi'=>$eval,'is_aktif'=>'aktif');
		$res=$this->ask->searchsoal($where);
		$pesan_komplit="<h3>
		Terima Kasih Atas Penilaian yang dilakukan</h3>
		<h5>Keikutsertaan anda membantu improvement perusahaan</h5>
		<a href='".base_url('evaluasi')."' class='btn btn-lg btn-success'>Selesai Evaluasi</a>
		<p> Dengan menekan tombol selesai maka evaluasi anda akan dianggap selesai dan tidak bisa menginput kembali</p>";
		$res2=array(
			"showProgressBar"=>"top",
			"logoPosition"=>"right",
			"completedHtml"=>$pesan_komplit,
			"showQuestionNumbers"=> "on"
		);
		
		$j=0;
		foreach($res as $r){
		
			$pertanyaan =$r->deskripsi;
			$pertanyaan .=" (Nilai ".$r->pertanyaan.")";
			$id=$r->id;
			$element[]=array("type"=>"rating","name"=>$id,"title"=>$pertanyaan,"isRequired"=> true,"rateMin"=> 1,"rateMax"=> 10);
			$j++;
		}

		$databaru=array_chunk($element,5);
		$page=count((array)$databaru);
		for($i=0;$i < $page; $i++){
			$nopage=$i+1;
			$nama="halaman ".$nopage;
			$konten =$databaru[$i];
			$res2['pages'][]=array('name'=>$nama,'elements'=>$konten);
		}

		$json = json_encode($res2);
		//write json to file

			echo json_encode($res2);
	}

	function simpanevaluasi(){
		$res=$this->ask->submit();
		echo json_encode($res);
	}
/////////////////////////////////////END LAMA /////////////////
	
	function goevaluasi(){
		$idevaluasi = $this->uri->segment(2);
		$where=array('e.id'=>$idevaluasi);
		$dataevaluasi=$this->alter->getprepare2($where);
		if(count((array)$dataevaluasi) <= 0){
			redirect(base_url('userdashboard'));
		}else{
			$tipe=$dataevaluasi[0]->tipe_nilai;
		}
		
	
		/// tipe nilai NPS atau lainnya
		$tipe=jenis_evaluasi($idevaluasi);
		$idusersesi=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		//echo $idusersesi."-".$dataevaluasi[0]->id_peserta."-".$dataevaluasi[0]->id_penilai;
		$isatasan=isatasan($idusersesi,$dataevaluasi[0]->id_peserta);
		$ismitra=ismitra($idusersesi,$dataevaluasi[0]->id_peserta);
		if($idusersesi == $dataevaluasi[0]->id_peserta || $isatasan ||$ismitra){
			if($tipe=="NPS"){
				$whereuser=array("p.userid"=>$dataevaluasi[0]->id_peserta);
				$userdetail=$this->user->getpeserta2($whereuser);
				//print_r($userdetail);
				//die();
				switch($dataevaluasi[0]->status){
					case 'aktif':
						switch($dataevaluasi[0]->jenis){
							case '1':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis);
							break;
							case '2':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten);
							break;
							case '3':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;
							case '4':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;	
						};
								
						$datasoal = $this->ask->searchsoal($wheresoal);
						$data['evaluasi']=$dataevaluasi;
						$data['token']=$this->encryption->encrypt($idevaluasi);
						$data['soal']=$datasoal;
						//print_r($data['soal']);
						$this->output->set_template('dashboard');
						$this->load->view('page/evaluasi',$data);
							
					break;
					case 'draft':
						switch($dataevaluasi[0]->jenis){
							case '1':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis);
							break;
							case '2':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten);
							break;
							case '3':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;
							case '4':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;	
						};
						$wherejawab=array("evaluasi"=>$idevaluasi);
						$datasoal = $this->ask->searchsoal($wheresoal);
						$datajawaban =$this->ask->getans($wherejawab);
						
						$data['evaluasi']=$dataevaluasi;
						$data['token']=$this->encryption->encrypt($idevaluasi);
						$data['soal']=$datasoal;
						$data['jawab']=$datajawaban;

						$this->output->set_template('dashboard');
						$this->load->view('page/evaluasi',$data);
					break;
					case 'final':
						switch($dataevaluasi[0]->jenis){
							case '1':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis);
							break;
							case '2':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten);
							break;
							case '3':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;
							case '4':
								$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
								"jenis_asisten"=>$userdetail->jenis_asisten,
								"komoditas"=>$userdetail->komoditas,
								"unit_kerja"=>$userdetail->unitkerja);
							break;	
						};
						$wherejawab=array("evaluasi"=>$idevaluasi);
						$datasoal = $this->ask->searchsoal($wheresoal);
						$datajawaban =$this->ask->getans($wherejawab);
						
						$data['evaluasi']=$dataevaluasi;
						$data['token']=$this->encryption->encrypt($idevaluasi);
						$data['soal']=$datasoal;
						$data['jawab']=$datajawaban;

						$this->output->set_template('dashboard');
						$this->load->view('page/evaluasi',$data);
					break;
					
				} 
			
			}else if($tipe =="kinerja"){
				if($isatasan){
					$whereuser=array("p.userid"=>$dataevaluasi[0]->id_peserta);				
					$userdetail=$this->user->getpeserta2($whereuser);
					switch($dataevaluasi[0]->status){
						case 'aktif':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
											"jenis_asisten"=>$userdetail->jenis_asisten,
											"komoditas"=>$userdetail->komoditas,
											"unit_kerja"=>$userdetail->unitkerja);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;	
						break;
						case 'draft':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
							"jenis_asisten"=>$userdetail->jenis_asisten,
							"komoditas"=>$userdetail->komoditas,
							"unit_kerja"=>$userdetail->unitkerja);
							$wherejawab=array("evaluasi"=>$idevaluasi);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$datajawaban =$this->ask->getans($wherejawab);
							
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;
							$data['jawab']=$datajawaban;
						break;
						case 'final':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
							"jenis_asisten"=>$userdetail->jenis_asisten,
							"komoditas"=>$userdetail->komoditas,
							"unit_kerja"=>$userdetail->unitkerja);
							$wherejawab=array("evaluasi"=>$idevaluasi);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$datajawaban =$this->ask->getans($wherejawab);
							
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;
							$data['jawab']=$datajawaban;
						break;
					}
				}else{
					$whereuser=array("p.userid"=>$this->encryption->decrypt($_SESSION['logged_in']['id']));				
					$userdetail=$this->user->getpeserta2($whereuser);
					switch($dataevaluasi[0]->status){
						case 'aktif':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
											"jenis_asisten"=>$userdetail->jenis_asisten,
											"komoditas"=>$userdetail->komoditas,
											"unit_kerja"=>$userdetail->unitkerja);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;	
						break;
						case 'draft':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
							"jenis_asisten"=>$userdetail->jenis_asisten,
							"komoditas"=>$userdetail->komoditas,
							"unit_kerja"=>$userdetail->unitkerja);
							$wherejawab=array("evaluasi"=>$idevaluasi);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$datajawaban =$this->ask->getans($wherejawab);
							
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;
							$data['jawab']=$datajawaban;
						break;
						case 'final':
							$wheresoal=array("jenis_evaluasi"=>$dataevaluasi[0]->jenis,
							"jenis_asisten"=>$userdetail->jenis_asisten,
							"komoditas"=>$userdetail->komoditas,
							"unit_kerja"=>$userdetail->unitkerja);
							$wherejawab=array("evaluasi"=>$idevaluasi);
							$datasoal = $this->ask->searchsoal($wheresoal);
							$datajawaban =$this->ask->getans($wherejawab);
							
							$data['evaluasi']=$dataevaluasi;
							$data['token']=$this->encryption->encrypt($idevaluasi);
							$data['soal']=$datasoal;
							$data['jawab']=$datajawaban;
						break;
					}
				}
				
				$this->output->set_template('dashboard');
				$this->load->view('page/tes_kinerja',$data);
			}else{

			}
		}else{
			echo "<h1> Anda tidak memiliki akses ke survei ini	</h1>";
		}
			

	}	

	function simpansurvey(){
	
		foreach($_POST['nsoal'] as $s)
		{	
			$penilai=$this->encryption->decrypt($_SESSION['logged_in']['id']);
			$ideval=$this->encryption->decrypt($_POST['eval']);
			$target=$this->encryption->decrypt($_POST['target']);
			if(isset($_POST['answer'][$s])){
				$jawab = $_POST['answer'][$s];
			}else{
				$jawab =0;
			}

			//cek jika ada kombinasi soal
			$wherecek=array("evaluasi"=>$ideval,"soal"=>$s);
			$ceksoal=$this->ask->getans($wherecek);
			if(count((array)$ceksoal) > 0){
				$whereupdate=array("id"=>$ceksoal[0]->id);
				$dataans=array("evaluasi"=>$ideval,
				"jawaban"=>$jawab,
				"nilai"=>NPSscore($jawab),
				"is_aktif"=>"aktif"
				);
				$cekaksi=$this->ask->updateans($whereupdate,$dataans);
				$res[$s]=$cekaksi;
			}else{
				$dataans=array("evaluasi"=>$ideval,
				"jawaban"=>$jawab,
				"nilai"=>NPSscore($jawab),
				"soal"=>$s,
				"is_aktif"=>"aktif",
				"create_date"=>date('Y-m-d H:i:s')
				);
				///add jawaban di tabel jawaban
				$cekaksi=$this->ask->addans($dataans);
				$res[$s]=$cekaksi;
			}		
			///edit evaluasi jadi draft
			$whereeval=array('id'=>$ideval);
			$dataeval=array('status'=>"draft");
			$this->alter->editevaluasi($whereeval,$dataeval);
			//data input

		}
		echo json_encode($res);
		
	}

	function simpanfinal(){
	
		$ideval=$this->encryption->decrypt($_POST['eval']);
		$whereeval=array('id'=>$ideval);
		$nilainps=npsevaluasi(array("evaluasi"=>$ideval));
		$dataeval=array('status'=>"final","nilai"=>$nilainps);
		$update=$this->alter->editevaluasi($whereeval,$dataeval);
		if($update){
			$res=array("res"=>"ok","pesan"=>"sudah simpan final");
		}else{
			$res=array("res"=>"gagal","pesan"=>"sudah simpan final");
		}
		echo json_encode($res);	
		
	}
	



	////// Preparation Kinerja Tes
	
	function preparekinerjates(){
		///prepare tes
		if(isset($_POST['teval'])){
			$target=$this->encryption->decrypt($_POST['teval']);
		}else{
			$target=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		}
		
		$res=$this->alter->preparekinerja($target);
		echo json_encode($res);
		
	}

	function kinerjasubmit(){

		$res=$this->ask->addkinerja();	
		echo json_encode($res);
	}

	function addkinerjafile(){
		if(isset($_FILES['file'])){
			$filename=$this->encryption->decrypt($_POST['keval']).".pdf";
			//upload gambar
			$config['upload_path']          = FCPATH.'data/bukti_kinerja/';
			$config['file_name']            = $filename;
			$config['allowed_types']        = 'pdf';
			$config['overwrite']            = true;
			$config['max_size']             = 1000;
			$config['max_width']            = 1024;
			$config['max_height']           = 768;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('file')) {
				
				$where=array("id"=>$this->encryption->decrypt($_POST['keval']));
				$data=array("filebukti"=>$filename);
				$updateevaluasi=$this->alter->editevaluasi($where,$data);
				if($updateevaluasi){
					$res="ok";
				}else{
					$res="gagal update";
				}
				
			}else{
				$res=$this->upload->display_errors();
			}


		}else{
			$res="gambar kosong";
		}

		echo json_encode($res);


	}

	function approvekinerja(){
		$where=array("id"=>$this->encryption->decrypt($_POST['keval']));
		$iducatatan=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		$data=array("catatan"=>$_POST['catatan'],"catatan_dari"=>$iducatatan);
		$updateevaluasi=$this->alter->editevaluasi($where,$data);
		if($updateevaluasi){
			$res="ok";
		}else{
			$res="gagal update";
		}
		echo json_encode($res);
	}

	
	function periodekinerja(){
		$idus=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		$res=$this->alter->preparekinerja2($idus,$_POST['bulan'],$_POST['tahun']);
		if($res['res']=='ok'){
			redirect(base_url('startevaluasi/').$res['eval']);
		}else{
			$this->session->set_flashdata('error', $res['pesan']);
		}
		
	}

	function daftarkinerja(){
		$daftarbawahan=bawahan_list();
					$dbawahan=array();
					foreach($daftarbawahan as $db){
						//print_r($db->peserta);
						$whereb=array('u.id'=>$db->peserta);
						$databawahan = $this->user->getpeserta2($whereb);

						//evaluasi kinerja
						$whereEval=array("e.peserta"=>$db->peserta,"e.jenis"=>'5');
						$datakinerja=$this->alter->getevaluasi($whereEval);
						
						$dbawahan[]=array('peserta'=>$databawahan,'evaluasi'=>$datakinerja,'');
					}
					$data['bawahankinerja']=$dbawahan;
					
					//die();
					$this->output->set_template('dashboard');
					$this->load->view('page/daftarkinerjabawahan',$data);
	}
	

	function tes(){
		  //
		
		/// cari evaluasi disetiap user;
		$whereuser=array('u.isaktif','1');
		$peserta=$this->user->getwherepesertabyperusahaan($whereuser);
		$jumlahnilai=0;
		$nilai=0;
		$count=0;
		$datakinerja=array();
		foreach($peserta as $p){
		
			///cari mean per evaluasi
			$where=array('peserta'=>$p->uid,'jenis'=>'5','status'=>'final');
		
			$this->db->select('id,nilai,bulan,tahun')
					 ->from('tb_evaluasi')
					 ->where($where);
			$qnilai=$this->db->get()->row();
			if(isset($qnilai)){
				$nilai=$qnilai->nilai;
				
				//$datakinerja[$p->kd][$p->batch][$p->unitusaha][$p->jenis_asisten][$p->komoditas][]=$nilai;
			//	$jumlahnilai +=$nilai;
				$perusahaan=$p->kd;
				//$datakinerja['perusahaan'][$p->batch][$p->kd][$p->unitusaha][$p->jenis_asisten][$p->komoditas][]=$jumlahnilai;
				///penilaian kinerja
			}
			$datakinerja[$p->kd][$p->batch][$p->unitusaha][$p->jenis_asisten][$p->komoditas][]=$jumlahnilai;
			$datatmp[$p->uid][]=$nilai;
		}

		foreach($datatmp as $key=>$nilai){
			$whereuser2=array('u.isaktif','1','u.uid'=>$key);
			$this->user->getwherepesertabyperusahaan($whereuser);
		}
			
		
		foreach($datakinerja as $key=>$batch){
		
			/*
				foreach($batch as $key2=>$unit){
					foreach($unit as $key3=>$asisten){
						for($asisten as $key4=>$komoditas){
							echo $key;
							echo " -".$key2;
							echo " -".$key3;
							echo "<br>";

						}
						
					}
					
					
				}
				*/

				
			echo "<hr>";
		}

	}

	function progresspengisian(){
		
		$datacek=array();
	

		$where1=array('e.status'=>'final');
		$this->db->select('*')
				 ->from('tb_evaluasi as e')
				 ->join('tb_peserta as per','per.userid=e.penilai')
				 ->join('tb_user as u','u.id=per.userid')
				 ->order_by('u.company','ASC')
				 ->where($where1);
		$query1=$this->db->get()->result();

		foreach($query1 as $q1){
			$this->db->select("batch,nopeg,nama")
					 ->from("tb_peserta")
					 ->where('userid',$q1->peserta);
			$query2=$this->db->get()->row();

			//hitung bawahan / mitra
			$whereb=array("a.leader"=>$q1->peserta,"p.batch"=>$query2->batch);
			$this->db->select("a.peserta")
					 ->from('tb_atasan as a')
					 ->join('tb_peserta as p','p.userid=a.peserta')
					 ->where($whereb);
			$query3=$this->db->get()->row();
			
			$datacek[$q1->id][$q1->evaluasi][$query2->batch]['nopeg'][]=$query2->nopeg;
			$datacek[$q1->id][$q1->evaluasi][$query2->batch]['jatah'][]=$query3;
		
		}


		foreach($datacek as $key => $d){
			foreach($d as $key2=>$e){
				foreach($e as $key3=>$f){
					//echo " id:".$key. "- JENIS: ".$key2." - BATCH :".$key3." - done:".count((array)$f['nopeg'])." dari ".count((array)$f['jatah'])."<br>";
					$datadisp[]=array("NoPenilai"=>$key,"jenis"=>$key2,"batch"=>$key3,"done"=>count((array)$f['nopeg']),"jatah"=>count((array)$f['jatah']));
				}
				
			}

		
		}
		
		
		$data['progress']=$datadisp;
		$this->output->set_template('dashboard');
		$this->load->view('page/progrespengisian',$data);
		/**/


	}

	function cekpengisianpeserta(){

		if(isset($_SESSION)){
			if($_SESSION['logged_in']['perusahaan']=="all"){
				$perusahaan=$_SESSION['logged_in']['perusahaan'];
				$where=array('u.isaktif'=>'1',);
			}else{
				$perusahaan=$_SESSION['logged_in']['perusahaan'];
				$where=array('u.isaktif'=>'1',"u.company"=>$perusahaan);
			}
			
		
		
		}else{
			logout();
		}
		
		//cek tiap user 
		
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,c.id as kid,p.jenis_asisten,p.komoditas,p.batch')
				 ->from('tb_peserta as p')
				 ->join('tb_user as u','u.id=p.userid')
				 ->join('tb_perusahaan as c','c.id=u.company')
				 ->where($where);
		$query1=$this->db->get()->result();

		$datacek=array();
		$datauser=array();
		$datarekap=array();

		foreach($query1 as $q){
			$stat=$q->status_peserta;
			///etos kerja
			$penilai= $q->userid;
			$bawahan=count((array)$this->alter->getrelasi('bawahan',array('m.leader'=>$penilai,"m.status"=>"aktif")));
			$mitra=count((array)$this->alter->getrelasi('mitra',array('m.mitra'=>$penilai,"m.status"=>"aktif")));
			$jpenilaian=$bawahan + $mitra;

			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$statuspeserta="Peserta";
			}else if($mitra > 0 && $bawahan == 0  && $stat=="peserta"){
				$statuspeserta="Peserta & Mitra";
			}else if($bawahan > 0 && $stat=="penilai"){
				$statuspeserta="Atasan";
			}else if($mitra>0 && $stat=="penilai" && $bawahan == 0){
				$statuspeserta="Mitra";
			}else{
				$statuspeserta="";
			}

			
			$whereetos=array('evaluasi'=>'1','penilai'=>$penilai,'status'=>'final');
			$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($whereetos);
			$queryetos=$this->db->count_all_results();
			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$jetos="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}else if($mitra > 0 && $stat=="peserta"){
				if($queryetos < $mitra){
					$jetos="<small style='color:#e67e22'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra<small>";
					$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($queryetos < $mitra){
					$jetos="<small style='color:#e67e22'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra<small>";
					$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($queryetos < $bawahan){
					$jetos="<small style='color:#e67e22'>Memberi ".$queryetos." evaluasi pada  ".$bawahan." bawahan</small></small>";
					$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos." evaluasi pada  ".$bawahan." bawahan</small></small>";
					$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
				}
			}
			else{
				$jetos="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}

			

			//tradisi
			$wheretradisi=array('evaluasi'=>'2','penilai'=>$penilai,'status'=>'final');
			$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($wheretradisi);
			$querytradisi=$this->db->count_all_results();
			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$jtradisi="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}else if($mitra > 0 && $stat=="peserta"){
				if($querytradisi < $mitra){
					$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($querytradisi < $mitra){
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
					$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($querytradisi < $bawahan){
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi." evaluasi pada  ".$bawahan." bawahan</small>";
					$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi." evaluasi pada  ".$bawahan." bawahan</small>";
					$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
				}
			}
			else{
				
			}


			//tritertib
			$wheretritertib=array('evaluasi'=>'3','penilai'=>$penilai,'status'=>'final');
			$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($wheretritertib);
			$querytritertib=$this->db->count_all_results();
			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$jtritertib="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}else if($mitra > 0 && $stat=="peserta"){
				if($querytritertib < $mitra){
					$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($querytritertib < $mitra){
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
					$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($querytritertib < $bawahan){
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib." evaluasi pada  ".$bawahan." bawahan</small>";
					$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib."evaluasi pada  ".$bawahan." bawahan</small>";
					$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
				}
			}
			else{
				
			}

			//atribut
			$whereatribut=array('evaluasi'=>'4','penilai'=>$penilai,'status'=>'final');
			$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($whereatribut);
			$queryatribut=$this->db->count_all_results();
			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$jatrib="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}else if($mitra > 0 && $stat=="peserta"){
				if($queryatribut < $mitra){
					$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
					$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($queryatribut < $mitra){
					$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra</small>";
					$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($queryatribut < $bawahan){
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
					$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
					$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
				}
			}
			else{
			
			}


			//kinerja
			
			
			$sisa="";
			if($bawahan == 0 && $stat== "peserta"){
				$wherekin=array('evaluasi'=>'5','penilai'=>$penilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($wherekin);
				$querykin=$this->db->count_all_results();
				$sisa="1 (peserta)";
				$jkin="<small style='color:#16a085'>telah mengisi ".$querykin. " evaluasi</small>";
				$datarekap[$q->kdc]['kinerja']['mengisi'][]=$q->nopeg;
			}else if($bawahan > 0 && $stat=="penilai"){
				$wherekin=array('evaluasi'=>'5','catatan_dari'=>$penilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($wherekin);
				$querykin=$this->db->count_all_results();
				$sisa=$bawahan;
				$jkin=$querykin." dari ".$sisa ."(approval)";
				$jkin="<small style='color:#16a085'>".$querykin."<br>(approval)</small>";
				$datarekap[$q->kdc]['kinerja']['approve'][]=$q->nopeg;
			}
			else if($mitra > 0 && $q->status_peserta == "penilai"){
		
				$jkin="<small style='color:#16a085'>Mitra hanya mengisi 4 evaluasi</small>";
			}
			else{
				$jkin="";
			}
			

			//pemisah batch
			$batch=empty($q->batch)?"non peserta":$q->batch;
			$asisten=$batch=="non peserta"?"-":$q->jenis_asisten;
			$komoditas=$batch=="non peserta"?"-":$q->komoditas;
			$datamentah[]=array("user"=>$q->userid,
								"nik"=>$q->nopeg,
								"nama"=>$q->nama,
								"perusahaan"=>$q->kdc,
								'komoditas'=>$komoditas,
								"asisten"=>$asisten,
								"etos"=>$jetos,
								"tradisi"=>$jtradisi,
								"tritertib"=>$jtritertib,
								"atribut"=>$jatrib,
								"kinerja"=>$jkin,
								"batch"=>$batch,
								"status"=>$statuspeserta);

			///// PROGRESS BY BATCH/PERUSAHAAN
			$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid));
			$jatasan=count((Array)$atasan);
			$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid));
			$jmitra=count((Array)$mitra);
			$datasan=array();
			if($jatasan > 0){
				$atasanid=$atasan[0]->idkoneksi;
				foreach($atasan as $a){
					//Penilaian dilakukan orang lain 
					$wherea=array('peserta'=>$q->userid,"penilai"=>$a->idkoneksi,"status"=>'final');
					$this->db->select('count(id) as jumlah')
							 ->from('tb_evaluasi')
							 ->where($wherea);
					$query2=$this->db->get()->row();
					//echo $this->db->last_query();
					$jetos=0;
					$jtradisi=0;
					$jtritertib=0;
					$jatribut=0;
					$jtotal=0;
					foreach($query2 as $q2){
						$jtotal++;
					}
					
					$datasan[]=array("nama"=>$a->koneksi,"jtotal"=>$query2->jumlah);
				}
			}else{
				$atasanid="-";
			}

			$dmitra=array();
			if($jmitra > 0){
				$mitralist="";			
				foreach($mitra as $m){	
					$wherem=array('peserta'=>$q->userid,"penilai"=>$m->idkoneksi,"status"=>'final');
					$this->db->select('id,evaluasi')
					->from('tb_evaluasi')
					->where($wherem);
					$query3=$this->db->get()->result();
					$jetos=0;
					$jtradisi=0;
					$jtritertib=0;
					$jatribut=0;
					$jtotal=0;
					foreach($query3 as $q3){
						
						$jtotal++;
					}
					$dmitra[]=array("nama"=>$m->koneksi,"eval"=>$jtotal);
				//	echo "user :".$q->userid."  nama mitra:".$m->koneksi." evaluasi : ".$jtotal."<br>";
					
				}

			}else{
				$mitraid="-";
			}
			//cek penilaian dari atasan
			$jatah_evaluasi=($jatasan*4)+($jmitra*4);
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"nopeg"=>$q->nopeg,"perusahaan"=>$q->kdc,"idp"=>$q->kid,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);
			
		//// END OF  PROGRESS BY BATCH 
			
		}

	$display=array();
	$detailbatch=array();
	foreach($datauser as $du){
		$atasanisi=0;
		if(isset($du['evalatasan'][0])){
		$atasanisi=$du['evalatasan'][0]['jtotal'];	
		}else{
			
		}
		$mitraisi=array_column($du['evalmitra'], 'eval');
		$jmitraisi=array_sum($mitraisi);
		
		$selesai=$atasanisi  + $jmitraisi;
		$jatah=$du['jatah_evaluasi'];
		$kurang=$du['jatah_evaluasi']-$selesai;
		$persen=$selesai > 0?$selesai/$jatah:0;

		$disp[$du['perusahaan']][$du['batch']][]=$persen;
	}

	$databatch=array();
	foreach($disp as $key1=>$batch)	{		
		foreach($batch as $key2=>$val){
			$j= count((array)$val);
			$n=array_sum($val);
			$persentotal=$n>0?round(($n/$j)*100,2):0;
			$databatch[]=array("perusahaan"=>$key1,"batch"=>$key2,"progres"=>$persentotal);
		}
	}
			$data['cek']=$datamentah;
			$data['rekap']=$datarekap;
			$data['batch']=$databatch;
			$this->output->set_template('dashboard');
			$this->load->view('page/cek_pengisian',$data);
}

	function cekdetailpengisian(){
		if($_SESSION['logged_in']['status'] == 'superadmin'){
			$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
		}else{
			if(isset($_SESSION['logged_in']['perusahaan'])){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','c.id'=>$_SESSION['logged_in']['perusahaan']);
			}else{
				logout();
			}
		}
		
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($filter);
		$query1=$this->db->get()->result();
		
		$datauser=array();
		foreach($query1 as $q){
			
			$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid));
			$jatasan=count((Array)$atasan);
			$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid));
			$jmitra=count((Array)$mitra);
			
			$datasan=array();
			if($jatasan > 0){
				$atasanid=$atasan[0]->idkoneksi;
				foreach($atasan as $a){
				
					//Penilaian dilakukan orang lain 
					$wherea=array('peserta'=>$q->userid,"penilai"=>$a->idkoneksi,"status"=>'final');
					$this->db->select('count(id) as jumlah')
							 ->from('tb_evaluasi')
							 ->where($wherea);
					$query2=$this->db->get()->row();
					//echo $this->db->last_query();
					$jetos=0;
					$jtradisi=0;
					$jtritertib=0;
					$jatribut=0;
					$jtotal=0;
					foreach($query2 as $q2){
						$jtotal++;
					}
					
					$datasan[]=array("nama"=>$a->koneksi,"jtotal"=>$query2->jumlah);
				}
			}else{
				$atasanid="-";
			}

			$dmitra=array();
			if($jmitra > 0){
				$mitralist="";
				
				foreach($mitra as $m){
					
					$wherem=array('peserta'=>$q->userid,"penilai"=>$m->idkoneksi,"status"=>'final');
					$this->db->select('id,evaluasi')
					->from('tb_evaluasi')
					->where($wherem);
					$query3=$this->db->get()->result();
					$jetos=0;
					$jtradisi=0;
					$jtritertib=0;
					$jatribut=0;
					$jtotal=0;
					foreach($query3 as $q3){
						
						$jtotal++;
					}
					$dmitra[]=array("nama"=>$m->koneksi,"eval"=>$jtotal);
				//	echo "user :".$q->userid."  nama mitra:".$m->koneksi." evaluasi : ".$jtotal."<br>";

				
					
				}

			}else{
				$mitraid="-";
			}
			//cek penilaian dari atasan
			$jatah_evaluasi=($jatasan*4)+($jmitra*4);
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"perusahaan"=>$q->kdc,"nopeg"=>$q->nopeg,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);
			
		}
		
		$data['detail']=$datauser;
		$this->output->set_template('dashboard');
		$this->load->view('page/cek_pengisian_detail',$data);
	}




	function monitoringpengisian_backup(){
		//print_r($_SESSION);
		if($_SESSION['logged_in']['perusahaan']=="all"){
			$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif"));
			$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
		}else{
			$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif","id"=>$_SESSION['logged_in']['perusahaan']));
			$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
		}
		
	
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
				$entitaschoose=isset($_POST['entitas'])&& $_POST['entitas']!=""?$_POST['entitas']:"all";
			}else{
				$entitaschoose=$_SESSION['logged_in']['perusahaan'];
			}
			
		}
		
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

		//koleksi data rekap
		if(isset($where_in)){
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,c.id as kid,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($where)
			->where_in('p.batch',$where_in);
		}else{
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,c.id as kid,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($where);
		}
		
		$query1=$this->db->get()->result();
		$syntax=$this->db->last_query();
		$query2=$this->db->last_query();
		$datarekap=array();
		$datauser=array();
		$disp=array();
		$datamentah=array();
		
		// susun progress
		foreach($query1 as $q){	
				$stat=$q->status_peserta;
				///etos kerja
				$penilai= $q->userid;
				$bawahan=count((array)$this->alter->getrelasi('bawahan',array('m.leader'=>$penilai,"m.status"=>"aktif")));
				$mitra=count((array)$this->alter->getrelasi('mitra',array('m.mitra'=>$penilai,"m.status"=>"aktif")));
				$jpenilaian=$bawahan + $mitra;

					if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
						$statuspeserta="Peserta";
					}else if($mitra > 0 && $bawahan == 0  && $stat=="peserta"){
						$statuspeserta="Peserta & Mitra";
					}else if($bawahan > 0 && $stat=="penilai"){
						$statuspeserta="Atasan";
					}else if($mitra>0 && $stat=="penilai" && $bawahan == 0){
						$statuspeserta="Mitra";
					}else{
						$statuspeserta="";
					}


				
				/// 1. etos kerja
				$whereetos=array('evaluasi'=>'1','penilai'=>$penilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($whereetos);
				$queryetos=$this->db->count_all_results();
				if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
					$jetos="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
				}else if($mitra > 0 && $stat=="peserta"){
					if($queryetos < $mitra){
						$jetos="<small style='color:#e67e22'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra<small>";
						$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
					}else{
						$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
						$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
					}
					
				}else if($mitra >0 && $stat=="penilai"){
					if($queryetos < $mitra){
						$jetos="<small style='color:#e67e22'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra<small>";
						$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
					}else{
						$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
						$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
					}
				}else if($bawahan >0 && $stat=="penilai"){
					if($queryetos < $bawahan){
						$jetos="<small style='color:#e67e22'>Memberi ".$queryetos." evaluasi pada  ".$bawahan." bawahan</small></small>";
						$datarekap[$q->kdc]['etos']['kurang'][]=$q->nopeg;
					}else{
						$jetos="<small style='color:#16a085'>Memberi ".$queryetos." evaluasi pada  ".$bawahan." bawahan</small></small>";
						$datarekap[$q->kdc]['etos']['selesai'][]=$q->nopeg;
					}
				}
				else{
					$jetos="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
				}

				// 2. tradisi
				$wheretradisi=array('evaluasi'=>'2','penilai'=>$penilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($wheretradisi);
				$querytradisi=$this->db->count_all_results();
				if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
					$jtradisi="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
				}else if($mitra > 0 && $stat=="peserta"){
					if($querytradisi < $mitra){
						$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
						$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
					}else{
						$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
						$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
					}
					
				}else if($mitra >0 && $stat=="penilai"){
					if($querytradisi < $mitra){
						$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
						$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
					}else{
						$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
						$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
					}
				}else if($bawahan >0 && $stat=="penilai"){
					if($querytradisi < $bawahan){
						$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi." evaluasi pada  ".$bawahan." bawahan</small>";
						$datarekap[$q->kdc]['tradisi']['kurang'][]=$q->nopeg;
					}else{
						$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi." evaluasi pada  ".$bawahan." bawahan</small>";
						$datarekap[$q->kdc]['tradisi']['selesai'][]=$q->nopeg;
					}
				}
				else{
					
				}


				// 3. tritertib
					$wheretritertib=array('evaluasi'=>'3','penilai'=>$penilai,'status'=>'final');
					$this->db->select("id,status,catatan,catatan_dari,filebukti")
							->from('tb_evaluasi')
							->where($wheretritertib);
					$querytritertib=$this->db->count_all_results();
					if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
						$jtritertib="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
					}else if($mitra > 0 && $stat=="peserta"){
						if($querytritertib < $mitra){
							$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
							$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
						}else{
							$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
							$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
						}
						
					}else if($mitra >0 && $stat=="penilai"){
						if($querytritertib < $mitra){
							$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
							$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
						}else{
							$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
							$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
						}
					}else if($bawahan >0 && $stat=="penilai"){
						if($querytritertib < $bawahan){
							$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib." evaluasi pada  ".$bawahan." bawahan</small>";
							$datarekap[$q->kdc]['tritertib']['kurang'][]=$q->nopeg;
						}else{
							$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib."evaluasi pada  ".$bawahan." bawahan</small>";
							$datarekap[$q->kdc]['tritertib']['selesai'][]=$q->nopeg;
						}
					}
					else{
						
					}

				// 4. atribut
					$whereatribut=array('evaluasi'=>'4','penilai'=>$penilai,'status'=>'final');
					$this->db->select("id,status,catatan,catatan_dari,filebukti")
							->from('tb_evaluasi')
							->where($whereatribut);
					$queryatribut=$this->db->count_all_results();
					if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
						$jatrib="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
					}else if($mitra > 0 && $stat=="peserta"){
						if($queryatribut < $mitra){
							$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
							$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
						}else{
							$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
							$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
						}
						
					}else if($mitra >0 && $stat=="penilai"){
						if($queryatribut < $mitra){
							$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
							$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
						}else{
							$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra</small>";
							$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
						}
					}else if($bawahan >0 && $stat=="penilai"){
						if($queryatribut < $bawahan){
							$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
							$datarekap[$q->kdc]['atribut']['kurang'][]=$q->nopeg;
						}else{
							$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
							$datarekap[$q->kdc]['atribut']['selesai'][]=$q->nopeg;
						}
					}
					else{
					
					}

				// 5. kinerja
					$sisa="";
					if($bawahan == 0 && $stat== "peserta"){
						$wherekin=array('evaluasi'=>'5','penilai'=>$penilai,'status'=>'final');
						$this->db->select("id,status,catatan,catatan_dari,filebukti")
								->from('tb_evaluasi')
								->where($wherekin);
						$querykin=$this->db->count_all_results();
						$sisa="1 (peserta)";
						$jkin="<small style='color:#16a085'>telah mengisi ".$querykin. " evaluasi</small>";
						$datarekap[$q->kdc]['kinerja']['mengisi'][]=$q->nopeg;
					}else if($bawahan > 0 && $stat=="penilai"){
						$wherekin=array('evaluasi'=>'5','catatan_dari'=>$penilai,'status'=>'final');
						$this->db->select("id,status,catatan,catatan_dari,filebukti")
							->from('tb_evaluasi')
							->where($wherekin);
						$querykin=$this->db->count_all_results();
						$sisa=$bawahan;
						$jkin=$querykin." dari ".$sisa ."(approval)";
						$jkin="<small style='color:#16a085'>".$querykin."<br>(approval)</small>";
						$datarekap[$q->kdc]['kinerja']['approve'][]=$q->nopeg;
					}
					else if($mitra > 0 && $q->status_peserta == "penilai"){
				
						$jkin="<small style='color:#16a085'>Mitra hanya mengisi 4 evaluasi</small>";
					}
					else{
						$jkin="";
					}

					
				/// progress by batch
				//pemisah batch
				$batch=empty($q->batch)?"non peserta":$q->batch;
				$asisten=$batch=="non peserta"?"-":$q->jenis_asisten;
				$komoditas=$batch=="non peserta"?"-":$q->komoditas;
				$datamentah[]=array("user"=>$q->userid,
									"nik"=>$q->nopeg,
									"nama"=>$q->nama,
									"perusahaan"=>$q->kdc,
									'komoditas'=>$komoditas,
									"asisten"=>$asisten,
									"etos"=>$jetos,
									"tradisi"=>$jtradisi,
									"tritertib"=>$jtritertib,
									"atribut"=>$jatrib,
									"kinerja"=>$jkin,
									"batch"=>$batch,
									"status"=>$statuspeserta);

				$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid));
				$jatasan=count((Array)$atasan);
				$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid));
				$jmitra=count((Array)$mitra);
				$datasan=array();
				if($jatasan > 0){
					$atasanid=$atasan[0]->idkoneksi;
					foreach($atasan as $a){
						//Penilaian dilakukan orang lain 
						$wherea=array('peserta'=>$q->userid,"penilai"=>$a->idkoneksi,"status"=>'final');
						$this->db->select('count(id) as jumlah')
								->from('tb_evaluasi')
								->where($wherea);
						$query2=$this->db->get()->row();
						//echo $this->db->last_query();
						$jetos=0;
						$jtradisi=0;
						$jtritertib=0;
						$jatribut=0;
						$jtotal=0;
						foreach($query2 as $q2){
							$jtotal++;
						}
						
						$datasan[]=array("nama"=>$a->koneksi,"jtotal"=>$query2->jumlah);
					}
				}else{
					$atasanid="-";
				}
				$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid));
				$jatasan=count((Array)$atasan);
				$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid));
				$jmitra=count((Array)$mitra);
				$datasan=array();
				if($jatasan > 0){
					$atasanid=$atasan[0]->idkoneksi;
					foreach($atasan as $a){
						//Penilaian dilakukan orang lain 
						$wherea=array('peserta'=>$q->userid,"penilai"=>$a->idkoneksi,"status"=>'final');
						$this->db->select('count(id) as jumlah')
								->from('tb_evaluasi')
								->where($wherea);
						$query2=$this->db->get()->row();
						//echo $this->db->last_query();
						$jetos=0;
						$jtradisi=0;
						$jtritertib=0;
						$jatribut=0;
						$jtotal=0;
						foreach($query2 as $q2){
							$jtotal++;
						}
						
						$datasan[]=array("nama"=>$a->koneksi,"jtotal"=>$query2->jumlah);
					}
				}else{
					$atasanid="-";
				}

				$dmitra=array();
				if($jmitra > 0){
					$mitralist="";			
					foreach($mitra as $m){	
						$wherem=array('peserta'=>$q->userid,"penilai"=>$m->idkoneksi,"status"=>'final');
						$this->db->select('id,evaluasi')
						->from('tb_evaluasi')
						->where($wherem);
						$query3=$this->db->get()->result();
						$jetos=0;
						$jtradisi=0;
						$jtritertib=0;
						$jatribut=0;
						$jtotal=0;
						foreach($query3 as $q3){
							
							$jtotal++;
						}
						$dmitra[]=array("nama"=>$m->koneksi,"eval"=>$jtotal);
					//	echo "user :".$q->userid."  nama mitra:".$m->koneksi." evaluasi : ".$jtotal."<br>";
						
					}

				}else{
					$mitraid="-";
				}
			//cek penilaian dari atasan
			$jatah_evaluasi=($jatasan*4)+($jmitra*4);
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"nopeg"=>$q->nopeg,"perusahaan"=>$q->kdc,"idp"=>$q->kid,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);

		/*	*/
		}

		$display=array();
		$detailbatch=array();
		foreach($datauser as $du){
			$atasanisi=0;
			if(isset($du['evalatasan'][0])){
			$atasanisi=$du['evalatasan'][0]['jtotal'];	
			}else{
			$atasanisi=0;
			}
			$mitraisi=array_column($du['evalmitra'], 'eval');
			$jmitraisi=array_sum($mitraisi);
			
			$selesai=$atasanisi  + $jmitraisi;
			$jatah=$du['jatah_evaluasi'];
			$kurang=$du['jatah_evaluasi']-$selesai;
			$persen=$selesai > 0?$selesai/$jatah:0;

			$disp[$du['perusahaan']][$du['batch']][]=$persen;
		}

		$databatch=array();
		foreach($disp as $key1=>$batch)	{		
			foreach($batch as $key2=>$val){
				$j= count((array)$val);
				$n=array_sum($val);
				$persentotal=$n>0?round(($n/$j)*100,2):0;
				$databatch[]=array("perusahaan"=>$key1,"batch"=>$key2,"progres"=>$persentotal);
			}
		}


		
		//end koleksi data

		$data['cek']=$datamentah;
		$data['rekap']=$datarekap;
		$data['batch']=$databatch;
		$data['postentitas']=$entitaschoose;
		$data['postbatch']=$batchchoose;
		$data['syntax']=$syntax;
		$this->output->set_template('dashboard');
		$this->load->view('page/view_progresspengisian',$data);
	}

	function monitoringpengisian(){
	
		if($_SESSION['logged_in']['perusahaan']=="all"){
			$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif"));
			$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
		}else{
			$data['entitas']=$this->master->getperusahaan(array("is_aktif"=>"aktif","id"=>$_SESSION['logged_in']['perusahaan']));
			$data['batchlist']=array("1","2","3","4","5","6","7","8","9","10");
		}
		
	
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
				$entitaschoose=isset($_POST['entitas'])&& $_POST['entitas']!=""?$_POST['entitas']:"all";
			}else{
				$entitaschoose=$_SESSION['logged_in']['perusahaan'];
			}
			
		}
		
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

		

		//$where=array('u.isaktif'=>'1',"u.company"=>'10');
		//$where_in=explode(',','9');

	//koleksi data rekap
		if(isset($where_in)){
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,c.id as kid,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($where)
			->where_in('p.batch',$where_in);
		}else{
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,c.id as kid,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($where);
		}
	
		$query1=$this->db->get()->result();
		$datarekap=array();
		$datauser=array();
		$disp=array();
		$datamentah=array();
	
		foreach ($query1 as $q){
			$datapenilai=array();
			$stat =$q->status_peserta;
			$peserta = $q->userid;
			$atasan =$this->alter->getrelasi('atasan',array('m.peserta'=>$peserta,"m.status"=>"aktif"));
			$jatasan=count($atasan);
			$bawahan=$this->alter->getrelasi('bawahan',array('m.leader'=>$peserta,"m.status"=>"aktif"));
			$jbawahan=count($bawahan);
			$mitra = $this->alter->getrelasi('mitra',array('m.peserta'=>$peserta,"m.status"=>"aktif"));
			$jmitra=count($mitra);
			$jpenilaian =$jatasan+$jmitra;
			
			foreach($atasan as $a){
				array_push($datapenilai,array("id"=>$a->idkoneksi,"nik"=>$a->nikatasan));
			}

			foreach($mitra as $m){
				array_push($datapenilai,array("id"=>$m->idkoneksi,"nik"=>$m->nikmitra));
			}

			if($jbawahan == 0  && $jmitra==0 && $stat=="peserta"){
				$statuspeserta="Peserta";
			}else if($jmitra > 0 && $jbawahan == 0  && $stat=="peserta"){
				$statuspeserta="Peserta & Mitra";
			}else if($jbawahan > 0 && $stat=="penilai"){
				$statuspeserta="Atasan";
			}else if($jmitra > 0 && $stat=="penilai" && $jbawahan == 0){
				$statuspeserta="Mitra";
			}else{
				$statuspeserta="";
			}


			//cek penilaian disetiap kategori penilaian.
			foreach($datapenilai as $dp){
				$idpenilai=$dp['id'];

				//1. etos
				$whereetos=array('evaluasi'=>'1','penilai'=>$idpenilai,'peserta'=>$peserta,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
							->from('tb_evaluasi')
							->where($whereetos);
				$queryetos=$this->db->count_all_results();
				if($queryetos > 0){
					$datarekap[$q->kdc]['etos']['selesai'][]=$dp['nik'];
					$datarekap[$q->kdc]['etos']['pesan'][]=$dp['nik']." telah menilai etos dari ".$q->nopeg;
				}else{
					$datarekap[$q->kdc]['etos']['kurang'][]=$dp['nik'];
					$datarekap[$q->kdc]['etos']['pesan'][]=$dp['nik']." belum menilai etos dari ".$q->nopeg;
				}

				//2. tradisi
				$wheretradisi=array('evaluasi'=>'2','penilai'=>$idpenilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($wheretradisi);
				$querytradisi=$this->db->count_all_results();
				if($querytradisi > 0){
					$datarekap[$q->kdc]['tradisi']['selesai'][]=$dp['nik'];
					$datarekap[$q->kdc]['tradisi']['pesan'][]=$dp['nik']." telah menilai tradisi dari ".$q->nopeg;
				}else{
					$datarekap[$q->kdc]['tradisi']['kurang'][]=$dp['nik'];
					$datarekap[$q->kdc]['tradisi']['pesan'][]=$dp['nik']." belum menilai tradisi dari ".$q->nopeg;
				}


				// 3. tritertib
				$wheretritertib=array('evaluasi'=>'3','penilai'=>$idpenilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($wheretritertib);
				$querytritertib=$this->db->count_all_results();

				if($querytritertib > 0){
					$datarekap[$q->kdc]['tritertib']['selesai'][]=$dp['nik'];
					$datarekap[$q->kdc]['tritertib']['pesan'][]=$dp['nik']." telah menilai tritertib dari ".$q->nopeg;
				}else{
					$datarekap[$q->kdc]['tritertib']['kurang'][]=$dp['nik'];
					$datarekap[$q->kdc]['tritertib']['pesan'][]=$dp['nik']." belum menilai tritertib dari ".$q->nopeg;
				}


				// 4. atribut
				$whereatribut=array('evaluasi'=>'4','penilai'=>$idpenilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
						->from('tb_evaluasi')
						->where($whereatribut);
				$queryatribut=$this->db->count_all_results();

				if($queryatribut > 0){
					$datarekap[$q->kdc]['atribut']['selesai'][]=$dp['nik'];
					$datarekap[$q->kdc]['atribut']['pesan'][]=$dp['nik']." telah menilai atribut dari ".$q->nopeg;
				}else{
					$datarekap[$q->kdc]['atribut']['kurang'][]=$dp['nik'];
					$datarekap[$q->kdc]['atribut']['pesan'][]=$dp['nik']." belum menilai atribut dari ".$q->nopeg;
				}
				
			}
		}

		$rekap=$datarekap['PTPN X'];
		
		//echo "1.ETOS :Penilaian selesai :".count((array)$rekap['etos']['selesai'])." Penilain belum dilakukan :".count((array)$rekap['etos']['kurang'])."<br>";
		//echo "2. TRADISI :Penilaian selesai :".count((array)$rekap['tradisi']['selesai'])." Penilain belum dilakukan :".count((array)$rekap['tradisi']['kurang'])."<br>";
		$datadisplay=array();
		foreach($datarekap as $key=>$val){
			//etos
			$etosok=isset($val['etos']['selesai'])?count((array)$val['etos']['selesai']):0;
			$etoskurang = isset($val['etos']['kurang'])?count((array)$val['etos']['kurang']):0;
			$totaletos =$etosok +$etoskurang;
			$persenetos =round(((int)$etosok/(int)$totaletos)*100,2);
			//tradisi
			$tradisiok=isset($val['tradisi']['selesai'])?count((array)$val['tradisi']['selesai']):0;
			$tradisikurang =isset($val['tradisi']['kurang'])? count((array)$val['tradisi']['kurang']):0;
			$totaltradisi =$tradisiok +$tradisikurang;
			$persentradisi =round(((int)$tradisiok/(int)$totaltradisi)*100,2);

			//tritertib
			$tritertibok=isset($val['tritertib']['selesai'])?count((array)$val['tritertib']['selesai']):0;
			$tritertibkurang =isset($val['tritertib']['kurang'])? count((array)$val['tritertib']['kurang']):0;
			$totaltritertib =$tritertibok +$tritertibkurang;
			$persentritertib =round(((int)$tritertibok/(int)$totaltritertib)*100,2);
			
			//tritertib
			$atributok=isset($val['atribut']['selesai'])?count((array)$val['atribut']['selesai']):0;
			$atributkurang = isset($val['atribut']['kurang'])?count((array)$val['atribut']['kurang']):0;
			$totalatribut =$atributok +$atributkurang;
			$persenatribut =round(((int)$atributok/(int)$totalatribut)*100,2);
			

			

			///hitung semua
			$ok=$etosok+$tradisiok+$tritertibok+$atributok;
			$kurang=$etoskurang+$tradisikurang+$tritertibkurang+$atributkurang;
			$total =$ok +$kurang;
			$persen =round(((int)$ok/(int)$total)*100,2);
			$datadisplay[$key]["data"]=array("selesai"=>$ok,"kurang"=>$kurang,"total"=>$total,"persen"=>$persen);
			$datadisplay[$key]["etos"]=array("selesai"=>$etosok,"kurang"=>$etoskurang,"total"=>$totaletos,"persen"=>$persenetos);
			$datadisplay[$key]["tradisi"]=array("selesai"=>$tradisiok,"kurang"=>$tradisikurang,"total"=>$totaltradisi,"persen"=>$persentradisi);
			$datadisplay[$key]["tritertib"]=array("selesai"=>$tritertibok,"kurang"=>$tritertibkurang,"total"=>$totaltritertib,"persen"=>$persentritertib);
			$datadisplay[$key]["atribut"]=array("selesai"=>$atributok,"kurang"=>$atributkurang,"total"=>$totalatribut,"persen"=>$persenatribut);
		}
		$data['cek']=$datamentah;
		//$data['batch']=$databatch;
		$data['postentitas']=$entitaschoose;
		$data['postbatch']=$batchchoose;

		$data['rekap']=$datadisplay;
		$this->output->set_template('dashboard');
		$this->load->view('page/view_progresspengisian_update',$data);	

	}


	function hasil_kriteria(){
		$start = microtime(true);

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

			$batchchoose='6,7,8,9';

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


			//set query

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

			$datanilai=array();
			$dataetos=array();
			$datatradisi=array();
			$datatritertib=array();
			$dataatribut=array();

			$datacount=0;
			
			$tmpnilaitritertib=array();
			$tmpnilaiatribut=array();

			$query1=$this->db->get()->result();
			foreach($query1 as $q){
				//hitung nilai per kriteria per user
				$this->db->select('e.id as idevaluasi,e.peserta,AVG(j.nilai) AS nilai,j.soal,s.soal as kriteria,s.id as idsoal,s.jenis_evaluasi')
						 ->from('tb_jawaban AS j')
						 ->join('tb_evaluasi AS e','e.id = j.evaluasi','LEFT')
						 ->join('tb_soal AS s','s.id = j.soal','LEFT')
						 ->where('e.peserta',$q->userid)
						 ->where('j.is_aktif','aktif')
						 ->group_by('j.soal');
				$query2=$this->db->get()->result();
				foreach($query2 as $q2){
					$datacount++;
					switch($q2->jenis_evaluasi){
						case '1':
							$dataetos[$q2->soal][]=$q2->nilai;
							$dataetos2[$q2->kriteria][]=$q2->nilai;
						break;
						case '2':
							$datatradisi[$q2->soal][]=$q2->nilai;
							$datatradisi2[$q2->kriteria][]=$q2->nilai;
						break;
						case '3':
							$datatritertib[$q2->soal][]=$q2->nilai;
							$tmpnilaitritertib[$q2->kriteria][]=$q2->nilai;
							$datatritertib2[$q->komoditas][$q->jenis_asisten][$q2->kriteria][]=$q2->nilai;						
						break;
						case '4':
							$dataatribut[$q2->soal][]=$q2->nilai;
							$dataatribut2[$q->komoditas][$q->jenis_asisten][]=$q2->nilai;			
						break;
						case '5':
							$datakinerja[$q2->soal][]=$q2->nilai;
						break;
					}					
				}

				
			}
			
			$atributhasil="";
			$tatribut=0;
			$catribut=0;
			foreach($dataatribut2 as $key=>$val){
				foreach($val as $key2=>$val2){
					$atributhasil .= "<tr>";
					$atributhasil .= "<td>".$key."</td>";
					$atributhasil .= "<td>".$key2."</td>";
					$rata =round((array_sum($val2)/count((array)$val2))*100,2);
					$tatribut+=$rata;
					$catribut++;
					$atributhasil .= "<td>".$rata."</td>";
					$atributhasil .= "</tr>";
				}
				
			}	

			echo $atributhasil;
			/**/
			$end = microtime(true);

			$executionTime = $end - $start;

			/*
			foreach($datatritertib2 as $key=>$dt){
				echo $key." <br>";
				foreach($dt as $key2=>$val){
					echo $key2."<br>";
					foreach($val as $key3=>$val2){
						echo $key3;
						foreach($val2 as $key4=>$val3){
							echo $key4." : ";
							print_r($val3);
							echo "<br>";
						}
					}
					
				}
				echo "<hr>";
			}
			*/


			/*$detailetos=array();
			$tetos=0;
			$cetos=0;
			foreach($dataetos2 as $key=>$val){
				$rata=round(array_sum($val)/count((Array)$val),2)*100;
				$tetos+=$rata;
				$cetos++;
				$detailetos['detail'][$key]=$rata;
			}

			$detailetos['total']=round($tetos/$cetos,2);

			
			/*
			$sumetos=0;
			$countetos=0;
			$sumtradisi=0;
			$counttradisi=0;
			$sumtritertib=0;
			$counttritertib=0;
			$sumatribut=0;
			$countatribut=0;
			$sumkinerja=0;
			$countkinerja=0;

			//1. hitung etos
			foreach($dataetos as $key=>$de){
				$sumetos+=array_sum($de);
				$countetos+=count((array)$de);
			}		
			
			//2. hitung tradisi
			foreach($datatradisi as $key=>$dt){
				$sumtradisi+=array_sum($dt);
				$counttradisi+=count((array)$dt);
			}	

			//3. hitung tritertib
			foreach($datatritertib as $key=>$dtt){
				$sumtritertib+=array_sum($dtt);
				$counttritertib+=count((array)$dtt);
			}	

			//3. hitung atribut
			foreach($dataatribut as $key=>$da){
				$sumatribut+=array_sum($da);
				$countatribut+=count((array)$da);
			}	
			
			
			$rataetos=round($sumetos/$countetos,2)*100;
			$ratatradisi=round($sumtradisi/$counttradisi,2)*100;
			$ratatritertib=round($sumtritertib/$counttritertib,2)*100;
			$rataatribut=round($sumatribut/$countatribut,2)*100;

			$total=($rataetos+$ratatradisi+$ratatritertib+$rataatribut)/4;
			

			echo "Etos :".$rataetos."<br>";
			echo "tradisi :".$ratatritertib."<br>";
			echo "tritertib :".$ratatritertib."<br>";
			echo "atribut :".$rataatribut."<hr>";

			echo "<h3> TOTAL:".$total."</h3>";
			*/
		}
		else{
			redirect('Muka/logout');
		}
	}
	
}