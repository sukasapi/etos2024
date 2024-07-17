  <!-- Main Content -->
<div id="content">
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
        <form action="<?=base_url('dashboard')?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
           
            <div class="input-group">
                <select id="comp" name="perusahaan" class="form-control mr-2">
                    
                    <?php 
                        if($_SESSION['logged_in']['status']=="admin unit"){
                        $where=array('id'=>$_SESSION['logged_in']['perusahaan']);
                        echo "<option readonly selected value='".$p->id."'>".$p->nama."</option>";
                        }else{
                            echo "<option readonly value=''>- Filter berdasarkan unit usaha -</option>";
                            foreach(perusahaan() as $p){
                                if($pos == $p->id){
                                    echo "<option selected value='".$p->id."'>".$p->nama."</option>";
                                }else{
                                    echo "<option value='".$p->id."'>".$p->nama."</option>";
                                }
                            }
                                    
                        
                        }
                    ?>
                </select>
                <input type="submit" class="float-right btn btn-round btn-info" value="search">
                <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            </div>
        </div>
        </form>
    </div>
  <!-- Content Row -->

  <input type="hidden" name="company" value="<?=$pos?>">
    <div class="row">
        <div class="col-md-12 col-xs-12">
          
        <div class ="col-md-3 col-sm-12 py-2">
                        <div class="card h-100">
                        <div class="card-body h-100 ">
                            <div class="row align-items-center">
                            <div class="col-xl-12 col-xxl-12 ">
                                <div class="text-center">
                                    <h5 class="text-primary"><strong>Skor</strong></h5>
                                    <?php 
       $total=0;
       $skortotal=0;
         foreach($evaluasi as $e){
          if($e->id != 5){
            $total +=isset($npsnilai[$e->id]['nilai'])?round($npsnilai[$e->id]['nilai'],2) : 0;
           
          }

        }
        $skortotal = ($total/4);
        if($skortotal >=75){
					?>
        <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-primary btn-circle btn-xl">
          <?=$skortotal?>
        </button>
          <?php
				}else if($skortotal > 50 && $skortotal < 75){
          ?>
          <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-success btn-circle btn-xl">
            <?=$skortotal?>
          </button>
            <?php
				}else if($skortotal > 25 && $skortotal < 50){
          ?>
          <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-warning btn-circle btn-xl">
            <?=$skortotal?>
          </button>
            <?php
				}else if($skortotal > 1 && $de->id < 25){
          ?>
          <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-danger btn-circle btn-xl">
            <?=$skortotal?>
          </button>
            <?php
				}else{
          ?>
          <button type="button" style=" font-size : 20px; height: 75px;width: 75px;" class="btn btn-dark btn-circle btn-xl">
            <?=$skortotal?>
          </button>
            <?php
				}
        
       ?>
                                    <div class="pt-3">
                                    <p class="text-gray-700 mb-0 pb-2">Total Nilai Evaluasi NPS</p>  
                                    <p class="text-gray-500 mb-0">NPS</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        </div>
                    </div>
       
        </div>
          <div class="row mb-3">

            <?php 
            $total =0;
            foreach($evaluasi as $e){
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
        
        </div>
    </div>
   
<!-------- TABEL DATA --->


<!--------END ./TABLE --->
<!-- Content Row -->
  <div class="tabNPS">
    <div class="row pb-5">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="card card-info">
                <div class="card-header text-white bg-primary">
                    <h5>NPS</h5>
                </div>
                <div class="card-body pb-2 ">
                
                    <div class="table-responsive ">
                        <table id="NPSdata" class="table table-bordered" width="95%">
                        <thead>
                                <tr>
                                    <th style="width:5%">No.</th>
                                    <th style="width:15%">Nama</th>
                                    <th style="width:15%">Penilai</th>
                                    <th style="width:20%">Perusahaan</th>
                                    <th style="width:25%">Jenis Evaluasi</th>
                                    <th style="width:10%">NPS Score</th>
                                    <th style="width:5%">Promoter</th>
                                    <th style="width:5%">Passive</th>
                                    <th style="width:5%">Detractor</th>
                                </tr>
                        </thead>
                        <tbody>
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
                                $strnps.="<td class='text-center'>".round($n['npsscore'][$i],2)."</td>";
                                $strnps.="<td class='text-center'>".$n['promoter'][$i]."</td>";
                                $strnps.="<td class='text-center'>".$n['passive'][$i]."</td>";
                                $strnps.="<td class='text-center'>".$n['detractor'][$i]."</td>";
                                $strnps.="</tr>";
                                $counter++;
                                $i++;
                              }
                            }
                            echo $strnps;
                           ?>
                        </tbody>
                          <tfoot>
                            <tr>
                                    <th colspan="5" ></th>
                                    <th class='text-center'></th>
                                    <th class='text-center'></th>
                                    <th class='text-center'></th>
                                    <th class='text-center'></th>
                              </tr>
                          </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>    
  <div class="tabKIN">
    <div class="row pb-5">
        <div class="col-md-12 col-xs-12 col-sm-12">
            <div class="card card-info card-waves">
                <div class="card-header text-white bg-primary">
                    <h5>KINERJA</h5>
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
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
  <!-- Page level plugins -->
  <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!----- Button datatables--------> 
    <script src="<?=base_url('assets/')?>vendor/datatables/button/dataTables.buttons.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.html5.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.print.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/jszip.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/pdfmake.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/vfs_fonts.js"></script>
  <!--<script src="<?=base_url('assets/')?>vendor/chart.js/Chart.min.js"></script> -->
  <!--<script src="<?=base_url('assets/js/barchart.js')?>"></script> -->

  <script>
    $(document).ready(function() {
      $('#NPSdata thead th').each( function (i) {
        var title = $('#NPSdata thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
    } );

    $('#kinerjadata thead th').each( function (i) {
        var title = $('#kinerjadata thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
    } );
    
    var tablenps =   $('#NPSdata').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        responsive:true,
        "columnDefs": [
         { "searchable": false, "targets": [0] }  // Disable search on first and last columns
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
           
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            
            var info = api.page.info();
            var rowsshown = info.recordsDisplay;
 
            var totalNPS = api
                .column( 5,{page:'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var npsmean =totalNPS / rowsshown;
            var romean=npsmean.toFixed(2);

             var totalpromoter = api
                .column( 6 ,{page:'current'})
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              
              var totalpassive = api
                .column( 7,{page:'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              
              var totaldetractor = api
                .column( 8,{page:'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

              
          
				
            // Update footer by showing the total with the reference of the column index 
            $( api.column( 0 ).footer() ).html("Kalkulasi NPS");

            $( api.column( 5 ).footer() ).html("Rerata Nilai NPS :" + romean);
            $( api.column( 6 ).footer() ).html("total Promoter :" + totalpromoter);
            $( api.column( 7 ).footer() ).html("total Passive :" + totalpassive);
            $( api.column( 8 ).footer() ).html("total Detractor :" + totaldetractor);
        },
        
    } );
        
    $( tablenps.table().container() ).on( 'keyup', 'thead input', function () {
        tablenps
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
    tablenps.columns.adjust().draw();
    
    var tablekinerja=$('#kinerjadata').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    $( tablekinerja.table().container() ).on( 'keyup', 'thead input', function () {
        tablekinerja
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
    tablekinerja.columns.adjust().draw();

      
    })
  </script>