<!-- CSS tambahan -->

<link href="<?=base_url('assets/survey-pack/')?>defaultV2.min.css" type="text/css" rel="stylesheet"/>

<link href="<?=base_url('assets/survey-pack/')?>survey.css" type="text/css" rel="stylesheet"/>

<input type="hidden" id="stateval" value="<?=$evaluasi[0]->status?>">

<div class="container-fluid">

     <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

           

                <div class="col-6">

                <h1 class="h3 mb-2 text-gray-800">Lembar Penilaian <?=$evaluasi[0]->namajenis?></h1>

                </div>

        </div>

        

        <!---- CONTENT --> 

        <div class="row">

                

       

                

                <!---- Panduan Pengerjaan -->

                <div class="col-md-12 col-sm-12">

                        <div class="card shadow mb-4">

                                <!-- Card Header - Accordion -->

                                <a href="#info" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">

                                    <h6 class="m-0 font-weight-bold text-primary">INFORMASI</h6>

                                </a>

                                <!-- Card Content - Collapse -->

                                <div class="collapse" id="info" >

                                    <div class="card-body">

                                  

                                <p class="card-text">Kami mohon partisipasi Anda untuk melakukan penilaian <?=$evaluasi[0]->namajenis?>. Penilaian <?=$evaluasi[0]->namajenis?> yang Anda lakukan menggambarkan persepsi Anda terhadap kesesuaian tata nilai <?=$evaluasi[0]->namajenis?> dari objek penilaian.

				<hr/>

				Penilaian ini menggunakan metode <?=$evaluasi[0]->tipe_nilai?></p>

                                    

                                    </div>

                                </div>

                        </div>

                </div>

                <div class="col-md-12 col-sm-12">

                        <div class="card shadow mb-4">

                                <!-- Card Header - Accordion -->

                                <a href="#petunjuk" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">

                                    <h6 class="m-0 font-weight-bold text-primary">PANDUAN PENGISIAN </h6>

                                </a>

                                <!-- Card Content - Collapse -->

                                <div class="collapse show" id="petunjuk" >

                                    <div class="card-body">



                                    <?php 

                                

                                    ?>

                                    <table class="table table-bordered mb-3">

                                        <tbody>

                                        <?php if($evaluasi[0]->jenis =="1" || $evaluasi[0]->jenis =="2"){

                                                ?>

                                                <tr>

                                                        <td style="width:20%" class="nilai_pengukuran_pr">10-9</td>

                                                        <td class="nilai_pengukuran_pr">Saya menganggap dia baik/sangat baik dalam mengamalkan <?=$evaluasi[0]->namajenis?> dan saya bersedia menyampaikan kepada orang lain mengenai kebaikannya. (Promotor)</td>

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_pa">8-7</td>

                                                        <td class="nilai_pengukuran_pa">Saya menganggap bahwa dia cukup dalam mengamalkan <?=$evaluasi[0]->namajenis?>, namun saya belum mau menyampaikan kebaikan tersebut kepada orang lain. (Pasif)</td>

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">6-1</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia kurang/buruk dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (Detractor)</td>

                                                </tr>

                                               

                                                <?php 

                                                 }

                                                if($evaluasi[0]->jenis =="4"){

                                                ?>

                                                 <tr>

                                                        <td colspan='2' class="nilai_pengukuran_de text-white" style="color: black">Opsi pengukuran lain</td>

                                                       

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">tidak</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia kurang/buruk dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (promotor)</td>

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">ya</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia baik/sangat baik dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (detractor)</td>

                                                </tr>

                                                <?php

                                                }

                                                if($evaluasi[0]->jenis =="3"){

                                                ?>

                                                <tr>

                                                 <td colspan='2' class="nilai_pengukuran_de text-white" style="color: black">Opsi pengukuran lain</td>

                                                       

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">tidak dilakukan</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia kurang/buruk dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (promotor)</td>

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">Tidak Konsisten dilakukan</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia cukup dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (passive)</td>

                                                </tr>

                                                <tr>

                                                        <td class="nilai_pengukuran_de">Konsisten dilakukan</td>

                                                        <td class="nilai_pengukuran_de">Saya menganggap dia baik/sangat baik dalam mengamalkan <?=$evaluasi[0]->namajenis?>, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (detractor)</td>

                                                </tr>



                                                <?php

                                                 }

                                                ?>

                                               

                                                

                                        </tbody>

                                     </table>

                                    </div>

                                </div>

                        </div>

                </div>

                <!---- End Panduan Pengerjaan -->

                <!---- TES FORM -->

        <div class="col-md-12 col-sm-12">

                <form   id="fsubmit" enctype="multipart/form-data">

                        <div class="col-md-12 col-sm-12">

                                <div class="card bg-light  shadow mb-4">

                                <input type="hidden" id="eval" name="eval" value=<?=$this->encryption->encrypt($evaluasi[0]->id)?>>

                                <input type="hidden" id="target" name="target" value=<?=$this->encryption->encrypt($evaluasi[0]->id_peserta)?>>

                                <input type="hidden" id="jsoal" name="jsoal" value=<?=count((array)$soal)?>>

                                

                                <div class="question bg-white p-3 border-bottom">

                        <div class="form-group">

                            <div class="row">

                                    

                                    <?php

                                    

                                        $isoal=1;

                                        $ijawab=0; 

                                       

                                       

                                        foreach($soal as $s){

                                                $text="";

                                                switch ($evaluasi[0]->jenis){

                                                        case '4':

                                                                $text=$isoal." . Apakah yang bersangkutan mengenakan/membawa <strong>".$s->soal. "</strong> dilingkungan kerjanya ?";

                                                        break;

                                                        default :

                                                        $text=$isoal." . Apakah yang bersangkutan melakukan <strong>".$s->soal. "</strong> dilingkungan kerjanya ?";

                                                        break;

                                                }

                                                if($evaluasi[0]->jenis =="4"){

                                                        

                                                }

                                                

                                     ?>

                                                <div class="col-12 col-md-12 my-2">

                                                        <div class="card px-2">

                                                                <div class="card-body style='width:100%'">

                                                                        <h5>

                                                                                

                                                                        <?=$text?>

                                                                        </h5>

                                                                     

                                                                        <p><?php

                                                                        if($s->deskripsi !='Atribut Planter'){

                                                                                echo   $s->deskripsi;

                                                                        }

                                                                      ?></p>

                                                                        <input type="hidden" name="nsoal[]" value="<?=$s->id?>">

                                                                        <div class="row">

                                                                                <div class="col-md-12">

                                                                                <div class="form-group">

                                                                                        

                                                                                <?php

                                                                              

                                                                                //echo $jawab[$ijawab]->jawaban;   

                                                                                switch($s->formula){

                                                                                        case 'nps2':

                                                                                                $npsopsi=array("10"=>"ya","1"=>"tidak");

                                                                                             

                                                                                                        foreach($npsopsi as $key=>$opsi){

                                                                                                                ?>

                                                                                                        <group class="inline-radio mx-2">

                                                                                                                <label class="radio-inline">

                                                                                                                <?php 

                                                                                                                        if(isset($jawab[$ijawab]) && $jawab[$ijawab]->soal == $s->id){

                                                                                                                        if($key == $jawab[$ijawab]->jawaban){

                                                                                                                                ?>

                                                                                                                                        <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> checked type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>      

                                                                                                                                <?php

                                                                                                                        }else{

                                                                                                                                ?>

                                                                                                                                        <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>

                                                                                                                                <?php

                                                                                                                        }

                                                                                                                        ?> 

                                                                                                                        

                                                                                                                        

                                                                                                                <?php        

                                                                                                                }else{

                                                                                                                ?>

                                                                                                                <input style="height:20px; width:20px; vertical-align: middle;" type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>

                                                                                                                <?php

                                                                                                                }

        

                                                                                                                ?>

                                                                                                        

                                                                                                                </label>

                                                                                                        </group>

                                                                                                        <?php

                                                                                                        }

                                                                                                  

                                                                                        break;

                                                                                        case 'nps3':

                                                                                                $npsopsi=array("1"=>"tidak dijalankan",7=>"tidak konsisten",10=>"dijalankan dengan konsisten");

                                                                                                foreach($npsopsi as $key=>$opsi){

                                                                                                        ?>

                                                                                                        <group class="inline-radio mx-2">

                                                                                                                <label class="radio-inline">

                                                                                                                <?php 

                                                                                                                        if(isset($jawab[$ijawab]) && $jawab[$ijawab]->soal == $s->id){

                                                                                                                        if($key == $jawab[$ijawab]->jawaban){

                                                                                                                                ?>

                                                                                                                                        <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> checked type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>      

                                                                                                                                <?php

                                                                                                                        }else{

                                                                                                                                ?>

                                                                                                                                        <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>

                                                                                                                                <?php

                                                                                                                        }

                                                                                                                        ?> 

                                                                                                                        

                                                                                                                        

                                                                                                                <?php        

                                                                                                                }else{

                                                                                                                ?>

                                                                                                                <input style="height:20px; width:20px; vertical-align: middle;" type="radio" name="answer[<?=$s->id?>]" value="<?=$key?>" id="<?="s".$s->id."r".$key?>"> <small class="text-muted"><?=$opsi?></small>

                                                                                                                <?php

                                                                                                                }

        

                                                                                                                ?>

                                                                                                        

                                                                                                                </label>

                                                                                                        </group>

                                                                                                        <?php

                                                                                                }

                                                                                        break;

                                                                                        default :

                                                                                                for($ri = 1 ; $ri <=10 ;$ri++){

                                                                                                ?>

                                                                                                <group class="inline-radio mx-2">

                                                                                                        <label class="radio-inline">

                                                                                                        <?php 

                                                                                                                if(isset($jawab[$ijawab]) && $jawab[$ijawab]->soal == $s->id){

                                                                                                                if($ri == $jawab[$ijawab]->jawaban){

                                                                                                                        ?>

                                                                                                                                <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> checked type="radio" name="answer[<?=$s->id?>]" value="<?=$ri?>" id="<?="s".$s->id."r".$ri?>"> <small class="text-muted"><?=$ri?></small>      

                                                                                                                        <?php

                                                                                                                }else{

                                                                                                                        ?>

                                                                                                                                <input <?=(status_evaluasi($evaluasi[0]->id)=='final' || $evaluasi[0]->id=="nonaktif") ? 'disabled' : '' ?> type="radio" name="answer[<?=$s->id?>]" value="<?=$ri?>" id="<?="s".$s->id."r".$ri?>"> <small class="text-muted"><?=$ri?></small>

                                                                                                                        <?php

                                                                                                                }

                                                                                                                ?> 

                                                                                                                

                                                                                                                

                                                                                                        <?php        

                                                                                                        }else{

                                                                                                        ?>

                                                                                                        <input style="height:20px; width:20px; vertical-align: middle;" type="radio" name="answer[<?=$s->id?>]" value="<?=$ri?>" id="<?="s".$s->id."r".$ri?>"> <small class="text-muted"><?=$ri?></small>

                                                                                                        <?php

                                                                                                        }



                                                                                                        ?>

                                                                                                

                                                                                                        </label>

                                                                                                </group>

                                                                                                <?php

                                                                                                }

                                                                                        break;



                                                                                }

                                                                                ?>

                                                                                </div>

                                                                                </div>

                                                                        </div>

                                                                </div>

                                                        </div>

                                                </div>

                                     <?php

                                        $ijawab ++;

                                        $isoal++;

                                        }



                                    ?>

                                <hr>

                            </div>

                        </div>

                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                       <?php  

                     

                       if(status_evaluasi($evaluasi[0]->id) =="final" || status_evaluasi($evaluasi[0]->id) == "nonaktif"){



                       }else{

                          ?>

                           <input type="submit" id="btsubmit" value="Simpan Hasil" class="btn btn-primary">

                           <input type="submit" id="btfinal"  value="Simpan Final" class="btn btn-success">

                          <?php

                       }

                       ?>

                </form>

        </div> 

                   </div>

                </div>

                <!---- .END TEST FORM --->

              

        </div>

        <!----- . End CONTENT --->



