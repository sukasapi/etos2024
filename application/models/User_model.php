<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


 
class User_model extends CI_Model

{ 

    function getdatauser(){
        $this->db
                ->select('*')
                ->from('tb_user as u')
                ->order_by('u.status','DESC')
                ;
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    function getuserwhere($where=null){
        $this->db
                ->select('*')
                ->from('tb_user as u')
                ->where($where)
                ->order_by('u.status','DESC')
                ;
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    function getuser($data=null){
        $this->db->select('*, p.nama as namapeserta,cp.nama as namaperusahaan')
                ->from('tb_user as u')
                ->join('tb_peserta as p','p.userid=u.id')
                ->join('tb_perusahaan as cp','cp.id=p.perusahaan')
                ->where($data);
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->row();
        }else{
            return array();
        }

    }

    function searchuser($data=null){
        $this->db->select('u.id,u.uname,u.upass,u.isaktif,u.status,u.isonline,u.company as comp,
                           p.perusahaan as perusahaan,p.bagian as bagian, p.unitusaha as unitusaha,
                           p.batch,p.status_peserta as stat')
        ->from('tb_user as u')
        ->join('tb_peserta as p','p.userid=u.id','left')
        ->where($data);
      
        $query=$this->db->get();      
        if($query->num_rows() > 0){
            if(empty($query->row()->perusahaan)){
                if(empty($query->row()->comp)){
                    $perusahaan ="all";
                }else{
                    $perusahaan=$query->row()->comp;
                }
            }else{
                $perusahaan=$query->row()->perusahaan;
            }

            $res=array(
                "id"=>$this->encryption->encrypt($query->row()->id),
                "uname"=>$query->row()->uname,
                "status"=>$query->row()->status,
                "isaktif"=>$query->row()->isaktif,
                "token"=>$query->row()->upass,
                "perusahaan"=>$perusahaan
            );
            return $res;
        }else{
            return array();
        }
    }
    function searchpeserta($data=null){
        $this->db->select('u.id,u.uname,u.upass,u.isaktif,u.status,u.isonline,p.nama as npes,p.id as perusahaan, p.bagian, p.jabatan, c.nama as ncomp')
        ->from('tb_user as u')
        ->join('tb_peserta as p','p.userid=u.id','left')
        ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
        ->where($data);
      
        $query=$this->db->get();      
        if($query->num_rows() > 0){
            $res=array(
                "id"=>$this->encryption->encrypt($query->row()->id),
                "uname"=>$query->row()->uname,
                "nama"=>$query->row()->npes,
                "status"=>$query->row()->status,
                "isaktif"=>$query->row()->isaktif,
                "bagian"=>$query->row()->bagian,
                "jabatan"=>$query->row()->jabatan,
                "perusahaan"=>$query->row()->ncomp,
                "idcomp"=>$query->row()->perusahaan
            );
            return $res;
        }else{
            return array();
        }
    }
    function searchpeserta2($data=null){
        $this->db->select('u.id,u.uname,u.upass,u.isaktif,u.status,u.isonline,p.nama as npes,p.id as perusahaan, p.bagian, p.jabatan, c.nama as ncomp,p.jenis_asisten,p.komoditas,p.unitkerja')
        ->from('tb_user as u')
        ->join('tb_peserta as p','p.userid=u.id','left')
        ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
        ->where($data);
      
        $query=$this->db->get();      
        if($this->db->count_all_results() > 0){
             return $query->result();
        }else{
            return array(); 
        }
    }
    function ceksyarat($data=null){
        $this->db->select('*')
        ->from('tb_peserta as u')
        ->where($data);
        $query=$this->db->get();
      return $query->row();
}

    //CRUD USER
    function adduser(){
        $res=array();
        $data=array(
                    'uname'=>$_POST['username'],
                    'upass'=>hashme($_POST['userpass']),
                    'status'=>$_POST['status'],
                    'date_create'=>date('Y-m-d H:i:s'),
                    'isonline'=>'0',
                    'isaktif'=>'1',
                    'company'=>$_POST['perusahaan']
        );
        $datasearch=array( 'uname'=>$_POST['username'], 'status'=>$_POST['status']);
        if(count((array)$this->getuser($datasearch)) > 0){
            $res=array('pesan'=>'data sudah ada',
                        'res'=>'gagal');
                        $this->session->set_flashdata('error', $res['pesan']);
        }else{
            //// cek apakah user sudah ada
            $this->db->insert('tb_user',$data);
            $res=array('pesan'=>'berhasil menambah data user',
            'res'=>'ok');
            $this->session->set_flashdata('success', $res['pesan']);
        }
      
        return $res;
    }

    function edituser(){
        $res=array();
        $idedit=array('id'=>$this->encryption->decrypt($_POST['id']));
        $search=array('uname'=>$_POST['username'],'status'=>$_POST['status'],'isaktif'=>$_POST['aktif']);
        $data=array(
            'company'=>$_POST['perusahaanedit'],
            'status'=>$_POST['status'],
            'isaktif'=>$_POST['aktif']
        );

        if(count((array)$this->getuser($search)) > 0){
            $res=array('pesan'=>'data sudah dipakai',
            'res'=>'gagal');
            $this->session->set_flashdata('error', $res['pesan']);
        }else{

            $this->db->where($idedit);
            $query=$this->db->update('tb_user',$data);
            if($query){
                $res=array('pesan'=>'data telah terupdate',
            'res'=>'success');
            $this->session->set_flashdata('success', $res['pesan']);
            }else{
                $res=array('pesan'=>'data gagal terupdate',
                'res'=>'success');
                $this->session->set_flashdata('error', $this->db->error());
            }
        }

        return $res;
    }
 
    function resetuser(){
        $idedit=$this->encryption->decrypt($_POST['ediu']);
        $data=array('upass'=>resetme());
        $this->db->where('id',$idedit);
        $query=$this->db->update('tb_user',$data);
        if($query){
            $res=array('pesan'=>'berhasil mereset password user',
            'res'=>'ok');
            $this->session->set_flashdata('success', $res['pesan']);
        }else{
            $res=array('pesan'=>'data sudah ada',
                        'res'=>'gagal');
                        $this->session->set_flashdata('error', $res['pesan']);
        }
    }


    ///// DATA PESERTA //////
    function getpeserta($where=null){
        $this->db->select('p.id as uid,p.nama,p.bagian,p.jabatan,p.nopeg,p.userid,u.uname,c.nama as namaperusahaan,')
                 ->from('tb_peserta as p')
                 ->join('tb_user as u','u.uname=p.userid')
                 ->join('tb_perusahaan as c','c.id=p.perusahaan')
                 ->where($where)
                 ->order_by('p.nama')
                 ->group_by('c.nama');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
    function getpeserta2($where=null){
        $this->db->select('p.id as uid,p.nama,p.bagian,p.jabatan,p.nopeg,p.userid,p.status_peserta,p.unitkerja,
                           u.uname,c.nama as namaperusahaan,p.jenis_asisten,p.komoditas,p.unitkerja,p.batch')
                 ->from('tb_peserta as p')
                 ->join('tb_user as u','u.id=p.userid')
                 ->join('tb_perusahaan as c','c.id=p.perusahaan')
                 ->where($where)
                 ->order_by('p.nama')
                 ->group_by('c.nama');
        $query=$this->db->get();
        $syn=$this->db->last_query();
        //return $syn;
        if($this->db->count_all_results() > 0){
            return $query->row();
        }else{
            return array();
        }
    }

    function getallpeserta(){
        $this->db->select('p.id as uid,p.nama,p.bagian,p.date_create,p.jabatan,p.nopeg,u.id ,c.nama as perusahaan,p.batch,p.unitusaha,p.jenis_asisten,p.komoditas')
                 ->from('tb_peserta as p')
                 ->join('tb_user as u','u.id = p.userid','left')
                 ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
                 ->where('p.status_peserta','peserta')
                 ->order_by('p.perusahaan');
        $query=$this->db->get();
       
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    function getwherepeserta($where = null){
        $this->db->select('p.id as uid,p.nama,p.bagian,c.kode as kd,p.date_create,p.jabatan,p.nopeg,u.id ,
        c.nama as perusahaan, p.batch,p.unitusaha,p.jenis_asisten,p.komoditas')
        ->from('tb_peserta as p')
        ->join('tb_user as u','u.id = p.userid','left')
        ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
        ->where($where)
        ->order_by('p.nama');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
    function getwherepeserta2($where = null){
        $this->db->select('p.id as uid,p.nama,p.bagian,p.date_create,p.jabatan,p.nopeg,u.id ,c.nama as perusahaan,p.batch,p.unitusaha,p.jenis_asisten,p.komoditas')
        ->from('tb_peserta as p')
        ->join('tb_user as u','u.id = p.userid','left')
        ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
        ->where($where)
        ->order_by('p.id');
        $query=$this->db->get();
        $syn=$this->db->last_query();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    function getwherepesertabyperusahaan($where = null){
        $this->db->select('p.id as uid,p.nama,p.bagian,c.kode as kd,p.date_create,p.jabatan,p.nopeg,u.id ,
        c.nama as perusahaan, p.batch,p.unitusaha,p.jenis_asisten,p.komoditas')
        ->from('tb_peserta as p')
        ->join('tb_user as u','u.id = p.userid','left')
        ->join('tb_perusahaan as c','c.id=p.perusahaan','left')
        ->where($where)
        ->order_by('c.id','ASC');
        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    function getpesertanonregis($where = null){
        $this->db->select('p.userid as nopes,p.nopeg,p.nama, p.bagian, p.jabatan,')  
        ->from('tb_peserta as p')
        ->join('tb_project_peserta as pp','pp.peserta = p.userid','left')
        ->where('pp.peserta IS NULL')
        ->order_by('p.nama');

        $query=$this->db->get();
        if($this->db->count_all_results() > 0){
             return $query->result();
        }else{
         return array();
        }
    }
    function getpesertaregis($where = null){
          $this->db->select('p.userid as nopes,p.nopeg,p.nama, p.bagian, p.jabatan,')  
          ->from('tb_project_peserta as pp')
          ->join('tb_peserta as p','p.userid = pp.peserta','left')
          ->where($where)
          ->order_by('p.nama');

          $query=$this->db->get();

        if($this->db->count_all_results() > 0){
        return $query->result();
        }else{
        return array();
        }
    }

    function editpeserta($where = null){
        $where=array('userid'=>$this->encryption->decrypt($_POST['id']));
        $data=array("nama"=>$_POST['editnama'],
                    "bagian"=>$_POST['editbagian'],
                    "jabatan"=>$_POST['editjabatan'],
                    "perusahaan"=>$_POST['editperusahaan']);
        $this->db->where($where);
        $query=$this->db->update('tb_peserta',$data);
        if($query){
            $res=array('pesan'=>'data telah terupdate',
            'res'=>'success');
            $this->session->set_flashdata('success', $res['pesan']);
        }else{
            $res=array('pesan'=>'data gagal terupdate',
            'res'=>'error');
            $this->session->set_flashdata('error', $res['pesan']);
        }

        return $res;
        
    }
    function editpeserta2($data=null, $where = null){
        $this->db->where($where);
        $query=$this->db->update('tb_peserta',$data);
        if($query){
            $res=array('pesan'=>'data telah terupdate',
            'res'=>'success');
            $this->session->set_flashdata('success', $res['pesan']);
        }else{
            $res=array('pesan'=>'data gagal terupdate',
            'res'=>'error');
            $this->session->set_flashdata('error', $res['pesan']);
        }

        return $res;
        
    }
    


    ///login 
    function masuksistem(){
            $passoper=$_POST['upassword'];
            $searchuser=array('u.uname'=>$_POST['username'],'u.isaktif'=>1);
            $user=$this->searchuser($searchuser);
               ///dapatkan hashed
			$hashed=$user['token'];
			if (password_verify($passoper,$hashed)) {
                sessiongen($user); 
                return true;
			} else {
				$this->session->set_flashdata('error','login gagal');
                return false;
			}
            
    }

    function importdata(){
        $jdata=count((array($_POST['datax'])));
        $dataimport=$_POST['datax'];
        $datares=array();
        $pesan =array();
        $perusahaan =$_POST['company'];
        $msg="<ul>";
        foreach($dataimport as $dt){
            //cek jika data sudah ada
            $pesertacek=array("uname"=>$dt['nip']);
            $ada=$this->getuser($pesertacek);
            if(count((array)$ada)){
                $pesan[]=array("status"=>"gagal","pesan"=>"Data nomer pegawai ".$dt['nip']." sudah ada.<br>");
            }else{
                //input buat user dulu
                $datainsert=array(
                    'uname'=>$dt['nip'],
                    'upass'=>hashme('12345'),
                    'status'=>'user',
                    'date_create'=>date('Y-m-d H:i:s'),
                    'isonline'=>'0',
                    'isaktif'=>'1',
                    'company'=>$perusahaan);
                $addu=$this->db->insert('tb_user',$datainsert);
                if($addu){
                    $iduser=$this->db->insert_id();
                    $datainsert=array(
                                'userid'=>$iduser,
                                'nopeg'=>$dt['nip'],
                                'nama'=>$dt['nama'],
                                'bagian'=>$dt['asisten'],
                                'komoditas'=>$dt['komoditi'],
                                'jenis_asisten'=>$dt['asisten'],
                                'unitkerja'=>strtoupper($dt['unit']),
                                'date_create'=>date('Y-m-d H:i:s'),
                                'perusahaan'=>$perusahaan,
                                ///tambahan
                                'status_peserta'=>$dt['status'],
                                'batch'=>$dt['batch']
                            );
                    $addp=$this->db->insert('tb_peserta',$datainsert);
                    if($addp){
                            $msg.="<li>Data nomer pegawai ".$dt['nip']." berhasil dimasukkan.</li>";
                            $pesan[]=array("status"=>"ok","pesan"=>"Data nomer pegawai ".$dt['nip']." berhasil dimasukkan.<br>");
                      }else{
                            $msg.="<li>Data nomer pegawai ".$dt['nip']." gagal didaftarkan.</li>";
                            $pesan[]=array("status"=>"gagal","pesan"=>"Data nomer pegawai ".$dt['nip']." gagal didaftarkan.<br>");
                    }
                       
                }else{
                    $msg.="<li>registrasi user ".$dt['nip']." gagal dimasukkan.</li>";
                    $pesan[]=array("status"=>"gagal","pesan"=>"registrasi user ".$dt['nip']." gagal dimasukkan.<br>");
                }

                //peserta add
              
            }
           
        }
        $msg.="</ul>";
        $this->session->set_flashdata('info', $msg);
       return $pesan;
    }

    function changepass(){
        $idedit=$this->encryption->decrypt($_POST['ediu']);
        $newpass=hashme($_POST['newpass']);
        $edit=array('upass'=>$newpass);
        $where=array('id'=>$idedit);
        $this->db->where($where);
        $query = $this->db->update('tb_user',$edit);
      //  $res=$this->db->last_query();
       
        if($query){
            $res=array('pesan'=>'berhasil mengganti password user',
            'res'=>'ok');
            $this->session->set_flashdata('success', $res['pesan']);
        }else{
            $res=array('pesan'=>'penggantian password gagal. Silahkan hubungi admin',
                        'res'=>'gagal');
            $this->session->set_flashdata('error', $res['pesan']);
        }
        return $res;
    }

    function tb2user($data=null){
        $addu=$this->db->insert('tb_user',$data);
        if($addu){
            $iduser=$this->db->insert_id();
        }else{
            $iduser=0;
        }

        return $iduser;
    }
    function tb2peserta($data=null){
        $addu=$this->db->insert('tb_peserta',$data);
        if($addu){
            $iduser=$this->db->insert_id();
        }else{
            $iduser=0;
        }

        return $iduser;
    }
    
     function hardresetuser($idus=null){
        $idedit=$idus;
        $data=array('upass'=>resetme()); 
        $this->db->where('id',$idedit);
        $query=$this->db->update('tb_user',$data);
        if($query){
            $res=array('pesan'=>'berhasil mereset password user',
            'res'=>'ok');
            $this->session->set_flashdata('success', $res['pesan']);
        }else{
            $res=array('pesan'=>'data sudah ada',
                        'res'=>'gagal');
                        $this->session->set_flashdata('error', $res['pesan']);
        }
    }

    function evaluasiCek($param=null){
        $this->db->select("*")
                 ->from("tb_evaluasi")
                 ->where($param);
        $query=$this->db->get();
        return $query->result();//$this->db->count_all_results();
    }

}