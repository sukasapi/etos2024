<style>
.nav-tabs > li.active > a {
  color: #3c5a78;
  font-size: 16px;
}
.nav-tabs > li > a {
  color: #FFFFFF;
}

</style>
<div id="content">
    <div class="container-fluid">
        <div class="text-center"><h4>Monitoring Progres Pengisian</h4></div>


   <!-- Filter Pemanggilan data --> 

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="card mb-5">
                    <div class="card-body text-white" style="background-color:#1e3799">
                        <div class="card-title text-center"> 
                            Gunakan filter ini untuk melakukan seleksi data yang akan ditampilkan
                        
                        </div>
                    
                        <form action="<?=base_url('tes/monitoringpengisian')?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="entitas">Entitas</label>
                                    <select class="form-control" id="entitas" name="entitas">
                                        <option disabled selected> Pilih entitas yang akan ditampilkan </option>
                                        
                                        <?php
                                            if($_SESSION['logged_in']['perusahaan']=="all"){
                                                if($postentitas =="all"){
                                                    echo "<option value='all' selected>Semua entitas</option>";
                                                }else{
                                                    echo "<option value='all'>Semua entitas</option>";
                                                }
                                            
                                            } 
                                            foreach($entitas as $e){
                                                if($postentitas==$e->id){
                                                    echo "<option value='".$e->id."' selected>".$e->nama."</option>";
                                                }else{
                                                    echo "<option value='".$e->id."'>".$e->nama."</option>";
                                                }
                                            
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                            
                                <div class="form-group">
                                    <label for="entitas">Batch</label>
                                    <input type="text" value="<?=$postbatch?>" name="batch" class="form-control">
                                    <small><i>* Gunakan pemisah koma (,) jika pilihan lebih dari 1</i></small> 
                                <!-- <select class="form-control" id="batch" name="batch">
                                        <option disabled selected> Pilih batch peserta </option>
                                        <?php if($postentitas =="all"){
                                            echo "<option value='all' selected> Semua Batch </option>";
                                        }else{
                                            echo "<option value='all'> Semua Batch </option>";
                                        }
                                        ?>
                                    
                                        <?php 
                                    
                                            foreach($batchlist as $b){
                                                if($postbatch==$b){
                                                    echo "<option value='".$b."' selected>".$b."</option>";
                                                }else{
                                                    echo "<option value='".$b."'>".$b."</option>";
                                                }
                                            
                                            }
                                        ?>
                                    </select> -->
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="submit" class="float-right btn btn-info btn-rounded" value="filter">
                        </form>
                    </div>
                </div>
                <?php 
                //print_r($syntax);
                //echo $postbatch;
                ?>

                <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">INFORMASI!</h4>
                <p>Perhitungan progress pada versi baru ini menggunakan acuan jumlah penilai baik atasan maupun mitra dan penilaian yang berstatus final</p>
                </div>
                
                <div class="card">
                    <div class="card-header text-center text-white" style="background-color:#0c2461">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#rekap" role="tab" aria-controls="One" aria-selected="true">Rekap</a>
                            </li>
                            <!--<li class="nav-item">
                                <a class="nav-link" id="two-tab" data-toggle="tab" href="#peserta" role="tab" aria-controls="Two" aria-selected="false">Detail</a>
                            </li> -->
                            <li class="nav-item">
                            <a class="nav-link" id="four-tab"  href="<?=base_url('cekdetailpengisian')?>" role="tab" aria-controls="Three" aria-selected="false">Peserta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="four-tab"  href="<?=base_url('cekpengisianpenilai')?>" role="tab" aria-controls="Three" aria-selected="false">Penilai</a>
                            </li>
                        
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="rekaptab">
                            <div class="tab-pane fade show active p-3" id="rekap" role="tabpanel" aria-labelledby="one-tab">
                                <h5 class="card-title">Rekapitulasi Progres Pengisian Evaluasi</h5>
                                <div class="table-responsive">
                                    <table id="rekappengisian" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Entitas</th>
                                                <th>Etos</th>
                                                <th>Tradisi</th>
                                                <th>Tri Tertib</th>
                                                <th>Atribut</th>
                                                <!--<th>Kinerja</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($rekap as $key=>$val){
                                                  
                                                    //*total
                                                    $persentotal=isset($val['data']['persen'])?$val['data']['persen']:0;
                                        
                                                    //1.etos
                                                    $etosselesai=isset($val['etos']['selesai']) && $val['etos']['selesai']!=null?count((array)$val['etos']['selesai']):0;
                                                    $etoskurang=isset($val['etos']['kurang'])?$val['etos']['kurang']:0;
                                                    $tetos=isset($val['etos']['total'])?$val['etos']['total']:0;
                                                    $persenetos=isset($val['etos']['persen'])?$val['etos']['persen']:0;
                                                    if($persenetos >= 75){
                                                        $ietos="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($persenetos >50 || $persenetos < 75){
                                                        $ietos="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $ietos="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }

                                                    /// 2.Tradisi
                                                    $tradisiselesai=isset($val['tradisi']['selesai'])?$val['tradisi']['selesai']:0;
                                                    $tradisikurang=isset($val['tradisi']['kurang'])?$val['tradisi']['kurang']:0;
                                                    $ttradisi=isset($val['tradisi']['total'])?$val['tradisi']['total']:0;
                                                    $persentradisi=isset($val['tradisi']['persen'])?$val['tradisi']['persen']:0;
                                                    if($persentradisi >= 75){
                                                        $itradisi="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($persentradisi >50 || $persentradisi < 75){
                                                        $itradisi="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $itradisi="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }

                                                    /// 3.Tritertib
                                                    $tritertibselesai=isset($val['tritertib']['selesai'])?$val['tritertib']['selesai']:0;
                                                    $tritertibkurang=isset($val['tritertib']['kurang'])?$val['tritertib']['kurang']:0;
                                                    $ttritertib=isset($val['tritertib']['total'])?$val['tritertib']['total']:0;
                                                    $persentritertib=isset($val['tritertib']['persen'])?$val['tritertib']['persen']:0;
                                                  
                                                    if($persentritertib >= 75){
                                                        $itritertib="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($persentritertib >50 || $persentritertib < 75){
                                                        $itritertib="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $itritertib="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }

                                                    /// 4. Atribut
                                                    $atributselesai=isset($val['atribut']['selesai'])?$val['atribut']['selesai']:0;
                                                    $atributkurang=isset($val['atribut']['kurang'])?$val['atribut']['kurang']:0;
                                                    $tatribut=isset($val['atribut']['total'])?$val['atribut']['total']:0;
                                                    $persenatribut=isset($val['atribut']['persen'])?$val['atribut']['persen']:0;
                                                    $atributres=$persenatribut;
                                                    if($atributres >= 75){
                                                        $iatribut="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($atributres >50 || $atributres < 75){
                                                        $iatribut="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $iatribut="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }


                                                    /// 5. Kinerja
                                                   /* $kinerjaisi=isset($val['kinerja']['mengisi'])&&count((array)$val['kinerja']['mengisi']) > 0 ? count((array)$val['kinerja']['mengisi']) : "0";
                                                    $kinerjaapprove=isset($val['kinerja']['approve']) && count((array)$val['kinerja']['approve']) > 0?count((array)$val['kinerja']['approve']):"0";
                                                    $persenakinerja=isset($kinerjaapprove) || isset($kinerjaisi) ? round($kinerjaapprove/($kinerjaisi)*100,2):0;
                                                    if($persenakinerja >= 75){
                                                        $ikinerja="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($persenakinerja >50 || $persenakinerja < 75){
                                                        $ikinerja="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $ikinerja="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }*/

                                                    $totalprogress=$persentotal;
                                                    if($totalprogress >=75){
                                                        $itotal ="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($totalprogress >50 || $totalprogress < 75){
                                                        $itotal = "<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $itotal="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }
                                                    echo "<tr>";
                                                    echo "<td>".$key."<br>
                                                        ".$persentotal."% ".$itotal."<br>(tanpa kinerja)
                                                        </td>";

                                                
                                                    echo "<td>".$persenetos." % ".$ietos."<ul> <li> Belum: ". $etoskurang ." evaluasi </li><li> Jumlah :".$tetos." </li></ul></td>" ;
                                                    
                                                
                                                    echo "<td>".$persentradisi." % ".$itradisi."<ul> <li> Belum: ". $tradisikurang ." evaluasi </li><li> Jumlah :".$ttradisi." </li></ul></td>" ;
                                                    
                                                
                                                    echo "<td >".$persentritertib." % ".$itritertib."<ul> <li> Belum: ". $tritertibkurang ." evaluasi </li><li> Jumlah :".$ttritertib." </li></ul></td>" ;


                                                
                                                    echo "<td>".$persenatribut." % ".$iatribut."<ul> <li> Belum: ". $atributkurang ." evaluasi </li><li> Jumlah :".$tatribut." </li></ul></td>" ;

                                                
                                                  //  echo "<td> progress:".$persenakinerja."% ".$ikinerja."<ul> <li> Belum: ". $kinerjaisi ." evaluasi </li><li> Jumlah :".$kinerjaapprove." </li></ul></td>" ;

                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody> 
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade p-3" id="peserta" role="tabpanel" aria-labelledby="two-tab">
                                <h5 class="card-title"></h5>
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
        </div>

    </div>

</div>
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
 
$( document ).ready(function() {
    $("#rekappengisian").DataTable({
        dom: 'lBfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        pageLength : 14
    });

    $("#rekapbatch").DataTable({
        pageLength : 5
    });

})
</script>