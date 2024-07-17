<?php if(!defined('BASEPATH')) exit('No direct script access allowed');




if (!function_exists('hashme')){

    function hashme($keys){
       return password_hash($keys,PASSWORD_BCRYPT);
    }

}

if(!function_exists('resetme')){
    function resetme(){
        $defaultpas='12345';
        return password_hash($defaultpas,PASSWORD_BCRYPT);
     }
}

if(!function_exists('noakses')){
    function noakses(){
        $CI = & get_instance();
      $CI->load->view('page/noakses');
     }
}

?>
