<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Result extends CI_Controller {
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
		if(count((array)bawahan_list()) > 0){
			redirect('Result/npsbawahan');
			
		}else{
			redirect('Result/npsindividu');
		}
		
		
	}

	function npsindividu(){
		$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
		$jenis=$this->alter->getjenisevaluasi();
		$datadetail=array();
		
		///SCORE NPS
			foreach($jenis as $j){
				if($j->id != 5){
					$where=array("pe.userid"=>$id,"e.jenis"=>$j->id);
					$dataeval=$this->alter->getevaluasi($where);
					//$datadetail[$j->id][]=$dataeval;
					$adadata=count((Array)$dataeval);
				
					if($adadata == 0){
						 
					}else{
						$promoter=0;
						$passive=0;
						$detractor=0;
						foreach($dataeval as $d){
							$wherejawaban=array("evaluasi"=>$d->id);
							$r=hitungnps($this->ask->searchjawab2($wherejawaban));
							$datadetail[$j->id]['promoter'][]=$r['promoter'];
							$datadetail[$j->id]['passive'][]=$r['passive'];
							$datadetail[$j->id]['detractor'][]=$r['detractor'];	
							$datadetail[$j->id]['jawaban'][]=$r['statistik'];
							$datadetail[$j->id]['teval'][]=$d->id;

						}
				
						
						
					}
				}
			}
	
			/// NILAI KINERJA
			$where=array("pe.userid"=>$id,"e.jenis"=>"5");
			$datakinerja=$this->alter->getevaluasi($where);
			$adadata=count((Array)$datakinerja);
			$r2=array();
			if($adadata == 0){
			
			}else{
				$wherejawaban2=array("evaluasi"=>$datakinerja[0]->id);	
				$r2=$this->ask->searchjawab2($wherejawaban2);
			}
		
		$data['kinerja']=count((array)$r2) > 0 ?$r2:array();
		$data['d_name']="NPSindividu";
		$data['detail']=$datadetail;
		$data['jenis']=$jenis;

		$data['info']="Anda tidak memiliki bawahan untuk dinilai. Anda hanya dapat melihat score NPS anda sendiri";
		$this->output->set_template('dashboard');
		$this->load->view('page/result_page',$data);
	}

	function npsbawahan(){
		//get value dari tiap jenis
		$jenis=$this->alter->getjenisevaluasi();
		$isbos= count((array)bawahan_list()) > 0 ?true:false;
		$datadetail=array();
		
		foreach(bawahan_list() as $idb){
			foreach($jenis as $j){
				if($j->id != 5){
					$where=array("pe.userid"=>$idb->peserta,"e.jenis"=>$j->id,"e.status"=>"final");
					$dataeval=$this->alter->getevaluasi($where);
					//$datadetail[$j->id][]=$dataeval;
					$adadata=count((Array)$dataeval);
					if($adadata == 0){
						
					}else{
						$wherejawaban=array("evaluasi"=>$dataeval[0]->id);
						$r=hitungnps($this->ask->searchjawab2($wherejawaban));
						$datadetail[$j->id]['teval'][]=$dataeval[0]->id;
						$datadetail[$j->id]['objekdinilai'][]=$dataeval[0]->namapeserta;
						$datadetail[$j->id]['nilai'][]=$r['hasil'];
						$datadetail[$j->id]['jawaban'][]=$r['statistik'];
						$datadetail[$j->id]['promoter'][]=$r['promoter'];
						$datadetail[$j->id]['passive'][]=$r['passive'];
						$datadetail[$j->id]['detractor'][]=$r['detractor'];
						
					}
				}else{
					////data kinerja karyawan disini
					$where=array("e.jenis"=>"5","e.peserta"=>$idb->peserta,"e.status"=>"final");
					$datakinerja=$this->alter->getevaluasi($where);
					$adadata=count((Array)$datakinerja);
					$r2=array();
					if($adadata == 0){
					
					}else{
						foreach($datakinerja as $dk){
							$wherejawaban2=array("evaluasi"=>$datakinerja[0]->id);	
							$resu=$this->ask->searchjawab2($wherejawaban2);
							
							foreach($resu as $re){
								$rumus = $re->inisial;
								$r2[]=array("id"=>$re->id,"parameter"=>$re->soal,"rumus"=>$rumus,"jawaban"=>$re->jawaban,"nilai"=>$re->nilai);
							}

						}
						
					}
					
				}
			}
		}
		

		$data['d_name']="NPSbawahan";
		$data['detail']=$datadetail;
		$data['jenis']=$jenis;
		$data['kinerjadata']=$r2;
		$this->output->set_template('dashboard');
		$this->load->view('page/result_page',$data);
	}

	function pribadi(){
		$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
		$jenis=$this->alter->getjenisevaluasi();
		$datadetail=array();
		

		/////NILAI NPS
			foreach($jenis as $j){
				if($j->id != 5){
					$where=array("pe.userid"=>$id,"e.jenis"=>$j->id);
					$dataeval=$this->alter->getevaluasi($where);
					//$datadetail[$j->id][]=$dataeval;
					$adadata=count((Array)$dataeval);
					if($adadata == 0){
						
					}else{
						$wherejawaban=array("evaluasi"=>$dataeval[0]->id);
						$r=hitungnps($this->ask->searchjawab2($wherejawaban));
						$datadetail[$j->id]['teval'][]=$dataeval[0]->id;
						$datadetail[$j->id]['jawaban'][]=$r['statistik'];
						$datadetail[$j->id]['promoter'][]=$r['promoter'];
						$datadetail[$j->id]['passive'][]=$r['passive'];
						$datadetail[$j->id]['detractor'][]=$r['detractor'];
						
					}
				}

			}

		/// NILAI KINERJA
		
	
		$data['d_name']="NPSindividu"; 
		$data['detail']=$datadetail;
		$data['jenis']=$jenis;
		$data['info']="Anda tidak memiliki bawahan untuk dinilai. Anda hanya dapat melihat score NPS anda sendiri";
		$this->output->set_template('dashboard');
		$this->load->view('page/result_page',$data);	
	} 

	function datagraph(){
		
		$tipe=$this->encryption->decrypt($_GET['konten']);
		if($tipe =="NPSindividu"){
			$res=$this->datagraphindividu($_GET['eval']);
		}else if($tipe =="NPSbawahan"){
			$res=$this->datagraphbawahan($_GET['eval']);
		}else{
			for($i = 1 ; $i <=10 ;$i++){
				$res["labels"][]=$i;
				$res["datasets"][]=0;
			}
		}

		echo json_encode($res);
	}
 
	function datagraphbawahan($e=null){	
		
		$datagraph=array();
		$jbw=count((array)bawahan_list());
		$resarr=array();
		$e=$_GET['eval'];
		foreach(bawahan_list() as $idb){
			$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
			$where=array("pe.userid"=>$idb->peserta,"e.jenis"=>$e,'e.status'=>'final');
			$dataeval=$this->alter->getevaluasi($where);
			$adadata=count((Array)$dataeval);
			if($adadata > 0){
				foreach($dataeval as $de){
					$wherejawaban=array("evaluasi"=>$de->id);
					$dtjawab=$this->ask->searchjawab2($wherejawaban);
					$promoter=0;
					$passive=0;
					$detractor=0;
					foreach($dtjawab as $dj){
						
						if((int)$dj->nilai > 0){
							$resarr[$dj->soal]['promoter'][]=$dj->id;	
							$promoter++;
						}else if((int)$dj->nilai < 0){
							$resarr[$dj->soal]['detractor'][]=$dj->id;	
							$detractor++;
						}else{
							$resarr[$dj->soal]['passive'][]=$dj->id;	
							$passive++;
						}
					
					}
				}
				
			}else{

			}
		}
	
		$rdisp=array();
		foreach($resarr as $key=>$re){
			$rdisp['labels'][]=$key;
			//echo $key;
			$p=isset($re['promoter'])?count((array)$re['promoter']):0;
			$s=isset($re['passive'])?count((array)$re['passive']):0;
			$d=isset($re['detractor'])?count((array)$re['detractor']):0;
			$rdisp['label']=array('promoter','passive','detractor');
			$rdisp['datasets'][]=array((int)$p,(int)$s,(int)$d);
			
		}
		$res=$rdisp;
		//print_r($res);
		echo json_encode($res);
	}


	function datagraphindividu($e=null){	
		$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
		$datagraph=array();

		$where=array("pe.userid"=>$id,"e.jenis"=>$e,'e.status'=>'final');
		$dataeval=$this->alter->getevaluasi($where);
		$adadata=count((Array)$dataeval);
			if($adadata == 0){
						
			}else{
				$wherejawaban=array("evaluasi"=>$dataeval[0]->id);
				$r=hitungnps($this->ask->searchjawab2($wherejawaban));
				$datagraph[$dataeval[0]->id]=$r;
			}

		//atur array 
		$data=array();
		$jdata=count((array)$datagraph);
			if($jdata > 0){
				foreach($datagraph as $disp){
					for($i = 1 ; $i <=10 ;$i++){
						$data[$i][]=isset($disp["statistik"][$i])?count((array)$disp["statistik"][$i]):'0';
					}
				}
				foreach($data as $key=>$stat){
					$res["labels"][]=$key;
					$res["datasets"][]=array_sum($stat);	
				}
				$res["stat"]="ok";
			}else{
				for($i = 1 ; $i <=10 ;$i++){
					$res["labels"][]=$i;
					$res["datasets"][]=0;	
				}
				$res["stat"]="none";
				
			}			
		return $res;
	} 


	function dataproporsi(){
		$idtype=$_GET['eval'];
		if($_SESSION['logged_in']['perusahaan'] == "all"){
			$where1=array("e.evaluasi"=>$idtype,"e.status"=>"final");
		}else{
			$where1=array("e.evaluasi"=>$idtype,"e.status"=>"final",'pe.perusahaan'=>$_SESSION['logged_in']['perusahaan']);
		}
		
		$dataeval=$this->alter->getevaluasi($where1);
		$adadata=count((Array)$dataeval);
		$data=array();
		if($adadata > 0){
			foreach ($dataeval as $de){
				$wherejawaban=array("evaluasi"=>$de->id);
				$r=hitungnps($this->ask->searchjawab2($wherejawaban));
				$npsvalue= calcNPS($r['promoter'],$r['passive'],$r['detractor']) > 0 ? calcNPS($r['promoter'],$r['passive'],$r['detractor']) : 0;
				
				if($npsvalue >=75){
					$data['tinggi'][]=$de->id;
				}else if($npsvalue > 50 && $npsvalue < 75){
					$data['sedang'][]=$de->id;
				}else if($npsvalue > 25 && $npsvalue < 50){
					$data['rendah'][]=$de->id;
				}else if($npsvalue > 1 && $de->id < 25){
					$data['sangat rendah'][]=$de->id;
				}else{
					$data['tidak dapat diterima'][]=$npsvalue;
				}

				$data['nps'][]=$npsvalue;
				$data['evaluasi'][]=$de->id;
			}
		}else{
		}

		$tinggi=isset($data['tinggi'])? count((array)$data['tinggi']):0;
		$sedang=isset($data['sedang'])? count((array)$data['sedang']):0;
		$rendah=isset($data['rendah'])? count((array)$data['rendah']):0;
		$sangatrendah=isset($data['sangat rendah'])? count((array)$data['sangat rendah']):0;
		$tdd=isset($data['tidak dapat diterima'])? count((array)$data['tidak dapat diterima']):0;


		$data['label']=array('tinggi','sedang','rendah','sangat rendah','tidak dapat diterima');
		$data['proporsi']=array($tinggi,$sedang,$rendah,$sangatrendah,$tdd);
		$res=$data;
		echo json_encode($res);
	}

	function datanps(){
		$data=array();
		$where=array('e.status'=>'final');
		$listcompany=perusahaan();
		
		$perusahaan=$_GET['company'];
		$eval=$_GET['je'];
		$data=array();

		if($perusahaan == ''){
			$where1=array("e.evaluasi"=>$eval,"e.status"=>"final");
		}else{
			$where1=array("e.evaluasi"=>$eval,"pe.perusahaan"=>$perusahaan,"e.status"=>"final");
		}
		$dtevaluasi=$this->alter->getevaluasi($where1);


		foreach($dtevaluasi as $d){
		
			$wherejawaban=array("evaluasi"=>$d->id);
            $r=hitungnps($this->ask->searchjawab2($wherejawaban));
			$data[$d->ncompany]['hasil'][]=$r['hasil'];
		}

		$display=array();
		foreach($data as $key=>$disp){
			$display['label'][]=$key;
			$display['detail'][]=$disp['hasil'];
			$display['sumnps'][]=array_sum($disp['hasil'])/count((array)$disp['hasil']);
		}

	
		$res=$display;
		echo json_encode($res);
	}

	function datagraphindividu2($e=null){
		$id=$this->encryption->decrypt($_SESSION["logged_in"]["id"]);
		$datagraph=array();
		$e=$_GET['eval'];
		//$e='1';
		$getusr=$this->user->searchpeserta2(array("u.id"=>$id));
		////daftar soal
		switch($e){
			case '1':
				$lsoal=$this->ask->listsoalwhere(array("jenis_evaluasi"=>$e));
			break;
			case '2':
				$wheresoal=array("jenis_evaluasi"=>$e,"jenis_asisten"=>$getusr[0]->jenis_asisten);
				$lsoal=$this->ask->listsoalwhere($wheresoal);
			break;
			case '3':
				$wheresoal=array("jenis_evaluasi"=>$e,"jenis_asisten"=>$getusr[0]->jenis_asisten,"komoditas"=>$getusr[0]->komoditas,"unit_kerja"=>$getusr[0]->unitkerja);
				$lsoal=$this->ask->listsoalwhere($wheresoal);
			break;
			case '4':
				$wheresoal=array("jenis_evaluasi"=>$e,"jenis_asisten"=>$getusr[0]->jenis_asisten,"komoditas"=>$getusr[0]->komoditas,"unit_kerja"=>$getusr[0]->unitkerja);
				$lsoal=$this->ask->listsoalwhere($wheresoal);
			break;
		}
	
		//print_r($lsoal);
		//$where=array("pe.userid"=>$id,"e.jenis"=>$e,'e.status'=>'final');
		$where=array("pe.userid"=>$id,"e.jenis"=>$e,'e.status'=>'final');
		$dataeval=$this->alter->getevaluasi($where);
		$adadata=count((Array)$dataeval);
		$resarr=array();
			if($adadata == 0){
						
			}else{
				
				foreach($dataeval as $de){
					$wherejawaban=array("evaluasi"=>$de->id);
					$dtjawab=$this->ask->searchjawab2($wherejawaban);
					$promoter=0;
					$passive=0;
					$detractor=0;
					foreach($dtjawab as $dj){
						
						if((int)$dj->nilai > 0){
							$resarr[$dj->soal]['promoter'][]=$dj->id;	
							$promoter++;
						}else if((int)$dj->nilai < 0){
							$resarr[$dj->soal]['detractor'][]=$dj->id;	
							$detractor++;
						}else{
							$resarr[$dj->soal]['passive'][]=$dj->id;	
							$passive++;
						}
					
					}
					
				
				}
				
			}
			//print_r($resarr);
			$rdisp=array();
			foreach($resarr as $key=>$re){
				$rdisp['labels'][]=$key;
				//echo $key;
				$p=isset($re['promoter'])?count((array)$re['promoter']):0;
				$s=isset($re['passive'])?count((array)$re['passive']):0;
				$d=isset($re['detractor'])?count((array)$re['detractor']):0;
				$rdisp['label']=array('promoter','passive','detractor');
				$rdisp['datasets'][]=array((int)$p,(int)$s,(int)$d);
			}
			$res=$rdisp;
			echo json_encode($res);
	}

	function detailobjek(){
		$idval=$_GET['eval'];
		$wherejawaban=array("evaluasi"=>$idval);
		$user=$this->alter->getevaluasi(array('e.id'=>$idval));
		$r=hitungnps($this->ask->searchjawab2($wherejawaban));
		$res['nilai']=$r;
		$res['objek']=$user[0]->namapeserta;
		echo json_encode($res);
	}


	function kalkulasidetail(){	
		/// KINERJA BOBOT
		//recalcbobot();
		//updatekinerja();
		///blok dulu, sampai launching
		if($_SESSION['logged_in']['status']!="superadmin"){
			redirect('Muka/logout');
		}
		if($_SESSION['logged_in']['status']=="admin unit"){
			$where=array('u.isaktif'=>'1','status_peserta'=>'peserta','company'=>$_SESSION['logged_in']['perusahaan']);
		}else{
			$where=array('u.isaktif'=>'1','status_peserta'=>'peserta');
		}
		
		$datacek=array();
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($where);
		$query1=$this->db->get()->result();

		///
		$dnilai=array();
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

			$npstotal=($etos+$tradisi+$tritertib+$atribut)/4;
			$npsgabungan=($npstotal+$kinerja)/2;
			$npssmkbk=($npstotal+$smkbk2021)/2;
			$npsbobot=$npstotal * 0.75;
			$kinbobot=$smkbk2021 * 0.25;
			$nilaibobot=round(($npsbobot+$kinbobot),2);
			//display hasil
			$dnilai[]=array("iduser"=>$q->userid,
							"nopeg"=>$q->nopeg,
							"nama"=>$q->nama,
							"perusahaan"=>$q->perusahaan,
							"unitkerja"=>$q->unitusaha,
							"asisten"=>$q->jenis_asisten,
							"komoditas"=>$q->komoditas,
							'batch'=>$q->batch,
							"etos"=>$etos,
							"tradisi"=>$tradisi,
							"tritertib"=>$tritertib,
							"atribut"=>$atribut,
							"nps"=>$npstotal,
							"kinerja"=>$kinerja,
							"kinerja2021"=>$kinerja2021,
							"kinerjasmkbk"=>$smkbk2021,
							"skorgabungan"=>$npsgabungan,
							"skorgabungan2"=>$npssmkbk,
							"nilaibobot"=>$nilaibobot);
				/**/	/*		/**/
		}
			$data['npsnonkinerja']=$dnilai;
		 	$this->output->set_template('dashboard');
			$this->load->view('page/kalkulasi_data',$data);
	}

	function cekpengisian(){
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
		$datacek=array();
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				 ->from('tb_peserta as p')
				 ->join('tb_user as u','u.id=p.userid')
				 ->join('tb_perusahaan as c','c.id=u.company')
				 ->where($where);
		$query1=$this->db->get()->result();
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
			
		}
			$data['cek']=$datamentah;
			$data['rekap']=$datarekap;
			$this->output->set_template('dashboard');
			$this->load->view('page/cek_pengisian',$data);

	}
	
	function getdetail(){
		$token=$_GET['token'];
		$where=array('u.isaktif'=>'1','nopeg'=>$token);
		$datacek=array();
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($where);
		
		$query1=$this->db->get()->row();
		$dnilai=array();
		
			///rerata nilai etos individu
			$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>1);
			$etos=$this->alter->getdetailnps($where2);

			//tradisi
			$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>2);
			$tradisi=$this->alter->getdetailnps($where2);
			
			//tri tertib
			$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>3);
			$tritertib=$this->alter->getdetailnps($where2);

			//atribut
			$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>4);
			$atribut=$this->alter->getdetailnps($where2);

			//kinerja
			//$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>5,'tahun !='=>'NULL','tahun'=>'2022');
			$where2=array('e.status'=>'final','e.peserta'=>$query1->userid,'jenis'=>5,'tahun !='=>'NULL');
			$kinerja=$this->alter->getdetailkinerja($where2);
			$skor=0;
			$dtkin=array();
			$dtcalc=array();
			$dtperbulan=array();
			foreach($kinerja as $k){
				$dataraw=explode(";",$k->jawaban);
				$target=$dataraw[0];
				$real=$dataraw[1];
				$skor=$k->bobot;
				$dtperbulan[$k->bulan][$k->soal][]=array("tahun"=>$k->tahun,
															 "formula"=>$k->inisial,
															 "target"=>$target,
															 "realisasi"=>$real,
															 "nilai"=>round($skor,2));
					//$dtperbulan['data'][]=array("soal"=>$k->soal,"tahun"=>$k->tahun,"target"=>$target,"realisasi"=>$real,"skor"=>$skor);
			}
			$dtkin[]=array("nopeg"=>$query1->nopeg,"data"=>$dtperbulan);

			$dnilai=array(
							"iduser"=>$query1->userid,
							"nopeg"=>$query1->nopeg,
							"nama"=>$query1->nama,
							"perusahaan"=>$query1->perusahaan,
							"unitkerja"=>$query1->unitusaha,
							"asisten"=>$query1->jenis_asisten,
							"komoditas"=>$query1->komoditas,
							'batch'=>$query1->batch,
							"etos"=>$etos,
							"tradisi"=>$tradisi,
							"tritertib"=>$tritertib,
							"atribut"=>$atribut,
							"kinerja"=>$dtkin);
		

		echo json_encode($dnilai);

	}

	function demografik(){
	
		if(!isset($_GET)){
			$kategori='';
			if($_SESSION['logged_in']['status']=="admin unit"){
				$entitas=$_SESSION['logged_in']['perusahaan'];
			}else{
				$entitas='semua';	
			}
			$batch='semua';
		}else{
			$kategori=$_GET['kategori'];
			$entitas=$_GET['entitas'];
			$batch=$_GET['batch'];
		} 
		$label=array();
		$data=array();

		if($entitas=='semua'){
			$this->db->select('kode,id')
					 ->from('tb_perusahaan')
					 ->where('is_aktif','aktif')
					 ->order_by('id');
			$query=$this->db->get()->result();
			foreach($query as $q){
				$label[]=$q->kode;
				//dapatkan nilai dari tiap entitas
				if($batch != 'semua'){
					$batchdraft=explode(",",htmlspecialchars($batch));
					$where_in="p.batch=".$batch;//$batchdraft;
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$q->id);
				
				}else{
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$q->id);
				}
				
				if(isset($where_in) && count((array)$where_in) > 0){
					$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
					->from('tb_peserta as p')
					->join('tb_user as u','u.id=p.userid')
					->join('tb_perusahaan as c','c.id=u.company')
					->where($filter)
					->where_in("p.batch",$batchdraft);
				}else{
					$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
					->from('tb_peserta as p')
					->join('tb_user as u','u.id=p.userid')
					->join('tb_perusahaan as c','c.id=u.company')
					->where($filter);
				}
				
				$query1=$this->db->get()->result();
				$sumetos=0;
				$countpeserta=count((array)$query1);
				$sumtradisi=0;
				$sumtritertib=0;
				$sumkinerja=0;
				$sumatribut=0;
			
				foreach($query1 as $q1){

					///etos
					$where2=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>1);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where2);
					$query2=$this->db->get()->row();
					$sumetos +=$query2->nilai;	
					
					///tradisi
					$where3=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>2);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where3);
					$query3=$this->db->get()->row();
					$sumtradisi +=$query3->nilai;	
					

					///tritertib
					$where4=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>3);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where4);
					$query4=$this->db->get()->row();
					$sumtritertib +=$query4->nilai;

					///atribut
					$where5=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>4);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where5);
					$query5=$this->db->get()->row();
					$sumatribut +=$query5->nilai;

					///kinerja
					$where6=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>5);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where6);
					$query6=$this->db->get()->row();
					$sumkinerja +=$query6->nilai;
				}
				$etos=round(($sumetos/$countpeserta),2);
				$tradisi=round(($sumtradisi/$countpeserta),2);
				$tritertib=round(($sumtritertib/$countpeserta),2);
				$atribut=round(($sumatribut/$countpeserta),2);
				$kinerja=round(($sumkinerja/$countpeserta),2);
				$data['etos'][]=$etos;
				$data['tradisi'][]=$tradisi;
				$data['tritertib'][]=$tritertib;
				$data['atribut'][]=$atribut;
				$data['kinerja'][]=$kinerja;			
			}
		}else{
			$wheref=array('u.isaktif'=>'1','u.company'=>$entitas,'p.status_peserta'=>'peserta');
				switch($kategori){
					case 'komoditas':
						$this->db->select('distinct(p.komoditas) as uker')
						->from('tb_peserta as p')
						->join('tb_user as u','u.id=p.userid')
						->where($wheref)
						->order_by('p.unitusaha');
					break;
					case 'asisten':
						$this->db->select('distinct(p.jenis_asisten) as uker')
						->from('tb_peserta as p')
						->join('tb_user as u','u.id=p.userid')
						->where($wheref)
						->order_by('p.unitusaha');
					break;
					default:
						$this->db->select('distinct(p.unitusaha) as uker')
						->from('tb_peserta as p')
						->join('tb_user as u','u.id=p.userid')
						->where($wheref)
						->order_by('p.unitusaha');
					break;

				}
			$query=$this->db->get()->result();
			foreach($query as $q){
				$label[]=$q->uker;
				//dapatkan nilai dari tiap entitas
			
				switch($kategori){
					case 'komoditas':
						if($batch != 'semua'){
							$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$entitas,'p.batch'=>$batch,'p.komoditas'=>$q->uker);
						}else{
							$filter=array('u.isaktif'=>'1','p.komoditas'=>$q->uker,'u.company'=>$entitas,'p.status_peserta'=>'peserta');
						}
						
					break;
					case 'asisten':
						if($batch != 'semua'){
							$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$entitas,'p.batch'=>$batch,'p.jenis_asisten'=>$q->uker);
						}else{
							$filter=array('u.isaktif'=>'1','p.jenis_asisten'=>$q->uker,'u.company'=>$entitas,'p.status_peserta'=>'peserta');
						}
					
					break;
					default:
					if($batch != 'all'){
						$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$entitas,'p.batch'=>$batch,'p.unitusaha'=>$q->uker);
					}else{
						$filter=array('u.isaktif'=>'1','p.unitusaha'=>$q->uker,'u.company'=>$entitas,'p.status_peserta'=>'peserta');
					}
				
					break;
				}
				
				$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($filter);
				
				$query1=$this->db->get()->result();
				//print_r($query1);
				$sumetos=0;
				$countpeserta=count((array)$query1);
				$sumtradisi=0;
				$sumtritertib=0;
				$sumkinerja=0;
				$sumatribut=0;
				foreach($query1 as $q1){
					
					///etos
					$where2=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>1);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where2);
					$query2=$this->db->get()->row();
					//echo $this->db->last_query();
					$sumetos +=$query2->nilai;	
				
				
					
					///tradisi
					$where3=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>2);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where3);
					$query3=$this->db->get()->row();
					$sumtradisi +=$query3->nilai;	
					

					///tritertib
					$where4=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>3);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where4);
					$query4=$this->db->get()->row();
					$sumtritertib +=$query4->nilai;

					///atribut
					$where5=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>4);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where5);
					$query5=$this->db->get()->row();
					$sumatribut +=$query5->nilai;

					///kinerja
					$where6=array('status'=>'final','peserta'=>$q1->userid,'jenis'=>5);
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where6);
					$query6=$this->db->get()->row();
					$sumkinerja +=$query6->nilai;
					/**/

				}

			//	echo $countpeserta;

			$etos=$sumetos>0?round(($sumetos/$countpeserta),2):0;
			$tradisi=$sumtradisi>0?round(($sumtradisi/$countpeserta),2):0;
			$tritertib=$sumtritertib>0? round(($sumtritertib/$countpeserta),2):0;
			$atribut=$sumatribut>0?round(($sumatribut/$countpeserta),2):0;
			$kinerja=$sumkinerja>0?round(($sumkinerja/$countpeserta),2):0;
			$data['etos'][]=$etos;
			$data['tradisi'][]=$tradisi;
			$data['tritertib'][]=$tritertib;
			$data['atribut'][]=$atribut;
			$data['kinerja'][]=$kinerja;	
				/**/

			
			}/**/
		}

		$res['label']=$label;
		$res['data']=$data;
		$data['kondisi']=$_GET;

		echo json_encode($res);
	}
 

	function proporsinilai(){
	
		
			$idtype=$_GET['eval'];
			$perusahaan=$_GET['company'];
			$batch=$_GET['batch'];
	
			$where_in="semua";
			if($perusahaan =='semua'){
				if($batch!='semua' || $batch!=''){
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
					$batchdraft=explode(",",htmlspecialchars($batch,ENT_QUOTES));
					$where_in=$batch;//$batchdraft;
	
				}else{
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
				}
				 
			}else{
				if($batch!='semua' || $batch!=''){
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
					$batchdraft=explode(",",htmlspecialchars($batch,ENT_QUOTES));
					$where_in=$batch;//$batchdraft;
				}else{
					$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
				}
			}
	
	
			if(isset($where_in) && $where_in!="semua"){
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

			$jdataload=count(($query1));

			$syntax=$this->db->last_query();

			$disp['sintaks'][]=$this->db->last_query();
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
				$disp=array();
				$data=array();
	
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
					
			switch($idtype){
				case '1':
					$disp['label']=array('tinggi','cukup','rendah','sangat rendah');
				break;
				case '2':
					$disp['label']=array('Menjalankan dan menghayati','Menjalankan','Tidak konsisten menjalankan','Tidak Menjalankan');
				break;
				case '3':
					$disp['label']=array('Tertib','Cukup Tertib','Kurang Tertib','Tidak Tertib');
				break;
				case '4':
					$disp['label']=array('Berdisiplin Tinggi','Cukup Berdisiplin','Berdisiplin','Berdisiplin Sangat Rendah');
				break;
				case '5':
					$disp['label']=array('tinggi','cukup','sedang','rendah','sangat rendah');
				break;
				case 'all':
					$disp['label']=array('Planters Role Model','Good Planters','Mediocore Planters','Distracted Planters','Dissident');
				break;
				
			}	

			/**/
			$disp['kondisi']=$_GET;
			$disp['count data']=$jdataload;
			$disp['syntax']=$syntax;
			$disp['where']=$batchdraft;
		
			$res=$disp;
			echo json_encode($res);
	}

	function cekdetailpengisian(){
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
				$entitaschoose=isset($_POST['entitas']) && $_POST['entitas']!=""?$_POST['entitas']:"all";
			}else{
				$entitaschoose=$_SESSION['logged_in']['perusahaan'];
			}
			
		}

		if($entitaschoose=="all"){
			if($batchchoose =="all"){
				$where=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
			}else{
				$where=array('u.isaktif'=>'1','p.batch'=>$batchchoose,'p.status_peserta'=>'peserta');
			}
		}else{
			if($batchchoose =="all"){
				$where=array('u.isaktif'=>'1','u.company'=>$entitaschoose,'p.status_peserta'=>'peserta');
			}else{
				$where=array('u.isaktif'=>'1','u.company'=>$entitaschoose,'p.batch'=>$batchchoose,'p.status_peserta'=>'peserta');
			}
		}

	
		
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($where);
		
		$query1=$this->db->get()->result();
		$syn=$this->db->last_query();
		$datauser=array();
		foreach($query1 as $q){
			
			$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid,"m.status"=>"aktif"));
			$jatasan=count((Array)$atasan);
		
			
			$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid,"m.status"=>"aktif"));
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
				//echo "user :".$q->userid."  nama mitra:".$m->koneksi." evaluasi : ".$jtotal."<br>";
				}

			}else{
				$mitraid="-";
			}
			//cek penilaian dari atasan
			$jatah_evaluasi=($jatasan*4)+($jmitra*4);
		//	echo $q->nopeg."/".$q->userid." - ".$jatah_evaluasi." jumlah atasan :".$jatasan." jumlah mitra :".$jmitra;
		//	echo "<br>";
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"perusahaan"=>$q->kdc,"unit"=>$q->unitusaha,"nopeg"=>$q->nopeg,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);
			
		}
		$data['postentitas']=$entitaschoose;
		$data['postbatch']=$batchchoose;
		$data['detail']=$datauser;
		$data['syn']=$syn;
		$this->output->set_template('dashboard');
		$this->load->view('page/cek_pengisian_detail',$data);
	}

	function proporsinilai_BC(){
	
		if(isset($_GET)){
			$idtype=$_GET['eval'];
			$perusahaan=$_GET['company'];
			$batch=$_GET['batch'];
		}else{
			$idtype=$_GET['eval'];
			$perusahaan='semua';
			$batch='semua';
		}
		
		if($perusahaan =='semua'){
			if($batch!='semua'){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','p.batch'=>$batch);
			}else{
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
			}
			
		}else{
			if($batch!='semua'){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan,'p.batch'=>$batch);
			}else{
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
			}
			
		}
		
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($filter);
		$query1=$this->db->get()->result();
		$data['sintaks'][]=$batch;//$this->db->last_query();
		foreach($query1 as $q){
			///etos
			$where2=array('status'=>'final','peserta'=>$q->userid,'jenis'=>$idtype);
			$this->db->select ('avg(nilai) as nilai')
					->from('tb_evaluasi')
					->where($where2);
			$query2=$this->db->get()->row();
			//echo $this->db->last_query();
			$nilai=isset($query2->nilai)?round($query2->nilai,2):0;
			if($nilai >=91){
				$data['tinggi'][]=round($nilai,2);
			}else if($nilai > 80 && $nilai < 91){
				$data['cukup'][]=round($nilai,2);
			}else if($nilai >70 && $nilai < 81){
				$data['sedang'][]=round($nilai,2);
			}else if($nilai > 50 && $nilai < 71){
				$data['rendah'][]=round($nilai,2);
			}else{
				$data['sangat rendah'][]=round($nilai,2);
			}
		
		}
		
		$tinggi=isset($data['tinggi'])? count((array)$data['tinggi']):0;
		$sedang=isset($data['cukup'])? count((array)$data['cukup']):0;
		$rendah=isset($data['sedang'])? count((array)$data['sedang']):0;
		$sangatrendah=isset($data['rendah'])? count((array)$data['rendah']):0;
		$tdd=isset($data['sangat rendah'])? count((array)$data['sangat rendah']):0;


		$data['label']=array('tinggi','cukup','sedang','rendah','sangat rendah');
		$data['proporsi']=array($tinggi,$sedang,$rendah,$sangatrendah,$tdd);
		$res=$data;
		echo json_encode($res);
	} 

	function cekpengisian_penilai(){

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
				$entitaschoose=isset($_POST['entitas'])&&$_POST['entitas']!=""?$_POST['entitas']:"all";
			}else{
				$entitaschoose=$_SESSION['logged_in']['perusahaan'];
			}
			
		}

		if($entitaschoose=="all"){
			if($batchchoose =="all"){
				$where=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
			}else{
				$where=array('u.isaktif'=>'1','p.batch'=>$batchchoose,'p.status_peserta'=>'peserta');
			}
		}else{
			if($batchchoose =="all"){
				$where=array('u.isaktif'=>'1','u.company'=>$entitaschoose,'p.status_peserta'=>'peserta');
			}else{
				$where=array('u.isaktif'=>'1','u.company'=>$entitaschoose,'p.batch'=>$batchchoose,'p.status_peserta'=>'peserta');
			}
		}


		/*if($_SESSION['logged_in']['status'] == 'superadmin'){
			$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
		}else{
			if(isset($_SESSION['logged_in']['perusahaan'])){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','c.id'=>$_SESSION['logged_in']['perusahaan']);
			}else{
				logout();
			}
		}*/

		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($where);
		$query1=$this->db->get()->result();
		$datacekisi=array();
		foreach($query1 as $q){
			$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid,"status"=>'aktif'));
			$jatasan=count((Array)$atasan);
			$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid,"status"=>'aktif'));
			$jmitra=count((Array)$mitra);
			$stat="";
			
			//// ATASAN
			if($jatasan > 0){
				foreach($atasan as $a){
					$atasanid=$atasan[0]->idkoneksi;
				
					//penilaian NPS
					$wherea=array('peserta'=>$q->userid,"penilai"=>$a->idkoneksi,"status"=>'final');
					$this->db->select('count(id) as jumlah')
							 ->from('tb_evaluasi')
							 ->where($wherea);
					$querynps=$this->db->get()->result();
					///jumlah kinerja dibuat
					$wherea=array('peserta'=>$q->userid,"evaluasi"=>"5","status"=>'final');
					$this->db->select('count(id) as jumlah')
							 ->from('tb_evaluasi')
							 ->where($wherea);
					$queryjumlahkinerja=$this->db->get()->result();
					$wherea=array('peserta'=>$q->userid,"catatan_dari"=>$a->idkoneksi,"status"=>'final');
					$this->db->select('count(id) as jumlah')
							 ->from('tb_evaluasi')
							 ->where($wherea);
					$querykinerja=$this->db->get()->result();
					$stat="atasan";
					
				$approval=$querykinerja[0]->jumlah." dari ".$queryjumlahkinerja[0]->jumlah;
				$datacekisi[]=array("nikpenilai"=>$a->nikatasan,
									"nmpenilai"=>$a->koneksi,
									"nikdinilai"=>$q->nopeg,
									"nmdinilai"=>$q->nama,
									"perusahaan"=>$q->perusahaan,
									"unit"=>$q->unitusaha,
									"batch"=>$q->batch,
									"statuspenilai"=>$stat,
									"nps"=>$querynps[0]->jumlah,
									"approval"=>$approval);
					

				}
				
			}


			///MITRA
			if($jmitra > 0){
				$stat="mitra";
				foreach($mitra as $m){
					$mitraid=$m->idkoneksi;
					//penilaian NPS
					$wherea=array('peserta'=>$q->userid,"penilai"=>$m->idkoneksi,"status"=>'final');
					$this->db->select('count(id) as jumlah')
							->from('tb_evaluasi')
							->where($wherea);
					$querynps=$this->db->get()->result();
				
					$approval="-";
					$datacekisi[]=array("nikpenilai"=>$m->nikmitra,
									"nmpenilai"=>$m->koneksi,
									"nikdinilai"=>$q->nopeg,
									"nmdinilai"=>$q->nama,
									"perusahaan"=>$q->perusahaan,
									"unit"=>$q->unitusaha,
									"batch"=>$q->batch,
									"statuspenilai"=>$stat,
									"nps"=>$querynps[0]->jumlah,
									"approval"=>$approval);
				}
			} 
			
		}
		$data['postentitas']=$entitaschoose;
		$data['postbatch']=$batchchoose;
		$data['progress']=$datacekisi;
		$this->output->set_template('dashboard');
		$this->load->view('page/progrespengisianpenilai',$data);
	}

	function komparasismkbk2021(){
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
		$datago=array();
		foreach($query1 as $q){
			$this->db->select('*')
					 ->from('tb_komparasi_kinerja')
					 ->where('userid',$q->userid);
			$dkomp=$this->db->get()->row();
			$smkbk=isset($dkomp->smkbk2021)?$dkomp->smkbk2021:0;
			$kinerja2022=isset($dkomp->kinerja2022)?$dkomp->kinerja2022:0;
			$kinerja2023=isset($dkomp->kinerja2023)?$dkomp->kinerja2023:0;
			$datago[]=array("nopeg"=>$q->nopeg,
							 "nama"=>$q->nama,
							 "perusahaan"=>$q->perusahaan,
							 "unitusaha"=>$q->unitusaha,
							 "komoditas"=>$q->komoditas,
							 "batch"=>$q->batch,
							 "n2021"=>$smkbk,
							 "n2022"=>$kinerja2022,
							 "n2023"=>$kinerja2023
							 );
		}
		$data['kinerja']=$datago; 
		$this->output->set_template('dashboard');
		$this->load->view('page/komparasismkbk',$data);
	}


	/*
		** fungsi kalkulasi nilai berdasrkan kriteria
		*** bisa pilih kalkulasi per batch, jika tidak ada maka kalkulasi semua batch
		*** filter batch menggunakan IN 
		*** data lama akan dinonaktifkan
		## authir : KDW
		## Date   : 10.12.2023
	*/
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
			if(!isset($_POST['entitas']) || count((array)$_POST) <=0){
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
					$entitaschoose=$_POST['entitas'];
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
			$datakinerja=array();
			$datacount=0;

			$tmpnilaitradisi=array();
			$tmpnilaiatribut=array();
			$total=0;
			
			$query1=$this->db->get()->result();
			foreach($query1 as $q){
				//hitung nilai per kriteria
				$this->db->select('e.id as idevaluasi,e.peserta,AVG(j.nilai) AS nilai,j.soal,s.soal as kriteria,s.id as idsoal,s.jenis_evaluasi')
						 ->from('tb_jawaban AS j')
						 ->join('tb_evaluasi AS e','e.id = j.evaluasi','LEFT')
						 ->join('tb_soal AS s','s.id = j.soal','LEFT')
						 ->where('e.peserta',$q->userid)
						 ->where('j.is_aktif','aktif')
						 ->group_by('j.soal');
				$query2=$this->db->get()->result();

				//kriteria 1-4
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
							$tmpnilaitradisi[$q2->kriteria]=$q2->nilai;
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

				//5.kinerja
				$qkinerja=$this->db->select('*')
						->from('tb_komparasi_kinerja')
						->where('userid',$q->userid);
				$dkinerja=$this->db->get()->result();
				
				//rerata
				
				$s2023=0;
				foreach($dkinerja as $dk23){
					$k2023=isset($dk23->kinerja2023) && $dk23->kinerja2023!="" && $dk23->kinerja2023!=null?$dk23->kinerja2023:0;
					$k2022=isset($dk23->kinerja2022) && $dk23->kinerja2022!="" && $dk23->kinerja2022!=null?$dk23->kinerja2022:0;
					$k2021=isset($dk23->smkbk2021) && $dk23->smkbk2021!="" && $dk23->smkbk2021!=null?$dk23->smkbk2021:0;
					$dtkin[]=array(
									"ud"=>$q->userid,
									"nip"=>$q->nopeg,
									"nama"=>$q->nama,
									"k2023"=>$k2023,
									"k2022"=>$k2022,
									"k2021"=>$k2021,
									"standard"=>100);
				}
				

			}
		/**/

			

			$tetos=0;
			$cetos=0;
			foreach($dataetos2 as $key=>$val){
				$rata=round(array_sum($val)/count((Array)$val),2)*100;
				$tetos+=$rata;
				$cetos++;
				$detailetos['detail'][$key]=$rata;
				$datacount++;
			}

			$detailetos['total']=round($tetos/$cetos,2);


			//2. tradisi

			$ttradisi=0;
			$ctradisi=0;
			foreach($datatradisi2 as $key=>$val){
				$rata=round(array_sum($val)/count((Array)$val),2)*100;
				$ttradisi+=$rata;
				$ctradisi++;
				$detailtradisi['detail'][$key]=$rata;
				$datacount++;
			}

			$detailtradisi['total']=round($ttradisi/$ctradisi,2);

			//3.tritertib
			$tritertibhasil="";
			$ttritertib=0;
			$ctritertib=0;
			foreach($datatritertib2 as $key=>$val){
				foreach($val as $key2=>$val2){
					foreach($val2 as $key3=>$val3){
						$tritertibhasil .= "<tr>";
						$tritertibhasil .= "<td>".$key."</td>";
						$tritertibhasil .= "<td>".$key2."</td>";
						$tritertibhasil .= "<td>".$key3."</td>";
						$rata =round((array_sum($val3)/count((array)$val3))*100,2);
						$ttritertib+=$rata;
						$ctritertib++;
						$tritertibhasil .= "<td>".$rata."</td>";
						$tritertibhasil .= "</tr>";
						$datacount++;
					}
				}
			}	
			$detailtritertib['total']=round($ttritertib/$ctritertib,2);
			$detailtritertib['detail']=$tritertibhasil;

			//4.atribut
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
			$detailatribut['total']=round($tatribut/$catribut,2);
			$detailatribut['detail']=$atributhasil;			


			//5/ data kinerja
			$datakinerja=$dtkin;
		
			$total=round(($detailetos['total']+$detailtradisi['total']+$detailtritertib['total']+$detailatribut['total'])/4,2);

			$end = microtime(true);

			$executionTime = $end - $start;
			
			$data['etos']=$detailetos['total'];
			$data['tradisi']=$detailtradisi['total'];
			$data['tritertib']=$detailtritertib['total'];
			$data['atribut']=$detailatribut['total'];
			$data['total']=$total;

			$data['detailetos']=$detailetos;
			$data['detailtradisi']=$detailtradisi;
			$data['detailtritertib']=$detailtritertib;
			$data['detailatribut']=$detailatribut;
			$data['detailkinerja']=$dtkin;


			$data['executetime']=$executionTime;
			$data['postentitas']=$entitaschoose;
			$data['postbatch']=$batchchoose;
			$data['datacount']=$datacount;
			//echo "proses perhitungan dalam ".$executionTime." detik";
			//print_r($dataetos);
			$this->output->set_template('dashboard');
			$this->load->view('page/v_hasil_kriteria',$data);
		}
		else{
			redirect('Muka/logout');
		}
	}


	function tesres(){

		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.id as idp,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->limit(1000);
		$query1=$this->db->get()->result();	
		foreach($query1 as $q){
			$qkinerja=$this->db->select('*')
					 ->from('tb_komparasi_kinerja')
					 ->where('userid',$q->userid);
			$dkinerja=$this->db->get()->result();

			foreach($dkinerja as $dk23){
				$dtkin['ud'][]=$q->userid;
				$dtkin['2023'][]=$dk23->kinerja2023;
				$dtkin['2022'][]=$dk23->kinerja2023;
				$dtkin['2021'][]=$dk23->kinerja2023;
			}
		}

		print_r($dtkin);

	}
}
