<?php if(!defined('BASEPATH')) exit('No direct script access allowed');







class Master_model extends CI_Model



{

 

    //PERUSAHAAN

   function getperusahaan($where=null){

       $this->db->select('*')

                ->from('tb_perusahaan')

                ->where($where);

        $query=$this->db->get();

        if($this->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

        

   }



   function getallperusahaan(){

    $this->db->select('*')
    ->from('tb_perusahaan')
    ->order_by('nama','ASC');

    $query=$this->db->get();

    if($this->db->count_all_results() > 0){

    return $query->result();

    }else{

    return array();

}

   }



   function searchperusahaan($where=null){

    $this->db->select('*')

             ->from('tb_perusahaan')

             ->or_where($where);

     $query=$this->db->get();

     if($this->db->count_all_results() > 0){

         return $query->result();

     }else{

         return array();

     }

     

}



   function addcompany(){
       
       // return $res;
        //sudah terdaftar
        
        $ada=array("kode"=>$_POST['kode']);
  
        if(count((array)$this->getperusahaan($ada)) > 0){

            $pesan= "Data ".$_POST['namaedit']." atau kode ".$_POST['kodeedit']." sudah digunakan.<br> Silahkan gunakan perusahaan dan kode baru";

            $res=array('pesan'=>'data sudah ada','res'=>'gagal');

            $this->session->set_flashdata('error', $pesan);

        }else{

            $datainsert=array("nama"=>$_POST['nama'],

                         "kode"=>$_POST['kode'],

                         "alamat"=>$_POST['alamat'],

                         "date_create"=>date('Y-m-d H:i:s'),

                         "is_aktif"=>"aktif");

            $ins=$this->db->insert('tb_perusahaan',$datainsert);

            if($ins){

                $pesan= "Registrasi ".$_POST['nama']." berhasil dilakukan";

                $res=array('pesan'=>$pesan,'res'=>'ok');

                $this->session->set_flashdata('success', $pesan);

            }else{

                $pesan= "Registrasi ".$_POST['nama']." gagal dilakukan pada database";

                $res=array('pesan'=>$pesan,'res'=>'gagal');

                $this->session->set_flashdata('error', $pesan);

            }

        

        }

        
          /**/ 
        return $ada;       

   }



   function editcompany(){

        //sudah terdaftar

            $dataupdate=array("nama"=>$_POST['namaedit'],

                         "alamat"=>$_POST['alamatedit'],

                         "is_aktif"=>$_POST['statusedit']);

            $this->db->where('id',$this->encryption->decrypt($_POST['token']));

            $ins=$this->db->update('tb_perusahaan',$dataupdate);

            if($ins){

                $pesan= "Pengubahan data ".$_POST['namaedit']." berhasil dilakukan";

                $res=array('pesan'=>$pesan,'res'=>'ok');

                $this->session->set_flashdata('success', $pesan);

            }else{

                $pesan= "Pengubahan data ".$_POST['namaedit']." gagal dilakukan pada database";

                $res=array('pesan'=>$pesan,'res'=>'gagal');

                $this->session->set_flashdata('error', $pesan);

            }

        return $res;  

   }





////// PRJOECT





function getprojectall(){

        $this->db->select('*')

                 ->from('tb_project as p')

                 ->order_by('p.date_start');

        $query=$this->db->get();

        if($this->db->count_all_results() >0 ){

            return $query->result();

        }else{

            return array();

        }

}

function getproject($where=null){

    $this->db->select('*')

             ->from('tb_project as p')

             ->where($where)

             ->order_by('p.date_start');

    $query=$this->db->get();

    if($this->db->count_all_results() > 0 ){

        return $query->result();

    }else{

        return array();

    }

}

function addproject(){

    //sudah terdaftar

    $ada=array("p.nama"=>$_POST['nama']);

    if(count((array)$this->getproject($ada)) > 0){

        $pesan= "Data project ".$_POST['nama']." di ".$this->getproject($ada)->company." sudah digunakan.<br> Silahkan gunakan perusahaan dan project baru";

        $res=array('pesan'=>'data sudah ada','res'=>'gagal');

        $this->session->set_flashdata('error', $pesan);

    }else{

        $datainsert=array("nama"=>$_POST['nama'],

                     "deskripsi"=>$_POST['deskripsi'],

                     "date_start"=>date('Y-m-d H:i:s',strtotime($_POST['start'])),

                     "date_end"=>date('Y-m-d H:i:s',strtotime($_POST['end'])),

                     "date_create"=>date('Y-m-d H:i:s'),

                     "status"=>$_POST['status']);

        $ins=$this->db->insert('tb_project',$datainsert);

        if($ins){

            $pesan= "Registrasi project ".$_POST['nama']." berhasil dilakukan";

            $res=array('pesan'=>$pesan,'res'=>'ok');

            $this->session->set_flashdata('success', $pesan);

        }else{

            $pesan= "Registrasi project ".$_POST['nama']." gagal dilakukan pada database";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('error', $pesan);

        }

    

    }

    return $res;        

}

function editproject(){

    //sudah terdaftar

        $dataupdate=array("nama"=>$_POST['namaedit'],

                     "deskripsi"=>$_POST['deskripsiedit'],

                     "date_start"=>date('Y-m-d H:i:s',strtotime($_POST['startedit'])),

                     "date_end"=>date('Y-m-d H:i:s',strtotime($_POST['endedit'])),

                     "status"=>$_POST['statusedit']);

        $this->db->where('id',$this->encryption->decrypt($_POST['token']));

        $ins=$this->db->update('tb_project',$dataupdate);

        if($ins){

            $pesan= "Pengubahan data ".$_POST['namaedit']." berhasil dilakukan";

            $res=array('pesan'=>$pesan,'res'=>'ok');

            $this->session->set_flashdata('success', $pesan);

        }else{

            $pesan= "Pengubahan data ".$_POST['namaedit']." gagal dilakukan pada database";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('error', $pesan);

        }

    return $res;  

}

function getmemberproject(){



} 





///VALUE

function getvalueall(){

    $this->db->select('id, nama , bobot, date_create,is_aktif as status, deskripsi')

             ->from('tb_value')

             ->order_by('nama');

    $query=$this->db->get();

    if($this->db->count_all_results() > 0){

        return $query->result();

    }else{

        return array();

    }

}



function getvalue($where=null){

    $this->db->select('id, nama , bobot, date_create,is_aktif as status,deskripsi')

    ->from('tb_value')

    ->where($where)

    ->order_by('nama');

    $query=$this->db->get();

    if($this->db->count_all_results() > 0){

    return $query->result();

    }else{

    return array();

    }

}



function addvalue(){

    $ada=array("nama"=>$_POST['nama']);

    if(count((array)$this->getvalue($ada)) > 0){

        $pesan= "Data value ".$_POST['nama']."sudah ada.Silahkan gunakan perusahaan dan project baru";

        $res=array('pesan'=>'data sudah ada','res'=>'gagal');

        $this->session->set_flashdata('error', $pesan);

    }else{

        $datainsert=array("nama"=>strtolower($_POST['nama']),

                     "bobot"=>$_POST['bobot'],

                     "deskripsi"=>$_POST['desc'],

                     "date_create"=>date('Y-m-d H:i:s'),

                     "is_aktif"=>$_POST['status']);

        $ins=$this->db->insert('tb_value',$datainsert);

        if($ins){

            $pesan= "Registrasi value ".$_POST['nama']." berhasil dilakukan";

            $res=array('pesan'=>$pesan,'res'=>'ok');

            $this->session->set_flashdata('success', $pesan);

        }else{

            $pesan= "Registrasi value ".$_POST['nama']." gagal dilakukan pada database";

            $res=array('pesan'=>$pesan,'res'=>'gagal');

            $this->session->set_flashdata('error', $pesan);

        }

    }

    return $res;

}

function editvalue(){

    //sudah terdaftar

    $dataupdate=array("nama"=>$_POST['namaedit'],

    "bobot"=>$_POST['bobotedit'],

    "deskripsi"=>$_POST['descedit'],

    "is_aktif"=>$_POST['statusedit']);

    $this->db->where('id',$this->encryption->decrypt($_POST['token']));

    $upd=$this->db->update('tb_value',$dataupdate);

    if($upd){

        $pesan= "Pengubahan data ".$_POST['namaedit']." berhasil dilakukan";

        $res=array('pesan'=>$pesan,'res'=>'ok');

        $this->session->set_flashdata('success', $pesan);

    }else{

        $pesan= "Pengubahan data ".$_POST['namaedit']." gagal dilakukan pada database";

        $res=array('pesan'=>$pesan,'res'=>'gagal');

        $this->session->set_flashdata('error', $pesan);

    }

    return $res;  

}







/////Jenis Evaluasi

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







}