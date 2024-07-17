  <!-- Main Content -->

  <div id="content">

        <!-- Begin Page Content -->

    <div class="container-fluid">

        <!--- SEARCH -->
        <div class="row pt-4 pb-2">

            <div class="col-md-12 col-xs-12">

                <div class="alert alert-info" role="alert">

                     <h5 >Fitur bantuan Pencarian</h5>

                     <p class="card-title">Gunakan fitur ini untuk menampilkan data berdasarkan kategori yang dipilih.</p>

                            

                </div>

                            

                            <hr>

                <button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#filtering" aria-expanded="false" aria-controls="collapseExample">

                    Pilih filter

                </button>

                <div class="collapse" id="filtering">

                    <div class="card ">

                        

                        <div class="card-body">

                            <div class="form-group text-center">

                                <label for="input">Unit Usaha / Entitas:</label>

                                <select  class="form-control" name='entitas' id='entitas' class="form-control">

                                

                                    <?php
                                        if($_SESSION['logged_in']['status']=="admin unit"){
                                          
                                          foreach(sperusahaan(array("id"=>$_SESSION['logged_in']['perusahaan'])) as $p){

                                            echo "<option value='".$p->id."'>".$p->nama."</label>";

                                        }
                                        }else{
                                          echo "<option value='semua'>Semua Entitas</option>";
                                          foreach(perusahaan() as $p){

                                            echo "<option value='".$p->id."'>".$p->nama."</label>";

                                          }
                                        }
                                        



                                    ?>

                                </select>

                            </div>

                            <hr>

                        
<!--                          
                              <div class="form-group text-center">
                                <label for="input">Batch / Angkatan:</label>

                                <select  class="form-control" name='batch' id='batch' class="form-control">
                                    <option value='semua'>Semua</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                    <option value='6'>6</option>
                                    <option value='7'>7</option>
                                    <option value='8'>8</option>
                                    <option value='9'>9</option>
                                    <option value='10'>10</option>
                                </select>
                              </div>
