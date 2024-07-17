 <!-- Outer Row -->
 <div class="row justify-content-center">

<div class="col-xl-10 col-lg-12 col-md-9">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-primary mb-4 " >Evaluasi <strong> Planters Tangguh</strong></h1>
                        </div>
                        <?php 
                          if($this->session->flashdata('success')){
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                               <strong>BERHASIL</strong>
                               <p><?=$this->session->flashdata('success')?></p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                               </button>
                            </div>
                            <?php
                        }else if(  $this->session->flashdata('error')){
                            ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                               <strong>Gagal</strong>
                               <p><?=$this->session->flashdata('error')?></p>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                               </button>
                            </div>
                            <?php
                        }else{
                        }
                        ?>
                        <?php 

                            if(whoslogin() > 800){
                                echo "<h5>Informasi</h5><h6> Mohon maaf, saat ini aplikasi sedang penuh. Coba beberapa saat lagi</h6>";
                            }else{
                                ?>
                                    <form class="user" action="<?=base_url('login')?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Masukkan username / ID pegawai anda ..">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="upassword" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Masukkan kata kunci aplikasi">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Ingat saya</label>
                                            </div>
                                        </div>
                                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <input type="submit" value="login" href="" class="btn btn-primary btn-user btn-block">
                
                                        </a>
                                    </form>
                                <?php
                            }
                            ?>
                       
                        <hr>
                        <div class="text-center ">
                            <a class="small" disabled data-toggle="tooltip" title="">Pengguna aplikasi saat ini : <?=whoslogin();?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>

<!-- Modal -->
<div class="modal fade" id="infomd" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
      <div class="row text-right">
       <div class="col-md-4 col-xs-12">
        <div>
            <img class="img" src="<?=base_url('assets/img/pindahan.jpg')?>" style="width:300px; max-height:auto;object-fit:contain"></img>             
        </div>
        </div>
        <div class="col-md-8 col-xs-12">
              
                <h3 class="pt-2 pb-1 mb-0 text-secondary">Pengumuman</h3>
                <p class="pb-1 text-muted">Selamat datang di alamat baru aplikasi Etos Kerja.<br> Mulai <strong> 1 November 2022</strong> alamat resmi aplikasi berada di domain ini.<br> Terima Kasih</p>                
        </div>
      </div>  
               
               
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    </div>
    </div>
  </div>
</div>
<script src="<?=base_url('assets/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?=base_url('assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script>
     $(document).ready(function() {
        /*$('#infomd').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                }); 
	*/
     })
</script>