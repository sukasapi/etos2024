<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><?=$PageTitle?></h1>
        </div>
        <div class="row">
            <?php  
         
                foreach($project as $p){
                    ?>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <a href="<?=base_url('starttes')?>">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                           <?=$p->nama?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php 
                                           
                                        ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                            </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }

            ?>
           
        </div>

</div>