-->
                            <div class="form-group">
                              <label for="input">Batch / Angkatan:</label>
                                    <?php
                                        if(isset($postbatch) && $postbatch !==""){
                                            $batch=$postbatch;
                                        }else{
                                            $batch="semua";
                                        }
                                    ?>
                                    <input type="text" class="form-control" name="batch" id="batch" value="<?=$batch?>">
                                    <small ><i>* Gunakan koma untuk memilih lebih dari satu batch tanpa spasi (1,2,3,dst)</i></small>
                            </div>

           
                          

                            <hr>

                            <div class="form-group text-center" id="pilkategori">

                                <label for="input">Kategori Pilihan:</label>

                                <select class="form-control" name='kategori' id='kategori'>

                                    <option value="perusahaan">Perusahaan (default)</option>

                                    <option value="komoditas">Komoditi</option>

                                    <option value="asisten">Jenis Asisten</option>

                                </select>

                            </div>

                            <div class='text-center'>

                            <button type="button" id='search' class="btn btn-primary btn-lg ">Saring Hasil</button>

                            </div>



                            </div>

                        </div>

                    </div>

            </div>

            

        </div>

        <div class="row pt-4 pb-2">

            <div class="col-md-12 col-lg-12  col-xs-12">

                <div class="card">

                    <div class="card-header bg-primary text-center text-white">

                        <h4>GRAFIK ETOS KERJA</h4>

                    </div>

                    <div class="card-body">

                        <div style="width: 100%;min-height: 40%">

                            <canvas id="NPS"></canvas>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="row pt-4 pb-2">

            <div class="col-md-12 col-lg-12 col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#2980b9">

                        <h6>Proporsi Nilai Keseluruhan</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                     <canvas id="pieall" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="taball"> </div>

                     <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#informasinilai">  Nilai </button>

                   

                    </div>

                </div>

            </div>

        <div class="row pt-4 pb-2">

            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#0fb9b1">

                        <h6>Proporsi Nilai Etos</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                     <canvas id="pie1" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="tab1"> </div>

                     <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#nilaietos">  Nilai Etos</button>

                   

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#0fb9b1">

                        <h6>Proporsi Nilai Tradisi</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                    <canvas id="pie2" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="tab2"> </div>

                     <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nilaitradisi">  Nilai tradisi</button>

                    </div>

                </div>

            </div>

            <hr>

            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#0fb9b1">

                        <h6>Proporsi Nilai Tri Tertib</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                    <canvas id="pie3" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="tab3"> </div>

                     <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nilaitritertib">  Nilai Tri tertib</button>

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#0fb9b1">

                        <h6>Proporsi Nilai Atribut</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                    <canvas id="pie4" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="tab4"> </div>

                     <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nilaiatribut">  Nilai Atribut</button>

                    </div>

                </div>

            </div>

            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-header text-center text-white" style="background-color:#0fb9b1">

                        <h6>Proporsi Nilai Kinerja</h6>

                    </div>

                    <div class="card-body h-100 my-5">

                    <canvas id="pie5" width="200" height="200"></canvas>

                    </div>

                    <div class="card-footer">

                     <div class="table-responsive" id="tab5"> </div>

                     <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nilaikinerja">  Nilai Kinerja</button>

                    </div>

                </div>

            </div>



            <div class="col-md-6 col-lg-6  col-xs-12 py-4 px-2">

                <div class="card">

                    <div class="card-body h-100 my-5 text-center">

                            <a href="<?=base_url('kalkulasi')?>" class="btn btn-primary btn-xl">Detail Perhitungan </a>

                    </div>

                </div>

            </div>

        </div>



    </div>

 </div>





 <div class="modal fade" id="informasinilai" tabindex="-1" role="dialog" aria-labelledby="etos" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="etos">Legend Nilai</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">

            <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Planters Role Model</td>

                <td style="width:30%"><strong>91% - 100%</strong></td>

                <td>Sang Suri Tauladan Planters. Selamat, Anda telah dipandang sebagai sosok Role Model Planters Tangguh. Anda secara aktif telah mempromosikan, menjaga, serta mendorong internalisasi Etos Kerja, Tradisi, Tri-tertib, dan Atribut Planters di linkungan kerja Anda. Anda juga telah membuktikan perwujudan Etos Kerja Planters dalam prestasi kerja gemilang yang Anda milki.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">The Good Planters</td>

                <td style="width:30%"><strong>81-90%</strong></td>

                <td>Planters Yang Baik. Anda adalah seorang planters yang baik. Anda berusaha menjalankan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters sesuai dengan Harapan Perusahaan. Anda juga telah menunjukan kinerja yang baik. Tingkatkan kualitas implementasi Etos Kerja Planters dan ajaklah lingkungan kerja Anda untuk turut menjalankan Etos Kerja Planters.

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">The Mediocore Planters</td>

                <td style="width:30%"><strong>71 - 80%</strong></td>

                <td>Planters Biasa. Anda dipandang sebagai seorang Planters biasa (rata-rata),  Anda memiliki beberapa hal yang perlu diperbaki sehingga Anda dapat menyandang predikat Planters Yang Baik dan Role Model Planters Tangguh. Anda perlu mereview kembali konsistensi Anda didalam mengamalkan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda juga perlu merview hambatan-hambatan didalam mewujudkan prestasi kerja.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">The Distratcted Planters</td>

                <td style="width:30%"><strong>51-70%</strong></td>

                <td>Planters Yang Bimbang. Anda dipandang kurang siap untuk berkomitmen kepada profesi Planters dan PTPN Group. Anda menujukan beberapa perilaku yang tidak sejalan dengan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda mungkin juga belum dapat menunjukan prestasi kerja yang dapat dibanggakan. Carilah mentor Planters Tangguh untuk diri Anda, bulatkan kembali tekad Anda serta raihlah jati diri dan kebanggaan/harga diri seorang Planters.

                </td>

            </tr>

            <tr>

                <td style="background:#000000 !important;color:#FFFFFF !important;">The Dissident</td>

                <td style="width:30%"><strong>-100 - 50%</strong></td>

                <td>Penentang. Anda secara sadar/sengaja menunjukan perilaku-perilaku dan atau mempengaruhi orang lain untuk berperilaku tidak sejalan dengan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda tidak sungkan berkonfrontasi untuk mempertahankan sikap dan perilaku Anda. Komunitas telah menunjukan penolakan terhadap sikap dan perilaku Anda. Segeralah merubah sikap dan perilaku untuk kembali meraih jati diri dan kebanggaan/harga diri seorang Planters.

                </td>

            </tr>

        </table>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="nilaietos" tabindex="-1" role="dialog" aria-labelledby="etos" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="etos">Legend Nilai Etos</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">

            <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Tinggi</td>

                <td style="width:30%"><strong>86% - 100%</strong></td>

                <td>Anda menghidupkan etos kerja planters dengan penuh kesadaran dan komitmen. Teruslah menjadi suri tauladan yang baik bagi rekan dan bawahan Anda.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Cukup</td>

                <td style="width:30%"><strong>66-85%</strong></td>

                <td>Terimakasih atas dukungan Anda untuk turut menghidupkan etos kerja planters. Selaraskan dan perbaiki terus perilaku Anda sesuai dengan 10 etos kerja planters. Jadikan nasihat rekan, atasan, dan bawahan sebagai masukan untuk menjadikan diri Anda Planters Tangguh.

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Rendah</td>

                <td style="width:30%"><strong>46-65%</strong></td>

                <td>Ada beberapa perilaku Anda yang tidak sejalan dengan 10 etos kerja planters, hapuslah perilaku yang tak sesuai tersebut dan konsistenlah didalam mengamalkan 10 etos kerja planters.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Sangat Rendah</td>

                <td style="width:30%"><strong>-100-45%</strong></td>

                <td>
                Berhentilah menunjukan perilaku-perilaku dan mempengaruhi orang lain untuk berperilaku tidak sejalan dengan 10 etos kerja planters. Segeralah perbaiki sikap perilaku Anda sehingga dapat kembali meraih jati diri dan tempat Anda diantara para Planters Tangguh.  
                </td>

            </tr>

        </table>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="nilaitradisi" tabindex="-1" role="dialog" aria-labelledby="tradisi" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="tradisi">Legend Nilai Tradisi</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">

            <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Menjalankan dan menghayati</td>

                <td style="width:30%"><strong>86% - 100%</strong></td>

                <td>Anda telah menjalankan, menghidupkan, serta menginternalisasikan makna filosofis dari pelaksanaan setiap tradisi planters.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Menjalankan</td>

                <td style="width:30%"><strong>66-85%</strong></td>

                <td>
                Anda telah menjalakan tradisi planters, selanjutnya ajaklah rekan dan bawahan Anda untuk turut menghayati makna luhur dibalik pelaksanaan tradisi planters sehingga pelaksanaan tradisi planters bukan hanya sekedar menggugurkan kewajiban atau simbol.
                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Tidak Konsisten Menjalankan</td>

                <td style="width:30%"><strong>46 - 65%</strong></td>

                <td>
                Banyak tradisi planters yang belum berjalan, pelaksanaan yang ada hanya sebatas formalitas, menggugurkan kewajiban atau simbol, belum dapat memaknai tujuan pelaksanaan tradisi planters.
                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Sangat Rendah</td>

                <td style="width:30%">-100-45%</td>

                <td>
                Hampir seluruh tradisi planters belum dijalankan.
                </td>

            </tr>

        </table>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="nilaitritertib" tabindex="-1" role="dialog" aria-labelledby="tritertib" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="tritertib">Legend Nilai Tri Tertib</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">

        <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Tertib</td>

                <td style="width:30%"><strong>86% - 100%</strong></td>

                <td>Anda menunjukan kedisiplinan didalam menerapkan prinsip Tri-tertib didalam pekerjaan.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Cukup Tertib</td>

                <td style="width:30%"><strong>66-85%</strong></td>

                <td>Masih terdapat beberapa pelaksanaan yang perlu disesuaikan dengan prinsip Tri-tertib

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Kurang Tertib</td>

                <td style="width:30%"><strong>46 - 65%</strong></td>

                <td>Banyak pelaksanaan pekerjaan yang belum sesuai dengan prinsip Tri-tertib.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Tidak</td>

                <td style="width:30%">-100-45%</td>

                <td>

                Hampir seluruh/sebagian besar pelaksanaan pekerjaan belum sesuai dengan prinsip Tri-tertib.

                </td>

            </tr>

        </table>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="nilaiatribut" tabindex="-1" role="dialog" aria-labelledby="atribut" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="atribut">Legend Nilai Atribut</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">

        <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Berdisiplin Tinggi</td>

                <td style="width:30%"><strong>86% - 100%</strong></td>

                <td>Anda telah berdisiplin didalam mengenakan setiap atribut planters dengan lengkap dan tertib. Anda menunjukan jati diri, kebanggan dan profesionalitas seorang planters pada atribut yang telah Anda kenakan sesuai dengan ketentuan.

                </td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Cukup Berdisiplin</td>

                <td style="width:30%"><strong>66-85%</strong></td>

                <td>Anda telah berupaya mengenakan setiap atribut planters dengan lengkap dan tertib. Namun masih terdapat beberapa atribut yang belum dikenakan dengan disiplin.

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Berdisiplin Rendah</td>

                <td style="width:30%"><strong>46 - 65%</strong></td>

                <td>Anda memiliki banyak atribut planters yang belum dikenakan sesuai dengan ketentuan.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Berdisiplin Sangat Rendah</td>

                <td style="width:30%">-100-45%</td>

                <td>

                Anda belum menunjukan kedisiplinan didalam mengenakan atribut planters. Adan belum memahami makna jati diri, kebanggaan, dan profesionalitas planters yang tercermin pada atribut planters.

                </td>

            </tr>

        </table>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>

