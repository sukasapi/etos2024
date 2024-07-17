<div class="container-fluid px-4">
  <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12">
         
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
      </div>
  </div>
    <div class="card">
        <div class="card-header">
        <h4> <div class="text-muted mb-2">Daftar Obyek Penilaian</div></h4>    
        </div>
        <div class="card-body">
        
            <div class="row">
                <div id="relasikonten">

                </div>
            </div>
        </div>
 <div class="card-footer text-right"><button id="btadd" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> Obyek Penilaian</button></div>
</div>           
</div>
<input type="hidden" id="token" value="<?=$_SESSION['logged_in']['id']?>">
<input type="hidden" id="comp" value="<?=$_SESSION['logged_in']['perusahaan']?>">

<!--ADD MODAL ATASAN-->
<div class="modal" id="mrelasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Objek Penilaian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <p class="text-center"> Jika sudah terdaftar, maka data akan diupdate</p>
      <form id="faddrelasi">
    <div class="modal-body">
        
        <div class="form-group">
            <label for="nama">Nama Karyawan</label>
            <select name="relasi" class="form-control" id="relasi">
                 
           </select>
        </div>
     <?php 
            $level=$levelrelasi;
     ?>

        <div class="form-group">
            <label for="nama">Level Relasi</label>
            <select name="level" class="form-control" id="level">
            <option disabled selected>Pilih level relasi </option>
               <?php 
                
                    foreach($level as $lr){
                        echo "<option value='".$lr."'>".ucfirst($lr)."</option>";
                    }
               ?>
           </select>
        </div>
        
       
        <div class="form-group">
            <label for="status">Status</label>
           <select name="status" class="form-control" id="status">
                <option value='aktif'>Aktif</option>
                <option value='nonaktif'>Non Aktif</option>
           </select>
        </div>
        <input type="hidden" name="comp" id="comp" value="<?=$_SESSION['logged_in']['perusahaan']?>">
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btsave" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--END ADD MODAL ATASAN-->
<script>
      $(document).ready(function() {
          var token=$('#token').val();
          var comp=$('#comp').val();
        getrelasi();
        getlist();
        $('#btadd').on('click', function(){
            $('#mrelasi').modal('show');
        })

        $('#btsave').on('click',function(){
            var level=$('#level').val();
            var fdata=$('#faddrelasi').serialize();
            var urlrel=base_url + '/addrelasi';
            $.ajax({
              
                url  : urlrel,
                type : 'POST',
                data : fdata, 
                dataType: 'json',
				success: function(result){
                  location.reload();
                }
            })
            
        })

        function getrelasi(){
            var urlrel= base_url + '/getrelasi2';
            $.ajax({
                url: urlrel,
                type: 'get',
                data :{token:token},
                success: function(result) {
                var res = JSON.parse(result);
                    $('#relasikonten').html(res);
                 
                }
            })
        }

        function getlist(){
            var urlrel= base_url + '/searchpesertacompany2';
            $.ajax({
                url: urlrel,
                type: 'get',
                data :{company:comp},
                success: function(result) {
                    var res=JSON.parse(result);
                    var disp="";
                    for ( var i=0;i < res.length ;i++){
                       console.log(res[i]);
                        disp += "<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
                        
                    }
                    $('#relasi').html(disp);
                }
            })
        }
      })
</script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>