<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/ 
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Muka';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['dashboard'] = 'Muka/dashboard';
$route['userdashboard'] = 'Muka/userdashboard';
$route['admindashboard'] = 'Muka/admindashboard';
$route['adminunitdashboard'] = 'Muka/adminunitdashboard';
$route['perusahaan'] = 'Perusahaan';

//Login
$route['login']='Muka/login';
$route['keluar']='Muka/logout'; 

///user management
$route['adduser'] = "User/adduser";
$route['edituser'] = "User/edituser";
$route['resetuser'] = "User/resetuser";
$route['profil']="User/profil";
$route['changepass']="User/changepass";
$route['tambahpeserta']="User/tambahpeserta";
$route['daftar_user'] = "User/userpage";

//peserta/karyawan management
$route['listpeserta'] = "User/peserta";
$route['importpeserta'] = "User/importpeserta";
$route['searchpeserta'] = "User/getuserpeserta";
$route['editpeserta'] = "User/editpeserta";
$route['updateprofil'] = "User/editpeserta2";
$route['pesertacompany']="User/getpesertacompany";

//company management
$route['addcomp'] = "Perusahaan/addcompany";
$route['searchcomp'] = "Perusahaan/searchcompany";
$route['searchcomp2'] = "Perusahaan/searchcompany2";
$route['editcomp'] = "Perusahaan/editcompany";

//project
$route['event'] = "Muka/eventEvaluasi";
$route['project'] = "Project";
$route['addpro'] = "Project/addproject";
$route['searchpro'] = "Project/searchproject";
$route['editpro'] = "Project/editproject";
$route['listpro'] = "Project/listproject";
$route['projectcompany'] = "Project/projectcompany";

//relasi
$route['relasi'] = "User/daftar_relasi";
$route['searchpesertacompany'] = "User/searchpesertacompany";
$route['searchpesertacompany2'] = "User/searchpesertacompany2";
$route['addatasan']='User/addatasan';
$route['searchatasan'] = "User/searchatasan";
$route['editatasan']='User/editatasan';
$route['getrelasi']='User/getrelasi';
$route['getrelasi2']='User/getrelasi2';
$route['pilihobyek']='User/pilihobyekpenilaian';
$route['addrelasi']='User/addrelasi';

//bank soal
$route['banksoal'] = "Question/listsoal";
$route['addsoal'] = "Question/addsoal";
$route['addjawab/(:any)'] = "Question/addjawab/$1";
$route['getdesk'] = "Question/getdesk";
///
$route['searchjawab'] = "Question/searchjawab";
$route['addjawaban']= "Question/addjawaban";

//value 
$route['value'] = "Value/listvalue";
$route['addval'] = "Value/addvalue";
$route['searchval'] = "Value/searchvalue";
$route['editval'] = "Value/editvalue";


///tes
$route['praevaluasi/(:any)']="Tes/praevaluasi/$1";
$route['evaluasi']="Tes/evaluasipeserta";
$route['pilihtarget/(:num)/(:num)']="Tes/pilihtarget/$1/$2";
//////////// LAMA
$route['starttes/(:num)/(:num)/(:num)']="Tes/start/$1/$2/$3";
$route['loadsoal']="Tes/loadsoal";
$route['submitevaluasi']="Tes/simpanevaluasi";
/////////// END LAMA
$route['startevaluasi/(:any)']="Tes/goevaluasi/$1";
$route['setsoal']="Tes/getsoal"; 
$route['getsoal/(:any)']="Tes/getsoal/$1";
$route['preparetes']="Tes/prepare";
$route['submitsurvey']="Tes/simpansurvey";
$route['final']="Tes/simpanfinal";
$route['kinerjaperiode']="Tes/periodekinerja";

///// JIKA JENISNYA SELAIN NPS
$route['startkinerja']="Tes/preparekinerjates";
$route['kinerjasubmit']="Tes/kinerjasubmit";
$route['daftar_kinerja']="Tes/daftarkinerja";
//// Peserta to project
$route['listregis']="Project/daftarregistrasi";
$route['registrasi']="Project/registrasipeserta";
$route['peserta']="User/getpeserta";
$route['addregis']="Project/addregistrasi";


///RESULT

$route['result']="Result";
$route['pribadi']="Result/pribadi";
$route['API/datagraph']="Result/datagraph";
$route['API/dataproporsi']="Result/dataproporsi"; 
$route['API/npsgraph']="Result/datanps";
$route['API/detailobjekdinilai']="Result/detailobjek";
$route['API/detailnilai']="Result/getdetail";
$route['appkinerja']="Tes/approvekinerja";
$route['kalkulasi']="Kalkulasi/kalkulasi_hasil";//"Result/kalkulasidetail";
$route['cekpengisian']="Result/cekpengisian";
$route['cekdetailpengisian']="result/cekdetailpengisian";
$route['rekap']="Muka/admindashboard";
$route['cekprogresisi']="Tes/cekpengisianpeserta";
$route['cekpengisianpenilai']="Result/cekpengisian_penilai";
$route['komparasikinerja']="Result/komparasismkbk2021";
$route['monitorpengisian']="Tes/monitoringpengisian";
$route['nilaievaluasi']="Result/hasil_kriteria";
//FILE
$route['addfilekinerja']="Tes/addkinerjafile";

//DASHBOARD
$route['demografik']="Muka/demografik";
$route['API/demografik']="Result/demografik";
$route['API/proporsi']="Result/proporsinilai";