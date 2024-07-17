 <!-- Main Content -->
 <style>
thead input {
  width: 100%; 
}
</style>
 <div id="content">
<!-- Begin Page Content -->
    <div class="container-fluid">
    <!-- Page Heading -->
    <!--- BUTTON --> 

            <div class="text-center"><h4>Pilih menu dibawah</h4></div>
            <div class="d-flex justify-content-center bd-highlight mb-3 text-center">
                <div class="p-2 bd-highlight"> <button class="btn btn-primary" data-toggle="collapse" href="#bynilai"> Kategori Penilaian</button></div>
                <div class="p-2 bd-highlight"><button class="btn btn-primary" data-toggle="collapse" href="#bybatch"> Perusahaan dan Batch</button></div>
                <div class="p-2 bd-highlight"><button class="btn btn-primary" data-toggle="collapse" href="#bydetail">Detail</button></div>
            </div>
               
        <!---- KATEGORI PENILAIAN --->
        <div class="collapse" id="bynilai">
            <div class="row pb-4">
                <div class="col-md-12 col-xs-12">
                <div class="card card-info">
                <h4 class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-document"></i> Kelajuan Penilaian Berdasarkan Parameter Penilaian
                        </div>
                        <a href="<?=base_url('cekdetailpengisian')?>" class="btn btn-sm btn-primary">Detail (khusus NPS)</a>
                        </h4>
                        <div class="card-body pb-2 ">
                            <div class="table-responsive">
                                <table id="rekappengisian" class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Entitas</th>
                                            <th>Etos</th>
                                            <th>Tradisi</th>
                                            <th>Tri Tertib</th>
                                            <th>Atribut</th>
                                            <th>Kinerja</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            
                                            foreach($rekap as $key=>$val){
                                                echo "<tr>";
                                                echo "<td>".$key."</td>";
                                                $etosselesai=count((array)$val['etos']['selesai']);
                                                $etoskurang=isset($val['etos']['kurang'])?count((array)$val['etos']['kurang']):0;
                                                $tetos=$etoskurang +$etosselesai;
                                                $persenetos=round($etosselesai/($tetos)*100,2);
                                                $etosres=$persenetos;
                                                if($etosres >= 75){
                                                    $ietos="<i class='fas fa-solid fa-circle text-success'></i>";
                                                }else if($etosres >50 || $etosres < 75){
                                                    $ietos="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                }else{
                                                    $ietos="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                }
                                                echo "<td class='text-center'>".$persenetos." % ".$ietos."<br> (kurang ". $etoskurang ." evaluasi dari ".$tetos." )</td>" ;

                                                $tradisiselesai=count((array)$val['tradisi']['selesai']);
                                                $tradisikurang=isset($val['tradisi']['kurang'])?count((array)$val['tradisi']['kurang']):0;
                                                $ttradisi=$tradisikurang +$tradisiselesai;
                                                $persentradisi=round($tradisiselesai/($ttradisi)*100,2);
                                                $tradisires=$persentradisi;
                                                if($etosres >= 75){
                                                    $itradisi="<i class='fas fa-solid fa-circle text-success'></i>";
                                                }else if($tradisires >50 || $tradisires < 75){
                                                    $itradisi="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                }else{
                                                    $itradisi="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                }
                                                echo "<td class='text-center'>".$persentradisi." % ".$itradisi."<br> (kurang ". $tradisikurang ." evaluasi dari ".$ttradisi." )</td>" ;

                                                $tritertibselesai=count((array)$val['tritertib']['selesai']);
                                                $tritertibkurang=isset($val['tritertib']['kurang'])?count((array)$val['tritertib']['kurang']):0;
                                                $ttritertib=$tritertibkurang + $tritertibselesai;
                                                $persentritertib=round($tritertibselesai/($ttritertib)*100,2);
                                                $tritertibres=$persentradisi;
                                                if($tritertibres >= 75){
                                                    $itritertib="<i class='fas fa-solid fa-circle text-success'></i>";
                                                }else if($tritertibres >50 || $tritertibres < 75){
                                                    $itritertib="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                }else{
                                                    $itritertib="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                }
                                                echo "<td class='text-center'>".$persentritertib." % ".$itritertib." <br> (kurang ". $tritertibkurang ." evaluasi dari ".$ttritertib." )</td>" ;

                                                $atributselesai=count((array)$val['atribut']['selesai']);
                                                $atributkurang=isset($val['atribut']['kurang'])?count((array)$val['atribut']['kurang']):0;
                                                $tatribut=$atributkurang +$atributselesai;
                                                $persenatribut=round($atributselesai/($tatribut)*100,2);
                                                $atributres=$persenatribut;
                                                if($atributres >= 75){
                                                    $iatribut="<i class='fas fa-solid fa-circle text-success'></i>";
                                                }else if($atributres >50 || $atributres < 75){
                                                    $iatribut="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                }else{
                                                    $iatribut="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                }
                                                echo "<td class='text-center'>".$persenatribut." ".$iatribut." % <br> (kurang ". $atributkurang ." evaluasi dari ".$tatribut." )</td>" ;
                                                
                                                $kinerjaisi=count((array)$val['kinerja']['mengisi']);
                                                $kinerjaapprove=count((array)$val['kinerja']['approve']);
                                                $persenakinerja=round($kinerjaapprove/($kinerjaisi)*100,2);
                                                if($persenakinerja >= 75){
                                                    $ikinerja="<i class='fas fa-solid fa-circle text-success'></i>";
                                                }else if($persenakinerja >50 || $persenakinerja < 75){
                                                    $ikinerja="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                }else{
                                                    $ikinerja="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                }
                                                echo "<td class='text-center'> progress:".$persenakinerja."% ".$ikinerja." <br>(Pengisian:".$kinerjaisi.", Approval :".$kinerjaapprove."</td>" ;

                                                echo "</tr>";
                                            }
                                        
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
                </div>
            </div>
        </div>
        <!----  END KATEGORI PENILAIAN --->
        <!---- PERUSAHAAN & BATCH --->
        <div class="collapse" id="bybatch">
            <div class="row pb-4">
                <div class="col-md-12 col-xs-12">
                    <div class="card card-info">
                        <h4 class="card-header d-flex justify-content-between align-items-center"> Kelajuan Pengisian Berdasar Perusahaan dan Batch</h4>
                        <div class="card-body pb-2 ">
                            <div class="table-responsive">
                                <table id="rekapbatch" class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width:1%">No</th>
                                            <th style="width:1%"></th>
                                            <th>Entitas</th>
                                            <th>Batch</th>
                                            <th>Persen Progress</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $cb=1;
                                        $sortkey = array_column($batch, 'perusahaan');
                                        //array_multisort($price, SORT_DESC, $inventory);
                                        array_multisort($sortkey, SORT_ASC, $batch);
                                        foreach($batch as $b){
                                                if($b['batch']>0){
                                                    if($b['progres'] >= 75){
                                                        $indikator="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($b['progres'] >50 || $b['progres'] < 75){
                                                        $indikator="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $indikator="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }
                                                echo "<tr>";
                                                echo "<td>".$cb."</td>";
                                                echo "<td>".$indikator."</td>";
                                                echo "<td>".$b['perusahaan']."</td>";
                                                echo "<td>".$b['batch']."</td>";
                                                echo "<td>".$b['progres']." %</td>";
                                                echo "</tr>";

                                                $cb++;
                                                }
                                            }
                                           
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!---- END PERUSAHAAN & BATCH --->
         <!---- DETAIL --->
        <div class="collapse" id="bydetail">
            <div class="row pb-4">
                <div class="col-md-12 col-xs-12">
                    
                    <div class="card card-info">
                        <div class="card-header text-white bg-primary">
                            <h5>Data Progres Pengisian Evaluasi</h5>
                        </div>
                        <div class="card-body pb-2 ">
                            <div class="table-responsive">
                                <table id="datapengisian" class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th style="width:10%">NIK</th>
                                            <th style="width:10%">Nama</th>
                                            <th style="width:15%">Entitas</th>
                                            <th style="width:15%">Komoditas</th>
                                            <th style="width:15%" >Asisten</th>
                                            <th>Batch</th>
                                            <th style="width:15%" >Status</th>
                                            <th>Etos Kerja</th>
                                            <th>Tradisi Planters</th>
                                            <th>Tri tertib</th>
                                            <th>Atribut</th>
                                            <th style="width:15%">Kinerja</th>
                                        
                                        </tr>
                                    </thead>  
                                    <tbody>
                                        <?php
                                            $str="";
                                            $i=1;
                                        // print_r($cek);
                                            foreach($cek as $c){
                                                $str .="<tr>";
                                                $str .="<td>".$i."</td>";
                                                $str .="<td>".$c['nik']."</td>";
                                                $str .="<td>".$c['nama']."</td>";
                                                $str .="<td>".$c['perusahaan']."</td>";
                                                $str .="<td>".$c['komoditas']."</td>";
                                                $str .="<td>".$c['asisten']."</td>";
                                                $str .="<td>".$c['batch']."</td>";
                                                $str .="<td>".$c['status']."</td>";
                                                $str .="<td>".$c['etos']."</td>";
                                                $str .="<td>".$c['tradisi']."</td>";
                                                $str .="<td>".$c['tritertib']."</td>";
                                                $str .="<td>".$c['atribut']."</td>";
                                                $str .="<td>".$c['kinerja']."</td>";
                                            
                                                $str .="</tr>";
                                                $i++;
                                            }

                                            echo $str;
                                        ?>
                                    </tbody>    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---- END DETAIL --->
    </div>
 </div>

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

 <script>
    $(document).ready(function() {
        
     $('#datapengisian thead th').each( function (i) {
            var title = $('#datapengisian thead th').eq( $(this).index() ).text();
                if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6"){
                    $(this).html( '<input style="width:100%" type="text" placeholder="'+title+'" data-index="'+i+'" />' );
                }
               
        
    } );


    $('#rekappengisian').DataTable({
    "pageLength": 50
    });

    var tablepengisian=$('#datapengisian').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        stateSave: true,
        lengthChange: false,

    } );
    tablepengisian.search( "").draw();

    
    $( tablepengisian.table().container() ).on( 'keyup', 'thead input', function () {
        tablepengisian
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
  


    $('#rekapbatch thead th').each( function (i) {
            var title = $('#rekapbatch thead th').eq( $(this).index() ).text();
                if(i =="2" || i =="3" || i =="4" ){
                    $(this).html( '<input style="width:100%" type="text" placeholder="'+title+'" data-index="'+i+'" />' );
                }
               
        
    } );

    var tablerekap=$('#rekapbatch').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        stateSave: true,
        lengthChange: false,
        pageLength:14,

    } );
    tablerekap.search("").draw();

    
    $( tablerekap.table().container() ).on( 'keyup', 'thead input', function () {
        tabelrekap
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
   
    })
 </script>