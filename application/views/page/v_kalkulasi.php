<div id="content">

<!-- Begin Page Content -->

    <div class="container-fluid">

    <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800"><a href="<?=base_url('kalkulasi')?>"><i class="fas fa-fw fa-arrow-circle-left  text-warning"></i></a> Data Kalkulasi </h1>

        </div>


    <!-- FILTER KALKULASI-->    
        <div class="row my-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center"><p>Pilih terlebih dahulu batch yang akan dikalkulasi ulang.</p></div>
                        <form action="<?=base_url('kalkulasi/kalkulasi_NPS')?>" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="batch">Batch</label>
                                <input type ="text" value ="all" class="form-control" name="batch">
                                <small><i>* Jika batch lebih dari 1 maka gunakan pemisah koma tanpa spasi (1,2,3,dst)</i></small>
                            </div>  
                            <input type="submit" class="btn btn-primary form-control" value="kalkulasi"> 
                            <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">                  
                        </form>
                    </div>
                </div>
              
            </div>
        </div>

        <?php 
            if(isset($pesan) && count((Array)$pesan) > 0){
        ?>
        <div class="row my-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Data Calculation Result
                    </div>
                    <div class="card-body text-center">
                        <h4> Data kalkulasi data sebanyak <strong><?=$proses?></strong> dalam <strong><?=round($xtime,2)?></strong> detik</h4>
                        <a href="<?=base_url("kalkulasi/kalkulasi_hasil")?>" class="btn btn-info btn-rounded">Lihat hasil Kalkulasi</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }else{

            }

        ?>
    </div>
</div>
