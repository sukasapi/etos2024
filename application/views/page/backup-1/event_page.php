<div id="content">
<!-- Begin Page Content -->
    <div class="container-fluid">
        <?php 
            foreach($project as $p){
        ?>
           <div class="row pt-4">
            <div class="col-xxl-4 col-xl-12 mb-4">
                <div class="card h-100">
                        <div class="card-body h-100 p-5">
                            <div class="row align-items-center">
                                <div class="col-xl-5 col-xxl-12">
                                    <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                        <h1 class="text-primary"><?=$p->nama?></h1>
                                        <p class="text-gray-700 mb-0"><?=$p->deskripsi?></p>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-xxl-12 text-center">
                                    <h4>Tanggal Evaluasi</h4>
                                    <p><?=date('d-m-Y',strtotime($p->date_start))?> Hingga <?=date('d-m-Y',strtotime($p->date_end))?></p>
                                </div>
                                <div class="col-xl-2 col-xxl-12 text-center">
                                <a href="<?= base_url('userdashboard') ?>" class="btn btn-primary rounded-pill me-2 my-1">Ikuti Evaluasi Ini</a>
                            </div>
                                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }
        ?>
 
</div>