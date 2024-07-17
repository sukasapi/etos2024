<link href="<?=base_url('assets/')?>css/timeline.css" rel="stylesheet">
<style>
.avatar {
  vertical-align: middle;
  width: 100px;
  height: 100px;
  border-radius: 50%;
}

body{
  background-color: #7E57C2;
}

.mt-100{
  margin-top: 200px;
}
.progress {
  width: 150px;
  height: 150px !important;
  line-height: 150px;
  background: none;
  margin: auto;
  margin-bottom: 10px;
  box-shadow: none;
  position: relative;
}
.progress:after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 12px solid #fff;
  position: absolute;
  top: 0;
  left: 0;
}
.progress>span {
  width: 50%;
  height: 100%;
  overflow: hidden;
  position: absolute;
  top: 0;
  z-index: 1;
}
.progress .progress-left {
  left: 0;
}
.progress .progress-bar {
  width: 100%;
  height: 100%;
  background: none;
  border-width: 12px;
  border-style: solid;
  position: absolute;
  top: 0;
}
.progress .progress-left .progress-bar {
  left: 100%;
  border-top-right-radius: 80px;
  border-bottom-right-radius: 80px;
  border-left: 0;
  -webkit-transform-origin: center left;
  transform-origin: center left;
}
.progress .progress-right {
  right: 0;
}
.progress .progress-right .progress-bar {
  left: -100%;
  border-top-left-radius: 80px;
  border-bottom-left-radius: 80px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
  animation: loading-1 1.8s linear forwards;
}
.progress .progress-value {
  width: 90%;
  height: 90%;
  border-radius: 50%;
  background: #000;
  font-size: 24px;
  color: #fff;
  line-height: 135px;
  text-align: center;
  position: absolute;
  top: 5%;
  left: 5%;
}
.progress.green .progress-bar {
  border-color: #20bf6b;
}
.progress.green .progress-left .progress-bar {
  animation: loading-1 0.5s linear forwards 1.8s;
}
.progress.yellow .progress-bar {
  border-color: #fdba04;
}
.progress.yellow .progress-right .progress-bar {
  animation: loading-2 0.5s linear forwards;
}
.progress.yellow .progress-left .progress-bar {
  animation: none;
}

.progress.orange .progress-bar {
  border-color: #fa8231;
}
.progress.orange .progress-left .progress-bar {
  animation: loading-3 0.5s linear forwards 1.8s;
}

.progress.red .progress-bar {
  border-color: #eb3b5a;
}
.progress.red .progress-right .progress-bar {
  animation: loading-4 0.1s linear forwards;
}
.progress.red .progress-left .progress-bar {
  animation: none;
}

@keyframes loading-1 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
@keyframes loading-2 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
    transform: rotate(180deg);
  }
}
@keyframes loading-3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(90deg);
    transform: rotate(90deg);
  }
}

@keyframes loading-4 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(10deg);
    transform: rotate(10deg);
  }
}

</style>
 <!-- Main Content -->
<div id="content">


 <!-- Begin Page Content -->
<div class="container-fluid">
<?php 
date_default_timezone_set("Asia/Jakarta");
$statpeserta="";
$idus=$this->encryption->decrypt($_SESSION['logged_in']['id']);
$jbawah=count((array)bawahan_list());
$jmitra=count((array)mitra_list());
$stat=statpeserta($idus)->status_peserta;
if( $jbawah== 0 && $jmitra==0  && $stat=="peserta" ){
  $statpeserta = "peserta";
  $fitur="
            <strong>Menginputkan Data kinerja</strong>
          ";

}else{
  $statpeserta = "penilai";
  $fitur="<ul>
            <li> Menginputkan Etos kerja, Tradisi, Tri Tertib, dan Atribut plantersss untuk bawahan atau mitra anda.</li>
            <li> Menginputkan Data kinerja</li>
          </ul>";
}

$now=date('Y-m-d H:i:s');
$open=date('Y-m-d H:i:s',strtotime('2023-01-30 23:59:00'));
$lastorder=date('Y-m-d H:i:s',strtotime('2023-12-30 23:59:00'));

  if( $now >= $open && $now < $lastorder){
    $isopen=true;
  }else{
    $isopen=false;
  }
