<!-- Begin Page Content -->
<div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><?=$PageTitle?></h1>
          
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary"> SOAL</h4>
            </div>
            <div class="card-body">
            <h4><?=$soal[0]->pertanyaan;?></h4>
            <div hidden id="token" data-token="<?=$this->encryption->encrypt($soal[0]->id) ?>"></div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h4 class=" d-flex justify-content-between align-items-center">
                <div class="m-0 font-weight-bold text-primary">
                  JAWABAN
                </div>
                <a href="#" id="badd" data-token="<?=$this->encryption->encrypt($soal[0]->id) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> 
                    Add
                </a>
            </h4>
            </div>
            <div class="card-body">
                <div id="jawab">

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
        <h5 class="modal-title" id="exampleModalLongTitle">Registrasi Jawaban</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    
      <div class="modal-body">
      <form id="fadd">
        <div class="form-group">
            <label for="inisial"></label>
            <input type="text"  id="inisial"  name="inisial" placeholder="masukkan inisial soal (misal: A, B, C)" class="form-control">
        </div>
        <div class="form-group">
            <label for="jawaban">Pertanyaan</label>
            <textarea  rows="4" name="jawaban" class="form-control" id="jawaban" placeholder="masukkan jawaban anda"></textarea>
        </div>
        <div class="form-group">
            <label for="bobot">Bobot soal (*jika ada)</label>
            <input type="number" name="bobot" value="1" min="1" class="form-control">
       </div>
       <div class="form-group">
            <label for="nilai">Nilai soal</label>
            <input type="number" name="nilai" value="0" min="0" max="1" class="form-control">
       </div>
       <div class="form-group">
            <label for="statusedit">Status Jawaban</label>
                <select class="form-control" name="statusjawaban" id="statusjawaban">
                    <option value="aktif">aktif</option>
                    <option value="nonaktif">non aktif</option>
                </select>
        </div>
        <input type="hidden" id="stoken" name="stoken" value="">

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

<!-- END MODAL -->

<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
     $(document).ready(function() {
        var token=$('#token').data('token');
        readjawab(token);
        //alert(token);
        $("#badd").on('click', function(event){
            event.preventDefault();
            $("#madd").modal('show');
            var stoken=$(this).data('token');
            $("#stoken").val(stoken);
        });

        $("#btadd").on('click', function(event){
            event.preventDefault();
           var urladd=base_url + '/addjawaban';
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

        $(".editbt").on('click', function(event){
            //vent.preventDefault();
            var token = $(this).data('token');
            alert("helllo");
        })

        function readjawab(){
            var urlsearch=base_url + 'searchjawab';
            $.ajax({
				url: urlsearch,
                data: { token : token},
                type: 'get',
                success: function(result) {
                    var res=JSON.parse(result);
                
                    var html="";
                   if(res.length > 0){
                   let sumskor=0;
                    for (var s=0;s < res.length;s++){
                        sumskor += parseInt(res[s].bobot);
                    }
                    let total=0;
                    for( var i=0; i < res.length ; i++){
                        html +="<div class='row mb-4'>";
                        html += "<div class='col-1'>" + res[i].inisial + "</div>"; 
                        html += "<div class='col-8'>" + res[i].jawaban + "</div>"; 
                        let skorbobot=res[i].bobot/sumskor;

                        html += "<div class='col-2'> bobot: " + skorbobot + "</div>"; 
                        html += "<div class='col-1'>"  + "<button class='btn editbt btn-warning btn-circle btn-sm' data-token='" + res[i].id +"'><i class='fas fa-edit'></i></button>"
                                +"</div>";
                        html +="</div>"
                        total +=skorbobot;
                      }
                      html +="<div class='row'>";
                      html +="<div class='col-12 text-center'> Bobot Total Jawaban : " + total +" <small>(Cek nilai harus selalu 1)</small><div>";
                      html +="</div>";

                    }else{
                        html +="<h5> Belum ada data jawaban</h5>";
                    }
                   
                    $("#jawab").html(html);
                  
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