

 
 <!-- Main Content -->
 <div id="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
    <div class="card p-3 mt-3"> 
             <h5 class="mt-3 mb-3">Performance score</h5>

               <div class="border p-2 rounded d-flex flex-row align-items-center">

                <div class="p-1 px-4 d-flex bg-primary flex-column align-items-center score rounded">
                    <span class="d-block char text-success">A</span>
                    <span class="text-success">98%</span>
                </div>


                <div class="ml-2 p-3">
                    <h6 class="heading1">PageSpeed Score</h6>
                    <span>The average page speed score is 75%</span> 
                 </div>
               </div>



             <div class="border p-2 rounded d-flex flex-row align-items-center mt-2">
                 <div class="p-1 px-4 d-flex flex-column align-items-center speed rounded">
                      <span class="d-block char text-warning">C</span>
                       <span class="text-warning">72%</span>
            </div>

                  <div class="ml-2 p-4">
                        <h6 class="text">YSlow Score</h6>
                       <span>The average YSlow score is 76%</span>   
                  </div>
                 
             </div>       
              
    </div>
    </div>

 </div>
 <script>
    $('.alert').fadeIn();     
  setTimeout(function() {
       $(".alert").fadeOut();           
  },5000);
</script>