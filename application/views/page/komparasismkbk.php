

<div class="container-fluid">

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            <h1 class="h3 mb-2 text-gray-800"> Data Komparasi Kinerja 2021 dengan SMKBK 2021</h1>

        </div>
 
        <div class="row">

            <div class="col-md-12">

                <div class="alert alert-success" role="alert">

                    <h4 class="alert-heading">Informasi</h4>

                    <ul>

                        <li> <p>Data Kinerja  bersumber pada data penilaian SMKBK tahun terkait.</p></li>
                        <li> <p>Nilai smkbk adalah hasil upload csv dari nilai smkbk tahun terkait.</p></li>


                    </ul>

                   

                </div>

            </div>

        </div>



        <hr>

        <div class="row">

            <div class="col-md-12">

                <div class="card bg-white">

                    <div class="card-body ">

                            <div class="table-responsive">

                                <table class="table table-bordered" id="tb_progress" width="100%">

                                    <thead>

                                        <tr>

                                            <th style="width:10%">No</th>

                                            <th style="width:10%">NIK</th>

                                            <th style="width:20%">Nama</th>

                                            <th style="width:10%">Entitas</th>

                                            <th style="width:10%">Batch</th>

                                            <th style="width:10%">Progress</th>

                                            <th style="width:10%">2021|2022</th>

                                            <th style="width:10%">2023</th>
                                            

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <?php

                                        $c=1;

                                            foreach($kinerja as $k){
                                                $n2021=is_null($k['n2021'])?0:$k['n2021'];
                                                $n2022=is_null($k['n2022'])?0:$k['n2022'];

                                                $n2023=is_null($k['n2023'])?0:$k['n2023'];

                                                if($k['n2023'] > $k['n2022']){

                                                    $progress="<i class='fas fa-arrow-up fa-fw text-success'></i>";

                                                }else if($k['n2023'] == $k['n2022']){

                                                    $progress="<i class='fas fa-minus fa-fw text-warning'></i>";

                                                }else{

                                                    $progress="<i class='fas fa-arrow-down fa-fw text-danger'></i>";

                                                }



                                            echo "<tr>";

                                                echo "<td>".$c."</td>";

                                                echo "<td>".$k['nopeg']."</td>";

                                                echo "<td>".$k['nama']."</td>";

                                                echo "<td>".$k['perusahaan']."</td>";

                                                echo "<td>".$k['batch']."</td>";

                                                echo "<td>".$progress."</td>";

                                                echo "<td>".$n2021."|".$n2022."</td>";

                                                echo "<td>".$n2023."</td>";

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

                if(i =="1" || i =="2" || i =="3" || i =="4" ){

                    $(this).html( '<input type="text" style="width:100%" placeholder="'+title+'" data-index="'+i+'" />' );

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