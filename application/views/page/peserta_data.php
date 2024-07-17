<!-- Begin Page Content -->

<div class="container-fluid">

    <div class="row">

        <div class="col-md-8">

        <h1 class="h3 mb-2 text-gray-800"><?=$pageTitle;?></h1>

        </div>

        <?php 

            switch($_SESSION['logged_in']['status']){

                case 'admin unit':



                break;

                case 'user':



                break;

                default:

                ?>

                <div class="col-md-4">

                    <div class="row">

                        <div class="col-md-6">

                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#madd">

                                <i class="fas fa-download fa-sm text-white-50"></i> 

                            Export

                            </a>

                        </div>

                        <div class="col-md-6">

                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary badd  shadow-sm" data-toggle="modal" data-target="#maddpeserta">

                            <i class="fas fa-plus fa-sm text-white-50"></i> 

                                Tambah Data

                            </a>

                        </div>

                    </div>

                </div>

                <?php

                break;

                

            }

        ?>

       

    </div>

        <!-- Page Heading -->

        <div class="d-sm-flex align-items-center justify-content-between mb-4">

            

           

        </div>

            <!-- DataTales Example -->

            <div class="card shadow mb-4">

                

                        <div class="card-header py-3">

                            <h6 class="m-0 font-weight-bold text-primary"><?=$pageName?></h6>

                        </div>

                        

                      

                        <div class="card-body">

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

                  }else if($this->session->flashdata('info')){

                    ?>

                    <div class="alert alert-info alert-dismissible fade show" role="alert">

                       <strong>Informasi</strong>

                       <p><?=$this->session->flashdata('info')?></p>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                       </button>

                    </div>

                    <?php

                  }else{



                  }

                  ?>

                            <div class="table-responsive">

                                <table class="table table-bordered" id="tbpeserta" width="100%" cellspacing="0">

                                    <thead>

                                        <tr>

                                            <th>No</th>

                                            <th>NIP<small>(*sebagai username)</small></th>

                                            <th>Nama</th>

                                            <th>Perusahaan</th>

                                            <th>Asisten</th>

                                            <th>Komoditas</th>

                                            <th>Unit Kerja</th>

                                            <th>Tanggal Registrasi</th>

                                            <th>Action</th>

                                        </tr>

                                    </thead>

                                  

                                    <tbody>

                                      

                                        <?php 

                                            $str ="";

                                            $no = 1;

                                            foreach($peserta as $p){

                                                $str.="<tr>";

                                                $str.="<td>".$no."</td>";

                                                $str.="<td>".$p->nopeg."</td>";

                                                $str.="<td>".$p->nama."</td>";

                                                $str.="<td>".$p->perusahaan."</td>";

                                                $str.="<td>".$p->jenis_asisten."</td>";

                                                $str.="<td>".$p->komoditas."</td>";

                                                $str.="<td>".$p->unitusaha."</td>";

                                                $str.="<td>".date('d-M-Y H:i:s',strtotime($p->date_create))."</td>";

                                                $str.="<td>

                                                            <a href='' data-toggle='modal' data-target='#medituser' data-ed='".$this->encryption->encrypt($p->id)."' class='editbt btn btn-warning btn-circle btn-sm'>

                                                            <i class='fas fa-edit'></i>

                                                            </a>

                                                            </a>

                                                       </td>";

                                                $str.="</tr>";

                                                $no++;

                                            }

                                            echo $str;

                                        ?>

                                      

                                     

                                    </tbody>

                                </table>

                            </div>

                        </div>

            </div>

</div>

<!-- /.container-fluid -->



<!-- MODAL -->

<!--ADD MODAL-->

<div class="modal fade" id="madd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Export Data Pengguna</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form id="fadd">

      <div class="modal-body">

      <div id="wait" class="text-center" hidden>

            <div class="spinner-border" role="status">

                <span class="sr-only">Tunggu Sebentar, data sedang diproses ...</span>

            </div>

        </div>

      <div class="form-group">

            <label for="userpass">Data Perusahaan</label>

            <select name="perusahaan" class="form-control" id="perusahaan">

                <?php 

                    foreach($perusahaan as $c){

                        echo "<option value='".$c->id."'>".$c->nama."</option>";

                    }

                ?>

            </select> 

        </div>

        <div class="form-group">

            <label for="username">File Data Peserta </label>

            <input type="file" name="filedata" accept=".csv" id="filedata" class="form-control">

            <small class="msg"><i>* File yang diterima adalah CSV dengan pemisah koma(,)</i></small>

            <small  class="alertinput" style="color:crimson" hidden> <i>* Format bukan CSV</i></small>

        </div>

        <button type="button" id="btadd" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>



        <div id="result" hidden>

            <hr>

            <h5>Hasil Scan File CSV</h5>

            <div class="table-responsive">

            <div id="resultparse"></div>

            </div>

        </div>

        

       

        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                </form>

      </div>

      <div class="modal-footer">

      <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>

        

      </div>

    </div>

  </div>

