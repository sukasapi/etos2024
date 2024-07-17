<!-- Begin Page Content -->
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><?=$pageTitle;?></h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="btmd" data-toggle="modal" data-target="#madduser">
                <i class="fas fa-plus fa-sm text-white-50"></i> 
            Add
            </a>
        </div>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?=$pageName?></h6>
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
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tbuser" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>username</th>
                                            <th>Status</th>
                                            <th>Tanggal Pembuatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                      
                                        <?php 
                                            $str ="";
                                            $no = 1;
                                            foreach($datauser as $du){
                                                $str.="<tr>";
                                                $str.="<td>".$no."</td>";
                                                $str.="<td>".$du->uname."</td>";
                                                $str.="<td>".$du->status."</td>";
                                                $str.="<td>".date('d-M-Y H:i:s',strtotime($du->date_create))."</td>";
                                                $str.="<td>
                                                            <a href='' data-toggle='modal' data-target='#medituser' data-ed='".$this->encryption->encrypt($du->id)."' class='editbt btn btn-warning btn-circle btn-sm'>
                                                            <i class='fas fa-edit'></i>
                                                            </a>
                                                            
                                                            
                                                       </td>";
                                                $str.="</tr>";
                                                $no++;
                                            }
                                            echo $str;
                                        ?>
                                      
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
            </div>
</div>
<!-- /.container-fluid -->

<!-- MODAL -->
<!--ADD MODAL-->
<div class="modal fade" id="madduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fadd">
      <div class="modal-body">
        <div class="form-group">
            <label for="username">Username Pengguna</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="userpass">Password Pengguna</label>
            <input type="password" name="userpass" id="userpass" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Autorisasi Pengguna</label>
            <select name="status" class="form-control" id="status">
                <?php
                    $utype=usertype();
                    foreach($utype as $t){
                        echo "<option value='".$t."'>".$t."</option>";
                    }
                ?>                        
            </select>
        </div>
        <div class="form-group">
            <label for="status">Perusahaan</label>
            <select name="perusahaan" class="form-control" id="perusahaan">
             <?php 
                $strcomp="";
                foreach($perusahaan as $pr){
                    $strcomp .="<option value='".$pr->id."'>".$pr->nama."</option>";  
                }
                echo $strcomp;
              ?>
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

<!--EDIT -->
<div class="modal fade" id="medituser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Pengguna</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="fedit">
      <div class="modal-body">
      <div id="compedit"></div>
        <div class="form-group">
            <label for="username">Username Pengguna</label>
            <input type="text" name="username" readonly id="edituser" class="form-control edituser">
        </div>
        <div class="form-group">
            <label for="editstatus">Autorisasi Pengguna</label>
            <select name="status" class="form-control editstatus" id="editstatus">
                <?php
                    $utype=usertype();
                    foreach($utype as $t){
                        echo "<option value='".$t."'>".$t."</option>";
                    }
                ?>                        
            </select>
        </div>
        <div class="form-group">
            <label for="status">Perusahaan</label>
            <select name="perusahaanedit" class="form-control" id="perusahaanedit">
            
            </select>
        </div>
        <div class="form-group">
            <label for="editaktif">Aktif</label>
            <select name="aktif" class="form-control editaktif" id="editaktif">
                    <option value='1'>Aktif</option>
                    <option value='0'>Non Aktif</option>
            </select>
            <input type="hidden" name="id" id="edui">
        </div>
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btreset"  class="btn btn-info" data-token='' ><i class="fas fa-key text-white-50"></i> Reset password</button>
        <button type="button" id="btedit" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- / .MODAL -->
 <!-- Page level plugins -->
 <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
       
       
        $('#tbuser').DataTable();

        $('#btadd').click(function(){
           
           var urladd=base_url + '/adduser';
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

        $(document).on('click', '.editbt', function(e) {
            var idus=$(this).data('ed');
            $('#btreset').attr('data-info', idus);
            getuser(idus);
            getcompany();
        })

        $('#status').on('change',function(){

        })


       $("#btedit").on('click', function(event){
            var editurl=base_url + 'edituser';
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
       } ) 


       $("#btreset").on('click', function(event){
            var reseturl=base_url + 'resetuser';
            var ediu=$(this).data('info');
            // CSRF Hash
			 var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
          	 var csrfHash = $('.txt_csrfname').val(); // CSRF hash
            $.ajax({
                url  : reseturl,
                type : 'POST',
                data :{ediu :ediu,[csrfName]: csrfHash },
                dataType: 'json',
				success: function(result){
                    location.reload();
                }

            })
       } ) 



        function getuser(idus){
            var urledit=base_url + '/edituser';
            $.ajax({
				url: urledit, 
                data: { idus : idus},
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
                    $('#edituser').val(res.uname);
                    $('#editstatus').val(res.status);
                    $('#editaktif').val(res.isaktif);
                    $('#edui').val(res.id);
                }
            })
        }
        
        function getcompany(){
            var urledit=base_url + '/searchcomp2';
           
            $.ajax({
                url: urledit, 
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
                    var opt="<option>- Tidak ada -</option>";
                   for(var i=0; i < res.length ; i++){
                        opt +="<option value='"+ res[i].id +"' "+res[i].stat+">" + res[i].nama + "</option>";
                   }
                   $('#perusahaanedit').html(opt);
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