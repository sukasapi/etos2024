<!-- Begin Page Content -->
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><?=$pageName?></h1>
        </div>
         
        <div class="row">
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
            <div class="col-md-6 col-xs-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h1 class="h3 mb-2 text-gray-800">Koneksi Atasan</h1>
                            <a href="#" data-toggle="modal" data-target="#maddatasan" id="bmadatasan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> 
                            Add Atasan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                             
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tbatasan" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peserta</th>
                                            <th>Atasan</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        <?php
                                        
                                            $no=1;
                                            $str="";
                                            foreach($dtatasan as $a){
                                                $str .="<tr>";
                                                $str .="<td>".$no."</td>";
                                                $str .="<td>".$a->peserta."</td>";
                                                $str .="<td>".$a->atasan."</td>";
                                                $str .="<td>".$a->level."</td>";
                                                $str .="<td>".$a->status."</td>";
                                                $str .="<td>
                                                <a href='' class='btn editbt btn-warning btn-circle btn-sm' data-token='".$this->encryption->encrypt($a->idrel)."'>
                                                <i class='fas fa-edit'></i>
                                                </a>
                                                </td>";
                                                $str .="</tr>";
                                            }
                                            $no++;
                                            echo $str;

                                        ?>
                                     
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h1 class="h3 mb-2 text-gray-800">Koneksi Mitra</h1>
                            <a href="#" data-toggle="modal" data-target="#maddmitra" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-plus fa-sm text-white-50"></i> 
                            Add mitra
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="row">
                            <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tbmitra" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Peserta</th>
                                            <th>Mitra</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        <?php
                                            $no=1;
                                            $str="";
                                            foreach($dtmitra as $m){
                                                $str .="<tr>";
                                                $str .="<td>".$no."</td>";
                                                $str .="<td>".$m->peserta."</td>";
                                                $str .="<td>".$m->atasan."</td>";
                                                $str .="<td>".$m->level."</td>";
                                                $str .="<td>".$m->status."</td>";
                                                $str .="<td>
                                                <a href='' class='btn editbt btn-warning btn-circle btn-sm' data-token='".$this->encryption->encrypt($m->idrel)."'>
                                                <i class='fas fa-edit'></i>
                                                </a>
                                                </td>";
                                                $str .="</tr>";
                                            }
                                            $no++;
                                            echo $str;

                                        ?>
                                     
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!--  END CONTAINER --> 