</div>



<!--EDIT -->

<div class="modal fade" id="medituser" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Edit Pengguna</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form id="fedit">

      <div class="modal-body">

        <div class="form-group">

            <label for="editnopeg">Username Peserta / NOPEG</label>

            <input type="text" name="editnopeg" readonly id="editnopeg" class="form-control">

        </div>

        <div class="form-group">

            <label for="editnama">Nama Peserta</label>

            <input type="text" name="editnama" id="editnama" class="form-control">

        </div>

        <div class="form-group">

            <label for="editperusahaan">Perusahaan</label>

            <select class="form-control" name="editperusahaan" id="editperusahaan">

                <?php 

                    foreach($perusahaan as $c){

                        echo "<option value='".$c->id."'>".$c->nama."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="batch">Angkatan Apel Siaga</label>

            <select class="form-control" name="batch" id="batch">

               <option value='1'>1</option>

               <option value='2'>2</option>

               <option value='3'>3</option>

               <option value='4'>4</option>

               <option value='5'>5</option>

            </select>

        </div>

        <div class="form-group">

            <label for="editstatus">Autorisasi Pengguna</label>

            <select name="editstatus" class="form-control editotor" id="editstatus">

                <?php

                    $utype=usertype();

                    foreach($utype as $t){

                        echo "<option value='".$t."'>".$t."</option>";

                    }

                ?>                        

            </select>

        </div>

        <div class="form-group">

            <label for="editaktif">Aktif</label>

            <select name="aktif" class="form-control editaktif" id="editaktif">

                    <option value='1'>Aktif</option>

                    <option value='0'>Non Aktif</option>

            </select>

            <input type="hidden" name="id" id="edui">

        </div>

        <div class="form-group">

            <label for="editbagian">Bagian</label>

            <input type="text" name="editbagian" id="editbagian" class="form-control">

        </div>

        <div class="form-group">

            <label for="editjabatan">Jabatan</label>

            <input type="text" name="editjabatan" id="editjabatan" class="form-control">

        </div>

     



        <hr>

        <h4> Profil Saat Pelatihan</h4>

        <div class="form-group">

            <label for="asisten">Jenis Asisten</label>

            <select name="asisten" class="form-control " id="asisten">

                <?php 

                    $jasisten=jasisten();

                    foreach($jasisten as $j){

                        echo "<option value='".$j."'>".$j."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="komoditas">Komoditas</label>

            <select name="komoditas" class="form-control">

            <?php 

                $jkomo=jkomoditas();

                    foreach($jkomo as $c){

                        echo "<option value='".$c."'>".ucfirst($c)."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="jabatan">Jabatan</label>

            <input type="text" name="jabatan" id="jabatan" class="form-control">

        </div>

        <div class="form-group">

            <label for="bagian">Bagian</label>

            <input type="text" name="bagian" id="bagian" class="form-control">

        </div>

        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        </form>

      

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>

        <button type="button" id="btedit" class="btn btn-primary" ><i class="fas fa-save text-white-50"></i> Simpan</button>

      </div>

    </div>

  </div>

</div>

<!-- END EDIT -->

<!-- ADD PESERTA --> 

<div class="modal fade" id="maddpeserta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Tambah Peserta</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <form action="<?=base_url('tambahpeserta')?>" method="POST" enctype="multipart/form-data">

      <div class="modal-body">

        <h4> Detail Peserta </h4>

        <div class="form-group">

            <label for="editnopeg">Username Peserta / NOPEG</label>

            <input type="text" name="nopeg"  id="nopeg" class="form-control">

        </div>

        <div class="form-group">

            <label for="editnama">Nama Peserta</label>

            <input type="text" name="nama" id="nama" class="form-control">

        </div>

        <div class="form-group">

            <label for="perusahaan">Entitas</label>

            <select class="form-control" name="perusahaan" id="perusahaan">

                <?php 

                    foreach($perusahaan as $c){

                        echo "<option value='".$c->id."'>".$c->nama."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="batch">Angkatan Apel Siaga</label>

            <select class="form-control" name="batch" id="batch">

               <option value='1'>1</option>

               <option value='2'>2</option>

               <option value='3'>3</option>

               <option value='4'>4</option>

               <option value='5'>5</option>

            </select>

        </div>

        <div class="form-group">

            <label for="status">Autorisasi Pengguna</label>

            <select name="status" class="form-control editotor" id="editstatus">

                <?php

                    $utype=usertype();

                    foreach($utype as $t){

                        echo "<option value='".$t."'>".$t."</option>";

                    }

                ?>                        

            </select>

        </div>

        <hr>

        <h4> Profil Saat Pelatihan</h4>

        <div class="form-group">

            <label for="asisten">Jenis Asisten</label>

            <select name="asisten" class="form-control " id="asisten">

                <?php 

                    $jasisten=jasisten();

                    foreach($jasisten as $j){

                        echo "<option value='".$j."'>".$j."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="komoditas">Komoditas</label>

            <select name="komoditas" class="form-control">

            <?php 

                $jkomo=jkomoditas();

                    foreach($jkomo as $c){

                        echo "<option value='".$c."'>".ucfirst($c)."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="jabatan">Jabatan</label>

            <input type="text" name="jabatan" id="jabatan" class="form-control">

        </div>

        <div class="form-group">

            <label for="bagian">Bagian</label>

            <input type="text" name="bagian" id="bagian" class="form-control">

        </div>

        <div class="form-group">

            <label for="aktif">Aktif</label>

            <select name="aktif" class="form-control aktif" id="aktif">

                    <option value='1'>Aktif</option>

                    <option value='0'>Non Aktif</option>

            </select>

            <input type="hidden" name="id" id="edui">

        </div>

        <hr>

        <h4> Profil Paska Pelatihan</h4>

        <div class="form-group">

            <label for="asisten">Jenis Asisten</label>

            <select name="asisten" class="form-control " id="asisten">

                <?php 

                    $jasisten=jasisten();

                    foreach($jasisten as $j){

                        echo "<option value='".$j."'>".$j."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="komoditas">Komoditas</label>

            <select name="komoditas" class="form-control">

            <?php 

                $jkomo=jkomoditas();

                    foreach($jkomo as $c){

                        echo "<option value='".$c."'>".ucfirst($c)."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="jabatan">Jabatan</label>

            <input type="text" name="jabatan" id="jabatan" class="form-control">

        </div>

        <div class="form-group">

            <label for="bagian">Bagian</label>

            <input type="text" name="bagian" id="bagian" class="form-control">

        </div>

        <hr>

        <h4> Profil Paska Pelatihan</h4>

        <div class="form-group">

            <label for="asistenpaska">Jenis Asisten Paska Apel Siaga</label>

            <select name="asistenpaska" class="form-control" id="asistenpaska">

                <?php 

                    $jasisten=jasisten();

                    foreach($jasisten as $j){

                        echo "<option value='".$j."'>".$j."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="komoditaspaska">Komoditas Paska Apel Siaga</label>

            <select name="komoditaspaska" class="form-control">

            <?php 

                $jkomo=jkomoditas();

                    foreach($jkomo as $c){

                        echo "<option value='".$c."'>".ucfirst($c)."</option>";

                    }

                ?>

            </select>

        </div>

        <div class="form-group">

            <label for="jabatanpaska">Jabatan Paska Apel Siaga</label>

            <input type="text" name="jabatanpaska" id="jabatanpaska" class="form-control">

        </div>

        <div class="form-group">

            <label for="bagianpaska">Bagian Paska Apel Siaga</label>

            <input type="text" name="bagianpaska" id="bagianpaska" class="form-control">

        </div>

       

        <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

       

      

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-window-close text-white-50"></i> Batal</button>

        <input type="submit" value="simpan" class="btn btn-primary">

      </div>

      </form>

    </div>

  </div>

</div>



<!-- END ADD PESERTA -->



<!-- / .MODAL --> 

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

 <script src="<?=base_url('assets/')?>js/papaparse.min.js"></script>



 

<script>

    $(document).ready(function() {

       

        $('#tbpeserta').DataTable({

        dom: 'Bfrtip',

        buttons: [

            'copy', 'csv', 'excel', 'pdf', 'print'

        ]

    });



        $('#filedata').on('change', function(event){

            var files = $(this)[0].files;

            var len = $(this).get(0).files.length;

            var ext = files[0].name.split('.').pop().toLowerCase();

            if(ext != "csv"){

                $('.alertinput').removeAttr('hidden');

                $('.msg').attr('hidden',true);

                $('#btadd').attr('disabled',true);

            }else{

                var dataparse=$('input[type=file]').parse({

                    config: {

                        delimiter: ";",

                        complete: function(results){

                        var data=results;

                        displayHTMLTable(data)

                        },//displayHTMLTable(results),

                        header:true,

                        skipEmptyLines: true,



                    },

                    before: function(file, inputElem)

                    {

                        $('#wait').removeAttr('hidden');

                    },

                   

                    error: function(err, file)

                    {

                        alert("ERROR:", err, file);

                    },

                    complete: function()

                    {

                        $('#wait').attr('hidden',true);

                    }

                });

                $('.msg').removeAttr('hidden');

                $('.alertinput').attr('hidden',true);

                $('#btadd').removeAttr('disabled');

            }



        }) 



        $('#btadd').on('click', function(event){

          

            var editurl=base_url + 'importpeserta';

            var datax=tabletoarray();

            var company=$('#perusahaan').val();

            // CSRF Hash

			 var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']

          	 var csrfHash = $('.txt_csrfname').val(); // CSRF hash

            $.ajax({

                url  : editurl,

                type : 'POST',

                data : {datax, company : company, [csrfName]: csrfHash},

                dataType: 'json',

                beforeSend:function(){

                    $("#wait").removeAttr("hidden");

                },

				success: function(result){

                    $("#wait").attr("hidden");

					//console.log(result);

                   location.reload();

				}

           }) 

        })



        $('#badd').on('click',function(){

            $('#maddpeserta').modal('show');

        })



      



        function displayHTMLTable(results){

            $('#result').removeAttr('hidden');

         //   var table = "  <hr><h5>Data Result</h5><div class='table-responsive'><table id='tbresult' class='table table-bordered'>";

            var dtparse=results.data;

         // EXTRACT VALUE FOR HTML HEADER 

            const header = Object.keys(dtparse[0]);         

        // CREATE DYNAMIC TABLE.

            const table = document.createElement("table");

            table.setAttribute("class", "table table-bordered");

            table.setAttribute("id", "tbresult");

        // CREATE HTML TABLE HEADER ROW USING THE EXTRACTED HEADERS ABOVE.

            let tr = table.insertRow(-1);                   // TABLE ROW.

            for (let i = 0; i < header.length; i++) {

                const th = document.createElement("th");      // TABLE HEADER.

                th.innerHTML = header[i];

                tr.appendChild(th);

            }



            // ADD JSON DATA TO THE TABLE AS ROWS.

            for (let i = 0; i < dtparse.length; i++) {



            tr = table.insertRow(-1);



                for (let j = 0; j < header.length; j++) {

                    let tabCell = tr.insertCell(-1); 

                    tabCell.innerHTML = dtparse[i][header[j]];

                }

            }

          //  table +="</table></div>";

            const divContainer = document.getElementById("resultparse");

            divContainer.appendChild(table);

        }



        $('.editbt').on('click',function(){

            var idus=$(this).data('ed');

            searchpeserta(idus);

        })



        $('#btedit').on('click',function(){

            var editurl=base_url + 'editpeserta';

            var dataed=$('#fedit').serializeArray();

            $.ajax({

                url  : editurl,

                type : 'POST',

                data : dataed,

                dataType: 'json',

				success: function(result){

                  if(result.res == "ok"){

                        location.reload();

                    }else{

                        location.reload();

                    }

				}

           })

        })



        function readtable(){

            var convertedIntoArray = [];

            var dtlength=0;

            $("table#tbresult tr").each(function() {

                    var rowDataArray = [];

                    var actualData = $(this).find('td');

                    dtlength=actualData.length;

                    if (dtlength > 0) {

                        actualData.each(function() {

                            rowDataArray.push($(this).text());

                        });

                        convertedIntoArray.push(rowDataArray);

                    }

            });

            return dtlength;

        }





        function tabletoarray(){

            var rows = [].slice.call($('#tbresult')[0].rows)



            var keys = [].map.call(rows.shift().cells, function(e) {

            return e.textContent.replace(/\s/g, '')

            })



            var result = rows.map(function(row) {

            return [].reduce.call(row.cells, function(o, e, i) {

                o[keys[i]] = e.textContent

                return o 

            }, {})

            })



           return result

        }



        function searchpeserta(idus){

            var urledit=base_url + '/searchpeserta';

            $.ajax({

				url: urledit,

                data: { idus : idus},

                type: 'get',

                success: function(result) {

                    console.log(result);

                   var res=JSON.parse(result);

                    $('#editnopeg').val(res.uname);

                    $('#editnama').val(res.nama);

                    $('#editperusahaan').val(res.idcomp);

                    $('#editbagian').val(res.bagian);

                    $('#editjabatan').val(res.jabatan);

                    $('#editstatus').val(res.status);

                    $('#editaktif').val(res.isaktif);

                    $('#edui').val(res.id);

                    

                }

            })

        }



    });

</script>

<script>

    $('.alert').fadeIn();     

  setTimeout(function() {

       $(".alert").fadeOut();           

  },5000);

</script>