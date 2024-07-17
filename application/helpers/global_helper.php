<?php if(!defined('BASEPATH')) exit('No direct script access allowed');









if (!function_exists('sitename')){



    function sitename(){

        return "Aplikasi Evaluasi Level 3 LPP";

    }



}

if (!function_exists('usertype')){



    function usertype(){

        return array('superadmin','admin','admin unit','user');

    }

   

  

}



if (!function_exists('perusahaan')){

    function perusahaan(){

        $CI = & get_instance();

        $CI->db->select('id,nama')

               ->from('tb_perusahaan')

               ->where('is_aktif','aktif')

               ->order_by('nama','ASC');

        $query=$CI->db->get();

        if($CI->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

  

}

if (!function_exists('sperusahaan')){

    function sperusahaan($where=null){

        $CI = & get_instance();

        $CI->db->select('id,nama')

               ->from('tb_perusahaan')

               ->where($where)

               ->order_by('nama','ASC');

        $query=$CI->db->get();

        if($CI->db->count_all_results() > 0){

            return $query->result();

        }else{

            return array();

        }

    }

  

}



if (!function_exists('countpeserta')){

    function countpeserta($where=null){

        $CI = & get_instance();

        $CI->db->select('count(*) as jumlah')

        ->from('tb_project_peserta as pp')

        ->join('tb_peserta as pe','pe.userid = pp.peserta')

        ->join('tb_project as pr','pr.id = pp.project') 

        ->join('tb_perusahaan as ph','ph.id = pe.perusahaan')

        ->where($where)

        ->order_by('pp.peserta','DESC');;

        $query=$CI->db->get();

        return $query->row();

    }

}





if (!function_exists('NPSjawab')){

    function NPSjawab(){

       for($i=1;$i <= 10;$i++){

          if($i <7 ){

            $list[]=array("ans"=>$i,"nilai"=>-1);

          }else if($i>6 && $i<9){

            $list[]=array("ans"=>$i,"nilai"=>0);

          }

          else{

            $list[]=array("ans"=>$i,"nilai"=>1);

          }

        

       }

     return $list;

    }

}



if (!function_exists('NPSscore')){

    function NPSscore($ans=null){

        $score=0;

      switch($ans){

        case '1':

            $score ='-1';

        break;

        case '2':

            $score ='-1';

        break;

        case '3':

            $score ='-1';

        break;

        case '4':

            $score ='-1';

        break;

        case '5':

            $score ='-1';

        break;

        case '6':

            $score ='-1';

        break;

        case '7':

            $score ='0';

        break;

        case '8':

            $score ='0';

        break;

        case '9':

            $score ='1';

        break;

        case '10':

            $score ='1';

        break;

        default:

            $score='0';

        break;



      }

        

       

     return $score;

    }

}



if(!function_exists('status_evaluasi')){

    function status_evaluasi($id){

        $CI = & get_instance();

        $CI->db->select('status')

                ->from('tb_evaluasi')

                ->where('id',$id);

        $query=$CI->db->get();

        if($CI->db->count_all_results() > 0){

            return $query->row()->status;

        } else{

            return "0";

        }

    }

}



if(!function_exists('jenis_evaluasi')){

    function jenis_evaluasi($id){

        $CI = & get_instance();

        $CI->db->select('je.tipe_nilai as tipe')

                ->from('tb_evaluasi as e')

                ->join('tb_jenis_evaluasi as je','je.id=jenis')

                ->where('e.id',$id);

        $query=$CI->db->get();

        if($CI->db->count_all_results() > 0){

            return $query->row()->tipe;

        } else{

            return "0";

        }

    }

}



if(!function_exists('nama_evaluasi')){

    function nama_evaluasi($id){

        $CI = & get_instance();

        $CI->db->select('nama')

                ->from('tb_jenis_evaluasi')

                ->where('id',$id);

        $query=$CI->db->get();

        if($CI->db->count_all_results() > 0){

            return $query->row()->nama;

        } else{

            return "";

        }

    }

}



if(!function_exists('jasisten')){

    function jasisten(){

        return array("tanaman","pabrik","lainnya");

    }

}



if(!function_exists('jkomoditas')){

    function jkomoditas(){

        return array("sawit","karet","gula","teh","kopi");

    }

}



if(!function_exists('juker')){

    function juker(){

        return array("tanaman","pabrik","lainnya");

    }

}



if(!function_exists('calcNPS')){

    function calcNPS($promoter,$passive,$detractor){

        $total = $promoter + $passive + $detractor;

        $totalp = isset($promoter)?$promoter/$total:0;

        $totald= isset($detractor)?$detractor/$total:0;

        $NPS=(($totalp) - ($totald))*100;

        return $NPS;

    }

}



if(!function_exists('hitungnps')){

    function hitungnps($datajawab=null){

	

        $promoter=0;

        $passive =0;

        $detractor = 0;

        $listjawab=array();

        $jawabtmp="";

        foreach($datajawab as $dj){

            if($jawabtmp != $dj->jawaban){

                $listjawab[$dj->tsoal][]=$dj->id;

                $jawabtmp=$dj->jawaban;

            }else{

                $listjawab[$dj->tsoal][]=$dj->id;

            }

            if($dj->nilai == 1){

                $promoter ++;

            }else if($dj->nilai == 0){

                $passive ++;

            }

            else{

                $detractor ++;

            }

            

        }

        $hasil=calcNPS($promoter,$passive,$detractor);

        $res=array("promoter"=>$promoter,"passive"=>$passive,"detractor"=>$detractor,"hasil"=>$hasil,"statistik"=>$listjawab);

        return $res;

    //$display[$d->jenis]=array("NPS"=>$hasil,"responden"=>count((array)));



}



if(!function_exists('npsevaluasi')){

    function npsevaluasi($data=null){

        $CI = & get_instance();

        $CI->db->select('*')

               ->from('tb_jawaban')

               ->where($data);

               $query=$CI->db->get();

               $syn=$CI->db->last_query();

        if($CI->db->count_all_results() > 0){

            $promoter=0;

            $passive=0;

            $detractor=0;

            $exe=$query->result();

            $jdata=count((array)$exe);

            $nilai=0;

            foreach ($exe as $q){

                $nilai += $q->nilai; 

            }

            $res=round(((int)$nilai/(int)$jdata)*100,2);

        }else{

            $res=0;

        }

        return $res;

    }

    //$display[$d->jenis]=array("NPS"=>$hasil,"responden"=>count((array)));



}





if (!function_exists('soaltext')){

    function soaltext($idsoal=null){

        $CI = & get_instance();

        $CI->db->select('soal')

        ->from('tb_soal')

        ->where("id",$idsoal);

        $query=$CI->db->get();

        return $query->row();

    }

}



if (!function_exists('bulanperiode')){

    function bulanpriode(){

        $month=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');

        return $month;        

    }

}



if(!function_exists('meankinerja')){

    function meankinerja($idus=null){

        $CI = & get_instance();

        $res=array();

        $where=array('peserta'=>$idus,'jenis'=>'5','status'=>'final');

        $CI->db->select('*')

               ->from('tb_evaluasi')

               ->where($where);

        $query=$CI->db->get()->result();

        if($CI->db->count_all_results() > 0){

            foreach($query as $j){

               $CI->db->select('*')

                      ->from('tb_jawaban')

                      ->where('evaluasi',$j->id);

                $query2=$CI->db->get()->result();

                $total=0;

                $jpar=0;

                foreach($query2 as $j2){

                    $jawab=explode(";",$j2->jawaban);

                    switch ($j2->inisial){

                        case 'P':

                            if($jawab[1]!=""){

                                $total +=$j2->nilai;

                                $jpar++;

                            }

                         

                        break;

                        case 'M':

                            if($jawab[1]!=""){

                                $total +=$j2->nilai;

                                $jpar++;

                            }

                        break;

                        case '0':

                            if($jawab[1]!=""){

                                $total +=$j2->nilai;

                                $jpar++;

                            }

                        break;

                    }

                }

                $mean=round((int)$total/(int)$jpar,2);

                $res[$j->peserta][]=array("total"=>$total,"parameter"=>$jpar,"rata"=>$mean);

            }

        }else{

            $res=array();

        }

        return $res; 

    }

   

}



if(!function_exists('calckinerja')){

    function calckinerja($jawab=null,$formula=null){

        $dataraw=explode(";",$jawab);

        $target=$dataraw[0];

        $real=$dataraw[1];



        switch($formula){

            case 'M':

                $x=($real/$target)*100;

                $skor=480-(4*(int)$x);

            break;

        }



        return $skor;





    }

}



if(!function_exists('bulancek')){

    function bulancek(){

        return array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');

    }

}



if(!function_exists('loggo')){

    function loggo($data=null){

        $CI = & get_instance();

        $query=$CI->db->insert('tb_log',$data);

        return $query;

    }

}



if(!function_exists('whoslogin')){

    function whoslogin($data=null){

        $CI = & get_instance();

        $CI->db->select('count(id) as online')

                ->from('tb_user')

                ->where('isonline','1');

        

        $query=$CI->db->get()->row()->online;

        return $query;

    }

}



if(!function_exists('recalcbobot')){



    function recalcbobot(){

        $CI = & get_instance();

        $where=array('jenis'=>'5',"status"=>"final");

		$CI->db->select('*')

				 ->from('tb_evaluasi')

				 ->where($where);

		$query=$CI->db->get()->result();

		$ok=0;

		$failed=0;

		foreach($query as $q){

			$where2=array("evaluasi"=>$q->id);

			$CI->db->select('id,nilai,inisial')

			->from('tb_jawaban')

			->where($where2);

  		 	$q2=$CI->db->get()->result();

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

				

				$CI->db->where('id',$n->id);

				$dtupd=array('bobot'=>$bobot);

				$CI->db->update('tb_jawaban',$dtupd);

			

			}

			

		}   			



		}

    }

}



if(!function_exists('updatekinerja')){



    function updatekinerja(){

        $CI = & get_instance();

        $where=array('jenis'=>'5','status'=>'final');

		$CI->db->select('*')

				 ->from('tb_evaluasi')

				 ->where($where);

		$query=$CI->db->get()->result();

		$ok=0;

		$failed=0;



		foreach($query as $q){



			$where2=array("evaluasi"=>$q->id);

			//updTE NILAI Evaluasi dari avg jawaban

			$CI->db->select('AVG(bobot) as nilai')

			->from('tb_jawaban')

			->where('evaluasi',$q->id);

			$query=$CI->db->get()->row();

			if($q->nilai > 100){

				$nilai=100;

			}else if($q->nilai<0){

				$nilai=0;

			}else{

				$nilai=$q->nilai;

			}

		

			///update data nilai ke 

				$CI->db->where('id',$q->id);

				$dtupd=array('nilai'=>$nilai);

				$update=$CI->db->update('tb_evaluasi',$dtupd);



				if($update){

					$ok++;

					}else{

					$failed++;

					}

		}

    }

}


if(!function_exists('cekakses')){
    function cekakses($perusahaan=null){
        $CI = & get_instance();
        $CI->db->select('start_akses,end_akses')
               ->from('tb_perusahaan')
               ->where('id',$perusahaan);
        $query=$CI->db->get();
        if($CI->db->count_all_results() > 0){
            return $query->result();
        }else{
            return array();
        }
    }
}

if (!function_exists('warna')){
    function warna($jenis=null,$nilai){
        $warna="";
        switch($jenis){
            case '1':
                if($nilai >=86){
                    //biru
                    $warna="#4e73df";
                }else if($nilai >= 66 && $nilai < 86){
                    //hijau
                    $warna="#1cc88a";
                }else if($nilai >=46 && $nilai < 66){
                    //kuning
                    $warna="#f6c23e";
                }else{
                    //merah
                    $warna="#e74a3b";
                }
            break;
            case '2':
                if($nilai >=91){
                    //biru
                    $warna="#4e73df";
                }else if($nilai >= 81 && $nilai < 91){
                    //hijau
                    $warna="#1cc88a";
                }else if($nilai >=61 && $nilai < 81){
                    //kuning
                    $warna="#f6c23e";
                }else{
                    //merah
                    $warna="#e74a3b";
                }
            break;
            case '3':
                if($nilai >=86){
                    //biru
                    $warna="#4e73df";
                }else if($nilai >= 66 && $nilai < 86){
                    //hijau
                    $warna="#1cc88a";
                }else if($nilai >=46 && $nilai < 66){
                    //kuning
                    $warna="#f6c23e";
                }else{
                    //merah
                    $warna="#e74a3b";
                }
            break;
            case '4':
                if($nilai >=86){
                    //biru
                    $warna="#4e73df";
                }else if($nilai >= 66 && $nilai < 86){
                    //hijau
                    $warna="#1cc88a";
                }else if($nilai >=46 && $nilai < 66){
                    //kuning
                    $warna="#f6c23e";
                }else{
                    //merah
                    $warna="#e74a3b";
                }
            break;
            case '5':
                if($nilai >=91){
                    //biru
                    $warna="#4e73df";
                }else if($nilai >= 81 && $nilai < 86){
                    //hijau
                    $warna="#1cc88a";
                }else if($nilai >=71 && $nilai < 81){
                    //kuning
                    $warna="#f6c23e";
                }else if($nilai >=51 && $nilai < 71){
                    //merah
                    $warna="#e74a3b";
                }else{
                    //hitam
                    $warna="#5a5c69";
                }
            break;
            default:
            if($nilai >=86){
                //biru
                $warna="#4e73df";
            }else if($nilai >= 66 && $nilai < 86){
                //hijau
                $warna="#1cc88a";
            }else if($nilai >=46 && $nilai < 66){
                //kuning
                $warna="#f6c23e";
            }else{
                //merah
                $warna="#e74a3b";
            }
            break;
        }

        return $warna;
    }
}


}
?>

