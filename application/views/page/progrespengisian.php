

<div class="container-fluid">
 
        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-2 text-gray-800"></h1>

        </div>

        <div class="row">

            <div class="col-md-12">

                <div class="table-responsive">

                    <table class="table table-bordered" id="tb_progress" width="100%">

                        <thead>

                            <tr>

                                <th style="width:10%">NIK</th>

                                <th style="width:10%">Nama</th>

                                <th style="width:15%">Entitas</th>

                                <th>Batch</th>

                                <th>Evaluasi</th>

                                <th>Progress</th>

</tr>

                        </thead>

                        <tbody>

                            <?php

                                foreach($progress as $p){

                                   

                                    switch($p['jenis']){

                                        case '5':

                                            $jenis="kinerja";

                                        break;

                                        case '4':

                                            $jenis="Atribut";

                                        break;

                                        case '3':

                                            $jenis="Tri Tertib";

                                        break;

                                        case '2':

                                            $jenis="Tradisi";

                                        break;

                                        case '1':

                                            $jenis="Etos kerja";

                                        break;

                                    }

                                  //  print_r($p);

                                   $this->db->select('p.nopeg,p.nama,c.kode')

                                             ->from('tb_peserta as p')

                                             ->join('tb_user as u','u.id=p.userid')

                                             ->join('tb_perusahaan as c','c.id=u.company')

                                             ->where('p.userid',$p['NoPenilai']);

                                    $q=$this->db->get()->result();

                                    

                                    if(count((array)$q) > 0){

                                        $nopeg=$q[0]->nopeg;

                                        $nama=$q[0]->nama;

                                        $entitas=$q[0]->kode;

                                        echo "<tr>";

                                        echo "<td>".$nopeg."</td>";

                                        echo "<td>".$nama."</td>";

                                        echo "<td>".$entitas."</td>";

                                        echo "<td>".$p['batch']."</td>";

                                        echo "<td>".$jenis."</td>";

                                        echo "<td>".$p['done']." dari ".$p['jatah']."</td>";

                                     

                                    echo "</tr>";

                                    }else{

                                        

                                    }

                                    /*

                                    //echo $q->nopeg."<br>";

                                  

                                    */

                                }

                            ?>

                        </tbody>

                    </table>

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

                if(i =="1" || i =="2" || i =="3" || i =="4" || i =="5" || i =="6"){

                    $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );

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