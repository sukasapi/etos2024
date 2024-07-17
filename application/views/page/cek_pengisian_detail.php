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

<!-- Begin Page Content -->

    <div class="container-fluid">

    <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800"><a href="<?=base_url('monitorpengisian')?>"><i class="fas fa-fw fa-arrow-circle-left  text-warning"></i></a> Progress Pengisian Peserta</h1>

        </div>

        <div class="row pb-4">
          
            <div class="col-md-12 col-xs-12">
            <div class="card mb-5">
                    <div class="card-body text-white" style="background-color:#1e3799">
                        <div class="card-title text-center"> 
                            Gunakan filter ini untuk melakukan seleksi data yang akan ditampilkan
                        </div>
                    
                        <form action="<?=base_url('result/cekdetailpengisian')?>" method="POST" enctype="multipart/form-data">
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


                <div class="card card-info">
                    <div class="card-header text-center text-white" style="background-color:#0c2461">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="four-tab"  href="<?=base_url('monitorpengisian')?>" role="tab" aria-controls="Three" aria-selected="false">Rekap</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#rekap" role="tab" aria-controls="One" aria-selected="true">Peserta</a>
                            </li>
                            <!--<li class="nav-item">
                                <a class="nav-link" id="two-tab" data-toggle="tab" href="#peserta" role="tab" aria-controls="Two" aria-selected="false">Detail</a>
                            </li> -->
                          
                            <li class="nav-item">
                                <a class="nav-link" id="four-tab"  href="<?=base_url('cekpengisianpenilai')?>" role="tab" aria-controls="Three" aria-selected="false">Penilai</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                    <div class="tab-content" id="rekaptab">
                        <div class="tab-pane fade show active p-3" id="rekap" role="tabpanel" aria-labelledby="one-tab">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="detailpengisian" width="100%">

                                    <thead>

                                        <tr>

                                            <th rowspan='2'>Nik</th> 
                                            <th rowspan='2'>Perusahaan</th>
                                            <th rowspan='2'>Unit</th>
                                            <th rowspan='2'>Batch</th>
                                            <th rowspan='2'>Progress</th>
                                            <th rowspan='2'>Kurang</th>
                                            <th colspan='2' class="text-center">Rincian Pengisian</th>

                                            

                                        </tr>

                                        <tr>

                                            <td>Atasan</td>

                                            <td>Mitra</td>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                            foreach($detail as $du){

                                            

                                                $atasanisi=0;

                                                if(isset($du['evalatasan'][0])){

                                                    $atasanisi=$du['evalatasan'][0]['jtotal'];	

                                                }else{

                                                        
 
                                                }



                                                $mitraisi=array_column($du['evalmitra'], 'eval');

                                                $jmitraisi=array_sum($mitraisi);



                                                $selesai=$atasanisi+ $jmitraisi;

                                                $kurang=$du['jatah_evaluasi']-$selesai;



                                                $progress=$selesai > 0?($selesai / $du['jatah_evaluasi']) *100:0;



                                            if($progress >= 75){

                                                $sym="<i class='fas fa-solid fa-circle text-success'></i>";

                                            }else if($progress >50 && $progress < 75){

                                                $sym="<i class='fas fa-solid fa-circle text-warning'></i>";

                                            }else{

                                                $sym="<i class='fas fa-solid fa-circle text-danger'></i>";

                                            }



                                                echo "<tr>";

                                                echo "<td>".$du['nopeg']."<br>".$du['nama']."</td>";

                                            

                                                echo "<td>".$du['perusahaan']."</td>";
                                                echo "<td>".$du['unit']."</td>";

                                                echo "<td> Batch ".$du['batch']."</td>";

                                                echo "<td>".round($progress,2)."% ".$sym."</td>";

                                                echo "<td>".$kurang."</td>";
                                                echo "<td>".$atasanisi."</td>";

                                                echo "<td>".$jmitraisi."</td>";

                                                echo "</tr>";

                                            }

                                        ?>

                                    </tbody>

                                    <tfoot>

                                        <tr>

                                            <th>Nik</th>

                                        

                                            <th>Perusahaan</th>

                                            <th>Batch</th>

                                            <th>Progres</th>

                

                                            <th>Kurang</th>

                                            <td></td>

                                            <td></td>

                                        </tr>

                                    </tfoot>

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

            $('#detailpengisian tfoot th').each( function (i) {

            var title = $('#detailpengisian tfoot td').eq( $(this).index() ).text();

                if(i =="0" || i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i=="6" || i=="7"){

                    $(this).html( '<input style="width:100%" type="text" placeholder="'+title+'" data-index="'+i+'" />' );

                }

               

        

        } );

        



        var tablepengisian=$('#detailpengisian').DataTable( {

        dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ],

        stateSave: true,

        lengthChange: false,

        fixedHeader: true,

        } );



        tablepengisian.search( "").draw();



    

        $( tablepengisian.table().container() ).on( 'keyup', 'tfoot input', function () {

            tablepengisian

                .column( $(this).data('index') )

                .search( this.value )

                .draw();

        } );





         

        })

</script>