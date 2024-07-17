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
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Pertanyaan</h6>
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
                                <table class="table table-bordered" id="tbpertanyaan" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Evaluasi</th>
                                            <th>Soal</th>
                                            <th>Tipe</th>
                                            <th>Asisten</th>
                                            <th>Komoditas</th>
                                            <th>Unit Kerja</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        <?php
                                            $no=1;
                                            $str="";
                                        
                                            foreach($soal as $s){
                                                $komoditas = empty($s->komoditas)?"semua komoditas":$s->komoditas;
                                                $jenis =  empty($s->jenis_asisten)?"semua jenis asisten":$s->komoditas;
                                                $unit =  empty($s->unit_kerja)?"semua unit kerja":$s->unit_kerja;
                                            $str .="<tr>";
                                            $str .="<td>".$no."</td>";
                                            $str .="<td>".$s->nama_evaluasi."</td>";
                                            $str .="<td>".$s->soal."</td>";
                                            $str .="<td>".$s->tipe_nilai."</td>";
                                            $str .="<td>".$s->jenis_asisten."</td>";
                                            $str .="<td>".$komoditas."</td>";
                                            $str .="<td>".$unit."</td>";
                                            $str .="<td><button class='btn btn-sm btn-info bt-desk' data-urut='".$this->encryption->encrypt($s->id)."'>Lihat deskripsi</td>";
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

<!-- MODAL -->
<!--ADD MODAL-->
<div class="modal fade show" id="madd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Registrasi Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
      <form id="fadd">
        <div class="form-group">
            <label for="tipe">Tipe Soal</label>
            <select name="tipe" class="form-control">
                  <option value="multiple">Multiple choice</option>
                  <option value="single">Single Choice</option>                    
            </select>
        </div>
        <div class="form-group">
            <label for="value">Nilai Perusahaan</label>
            <select name="value" class="form-control">
                <?php 
                    foreach($value as $v){
                        echo "<option value='".$this->encryption->encrypt($v->id)."'>".ucfirst($v->nama)."</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="pertanyaan">Pertanyaan</label>
            <textarea  rows="8" name="pertanyaan" class="form-control" placeholder="masukkan pertanyaan anda"></textarea>
        </div>
        <div class="form-group">
            <label for="bobot">Bobot soal (*jika ada)</label>
            <input type="number" name="bobot" value="0" min="1" class="form-control">
       </div>
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        </form>
        <hr>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btadd" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--END ADD MODAL-->
<!--EDIT MODAL-->
<div class="modal fade show" id="medit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        <div class="form-group">
            <label for="namaedit">Nama Perusahaan</label>
            <input type="text" name="namaedit" id="namaedit" class="form-control" placeholder="masukkan nama perusahaan">
        </div>
        <div class="form-group">
            <label for="kodeedit">Kode Perusahaan</label>
            <input type="text" readonly name="kodeedit" id="kodeedit" class="form-control" placeholder="masukkan kode perusahaan misal PT01">
        </div>
        <div class="form-group">
            <label for="alamatedit">Alamat Perusahaan</label>
           <textarea name="alamatedit" id="alamatedit" class="form-control" placeholder="masukkan alamat perusahaan" rows="8"></textarea>
        </div>
        <div class="form-group">
            <label for="statusedit">Status</label>
                <select class="form-control" name="statusedit" id="statusedit">
                    <option value="aktif">aktif</option>
                    <option value="nonaktif">non aktif</option>
                </select>
        </div>
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
<!--END EDIT MODAL-->

<!--EDIT MODAL-->
<div class="modal" id="mdesk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Perusahaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div id="deskripsisoal">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
        <button type="button" id="btedit" class="btn btedit btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>
      </div>
    </div>
  </div>
</div>
<!--END EDIT MODAL-->
<!-- END MODAL -->
<!-- /.container-fluid -->
 <!-- Page level plugins -->
 <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
       
        $('#tbpertanyaan').DataTable();

        $("#btadd").on('click', function(event){
            event.preventDefault();
           var urladd=base_url + '/addsoal';
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
        
        $(".addjawab").on('click',function(event){
            event.preventDefault();
            var stoken=$(this).data('token');
            var url=base_url + "addjawab/" + stoken;
            //alert(url);
            location.replace(url); 
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
            var editurl=base_url + 'editcomp';
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
      
        $(document).on('click', '.bt-desk', function(e) {
            var token = $(this).data('urut');
            $('#mdesk').modal('show');
            var urledit=base_url + '/getdesk';
            const box = document.getElementById('deskripsisoal');
            $.ajax({
				url: urledit,
                data: { token : token},
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
                    var konten =res.deskripsi;

                  $("#deskripsisoal").html(textToHTML(konten));
                }
            })

            
        })


        function searchcompany(token){
            var urledit=base_url + '/searchcomp';
            $.ajax({
				url: urledit,
                data: { token : token},
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
                   
                    $('#namaedit').val(res[0].nama);
                    $('#kodeedit').val(res[0].kode);
                    $('#alamatedit').val(res[0].alamat);
                    $('#statusedit').val(res[0].is_aktif);
                }
            })
        }

        var support = (function () {
	if (!window.DOMParser) return false;
	var parser = new DOMParser();
	try {
		parser.parseFromString('x', 'text/html');
	} catch(err) {
		return false;
	}
	return true;
})();

var textToHTML= function (str) {

	// check for DOMParser support
	if (support) {
		var parser = new DOMParser();
		var doc = parser.parseFromString(str, 'text/html');
		return doc.body.innerHTML;
	}

	// Otherwise, create div and append HTML
	var dom = document.createElement('div');
	dom.innerHTML = str;
	return dom;

};
        

    });
</script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>