<div class="container-fluid">
     <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <input type="hidden" id="stateval" value="<?=$evaluasi[0]->status?>">
                <div class="col-6">
                <h1 class="h3 mb-2 text-gray-800">Lembar Penilaian <?=$evaluasi[0]->namajenis?></h1>
                </div>
        </div>

         <!---- Panduan Pengerjaan -->
         <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#info" class="d-block card-header bg-info py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-white">INFORMASI</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="info" >
                    <div class="card-body">
                        <p>Kami mohon partisipasi Anda untuk melakukan penilaian <?=$evaluasi[0]->namajenis?>. Penilaian <?=$evaluasi[0]->namajenis?> yang Anda lakukan menggambarkan persepsi Anda terhadap kesesuaian tata nilai <?=$evaluasi[0]->namajenis?> dari objek penilaian.
                    <hr/>
                    Penilaian ini menggunakan metode <?=$evaluasi[0]->tipe_nilai?></p>
                     </div>
                </div>
            </div>
        </div>
        <!---- End Panduan Pengerjaan -->
       
         <!---- Panduan Pengerjaan -->
         <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#petunjuk" class="d-block card-header bg-primary py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-white">PANDUAN PENGISIAN</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse" id="petunjuk" >
                    <div class="card-body">
                        <table class="table table-bordered mb-3">
                           <tbody>
                                <tr>
                                    <td style="width:20%" class="nilai_pengukuran_pr">Formula P</td>
                                    <td class="nilai_pengukuran_pr">(realisasi /target)*100%</td>
                                </tr>
                                <tr>
                                    <td class="nilai_pengukuran_pa">Formula M</td>
                                    <td class="nilai_pengukuran_pa"><p>Y = 480 - 4 ( x )</p><p>*x = (realisasi / target) x 100</p></td>
                                </tr>
                                <tr> 
                                    <td class="nilai_pengukuran_de">0-1</td>
                                    <td class="nilai_pengukuran_de">tercapai 100%</td>
                                </tr>
                            </tbody>
                         </table>
                     </div>
                </div>
            </div>
        </div>
        <!---- End Panduan Pengerjaan -->
        
        
        <!---- DAFTAR KINERJA --> 
        <div class="col-md-12 col-sm-12">
            <div class="card shadow mb-4">
  <!-- Card Header - Accordion -->
                <a href="#daftarkinerja" class="d-block card-header bg-primary py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-white">Pengambilan data</h6>
                </a>
                <div class="collapse show" id="daftarkinerja" >
                    <div class="card-body">
                        <h5 class="mb-4">*Pilih terlebih dahulu tanggal dan tahun pengambilan data kinerja </h5>
                        <form action="<?=base_url('kinerjaperiode')?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="token" value="<?=$this->encryption->encrypt($evaluasi[0]->id)?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="bulan">Bulan Pengambilan Kinerja</label>
                                    <select name="bulan" class="form-control" id="bulan">
                                        <option selected readonly >- Pilih bulan periode pengambilan kinerja -</option>
                                    <?php 
                                            foreach(bulanpriode() as $bulan){
                                                echo "<option value='".$bulan."'>".$bulan."</option>";
                                            }
                                        ?>
                                    </select> 
                                </div>
                                <div class="col-md-6">
                                    <label for="bulan">Tahun Pengambilan Kinerja</label>
                                    <select name="tahun" class="form-control" id="tahun">
                                        <option selected readonly >- Pilih tahun periode pengambilan kinerja -</option>
                                        <option value='2021' >2021</option>
                                        <option value='2022' >2022</option>
                                    </select> 
                                </div>
                            </div>
                            <div class="row py-3">
                            <div class="col-md-12">
                                <input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <input type="submit" value="Mulai Pengambilan Nilai" class="btn btn-success btn-block">
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
        <!---- END DAFTAR KINERJA -->

</div>
 <!-- Page level plugins -->
 <script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
     $(document).ready(function() {
        $('#tbdkinerja').DataTable();
     })
</script>