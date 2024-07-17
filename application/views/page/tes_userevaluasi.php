  <!-- Main Content -->
  <div id="content">


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=$pageTitle?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php 
      
            foreach($project as $p){
                ?>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                               <?=$p->project?></div>
                                        </div>
                                        <div class="col-auto">
                                            <a href='' class="pilihtes" data-project="<?=$this->encryption->encrypt($p->idpro)?>"><i class="fas fa-comments fa-2x text-gray-300"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
            }
        ?>
        <!-- Pending Requests Card Example -->
      
    </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
  
<!-- MODAL -->
<!--ADD MODAL-->
<div class="modal fade show" id="mdjenis" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Evaluasi Apa Yang Anda Pilih ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="fadd">
      <div class="modal-body">
          <div class="row">
            
          <?php
            
                foreach($jenis as $j){
                    echo "<div class='col-md-12 col-sm-12 mb-2'>";
                    echo "<button class='btn btn-block btn-xl btn-info goto' data-pc='".$j->id."' data-nilai='".$this->encryption->encrypt($j->id)."'>".$j->nama." - ".$j->tipe_nilai."</button>";
                    echo "</div>";
                }
            ?>
            <input type="hidden" name="proyek" id="proyek" >
          </div>
            
        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>
      </div>
    </div>
  </div>
</div>
<!--END ADD MODAL-->

<!-- END MODAL -->

<script>
    $(document).ready(function() {

      
        $('.pilihtes').on('click',function(e){
            e.preventDefault();
            project = $(this).data('project');
            $('#mdjenis').modal('show');
            $('#proyek').val(project);
        });
        
        $('.goto').click(function(e){
            e.preventDefault();
            var eval = $(this).data('nilai');
            var proyek =$('#proyek').val();
            
            var urlprep=base_url + '/preparetes';
            var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
            var csrfHash = $('.txt_csrfname').val(); // CSRF hash

            $.ajax({
                url  : urlprep,
                type : 'POST',
                data : {proyek : proyek,eval : eval , [csrfName]: csrfHash},
                dataType: 'json',
				success: function(result){
                  if(result.res == "ok"){
                        location.replace(base_url + "pilihtarget/" + result.project +"/"+ result.eval);
                    }else{
                        location.reload();
                    }
                  
				}
           })
            
        })
        

        function prepare(){
          
            
        }

        
    })
</script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>