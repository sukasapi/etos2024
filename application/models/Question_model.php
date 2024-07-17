<?php if(!defined('BASEPATH')) exit('No direct script access allowed');



class Question_model extends CI_Model
{
    function listsoal(){
        $this->db->select('p.id,p.soal,p.deskripsi,p.date_created, p.status,p.jenis_evaluasi,p.jenis_evaluasi,p.jenis_asisten,p.komoditas,p.unit_kerja,
                            je.nama as nama_evaluasi,je.tipe_nilai')
                 ->from('tb_soal as p')
                 ->join('tb_jenis_evaluasi as je','je.id=p.jenis_evaluasi')
                 ->order_by('p.date_created','desc');
        $query=$this->db->get();
        //$syn=$this->db->last_query(); 
       if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
   
  
    }

    function searchsoal($where=null){
        $this->db->select('p.id,p.soal,p.deskripsi,p.formula,p.date_created, p.status,p.jenis_evaluasi,p.jenis_asisten,p.komoditas,p.unit_kerja,
        je.nama as nama_evaluasi,je.tipe_nilai')
        ->from('tb_soal as p')
        ->where($where)
        ->join('tb_jenis_evaluasi as je','je.id=p.jenis_evaluasi')
        ->order_by('p.date_created','desc');
        $query=$this->db->get();
        $syn=$this->db->last_query();
        if($this->db->count_all_results() > 0){ 
            return $query->result();
        }else{
            return array();
        }
        

  
    }

    function addsoal(){
        $where=array('pertanyaan'=>$_POST['pertanyaan']);
        $ada=count((array)$this->searchsoal($where));
        if($ada > 0){
            $pesan= "Pertanyaan ".$_POST['pertanyaan']."sudah ada.Silahkan buat pertanyaan lain";
            $res=array('pesan'=>'data sudah ada','res'=>'gagal');
            $this->session->set_flashdata('error', $pesan);
        }else{
           $bobot=empty($_POST['bobot']) ? '0' : $_POST['bobot'];
           $value=empty($this->encryption->decrypt($_POST['value'])) ? '0' : $_POST['value'];
           $dataquestion=array(
                                "pertanyaan"=>strtolower($_POST['pertanyaan']),
                                "create_date"=>date('Y-m-d H:i:s'),
                                "is_aktif"=>"aktif",
                                "bobot"=>$bobot,
                                "tipe"=>$_POST['tipe'],
                                "value"=>$value);
            $ins=$this->db->insert('tb_pertanyaan',$dataquestion);
            if($ins){
                $pesan= "Registrasi pertanyaan ".$_POST['pertanyaan']." berhasil dilakukan";
                $res=array('pesan'=>$pesan,'res'=>'ok');
                $this->session->set_flashdata('success', $pesan);
            }else{
                $pesan= "Registrasi value ".$_POST['pertanyaan']." gagal dilakukan pada database";
                $res=array('pesan'=>$pesan,'res'=>'gagal');
                $this->session->set_flashdata('error', $pesan);
            }
        }
        return $res;
    }

    function listsoalwhere($where=null){
        $this->db->select('id,soal')
                 ->from('tb_soal')
                 ->where($where);
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
    



    ///// JAWABAN

     function listjawab(){
        $this->db->select('j.id,j.inisial,j.jawaban, j.is_aktif,j.nilai,j.bobot,j.create_date,j.soal,
                           s.pertanyaan,s.bobot as bobot_soal,s.is_aktif as soal_aktif')
                 ->from('tb_jawaban as j')
                 ->join("tb_pertanyaan as s","s.id=j.soal",'left')
                 ->order_by('j.create_date','desc');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
  
    }
    function searchjawab($where){
        $this->db->select('j.id,j.evaluasi,j.inisial, j.jawaban, j.is_aktif,j.nilai,j.bobot,j.create_date,j.soal,
                           s.pertanyaan,s.bobot as bobot_soal, s.is_aktif as soal_aktif')
                 ->from('tb_jawaban as j')
                 ->where($where)
                 ->order_by('j.inisial','ASC')
                 ->join("tb_pertanyaan as s","s.id=j.soal",'left')
                 ->order_by('j.create_date','desc');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
  
    }
    function searchjawab2($where){
        $this->db->select('*,s.soal as tsoal')
                 ->from('tb_jawaban as j')
                 ->join('tb_soal as s','s.id=j.soal')
                 ->where($where);
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
  
    }

    function searchjawab3($where){
        $this->db->select('*')
                 ->from('tb_jawaban as j')
                 ->where($where)
                 ->order_by('j.inisial','ASC')
                 ->join("tb_soal as s","s.id=j.soal",'left')
                 ->order_by('j.create_date','desc');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
  
    }


    function addjawaban(){
        $where=array('j.jawaban'=>$_POST['jawaban'],"j.inisial"=>$_POST['inisial'],"j.is_aktif"=>$_POST['statusjawaban']);
        $ada=count((array)$this->searchjawab($where));
        if($ada > 0){
            $pesan= "Jawaban ".$_POST['jawaban']."sudah ada.Silahkan buat jawaban lain";
            $res=array('pesan'=>'data sudah ada','res'=>'gagal');
            $this->session->set_flashdata('error', $pesan);
        }else{
           $bobot=empty($_POST['bobot']) ? '0' : $_POST['bobot'];
           $nilai=empty($this->encryption->decrypt($_POST['nilai'])) ? '0' : $_POST['nilai'];
           $dataquestion=array(
                                "soal"=>$this->encryption->decrypt($_POST['stoken']),
                                "jawaban"=>strtolower($_POST['jawaban']),
                                "create_date"=>date('Y-m-d H:i:s'),
                                "is_aktif"=>"aktif",
                                "bobot"=>$bobot,
                                "inisial"=>strtoupper($_POST['inisial']),
                                "nilai"=>$nilai);
            $ins=$this->db->insert('tb_jawaban',$dataquestion);
            if($ins){
                $pesan= "Registrasi jawaban ".$_POST['jawaban']." berhasil dilakukan";
                $res=array('pesan'=>$pesan,'res'=>'ok');
                $this->session->set_flashdata('success', $pesan);
            }else{
                $pesan= "Registrasi jawaban ".$_POST['jawaban']." gagal dilakukan pada database";
                $res=array('pesan'=>$pesan,'res'=>'gagal');
                $this->session->set_flashdata('error', $pesan);
            }
        }
        return $res;
    }



    //////SUBMIT SOAL
    function submit(){
        $project=$_POST['project'];
        $jenis=$_POST['jenis'];
        $nilai=$_POST['evaluasi'];

        foreach($nilai as $keys=>$value){
            if($value < 7){
                $n=-1;
            }else if( $value == 7 || $value == 8){
                $n=0;
            }else{
                $n=1;
            }
            $datanilai=array("peserta"=>$this->encryption->decrypt($_SESSION['logged_in']['id']),
                             "project"=>$project,
                             "jenis"=>$jenis,
                             "nilai"=>$n,
                             "date_create"=>date('Y-m-d H:i:s'),"status"=>"aktif");
            $query = $this->db->insert('tb_evaluasi',$datanilai);
            if($query){
                $res[]=array('nomor'=>$keys,"pesan"=>'tersimpan');
            }else{
                $res[]=array('nomor'=>$keys,"pesan"=>'tidak tersimpan');
            }
        }
        return $res;
    }

    function getans($where=null){
        $this->db->select('id,evaluasi,soal,jawaban')
                 ->from('tb_jawaban')
                    ->where($where);
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
    function addans($data=null){
        $query=$this->db->insert('tb_jawaban',$data);
        if($query){
            return true;
        }else{
            return false;
        }
        
    }

    function updateans($where=null,$data=null){
        $this->db->where($where);
        $query=$this->db->update('tb_jawaban',$data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    
    /// KINERJAS


    function addkinerja(){
        $i=0;
		foreach($_POST['usoal'] as $p){
			$target=isset($_POST['target'][$i])?$_POST['target'][$i]:0;
			$realisasi=isset($_POST['realisasi'][$i])?$_POST['realisasi'][$i]:0;
			$jawab=$target.";".$realisasi;
			$usoal=$this->encryption->decrypt($p);
			switch($_POST['formula'][$i]){
				case 'P':
					$nilai = ($realisasi /$target) * 100 ;
				break;
				case 'M':
					$nilai = 480-4*(($realisasi/$target)*100);
				break;
				case '0-1':
					$nilai = $realisasi;
				break;
			}
            $ideval=$this->encryption->decrypt($_POST['eval']);
			$data=array("evaluasi"=>$ideval,"inisial"=>$_POST['formula'][$i],"soal"=>$usoal,"jawaban"=>$jawab,'nilai'=>$nilai);
			$wherejawab=array("evaluasi"=>$ideval,"soal"=>$usoal);
            if(count((array)$this->getans($wherejawab)) > 0){
                $idjwab=$this->getans($wherejawab)[0]->id;
                $wherej=array('id'=>$idjwab);
                $this->db->where($wherej);
                $query=$this->db->update('tb_jawaban',$data);
            }else{
                $query=$this->db->insert('tb_jawaban',$data);
            }
           
            if($query){
                   //edit status evaluasi
                $upeval=array('status'=>'draft');
                $this->db->where('id',$ideval);
                $this->db->update('tb_evaluasi',$upeval);

                $pesan="berhasil menerima jawaban";
                $res[]=array('pesan'=>$pesan,'res'=>'ok','data'=>$ideval);
                $this->session->set_flashdata('success', $pesan);
            }else{
                $pesan="gagal menyimpan jawaban";
                $res[]=array('pesan'=>$pesan,'res'=>'gagal','data'=>$ideval);
                $this->session->set_flashdata('error', $pesan);
            }
            $i++;
		}
        return $res;
    }

    function desk($token=null){
        $this->db->select('deskripsi')
                 ->from('tb_soal')
                 ->where('id',$token)
                 ->limit(1);
        $query=$this->db->get()->row();

        return $query;
    }
       

 
}