</div>



<div class="modal fade" id="nilaikinerja" tabindex="-1" role="dialog" aria-labelledby="kinerja" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="kinerja">Legend Nilai Kinerja</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      <table style="width:100%" class="table table-sm">
<!--- Update 24 Februari 2023
            <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Planters Role Model</td>

                <td style="width:30%"><strong>91% - 100%</strong></td>

                <td>Sang Suri Tauladan Planters. Selamat, Anda telah dipandang sebagai sosok Role Model Planters Tangguh. Anda secara aktif telah mempromosikan, menjaga, serta mendorong internalisasi Etos Kerja, Tradisi, Tri-tertib, dan Atribut Planters di linkungan kerja Anda. Anda juga telah membuktikan perwujudan Etos Kerja Planters dalam prestasi kerja gemilang yang Anda milki.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Cukup</td>

                <td style="width:30%"><strong>81-90%</strong></td>

                <td>Planters Yang Baik. Anda adalah seorang planters yang baik. Anda berusaha menjalankan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters sesuai dengan Harapan Perusahaan. Anda juga telah menunjukan kinerja yang baik. Tingkatkan kualitas implementasi Etos Kerja Planters dan ajaklah lingkungan kerja Anda untuk turut menjalankan Etos Kerja Planters.

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Sedang</td>

                <td style="width:30%"><strong>71 - 80%</strong></td>

                <td>Planters Biasa. Anda dipandang sebagai seorang Planters biasa (rata-rata),  Anda memiliki beberapa hal yang perlu diperbaki sehingga Anda dapat menyandang predikat Planters Yang Baik dan Role Model Planters Tangguh. Anda perlu mereview kembali konsistensi Anda didalam mengamalkan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda juga perlu merview hambatan-hambatan didalam mewujudkan prestasi kerja.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Rendah</td>

                <td style="width:30%"><strong>51-70%</strong></td>

                <td>Planters Yang Bimbang. Anda dipandang kurang siap untuk berkomitmen kepada profesi Planters dan PTPN Group. Anda menujukan beberapa perilaku yang tidak sejalan dengan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda mungkin juga belum dapat menunjukan prestasi kerja yang dapat dibanggakan. Carilah mentor Planters Tangguh untuk diri Anda, bulatkan kembali tekad Anda serta raihlah jati diri dan kebanggaan/harga diri seorang Planters.

                </td>

            </tr>

            <tr>

                <td style="background:#000000 !important;color:#FFFFFF !important;">Sangat Rendah</td>

                <td style="width:30%"><strong>0 - 50%</strong></td>

                <td>Penentang. Anda secara sadar/sengaja menunjukan perilaku-perilaku dan atau mempengaruhi orang lain untuk berperilaku tidak sejalan dengan Etos Kerja, Tradisi, Tri-tertib, serta Atribut Planters. Anda tidak sungkan berkonfrontasi untuk mempertahankan sikap dan perilaku Anda. Komunitas telah menunjukan penolakan terhadap sikap dan perilaku Anda. Segeralah merubah sikap dan perilaku untuk kembali meraih jati diri dan kebanggaan/harga diri seorang Planters.

                </td>

            </tr>
