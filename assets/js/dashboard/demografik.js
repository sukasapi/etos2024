$(document).ready(function() {
  var par1=$("#batch").val();
  var par2=$("#entitas").val();
  var par3='semua';
  var myChart;


  var dataawal=datagraph(par1,par2,par3);
  updategrafik(dataawal);

  $("#search").on("click", function(){
    par1=$('#kategori').val();
    par2 = $("#entitas").val();
    par3 = $("#batch").val();
    var data=datagraph(par1,par2,par3);
    updategrafik(data);
})




function updategrafik(datablok){
  const labels = datablok.label;
  const data = {
    labels: labels,
    datasets: [
      {
        label: 'ETOS KERJA',
        data: datablok.data['etos'],
        backgroundColor:'#33d9b2'
      },
      {
        label: 'TRADISI',
        data: datablok.data['tradisi'],
        backgroundColor:'#ffb142',
      },
      {
        label: 'TRI TERTIB',
        data: datablok.data['tritertib'],
        backgroundColor:'#b33939',
      },
      {
        label: 'ATRIBUT',
        data: datablok.data['atribut'],
        backgroundColor:'#706fd3',
      },
      {
        label: 'KINERJA',
        data: datablok.data['kinerja'],
        backgroundColor:'#227093',
      }
    ]
  };
  
  var ctx = document.getElementById("NPS").getContext('2d');

  if(myChart){
    myChart.destroy();
  }

    myChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: {
        plugins: {
          datalabels: {
            display: true
          }
        },
        responsive: true,
        scales: {
          xAxes: [{ stacked: true }],
          yAxes: [{ stacked: true }]
        }
      }
    });
    
    myChart.update();
  


  
}
 

 

 
    function datagraph(par1,par2,par3){
     // var konten=$("#konten").val();
      var urlget=base_url + 'API/demografik';
      var j;
      $.ajax({
          url: urlget,
          data: {kategori:par1,entitas:par2,batch:par3},
          type: 'get',
          async:false, 
          beforeSend: function(){ 
            $('#loading').modal('show');
          },
          success: function(result) {
            $('#loading').modal('hide');
              j=JSON.parse(result);   
          },
          complete: function(){
           
          },
      })
    //console.log(j)
      return j;
    }
    /*
 */
   

    function formatValue(val, context) {
      //console.log('Column Chart', val);
      return val.toFixed(2);
    }
})