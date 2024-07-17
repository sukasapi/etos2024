<!-- Begin Page Content -->
<div class="container-fluid">
     <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
           
                <div class="col-6">
                <h1 class="h3 mb-2 text-gray-800">Lembar Penilaian</h1>
                </div> 
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-center row">
            <div class="col-md-10 col-lg-10">
                <div class="border">
                    
                    <div class="question bg-white p-3 border-bottom">
                        <div class="d-flex flex-row justify-content-between align-items-center mcq">
                            <?php 
                                $for=($Penilai == $Peserta)?"diri sendiri" : $Peserta; 
                                $judul = "Penilaian ".$Namates." / Penilai atas ".$for;
                            ?>
                            <h4><div id="nproject">Penilaian Penilai <strong><?=$Penilai?></strong> untuk <?=$for?></div></h4><span><div id="counter"></div></span>
                        </div>
                    </div>
                    <div class="question bg-white p-3 border-bottom">
                        <div id="quiz">

                        </div>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center p-3 bg-white">
                        <button class="btn btn-primary align-items-center btn-danger" id="prev" type="button"><i class="fa fa-angle-left mt-1 mr-1"></i>&nbsp;Previous</button>
                        <button class="btn btn-primary border-success align-items-center btn-success" id="next" type="button">Next<i class="fa fa-angle-right ml-2"></i></button>
                        <button class="btn btn-primary border-success align-items-center btn-info" id="end" type="button">Selesai<i class="fa fa-angle-right ml-2"></i></button>
                    </div>
                </div>
            </div>
            </div>
        </div>
</div>

<!----- MODAL --> 
<div class="modal fade show" id="minfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
      <h5 class="modal-title text-white" id="exampleModalLongTitle">INFORMASI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fadd">
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                
             <p>   <div id="info"></div></p> 
            </div>
        </div>
      <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btcancel" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btsave" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>

<!----- END MODAL --->

<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url('assets/')?>js/custom/tes.js"></script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>