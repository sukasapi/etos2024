<link href="<?=base_url('assets/')?>css/timeline.css" rel="stylesheet">
<link href="<?=base_url('assets/')?>css/timeline.css" rel="stylesheet">
 <!-- Main Content -->
<div id="content">

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ADMIN UNIT<br><?=sperusahaan(array("id"=>$_SESSION['logged_in']['perusahaan']))[0]->nama?></h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 col-xs-12">
          <div class="row mb-5 pb-5">
            <?php  
           foreach($project as $e){
            if($e->id != 5){
                ?>
                <div class ="col-md-3 col-sm-12 py-2">
                    <div class="card h-100">
                    <div class="card-body h-100 ">
                        <div class="row align-items-center">
                        <div class="col-xl-12 col-xxl-12 ">
                            <div class="text-center">
                                <h5 class="text-primary"><strong><?=$e->nama?></strong></h5>
                                <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-success btn-circle btn-xl">
                                    <?=isset($npsnilai[$e->id]['nilai'])?round($npsnilai[$e->id]['nilai'],2) : '0'?>
                                </button>
                                <div class="pt-3">
                                <p class="text-gray-700 mb-0 pb-2"><?=$e->deskripsi?></p>  
                                <p class="text-gray-500 mb-0"><?=$e->tipe_nilai?></p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    </div>
                </div>
                <?php
            }else{

            }
        }
            ?> 
          </div>  
       
          <div class="row mb-5 pb-5">
            <?php 
         
              foreach($project as $e){
                if($e->id != 5){
              
            ?>
              <div class ="col-md-6 col-sm-12 py-2 px-2">
                <div class="card h-100">
                  <div class="card-header">
                    <h6>Proporsi nilai <?=$e->nama?></h6>
                  </div>
                  <div class="card-body h-100 my-5">
                  
                    <canvas id="pie<?=$e->id?>" width="200" height="200"></canvas>
                  </div>
                  <div class="card-footer bg-white">
                    <div class="table-responsive" id="tab<?=$e->id?>">

                    </div>
                  </div>
                </div>
              </div>
            <?php
                }else{

                }
              }
            ?>
             
             
          </div>   
          <div class="row mb-5 pb-5">
              <div class="col-md-12 col-xs-12 col-sm-12 pb-4">
                <div class="card card-info">
                  <div class="card-header bg-primary">
                    <h5 class="text-white">NPS</h5>
                  </div>
                  <div class="card-body pb-2">
                    <div class="table-responsive">
                        <table id="NPSdata" class="table">
                          <thead>
                                  <tr>
                                      <th>No.</th>
                                      <th>Nama</th>
                                      <th>Penilai</th>
                                      <th>Perusahaan</th>
                                      <th>Jenis Evaluasi</th>
                                      <th>NPS Score</th>
                                      <th>Promoter</th>
                                      <th>Passive</th>
                                      <th>Detractor</th>
                                  </tr>
                          </thead>
                          <?php 
                           
                           $strnps="";
                          $counter=1;
                           foreach ($tableNPS as $key=>$n){
                             $i=0;
                            foreach ($n['ideval'] as $e){
                              $strnps.="<tr>";
                               $strnps.="<td>".$counter."</td>";
                               $strnps.="<td>".$n['peserta'][$i]."</td>";
                               $strnps.="<td>".$n['penilai'][$i]."</td>";
                               $strnps.="<td>".$n['perusahaan'][$i]."</td>";
                               $strnps.="<td>".$n['namaeval'][$i]."</td>";
                               $strnps.="<td>".round($n['npsscore'][$i],2)."</td>";
                               $strnps.="<td>".$n['promoter'][$i]."</td>";
                               $strnps.="<td>".$n['passive'][$i]."</td>";
                               $strnps.="<td>".$n['detractor'][$i]."</td>";
                               $strnps.="</tr>";
                               $counter++;
                               $i++;
                             }
                           }
                           echo $strnps;
                           ?>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12 ">
                  <div class="card card-primary">
                      <div class="card-header bg-primary">
                          <h5 class="text-white">KINERJA</h5>
                      </div>
                      <div class="card-body pb-2">
                          <div class="table-responsive">
                              <table id="kinerjadata" class="table">
                              <thead>
                                      <tr>
                                          <th>No.</th>
                                          <th>Nama</th>
                                          <th>Perusahaan</th>
                                          <th>KPI</th>
                                          <th>Formula</th>
                                          <th>Target</th>
                                          <th>Realisasi</th>
                                          <th>Skor KPI</th>
                                      </tr>
                              </thead>
                              <tbody>
                                <?php 
                              
                                  $ik=1;
                                  $strkin="";
                                  foreach($tablekinerja as $kin){
                                      
                                          $strkin .="<tr>";
                                          $strkin .="<td>".$ik."</td>";
                                          $strkin .="<td>".$kin['namapeserta']."</td>";
                                          $strkin .="<td>".$kin['perusahaan']."</td>";
                                          $strkin .="<td>".$kin['KPI']."</td>";
                                          $strkin .="<td>".$kin['formula']."</td>";
                                          $strkin .="<td>".$kin['target']."</td>";
                                          $strkin .="<td>".$kin['realisasi']."</td>";
                                          $strkin .="<td>".$kin['skor']."</td>";
                                          $strkin .="</tr>";
          
                                          $ik++;
                                  }
                                      
                                  echo $strkin;
                                ?>
                              </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>

    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
 <!----- Button datatables--------> 
 <script src="<?=base_url('assets/')?>vendor/datatables/button/dataTables.buttons.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.html5.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.print.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/jszip.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/pdfmake.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/vfs_fonts.js"></script>
<script src="<?=base_url('assets/')?>vendor/chart.js/Chart.min.js"></script>
<script src="<?=base_url('assets/')?>js/proporsigraph.js"></script>
<script>
    $(document).ready(function() {
        $('#NPSdata').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
        $('#kinerjadata').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

      
    })
  </script>