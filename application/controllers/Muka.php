<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muka extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','user');
		$this->load->model('Alter_model','alter');
		$this->load->model('Master_model','master');
		$this->load->model('question_model','ask');
		$this->_init(); 
	}

	private function _init()
	{
	
	}

	public function index()
	{
		
		if(isset($_SESSION['logged_in'])){
			$stat=$_SESSION['logged_in']['status'];
			if(isonline()){
				switch($stat){
					case 'superadmin':
						redirect('dashboard');
					break;
					case 'admin':
						redirect('dashboard');
					break;
					case 'admin unit':
						redirect('dashboard');
					break;
					case 'user':
						redirect('userdashboard');
					break;
					default:
						$this->output->set_template('default');
						$this->load->view('page/muka');
					break;
					
				}
			}else{
				$this->output->set_template('default');
				$this->load->view('page/muka'); 
			}
		
			
		}else{
			
			$this->output->set_template('default');
			$this->load->view('page/muka'); 
		} 
	}

	function dashboard(){
		$this->output->set_template('dashboard');
	
	}
	function userdashboard(){
	
		if($_SESSION['logged_in']['status']!=""){
			$iduser=$this->encryption->decrypt($_SESSION['logged_in']['id']);
			if($_SESSION['logged_in']['status'] !="user"){
				logout();
			}else{
				$iduser=$this->encryption->decrypt($_SESSION['logged_in']['id']);
				///cek apakah data user sudah lengkap
				$wherecek=array("userid"=>$this->encryption->decrypt($_SESSION['logged_in']['id']));
				$ceksyarat=$this->user->ceksyarat($wherecek);
				
					$where=array('pe.userid'=>$iduser,'pp.is_aktif'=>'aktif');
					//detail atasan
					$atasan = atasan_list();
				
					$jatasan= count((array)atasan_list()) > 0 ? "1" :"0";
					if($jatasan > 0){
						foreach($atasan as $a){
							$wherep=array('p.userid'=>$a->leader);
							$atasan_detail[]=$this->user->getpeserta2($wherep);
						}
					}else{
						$atasan_detail=array();
					}

			
					///detail bawahan
					$bawahan=bawahan_list();
					$jbawahan= count((array)bawahan_list()) > 0 ? count((array)bawahan_list()) :"0";
					if($jbawahan > 0){
						foreach($bawahan as $b){
							$wherep=array('p.userid'=>$b->peserta);
							$bawahan_detail[]=$this->user->getpeserta2($wherep);
						}
					}else{
						$bawahan_detail=array();
					}

			
					//detail mitra
					$mitra = mitra_list();			
					$jmitra=count((array)mitra_list()) > 0 ? count((array)mitra_list()) :"0";
					if($jmitra > 0){
						foreach($mitra as $m){
							$wherep=array('p.userid'=>$m->mitra);
							$mitra_detail['peserta'][]=$this->user->getpeserta2($wherep);
							$idlogin=$this->encryption->decrypt($_SESSION['logged_in']['id']);
                            $param1=array("peserta"=>$idlogin,"penilai"=>$m->mitra,"evaluasi"=>"1","status"=>"final");
							$param2=array("peserta"=>$idlogin,"penilai"=>$m->mitra,"evaluasi"=>"2","status"=>"final");
							$param3=array("peserta"=>$idlogin,"penilai"=>$m->mitra,"evaluasi"=>"3","status"=>"final");
							$param4=array("peserta"=>$idlogin,"penilai"=>$m->mitra,"evaluasi"=>"4","status"=>"final");
							$cek1=$this->user->evaluasiCek($param1);
							$mitra_detail['1'][]=$cek1;
							$cek2=$this->user->evaluasiCek($param2);
							$mitra_detail['2'][]=$cek2;
							$cek3=$this->user->evaluasiCek($param3);
							$mitra_detail['3'][]=$cek1;
							$cek4=$this->user->evaluasiCek($param4);
							$mitra_detail['4'][]=$cek4;
                            //cek jika if mitra sudah selesai menilai
							
						}
					}else{
						$mitra_detail=array();
					}
					
					//cek sudah menilai berapa orang di tiap evaluasi
					$project=$this->alter->getjenisevaluasi();
					foreach ($project as $p){
						//cari di tabel evaluasi yang penilai adalah login dan evaluasi adalah $p->id
						$whereeval=array("e.jenis"=>$p->id,"e.penilai"=>$iduser);
						$dataeval=$this->alter->getevaluasi($whereeval);
					
						$data['progress'][$p->id]=array();
						foreach($dataeval as $de){
							if($de->status=="final"){
								$deval[$p->id]['selesai'][]=$de->id;
							}else{
								$deval[$p->id]['progress'][]=$de->id;
							}
							
						}
						
						$selesai=isset($deval[$p->id]['selesai'])? count((array)$deval[$p->id]['selesai']) : '0';
						$progress=isset($deval[$p->id]['progress'])? count((array)$deval[$p->id]['progress']) : '0';
						$jumlah=$selesai + $progress;
						$persen=($selesai==0)?"0":($selesai / $jumlah )*100;
						$data['progress'][$p->id]=array("selesai"=>$selesai,"progress"=>$progress,"jumlah"=>$jumlah,"persen"=>$persen);
					} 
					$jatasan= count((array)atasan_list()) > 0 ? count((array)atasan_list()) :"0";
					$totaltarget = $jbawahan+$jmitra;//+$jatasan;

					$data['project']=$project;
					$data['atasan']=$atasan_detail;
					$data['bawahan']=$bawahan_detail;
					$data['mitra']=$mitra_detail;
					$data['target']=array("total"=>$totaltarget,"atasan"=>$jatasan,"mitra"=>$jmitra,"bawahan"=>$jbawahan);
					
					$this->output->set_template('dashboard');
					$this->load->view('page/user_dash',$data);
				
			}	

		}else{
			logout();
		}
	
	}

	function adminunitdashboard(){
		if(isset($_SESSION['logged_in'])){
			$this->output->set_template('dashboard');
		}else{
			logout();
		}
	}

	function admindashboard(){
		if(isset($_SESSION['logged_in'])){

			if($_SESSION['logged_in']['status'] == 'admin' || $_SESSION['logged_in']['status'] == 'superadmin'){
				if(isset($_POST['perusahaan'])){
					$perusahaan=$_POST['perusahaan'];
				}else{
					$perusahaan='';
				}
			}else{
				$perusahaan=$_SESSION['logged_in']['perusahaan'];
			}
			$project=$this->alter->getjenisevaluasi();
			$dataNPStotal=$this->alter->NPSadminscore($perusahaan);
			$datakinerjatotal=$this->alter->tablescore($perusahaan);
			////// UNTUK TABEL
			// Jika ada $_POST
			
			$data['tableNPS']=$datakinerjatotal['nps'];
			$data['tablekinerja']=$datakinerjatotal['kin'];
			$data['npsnilai']=$dataNPStotal;
			$data['pos']=isset($_POST['perusahaan'])?$_POST['perusahaan']:"";
			$data['evaluasi']=$project;
			unset($_POST['perusahaan']);
			//$netos['etos']=$dataNPStotal['1']->nilai;

			
			$this->output->set_template('dashboard');
			$this->load->view('page/admin_dash',$data);
			
			/**/
		}else{
			logout();
		}
	
	}

	function eventEvaluasi(){
		$where=array('status'=>'aktif');
		$projectlist = $this->master->getproject($where);
		$data['project']=$projectlist;
		$this->output->set_template('dashboard');
		$this->load->view('page/event_page',$data);
			
	}

	function login(){
		if($_POST){
			if($this->user->masuksistem()){
				ini_set('date.timezone', 'Asia/Jakarta');
				$stat=$_SESSION['logged_in']['status'];
				$uid=$this->encryption->decrypt($_SESSION['logged_in']['id']);
				$addlog=array("user"=>$uid,"aktivitas"=>"login sistem","tglog"=>date('Y-m-d H:i:s'),"status"=>"berhasil");
				loggo($addlog);
				$this->db->where('id',$uid);
				$this->db->update('tb_user',array('isonline'=>1));
				switch($stat){
					case 'superadmin':
						redirect('dashboard');
					break;
					case 'admin':
						redirect('dashboard');
					break;
					case 'admin unit':
						redirect('adminunitdashboard');
					break;
					default:
						redirect('userdashboard');
					break;
					
				}
			}else{
				$this->session->set_flashdata('error','Login tidak dikenal');
				redirect('Muka');
			}
			
		}else{
				$this->session->set_flashdata('error','Input data tidak ada');
				redirect('Muka');
		}
		
	}

	function logout(){
		ini_set('date.timezone', 'Asia/Jakarta');
		$addlog=array("user"=>$this->encryption->decrypt($_SESSION['logged_in']['id']),"aktivitas"=>"keluar sistem","tglog"=>date('Y-m-d H:i:s'),"status"=>"berhasil");
		loggo($addlog);
		$uid=$this->encryption->decrypt($_SESSION['logged_in']['id']);
		$this->db->where('id',$uid);
		$this->db->update('tb_user',array('isonline'=>0));
		logout();
	} 

	function demografik(){
		//recalcbobot();
		//updatekinerja();
		$this->output->set_template('dashboard');
		$this->load->view('page/demografik');
	}

	function tes(){
		$batch = htmlspecialchars("6,7,8,9",ENT_QUOTES);
		$perusahaan ="3";
		$batchdraft=explode(",",$batch);
		$idtype='1';
		if($perusahaan =='semua'){
			if($batch!='all'){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
				$batchdraft=explode(",",htmlspecialchars($batch));
				$where_in="p.batch=".$batch;//$batchdraft;

			}else{
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
			}
			 
		}else{
			if($batch!='all'){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
				$batchdraft=explode(",",htmlspecialchars($batch));
				$where_in="p.batch=".$batch;//$batchdraft;
			}else{
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
			}
		}

		if(isset($where_in) && $where_in!=""){
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($filter)
			->where_in("p.batch",$batchdraft);
			//echo $where_in;
		}else{
			$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->join('tb_perusahaan as c','c.id=u.company')
			->where($filter)
			;
		}

		$query1=$this->db->get()->result();
		
		$disp=array();
		$data=array();


		foreach($query1 as $q){
			if($idtype!='5' && $idtype!='all'){
				$disp=array();
				$data=array();
	
				foreach($query1 as $q){
					$where2=array('status'=>'final','peserta'=>$q->userid,'jenis'=>$idtype);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where2);
					$query2=$this->db->get()->row();
					$nilai=$query2->nilai;
				
					if($nilai >=86){
						$data['tinggi'][]=round($nilai,2);
					}else if($nilai >= 66 && $nilai < 86){
						$data['cukup'][]=round($nilai,2);
					}else if($nilai >=46 && $nilai < 66){
						$data['sedang'][]=round($nilai,2);
					}else{
						$data['rendah'][]=round($nilai,2);
					}
				}
				$disp['hover']=array('#0071bc', '#2cb34c', '#ffc000','#e63928');
				$disp['color'] =array('#0076bc', '#2cb64c', '#ffc600','#e63628');
				$tinggi=isset($data['tinggi'])?count((array)$data['tinggi']):0;
				$cukup=isset($data['cukup'])?count((array)$data['cukup']):0;
				$sedang=isset($data['sedang'])?count((array)$data['sedang']):0;
				$rendah=isset($data['rendah'])?count((array)$data['rendah']):0;
				$disp['proporsi']=array($tinggi,$cukup,$sedang,$rendah);
				
			}else if($idtype=='all'){
				$disp=array();
				$data=array();
	
				foreach($query1 as $q){
					$where2=array('status'=>'final','peserta'=>$q->userid);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where2);
					$query2=$this->db->get()->row();
					$nilai=$query2->nilai;
				
					if($nilai >=91){
						$data['tinggi'][]=round($nilai,2);
					}else if($nilai > 80 && $nilai < 91){
						$data['cukup'][]=round($nilai,2);
					}else if($nilai >70 && $nilai < 81){
						$data['sedang'][]=round($nilai,2);
					}else if($nilai > 50 && $nilai < 71){
						$data['rendah'][]=round($nilai,2);
					}else{
						$data['srendah'][]=round($nilai,2);
					}
				}
				$disp['hover'] =array('#0076bc', '#2cb64c', '#ffc600','#e63628','#006000');
				$disp['color']=array('#0071bc', '#2cb34c', '#ffc000','#e63928','#000000');
				$tinggi=isset($data['tinggi'])?count((array)$data['tinggi']):0;
				$cukup=isset($data['cukup'])?count((array)$data['cukup']):0;
				$sedang=isset($data['sedang'])?count((array)$data['sedang']):0;
				$rendah=isset($data['rendah'])?count((array)$data['rendah']):0;
				$srendah=isset($data['srendah'])?count((array)$data['srendah']):0;
				
				$disp['proporsi']=array($tinggi,$cukup,$sedang,$rendah,$srendah);
			}else{
			
	
				foreach($query1 as $q){
					$where2=array('status'=>'final','peserta'=>$q->userid,'jenis'=>$idtype);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where2);
					$query2=$this->db->get()->row();
					$nilai=$query2->nilai;
				
					if($nilai >=91){
						$data['tinggi'][]=round($nilai,2);
					}else if($nilai > 80 && $nilai < 91){
						$data['cukup'][]=round($nilai,2);
					}else if($nilai >70 && $nilai < 81){
						$data['sedang'][]=round($nilai,2);
					}else if($nilai > 50 && $nilai < 71){
						$data['rendah'][]=round($nilai,2);
					}else{
						$data['srendah'][]=round($nilai,2);
					}
				}
				$disp['hover'] =array('#0076bc', '#2cb64c', '#ffc600','#e63628','#006000');
				$disp['color']=array('#0071bc', '#2cb34c', '#ffc000','#e63928','#000000');
				$tinggi=isset($data['tinggi'])?count((array)$data['tinggi']):0;
				$cukup=isset($data['cukup'])?count((array)$data['cukup']):0;
				$sedang=isset($data['sedang'])?count((array)$data['sedang']):0;
				$rendah=isset($data['rendah'])?count((array)$data['rendah']):0;
				$srendah=isset($data['srendah'])?count((array)$data['srendah']):0;
				
				$disp['proporsi']=array($tinggi,$cukup,$sedang,$rendah,$srendah);
				
			}
		}

		print_r($disp);
		exit;
			
	}
}
