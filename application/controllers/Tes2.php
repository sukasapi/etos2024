<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes2 extends CI_Controller {
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
		$datacek=array();
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.nama as perusahaan,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				 ->from('tb_peserta as p')
				 ->join('tb_user as u','u.id=p.userid')
				 ->join('tb_perusahaan as c','c.id=u.company')
				 ->where($where);
		$query1=$this->db->get()->result();

		foreach($query1 as $q){
			$stat=$q->status_peserta;
			///etos kerja
			$penilai= $q->userid;
			$bawahan=count((array)$this->alter->getrelasi('bawahan',array('m.leader'=>$penilai,"m.status"=>"aktif")));
			$mitra=count((array)$this->alter->getrelasi('mitra',array('m.mitra'=>$penilai,"m.status"=>"aktif")));
			$jpenilaian=$bawahan + $mitra;

			if($bawahan == 0  && $mitra==0 && $stat=="peserta"){
				$statuspeserta="Peserta";
			}else if($mitra > 0 &&  $stat=="peserta"){
				$statuspeserta="Peserta & Mitra";
			}else if($bawahan > 0 && $stat=="penilai"){
				$statuspeserta="Atasan";
			}else if($mitra>0 && $stat=="penilai"){
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
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($queryetos < $mitra){
					$jetos="<small style='color:#e67e22'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos ." evaluasi pada ".$mitra." mitra</small>";
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($queryetos < $bawahan){
					$jetos="<small style='color:#e67e22'>Memberi ".$queryetos." evaluasi pada bawahan</small>";
				}else{
					$jetos="<small style='color:#16a085'>Memberi ".$queryetos." evaluasi</small>";
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
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($querytradisi < $mitra){
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi ." evaluasi pada ".$mitra." mitra</small>";
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($querytradisi < $bawahan){
					$jtradisi="<small style='color:#e67e22'>Memberi ".$querytradisi." evaluasi pada bawahan</small>";
				}else{
					$jtradisi="<small style='color:#16a085'>Memberi ".$querytradisi." evaluasi</small>";
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
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($querytritertib < $mitra){
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib ." evaluasi pada ".$mitra." mitra</small>";
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($querytritertib < $bawahan){
					$jtritertib="<small style='color:#e67e22'>Memberi ".$querytritertib." evaluasi pada bawahan</small>";
				}else{
					$jtritertib="<small style='color:#16a085'>Memberi ".$querytritertib." evaluasi</small>";
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
				$jtritertib="<small style='color:#16a085'> Peserta hanya data kinerja saja</small>";
			}else if($mitra > 0 && $stat=="peserta"){
				if($queryatribut < $mitra){
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
				}
				
			}else if($mitra >0 && $stat=="penilai"){
				if($queryatribut < $mitra){
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra<small>";
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut ." evaluasi pada ".$mitra." mitra</small>";
				}
			}else if($bawahan >0 && $stat=="penilai"){
				if($queryatribut < $bawahan){
					$jatrib="<small style='color:#e67e22'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
				}else{
					$jatrib="<small style='color:#16a085'>Memberi ".$queryatribut." evaluasi pada ".$bawahan."  bawahan</small>";
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
			}else if($bawahan > 0 && $stat=="penilai"){
				$wherekin=array('evaluasi'=>'5','catatan_dari'=>$penilai,'status'=>'final');
				$this->db->select("id,status,catatan,catatan_dari,filebukti")
					 ->from('tb_evaluasi')
					 ->where($wherekin);
				$querykin=$this->db->count_all_results();
				$sisa=$bawahan;
				$jkin=$querykin." dari ".$sisa ."(approval)";
				$jkin="<small style='color:#16a085'>".$querykin."<br>(approval)</small>";
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
			$this->output->set_template('dashboard');
			$this->load->view('page/cek_pengisian',$data);
	}

	function kalkulasi(){
		$where=array('u.isaktif'=>'1','status_peserta'=>'peserta');
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
			

			$where8=array('status'=>'1','userid'=>$q->userid);
			$this->db->select ('smkbk2021 as nilai')
					 ->from('tb_komparasi_kinerja')
					 ->where($where8);
			$query8=$this->db->get()->row();
			$smkbk2021=!empty($query8->nilai)?$query8->nilai:"0";


			$npstotal=($etos+$tradisi+$tritertib+$atribut)/4;

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
							"smkbk2021"=>$smkbk2021);
				/**/	/*		/**/
		}
			$data['npsnonkinerja']=$dnilai;
		 	print_r($dnilai);
			//$this->output->set_template('dashboard');
			//$this->load->view('page/kalkulasi_data',$data);
	}


	function recalckinerja(){
		$where=array('jenis'=>'5',"status"=>"final");
		$this->db->select('*')
				 ->from('tb_evaluasi')
				 ->where($where);
		$query=$this->db->get()->result();
		$ok=0;
		$failed=0;
		
		foreach($query as $q){
			$where2=array("inisial"=>'M',"evaluasi"=>$q->id);
			//updTE NILAI Evaluasi dari avg jawaban
			$this->db->select('AVG(bobot) as nilai')
					 ->from('tb_jawaban')
					 ->where('evaluasi',$q->id);
			$skor= $this->db->get()->row()->nilai;
			//update nilai
			$dtupdate = array("nilai"=>$skor);
			$this->db->where(array('id'=>$q->id));
			$update=$this->db->update('tb_evaluasi',$dtupdate);
			if($update){
				$ok++;
			}else{
				$failed++;
			}
			/**/

			
		}
			echo "<hr>";
		
			echo "berhasil update date sebanyak:".$ok."  gagal update data:".$failed;
			
		
	}
	
	
	
	function ceknilai(){
		$idus='1080';
		$jenis='5';
	

		//cek evaluasi dengan dengan  peserta adalah user id
		$where2=array('status'=>'final','peserta'=>$idus,'jenis'=>5,'tahun !='=>'NULL','tahun'=>'2022');
		$this->db->select('*')
				 ->from('tb_evaluasi')
				 ->where($where2);
		$query7=$this->db->get()->result();
		$sum=0;
		$count=count((Array)$query7);
		foreach($query7 as $q){
			echo $q->id;
			echo "-";
			
			$wherer=array("evaluasi"=>$q->id);
			$this->db->select ('AVG(bobot) as nilai')
			->from('tb_jawaban')
			->where($wherer);
			$queryr=$this->db->get()->row();
			echo $queryr->nilai;
			echo "<br>";
			$sum+=$queryr->nilai;
		}
		$rerata=($sum/$count);
		echo $sum."/".$count."=".$rerata;
		/*$sumnilai=0;
		$countnilai=count((array)$query1);
		foreach($query1 as $q){	
			echo $q->nilai."<br>";
			$sumnilai +=$q->nilai;
		}
		echo $sumnilai ."/".$countnilai;
*/

		
	
		

	}

///step perbaikan NIlai

//// 1. update data nilai per soal
	function updatenilai(){

		$where=array("e.status"=>"final",'e.jenis'=>'5');
		$this->db->select('j.id as idjawab , e.id as idevaluasi,j.jawaban,j.nilai,j.bobot,j.inisial')
				 ->from('tb_jawaban as j')
				 ->join('tb_evaluasi as e','e.id=j.evaluasi')
				 ->where($where);
		$query=$this->db->get()->result();
		foreach($query as $q){
			$jawab =explode(";",$q->jawaban);
			$target=$jawab['0'];
			$realisasi=isset($jawab['1'])?$jawab['1']:0;

			//formula




			echo "id jawab:".$q->idjawab. " - target:".$target." - realisasi:".$realisasi." - formula:".$q->inisial." - nilai:".$q->nilai."<hr>"; 


		}
				 /*$where=array("status"=>"final","jenis"=>'5');
		$this->db->select('*')
				 ->from('tb_evaluasi')
				 ->where($where);
		$query=$this->db->get()->result();
		foreach ($query as $q){
			echo $q->id.":<br>";
			$where2=array("evaluasi"=>$q->id);
			$this->db->select('*')
				 ->from('tb_jawaban')
				 ->where($where2);
			$query2=$this->db->get()->result();
			foreach ($query2 as $q2){
				/*
				$jawab=explode(";",$q2->jawab);
				echo "id jawaban:".$q2->id."  target:"=$jawab[0]." realisasi:".$jawab[1]."  inisial".."<br>";
				
			}		
			echo "<hr>";
			*/
		
	}


//// 2. update bobot tiap soal
	function recalcbobot(){
		$where=array('jenis'=>'5',"status"=>"final");
		$this->db->select('*')
				 ->from('tb_evaluasi')
				 ->where($where);
		$query=$this->db->get()->result();
		$ok=0;
		$failed=0;
		foreach($query as $q){
			$where2=array("evaluasi"=>$q->id);
			$this->db->select('id,nilai,inisial')
			->from('tb_jawaban')
			->where($where2);
  		 	$q2=$this->db->get()->result();
			if(count((array)$q2) > 0){
				foreach($q2 as $n){
					if($n->inisial =="M"){
						$ntmp= $n->nilai;
						if($ntmp > 100){
							$bobot=100;
						}else if($ntmp < 0){
							$bobot=0;
						}else{
							$bobot=$ntmp;
						}
	
					}else{
						$bobot=$n->nilai >100?100:$n->nilai;		
					}
				
				$this->db->where('id',$n->id);
				$dtupd=array('bobot'=>$bobot);
				$this->db->update('tb_jawaban',$dtupd);
			
			}
			
		}   			

		}
	}
/// 3. update nilai di evaluasi
	function updatekinerja(){
		$where=array('jenis'=>'5','status'=>'final');
		$this->db->select('*')
				 ->from('tb_evaluasi')
				 ->where($where);
		$query=$this->db->get()->result();
		$ok=0;
		$failed=0;

		foreach($query as $q){

			$where2=array("evaluasi"=>$q->id);
			//updTE NILAI Evaluasi dari avg jawaban
			$this->db->select('AVG(bobot) as nilai')
			->from('tb_jawaban')
			->where('evaluasi',$q->id);
			$query=$this->db->get()->row();
			if($q->nilai > 100){
				$nilai=100;
			}else if($q->nilai<0){
				$nilai=0;
			}else{
				$nilai=$q->nilai;
			}
		
			///update data nilai ke 
				$this->db->where('id',$q->id);
				$dtupd=array('nilai'=>$nilai);
				$update=$this->db->update('tb_evaluasi',$dtupd);

				if($update){
					$ok++;
					}else{
					$failed++;
					}
		}
		echo "<hr>";
		echo "berhasil update date sebanyak:".$ok."  gagal update data:".$failed;
	}

	function update_nilai(){
		

		//jika ada perubahan pada formula
		//1. ubah skema formula pada soal terkait

		/*$this->db->where('soal','323');
		$dtup=array('inisial'=>'M');
		$this->db->update('tb_jawaban',$dtup);
		*/

		//2. hitung ulang skor untuk nilai dan bobot pada tiap jawaban
		$this->db->select('*')
		->where('soal','323')
		->from('tb_jawaban');

		$query=$this->db->get()->result();
		if(count((array)$query) > 0){
			foreach ($query as $q){
				$jawaban=explode(";",$q->jawaban);
				$target=isset($jawaban[0])?$jawaban[0]:0;
				$realisasi=isset($jawaban[1])?$jawaban[1]:0;
				$nilai = 480-4*(($realisasi/$target)*100);
				
				
				///update bobot
				if($nilai >100){
					$bobot=100;
				}else if($nilai < 0){
					$bobot=0;
				}else{
					$bobot=$nilai;
				}

				$wupdate=array("id"=>$q->id);
				$dtupnilai=array("nilai"=>$nilai,"bobot"=>$bobot);
				///
				$this->db->where($wupdate);
				$queryupdt=$this->db->update('tb_jawaban',$dtupnilai);
				if($queryupdt){
					echo "id:".$q->id." nilai awal:".$q->nilai." nilai update:".$nilai."<hr>";
				}else{
					echo "id:".$q->id." nilai awal:".$q->nilai."gagal update<hr>";
				}
	
			}

		}else{

		}
	/**/
		
		//$dt=array("inisial"=>"M");
		//$query=$this->db->update('tb_jawaban',$dt);
	}


	function demografik(){
		$kategori='komoditas';
		$entitas='1';
		$label=array();
		$labels=array();
		$data=array();
		$datagraph=array();

		if($entitas=='semua'){
			$this->db->select('kode,id')
					 ->from('tb_perusahaan')
					 ->where('is_aktif','aktif')
					 ->order_by('id');
			$query=$this->db->get()->result();
			foreach($query as $q){
				$label[]=$q->kode;
				//dapatkan nilai dari tiap entitas
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$q->id);
				$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($filter);
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
				$data['etos'][]=$etos;
				$data['tradisi'][]=$tradisi;
				

			
			}
		}else{
			$wheref=array('u.isaktif'=>'1','u.company'=>$entitas,'p.status_peserta'=>'peserta');
			$this->db->select('distinct(p.unitusaha) as uker')
			->from('tb_peserta as p')
			->join('tb_user as u','u.id=p.userid')
			->where($wheref)
			->order_by('p.unitusaha');
			$query=$this->db->get()->result();
			foreach($query as $q){
				$label[]=$q->uker;
				//dapatkan nilai dari tiap entitas
				$filter=array('u.isaktif'=>'1','p.unitusaha'=>$q->uker,'p.status_peserta'=>'peserta');
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
				/**/

			
			}/**/
		
		}

		$res['label']=$label;
		$res['data']=$data;
		print_r($res);
	}

	function proporsi(){
		$idtype='1';
		$perusahaan="semua";
		if($perusahaan =='semua'){
			$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
		}else{
			$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta','u.company'=>$perusahaan);
		}
		
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($filter);
		$query1=$this->db->get()->result();
		$datatmp=array();

		foreach($query1 as $q){
			///etos
			$where2=array('status'=>'final','peserta'=>$q->userid,'jenis'=>$idtype);
			$this->db->select ('avg(nilai) as nilai')
					->from('tb_evaluasi')
					->where($where2);
			$query2=$this->db->get()->row();
			//echo $this->db->last_query();
			$nilai=isset($query2->nilai)?$query2->nilai:0;
			if($nilai >=75){
				$data['tinggi'][]=$nilai;
			}else if($nilai > 50 && $nilai < 75){
				$data['sedang'][]=$nilai;
			}else if($nilai > 25 && $nilai < 50){
				$data['rendah'][]=$nilai;
			}else if($nilai > 1 && $nilai < 25){
				$data['sangat rendah'][]=$nilai;
			}else{
				$data['tidak dapat diterima'][]=$nilai;
			}
		
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

	function closeuser(){
		$this->db->where('status','user');
		$data=array('isonline'=>'0');
		$this->db->update('tb_user',$data);
	}

	function updatebatch(){
		$this->db->where('status_peserta','penilai');
		$data=array('batch'=>'');
		$this->db->update('tb_peserta',$data);
	}

	function progresspeserta(){
		$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
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
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"nopeg"=>$q->nopeg,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);
			
		}
		echo "<table border='1'>";
		echo "<tr>";
		echo "<td rowspan='2'>Nik</td>";
		echo "<td rowspan='2'>nama</td>";
		echo "<td rowspan='2'>batch</td>";
		echo "<td rowspan='2'>jatah</td>";
		echo "<td rowspan='2'>Terisi</td>";
		echo "<td rowspan='2'>Kurang</td>";
		echo "<td colspan='2'>Evaluasi</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Atasan</td>";
		echo "<td>Mitra</td>";
		echo "</tr>";

		
		foreach($datauser as $du){
			$atasanisi=0;
			if(isset($du['evalatasan'][0])){
			$atasanisi=$du['evalatasan'][0]['jtotal'];	
			}else{
				
			}
		
			//echo $du['evalatasan'][0]['jtotal'];
		
		
			// /$atasanisi=isset($du['evalatasan'])?$du['evalatasan'][0]['jtotal']:"-";
			
			//$atasanisi=$du['evalatasan']['jtotal'];
			///jumlah isi mitra
			
			$mitraisi=array_column($du['evalmitra'], 'eval');
			$jmitraisi=array_sum($mitraisi);
			
			$selesai=$atasanisi  + $jmitraisi;
			$kurang=$du['jatah_evaluasi']-$selesai;
			echo "<tr>";
			echo "<td>".$du['nopeg']."</td>";
			echo "<td>".$du['nama']."</td>";
			echo "<td> Batch ".$du['batch']."</td>";
			echo "<td>".$du['jatah_evaluasi']."</td>";
			echo "<td>".$selesai."</td>";
			echo "<td>".$kurang."</td>";
			echo "<td>".$atasanisi."</td>";
			echo "<td>".$jmitraisi."</td>";
			echo "</tr>";
		

		}
		echo "</table>";

	}


	function tesproporsi(){
		$perusahaan="semua";
		$idtype="all";
		$batch="semua";

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
		//$sintaks=$this->db->last_query();
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
			//echo "tes nps";
		}
		else if($idtype=='all'){
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
			//echo "tes";
			$disp['score'][]=$nilai;
			$disp['hover'] =array('#0076bc', '#2cb64c', '#ffc600','#e63628','#006000');
			$disp['color']=array('#0071bc', '#2cb34c', '#ffc000','#e63928','#000000');
			$tinggi=isset($data['tinggi'])?count((array)$data['tinggi']):0;
			$cukup=isset($data['cukup'])?count((array)$data['cukup']):0;
			$sedang=isset($data['sedang'])?count((array)$data['sedang']):0;
			$rendah=isset($data['rendah'])?count((array)$data['rendah']):0;
			$srendah=isset($data['srendah'])?count((array)$data['srendah']):0;
			
			$disp['proporsi']=array($tinggi,$cukup,$sedang,$rendah,$srendah);
			//echo "tes all";
		}
		else{
			//echo "tes kinerja";
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
			$tinggi=count((array)$data['tinggi']);
			$cukup=count((array)$data['cukup']);
			$sedang=count((array)$data['sedang']);
			$rendah=count((array)$data['rendah']);
			$srendah=count((array)$data['srendah']);
			
			$disp['proporsi']=array($tinggi,$cukup,$sedang,$rendah,$srendah);
			
		}
				
		
		switch($idtype){
			case '1':
				$disp['label']=array('tinggi','cukup','rendah','sangat rendah');
			break;
			case '2':
				$disp['label']=array('Menjalankan dan menghayati','Tidak konsisten menjalankan','Tidak Menjalankan');
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
	
	$res=$disp;
	print_r($res);
	//echo json_encode($res);
	}


	function cekyangbelumngisi(){
		$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
		$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
		->from('tb_peserta as p')
		->join('tb_user as u','u.id=p.userid')
		->join('tb_perusahaan as c','c.id=u.company')
		->where($filter);
		$query1=$this->db->get()->result();
		$datacekisi=array();
		foreach($query1 as $q){
			$atasan=$this->alter->getrelasi('atasan',array('m.peserta'=>$q->userid));
			$jatasan=count((Array)$atasan);
			$mitra=(array)$this->alter->getrelasi('mitra',array('m.peserta'=>$q->userid));
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
					//echo $a->idkoneksi." |";
					//echo "menilai:".$q->nama."|";
					//echo "Batch obyek :".$q->batch." | ";
					//echo "status penilai :".$stat." | ";
					//echo "Jumlah penilaian :".$querynps[0]->jumlah." | ";
				//	echo "Approval : ".$querykinerja[0]->jumlah." dari ".$queryjumlahkinerja[0]->jumlah ."| ";
				//	echo "<hr>";
				$approval=$querykinerja[0]->jumlah." dari ".$queryjumlahkinerja[0]->jumlah;
				$datacekisi[]=array("nikpenilai"=>$a->nikatasan,
									"nmpenilai"=>$a->koneksi,
									"nikdinilai"=>$q->nopeg,
									"nmdinilai"=>$q->nama,
									"perusahaan"=>$q->perusahaan,
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
					/*echo $mitraid." |";
					echo "menilai:".$q->nama."|";
					echo "Batch obyek :".$q->batch." | ";
					echo "status penilai :".$stat." | ";
					echo $querynps[0]->jumlah;
					echo "<hr>";*/
					$approval="-";
					$datacekisi[]=array("nikpenilai"=>$m->nikmitra,
									"nmpenilai"=>$m->koneksi,
									"nikdinilai"=>$q->nopeg,
									"nmdinilai"=>$q->nama,
									"perusahaan"=>$q->perusahaan,
									"batch"=>$q->batch,
									"statuspenilai"=>$stat,
									"nps"=>$querynps[0]->jumlah,
									"approval"=>$approval);
				}
			}
			
		}
		print_r($datacekisi);

	}


	function generatekinerja2022(){
				$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
				$this->db->select('p.nopeg,p.userid,p.status_peserta,p.nama,c.kode as perusahaan,p.unitusaha,p.jenis_asisten,p.komoditas,c.kode as kdc,p.jenis_asisten,p.komoditas,p.batch')
				->from('tb_peserta as p')
				->join('tb_user as u','u.id=p.userid')
				->join('tb_perusahaan as c','c.id=u.company')
				->where($filter);
				$query1=$this->db->get()->result();

				foreach($query1 as $q){
					// kinerja baru
					$where=array('status'=>'final','peserta'=>$q->userid,'jenis'=>5,'tahun !='=>'NULL','tahun'=>'2022');
					$this->db->select ('avg(nilai) as nilai')
							->from('tb_evaluasi')
							->where($where);
					$query6=$this->db->get()->row();
					$nilai=round($query6->nilai,2);
					
					//cek jika ada maka
					$whereada=array("userid"=>$q->userid);
					$this->db->select('*')
							 ->from('tb_komparasi_kinerja')
							 ->where($whereada);
					$qada=$this->db->get()->result();
					$cada=count((array)$qada);
					if($cada > 0){
						//update
						$data=array("kinerja2022"=>$nilai);
						$this->db->where('userid',$q->userid);
						$this->db->update('tb_komparasi_kinerja',$data);
					}else{
						$data=array("kinerja2022"=>$nilai);
						$this->db->where('userid',$q->userid);
						$this->db->insert('tb_komparasi_kinerja',$data);
						//insert
					}
				
					//query7=$this->db->get();
					//print_r($query7);
					
					echo "<hr>";
					
				}
	}

	function persenbatch(){
		$filter=array('u.isaktif'=>'1','p.status_peserta'=>'peserta');
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
			$datauser[]=array("uid"=>$q->userid,"nama"=>$q->nama,"nopeg"=>$q->nopeg,"perusahaan"=>$q->perusahaan,"batch"=>$q->batch,"jatah_evaluasi"=>$jatah_evaluasi,"evalatasan"=>$datasan,"evalmitra"=>$dmitra);
			
		}
	
		$display[]=array();
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

		foreach($disp as $key1=>$batch)	{		
			foreach($batch as $key2=>$val){
				$j= count((array)$val);echo "-";
				$n=array_sum($val);
				$persentotal=$n>0?round(($n/$j)*100,2):0;
				echo " Perusahaan: ". $key1." | Batch: ". $key2. " | persen :".$persentotal ;
				echo "<hr>";
			}
		}
	}
	
	function hardreset(){
		
		$reset=$this->user->hardresetuser('1');
		print_r($reset);
		echo 'berhasil';
	}

}