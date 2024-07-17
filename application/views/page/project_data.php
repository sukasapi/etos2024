<!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Perusahaan</h1>
            <a href="#" data-toggle="modal" data-target="#madd" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> 
            Add
            </a>
        </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Project</h6>
                        </div>
                        <div class="card-body">
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
                         <strong>GAGAL</strong>
                         <p><?=$this->session->flashdata('error')?></p>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                         </button>
                      </div>
                      <?php
                  }else{
                  }
                  ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tbperusahaan" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Project</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Status</th>
                                            <th>Registered</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        <?php
                                            $no=1;
                                            $str="";
                                            foreach($project as $p){
                                                $str .="<tr>";
                                                $str .="<td>".$no."</td>";
                                                $str .="<td>".$p->nama."</td>";
                                                $str .="<td>".date('d-m-Y',strtotime($p->date_start))."</td>";
                                                $str .="<td>".date('d-m-Y',strtotime($p->date_end))."</td>";
                                                $str .="<td>".$p->status."</td>";
                                                $str .="<td>".date('d-m-Y',strtotime($p->date_create))."</td>";
                                                $str .="<td>
                                                <a href='' class='btn editbt btn-warning btn-circle btn-sm' data-token='".$this->encryption->encrypt($p->id)."'>
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

<!-- MODAL -->
<!--ADD MODAL-->
<div class="modal fade" id="madd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrasi Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fadd">
      <div class="modal-body">
         
        <div class="form-group">
            <label for="nama">Nama Project / Event</label>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="masukkan nama perusahaan">
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="start">Tanggal Mulai</label>
                   <input  class="form-control" type="date" name="start" id="start">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="end">Tanggal selesai</label>
                   <input class="form-control" type="date" name="end" id="end">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
           <select name="status" class="form-control" id="status">
                <option value='aktif'>Aktif</option>
                <option value='nonaktif'>Non Aktif</option>
           </select>
        </div>
        <div class="form-group">
            <label for="status">Deskripsi Event</label>
            <textarea name="deskripsi" class="form-control" rows="8"></textarea>
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
<!--END ADD MODAL-->
<!--ADD MODAL-->
<div class="modal fade" id="medit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fedit">
      <input type="hidden" name="token" id="token">
      <div class="modal-body">
        <!------->
        <div class="form-group">
            <label for="nama">Nama Project</label>
            <input type="text" name="namaedit" id="namaedit" class="form-control" placeholder="Masukkan nama project">
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="startedit">Tanggal Mulai</label>
                   <input  class="form-control" type="date" name="startedit" id="startedit">
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                    <label for="endedit">Tanggal selesai</label>
                   <input class="form-control" type="date" name="endedit" id="endedit">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
           <select name="statusedit" class="form-control" id="statusedit">
                <option value='aktif'>Aktif</option>
                <option value='nonaktif'>Non Aktif</option>
           </select>
        </div>
        <div class="form-group">
            <label for="status">Deskripsi Event</label>
            <textarea name="deskripsiedit" id="deskripsiedit" class="form-control" rows="8"></textarea>
        </div>
        <!------>
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btedit" class="btn btedit btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--END ADD MODAL-->
<!-- END MODAL -->
<!-- /.container-fluid -->
 <!-- Page level plugins -->
 <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
       
        $('#tbperusahaan').DataTable();

        $("#btadd").on('click', function(event){
            event.preventDefault();
           var urladd=base_url + '/addpro';
           var datain=$('#fadd').serializeArray();
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

        })

        $(".editbt").on('click',function(event){
            event.preventDefault();
            $('#medit').modal('show');
            var token = $(this).data('token');
            $('#token').val(token);
            $('#kodeedit').attr('readonly', true);
            searchcompany(token);
        })

        $(".btedit").on('click',function(event){
            var editurl=base_url + 'editpro';
            var dataed=$('#fedit').serializeArray();
            $.ajax({
                url  : editurl,
                type : 'POST',
                data : dataed,
                dataType: 'json',
				success: function(result){
                  if(result.res == "ok"){
                        location.reload();
                    }else{
                        location.reload();
                    }
				}
           })
        })      


        function searchcompany(token){
            var urledit=base_url + '/searchpro';
            $.ajax({
				url: urledit,
                data: { token : token},
                type: 'get',
                success: function(result) {
                    console.log(result);
                    var res=JSON.parse(result);
                   
                    $('#namaedit').val(res[0].nama);
                    $('#deskripsiedit').val(res[0].deskripsi);
                    $('#startedit').val(res[0].date_start);
                    $('#endedit').val(res[0].date_end);
                    $('#status').val(res[0].status);
                 
                }
            })
        }
    });
</script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>