?>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Evaluasi</h1>
    </div>
    <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="alert alert-success" role="alert">
            <h5 class="alert-heading">INFORMASI!</h5>
            <?php 
            if($isopen){
              ?>
                <p>Saat ini anda terdaftar sebagai <strong><?=strtoupper($statpeserta)?></strong> pada sistem kami</p>
                <p> Dengan status tersebut anda dapat :
               <?=$fitur?>
            </p>
              <?php
            }else{
             ?>
               <p>Saat ini penilaian belum terbuka.</p>
              <p> Penilaian akan dibuka pada <strong><?=$open?> jam saat ini <?=$now?></strong> 
            </p>
             <?php
            }?>
          
            <hr>
          
          </div>
        </div>
    </div>
  <!-- Content Row -->
  <div class="row">
      <?php 
      if($isopen){
        ?>
        <div class="col-md-12 col-xs-12">
          <div class="row mb-5 pb-5">
       
          <?php 
         
          foreach($project as $p){
          
            if($statpeserta =="penilai"){
            ?>
             <div class="col-md-4 mb-4 col-sm-12">
              <div class="card p-3 mb-2 h-100 align-items-center">
                  
                  <div class="mt-2 h-100 text-center">
                      <div style="height : 80px">
                        <h3 class="heading"><?=$p->nama?></h3>
                        <h6 class="mb-2">Model Penilaian <?=($p->tipe_nilai != "NPS")?'Non NPS':'NPS'?></h6>
                      </div>
                      <div class="text-center">
                        <?php
                              $selesai=isset($progress[$p->id]['selesai'])?$progress[$p->id]['selesai']:0;
                              $total=isset($target['total'])?$target['total']:0;
                              $persen=($total>0)?($selesai/$total)*100:0;
                              if($persen >=100){
                                $color ="bg-success";
                                $pb ="
                                <div class='progress green'>
                                    <span class='progress-left'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <span class='progress-right'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <div class='progress-value'>".$selesai."/".$total."</div>
                                </div>
                                ";
                              }else if($persen > 50 || $persen >=75){
                                $color ="bg-info";
                                $pb ="
                                <div class='progress orange'>
                                    <span class='progress-left'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <span class='progress-right'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <div class='progress-value'>".$persen."%</div>
                                </div>
                                ";
                              }else if($persen >25 || $persen >50){
                                $color ="bg-warning";
                                $pb ="
                                <div class='progress yellow'>
                                    <span class='progress-left'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <span class='progress-right'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <div class='progress-value'>".$selesai."/".$total."%</div>
                                </div>
                                ";
                              }else{
                                $color ="bg-danger";
                                $pb ="
                                <div class='progress red'>
                                    <span class='progress-left'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <span class='progress-right'>
                                        <span class='progress-bar'></span>
                                    </span>
                                    <div class='progress-value'>".$persen."%</div>
                                </div>
                                ";
                              } 
                              if($p->id != '5'){
                                  echo $pb;
                              ?>
                                    <button data-toggle="modal" data-target="#mdEval<?=$p->id?>" 
                                    class="btn btn-info btn-rounded btfor<?=$p->id?>" data-namae="<?=$p->nama?>" 
                                    data-jeval="<?=$p->id?>" isok="<?$cek?>" role="button">Lihat Obyek Penilaian<br><i class="fas fa-users"></i>
                                   </button>
                              <?php
                                }else{

                                }

                        ?>

                       
                        <!--<a class="btn btn-info  bt_for" data-namae="<?=$p->nama?>" data-jeval="<?=$p->id?>" isok="<?$cek?>" role="button" href="">Pilih Objek Penilaian <i class="fas fa-users"></i></a> -->
                               
                      </div>

                      <!--- modal disini -->
                      <?php 
                        if($p->id != '5'){
                          ?>
                            <div class="modal" id="mdEval<?=$p->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                  <div class="modal-header ">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Daftar Obyek Dinilai</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                        <div class="row">
                                          <div class="col-md-12 text-center">
                                          <?php 
                                                if(count((array)mitra_list()) > 0 ){
                                                  ?>
                                                  <div class="card">
                                                    <div class="card-header bg-primary">
                                                      <div class="card-title text-white"><h5>Mitra</h5> </div>
                                                    </div>
                                                    <div class="card-body">
                                                      <div class="row">
                                                        <?php
                                                           $evalno=0;
                                                           foreach($mitra['peserta'] as $m){
                                                           echo "<br>";
                                                           //print_r($this->enryption->encrypt($_SESSION['logged_in']['id']));
                                                           echo "<div class='col-md-3 col-xs-12 text-center'";
                                                        ?>
                                                          <form class="fprepare">
                                                              <?php
                                                            //echo "<img src='".base_url('assets/img/mitra.png')."' alt='Avatar' class='avatar'>";
                                                              echo "<p class='mb-0 mt-2'>".ucfirst($m->nama)." / ".$m->nopeg."</p>";
                                                              echo "<p ><small>".$m->bagian." - ".$m->jabatan."</small></p>";
                                                              //cek jika status sudah final
                                                              $idlogin=$this->encryption->decrypt($_SESSION['logged_in']['id']);
                                                              $paramcek=array("penilai"=>$idlogin,"peserta"=>$m->userid,"evaluasi"=>$p->id,"status"=>"final");
                                                              $docek=$this->user->evaluasiCek($paramcek);
                                                              $cek=count((array)$docek);
                                                           
                                                              if($cek > 0){
                                                                echo "<button data-teval='".$this->encryption->encrypt($m->userid)."'  data-jeval='".$p->id."' class='btn btn-sm bt-goto btn-success'> Evaluasi <br><i class='fas fa-thumbs-up'></i></button><hr>";
                                                              }else{
                                                                echo "<button data-teval='".$this->encryption->encrypt($m->userid)."' data-jeval='".$p->id."' class='btn btn-sm bt-goto btn-danger'>Evaluasi <br><i class='fas fa-thumbs-down'></i></button><hr>";
                                                              }
                                                            
                                                              
                                                              ?>
                                                              
                                                              <div class="" id="goeval">

                                                              </div>
                                                              <input type="hidden" id="jval" class="jval" name="jval">
                                                              <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                          </form>
                                                            <?php 
                                                            echo "</div>";
                                                            $evalno++;
                                                           }
                                                            ?>

                                                      </div>
                                                    </div>
                                                  </div>
                                                  <?php
                                                }else{

                                                }
                                          ?>  
                                          <?php 
                                                if(count((array)bawahan_list()) > 0 ){
                                          ?>
                                                <div class="card">
                                                  <div class="card-header bg-primary">
                                                    <div class="card-title text-white">   <h5>Bawahan</h5> </div>
                                                  </div>
                                                  <div class="card-body">
                                                    <div class="row">
                                                    <?php 
                                                        $evalno=0;
                                                       
                                                        foreach($bawahan as $b){
                                                          echo "<br>";
                                                          //print_r($this->enryption->encrypt($_SESSION['logged_in']['id']));
                                                          echo "<div class='col-md-4 col-xs-12 text-center'";
                                                              ?>
                                                                <form class="fprepare">
                                                              <?php
                                                            //echo "<img src='".base_url('assets/img/mitra.png')."' alt='Avatar' class='avatar'>";
                                                              echo "<p class='mb-0 mt-2'>".ucfirst($b->nama)." <br> ".$b->nopeg."</p>";
                                                              echo "<p ><small>".$b->bagian." - ".$b->jabatan."</small></p>";
                                                              //cek jika status sudah final
                                                              
                                                              $idlogin=$this->encryption->decrypt($_SESSION['logged_in']['id']);
                                                              $paramcek=array("peserta"=>$b->uid,"penilai"=>$idlogin,"evaluasi"=>$p->id,"status"=>"final");
                                                              $cek=$this->user->evaluasiCek($paramcek);

                                                              if($cek > 0){
                                                                echo "<button data-teval='".$this->encryption->encrypt($b->userid)."'  data-jeval='".$p->id."' class='btn btn-sm bt-goto btn-success'> Evaluasi <br><i class='fas fa-thumbs-up'></i></button><hr>";
                                                              }else{
                                                                echo "<button data-teval='".$this->encryption->encrypt($b->userid)."' data-jeval='".$p->id."' class='btn btn-sm bt-goto btn-warning'>Evaluasi <br><i class='fas fa-thumbs-down'></i></button><hr>";
                                                              }
                                                            
                                                              
                                                              ?>
                                                              
                                                              <div class="" id="goeval">

                                                              </div>
                                                              <input type="hidden" id="jval" class="jval" name="jval">
                                                              <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                                </form>
                                                        <?php
                                                            echo "</div>";
                                                            $evalno++;
                                                        }
                                                    ?>
                                                    </div>
                                                  </div>
                                                </div>    
                                          <?php
                                            }else{

                                            }
                                          ?>
                                                        
                                          </div>
                                        </div>
                                        <hr>
                                  </div>
                                </div>
                              </div>
                            </div>


                          <?php
                        }else{
                          if(count((array)bawahan_list()) > 0 ){
                            /// jika ada bawahan
                          ?>
                            
                          <?php
                          }else{
                            ///
                            if($stat!='peserta'){
                              ?>
                              <div class="mt-3"> 
                                <div class="alert alert-info" role="alert">
                                <span class="text1">Tidak Tersedia</span> 
                                </div>
                                  
                              </div>
                              <?php
                            }else{
                            ?>  
                              <div> 
                                <span class="text1"><small>Evaluasi ini menilai kinerja pribadi</small></span> 
                              </div>
                              <div class="mt-3 text-center">
                              <button data-teval='<?=$_SESSION['logged_in']['id']?>' data-jeval='<?=$p->id?>' id='btkinerja' class='btn btn-sm btn-info'>Evaluasi</button>
                              </div>
                            <?php
                            }

                            ///
                          }
                        }
                      ?>
                  </div>
              </div>
             </div>
              
            <?php
            }else{
              if($p->tipe_nilai == "NPS"){

              }else{
                ?>                
                  <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="card p-3 mb-2 h-100">
                    <h3 class="card-title text-center">Evaluasi Kinerja</h3>
                      <div class="mt-3 text-center"> 
                                  <span class="text1 "><p>Evaluasi ini menilai kinerja pribadi Anda</p></span> 
                                
                                </div>
                                <div class="mt-3 text-center">
                                <button data-teval='<?=$_SESSION['logged_in']['id']?>' data-jeval='<?=$p->id?>' id='btkinerja' class='btn btn-sm btn-info'>Evaluasi</button>
                                </div>
                    </div>
                  </div>
                <?php
              }
            
            }
          }
          ?>
          </div>   
      
        </div>
        <?php 
      }else{

      }
        ?>
    </div>

    <!-- Content Row -->
    

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


