$(document).ready(function() {

  ///color
var grcol=['#c7ecee','#f6e58d','#badc58','#eb4d4b','#7ed6df','#686de0','#535c68','#0fbcf9','#ffa801','#05c46b','#575fcf','#34ace0','#474787','#227093','#ffb142','#58B19F','#F8EFBA','#FD7272','#3B3B98','#B33771','#BDC581','#D6A2E8','#487eb0','#7f8fa6','#e84118','#353b48','#40739e','#9c88ff','#fbc531'];


/**/
var marksCanvas1 = document.getElementById("graph1");
var marksCanvas2 = document.getElementById("graph2");
var marksCanvas3 = document.getElementById("graph3");
var marksCanvas4 = document.getElementById("graph4");

var marksData1 = dispgraph2(datagraph2(1))
var marksData2 = dispgraph2(datagraph2(2))
var marksData3 = dispgraph2(datagraph2(3))
var marksData4 = dispgraph2(datagraph2(4))

var marksDatates=dispgraph2(datagraph2(1));
creategraph(marksData1,marksCanvas1);
creategraph(marksData2,marksCanvas2);
creategraph(marksData3,marksCanvas3);
creategraph(marksData4,marksCanvas4);


function creategraph(Data,kanvas){
    var chartOptions = {
        plugins: {
        title: {
          display: true,
          align: "start",
          text: "NPS Value untuk Evaluasi"
        },
        legend: {
          align: "start"
        }
        },
        scales: {
        r: {
          pointLabels: {
            font: {
              size: 20
            }
          }
        }
        }
        };
        
        var radarChart = new Chart(kanvas, {
        type: "radar",
        data: Data,
        options: chartOptions
        }); 
}
 function datagraph2(eval){

  var dkonten=$("#dkonten").val();
  let urlget="";

  if(dkonten =="NPSbawahan"){
    urlget=base_url + 'Result/datagraphbawahan';
  }else{
    urlget=base_url + 'Result/datagraphindividu2';
  }
  

  var j;
  $.ajax({
      url: urlget,
      data: {eval:eval,dkonten:dkonten},
      type: 'get',
      async:false,
      success: function(result) {
          j=JSON.parse(result);    
      }
  })

  return j;
}

function dispgraph2(data){
  var l = data['labels'].length;
  var disp=[];
  for (var i=0;i < l ; i++){
    disp.push({
      label : data['labels'][i],
      data : data['datasets'][i],
      backgroundColor: grcol[i],
    })
  }


  var res ={
    labels:data['label'],
    datasets: disp
    }
return res;
}


})