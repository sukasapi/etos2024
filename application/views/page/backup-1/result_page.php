
<div class="container-fluid">
  <input type="hidden" id="dkonten" value="<?=$d_name?>">
     <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="col-6">
              <h1 class="h3 mb-2 text-gray-800">Hasil Penilaian</h1>
            </div>
        </div>
        <div class="row pb-4">
       
        </div>
        <div class="row pb-4">
          <?php 
          $c=0;
          $promoter=0;
          $passive=0;
          $detractor=0;
          
              foreach($jenis as $j){
                
                if($j->tipe_nilai =="NPS"){ 
                  $c++;
                  
                ?>
                  <div class="col-md-6 mb-6  col-sm-12 py-4">
                      <div class="card">
                          <div class="card-header bg-primary text-white text-center"><h6>NPS <?=strtoupper($j->nama)?></h6></div>
                          <div class="card-body">
                            
                              <div id="accordion">
                                  <div class="card">
                                    <div class="card-header" id="headingOne">
                                      <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#cnps<?=$j->id?>" aria-expanded="true" aria-controls="collapseOne">
                                          Nilai <?=$j->nama?>
                                        </button>
                                      </h5>
                                    </div>

                                    <div id="cnps<?=$j->id?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                      <div class="card-body">
                                          <?php
                                            
                                              if(isset($detail[$j->id])){
                                                  $promoter = array_sum($detail[$j->id]['promoter']);
                                                  $passive = array_sum($detail[$j->id]['passive']);
                                                  $detractor = array_sum($detail[$j->id]['detractor']);
                                                  $total=(int)$promoter + (int)$passive + (int)$detractor;
                                                  $ppromoter = ((int)$promoter / $total)*100;
                                                  $ppassive = ((int)$passive / $total)*100;
                                                  $pdetractor = ((int)$detractor / $total)*100;
                                                  $nps =round(calcNPS($promoter,$passive,$detractor),2);
                                                
                                                  echo "<div class='text-center mb-4'><span>Nilai NPS </span> <h4>". $nps." </h4></div>";
                                                  ?>
                                                  <div class="progress">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?=$ppromoter?>%" aria-valuenow="<?=$ppromoter?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?=$ppassive?>%" aria-valuenow="<?=$ppassive?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: <?=$pdetractor?>%" aria-valuenow="<?=$pdetractor?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                  </div>
                                                  <hr>
                                                 <?php
                                                  echo "Komposisi Global: 
                                                  <ul>
                                                  <li> promoter ".$promoter."</li>
                                                  <li> passive ".$passive."</li>
                                                  <li> detractor ".$detractor."</li>
                                                  </ul>
                                                  <hr>";
                                                  
                                                 

                                                 
                                                 ?>
  
                                                  <?php
                                              }else{
                                                $nps=0;
                                                $ppromoter=0;
                                                $ppassive=0;
                                                $pdetractor = 0;
                                                echo "<div class='text-center mb-4'><span>SCORE NPS TOTAL </span> <h4>". $nps."</h4></div>";
                                               
                                                echo "<div class='progress'>
                                                <div class='progress-bar bg-success' role='progressbar' style='width:".$ppromoter."% aria-valuenow=".$ppromoter." aria-valuemin='0' aria-valuemax='100'></div>
                                                <div class='progress-bar bg-warning' role='progressbar' style='width:".$ppassive."% aria-valuenow=".$ppassive." aria-valuemin='0' aria-valuemax='100'></div>
                                                <div class='progress-bar bg-danger' role='progressbar' style='width:".$pdetractor."% aria-valuenow=".$pdetractor." aria-valuemin='0' aria-valuemax='100'></div>
                                                </div>
                                                <p><small><i>belum ada penilaian</i></small></p>

                                              <hr>";
                                              }
                                          ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card">
                                    <div class="card-header" id="headingOne">
                                      <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#cgraph<?=$j->id?>" aria-expanded="true" aria-controls="collapseOne">
                                          Grafik NPS
                                        </button>
                                      </h5>
                                    </div>

                                    <div id="cgraph<?=$j->id?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                      <div class="card-body">
                                        <canvas id="graph<?=$j->id?>" width="200" height="200"></canvas>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="card">
                                    <div class="card-header" id="headingTwo">
                                      <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#cdetail<?=$j->id?>" aria-expanded="false" aria-controls="collapseTwo">
                                         Detail
                                        </button>
                                      </h5>
                                    </div>
                                    <div id="cdetail<?=$j->id?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                      <div class="card-body">
                                        <?php
                                           $ia=0;
                                           echo "<div class='text-center'><strong>Detail Komposisi</strong></div>";
                                           if(isset($detail[$j->id]['teval'])){
                                            foreach($detail[$j->id]['teval'] as $dt){
                                                $ppro=0;
                                                $ppa=0;
                                                $pdetractor = 0;
                                                ?>
                                                  <table class="table table-striped" style="width:100%">
                                                    <tr>
                                                      <td ><?=$detail[$j->id]['objekdinilai'][$ia]?></td>
                                                      <td><button class='text-right btn btn-sm btn-primary btdet' data-nama='"<?=$detail[$j->id]['objekdinilai'][$ia]?>' data-ev='<?=$dt?>'> <?=round($detail[$j->id]['nilai'][$ia],2)?></button></td>
                                                    </tr>
                                                  </table>
                                                <?php
                                             // echo "<p>".$detail[$j->id]['objekdinilai'][$ia] .
                                             // " <button class='text-right btn btn-sm btn-primary btdet' data-nama='".$detail[$j->id]['objekdinilai'][$ia]."' data-ev='".$dt."'> ".round($detail[$j->id]['nilai'][$ia],2)."</button></p>";
                                              $ia++;
                                            }
                                           }else{
                                             echo "Data tidak ditemukan";
                                           }
                                          

                                        ?>
                                      </div>
                                    </div>
                                  </div>
                                  
                             
                                </div>
                          </div>
                      </div>
                  
                  </div>
                <?php
                }else{
                  if($d_name == "NPSindividu"){
                  ?>
                  
                    <div class="col-md-12 mb-12  col-sm-12 py-4">
                      <div class="card">
                          <div class="card-header bg-primary text-white text-center"><h6>KINERJA</h6></div>
                          <div class="card-body"> 
                            <?php
                                $cs=1;
                                if(count((array)$kinerja) > 0){
                                  foreach($kinerja as $k){
                                    $soal=$k->soal;//soaltext($k[]];
                                    $kexp=explode(";",$k->jawaban);
                                   
                                    echo "<div class='text-center'><h5>".$soal."</h5>";
                                    echo "<h4> Score <br> <strong>".$k->nilai."</strong></h4></div>";
                                    echo "<p> target : <strong>".$kexp[0]."</strong></p>";
                                    echo "<p> Realisasi : <strong>".$kexp[1]."</strong></p>";
                                   
                                    $percenr =($kexp[1] / $kexp[0])*100;
                                    $percent =($kexp[0] / $kexp[0])*100;
                                    echo $percenr."/".$percent;
                                    if($percenr > $percent){
                                      $pgr = $percenr-100;
                                      $pgt = 100-$pgr;
                                      echo "<div class='progress bg-dark' style='height: 40px;'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: ".$pgt."%' aria-valuenow='".$pgt."' aria-valuemin='0' aria-valuemax='100'> T: 100  %</div>
                                      <div class='progress-bar bg-danger' role='progressbar' style='width: ".$pgr."%' aria-valuenow='".$pgr."' aria-valuemin='0' aria-valuemax='100'> R: ".$percenr."%</div>
                                      </div>";
                                    }
                                    else{
                                      $pgr = $percenr;
                                      $pgt = 100;
                                      echo "<div class='progress bg-dark' style='height: 40px;'>
                                      <div class='progress-bar bg-success' role='progressbar' style='width: ".$pgr."%' aria-valuenow='".$pgr."' aria-valuemin='0' aria-valuemax='100'> Realisasi: ".$percenr."%</div>
                                      </div>";
                                    }
                                   
                                  
                                    echo "<hr>";
                                    $cs++;
                                  }
                              }else{
                                echo "<p>data kinerja belum ada</p>";
                              }
                            ?>
                          </div>
                      </div>
                    </div>
                <?php
                  }else{
                    ?>
                    <div class="col-md-12 mb-12  col-sm-12 py-4">
                      <div class="card">
                          <div class="card-header bg-primary text-white text-center"><h6>KINERJA</h6></div>
                          <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="tbkinerja">
                                  <thead>
                                    <td>No</td>
                                    <td>Parameter Kinerja</td>
                                    <td>Rumus</td>
                                    <td>Target</td>
                                    <td>Realisasi</td>
                                    <td>Nilai</td>
                                  </thead>
                                  <tbody>

                                      <?php
                                        $ikin=1;
                                        $strkin=""; 
                                        foreach($kinerjadata as $kd){
                                          //print_r($kd);
                                          $rnilai=explode(";",$kd['jawaban']);
                                          $target=$rnilai[0];
                                          $real=$rnilai[1];
                                          switch($kd['rumus']){
                                            case 'P':
                                              $ntemp1=0;
                                              $ntemp=0;
                                              $nilai=((int)$real/(int)$target)*100;
                                            break;
                                            case '0':
                                              $ntemp=((int)$real/(int)$target)*100;
                                              $nilai=$ntemp>100?100:$ntemp;
                                            break;
                                            case 'M':
                                              $ntemp1=((int)$real/(int)$target)*100;
                                              $ntemp=480-(4*$ntemp1);
                                             
                                              $nilai=$ntemp;
                                            break;
                                          }
                                          $strkin.="<tr>";
                                          $strkin.="<td>".$ikin."</td>";
                                          $strkin.="<td>".$kd['parameter']."</td>";
                                          $strkin.="<td>".$kd['rumus']."</td>";
                                          $strkin.="<td>".$target."</td>";
                                          $strkin.="<td>".$real."</td>";
                                          $strkin.="<td>".round($nilai,2)."</td>";
                                          $strkin.="</tr>";
                                          $ikin++;
                                        }
                                        echo $strkin;
                                      ?>
                                      </tbody>
                                </table>
                            </div>
                            
                          </div>
                      </div>
                    </div>
                    <?php
                  }
                }
              }
          ?>
           <input type="hidden" class="jgraph" value="<?=$c?>">
          
            
        </div>
