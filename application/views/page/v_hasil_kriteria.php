 <!-- style --> 
 <style>
    .circled-number {
  color: #FFF;
  border: 2px solid #666;
  border-radius: 50%;
  font-size: 4rem;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 3em; 
  height: 3em;
}

.circled-number--big {
  color: #666;
  border: 2px solid #666;
  border-radius: 50%;
  font-size: 1rem;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 4em; 
  height: 4em;
}

 </style>
 
 <!-- Main Content -->


 <div id="content">

<!-- Begin Page Content -->

    <div class="container-fluid">

    <div class="modal" id="mdinfo" tabindex="-1" role="dialog" data-backdrop="static">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

            <div class="modal-header bg-info" style="background-color:#95afc0">

                <h5 class="modal-title" style="color:#130f40"></h5>             

                <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <h3 class='text-center'>Aplikasi sedang merinci detail penilaian.<br> Harap tunggu sebentar.</h3> 

                <div class="d-flex justify-content-center">

                    <div class="spinner-border " style="width: 10rem; height: 10rem;" role="status">

                        <span class="sr-only">Loading...</span>

                    </div>

                </div>

            </div> 

            <div class="modal-footer">

               

            </div>

            </div>

        </div>

    </div>

    <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-0 text-gray-800">REKAPITULASI HASIL PENILAIAN</h1>

        </div>

        <div class="row py-2">
          
            <div class="col-md-12 col-xs-12 pb-4">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="text-center text-white"><h5>Penyaringan</h5></div>
                        <form action="<?=base_url('nilaievaluasi')?>" method="POST" enctype="multipart/form-data">
                           <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <div class="form-group">
                                    <?=$postentitas?>
                                    <label class="text-white">Entitas</label>
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
                            <div class="col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label for ='batch' class="text-white">Batch</label>
                                    <?php
                                        if(isset($postbatch) || $postbatch !==""){
                                            $batch=$postbatch;
                                        }else{
                                            $batch="all";
                                        }
                                    ?>
                                    <input type="text" class="form-control" name="batch" value="<?=$batch?>">
                                    <small class='text-white'><i>* Gunakan koma untuk memilih lebih dari satu batch tanpa spasi (1,2,3,dst)</i></small>
                                </div>
                            </div>
                           </div>
                          
                           
                            <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">                
                            <input type="submit" class="btn btn-rounded btn-info float-right" value="Saring">  
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 text-center">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">INFORMASI!</h4>
             
                                <p>Data kalkulasi berdasarkan perhitungan pada <strong><?=date('d-m-Y H:i:s');?></strong></p>
                                <p> Proses kalkulasi sebanyak <?=$datacount?> memakan waktu : <?=round($executetime,2)?> detik;</p>
                   
                     
                </div>
            </div>
        </div>

        <div class="row pb-4">

            <div class="col-md-12 col-xs-12">
                <div class="card">

                    <div class="card-header">

                        <h5>Rekap Kalkulasi</h5>
                     
                    </div>

                    <div class="card-body pb-2 ">
                        <div class="row">
                       
                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="d-flex justify-content-center">
                                    <div class="circled-number" style="background-color:<?=warna("all",$total)?>">
                                    <?=$total?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table" style="widht:100%">
                                        <thead>
                                            <tr>
                                                <th>Kriteria</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Etos Kerja</td>
                                                <td><?=$etos?></td>
                                            </tr>
                                            <tr>
                                                <td>Tradisi</td>
                                                <td><?=$tradisi?></td>
                                            </tr>
                                            <tr>
                                                <td>Tri Tertib</td>
                                                <td><?=$tritertib?></td>
                                            </tr>
                                            <tr>
                                                <td>Atribut</td>
                                                <td><?=$atribut?></td>
                                            </tr>
                                            <tr>
                                                <td>Kinerja</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                
                    </div>

                </div> 
            </div>

        </div>
        <!-- Nilai etos & Tradisi-->
        <div class="row pb-4">

            <div class="col-md-6 col-xs-12">

                <div class="card">

                    <div class="card-header">

                        <h5>Nilai Etos Planters</h5>
                   
                    </div>

                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="text-center">
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?=$detailetos['total']?>%;background-color:<?=warna('1',$detailetos['total'])?>" aria-valuenow="<?=$detailetos['total']?>" aria-valuemin="0" aria-valuemax="100"><h4 style="margin: auto;"><?=$detailetos['total']?>%</h4></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Parameter Etos</th>
                                                <th>Nilai Etos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach($detailetos['detail'] as $key=>$val){
                                                echo "<tr>";
                                                echo "<td>".$key."</td>";
                                                echo "<td>".$val."</td>";
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

            <div class="col-md-6 col-xs-12">

                <div class="card">

                    <div class="card-header">

                        <h5>Nilai Tradisi Planters</h5>
                    
                    </div>

                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="text-center">
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar" role="progressbar" style="width:<?=$detailtradisi['total']?>%;background-color:<?=warna('2',$detailtradisi['total'])?>" aria-valuenow="<?=$detailtradisi['total']?>" aria-valuemin="0" aria-valuemax="100"><h4 style="margin: auto;"><?=$detailtradisi['total']?>%</h4></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Parameter Tradisi</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($detailtradisi['detail'] as $key=>$val){
                                                    echo "<tr>";
                                                    echo "<td>".$key."</td>";
                                                    echo "<td>".$val."</td>";
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
        </div>
         <!-- End Nilai etos & Tradisi -->
       
        
        
        <!-- Tri tertib & Atribut -->
        <div class="row pb-4">

            <div class="col-md-6 col-xs-12">

                <div class="card">

                    <div class="card-header">

                        <h5>Nilai Tri Tertib Planters</h5>
                     
                    
                    </div>

                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="text-center">
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?=$detailtritertib['total']?>%;background-color:<?=warna('3',$detailtritertib['total'])?>" aria-valuenow="<?=$detailtritertib['total']?>" aria-valuemin="0" aria-valuemax="100"><h4 style="margin: auto;"><?=$detailtritertib['total']?>%</h4></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Komoditas</th>
                                                <th>Tri Tertib</th>
                                                <th>Parameter</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?=$detailtritertib['detail']?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                
                    </div>

                </div> 

            </div>

            <div class="col-md-6 col-xs-12">

                <div class="card">

                    <div class="card-header">

                        <h5>Nilai Atribut Planters</h5>
                    </div>
                   
                    <div class="card-body pb-2 ">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="text-center">
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?=$detailatribut['total']?>%;background-color:<?=warna('4',$detailatribut['total'])?>" aria-valuenow="<?=$detailatribut['total']?>" aria-valuemin="0" aria-valuemax="100"><h4 style="margin: auto;"><?=$detailatribut['total']?>%</h4></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Komoditas</th>
                                                <th>Asisten<th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?=$detailatribut['detail']?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                
                    </div>

                </div> 

            </div>

        </div>
        <!-- End Nilai Tradisi -->
        
        <!-- tradisi -->
        <div class="row pb-4">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header">

                        <h5>Nilai Kinerja Planters</h5>
                        <p><i>dalam pembangunan</i></p>
                    </div>

                    <div class="card-body pb-2 ">
                        <div class="row">
                            <?php
                                $k2023=0;
                                $k2022=0;
                                $k2021=0;
                                $count=0;
                                                
                                foreach($detailkinerja as $dk){
                                    //echo $dk['k2023'];
                                    $k2023+=$dk['k2023'];
                                    $k2022+=$dk['k2022'];
                                    $k2021+=$dk['k2021'];
                                    $count++;
                                    }
                                $d2023=ROUND($k2023/$count,2);
                                $d2022=ROUND($k2022/$count,2);
                                $d2021=ROUND($k2021/$count,2);

                                $progress=round($d2023/$d2022,2)*100;

                                echo "Total score 2023 :".$k2023."<br>?";
                                echo "Total data :".$count."<br>";
        ?>

                            <div class="col-md-12 col-xs-12 pb-4">
                                <div class="text-center">
                                    <div class="progress" style="height: 40px;">
                                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                        <!--<div class="progress-bar" role="progressbar" style="width: 75%;background-color:<?=warna(0,$progress)?>" aria-valuenow="<?=$progress?>" aria-valuemin="0" aria-valuemax="100"><h4 style="margin: auto;"><?=$progress?>%</h4></div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">


                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Kinerja</th>
                                                <th>Nilai Rerata Kinerja</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <tr>
                                                <td>2023</td>
                                                <td><?=$d2023?></td>
                                            </tr>
                                            <tr>
                                                <td>2022</td>
                                                <td><?=$d2022?></td>
                                            </tr>
                                            <tr>
                                                <td>2021</td>
                                                <td><?=$d2021?></td>
                                            </tr>
                                        </tbody>
                                    

                                    </table>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div> 
            </div>
        </div>
        <!-- End Nilai Tri tertib & Atribut -->
        
    
        <?php
                    $tt = number_format(rtrim(sprintf("%.20f", (microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'])), "0"),6,'.',',');
                    if (strpos(($tt."0"), "0") != 0) {
                      $tt = number_format($tt,2,'.',',');
                    }
                    echo "load page: ".$tt." detik";?>
    </div>

 </div>



 <!-- MODAL -->

 <!-- Modal -->

<div class="modal fade" id="mdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

  <div class="modal-dialog modal-xl" role="document">

    <div class="modal-content ">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Detail Nilai</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        <div id="kontendetail">

        </div>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

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

        $('#NPSdata thead th').each( function (i) {

            var title = $('#NPSdata thead th').eq( $(this).index() ).text();

                if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6"){

                    $(this).html( '<input style="width:100px" type="text" placeholder="'+title+'" data-index="'+i+'" />' );

                }

        } );





    var tablepengisian =   $('#NPSdata').DataTable({
            dom: 'lBfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf',
                {
                extend: "print",
                customize: function(win)
                        {
            
                            var last = null;
                            var current = null;
                            var bod = [];
            
                            var css = '@page { size: landscape; }',
                                head = win.document.head || win.document.getElementsByTagName('head')[0],
                                style = win.document.createElement('style');
            
                            style.type = 'text/css';
                            style.media = 'print';
            
                            if (style.styleSheet)
                            {
                            style.styleSheet.cssText = css;
                            }
                            else
                            {
                            style.appendChild(win.document.createTextNode(css));
                            }
            
                            head.appendChild(style);
                    }
                }
            ],
            columnDefs: [
                { type: 'natural',
                  targets: 0 }, 
                { "visible": false, "targets": [8,10,12,14,16,18] }
                
            ],
            responsive:true,
        });

        tablepengisian.search( "").draw();
        $( tablepengisian.table().container() ).on( 'keyup', 'thead input', function () {
            tablepengisian
                .column( $(this).data('index') )
                .search( this.value )
                .draw();
        } );





        $('#kinerjadata thead th').each( function (i) {

            var title = $('#kinerjadata thead th').eq( $(this).index() ).text();

                if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6"){

                    $(this).html( '<input style="width:100px" type="text" placeholder="'+title+'" data-index="'+i+'" />' );

                }

        } );





        var tablepengisian2=   $('#kinerjadata').DataTable({

            dom: 'Bfrtip',

            buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

            ],

            responsive:true,

        });



        tablepengisian2.search( "").draw();

        $( tablepengisian2.table().container() ).on( 'keyup', 'thead input', function () {

            tablepengisian2

                .column( $(this).data('index') )

                .search( this.value )

                .draw();

        } );



        

        $(document).on('click', '.btdetail', function(e) {

            var token=$(this).data('token');

            var konten=getdatanilai(token);

            $("#mdetail").modal("show");

            ($("#kontendetail").html(konten));

        })



       

        function getdatanilai(token){

            var text="";

            var urldata= base_url + 'API/detailnilai';

            $.ajax({

                url: urldata, 

                type: 'get',

                async: false,

                data :{token:token},

                beforeSend: function() {

                    $("#mdinfo").show();

                },

                success: function(result) {

                    $("#mdinfo").hide();

             

                var res=JSON.parse(result);

                text +="<div class='row'>"+

                            "<div class='col-md-12 col-xs-12'> "+

                            "<div class='alert alert-success' role='alert'>"+

                            "<h4 class='alert-heading'>Informasi!</h4>"+

                            "<p>Pilih menu yang tersedia untuk membuka detail data evaluasi</p></div></div>"+

                            "<div class='col-md-4 py-4'><button class='btn btn-primary btn-block' type='button' data-toggle='collapse' data-target='#etos' aria-expanded='false' aria-controls='collapseExample'>"+

                            "Etos Kerja </button></div>"+

                            "<div class='col-md-4 py-4'><button class='btn btn-primary btn-block' type='button' data-toggle='collapse' data-target='#tradisi' aria-expanded='false' aria-controls='collapseExample'>"+

                            "Tradisi </button></div>"+

                            "<div class='col-md-4 py-4'><button class='btn btn-primary btn-block' type='button' data-toggle='collapse' data-target='#tritertib' aria-expanded='false' aria-controls='collapseExample'>"+

                            "Tri Tertib </button></div>"+

                            "<div class='col-md-4 py-4'><button class='btn btn-primary btn-block' type='button' data-toggle='collapse' data-target='#atribut' aria-expanded='false' aria-controls='collapseExample'>"+

                            "Atribut </button></div>"+

                            "<div class='col-md-4 py-4'><button class='btn btn-primary btn-block' type='button' data-toggle='collapse' data-target='#kinerja' aria-expanded='false' aria-controls='collapseExample'>"+

                            "kinerja </button></div>"+

                        "</div>";

                   //alert(disp);

                  // $('#detNPS').find('.modal-body').append(disp);

                  text += "<div class='row'>"+

                          "<div class='col-md-12 col-xs-12'>";

                  text += "<div class='collapse' id='etos'>"+

                            "<div class='card card-body'>";

                  text +="<h3 class='text-center'>" + res.nopeg + " /"+res.nama + "</h3>";

                  text +="<div class='table-responsive'>" +

                         "<table class='table table-bordered' width='100%'>"+

                            "<thead >"+ 

                                "<tr class='text-center table-info'><td colspan='2'><h5>ETOS KERJA</h5></td></tr>"+

                                "<tr class='table-warning'>"+

                                    "<td>Penilai</td>"+

                                    "<td>Nilai</td>"+

                                "<tr>"+

                            "</thead>";

                    text +="<tbody>";

                        for(var i=0 ; i< res.etos.length ; i++){

                            text +="<tr><td>" + res.etos[i].penilai + "</td><td>" + res.etos[i].nilai + "</td></tr>"

                        }

                    text +="</tbody>";

		        text +="</table></div><hr>";

                text += "</div></div>";



                text += "<div class='collapse' id='tradisi'>"+

                            "<div class='card card-body'>";

                text +="<div class='table-responsive'>" +

                         "<table  class='table table-bordered' width='100%'>"+

                            "<thead >"+

                                "<tr class='text-center table-info'><td colspan='2'><h5>TRADISI</h5></td></tr>"+

                                "<tr class='table-warning'>"+

                                    "<td>Penilai</td>"+

                                    "<td>Nilai</td>"+

                                "<tr>"+

                            "</thead>";

                    text +="<tbody>";

                        for(var i=0 ; i< res.tradisi.length ; i++){

                            text +="<tr><td>" + res.tradisi[i].penilai + "</td><td>" + res.tradisi[i].nilai + "</td></tr>"

                        }

                    text +="</tbody>";

		        text +="</table></div><hr>";

                text += "</div></div>";



                text += "<div class='collapse' id='tritertib'>"+

                            "<div class='card card-body'>";

                text +="<div class='table-responsive'>" +

                         "<table class='table table-bordered ' width='100%'>"+

                            "<thead >"+

                                "<tr class='text-center table-info'><td colspan='2'><h5>TRI TERTIB</h5></td></tr>"+

                                "<tr class='table-warning'>"+

                                    "<td>Penilai</td>"+

                                    "<td>Nilai</td>"+

                                "<tr>"+

                            "</thead>";

                    text +="<tbody>";

                        for(var i=0 ; i< res.tritertib.length ; i++){

                            text +="<tr><td>" + res.tritertib[i].penilai + "</td><td>" + res.tritertib[i].nilai + "</td></tr>"

                        }

                    text +="</tbody>";

		        text +="</table></div><hr>";

                text += "</div></div>";



                text += "<div class='collapse' id='atribut'>"+

                            "<div class='card card-body'>";

                text +="<div class='table-responsive'>" +

                         "<table class='table table-bordered' width='100%'>"+

                            "<thead >"+

                                "<tr  class='text-center table-info'><td colspan='2'><h5>ATRIBUT</h5></td></tr>"+

                                "<tr class='table-warning'>"+

                                    "<td>Penilai</td>"+

                                    "<td>Nilai</td>"+

                                "<tr>"+

                            "</thead>";

                    text +="<tbody>";

                        for(var i=0 ; i< res.atribut.length ; i++){

                            text +="<tr><td>" + res.atribut[i].penilai + "</td><td>" + res.atribut[i].nilai + "</td></tr>"

                        }

                    text +="</tbody>";

		        text +="</table></div><hr>";

                text += "</div></div>";



                text += "<div class='collapse' id='kinerja'>"+

                            "<div class='card card-body'>";

                text +="<div class='table-responsive' width='100%' style ='table-layout: fixed; word-wrap: break-word;'>" +

                         "<table class='table table-bordered'  width='100%'>"+

                            "<thead >"+

                                "<tr class='text-center table-info'><td colspan='10'><h5>KINERJA</h5></td></tr>"+

                                

                            "</thead>";



                   text +="<tbody>";

                   console.log(res.kinerja);

                   //text +=res.kinerja;

                                    var tl="";

                                    var rl="";

                                    var nl="";

                                    var t="";

                                    var r="";

                                    var n="";

                        for(var i=0 ; i< res.kinerja.length ; i++){

                            const obj=res.kinerja[i].data;

                            Object.keys(obj).forEach(key => {

                            text +="<tr class='bg-primary text-white'><td colspan='10'>" + key + "</td></tr>"; 

                            text +="<tr class='table-warning'>"+

                                    "<td>soal</td>"+

                                    "<td></td>"+

                                    "<td>T lalu</td>"+

                                    "<td>R lalu</td>"+

                                    "<td>Skor lalu</td>"+

                                    "<td>T</td>"+

                                    "<td>R</td>"+

                                    "<td>Skor</td>"+

                                "<tr>";

                                const obj2=obj[key];

                                Object.keys(obj2).forEach(keys => {

                                    if(isset(obj2[keys][1])){

                                        tl=obj2[keys][1].target;

                                        rl=obj2[keys][1].realisasi;

                                        nl=obj2[keys][1].nilai;

                                    }else{

                                        tl=0;

                                        rl=0;

                                        nl=0;

                                    }



                                    if(isset(obj2[keys][0])){

                                        t=obj2[keys][0].target;

                                        r=obj2[keys][0].realisasi;

                                        n=obj2[keys][0].nilai;

                                    }else{

                                        t=0;

                                        r=0;

                                        n=0;

                                    }

                                    var posisi="";

                                    if(nl < n){

                                        posisi="<i class='fas fa-arrow-up fa-fw text-success'></i>";

                                    }else if(n == nl){

                                        posisi="<i class='fas fa-minus fa-fw text-warning'></i>";

                                    }

                                    else{

                                        posisi="<i class='fas fa-arrow-down fa-fw text-danger'></i>";

                                    }

                                  

                                    

                                  

                                    text +="<tr>";

                                    text +="<td>" + keys+ "</td> "+

                                    "<td>"+ posisi +"</td> "+

                                    "<td>"+ tl+"</td>"+

                                    "<td>"+ rl+"</td> "+

                                    "<td>"+ nl+"</td> "+

                                    "<td>"+ t +"</td>"+

                                    "<td>"+ r +"</td> "+

                                    "<td>"+ n +"</td> ";

                                  

                                    text += "</tr>";

                                })

                          

                           

                        });

                        

                          

                        

                           // text +="<tr><td>" + res.kinerja[i]['data'] + "</td>" + 

                                  

                                    //

                        }

                    text +="</tbody>";

		        text +="</table></div><hr>";

                text += "</div></div>";

                text += "</div>"+

                          "</div>";

                

                }

                

            })

            return (text);

        }



        function isset (ref) { return typeof ref !== 'undefined' }

    })

 </script>