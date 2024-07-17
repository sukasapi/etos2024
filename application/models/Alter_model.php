<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Alter_model extends CI_Model

{



    ///// atasan

    function getatasan($where=null){

        $this->db

                 ->select('a.id as idrel , a.level as level , a.status as status, a.perusahaan as idper, a.perusahaan as company,

                           p.nama as peserta,p.userid as idpeserta,

                           p2.nama as atasan,p2.userid as idatasan,

                           pr.nama as perusahaan')

                 ->from('tb_atasan as a')

                 ->join('tb_peserta as p','p.userid=a.peserta','left')

                 ->join('tb_peserta as p2','p2.userid=a.leader','left')

                 ->join('tb_perusahaan as pr','pr.id=a.perusahaan','left')

                 ->where($where);

        $query=$this->db->get();



        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

    function getatasanall(){

        $this->db

                 ->select('a.id as idrel ,a.level as level , a.status as status,

                           p.nama as peserta,p.userid as idpeserta,

                           p2.nama as atasan,p2.userid as idatasan,

                           pr.nama as perusahaan')

                 ->from('tb_atasan as a')

                 ->join('tb_peserta as p','p.userid=a.peserta','left')

                 ->join('tb_peserta as p2','p2.userid=a.leader','left')

                 ->join('tb_perusahaan as pr','pr.id=a.perusahaan','left');

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

    function addatasan(){

        if(empty($_POST['level'])){

            $level=1;

        }else{

            $level=$_POST['level'];

        }

        $data=array("peserta"=>$_POST['bawahan'],

                    "leader"=>$_POST['atasan'],

                    "level"=>$level,

                    "create_date"=>date('Y-m-d H:i:s'),

                    "status"=>$_POST['status'],

                    "perusahaan"=>$_POST['perusahaan']);

        ///cek ada

        $where=array("a.peserta"=>$_POST['bawahan'],

                     "a.leader"=>$_POST['atasan'],

                    "a.perusahaan"=>$_POST['perusahaan']);

        $ada=$this->getatasan($where);

        if(count((array)$ada) > 0){

            $pesan= "Koneksi karyawan sudah pernah dilakukan, cek kembali status koneksi";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('gagal', $pesan);

        }else{

            $query=$this->db->insert('tb_atasan',$data);

            if($query){

                $pesan= "Koneksi karyawan berhasil dilakukan";

                $res=array('pesan'=>$pesan,'res'=>'ok');

                $this->session->set_flashdata('ok', $pesan);

            }else{

                $pesan= "Koneksi karyawan gagal dibuat, hubungi admin";

                $res=array('pesan'=>$pesan,'res'=>'gagal');

                $this->session->set_flashdata('gagal', $pesan);

            }

        }

        return $res;

    }

    function editatasan(){

        if(empty($_POST['level'])){

            $level=1;

        }else{

            $level=$_POST['level'];

        }

        $data=array("peserta"=>$_POST['editbawahan'],

        "leader"=>$_POST['editatasan'],

        "level"=>$level,

        "status"=>$_POST['editstatus'],

        "perusahaan"=>$_POST['editperusahaan']);

        ///cek ada

        $where=array("peserta"=>$_POST['editbawahan'],

                        "leader"=>$_POST['editatasan'],

                        "level"=>$level,

                        "status"=>$_POST['editstatus'],

                        "perusahaan"=>$_POST['editperusahaan']);

        $ada=$this->getatasan($where);

        if(count((array)$ada) > 0){

        $pesan= "Koneksi karyawan sudah pernah dilakukan, cek kembali status koneksi";

        $res=array('pesan'=>$pesan,'res'=>'gagal');

        $this->session->set_flashdata('gagal', $pesan);

        }else{

        $query=$this->db->update('tb_atasan',$data);

        if($query){

            $pesan= "Koneksi karyawan berhasil dilakukan";

            $res=array('pesan'=>$pesan,'res'=>'ok');

            $this->session->set_flashdata('ok', $pesan);

        }else{

            $pesan= "Koneksi karyawan gagal dibuat, hubungi admin";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('gagal', $pesan);

        }

        }

        return $res;

    }





    ///// Mitra

    function getmitra($where=null){

        $this->db

                 ->select('m.status,m.id as idrel,

                           p.nama as peserta,p.userid as idpeserta,

                           p2.nama as atasan,p2.userid as idatasan,

                           pr.nama as perusahaan')

                 ->from('tb_mitra as m')

                 ->join('tb_peserta as p','p.userid=m.peserta','left')

                 ->join('tb_peserta as p2','p2.userid=m.mitra','left')

                 ->join('tb_perusahaan as pr','pr.id=m.perusahaan','left')

                 ->where($where);

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

    function getmitraall(){

        $this->db

                 ->select('m.status as status,m.id as idrel,

                           p.nama as peserta,p.userid as idpeserta,

                           p2.nama as atasan,p2.userid as idatasan,

                           pr.nama as perusahaan')

                 ->from('tb_mitra as m')

                 ->join('tb_peserta as p','p.userid=m.peserta','left')

                 ->join('tb_peserta as p2','p2.userid=m.mitra','left')

                 ->join('tb_perusahaan as pr','pr.id=m.perusahaan','left');

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

    function addmitra(){

        $data=array("peserta"=>$_POST['peserta'],

                    "mitra"=>$_POST['mitra'],

                    "date_create"=>date('Y-m-d H:i:s'),

                    "status"=>"aktif",

                    "perusahaan"=>$_POST['perusahaan']);

         ///cek ada

            $where=array("peserta"=>$_POST['peserta'],

            "mitra"=>$_POST['mitra'],

            "perusahaan"=>$_POST['perusahaan']);

            $ada=$this->getmitra($where);

            if(count((array)$ada) > 0){

            $pesan= "Koneksi karyawan sudah pernah dilakukan, cek kembali status koneksi";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('gagal', $pesan);

            }else{

            $query=$this->db->insert('tb_mitra',$data);

            if($query){

                $pesan= "Koneksi karyawan berhasil dilakukan";

                $res=array('pesan'=>$pesan,'res'=>'ok');

                $this->session->set_flashdata('ok', $pesan);

            }else{

                $pesan= "Koneksi karyawan gagal dibuat, hubungi admin";

                $res=array('pesan'=>$pesan,'res'=>'gagal');

                $this->session->set_flashdata('gagal', $pesan);

            }

        }



        return $res();

    }

    function editmitra(){

        $data=array("peserta"=>$_POST['peserta'],

                    "mitra"=>$_POST['mitra'],

                    "status"=>"aktif",

                    "perusahaan"=>$_POST['perusahaan']);

         ///cek ada

            $where=array("peserta"=>$_POST['peserta'],

            "mitra"=>$_POST['mitra'],

            "status"=>$_POST['status'],

            "perusahaan"=>$_POST['perusahaan']);

            $ada=$this->getmitra($where);

            if(count((array)$ada) > 0){

            $pesan= "Koneksi karyawan sudah pernah dilakukan, cek kembali status koneksi";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('gagal', $pesan);

            }else{

            $query=$this->db->update('tb_mitra',$data);

            if($query){

                $pesan= "Koneksi karyawan berhasil dilakukan";

                $res=array('pesan'=>$pesan,'res'=>'ok');

                $this->session->set_flashdata('ok', $pesan);

            }else{

                $pesan= "Koneksi karyawan gagal dibuat, hubungi admin";

                $res=array('pesan'=>$pesan,'res'=>'gagal');

                $this->session->set_flashdata('gagal', $pesan);

            }

        }



        return $res();

    }



    //?REGSITRASI PESERTA

    function getpesertaproject($where=null){

        if(is_null($where)){    

                     $this->db->select('pe.userid as up,pe.nopeg, pe.nama, pe.bagian, pe.jabatan,pe.perusahaan, pe.jenis_asisten,pe.komoditas,pe.unitkerja,

                               pr.nama as project,pr.id as idpro,ph.nama as nama_perusahaan')

                     ->from('tb_project_peserta as pp')

                     ->join('tb_peserta as pe','pe.userid = pp.peserta')

                     ->join('tb_project as pr','pr.id = pp.project') 

                     ->join('tb_perusahaan as ph','ph.id = pe.perusahaan')

                     ->order_by('pp.peserta','DESC');

             

        }else{

            $this->db->select('pe.userid as up,pe.nopeg, pe.nama, pe.bagian, pe.jabatan,pe.perusahaan,pe.jenis_asisten,pe.komoditas,pe.unitkerja,

            pr.nama as project ,pr.id as idpro,ph.nama as nama_perusahaan')

            ->from('tb_project_peserta as pp')

            ->join('tb_peserta as pe','pe.userid = pp.peserta')

            ->join('tb_project as pr','pr.id = pp.project') 

            ->join('tb_perusahaan as ph','ph.id = pe.perusahaan')

            ->where($where)

            ->order_by('pp.peserta','DESC');

        }

        $query = $this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }



    }



    function registrasipeserta($project=null){

        $i=0;

        foreach($_POST['peserta'] as $p){

            ///cek jika sudah ada

            $where=array('pp.project'=>$project,"pp.peserta"=>$p);

            if(count((array)$this->getpesertaproject($where)) > 0){



            }else{

                $datainsert=array('project'=>$project,'peserta'=>$p,"create_date"=>date('Y-m-d H:i:s'),"is_aktif"=>"aktif");

                $this->db->insert('tb_project_peserta',$datainsert);

                $i++;   

            }

			

		}

        $pesan= "Registrasi ".$i." peserta telah selesai dilakukan";

        $res=array('pesan'=>$pesan,'res'=>'ok');

        $this->session->set_flashdata('success', $pesan);



        return $res;

    }

    function removepeserta($project=null){

        $i=0;

        foreach($_POST['remolis'][0] as $r){

            $where=array('project'=>$project,"peserta"=>$r['id']);

            if(count((array)$this->getpesertaproject($where)) > 0){

                $this->db->where($where);

                $this->db->delete('tb_project_peserta');

                $this->db->query('ALTER TABLE tb_project_peserta AUTO_INCREMENT=0');

            }else{



            }

            $i++;

        }

        $pesan= "Penghapusan registrasi ".$i." peserta telah selesai dilakukan";

        $res=array('pesan'=>$pesan,'res'=>'ok');

        $this->session->set_flashdata('success', $pesan);

        return $res;

    }



    ////PREPARE TES

    function prepare(){

        $peserta =$this->encryption->decrypt($_SESSION['logged_in']['id']);

        $project = $this->encryption->decrypt($_POST['proyek']);

        $jenis = $this->encryption->decrypt($_POST['eval']);

        $data = array("project"=>$project,

                      "jenis"=>$jenis,

                      "peserta  "=>$peserta,                      

                      "date_create"=>date('Y-m-d H:i:s'), 

                      "status"=>"aktif", 

                      "progres"=> 0);

            $where = array("e.project"=>$project,"e.jenis"=>$jenis,"e.peserta"=>$peserta);

            $ada=$this->getprepare($where);

       if(count((array)$ada) > 0 ){

           if($ada[0]->status =="aktif"){

            $pesan= "Persiapan tes berhasil";

            $res=array('pesan'=>$pesan,'res'=>'ok','project'=>$ada[0]->idpro,'eval'=>$ada[0]->ideval);

            $this->session->set_flashdata('success', $pesan);

           }else{

            $pesan= "Persiapan data gagal karena syarat belum lengkap";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('error', $pesan);

           }

           

        }else{

            $this->db->insert('tb_evaluasi',$data);

            $pesan= "Persiapan tes berhasil";

            $ada2=$this->getprepare($where);

            $res=array('pesan'=>$pesan,'res'=>'ok','project'=>$ada2[0]->idpro,'eval'=>$ada2[0]->ideval);

            $this->session->set_flashdata('success', $pesan);

        }



     return $res;

    }



    function prepare2(){

        $penilai =$this->encryption->decrypt($_SESSION['logged_in']['id']);

        $jenis = $_POST['jval'];

        $peserta=$this->encryption->decrypt($_POST['teval']);

       

        $data = array(

                      "jenis"=>$jenis,

                      "peserta "=>$peserta,                      

                      "date_create"=>date('Y-m-d H:i:s'), 

                      "evaluasi"=>$jenis,

                      "penilai"=>$penilai,

                      "status"=>"aktif", 

                      "progres"=> 0);

            $where = array("e.jenis"=>$jenis,"e.peserta"=>$peserta,"e.penilai"=>$penilai);

            $ada=$this->getprepare2($where);

         if(count((array)$ada) > 0 ){

                if($ada[0]->status =="aktif" ||$ada[0]->status =="draft" || $ada[0]->status =="final" ){

                    $eval=$ada[0]->id;

                    $pesan= "Persiapan tes berhasil";

                    $res=array('pesan'=>$pesan,'res'=>'ok','eval'=>$eval);

                    $this->session->set_flashdata('success', $pesan);

                }else{

                    $pesan= "Persiapan data gagal karena syarat belum lengkap";

                    $res=array('pesan'=>$pesan,'res'=>'gagal');

                    $this->session->set_flashdata('error', $pesan);

                }



            }else{

                $res=array('pesan'=>'input berhasil','res'=>'ok');

                $this->db->insert('tb_evaluasi',$data);

                $idbaru=$this->db->insert_id();

                $pesan= "Persiapan tes berhasil";

                $where2=array('e.id'=>$idbaru);

                $ada2=$this->getprepare2($where2);

                $eval=$ada2[0]->id;

                $res=array('pesan'=>$ada2[0]->id,'eval'=>$eval,'res'=>'ok');

                $this->session->set_flashdata('success', $pesan);

               

            }



        return $res;

    }



    function preparekinerja($target=null){

        $penilai =$target;//$this->encryption->decrypt($_SESSION['logged_in']['id']);

        $jenis = "5";

        $peserta=$target;

        $data = array(

                      "jenis"=>$jenis,

                      "peserta "=>$peserta,                      

                      "date_create"=>date('Y-m-d H:i:s'), 

                      "evaluasi"=>$jenis,

                      "penilai"=>$penilai,

                      "status"=>"aktif", 

                      "progres"=> 0);

            $where = array("e.jenis"=>$jenis,"e.peserta"=>$peserta,"e.penilai"=>$penilai);

            $ada=$this->getprepare2($where);

            if(count((array)$ada) > 0 ){

                if($ada[0]->status =="aktif" ||$ada[0]->status =="draft" || $ada[0]->status =="final" ){

                    $eval=$ada[0]->id;

                    $pesan= "Persiapan tes berhasil";

                    $res=array('pesan'=>$pesan,'res'=>'ok','eval'=>$eval);

                }else{ 

                    $pesan= "Persiapan data gagal karena syarat belum lengkap";

                    $res=array('pesan'=>$pesan,'res'=>'gagal');

                    $this->session->set_flashdata('error', $pesan);

                }



            }else{

                $res=array('pesan'=>'input berhasil','res'=>'ok');

                $this->db->insert('tb_evaluasi',$data);

                $idbaru=$this->db->insert_id();

                $pesan= "Persiapan tes berhasil";

                $where2=array('e.id'=>$idbaru);

                $ada2=$this->getprepare2($where2);

                $eval=$ada2[0]->id;

                $res=array('pesan'=>$ada2[0]->id,'eval'=>$eval,'res'=>'ok');               

            }

        

        return $res;

    }

    function preparekinerja2($target=null,$bulan=null,$tahun=null){

        $penilai =$target;//$this->encryption->decrypt($_SESSION['logged_in']['id']);

        $jenis = "5";

        $peserta=$target;

        $data = array(

                      "jenis"=>$jenis,

                      "peserta "=>$peserta,                      

                      "date_create"=>date('Y-m-d H:i:s'), 

                      "evaluasi"=>$jenis,

                      "penilai"=>$penilai,

                      "status"=>"aktif",

                      "bulan"=>$bulan,

                      "tahun"=>$tahun, 

                      "progres"=> 0);

            $where = array("e.jenis"=>$jenis,"e.peserta"=>$peserta,"e.penilai"=>$penilai,"e.bulan"=>$bulan,"e.tahun"=>$tahun);

            $ada=$this->getprepare2($where);

           

            if(count((array)$ada) > 0 ){

              if($ada[0]->status =="aktif" ||$ada[0]->status =="draft" || $ada[0]->status =="final" ){

                    $eval=$ada[0]->id;

                    $pesan= "Tes telah dilakukan";

                    $res=array('pesan'=>$pesan,'res'=>'ok','eval'=>$eval);

                }else{ 

                    $pesan= "Persiapan data gagal karena syarat belum lengkap";

                    $res=array('pesan'=>$pesan,'res'=>'gagal');

                    $this->session->set_flashdata('error', $pesan);

                }

             

            }else{

               

                $res=array('pesan'=>'input berhasil','res'=>'ok');

                $this->db->insert('tb_evaluasi',$data);

                $idbaru=$this->db->insert_id();

                $pesan= "Persiapan tes berhasil";

                $where2=array('e.id'=>$idbaru);

                $ada2=$this->getprepare2($where2);

                $eval=$ada2[0]->id;

                $res=array('pesan'=>$ada2[0]->id,'eval'=>$eval,'res'=>'ok');    

                     

            }

        

        return $res;

    }

    



    function getprepare($where =null){

        $this->db->select('p.id as idpro,p.nama as npro,p.status as status,

                           je.nama as neval,je.id as ideval,e.progres as progres')

                 ->from('tb_evaluasi as e')

                 ->where($where)

                 ->join('tb_project as p','p.id=e.project')

                 ->join('tb_jenis_evaluasi as je','je.id=e.jenis')

                 ->join('tb_peserta as pe','pe.userid=e.peserta'); 

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }



    function getprepare2($where =null){

        $this->db->select('e.id as id, e.jenis as jenis,e.progres as progres,e.status as status,e.filebukti,e.catatan,e.catatan_dari,e.bulan,e.tahun,

                          pe.userid as id_peserta, pe.nama as namapeserta, 

                          pp.userid as id_penilai, pp.nama as namapenilai,

                          je.id as idjenis,je.nama as namajenis,je.tipe_nilai')

                 ->from('tb_evaluasi as e')

                 ->where($where)

                 ->join('tb_jenis_evaluasi as je','je.id=e.jenis')

                 ->join('tb_peserta as pe','pe.userid=e.peserta')

                 ->join('tb_peserta as pp','pp.userid=e.penilai');

        $query=$this->db->get();

        //$syn=$this->db->last_query();

    if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    

        //return $syn;

      

       

    }



 

    //// Evaluasi

    function getevaluasi($where){ 

        $this->db->select('e.id as id, e.jenis as jenis,e.progres as progres,e.status as status,e.evaluasi,e.bulan,e.tahun,

        pe.id as id_peserta, pe.nama as namapeserta,pe.jenis_asisten as jper,pe.komoditas as kompe,pe.unitkerja as ukper,pe.perusahaan as pecompany, 

        pp.id as id_penilai, pp.nama as namapenilai,pp.jenis_asisten as jpen,pp.komoditas as kompen,pp.unitkerja as ukpen,pp.perusahaan as ppcompany,

        je.id as idjenis,je.nama as namajenis,je.tipe_nilai,

        p.nama as ncompany')

        ->from('tb_evaluasi as e')

        ->where($where)

        ->join('tb_jenis_evaluasi as je','je.id=e.jenis')

        ->join('tb_peserta as pe','pe.userid=e.peserta')

        ->join('tb_peserta as pp','pp.userid=e.penilai')

        ->join('tb_perusahaan as p','p.id=pe.perusahaan');

        $query=$this->db->get();

        $syn=$this->db->last_query();

        //return $syn;

        if($this->db->count_all_results() > 0){

        return $query->result();

        }else{

        return array();

        }

        

    }



    function getjenisevaluasi(){

        $this->db->select('*')

                 ->from('tb_jenis_evaluasi')

                 ->order_by('id','ASC');

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }



    function editevaluasi($where=null,$data=null){

       $this->db->where($where);

      $query=$this->db->update('tb_evaluasi',$data);

        if($query){

            return true;

        }else{

            return false;

        }

    }



    function updateperiode($where=null,$periode=null){

        $this->db->where($where);

        $query=$this->db->update('tb_evaluasi',$periode);

        if($query){

            return true;

        }else{

            return false;

        }

    }





    function getrelasi($jenis=null,$where=null){

        switch($jenis){

            case 'atasan':

                ///jika atasan wherenya adalah tb_atasan.id_karyawan = id yang dikirim

                $this->db

                ->select('m.status,m.id as idrel,

                        p.nama as peserta,p.userid as idpeserta,p.nopeg as nikpeserta,

                        p2.nama as koneksi,p2.userid as idkoneksi,p2.nopeg as nikatasan,

                        pr.nama as perusahaan')

                ->from('tb_atasan as m')

                ->join('tb_peserta as p','p.userid=m.peserta','left')

                ->join('tb_peserta as p2','p2.userid=m.leader','left')

                ->join('tb_perusahaan as pr','pr.id=m.perusahaan','left')

                ->where($where)

                ->order_by("pr.id","ASC");

            break;

            case 'mitra':

                $this->db

                ->select('m.status,m.id as idrel,

                          p.nama as peserta,p.userid as idpeserta,,p.nopeg as nikpeserta,

                          p2.nama as koneksi,p2.userid as idkoneksi,p2.nopeg as nikmitra,

                          pr.nama as perusahaan')

                ->from('tb_mitra as m')

                ->join('tb_peserta as p','p.userid=m.peserta','left')

                ->join('tb_peserta as p2','p2.userid=m.mitra','left')

                ->join('tb_perusahaan as pr','pr.id=m.perusahaan','left')

                ->where($where)

                ->order_by("pr.id","ASC");

            break;

            case 'bawahan':

                ///jika bawahan wherenya adalah tb_atasan.id_atasan = id yang dikirim

                $this->db

                ->select('m.status,m.id as idrel,

                          p2.nama as peserta,p2.userid as idpeserta,

                          p.nama as koneksi,p.userid as idkoneksi,

                          pr.nama as perusahaan')

                ->from('tb_atasan as m')

                ->join('tb_peserta as p','p.userid=m.peserta','left')

                ->join('tb_peserta as p2','p2.userid=m.leader','left')

                ->join('tb_perusahaan as pr','pr.id=m.perusahaan','left')

                ->where($where)

                ->order_by("pr.id","ASC");

            break;

        }

       

        $query=$this->db->get();
        $syn=$this->db->last_query();

        if($this->db->count_all_results() > 0){

        return $query->result();

        }else{

        return array();

        }

        return $syn;    

    }



    function addrelasi(){

        

        /////cek dulu relasi, jika ada maka

        switch($_POST['level']){

            case 'bawahan':

                $where=array("peserta"=>$_POST['relasi'],"leader"=>$this->encryption->decrypt($_SESSION['logged_in']['id']));

                $data=array('peserta'=>$_POST['relasi'],'leader'=>$this->encryption->decrypt($_SESSION['logged_in']['id']),'level'=>'1','create_date'=>date('Y-md H:i:s'),'status'=>'aktif','perusahaan'=>$_POST['comp']);

                $this->db->select('count(id) as ada')

                            ->from('tb_atasan')

                            ->where($where)

                            ->limit(1);

                $query=$this->db->get();

               

                if($query->row('ada') > 0){

                   $idrelasi=$query->row('id');

                    $where=array("id"=>$idrelasi);

                    $this->db->update('tb_atasan',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah diupdate');

                    $this->session->set_flashdata('success', $res['pesan']);

                    

                }else{

                    //$res="tidak ada, tambah ";

                   

                    $this->db->insert('tb_atasan',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah ditambahkan');

                    $this->session->set_flashdata('success', $res['pesan']);

                

                }

            

            break;

            case 'atasan':

                $where=array("peserta"=>$this->encryption->decrypt($_SESSION['logged_in']['id']),"leader"=>$_POST['relasi']);

                $data=array('peserta'=>$this->encryption->decrypt($_SESSION['logged_in']['id']),'leader'=>$_POST['relasi'],'level'=>'1','create_date'=>date('Y-m-d H:i:s'),'status'=>'aktif','perusahaan'=>$_POST['comp']);

                $this->db->select('count(*) as ada')

                            ->from('tb_atasan')

                            ->where($where)

                            ->limit(1);

                $query=$this->db->get();

                if($query->row('ada') > 0){

                    $idrelasi=$query->row('id');

                    $where=array("id"=>$idrelasi);

                    $this->db->update('tb_atasan',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah diupdate');

                    $this->session->set_flashdata('success', $res['pesan']);

                }else{

                    $this->db->insert('tb_atasan',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah ditambahkan');

                    $this->session->set_flashdata('success', $res['pesan']);

                }

            break;

            case 'mitra':

                $where=array("peserta"=>$this->encryption->decrypt($_SESSION['logged_in']['id']),"mitra"=>$_POST['relasi']);

                $data=array('peserta'=>$this->encryption->decrypt($_SESSION['logged_in']['id']),'mitra'=>$_POST['relasi'],'create_date'=>date('Y-md H:i:s'),'status'=>'aktif','perusahaan'=>$_POST['comp']);

                $this->db->select('count(id) as ada')

                            ->from('tb_mitra')

                            ->where($where)

                            ->limit(1);

                $query=$this->db->get();

                if($query->row('ada') > 0){

                    $idrelasi=$query->row('id');

                    $where=array("id"=>$idrelasi);

                    $this->db->update('tb_mitra',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah diupdate');

                    $this->session->set_flashdata('success', $res['pesan']);

                }else{

                    $this->db->insert('tb_mitra',$data);

                    $res=array("res"=>'ok','pesan'=>'data telah ditambahkan');

                    $this->session->set_flashdata('success', $res['pesan']);

                }



                /// input kedua

                $where2=array("mitra"=>$this->encryption->decrypt($_SESSION['logged_in']['id']),"peserta"=>$_POST['relasi']);;

                $data2=array('mitra'=>$this->encryption->decrypt($_SESSION['logged_in']['id']),'peserta'=>$_POST['relasi'],'create_date'=>date('Y-md H:i:s'),'status'=>'aktif','perusahaan'=>$_POST['comp']);

                $this->db->select('count(id) as ada')

                ->from('tb_mitra')

                ->where($where2)

                ->limit(1);

                $query=$this->db->get();

                if($query->row('ada') > 0){

                    $idrelasi=$query->row('id');

                    $where=array("id"=>$idrelasi);

                    $this->db->update('tb_mitra',$data2);

                    $res=array("res"=>'ok','pesan'=>'data telah diupdate');

                    $this->session->set_flashdata('success', $res['pesan']);

                }else{

                    $this->db->insert('tb_mitra',$data2);

                    $res=array("res"=>'ok','pesan'=>'data telah ditambahkan');

                    $this->session->set_flashdata('success', $res['pesan']);

                }

            break;

        }



        return $res;

       

    }





    ///dashboard data

    function NPSadminscore($perusahaan=null){



        ///variable tampungan

			$npsnilai=array();

			$project=$this->getjenisevaluasi();

			

			/// UNTUK NILAI NPS

			foreach($project as $p){

				if($perusahaan == ''){

					$where1=array("e.evaluasi"=>$p->id,"e.status"=>"final");

				}else{

					$where1=array("e.evaluasi"=>$p->id,"pe.perusahaan"=>$perusahaan,"e.status"=>"final");

				}

				$dataeval=$this->alter->getevaluasi($where1);

				$adadata=count((Array)$dataeval);

				if($adadata > 0){

					if($p->id != '5'){

						if($adadata == 0){

							$npsnilai[$p->id]=array();	

						}else{

							foreach ($dataeval as $de){

								$wherejawaban=array("evaluasi"=>$de->id);

								$r=hitungnps($this->ask->searchjawab2($wherejawaban));

							

								$npsnilai[$p->id]['evaluasi'][]=$de->id;

								$npsnilai[$p->id]['NPS'][]=calcNPS($r['promoter'],$r['passive'],$r['detractor']) > 0 ? calcNPS($r['promoter'],$r['passive'],$r['detractor']) : 0;						

							}

								$nilai=array_sum($npsnilai[$p->id]['NPS'])/count((array)$npsnilai[$p->id]['NPS']);

								$npsnilai[$p->id]['nilai']=$nilai;

							//$nilai;

						}

					}else{

		

					}

				}else{



				}

				

				

			}

            return $npsnilai;



    }

    function tablescore($perusahaan=null){

        $project=$this->getjenisevaluasi();

		$nps=array();

		$kin=array();

		$dtevaluasi=array();

        $data=array();

		foreach($project as $p){

        

			if($p->id != '5'){

				if($perusahaan == ''){

					$where1=array("e.evaluasi"=>$p->id,"e.status"=>"final");

				}else{

					$where1=array("e.evaluasi"=>$p->id,"pe.perusahaan"=>$perusahaan,"e.status"=>"final");

			    }

                $dtevaluasi=$this->getevaluasi($where1);

                foreach($dtevaluasi as $de){

                   // print_r($de);

                    $nps[$p->id]['ideval'][]=$de->id;

                    $nps[$p->id]['namaeval'][]=$de->namajenis;

                    $nps[$p->id]['peserta'][]=$de->namapeserta;

                    $nps[$p->id]['penilai'][]=$de->namapenilai;

                    $nps[$p->id]['perusahaan'][]=$de->ncompany;

                    $wherejawaban=array("evaluasi"=>$de->id);

                    $r=hitungnps($this->ask->searchjawab2($wherejawaban));

                    $nps[$p->id]['promoter'][]=($r['promoter']);

                    $nps[$p->id]['detractor'][]=($r['detractor']);

                    $nps[$p->id]['passive'][]=($r['passive']);

                    $nps[$p->id]['npsscore'][]=($r['hasil']);

                }

              

            }else{

                

                if($perusahaan == ''){

                    $where=array("e.evaluasi"=>$p->id,"e.status"=>"final");

                }else{

                    $where=array("e.evaluasi"=>$p->id,"pe.perusahaan"=>$perusahaan,"e.status"=>"final");

                }

               $dtkinerja=$this->getevaluasi($where);

               foreach($dtkinerja as $dk){

                $wherejawaban=array("evaluasi"=>$dk->id);

                $datajawab=$this->ask->searchjawab3($wherejawaban);

                foreach ($datajawab as $dj){

                    $jawab=explode(";",$dj->jawaban);

                    $kin[]=array(

                                        "idpeserta"=>$dk->id_peserta,

                                        "namapeserta"=>$dk->namapeserta,

                                        "evaluasi"=>$dk->namajenis,

                                        "perusahaan"=>$dk->ncompany,

                                        "KPI"=>$dj->soal,

                                        "target"=>$jawab[0],

                                        "realisasi"=>$jawab[1],

                                        "formula"=>$dj->inisial,

                                        "skor"=>$dj->nilai

                                      );

                }

               }

            

            }

          

                

	    }

        $i=0;

        $data['kin']=$kin;

        $data['nps']=$nps;

    

        return $data;   

    

    }



    function statuseval($where=null){

        $this->db->select('e.status as status')

        ->from('tb_evaluasi as e')

        ->where($where)

        ->join('tb_jenis_evaluasi as je','je.id=e.jenis')

        ->join('tb_peserta as pe','pe.userid=e.peserta')

        ->join('tb_peserta as pp','pp.userid=e.penilai')

        ->join('tb_perusahaan as p','p.id=pe.perusahaan');

        $query=$this->db->get();

        $syn=$this->db->last_query();

       // return $syn;

        if($this->db->count_all_results() > 0){

        return $query->row();

        }else{

        return array();

        }

        

    }



    function getdetailnps($where=null){

        $this->db->select ('p.userid as idpenilai,p.nopeg as nikpenilai,p.nama as penilai,nilai')

					 ->from('tb_evaluasi as e')

					 ->join('tb_peserta as p','p.userid=e.penilai')

					 ->where($where);

		$query2=$this->db->get()->result();

        return $query2;

    }



    function getdetailkinerja($where=null){

        $this->db->select ('p.userid as idpenilai,p.nopeg as nikpenilai,p.nama as penilai,e.id as idevaluasi,e.nilai,j.bobot,

                            s.soal,j.jawaban,j.inisial,j.nilai as nilaijawab,e.bulan,e.tahun')

					 ->from('tb_jawaban as j')

                     ->join('tb_evaluasi as e','e.id=j.evaluasi')

                     ->join('tb_soal as s','s.id=j.soal')

					 ->join('tb_peserta as p','p.userid=e.penilai')

					 ->where($where)

                     ->order_by('e.bulan');

		$query2=$this->db->get()->result();

        return $query2;

    }



    function rerataevaluasi($where=null){

        $this->db->select('e.nilai,p.kode')

                 ->from('tb_evaluasi as e')

                 ->join('tb_user as u','u.id=e.peserta')

                 ->join('tb_perusahaan as p','p.id=u.company')

                 ->where($where);

        $query=$this->db->get()->result();

        return $query;

    }



    function getskormean($where=null){

        $this->db->select('AVG(nilai) as mean')

                 ->from('tb_evaluasi')

                 ->where($where);

        $query=$this->db->get()->row()->mean;

        return $query;

        //return $this->db->last_query();;

    }



}