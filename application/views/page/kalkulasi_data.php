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

            <h1 class="h3 mb-0 text-gray-800">KALKULASI DATA EVALUASI</h1>

        </div>

        <div class="row pb-4">

            <div class="col-md-12 col-xs-12">

                

                <div class="card card-info">

                    <div class="card-header text-white bg-primary">

                        <h5>NPS</h5>

                    </div>

                    <div class="card-body pb-2 ">

                        <div class="table-responsive">

                            <table id="NPSdata" class="table table-bordered" width="95%">

                                <thead>

                                    <tr>

                                        <th style="width:5%">No.</th>

                                        <th style="width:8%">NIK</th>

                                        <th style="width:8%">Nama</th>

                                        <th style="width:10%">Entitas</th>

                                        <th style="width:10%">Komoditas</th>

                                        <th style="width:10%">Jenis Asisten</th>

                                        <th style="width:3%">Batch</th>

                                     

                                        <th style="width:5%">NPS total</th>
                                        <th></th>
                                       
                                       
                                        <th style="width:5%">Etos Kerja</th>
                                        <th></th>
                                        <th style="width:5%">Tradisi</th>
                                        <th></th>
                                        <th style="width:5%">Tri Tertib</th>
                                        <th></th>
                                        <th style="width:5%">Atribut</th>
                                        <th></th>

                                        <th style="width:5%">Kinerja smkbk</th>
                                        <th></th>
                                        <th style="width:5%">NPS + SMKBK (bobot)</th>
                                        <th style="width:5%">Detail</th>

                                    </tr>

                                </thead> 

                                <tbody>

                                    <?php

                                    $i=1;

                                    $str="";

                                        foreach($npsnonkinerja as $nnk){
                                            
                                            if(floor($nnk['etos']) > 85){
                                                $etosdesk="tinggi";
                                                $etosstat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='tinggi'>".round($nnk['etos'],2)."</span>";
                                            }else if(floor($nnk['etos']) >= 66 && floor($nnk['etos']) <= 85){
                                                $etosdesk="cukup";
                                                $etosstat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='cukup'>".round($nnk['etos'],2)."</span>";
                                            }else if(floor($nnk['etos']) >= 46 && floor($nnk['etos']) <= 65){
                                                $etosdesk="rendah";
                                                $etosstat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='rendah'>".round($nnk['etos'],2)."</span>";
                                            }
                                            else{
                                                $etosdesk="sangat rendah";
                                                $etosstat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='sangat rendah'>".round($nnk['etos'],2)."</span>";
                                            }

                                            if(floor($nnk['tradisi']) > 85){
                                                $tradisidesk="menjalankan dan menghayati";
                                                $tradisistat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='menjalankan dan menghayati'>".round($nnk['tradisi'],2)."</span>";
                                            }else if(floor($nnk['tradisi']) >= 66 && floor($nnk['tradisi']) <= 85){
                                                $tradisidesk="menjalankan";
                                                $tradisistat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='menjalankan'>".round($nnk['tradisi'],2)."</span>";
                                            }else if(floor($nnk['tradisi']) >= 46 && floor($nnk['tradisi']) <= 65){
                                                $tradisidesk="tidak konsisten menjalankan";
                                                $tradisistat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='tidak konsisten menjalankan'>".round($nnk['tradisi'],2)."</span>";
                                            }
                                            else{
                                                $tradisidesk="tidak menjalankan";
                                                $tradisistat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='tidak menjalankan'>".round($nnk['tradisi'],2)."</span>";
                                            }

                                            
                                            if(floor($nnk['tritertib']) > 90){
                                                $tritertibdesk="tertib";
                                                $tritertibstat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='tertib'>".round($nnk['tritertib'],2)."</span>";
                                            }else if(floor($nnk['tritertib']) >= 81 && floor($nnk['tritertib']) <= 90){
                                                $tritertibdesk="cukup tertib";
                                                $tritertibstat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='cukup tertib'>".round($nnk['tritertib'],2)."</span>";
                                            }else if(floor($nnk['tritertib']) >= 61 && floor($nnk['tritertib']) <= 80){
                                                $tritertibdesk="kurang tertib";
                                                $tritertibstat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='kurang tertib'>".round($nnk['tritertib'],2)."</span>";
                                            }
                                            else{
                                                $tritertibdesk="tidak tertib";
                                                $tritertibstat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='tidak tertib'>".round($nnk['tritertib'],2)."</span>";
                                            }

                                            if(floor($nnk['atribut']) > 85){
                                                $atributdesk="berdisplin tinggi";
                                                $atributstat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='berdisplin tinggi'>".floor($nnk['atribut'])."</span>";
                                            }else if(floor($nnk['atribut']) >= 66 && floor($nnk['atribut']) <= 85){
                                                $atributdesk="cukup berdisplin";
                                                $atributstat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='cukup berdisiplin'>".round($nnk['atribut'],2)."</span>";
                                            }else if(floor($nnk['atribut']) >= 46 && floor($nnk['atribut']) <= 65){
                                                $atributdesk="berdisplin rendah";
                                                $atributstat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='berdisiplin rendah'>".round($nnk['atribut'],2)."</span>";
                                            }else{
                                                $atributdesk="berdisiplin sangat rendah";
                                                $atributstat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='berdisiplin sangat rendah'>".round($nnk['atribut'],2)."</span>";;
                                            }

                                            if(floor($nnk['nps']) > 90){
                                                $npsdesk="Planters Role Model";
                                                $npsstat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='Planters Role Model'>".round($nnk['nps'],2)."</span>";
                                            }else if($nnk['nps'] >= 81 && floor($nnk['nps']) <= 90){
                                                $npsdesk="Good Planters";
                                                $npsstat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='Good Planters'>".round($nnk['nps'],2)."</span>";
                                            }else if($nnk['nps'] >= 71 && floor($nnk['nps']) <= 80){
                                                $npsdesk="Mediocore Planters";
                                                $npsstat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='Mediocore Planters'>".round($nnk['nps'],2)."</span>";
                                            }else if($nnk['nps'] >= 51 && floor($nnk['nps']) <= 70){
                                                $npsdesk="Distracted Planters";
                                                $npsstat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='Distracted Planters'>".round($nnk['nps'],2)."</span>";
                                            }
                                            else{
                                                 $npsdesk="Dissident";
                                                 $npsstat="<span class='badge badge-pill badge-dark' data-toggle='tooltip' data-placement='top' title='Dissident'>".round($nnk['nps'],2)."</span>";;
                                            }

                                            if((int)$nnk['kinerjasmkbk'] > 90){
                                                $kinerjadesk="tinggi";
                                                $kinerjastat="<span class='badge badge-pill badge-primary' data-toggle='tooltip' data-placement='top' title='tinggi'>".round($nnk['kinerjasmkbk'],2)."</span>";
                                            }else if((int)$nnk['kinerjasmkbk'] >= 81 && (int)$nnk['kinerjasmkbk'] <= 90){
                                                $kinerjadesk="cukup";
                                                $kinerjastat="<span class='badge badge-pill badge-success' data-toggle='tooltip' data-placement='top' title='cukup'>".round($nnk['kinerjasmkbk'],2)."</span>";
                                            }else if((int)$nnk['kinerjasmkbk'] >= 71 && (int)$nnk['kinerjasmkbk'] <= 80){
                                                $kinerjadesk="sedang";
                                                $kinerjastat="<span class='badge badge-pill badge-warning' data-toggle='tooltip' data-placement='top' title='sedang'>".round($nnk['kinerjasmkbk'],2)."</span>";
                                            }else if((int)$nnk['kinerjasmkbk'] >= 51 &&(int)$nnk['kinerjasmkbk'] <= 70){
                                                $kinerjadesk="rendah";
                                                $kinerjastat="<span class='badge badge-pill badge-danger' data-toggle='tooltip' data-placement='top' title='rendah'>".round($nnk['kinerjasmkbk'],2)."</span>";
                                            }
                                            else{
                                                $kinerjadesk="sangat rendah";
                                                $kinerjastat="<span class='badge badge-pill badge-dark' data-toggle='tooltip' data-placement='top' title='sangat rendah'>".round($nnk['kinerjasmkbk'],2)."</span>";;
                                            }



                                           $str.="<tr>";

                                           $str.="<td>".$i."</td>";

                                           $str.="<td>".$nnk['nopeg']."</td>";

                                           $str.="<td>".$nnk['nama']."</td>";

                                           $str.="<td>".$nnk['perusahaan']."</td>";

                                           $str.="<td>".$nnk['komoditas']."</td>";

                                           $str.="<td>".$nnk['asisten']."</td>";

                                           $str.="<td>".$nnk['batch']."</td>";

                                           $str.="<td  class='text-center'>".$npsstat."</td>";
                                           $str.="<td>".$npsdesk."</td>";

                                           $str.="<td class='text-center'>".$etosstat."</td>";
                                           $str.="<td>".$etosdesk."</td>";

                                           $str.="<td class='text-center'>".$tradisistat."</td>";
                                           $str.="<td>".$tradisidesk."</td>";
                                           $str.="<td class='text-center'>".$tritertibstat."</td>";
                                           $str.="<td>".$tritertibdesk."</td>";
                                           $str.="<td class='text-center'>".$atributstat."</td>";
                                           $str.="<td>".$atributdesk."</td>";
                                           $str.="<td class='text-center'>".$kinerjastat."</td>";
                                           $str.="<td>".$kinerjadesk."</td>";
                                           $str.="<td  class='text-center'>".round($nnk['nilaibobot'],2)."</td>";
                                           $str .="<td><button class='btn btn-sm btn-info btdetail' data-token='".$nnk['nopeg']."'>Lihat</button></td>";

                                           $str.="</tr>";

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


<!--
        <div class="row pb-4">

            <div class="col-md-12 col-xs-12">              

                <div class="card card-info">

                    <div class="card-header text-white bg-primary">

                        <h5>Detail Nilai Evaluasi</h5>

                    </div>

                    <div class="card-body pb-2 ">

                        <div class="table-responsive">

                            <table id="kinerjadata" class="table table-bordered" width="100%">

                                <thead>

                                    <tr>

                                        <th style="width:5%">No.</th>

                                        <th style="width:8%">NIK</th>

                                        <th style="width:8%">Nama</th>

                                        <th style="width:10%">Entitas</th>

                                        <th style="width:10%">Komoditas</th>

                                        <th style="width:10%">Jenis Asisten</th>

                                        <th style="width:3%">Batch</th>

                                        <th style="width:5%">Kinerja 2022</th>

                                        <th style="width:5%">Kinerja 2021</th>

                                        <th style="width:5%">Status</th>

                                        <th style="width:5%">Detail</th>

                                    </tr>

                                </thead> 

                                <tbody>

                                    <?php

                                    $i=1;

                                    $str="";

                                        foreach($npsnonkinerja as $nnk){

                                            if(round($nnk['kinerja2021'],2) < round($nnk['kinerja'],2)){

                                               $posisi="<i class='fas fa-arrow-up fa-fw text-success'></i>";

                                            }else if (round($nnk['kinerja2021'],2) == round($nnk['kinerja'],2)){

                                                $posisi="<i class='fas fa-minus fa-fw text-warning'></i>";

                                            }

                                            else{

                                                $posisi="<i class='fas fa-arrow-down fa-fw text-danger'></i>";

                                            }

                                           $str.="<tr>";

                                           $str.="<td>".$i."</td>";

                                           $str.="<td>".$nnk['nopeg']."</td>";

                                           $str.="<td>".$nnk['nama']."</td>";

                                           $str.="<td>".$nnk['perusahaan']."</td>";

                                           $str.="<td>".$nnk['komoditas']."</td>";

                                           $str.="<td>".$nnk['asisten']."</td>";

                                           $str.="<td>".$nnk['batch']."</td>";

                                           $str.="<td>".round($nnk['kinerja'],2)."</td>";

                                           $str.="<td>".round($nnk['kinerja2021'],2)."</td>";

                                           $str.="<td>".$posisi."</td>";

                                           $str .="<td><button class='btn btn-sm btn-info btdetail' data-token='".$nnk['nopeg']."'>Lihat</button></td>";

                                           $str.="</tr>";

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

                                    -->

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
            dom: 'Bfrtip',
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
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