<div class="modal" id="periodeeval" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="exampleModalLongTitle">Periode Penilaian Kinerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?=base_url('kinerjaperiode')?>" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
        <input type="hidden" jid="teval" name='teval' value=''>
        <input type="hidden" id="jeval" name='jeval'>
                <div class="row mx-2">
                  <div class='alert alert-info' role='alert'>
                  <h6> Pilih terlebih dahulu bulan dan tahun periode pengambilan nilai kinerja anda</h6>
                  </div>
                  <hr>
                    <div class="col-md-6 col-sm-12 py-2">
                          <select name="bulan" class="form-control" id="bulan">
                            <option value='' selected readonly >- Pilih bulan periode pengambilan kinerja -</option>
                              <?php 
                                foreach(bulanpriode() as $bulan){
                                  echo "<option value='".$bulan."'>".$bulan."</option>";
                                }
                              ?>
                          </select> 
                     </div>
                    <div class="col-md-6 col-sm-12 py-2">
                                
                      <select name="tahun" class="form-control" id="tahun">
                        <option value='' selected readonly >- Pilih tahun periode pengambilan kinerja -</option>
                        <option value='2021' >2021</option>
                        <option value='2022' >2022</option>
                      </select> 
                    </div>
                </div>
        </div>
        
        <div class="modal-footer">
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
          <input type="submit"  id="bt_goeval" value="Mulai Evaluasi" class="btn btn-success">
        </div>
      </form>
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
        var isok=$(this).data('isok');
        console.log(isok);
        if(isok > 0){
          console.log(isok);
        }else{

        }
    })

    $('#evalfor').on('change',function(){
      var evalfor = $(this).val();
      $('#evalname').empty();
      getrelasi(evalfor);
    })

    $('#btkinerja').on('click',function(){
      var dtkinerja=$(this).data('token');
      var teval=$(this).data('teval');
      var jeval=$(this).data('jeval');
      $('#periodeeval').modal('show');
      $('#bt_goeval').hide();
      $('#teval').val(teval);
      $('#jeval').val(jeval);

    })

    $('.btstart').on('click',function(){
        gototes();
    })

    $('.bt-goto').on('click',function(e){
      e.preventDefault();
      var teval=$(this).data('teval');
      var jeval=$(this).data('jeval');
      gototes(teval,jeval);
    })

    $('#bulan').on('change',function(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
       if(bulan =='' ||  tahun==''){
        $('#bt_goeval').hide();
       }else{
        $('#bt_goeval').show();
       }
    })

    $('#tahun').on('change',function(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
       if(bulan =='' ||  tahun==''){
        $('#bt_goeval').hide();
       }else{
        $('#bt_goeval').show();
       }
    })


    function getrelasi(efor){
      var urlcari=base_url + '/getrelasi2';
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


    function gototes(teval,eval){
     
     
       // CSRF Hash
       var csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
       var csrfHash = $('.txt_csrfname').val(); // CSRF hash
       var jeval=$('.jval').val();
       if(jeval == ''){
         jeval=eval
       }
     
       if(jeval!="5"){
        var urladd=base_url + 'preparetes';
       }else{
        var urladd=base_url + 'startkinerja';
       }

     
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

<?php 

?>