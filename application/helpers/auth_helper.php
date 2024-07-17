<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('sessiongen')){

    function sessiongen($data=null){
        $CI =& get_instance(); 
        $CI->session->set_userdata('logged_in', $data);
    }
} 

if (!function_exists('issuper')){

    function issuper(){
     if($_SESSION['logged_in']['status']=="superadmin"){
         return true;
     }else{
         return false;
     }
    }
}
if (!function_exists('isadmin')){

    function isadmin(){
     if($_SESSION['logged_in']['status']=="admin"){
         return true;
     }else{
         return false;
     }
    }
}

if (!function_exists('bawahan_list')){
    function bawahan_list(){
       
        $CI =& get_instance();
        $uid=$CI->encryption->decrypt($_SESSION['logged_in']['id']);
        $where=array('a.leader'=>$uid,'a.status'=>'aktif');
        $CI->db->select('a.peserta')
               ->from('tb_atasan as a')
               ->where($where)
               ->join('tb_peserta as p','p.userid=a.peserta');
        $query=$CI->db->get();
        return $query->result();

    }
}

if (!function_exists('atasan_list')){
    function atasan_list(){
       
        $CI =& get_instance();
        $uid=$CI->encryption->decrypt($_SESSION['logged_in']['id']);
        $where=array('a.peserta'=>$uid,'a.status'=>'aktif');
        $CI->db->select('a.leader')
               ->from('tb_atasan as a')
               ->where($where)
               ->join('tb_peserta as p','p.userid=a.peserta');
        $query=$CI->db->get();
        return $query->result();

    }
}

if (!function_exists('mitra_list')){
    function mitra_list(){
       
        $CI =& get_instance();
        $uid=$CI->encryption->decrypt($_SESSION['logged_in']['id']);
        $where=array('m.mitra'=>$uid,'status'=>'aktif');
        
        $CI->db->select('m.peserta as mitra')
               ->from('tb_mitra as m')
               ->where($where)
               ->join('tb_peserta as p','p.userid=m.mitra');
        $query=$CI->db->get();
        return $query->result();

    }
}

if(!function_exists('compdet')){
    function compdet($compid=null){
        $CI =& get_instance();
        $where=array('icomp'=>$compid);
        $CI->db->select('*')
                ->from ('tb_perusahaan')
                ->where($where)
                ->limit(1);
        $query=$CI->db->get()->row;
        return $query;
    }   
}
if (!function_exists('logoout')){

    function logout(){
        session_destroy();
        redirect('muka');
    }
    
}

if (!function_exists('isonline')){

    function isonline(){
        if(empty($_SESSION['logged_in'])){
            return false;
        }else{
            return true;
        }
    }
    
}

if (!function_exists('isatasan')){
    function isatasan($ida=null,$idb=null){
        $CI =& get_instance();
        $where=array('a.peserta'=>$idb,'a.leader'=>$ida,'a.status'=>'aktif');
        $CI->db->select('COUNT(a.leader) as j')
               ->from('tb_atasan as a')
               ->where($where)
               ->join('tb_peserta as p','p.userid=a.peserta');
        $query=$CI->db->get()->row('j');
        if((int)$query > 0){
            return true;
        }else{
            return false;
        }
        
        //return $query->result();
    }
    if (!function_exists('ismitra')){
        function ismitra($ida=null,$idb=null){
            $CI =& get_instance();
            $where=array('m.peserta'=>$idb,'m.mitra'=>$ida,'m.status'=>'aktif');
            $CI->db->select('COUNT(m.mitra) as j')
                   ->from('tb_mitra as m')
                   ->where($where)
                   ->join('tb_peserta as p','p.userid=m.peserta');
            $query=$CI->db->get()->row('j');
            if((int)$query > 0){
                return true;
            }else{
                return false;
            }
            
            //return $query->result();
        }
    }
}


if (!function_exists('statpeserta')){
    function statpeserta($uid=null){
        $CI = & get_instance();
        $where=array('userid'=>$uid);
        $CI->db->select('status_peserta')
               ->from('tb_peserta')
               ->where($where)
               ->limit(1);
        $query=$CI->db->get();
        if($CI->db->count_all_results() > 0){
            return $query->row();
        }else{
            return array();
        }
    }
  
}


