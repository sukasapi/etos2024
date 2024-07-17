<div class="container-fluid">
     <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <input type="hidden" id="stateval" value="<?=$evaluasi[0]->status?>">
                <div class="col-6">
                <h1 class="h3 mb-2 text-gray-800">Lembar Penilaian <?=$evaluasi[0]->namajenis?></h1>
                </div>
        </div>
        <?php 
            $idlogin=$this->encryption->decrypt($_SESSION['logged_in']['id']);
             $isatasan=isatasan($idlogin, $evaluasi[0]->id_peserta);
            if($idlogin != $evaluasi[0]->id_peserta && $isatasan==false){
               echo "<h1> Anda tidak punya hak akses</h1>";
            }else if($idlogin != $evaluasi[0]->id_peserta && $isatasan==true){
                $disable="disabled";
                if($evaluasi[0]->status=="aktif"){
                    echo "<div class='alert alertglobal alert-danger' role='alert'>Bawahan anda belum mengisi survei ini</div>";
                }
               
            }else{
                $disable="";
            }
        ?>
        <!---- Panduan Pengerjaan -->
        <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#info" class="d-block card-header bg-info py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-white">INFORMASI</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="info" >
                    <div class="card-body">
                        <p>Kami mohon partisipasi Anda untuk melakukan penilaian <?=$evaluasi[0]->namajenis?>. Penilaian <?=$evaluasi[0]->namajenis?> yang Anda lakukan menggambarkan persepsi Anda terhadap kesesuaian tata nilai <?=$evaluasi[0]->namajenis?> dari objek penilaian.
                    <hr/>
                    Penilaian ini menggunakan metode <?=$evaluasi[0]->tipe_nilai?></p>
                     </div>
                </div>
            </div>
        </div>
        <!---- End Panduan Pengerjaan -->
       
         <!---- Panduan Pengerjaan -->
         <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#petunjuk" class="d-block card-header bg-primary py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-white">PANDUAN PENGISIAN</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse show" id="petunjuk" >
                    <div class="card-body">
                        <table class="table table-bordered mb-3">
                           <tbody>
                                <tr>
                                    <td style="width:20%" class="nilai_pengukuran_pr">Formula P</td>
                                    <td class="nilai_pengukuran_pr">(realisasi /target)*100%</td>
                                </tr>
                                <tr>
                                    <td class="nilai_pengukuran_pa">Formula M</td>
                                    <td class="nilai_pengukuran_pa"><p>Y = 480 - 4 ( x )</p><p>*x = (realisasi / target) x 100</p></td>
                                </tr>
                                <tr> 
                                    <td class="nilai_pengukuran_de">0-1</td>
                                    <td class="nilai_pengukuran_de">tercapai 100%</td>
                                </tr>
                            </tbody>
                         </table>
                     </div>
                </div>
            </div>
        </div>
        <!---- End Panduan Pengerjaan -->

        <!----  SOAL ---> 
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form id="fsoal">
                    <input type="hidden" id="jsoal" name="jsoal" value=<?=count((array)$soal)?>>
                    <input type="hidden" id="eval" name="eval" value=<?=$this->encryption->encrypt($evaluasi[0]->id)?>>
                    <div class='alert alert-warning alertinfo' role='alert'>
                    <h4 class="alert-heading">Informasi!</h4>
                    <?php 
                        if($evaluasi[0]->status!='final'){
                    ?>
                    <p>Unggah bukti kinerja anda terlebih dahulu dalam satu file berformat <strong>.pdf</strong></p>
                    <?php }else{
                        echo " <p>Untuk membuka file bukti kinerja, silahkan tekan tombol dibawah</p>";
                    }
                        ?>
                    </div>
                    <?php 
                   
                    $enablefile=$evaluasi[0]->status=='aktif' ||$evaluasi[0]->status=='draft' ?"":"readonly";
                      if($isatasan==false && $idlogin=$evaluasi[0]->id_peserta){
                        ?><hr>
                        <?php 
                         if($evaluasi[0]->status=='final' ){
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 pb-4">
                                <h4>File Bukti Kinerja</h4>
                                <div class="form-group inline">
                                    <button class="btn btn-block btn-primary btfilebukti" > Lihat File Kinerja</button>
                                 </div>
                           </div>
                            <?php
                         }else{
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 pb-4">
                            <h4 class="text-center">Unggah File Bukti Kinerja</h4>
                                    <div class="form-group inline">
                                        <input type="hidden" id="kdeval" value=<?=$this->encryption->encrypt($evaluasi[0]->id)?>>
                                        <?php 
                                        echo $evaluasi[0]->filebukti;
                                            if($evaluasi[0]->filebukti!=""){
                                                ?>
                                                <input type="hidden" id="buktikinerja" value="<?=$evaluasi[0]->filebukti?>">
                                                <?php
                                            }else{
                                                ?>
                                                     <input type="hidden" id="buktikinerja">
                                                <?php
                                            }
                                        ?>
                                        <input <?=$enablefile?> type="file" class="form-control" name="filekinerja" id="filekinerja">
                                    </div>
                            </div>
                        <?php
                         }
                        ?>
                        <?php
                      }else{
                        ?>
                           <div class="col-md-12 col-sm-12 col-xs-12 pb-4">
                           <h4>File Bukti Kinerja</h4>
                                <div class="form-group inline">
                                    <button class="btn btn-block btn-primary btfilebukti" >Lihat File Kinerja</button>
                                 </div>
                           </div>
                        <?php
                           }
                       ?> 
                    <hr>
                    <h4 class="text-center">PARAMETER KPI</h4>
                    <?php 
                        $isoal=1;
                        $iurut=0;
                        $str="";
                       $final='';
                       $capaian="";
                       $target="";
                            foreach($soal as $s){
                                $tokensoal=$this->encryption->encrypt($s->id);
                                if(isset($jawab)){
                                    foreach($jawab as $j ){
                                        if($j->soal == $s->id){
                                           
                                            $vjawab =explode(';',$j->jawaban);
                                            $target =($j->soal == $s->id)?$vjawab[0]:"";
                                            $capaian =($j->soal == $s->id)?$vjawab[1]:"";
                                
                                        }
                                
                                        $jreal="value='".$capaian."'";
                                        $jtarget="value='".$target."'";
                        
                                        $final=($evaluasi[0]->status=='final' || $evaluasi[0]->id=="nonaktif") ? 'readonly' : '' ;
                                    }
                                 }else{
                                    $jreal='';
                                    $jtarget='';
                                    $final='';
                                 }
                               
                               

                                 
                    ?>
                          
                           <div class="row pb-4">
                               <div class="col-md-12 col-sm-12">
                                    <h5><?=$isoal.". ".$s->soal?></h5>
                                    <p><?=$s->deskripsi?></p>
                                    <input type="hidden" name="usoal[<?=$iurut?>]" value="<?=$tokensoal?>">
                                    <input type="hidden" name="formula[<?=$iurut?>]" value="<?=$s->formula?>">
                                   
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group inline">

                                                <?php 
                                                
                                                    switch ($s->formula){
                                                        
                                                        case 'P':
                                                            ?>
                                                            <label for="target[<?=$s->id?>]">Target (%)</label>
                                                            <input <?=$final?> <?=$disable?> type="number" <?=$jtarget?> class="form-control" name="target[<?=$iurut?>]" value="100">
                                                            <?php
                                                        break;
                                                        case 'M':
                                                            ?>
                                                            <label for="target[<?=$s->id?>]">Target</label>
                                                            <input <?=$final?> <?=$disable?> type="number" <?=$jtarget?> class="form-control" name="target[<?=$iurut?>]">
                                                            <?php
                                                        break;
                                                        case '0-1':
                                                            ?>
                                                            <label for="target[<?=$s->id?>]">Target</label>
                                                            <input <?=$final?> <?=$disable?> <?=$jtarget?> class="form-control" type="number" name="target[<?=$iurut?>]" >
                                                            <?php
                                                        break;
                                                    }
                                                ?>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12 pb-2">
                                            <div class="form-group inline">
                                            
                                                <?php 
                                            switch ($s->formula){

                                                case 'P':
                                                    ?>
                                                        <label for="realisasi[<?=$s->id?>]">Realisasi (%)</label>
                                                    <input <?=$final?> <?=$disable?> type="number" <?=$jreal?> class="form-control" name="realisasi[<?=$iurut?>]" >
                                                    <?php
                                                break;
                                                case 'M':
                                                    ?>
                                                        <label for="realisasi[<?=$s->id?>]">Realisasi</label>
                                                    <input <?=$final?> <?=$disable?> type="number" <?=$jreal?> class="form-control" name="realisasi[<?=$iurut?>]">
                                                    <?php
                                                break;
                                                case '0-1':
                                                    ?>
                                                    <label for="realisasi[<?=$s->id?>]">Realisasi</label>
                                                    <input <?=$final?>  <?=$disable?> <?=$jreal?> class="form-control" type="number" name="realisasi[<?=$iurut?>]" >
                                                    <?php
                                                break;
                                            }
                                        ?>
                                            </div>
                                        </div>
                                       
                                    </div>
                           
                               </div>

                           </div> 
                          
                           <?php
                           

                           $isoal++;
                           $iurut++;
                        }
                       
                        if($evaluasi[0]->status=='final'  && $isatasan){
                            
                            $iduserctt=$this->encryption->decrypt($_SESSION['logged_in']['id']);
                           // echo $iduserctt."-".$evaluasi[0]->catatan."-".$evaluasi[0]->catatan_dari;
                            if($evaluasi[0]->catatan =='' || $evaluasi[0]->catatan_dari=''){

                                echo "<div class='form-group text-center'>
                                <label for='catatan'><h4>Catatan Survei</h4></label>
                                <textarea class='form-control' name='catatan' rows='8' id='catatan' placeholder='Masukkan catatan untuk bawahan anda'></textarea>
                            </div>";
                            }else{
                                echo "<div class='form-group text-center'>
                                <label for='catatan'><h4>Catatan Survei</h4></label>
                                <textarea readonly class='form-control' name='catatan'  rows='8' id='catatan' placeholder='Masukkan catatan untuk bawahan anda'>".$evaluasi[0]->catatan."</textarea>
                            </div>";
                            }
                          
                        }else if($evaluasi[0]->status=='final') {
                            if($evaluasi[0]->catatan =='' || $evaluasi[0]->catatan_dari=''){

                            }else{
                                echo "<div class='form-group text-center'>
                                <label for='catatan'><h4>Catatan Survei</h4></label>
                                <textarea readonly class='form-control' name='catatan'  rows='8' id='catatan' placeholder='Masukkan catatan untuk bawahan anda'>".$evaluasi[0]->catatan."</textarea>
                            </div>";
                            }
                        }
                        
                    ?>
                    
                    <div class="card-footer">
                    <?php 
                   
                        if($evaluasi[0]->status=='final'  && $isatasan==true){
                            if($evaluasi[0]->catatan =="" && $evaluasi[0]->catatan_dari!=$iduserctt ){
                                echo "<button class='btn btn-success btn-rounded btnapprove'>Approve</button>";
                            }else{
                              
                            }
                         }else if($isatasan==true){

                         }
                         else  if($evaluasi[0]->status=='final'  && $isatasan==false){

                         }else{
                                echo " <button class='btn btn-primary btn-rounded btnsimpan'> Simpan </button> ";
                                echo "<button class='btn btn-success btn-rounded btnfinal' id='btnfinal'> Simpan Final </button>";
                        }
                    ?>
                    
                    
                        
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        </form>
                    </div>
                </div>
            </div>
           
        </div>
        <!---- END SOAL --->

