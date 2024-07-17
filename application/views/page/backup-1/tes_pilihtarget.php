<!-- CSS tambahan -->
<link href="<?=base_url('assets/survey-pack/')?>defaultV2.min.css" type="text/css" rel="stylesheet"/>
<link href="<?=base_url('assets/survey-pack/')?>survey.css" type="text/css" rel="stylesheet"/>

<div class="container-fluid">
     <!-- Page Heading -->
        <div class="d-sm-flex text-center mb-4">
           
                <div class="col-12">
                <h1 class="h3 center mb-2 text-gray-800">Pilih Target Evaluasi</h1>
                </div>
        </div>

        <!---- CONTENT --> 
        <div class="row">
                <div class="col-md-12 col-sm-12">
                        <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Informasi</h4>
                                <p>Kami mohon partisipasi Anda untuk melakukan penilaian tata nilai [evaluasi], rekan kerja dan bawahan. Penilaian [evaluasi] yang Anda lakukan menggambarkan persepsi Anda terhadap kesesuaian tata nilai [evaluasi] dari objek penilaian.
				<hr/>
				Penilaian ini menggunakan metode <strong><?=$tipeeval?></strong></p>
                        </div>
                </div>
                <!---- TES FORM -->
                <div class="col-md-12 col-sm-12">
                   <div class="card shadow mb-4">
                           <input type="hidden" id="pro" value=<?=$project?>>
                           <input type="hidden" id="eval" value=<?=$eval?>>
                       
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                   </div>
                </div>
                <!---- .END TEST FORM ---> 
             
        </div>
        <div class="row">
        <div class="col-xl-12 col-lg-12 col-xs-12">
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#atasanread" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Evaluasi Bawahan</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="atasanread">
                                    <div class="card-body">
                                       <?php 
                                       $sb="";
                                       if(count((array)$bawahan) > 0){
                                        foreach($bawahan as $b){
                                                $sb .="<div class='form-group'>";
                                                $sb .="<label for='bawahan'>Daftar Bawahan</label>";
                                                $sb .="<select name='bawahan' id='bawahan' class='form-control'>";
                                                $sb .="<option value='".$b->idpeserta."'>".$b->peserta."</option>";
                                                $sb .="</select>";
                                                $sb .="</div>";
                                            
                                            }
                                            echo $sb;
                                            echo "<div class='text-center'>";
                                            echo "<button id='btbawahan' class='btn btn-primary btn-lg'>Evaluasi Sekarang</button>";
                                            echo "</div>";
                                        }else{
                                            echo "<h5>Daftar bawahan kosong, silahkan hubungi admin untuk mendaftarkan bawahan anda.</h5>";
                                        }
                                        
                                       ?>
                                    </div>
                                </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-xs-12">
                    <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#mitraread" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Evaluasi Mitra</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="mitraread">
                                    <div class="card-body">
                                    <?php 
                                    $sat="";
                                       if(count((array)$mitra) > 0){
                                        foreach($mitra as $m){
                                                $sat .="<div class='form-group'>";
                                                $sat .="<select class='form-control'>";
                                                $sat .="<option value='".$m->idmitra."'>".$m->peserta."</option>";
                                                $sat .="</select>";
                                                $sat .="</div>";
                                            }
                                            echo $sat;
                                            echo "<div class='text-center'>";
                                            echo "<button id='btmitra' class='btn btn-primary btn-lg'>Evaluasi Sekarang</button>";
                                            echo "</div>";
                                        }else{
                                            echo "<h5>Daftar mitra kosong, silahkan hubungi admin untuk mendaftarkan mitra anda.</h5>";
                                        }
                                        
                                       ?>
                                    </div>
                                </div>
                    </div>
                </div>
        </div>

        <!----- . End CONTENT --->

</div>

<script> 
$(document).ready(function() {



    $('#btbawahan').on('click', function(){
        var param = $('#pro').val() + "/" + $('#eval').val() + "/" + $('#bawahan').val();
        location.replace(base_url + "starttes/" + param);
        
    });

    $('#btmitra').on('click', function(){
        var param = $('#pro').val() + " -" + $('#eval').val() + " -" + $('#mitra').val();
        alert(param);
    })
})
</script>

<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>