--->

<!--- Update 12 Juni 2023 -->
            <tr>

                <td style="background:#0071bc !important;color:#FFFFFF !important;">Tinggi</td>

                <td style="width:30%"><strong>91% - 100%</strong></td>

                <td>Anda telah berhasil menunjukkan Kinerja yang baik.</td>

            </tr>

            <tr>

                <td style="background:#2cb34c  !important;color:#FFFFFF !important;">Cukup</td>

                <td style="width:30%"><strong>81-90%</strong></td>

                <td>Anda memiliki beberapa indikator Kinerja yang perlu dioptimalkan pencapaiannya.

                </td>

            </tr>

            <tr>

                <td style="background:#ffc000 !important;color:#000000 !important;">Sedang</td>

                <td style="width:30%"><strong>71 - 80%</strong></td>

                <td>Anda memiliki permasalahan dan hambatan didalam meraih target pada beberapa indikator kinerja.

                </td>

            </tr>

            <tr>

                <td style="background:#e63928  !important;color:#FFFFFF !important;">Rendah</td>

                <td style="width:30%"><strong>51-70%</strong></td>

                <td>Anda memiliki permasalahan dan hambatan yang serius didalam bekerja, deviasi realisasai terhadap target indikator kinerja besar.

                </td>

            </tr>

            <tr>

                <td style="background:#000000 !important;color:#FFFFFF !important;">Sangat Rendah</td>

                <td style="width:30%"><strong>0 - 50%</strong></td>

                <td>Hampir seluruh indikator Kinerja tidak dapat diraih atau banyak indikator kinerja yang memiliki deviasi (antar target dan realisasi) yang tinggi.

                </td>

            </tr>
<!-- --->
        </table>

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>

  </div>

</div>


 <script src="<?=base_url('assets/')?>vendor/chart.js/Chart.min.js"></script>

 <script src="<?=base_url('assets/')?>vendor/chart.js/chartjs-plugin-datalabels.js"></script>

<script src="<?=base_url('assets/js/dashboard/demografik.js')?>"></script>

<script src="<?=base_url('assets/js/dashboard/proporsi.js')?>"></script>

<script>
  
    $(document).ready(function() {

        $("#pilkategori").hide();
        $("#entitas").on("change",function(){
            var entitas=$(this).val();
            if(entitas=='semua'){
                $("#pilkategori").hide();
            }else{
                $("#pilkategori").show();
            }

        })

    })

</script>