</div>
<div class="modal" id="mdinfo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white">INFORMASI</h5>
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

<div class="modal fade" id="filebukti" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bukti Kinerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
        <?php
       
        if(isset($evaluasi[0]->filebukti) || $evaluasi[0]->filebukti !=""){
            $fileurl=base_url('data/bukti_kinerja/').$evaluasi[0]->filebukti;
        }else{
            $fileurl='';
        }
        ?>
        <embed type="application/pdf" src="<?=$fileurl?>#toolbar=0" width="100%" height="600"></embed>
        </div>
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
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pernyataan</h5>
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
        var jsoal= parseInt($('#jsoal').val())*2;
      
        var stat_eval=$("#stateval").val();
        var jselect=0;

        $('input[type=number]').each(function() { 
            if( $(this).val() !="" ) {
               jselect ++;
            }  
        })

        var sis=jsoal-jselect;
       
        //END TES
             if(stat_eval =="final"){
               $("#mdinfo").modal('show');
             }else{
               $("#mdinfo").modal('hide');
             }
        if(sis = 0){
            $('.btnfinal').hide();   
        }else{
            $('.btnfinal').show();
            
        }

        $('.btagree').on('click',function(e){
                var finale=final();
                if(finale=="ok"){
                        $('#simpankonfirm').modal('show');
                        var info="<h4>Anda telah menyimpan final hasil penilaian ini.</h4>";
                        $('#isikonfirm').html(info);
                }else{
                        alert('proses simpan gagal');
                }
        })
        $('.btnsimpan').on('click',function(e){
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

        $('.btoksimpan').on('click',function(){
                location.reload();
        })

        $('#btnfinal').on('click',function(e){
                submit();

                //cek jika belum ada file
                if ($('#buktikinerja').val() == "") {
                    alert("Anda belum mengunggah bukti kinerja");
                }else{
                    $('#agreement').modal('show');
                    e.preventDefault();
                   
                }
              
                
        })
        $('.btnapprove').on('click',function(e){
            var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
            var csrfHash = $('.txt_csrfname').val(); // CSRF hash
            var catatan = $('#catatan').val();
            var keval=$('#eval').val();
            var form_data = new FormData(); 
            form_data.append("keval", keval);
            form_data.append("catatan", catatan);
            form_data.append(csrfName, csrfHash);
            $.ajax({
                    url: "<?=base_url('appkinerja')?>",
                    method: 'post',
                    data: form_data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                       
                        if(response =="ok"){
                            alert("Upload Bukti Kinerja Berhasil");
                           
                        }else{
                            alert(response);
                        }
                        location.reload();
                    }
                 })
                 
            })

        $("#fsoal").change(function() {
                      var jselect=0;
                        $('input[type=number]').each(function() { 
                                if( $(this).val() !="" ) {
                                        jselect ++;
                                }  
                        })
                        var total=jsoal-jselect;
                      
                      if(total == 0){
                                $('.btnfinal').show();
                        }else{
                                $('.btnfinal').hide();
                        }
                
        })
        $('#filekinerja').on('change',function(){
            var fileformat = $(this).val();
            var formatok=/(\.pdf)$/i;
          
            if(!formatok.exec(fileformat)){
               alert("Maaf, format yang diperbolehkan hanya .pdf")
            }else{
               // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                var keval=$('#eval').val();
                var form_data = new FormData(); 
                var file_data = $(this).prop("files")[0]; 
                form_data.append("file", file_data);
                form_data.append("keval", keval);
                form_data.append(csrfName, csrfHash);
                $.ajax({
                    url: "<?=base_url('addfilekinerja')?>",
                    method: 'post',
                    data: form_data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        if(response =="ok"){
                            alert("Upload Bukti Kinerja Berhasil");
                        }else{
                            alert(response)
                        }
                    }
                 })
            }
           
        })

        $('.btfilebukti').on('click',function(e){
           
            $('#filebukti').modal('show');
            e.preventDefault();
        })

        function submit(){
                var dataed=$('#fsoal').serialize();
                var  urlbase=base_url + 'kinerjasubmit' ;
                var nval;
                $.ajax({
                url  : urlbase,
                type : 'POST',
                data : dataed,
                dataType: 'json',
		        success: function(result){
                   nval=result[0].data;
                 
 				}
            })
            return "ok";
        }

        function final(){
                var dataed=$('#fsoal').serializeArray();
                var  urlbase=base_url + 'final' ;
                var nval;
                var res;
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
     })
</script>
