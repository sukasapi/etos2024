$(document).ready(function() {

  var company=$('#comp').val();

  var demografi1=$("#demografi1");
  var data1=datagraphNPS(company,"1");

  var demografi2=$("#demografi2");
  var data2=datagraphNPS(company,"2");

  var demografi3=$("#demografi3");
  var data3=datagraphNPS(company,"3");

  var demografi4=$("#demografi4");
  var data4=datagraphNPS(company,"4");

  var data1 = {
    labels: data1.label,
    datasets: [
      {
        label: data1.label,
        data: data1.sumnps,
        borderWidth: 1
      },
   
    ]
  };


  var data2 = {
    labels: data2.label,
    datasets: [
      {
        label: data2.label,
        data: data2.sumnps,
        borderWidth: 1
      },
   
    ]
  };


  var data3 = {
    labels: data3.label,
    datasets: [
      {
        label: data3.label,
        data: data3.sumnps,
        borderWidth: 1
      },
   
    ]
  };


  var data4 = {
    labels: data4.label,
    datasets: [
      {
        label: data4.label,
        data: data4.sumnps,
        borderWidth: 1
      },
   
    ]
  };

  var options = {
    responsive: true,
    title: {
      display: true,
      position: "top",
      text: "Bar Graph",
      fontSize: 18,
      fontColor: "#111"
    },
    legend: {
      display: true,
      position: "bottom",
      labels: {
        fontColor: "#333",
        fontSize: 16
      }
    },
    scales: {
      yAxes: [{
        ticks: {
          min: 0
        }
      }]
    }
  };

   //create Chart class object
   var chart = new Chart(demografi1, {
    type: "bar",
    data: data1,
    options: options
  });

  var chart2 = new Chart(demografi2, {
    type: "bar",
    data: data2,
    options: options
  });

  var chart3= new Chart(demografi3, {
    type: "bar",
    data: data3,
    options: options
  });

  var chart4= new Chart(demografi4, {
    type: "bar",
    data: data4,
    options: options
  });

  


    function datagraphNPS(company,eval){
      var konten=$("#konten").val();
      var urlget=base_url + 'API/npsgraph';
      var j;
      $.ajax({
          url: urlget,
          data: {company:company,je:eval},
          type: 'get',
          async:false,
          success: function(result) {
              j=JSON.parse(result);   
          }
      })
      return j;
    }
   
})