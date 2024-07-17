<!-- CSS tambahan -->
<link href="<?=base_url('assets/survey-pack/')?>defaultV2.min.css" type="text/css" rel="stylesheet"/>
<link href="<?=base_url('assets/survey-pack/')?>survey.css" type="text/css" rel="stylesheet"/>

<div class="container-fluid">
     <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           
                <div class="col-6">
                <h1 class="h3 mb-2 text-gray-800">Lembar Penilaian <?=$peserta[0]->nama?></h1>
                </div>
        </div>

        <!---- CONTENT --> 
        <div class="row">
                <div class="col-md-12 col-sm-12">
                        <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Informasi</h4>
                                <p>Kami mohon partisipasi Anda untuk melakukan penilaian tata nilai [evaluasi], rekan kerja dan bawahan. Penilaian [evaluasi] yang Anda lakukan menggambarkan persepsi Anda terhadap kesesuaian tata nilai [evaluasi] dari objek penilaian.
				<hr/>
				Penilaian ini menggunakan metode Net Promotor Score [tipe evaluasi]</p>
                        </div>
                </div>
                <?=print_r($evaluasi);?>
                <!---- Panduan Pengerjaan -->
                <div class="col-md-12 col-sm-12">
                        <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#petunjuk" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">PANDUAN PENGISIAN</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="petunjuk" >
                                    <div class="card-body">
                                    <table class="table table-bordered mb-3">
                                        <tbody>
                                                <tr>
                                                        <td style="width:20%" class="nilai_pengukuran_pr">10-9</td>
                                                        <td class="nilai_pengukuran_pr">Saya menganggap dia baik/sangat baik dalam mengamalkan  dan saya bersedia menyampaikan kepada orang lain mengenai kebaikannya. (Promotor)</td>
                                                </tr>
                                                <tr>
                                                        <td class="nilai_pengukuran_pa">8-7</td>
                                                        <td class="nilai_pengukuran_pa">Saya menganggap bahwa dia cukup dalam mengamalkan nilai AKHLAK, namun saya belum mau menyampaikan kebaikan tersebut kepada orang lain. (Pasif)</td>
                                                </tr>
                                                <tr>
                                                        <td class="nilai_pengukuran_de">6-1</td>
                                                        <td class="nilai_pengukuran_de">Saya menganggap dia kurang/buruk dalam mengamalkan nilai AKHLAK, dan mungkin saya akan menyampaikan apa adanya/kepada orang lain tentang karyawan tersebut. (Detractor)</td>
                                                </tr>
                                        </tbody>
                                </table>
                                    </div>
                                </div>
                        </div>
                </div>
                <!---- End Panduan Pengerjaan -->
                <!---- TES FORM -->
                <div class="col-md-12 col-sm-12">
                   <div class="card shadow mb-4">
                           <input type="hidden" id="pro" value=<?=$project?>>
                           <input type="hidden" id="eval" value=<?=$evaluasi?>>
                           <input type="hidden" id="target" value=<?=$peserta[0]->id?>>
                        <div class="question bg-white p-3 border-bottom">
                                <div id="myContainer"></div>
                        </div>
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                   </div>
                </div>
                <!---- .END TEST FORM --->
              
        </div>

        <!----- . End CONTENT --->

</div>
<script src="<?=base_url('assets/survey-pack/')?>survey.jquery.js"></script>
<script  src="<?=base_url('assets/js/custom/')?>tes.js"></script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>