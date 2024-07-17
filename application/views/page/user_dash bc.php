<link href="<?=base_url('assets/')?>css/timeline.css" rel="stylesheet">
<style>
.avatar {
  vertical-align: middle;
  width: 100px;
  height: 100px;
  border-radius: 50%;
}
</style>
 <!-- Main Content -->
<div id="content">


 <!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Evaluation Path</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="row mb-5 pb-5">
         
          <?php 
           $task ="";

          foreach($project as $p){
            
            ?>
             <div class="col-md-4 mb-4 col-sm-12">
              <div class="card p-3 mb-2 h-100">
                  
                  <div class="mt-2 h-100 text-center">
                      <h3 class="heading"><?=$p->nama?></h3>
                      <h6 class="mb-2">Model Penilaian <?=($p->tipe_nilai != "NPS")?'Non NPS':'NPS'?></span>
                      <div class="mt-5">
                        <?php 
                          $selesai=isset($progress[$p->id]['selesai'])?$progress[$p->id]['selesai']:0;
                          $total=isset($target['total'])?$target['total']:0;
                          $persen=($total>0)?($selesai/$total)*100:0;
                          if($persen ==100){
                            $color ="bg-success";
                          }else if($persen > 50 && $persen >=75){
                            $color ="bg-info";
                          }else if($persen > 25 && $persen >=50){
                            $color ="bg-warning";
                          }else{
                            $color ="bg-danger";
                          } 
                        ?>
                          
                          <?php 
                          if($p->tipe_nilai != "NPS"){
                            ?>  
                            <div class="progress">
                              <div class="progress-bar <?=$color?>" role="progressbar" style="width:<?=$persen?>%" aria-valuenow="<?=$persen?>" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                          <div class="mt-3"> <span class="text1"><small>Evaluasi ini menilai kinerja pribadi</small></span> </div>
                            <div class="mt-3 text-center">
                                  <a class="btn btn-primary" role="button" href="<?=base_url('startkinerja')?>">Evaluasi Kinerja <i class="fas fa-tasks"></i></a>
                                </div>
                            <?php
                          }else{
                            ?>
                            <div class="progress">
                              <div class="progress-bar <?=$color?>" role="progressbar" style="width:<?=$persen?>%" aria-valuenow="<?=$persen?>" aria-valuemin="0" aria-valuemax="100">
                              </div>
                            </div>
                            <?php 
                            if($total > 0){
                              ?>
                              <div class="mt-3">
                                <span class="text1"><small><?=$progress[$p->id]['selesai']?> dari <?=$target['total']?> orang telah anda nilai</small></span> 
                              </div>
                              <div class="mt-3 text-center">
                                <a class="btn btn-info  bt_for" data-namae="<?=$p->nama?>" data-jeval="<?=$p->id?>" role="button" href="">Pilih Objek Penilaian <i class="fas fa-users"></i></a>
                              </div>
                              <?php
                            }else{
                              ?>
                              <span class="text1"><small> Anda belum menentukan bawahan anda. Tentukan Obyek Dinilai  <strong><a href="<?=base_url('pilihobyek')?>">disini</a></strong></small></span>
                              <?php
                            }
                            
                            
                          }

                          ?>
                        
                      </div>
                  </div>
              </div>
             </div>
              
            <?php
          }
          ?>
          </div>   
      
        </div>
    </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal" id="evaluasifor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalLongTitle">Objek Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-md-12 text-center">
              <h5>Atasan</h5>
              <?php 
                    
                        if(count((array)$atasan) > 0){
                          
                          foreach($atasan as $a){
                            echo "<div class='col-md-3 col-xs-12'>";
                            ?>
                              <form class="fprepare">
                            <?php
                            echo "<img src='".base_url('assets/img/bos.png')."' alt='Avatar' class='avatar'>";
                            echo "<p class='mb-0 mt-2'>".ucfirst($a->nama)." / ".$a->nopeg."</p>";
                            echo "<p ><small>".$a->bagian." - ".$a->jabatan."</small></p>";
                            echo "<button data-teval='".$this->encryption->encrypt($a->userid)."' class='btn btn-sm btn-round bt-goto btn-info'>Evaluasi</button><hr>";
                            ?>
                            <input type="hidden" id="jval" class="jval" name="jval">
                            <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                              </form>
                            <?php
                              echo "</div>";
                          }
                        }else{
                          echo "Tidak ada obyek penilaian. Cek daftar bawahan";
                        }
                        ?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 text-center">
              <h5>Mitra</h5>
              <div class="card">
                <div class="card-body">
                    <div class="row">
                    <?php 
                 
                        if(count((array)$mitra) > 0){
                          foreach($mitra as $m){
                            echo "<div class='col-md-3 col-xs-12'>";
                            ?>
                              <form class="fprepare">
                            <?php
                            echo "<img src='".base_url('assets/img/mitra.png')."' alt='Avatar' class='avatar'>";
                            echo "<p class='mb-0 mt-2'>".ucfirst($m->nama)." / ".$m->nopeg."</p>";
                            echo "<p ><small>".$m->bagian." - ".$m->jabatan."</small></p>";
                            //cek jika status sudah final

                            echo "<button data-teval='".$this->encryption->encrypt($m->userid)."' class='btn btn-sm bt-goto btn-info'>Evaluasi</button><hr>";
                          
                            ?>
                            <input type="hidden" id="jval" class="jval" name="jval">
                            <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                              </form>
                            <?php
                              echo "</div>";
                          }
                        }else{
                          echo "<p class='text-center'>Tidak ada obyek penilaian. Cek daftar bawahan</p>";
                        }
                        ?>
                    </div>
                </div>
              </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12 text-center">
              <h5>Bawahan</h5>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                  <?php 

                    if(count((array)$bawahan) > 0){
                      foreach($bawahan as $b){
                        echo "<div class='col-md-3 col-xs-12 '>";
                        ?>
                          <form class="fprepare">
                        <?php
                        echo "<img src='".base_url('assets/img/bawahan.png')."' alt='Avatar' class='avatar'>";
                        echo "<p class='mb-0 mt-2'>".ucfirst($b->nama)." / ".$b->nopeg."</p>";
                        echo "<p ><small>".$b->bagian." - ".$b->jabatan."</small></p>";
                        echo "<button data-teval='".$this->encryption->encrypt($b->userid)."' class='btn btn-sm bt-goto btn-info'>Evaluasi</button><hr>";
                       
                        ?>
                         <input type="hidden" id="jval" class="jval" name="jval">
                         <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                          </form>
                        <?php
                          echo "</div>";
                      }
                    }else{
                      echo "Tidak ada obyek penilaian. Cek daftar bawahan";
                    }
                  ?>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <hr>
        <form id="fpreparetes">
      
      </div>
       
        </form>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btstart btn-primary">Mulai Evaluasi</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    $('.bt_for').on('click', function(e){
      e.preventDefault();
        $("#evaluasifor").modal("show");
        $("#namae").html($(this).data('namae'));
        $(".jval").val($(this).data('jeval'));
    })

    $('#evalfor').on('change',function(){
      var evalfor = $(this).val();
      $('#evalname').empty();
      getrelasi(evalfor);
    })

    $('.btstart').on('click',function(){
        gototes();
    })

    $('.bt-goto').on('click',function(e){
      e.preventDefault();
      var teval=$(this).data('teval');
      gototes(teval);
    })


    function getrelasi(efor){
      var urlcari=base_url + '/getrelasi';
      var token = $('#token').val();
            $.ajax({
				url: urlcari,
                data: {efor : efor, token:token},
                type: 'get',
                success: function(result) {
              
                  var ldata=JSON.parse(result).length;
                  var data=JSON.parse(result);
                  if(ldata > 0){
                   for(var i=0 ; i < ldata ; i++){
                    $("#evalname").append('<option value=' + data[i].idkoneksi + '>' + data[i].koneksi + '</option>');
                    }
                  }else{
                   $("#evalname").append('<option disabled selected>Data tidak ditemukan</option>');
                  }
              }
          })
    }


    function gototes(teval){
     
      var urladd=base_url + 'preparetes';
       // CSRF Hash
       var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
       var csrfHash = $('.txt_csrfname').val(); // CSRF hash
       var jeval=$('.jval').val();
     
    
     $.ajax({
        url  : urladd,
        type : 'POST',
        data : {jval: jeval,teval:teval,[csrfName]: csrfHash },
        dataType: 'json',
				success: function(result){
       	if(result.res == "ok"){
             location.replace(base_url + "startevaluasi/" + result.eval);
            }else{
              location.reload();
            }
       
				  }
       })
      
    }
    


  })
</script>