<!DOCTYPE html>

<html lang="en">



<head>



    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">

    <meta name="author" content="">



	<?php

		 foreach($js as $file){

				echo "\n\t\t"; 

				?><script src="<?php echo $file; ?>"></script><?php

		 } echo "\n\t"; 

?>	

<?php

		

		 foreach($css as $file){ 

		 	echo "\n\t\t"; 

			?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php

		 } echo "\n\t"; 

?>

<?php

		if(!empty($meta)) 

			foreach($meta as $name=>$content){

				echo "\n\t\t"; 

				?><meta name="<?php echo $name; ?>" content="<?php echo is_array($content) ? implode(", ", $content) : $content; ?>" /><?php

		 }

	?>

    <title><?php echo sitename();?></title>



    <!-- Custom fonts for this template-->

    <link href="<?=base_url('assets/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link

        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"

        rel="stylesheet">





    <!-- Custom styles for this template-->

    <link href="<?=base_url('assets/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!---- Script tambahan datatables -->

    <link href="<?=base_url('assets/')?>vendor/datatables/button/buttons.dataTables.min.css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>css/sb-admin-2.min.css" rel="stylesheet">

    <link href="<?=base_url('assets/')?>scss/dual-listbox.scss" rel="stylesheet">

    <script src="<?=base_url('assets/')?>vendor/jquery/jquery.min.js"></script>

   

</head>



<body id="page-top">



    <!-- Page Wrapper -->

    <div id="wrapper">

         <?php $this->load->view('element/sidebar');?>

       



        <!-- Content Wrapper -->

        <div id="content-wrapper" class="d-flex flex-column">

         <div class="content">

         <?php $this->load->view('element/topbar'); ?>



          <?php echo $output?>



       <?php $this->load->view('element/footer'); ?>

         </div>

        </div>

        <!-- End of Content Wrapper -->



    </div>

    <!-- End of Page Wrapper -->



    <!-- Scroll to Top Button-->

    <a class="scroll-to-top rounded" href="#page-top">

        <i class="fas fa-angle-up"></i>

    </a>

<script>

    var base_url ="<?=base_url()?>";

</script>

    <!-- Logout Modal-->

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

        aria-hidden="true">

        <div class="modal-dialog" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">×</span>

                    </button>

                </div>

                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>

                <div class="modal-footer">

                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                    <a class="btn btn-primary" href="login.html">Logout</a>

                </div>

            </div>

        </div>

    </div>



    

  



    
    <?php //$this->load->view('element/jascript');?>
    <script src="<?=base_url('assets/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->

    <script src="<?=base_url('assets/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Script datatables -->

  

    <!-- Custom scripts for all pages-->

    <script src="<?=base_url('assets/')?>js/sb-admin-2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.8.1/prism.min.js"></script>

    <script>

    window.setTimeout(function() {

        $(".alertglobal").fadeTo(300, 0).slideUp(500, function(){

        $(this).remove(); 

        });

    }, 5000);

    </script>
</body>



</html>

