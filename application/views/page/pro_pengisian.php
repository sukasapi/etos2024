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
                                        <th>No.</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Entitas</th>
                                        <th>Komoditas</th>
                                        <th>Jenis Asisten</th>
                                        <th>Batch</th>
                                        <th>progress</th>
                                        <th>Etos Kerja</th>
                                        <th>Tradisi</th>
                                        <th>Tri Tertib</th>
                                        <th>Atribut</th>
                                        <th>Kinerja</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    <?php
                                    $i=1;
                                    $str="";
                                        foreach($npsnonkinerja as $nnk){
                                         
                                           $str.="<tr>";
                                           $str.="<td>".$i."</td>";
                                           $str.="<td>".$nnk['nopeg']."</td>";
                                           $str.="<td>".$nnk['nama']."</td>";
                                           $str.="<td>".$nnk['perusahaan']."</td>";
                                           $str.="<td>".$nnk['komoditas']."</td>";
                                           $str.="<td>".$nnk['asisten']."</td>";
                                           $str.="<td>".$nnk['batch']."</td>";
                                           $str.="<td>".$nnk['nps']."</td>";
                                           $str.="<td>".round($nnk['etos'],2)."</td>";
                                           $str.="<td>".round($nnk['tradisi'],2)."</td>";
                                           $str.="<td>".round($nnk['tritertib'],2)."</td>";
                                           $str.="<td>".round($nnk['atribut'],2)."</td>";
                                           $str.="<td>".round($nnk['kinerja'],2)."</td>";
                                           $str.="</tr>";
                                           $i++;
                                        }
                                        echo $str;
                                    ?>
                                </tbody> 
                                <tfoot>
                                <tr>
                                        <th>No.</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Entitas</th>
                                        <th>Komoditas</th>
                                        <th>Jenis Asisten</th>
                                        <th>Batch</th>
                                        <th>progress</th>
                                        <th>Etos Kerja</th>
                                        <th>Tradisi</th>
                                        <th>Tri Tertib</th>
                                        <th>Atribut</th>
                                        <th>Kinerja</th>
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
        $('#NPSdata tfoot th').each( function (i) {
        var title = $('#NPSdata thead th').eq( $(this).index() ).text();
        if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6"){
            $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
        }
      
    } );

    var table =   $('#NPSdata').DataTable({
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
       
        $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );
       
    table.columns.adjust().draw();
    })
 </script>