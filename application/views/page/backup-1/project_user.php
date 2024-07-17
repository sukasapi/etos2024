<!-- Begin Page Content -->
<link href="<?=base_url('assets/')?>css/picklist.css" rel="stylesheet">
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><?=$PageTitle;?></h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#madd">
                <i class="fas fa-plus fa-sm text-white-50"></i> 
                Registrasi
            </a>
        </div>

         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?=$PageName?></h6>
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
                  }else if($this->session->flashdata('info')){
                    ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                       <strong>Informasi</strong>
                       <p><?=$this->session->flashdata('info')?></p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                       </button>
                    </div>
                    <?php
                  }else{

                  }
                  ?>
                       
                    <div class="table-responsive">
                                <table class="table table-bordered" id="tbregis" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIP<small>(*sebagai username)</small></th>
                                            <th>Nama</th>
                                            <th>Perusahaan</th>
                                            <th>Bagian</th>
                                            <th>Jabatan</th>
                                            <th>Project</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                          $str ="";
                                          $no =1;
                                            foreach($regis as $r){
                                              
                                                $str .="<tr>";
                                                $str .="<td>".$no."</td>";
                                                $str .="<td>".$r->nopeg."</td>";
                                                $str .="<td>".$r->nama."</td>";
                                                $str .="<td>".$r->nama_perusahaan."</td>";
                                                $str .="<td>".$r->bagian."</td>";
                                                $str .="<td>".$r->jabatan."</td>";
                                                $str .="<td>".$r->project."</td>";
                                                $str .="<td></td>";
                                                $str .="</tr>";
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
<!-- MODAL -->
<!--ADD MODAL-->
<div class="modal fade" id="madd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrasi Peserta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fadd">
      <div class="modal-body">
        <div class="form-group">
            <label for="userpass">Data Perusahaan</label>
            <select name="perusahaan" class="form-control" id="perusahaan">
                <option selected disabled readonly>- Pilih Perusahaan -</option>
                <?php 
                    foreach($perusahaan as $c){
                        echo "<option value='".$c->id."'>".$c->nama."</option>";
                    }
                ?>
            </select> 
        </div>
        <div class="form-group">
            <label for="project">Project / Evaluasi</label>
            <select name="project" class="form-control" id="project">
                <option selected disabled readonly>- Pilih Perusahaan lebih dulu -</option>
            </select> 
        </div>
        <div class ="form-group">
            <label for="peserta">Peserta</label>   
          
                    <div id="list">

                    </div>
               
         
        </div>
       
        <div id="wait" class="text-center" hidden>
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

       
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
      </div>
      <div class="modal-footer">
      <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btadd" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--- ./END ADD MODAL -->

<!--- ./END MODAL -->

 <!-- Page level plugins -->
 <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
 <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <script src="<?=base_url('assets/')?>js/picklist.js"></script>

 
 <script>
      $(document).ready(function() {
       
       $('#tbregis').DataTable({
           "language":{
               "emptyTable": "belum ada data"
           }
       });

       $('#perusahaan').on('change',function(e){
           var comp = $(this).val();
           var res=getproject(comp);
           var html="";
           for(var i=0; i < res.length ; i++){
               html +="<option selected disabled readonly>- Pilih Project lebih dulu -</option>";
               html +="<option value='"+ res[0].id +"'>"+ res[0].nama +"</option>";
           }
           $('#project').html(html);
           $('#list').html('');

       })
       $('#project').on('change',function(e){
           var proyek = $(this).val();
           $('#list').html('');
           getregister(proyek);
       })
       $('#btadd').on('click',function(){
        var addurl=base_url + 'addregis';
        var terpilih=a.pickList('getSelected');
        var project=$('#project').val();
        var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
        var csrfHash = $('.txt_csrfname').val(); // CSRF hash
        const dataregis=[];
        for(var i=0; i < terpilih.length ;i++){
            dataregis[i]=terpilih[i].id;
        }
        
       
        $.ajax({
                url  : addurl,
                type : 'POST',
                data : {project:project,peserta:dataregis,remolis : remolis,[csrfName]: csrfHash },
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

            
        function getregister(proyek){
            var data2=getdatauser(proyek);
            let remolis =[];
            var a = $('#list').pickList({
                data: data2,
                 buttons:[
                     {
                        action:'add',
                        label: 'Tambah',
                        className: 'btn btn-sm btn-block btn-primary'
                     },
                     {
                        action:'addAll',
                        label: 'Tambah Semua',
                        className: 'btn btn-sm btn-block btn-info'
                     },
                     {
                         action: 'remove',
                         label: 'Hapus',
                         className: 'btn btn-sm btn-block btn-warning'
                     },
                     {
                        action:'removeAll',
                        label: 'Hapus semua',
                        className: 'btn btn-sm btn-block btn-danger'
                     },

                 ]
            });

          a.on('picklist.remove', function (event, v) {
                remolis.push(v);
                return remolis;
            });
        }
        function getdatauser(project){
                var url = base_url + 'peserta';
                let returnval= null;
                //var project=$('#project').val();
                $.ajax({
				url: url,
                async: false,
                data: {project : project},
                type: 'get',
                success: function(result) {
                    console.log(result);
                    var res=JSON.parse(result);
                    returnval = res;
                }
            })
            return returnval;
        }

        function getproject(company){
                var url = base_url + 'projectcompany';
                let returnval= null;
                //var project=$('#project').val();
                $.ajax({
				url: url,
                async: false,
                data: {company : company},
                type: 'get',
                success: function(result) {
                    console.log(result);
                    var res=JSON.parse(result);
                    returnval = res;
                }
            })
            return returnval;
        }

      })
 </script>
 <script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>