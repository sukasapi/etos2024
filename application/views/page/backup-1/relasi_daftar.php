 <style>
tfoot input {
  width: 90%;
  display: block;
  margin-right: auto;
  margin-left: auto;
}
</style>
 <!-- Begin Page Content -->
<div class="container-fluid">
        <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800"><?=$pageName?></h1>
    </div>
    
    <div class="row">
    <?php 
        if($this->session->flashdata('success')){
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>BERHASIL</strong>
                <p><?=$this->session->flashdata('success')?></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
            <?php
        }else if(  $this->session->flashdata('error')){
             ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal</strong>
                <p><?=$this->session->flashdata('error')?></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <?php
        }else{
        }
        ?>

        <!-- TABEL RELASI -->
        <div class="col-md-12 col-xs-12">
           <div class="card shadow mb-4">
                <div class="card-header py-3">
                   <div class="d-sm-flex align-items-center justify-content-between">
                        <h1 class="h6 mb-2 text-gray-800">Daftar Relasi Peserta</h1>
                   <!--     <a href="#" data-toggle="modal" data-target="#maddatasan" id="bmadatasan" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                           <i class="fas fa-plus fa-sm text-white-50"></i> 
                            Tambah Relasi
                        </a> -->
                   </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm" width="95%" id="tbrelasi" >
                                    <thead class="text-center">
                                    <tr>
                                        <th rowspan="2"  >No</th>
                                        <th rowspan="2">NIK</th>
                                        <th rowspan="2">Nama</th>
                                        <th rowspan="2">Entitas</th>
                                        <th rowspan="2">Batch</th>
                                        <th colspan="2">Atasan</th>
                                        <th colspan="2">Mitra</th>
                                    </tr>
                                    <tr>
                                        <th>NIK Atasan</th>
                                        <th>Nama Atasan</th>
                                        <th>NIK Mitra</th>
                                        <th>Nama Mitra</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                            $str="";
                                            $i=1;
                                            foreach($peserta as $pe){
                                                $natasan="";
                                                $nikatasan="";
                                                if(count((array)$pe['atasan']) > 0){
                                                 foreach($pe['atasan'] as $at){
                                                    $nikatasan=$at['nikkoneksi'];
                                                    $natasan=$at['nama_koneksi'];
                                                 }   
                                                }else{
                                                    $nikatasan="-";
                                                    $natasan="-";
                                                }
                                                
                                                $nmitra="";
                                                $nikmitra="";
                                                if(count((array)$pe['mitra']) > 0){
                                                    foreach($pe['mitra'] as $mt){
                                                        $nikmitra.="<ul>";
                                                        $nikmitra.="<li>".$mt['nikkoneksi']."</li>";
                                                        $nikmitra.="</ul>";
                                                        $nmitra.="<ul>";
                                                        $nmitra.="<li>".$mt['nama_koneksi']."</li>";
                                                        $nmitra.="</ul>"; 
                                                    }
                                                }else{
                                                    $nmitra.="-";
                                                    $nikmitra.="-";
                                                }


                                                $str .="<tr>";
                                                $str .="<td>".$i."</td>";
                                                $str .="<td>".$pe['nopeg']."</td>";
                                                $str .="<td>".ucfirst(strtolower($pe['nama']))."</td>";
                                                $str .="<td>".$pe['perusahaan']."</td>";
                                                $str .="<td>".$pe['batch']."</td>";
                                                $str .="<td>".$nikatasan."</td>";
                                                $str .="<td>".ucfirst(strtolower($natasan))."</td>";
                                                $str .="<td>".$nikmitra."</td>";
                                                $str .="<td>".ucfirst(strtolower($nmitra))."</td>";
                                                $str .="</tr>";
                                                $i++;
                                            }
                                            
                                            echo $str;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Entitas</th>
                                        <th>Batch</th>
                                        <th>NIK Atasan</th>
                                        <th>Nama Atasan</th>
                                        <th>NIK Mitra</th>
                                        <th>Nama Mitra</th>
                                        </tr>
                                    </tfoot>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

           </div>
        </div>

        <!-- END TABEL RELASI -->
    </div>
    

</div>

<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script> 
 <!----- Button datatables--------> 
 <script src="<?=base_url('assets/')?>vendor/datatables/button/dataTables.buttons.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.html5.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.print.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/jszip.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/vfs_fonts.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/button/buttons.colVis.min.js"></script>
<script>
     $(document).ready(function() {
        $('#tbrelasi tfoot th').each( function (i) {
        var title = $('#tbrelasi thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text"  data-index="'+i+'" />' ); 
    } );

        var table = $('#tbrelasi').removeAttr('width').DataTable({
            dom: 'Bfrtip',
            buttons: [
             'csv', 'excel', 'colvis'
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
     })
</script>