</div>

<div class="modal" id="mdinfo" tabindex="-1" role="dialog">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header bg-success" style="background-color:#95afc0">

        <h5 class="modal-title" style="color:#130f40">INFORMASI</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

       <p>Evaluasi ini telah anda lakukan dan tersimpan <strong>FINAL</strong>.</p>

       <p>Anda Hanya dapat melihat evaluasi yang telah anda simpan final.</p>

      </div> 

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="agreement" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color:#f9ca24" >

        <h5 class="modal-title" id="exampleModalLongTitle" style="color:#535c68">Pernyataan</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="text-center">

            <p> Dengan ini saya menyatakan bahwa saya bersungguh-sungguh dan sadar dalam memberikan data evaluasi.<br></p>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-success btagree" data-dismiss="modal">ya</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">batal</button>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="simpankonfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">

    <div class="modal-content">

         

    <div class="modal-header" style="background-color:#22a6b3">

        <h5 class="modal-title" style="color:white">INFORMASI</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div class="text-center">

            <p> <div id="isikonfirm"></div><br></p>

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-success btoksimpan" data-dismiss="modal">ya</button>

      </div>

    </div>

  </div>

</div>



<script>

        $(document).ready(function() {

                

               var stat_eval=$("#stateval").val();

             

              if(stat_eval =="final"){

                $("#mdinfo").modal('show');

              }else{

                $("#mdinfo").modal('hide');

              }

                

               var jsoal= parseInt($('#jsoal').val());

               var jans = parseInt(isokfinal());



               if(jans >= jsoal){

                        $('#btfinal').show();

               }else{

                        $('#btfinal').hide();   

               }

                

              $('#btsubmit').on('click',function(e){

                var simpan=submit();

               

                if(simpan=="ok"){

                        $('#simpankonfirm').modal('show');

                        var info="<h6>Anda telah menyimpan hasil penilaian ini.</h6>";

                        $('#isikonfirm').html(info);

                }else{

                        alert('proses simpan gagal');

                }



                e.preventDefault();

              }) 



              $("#fsubmit").change(function() {

                      var jselect=0;

                        $('input[type=radio]').each(function() { 

                                if( $(this).is(':checked') ) {

                                        jselect ++;

                                }  

                        })

                        if(jsoal == jselect){

                                $('#btfinal').show();

                        }else{

                                $('#btfinal').hide();

                        }

                

        })



        $('.btagree').on('click',function(e){

               submit();

                var finale=final();

                if(finale=="ok"){

                        $('#simpankonfirm').modal('show');

                        var info="<h4>Anda telah menyimpan final hasil penilaian ini.</h4>";

                        $('#isikonfirm').html(info);

                }else{

                        alert('proses simpan gagal');

                }

                //alert("anda telah menyimpan final penilaian ini");

                //location.reload();

        })



        $('.btoksimpan').on('click',function(){

                location.reload();

        })



        $('#btfinal').on('click',function(e){

              $('#agreement').modal('show');

               e.preventDefault();

         })

              

              function submit(){

                var dataed=$('#fsubmit').serializeArray();

                var  urlbase=base_url + 'submitsurvey' ;

                

                $.ajax({

                url  : urlbase,

                type : 'POST',

                data : dataed,

                dataType: 'json',

		success: function(result){

                        var r=JSON.parse(result);  

		}

                })

                return "ok";

              }



             



              function final(){

                var dataed=$('#fsubmit').serializeArray();

                var  urlbase=base_url + 'final' ;

                $.ajax({

                url  : urlbase,

                type : 'POST',

                data : dataed,

                dataType: 'json',

		success: function(result){

                

				}

                })

                return "ok";

              }



              function isokfinal(){

                return $('input:radio:checked').length;

              }



        })

</script>

<script>

   

</script>