$(document).ready(function() {
    
    // Pie Chart Example
var ctx = $("#pie1");
var label1=getdata(1).label;
var data1=getdata(1).proporsi;
var pie1=new Chart(ctx,dispgraph(label1,data1));

var ctx2 = $("#pie2");
var label2=getdata(2).label;
var data2=getdata(2).proporsi;
var pie2=new Chart(ctx2,dispgraph(label2,data2));

var ctx3 = $("#pie3");
var label3=getdata(3).label;
var data3=getdata(3).proporsi;
var pie3=new Chart(ctx3,dispgraph(label3,data3));

var ctx4 = $("#pie4");
var label4=getdata(4).label;
var data4=getdata(4).proporsi;
var pie4=new Chart(ctx4,dispgraph(label4,data4));

$("#tab1").html(calcdata(label1,data1));
$("#tab2").html(calcdata(label2,data2));
$("#tab3").html(calcdata(label3,data3));
$("#tab4").html(calcdata(label4,data4));
  function getdata(type){
      var j;
      var urlget=base_url + 'API/dataproporsi';
      $.ajax({
        url: urlget,
        data: {eval:type},
        type: 'get',
        async:false,
        success: function(result) {
          j=JSON.parse(result);    
        }
    })
    return j;
  }

  function dispgraph(label,data){
    var res ={
        type: 'pie',
        data: {
          labels:label,
          datasets: [{
            data: data,
            backgroundColor: ['#0071bc', '#2cb34c', '#ffc000','#e63928','#000000'],
            hoverBackgroundColor: ['#0076bc', '#2cb64c', '#ffc600','#e63628','#006000'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: true,
            caretPadding: 10,
          },
          legend: {
            display: false,
            position : 'bottom'
          },
          responsive : true,
          cutoutPercentage: 0,
        }
    }
    return res;
  }

 
  function calcdata(label,data){
    var ret="";
    var prop=data;
    var lab=label;
    var total =prop.reduce((a, b) => a + b, 0)
    var color="";

    ret +=" <table class='table '><tbody>";
    for(var i=0; i < prop.length ; i++){
        console.log(lab[i])
        console.log(prop[i])
        var persen = prop[i] == 0 ? 0:(prop[i]/total)*100;
        switch(i) {
            case 0:
                color ="style='background:#0071bc !important;color:#FFFFFF !important;'";
              break;
            case 1:
                color ="style='background:#2cb34c  !important;color:#FFFFFF !important;'";
              break;
              case 2:
                color ="style='background:#ffc000 !important;color:#000000 !important;'";
              break;
              case 3:
                color ="style='background:#e63928  !important;color:#FFFFFF !important;'";
              break;
              case 4:
                color ="style='background:#000000 !important;color:#FFFFFF !important;'";
              break;
            
              // code block
          }
          ret +="<tr " + color +">"
             +"<td>" + lab[i] + "</td>"
             +"<td>" + persen + "%</td>"
             +"<td>" + prop[i] + " orang</td>" 
             +"</tr>";
    }
    ret +="</tbody></table>";
    return ret;
  }

  })