
 
 <!-- Main Content -->
  <div id="content">


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Profil</h1> 
    </div>

    <!-- Content Row -->
    <?php 
            if($this->session->flashdata('error')){
        ?>
      
                <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Informasi</h4>
                <p><?=$this->session->flashdata('error')?></p>
                </div>
                <?php
                }else if($this->session->flashdata('success')){
                        ?>
                        <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Informasi</h4>
                        <p><?=$this->session->flashdata('success')?></p>
                        </div>
                        <?php
                }else{

                }

                ?>
          
      
    <div class="row pb-3">
        <div class="col-md-6 col-xs-12">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil user</h6>
                
                </div>
                <div class="card-body bg-white">
                    <?php 
                     
                    if($_SESSION['logged_in']['status'] != 'user'){
                   
                        ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"><?=$_SESSION['logged_in']['uname']?></div>
                    </div>
                    <hr>
                        <?php
                        $uid=$_SESSION['logged_in']['id'];
                    }else{
                        $uid=$this->encryption->encrypt($user->userid);
                    ?>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nomor Pegawai</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"> <?=$user->uname?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"> <?=$user->namapeserta?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Perusahaan</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"> <?=$user->namaperusahaan?></div>
                    </div>
                    <?php 
                        if($detail->status_peserta != "penilai"){
                            ?>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Unit kerja</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"> <?=$user->bagian?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jabatan</h6>
                        </div>
                        <div class="col-sm-9 text-secondary"> <?=$user->jabatan?></div>
                    </div>
                    <hr>
                            <?php
                        }else{
                            ?>
                    
                            <?php
                        }
                    ?>
                    
                    <?php
                    }
                        ?>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12">
            <div class="row">
                <?php 
                    $adabawahan= count((array)bawahan_list());
                    $statususer=$detail->status_peserta;
                    if($adabawahan < 0 || $statususer=='peserta'){
                        ?>
                              <div class="col-md-12 col-xs-12 pb-4">
                    <div class="card">
                        <div class="card-header  py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Kelengkapan Obyek Penilaian</h6>
                        </div>
                        <form action="<?= base_url('updateprofil')?>" method="POST" enctype="multipart/form-data">
                        <div class="card-body bg-white">
                            <div class="form-group">                               
                                <label for="jenis">Jenis Asisten</label>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option selected readonly>- Input Jenis Asisten</option>
                                    <?php 
                                    
                                        $asisten=jasisten();
                                        foreach($asisten as $a){
                                            if($a == $user->jenis_asisten){
                                               echo  "<option value='".$a."' selected>".ucfirst($a)."</option>";
                                            }else{
                                                echo  "<option value='".$a."'>".ucfirst($a)."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">                               
                                <label for="komoditas">Komoditas</label>
                                <select name="komoditas" id="komoditas" class="form-control">
                                    <option selected readonly>- Input Komoditas</option>
                                    <?php 
                                    $komoditas=jkomoditas();
                                    foreach($komoditas as $k){
                                        if($k == $user->komoditas){
                                            echo " <option value='".$k."' selected >".ucfirst($k)."</option>";
                                        }else{
                                            echo " <option value='".$k."'>".ucfirst($k)."</option>";
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">                               
                                <label for="unit">Unit kerja</label>
                                <select name="unit" id="unit" class="form-control">
                                    <option selected readonly>- Input Unit Kerja</option>
                                    <?php 
                                            $unit=juker();
                                            foreach($unit as $u){
                                                if($u==$user->unitkerja){
                                                    echo "<option selected value='".$u."'>".ucfirst($u)."</option>";
                                                }else{
                                                    echo "<option value='".$u."'>".ucfirst($u)."</option>"; 
                                                }
                                            }

                                    ?>
                                </select>
                            </div>
                            <button class="btn btn-default" type="button" id="show">
                                </button>
                            <div class="text-left">
                            <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="submit" class="btn btn-primary" id="updatebt" value="Update Keterangan"> 
                                
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                        <?php
                    }else{

                    }
                ?>
              
                <div class="col-md-12 col-xs-12">
                    <div class="card">
                    <div class="card-header  py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                    </div>
                    <div class="card-body bg-white text-center">
                        <div class="form-group input-group" id="show_hide_password">
                            <input type="password" id="passval" class="form-control">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" id="show"><i class="fa fa-eye-slash"></i>
                            </button>
                            </span>
                        </div>
                        <div class="text-left">
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <button class="btn btn-primary" id="changepass" data-ius='<?=$uid?>'>
                            Ganti Password 
                        </div>
                    </div>
                    </div>
                </div>
            </div>
           
        </div>
    </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
  

<script>
     $(document).ready(function() {



        $("#show").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show i').addClass( "fa-eye-slash" );
                $('#show i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show i').removeClass( "fa-eye-slash" );
                $('#show i').addClass( "fa-eye" );
            }
        });

        $("#changepass").on('click', function() {
             var idus=$(this).data('ius');
                changepass(idus);
        });

        function changepass(idus){
            var urlchangepass=base_url + 'changepass';
            var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
            var csrfHash = $('.txt_csrfname').val(); // CSRF hash
            var dtpass = $('#passval').val();
            $.ajax({
                url  : urlchangepass,
                type : 'POST',
                data : { newpass : dtpass,ediu:idus, [csrfName]: csrfHash},
                dataType: 'json',
				success: function(result){
                    console.log(result);
                }
            })
        }
     })
</script>