<!--  MODAL --> 
<!--ADD MODAL ATASAN-->
<div class="modal" id="maddatasan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Relasi Atasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="faddatasan">
    <div class="modal-body">
        <div class="form-group">
            <label for="perusahaan">Perusahaan</label>
           <select name="perusahaan" class="form-control" id="perusahaan">
               <option disabled selected>Pilih perusahaan </option>
               <?php 
                    foreach($perusahaan as $c){
                        echo "<option value='".$c->id."'>".$c->nama."</option>";
                    }
               ?>
           </select>
        </div>
        <div class="form-group">
            <label for="nama">Nama Atasan</label>
            <select name="atasan" class="form-control" id="atasan">
            <option disabled selected>Pilih Atasan </option>
               <?php 
                    foreach($peserta as $ps){
                        echo "<option value='".$this->encryption->encrypt($ps->id)."'>".$ps->nama."</option>";
                    }
               ?>
           </select>
        </div>
        <div class="form-group">
            <label for="nama">Nama Karyawan</label>
            <select name="bawahan" class="form-control" id="bawahan">
                <option disabled selected>Pilih Bawahan </option>
               <?php 
                    foreach($peserta as $ps){
                        echo "<option value='".$this->encryption->encrypt($ps->id)."'>".$ps->nama."</option>";
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
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btadd" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--END ADD MODAL ATASAN-->
<!-- ADD MODAL ATASAN -->
<!-- EDIT ATASAN -->
<div class="modal fade show" id="meditatasan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Relasi Atasan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="feditatasan">
    <div class="modal-body">
        <div class="form-group">
            <label for="editperusahaan">Perusahaan</label>
           <select name="editperusahaan" class="form-control" id="editperusahaan">
               <option disabled selected>Pilih perusahaan </option>
               <?php 
                    foreach($perusahaan as $c){
                        echo "<option value='".$c->id."'>".$c->nama."</option>";
                    }
               ?>
           </select>
        </div>
        <div class="form-group">
            <label for="editatasan">Nama Atasan</label>
            <select name="editatasan" class="form-control" id="editatasan">
            <option disabled selected>Pilih Atasan </option>
                                     
           </select>
        </div>
        <div class="form-group">
            <label for="editbawahan">Nama Karyawan</label>
            <select name="editbawahan" class="form-control" id="editbawahan">
                <option disabled selected>Pilih Bawahan </option>
             
           </select>
        </div>
       
        <div class="form-group">
            <label for="editstatus">Status</label>
           <select name="editstatus" class="form-control" id="editstatus">
                <option value='aktif'>Aktif</option>
                <option value='nonaktif'>Non Aktif</option>
           </select>
        </div>
        <input type="hidden" id="tokenrel" name="tokenrel">
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btedit" data-token='' class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit ATASAN -->
<!--  END MODAL --> 
<!-- Page level plugins -->
<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script> 
<script>
      $(document).ready(function() {
        $('#tbatasan').DataTable();
        $('#tbmitra').DataTable();

        $('#bmaddatasan').click(function(){
            $('#maddatasan').modal('show');
        })
        $('#perusahaan').on('change', function(){
            getpeserta($(this).val());
        });

        $('#btadd').on('click',function(){
           var urladd=base_url + '/addatasan';
           var datain=$('#faddatasan').serializeArray();
            $.ajax({
                url  : urladd,
                type : 'POST',
                data : datain,
                dataType: 'json',
				success: function(result){
					if(result.res == "ok"){
                        location.reload();
                    }else{
                        location.reload();
                    }
				}
           })
        });

        $('.editbt').on('click',function(e){
            e.preventDefault();
            var token=$(this).data('token');
            searchatasan(token);
            $('#meditatasan').modal('show');
        })
        $('#btedit').on('click',function(e){
            var urledit=base_url + '/editatasan';
           var datain=$('#feditatasan').serializeArray();
            $.ajax({
                url  : urledit,
                type : 'POST',
                data : datain,
                dataType: 'json',
				success: function(result){
					/*if(result.res == "ok"){
                        location.reload();
                    }else{
                        location.reload();
                    }*/
				}
           })
        })
        $('#editperusahaan').on('change', function(){
            getpeserta($(this).val());
        });

        function getpeserta(company){
            var urlcari=base_url + '/searchpesertacompany';
            $.ajax({
				url: urlcari,
                data: {company : company},
                type: 'get',
                success: function(result) {
                    $('#atasan').html(JSON.parse(result));
                    $('#bawahan').html(JSON.parse(result));
                }
            })
        }
        function geteditpeserta(company){
            var urlcari=base_url + '/searchpesertacompany';
            $.ajax({
				url: urlcari,
                data: {company : company},
                type: 'get',
                success: function(result) {
                    if(JSON.parse(result).length > 0){
                        $('#editatasan').html(JSON.parse(result));
                        $('#editbawahan').html(JSON.parse(result));
                    }else{
                        $('#editatasan').html(JSON.parse(result));
                        $('#editbawahan').html(JSON.parse(result));
                    }
                   
                }
            })
        }
        function searchatasan(token){
            var urlcari=base_url + '/searchatasan';
            $.ajax({
				url: urlcari,
                data: {token : token},
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
               
                   $('#editatasan').val(res.idatasan);
                   $('#editbawahan').val(res.idbawahan);
                   $('#editperusahaan').val(res.idperusahaan);
                   $('#editstatus').val(res.status);
                   $('#tokenrel').val(res.idrel);
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