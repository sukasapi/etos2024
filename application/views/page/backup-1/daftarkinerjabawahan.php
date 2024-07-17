<?php



?>

<!-- Begin Page Content -->
<div class="container-fluid">
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">
           
           <div class="col-6">
           <h1 class="h3 mb-2 text-gray-800">Daftar Penilaian Kinerja</h1>
           </div> 
   </div>

   <div class="row pb-5">
        <?php
            
            $ada=0;
            $idx=0;
            foreach($bawahankinerja as $bk){
                //print_r($bk['peserta']);
                ?>
                    <div class="col-md-6 col-xs-12 pb-2">
                        <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample<?=$idx?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kinerja <?=$bk['peserta']->nama?></h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse" id="collapseCardExample<?=$idx?>">
                                    <div class="card-body">
                                        <div class="row">
                                           <?php 
                                           $ada = count((array)$bk['evaluasi']);
                                            if($ada > 0){
                                                foreach($bk['evaluasi'] as $e){
                                                    ?>
                                                        <div class="col-md-12 col-xs-12">
                                                            <a href="<?=base_url('startevaluasi/').$e->id?>" class="btn btn-primary btn-block"><?=$e->bulan?> - <?=$e->tahun?></a> 
                                                        </div>
                                                    <?php
                                                }
                                               
                                            }else{
                                                echo "<h4> Peserta ini belum memiliki data Kinerja</h4>";
                                            }
                                           ?>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                <?php
                $idx++;
            }
           /* foreach($evaluasi as $e){
              if($e->bulan =='' || $e->bulan=''){
               
              }else{
                $ada++;
              }
            }
            if($ada > 0){
                foreach($evaluasi as $e){
                    echo "<button class='btn btn-primary '>Data Kinerja ".$e->bulan." tahun ".$e->tahun."</button>";
                }
            }else{
                echo "<div class='col-md-12 col-xs-12'>";
                echo "
                    <div class='alert alert-info' role='alert'>
                    <h4 class='alert-heading'>Informasi!</h4>
                    <p><strong>".$evaluasi[0]->namapeserta."</strong> belum mengisi data kinerja. Silahkan Informasikan kepada yang bersangkutan untuk mengisi data kinerja</p>
                    </div>
                     ";
                echo "</div>";  
            }*/
        ?>
   </div>
</div>