</div>

<div class="modal" id="detNPS" tabindex="-1" role="dialog" aria-labelledby="detail NPS" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Detail Nilai Per Obyek</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="konten"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Page level plugins -->
<script src="<?=base_url('assets/')?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets/vendor/chart.js/Chart.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/npsgraph.js')?>"></script>
<script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>
<script>
  $(document).ready(function() {
    
    $("#tbkinerja").DataTable();
    $('.btdet').on("click",function(){
       var eval=$(this).data('ev');
      $('#detNPS').modal('show');
      var r= getdet(eval);
      // alert(r);
      $('#detNPS').find('.modal-body').html(r);
    })


    function getdet(ev){
     var urldet=base_url + 'API/detailobjekdinilai';
     var disp="";
      $.ajax({
                url: urldet, 
                type: 'get',
                async: false,
                data :{eval:ev},
                success: function(result) {
                   var res=JSON.parse(result);
                  
                   disp +='<div class="text-center">';
                   disp += '<h3>' + res['objek']+"</h3>";
                   disp +='<hr>';
                   disp += '<p>Nilai NPS :<strong>' + res['nilai'].hasil+"</strong></p>";
                   disp += '<p> Promoter :' + res['nilai'].promoter + '</p>';
                   disp += '<p> Passive :' + res['nilai'].passive + '</p>';
                   disp += '<p> Detractor :' + res['nilai'].detractor + '</p>';
                   disp +='</div>'
                   //alert(disp);
                  // $('#detNPS').find('.modal-body').append(disp);
                }
                
            })
            
            return (disp);
    }

  })
</script>