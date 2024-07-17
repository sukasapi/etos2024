<style>
.nav-tabs > li.active > a {
  color: #3c5a78;
  font-size: 16px;
}
.nav-tabs > li > a {
  color: #FFFFFF;
}

</style>
<div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800"><a href="<?=base_url('monitorpengisian')?>"><i class="fas fa-fw fa-arrow-circle-left  text-warning"></i></a> Progres Pengisian Penilai </h1>
        </div> 
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body text-white" style="background-color:#1e3799">
                        <div class="card-title text-center"> 
                            Gunakan filter ini untuk melakukan seleksi data yang akan ditampilkan
                        </div>
                    
                        <form action="<?=base_url('result/cekpengisian_penilai')?>" method="POST" enctype="multipart/form-data">
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
                                    <select class="form-control" id="batch" name="batch">
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
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="submit" class="float-right btn btn-info btn-rounded" value="filter">
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header text-center text-white" style="background-color:#0c2461">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="four-tab"  href="<?=base_url('monitorpengisian')?>" role="tab" aria-controls="Three" aria-selected="false">Rekap</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="four-tab"  href="<?=base_url('cekdetailpengisian')?>" role="tab" aria-controls="Three" aria-selected="false">Peserta</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#rekap" role="tab" aria-controls="One" aria-selected="true">Penilai</a>
                            </li>
                            
                            <!--<li class="nav-item">
                                <a class="nav-link" id="two-tab" data-toggle="tab" href="#peserta" role="tab" aria-controls="Two" aria-selected="false">Detail</a>
                            </li> -->
                          
                            
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="rekaptab">
                            <div class="tab-pane fade show active p-3" id="rekap" role="tabpanel" aria-labelledby="one-tab">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed" id="tb_progress" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width:2%">No</th>
                                                <th style="width:8%">Penilai</th>
                                                
                                                <th style="width:8%">Dinilai</th>
                                                
                                                <th style="width:5%">Entitas</th>
                                                <th style="width:10%">Unit</th>
                                                <th style="width:10%">Batch</th>
                                            
                                                <th style="width:10%">Value</th>
                                                <th style="width:15%">Kinerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $c=1;
                                                foreach($progress as $p){
                                                    $nprogress=round((int)$p['nps']/4*100,2);
                                                    
                                                    if($nprogress > 75){
                                                        $iprog ="<i class='fas fa-solid fa-circle text-success'></i>";
                                                    }else if($nprogress >=50 && $nprogress <= 75){
                                                        $iprog ="<i class='fas fa-solid fa-circle text-warning'></i>";
                                                    }else{
                                                        $iprog ="<i class='fas fa-solid fa-circle text-danger'></i>";
                                                    }
                                                
                                                    echo "<tr>";
                                                    echo "<td>".$c."</td>";
                                                    echo "<td>".$nprogress." | ".$p['nikpenilai']."<br>".$p['nmpenilai']."<br>(".$p['statuspenilai'].")".$iprog."</td>";
                                                
                                                    echo "<td>".$p['nikdinilai']."<br>".$p['nmdinilai']."</td>";
                                                
                                                    echo "<td>".$p['perusahaan']."</td>";
                                                    echo "<td>".$p['unit']."</td>";
                                                    echo "<td>".$p['batch']."</td>";
                                                
                                                    echo "<td>".$p['nps']." dari 4</td>";
                                                    echo "<td>".$p['approval']."</td>";
                                                    echo "</tr>";
                                                $c++;
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
        $('#tb_progress thead th').each( function (i) {
            var title = $('#tb_progress thead th').eq( $(this).index() ).text();
                if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6" || i =="7" || i =="8" || i =="9"){
                    $(this).html( '<input style="width:100%" type="text" placeholder="'+title+'" data-index="'+i+'" />' );
                }
               
        
    } );
    var tablepengisian=   $('#tb_progress').DataTable({
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            autoWidth: true,
            responsive:true,
            columnDefs :[
                { "width": "5%", "targets": 0 }
            ]
        });

        $( tablepengisian.table().container() ).on( 'keyup', 'thead input', function () {
        tablepengisian
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
    tablepengisian.columns.adjust().draw();
    })
    </script>