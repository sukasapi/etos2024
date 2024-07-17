 <!-- Sidebar -->

 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">



<!-- Sidebar - Brand -->

<?php 

    if(issuper()){

       $url=base_url('dashboard');

    }else if(isadmin()){

        $url=base_url('admindashboard');

    }else{

        $url=base_url('userdashboard');

    }		

?>

<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=$url?>">

    <div class="sidebar-brand-icon rotate-n-15">

        <i class="fas fa-laugh-wink"></i>

    </div>

    <div class="sidebar-brand-text mx-3"><?=sitename()?></div>

</a>



<!-- Divider -->

<hr class="sidebar-divider my-0">



<!-- Nav Item - Dashboard -->

<li class="nav-item active">

    <a class="nav-link" href="<?=$url?>">

        <i class="fas fa-fw fa-tachometer-alt"></i>

        <span>Dashboard</span></a>

</li>



<!-- Divider -->

<hr class="sidebar-divider">

<?php 



switch($_SESSION['logged_in']['status']){

    case 'superadmin':

        ?>

        <!-- Heading -->

        <div class="sidebar-heading">

            Manajemen

        </div>



        <!-- Nav Item - Pages Collapse Menu -->

        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengguna"

                aria-expanded="true" aria-controls="collapsePengguna">

                <i class="fas fa-fw fa-users"></i>

                <span>Pengguna</span>

            </a>

            <div id="collapsePengguna" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Pengaturan</h6>

                    <a class="collapse-item" href="<?=base_url('perusahaan');?>">Perusahaan</a>

                    <a class="collapse-item" href="<?=base_url('daftar_user')?>">User Pengguna</a>

                    <a class="collapse-item" href="<?=base_url('listpeserta');?>">Peserta</a>

                    <a class="collapse-item" href="<?=base_url('relasi');?>">Relasi</a>

                </div>

            </div>

        </li>

        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKonten"

                aria-expanded="true" aria-controls="collapseTwo">

                <i class="fas fa-fw fa-book"></i>

                <span>Konten</span>

            </a>

            <div id="collapseKonten" class="collapse" aria-labelledby="headingKonten" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Pengaturan</h6>

                    <a class="collapse-item" href="<?=base_url('banksoal')?>">Bank Soal</a>

                </div>



                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Registrasi</h6>

                    <a class="collapse-item" href="<?=base_url('listregis')?>">Registrasi Peserta</a>

                </div>

            </div>

        </li>

        <!-- Divider -->

        <hr class="sidebar-divider">

        <!-- Heading -->

        <div class="sidebar-heading">
            Hasil Penilaian
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('demografik')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Rekapitulasi Nilai</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('nilaievaluasi')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Nilai Evaluasi</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('kalkulasi')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Kalkulasi Data</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('komparasikinerja')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Komparasi Kinerja</span></a>
        </li>
        <!-- -->
         <!-- Divider -->
         <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
           Monitoring Pengisian
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('monitorpengisian')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Monitoring</span></a>
        </li>
<!--
        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('cekpengisianpenilai')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Progress Pengisian Penilai</span></a>

        </li>

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('cekdetailpengisian')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Progress Pengisian Peserta</span></a>

        </li>
    -->
      

<?php
    break;
    case 'admin':

    break;
    case 'admin unit':
        ?>
         <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengguna"
                aria-expanded="true" aria-controls="collapsePengguna">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengguna</span>
            </a>
            <div id="collapsePengguna" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Pengaturan</h6>

                    <a class="collapse-item" href="<?=base_url('daftar_user')?>">User Pengguna</a>

                    <a class="collapse-item" href="<?=base_url('relasi');?>">Relasi</a>

                </div>

            </div>

        </li>
       <!-- <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Hasil Penilaian
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('demografik')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Rekapitulasi Nilai</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('kalkulasi')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Kalkulasi Data</span></a>
        </li>

        -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            Progress Pengisian
        </div>
        <li class="nav-item">
            <a class="nav-link" href="<?=base_url('monitorpengisian')?>">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Monitoring</span></a>
        </li>
<!---
        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('cekpengisianpenilai')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Progress Pengisian Penilai</span></a>

        </li>

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('cekdetailpengisian')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Progress Pengisian Peserta</span></a>

        </li>

    -->



        <?php

            break;

            default:

?>

        <!-- Heading -->

        <div class="sidebar-heading">

                    Evaluasi

        </div>

        <!-- Nav Item - Tables 

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('pilihobyek')?>">

                <i class="fas fa-fw fa-users"></i>

                <span>1. Obyek Penilaian</span></a>

        </li>

        -->

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('userdashboard')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Daftar Evaluasi</span></a>

        </li>

        

        <!-- Heading  

        <div class="sidebar-heading">

            Results

        </div> -->

      

        <!-- Nav Item - Tables

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('result/NPSindividu')?>">

                <i class="fas fa-fw fa-chart-line"></i>

                <span>Evaluasi Individu</span></a>

        </li> --> 

        <?php 

           /* if(count((array)bawahan_list()) > 0){

                ?>

                <li class="nav-item">

                    <a class="nav-link" href="<?=base_url('result')?>">

                        <i class="fas fa-fw fa-chart-line"></i>

                        <span>Evaluasi Bawahan</span></a>

                </li>

                <?php

            }*/

        ?>

       

        

<?php

    break;



}



?>





<!-- Divider -->

<hr class="sidebar-divider">



<div class="sidebar-heading">

   Tools

</div>

<!-- Nav Item - Tables -->

<?php 

    switch ($_SESSION['logged_in']['status']){

        case 'superadmin':



        break;

        case 'admin':



        break;

        case 'admin unit':

        break;

        case 'user':

        ?>

        <li class="nav-item">

            <a class="nav-link" href="<?=base_url('profil')?>">

                <i class="fas fa-fw fa-user"></i>

                <span>Profil</span></a>

        </li>

        <?php

        break;

    }

?>



<li class="nav-item">

    <a class="nav-link" href="<?=base_url('keluar')?>">

        <i class="fas fa-fw fa-sign-out-alt"></i>

        <span>Keluar</span></a>

</li>



<!-- Divider -->

<hr class="sidebar-divider d-none d-md-block">



<!-- Sidebar Toggler (Sidebar) -->

<div class="text-center d-none d-md-inline">

    <button class="rounded-circle border-0" id="sidebarToggle"></button>

</div>





</ul>

<!-- End of Sidebar -->