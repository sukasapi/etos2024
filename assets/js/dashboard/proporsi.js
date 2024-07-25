$(document).ready(function() {
  updategraph();
 /*
  var par1=$('#kategori').val();
 var par2 = $("#entitas").val();
 var par3 = $("#batch").val();

    // Pie Chart Example
var ctx = $("#pie1");
var get1=getdata(1,par2,par3);
var label1=get1.label;
var data1=get1.proporsi;
var color1=get1.color;
var pie1=new Chart(ctx,dispgraph(label1,data1,color1));

var ctx2 = $("#pie2");
var get2=getdata(2,par2,par3);
var label2=get2.label;
var data2=get2.proporsi;
var color2=get2.color;
var pie2=new Chart(ctx2,dispgraph(label2,data2,color2));

var ctx3 = $("#pie3");
var get3=getdata(3,par2,par3);
var label3=get3.label;
var data3=get3.proporsi;
var color3=get3.color;
var pie3=new Chart(ctx3,dispgraph(label3,data3,color3));

var ctx4 = $("#pie4");
var get4=getdata(4,par2,par3);
var label4=get4.label;
var data4=get4.proporsi;
var color4=get4.color;
var pie4=new Chart(ctx4,dispgraph(label4,data4,color4));

var ctx5 = $("#pie5");
var get5=getdata(5,par2,par3);
var label5=get5.label;
var data5=get5.proporsi;
var color5=get5.color;
var pie5=new Chart(ctx5,dispgraph(label5,data5,color5));
 $("#tab1").html(calcdata(label1,data1,1));
 $("#tab2").html(calcdata(label2,data2,2));
 $("#tab3").html(calcdata(label3,data3,3));
 $("#tab4").html(calcdata(label4,data4,4));
 $("#tab5").html(calcdata(label5,data5,5));
*/

$(document).on('click','#search',function(){
  updategraph();
});



function getdata(type,company,batch){
      var j;
      var urlget=base_url + 'API/proporsi';
      $.ajax({
        url: urlget,
        data: {eval:type,company:company,batch:batch},
        type: 'get',
        async:false,
        success: function(result) {
          j=JSON.parse(result);    
        }
    })
    return j;
  }
 
  function dispgraph(label,data,color,hover){
    var res ={
        type: 'pie',
        data: {
          labels:label,
          datasets: [{
            data: data,
            backgroundColor: color,//['#0071bc', '#2cb34c', '#ffc000','#e63928','#000000'],
            hoverBackgroundColor:hover,
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
          
        plugins: {
          datalabels: {
            display: true,
            align: 'center',
            anchor: 'center'
          }
        },
          legend: {
            display: true,
            position : 'right'
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
             +"<td>" + persen.toFixed(2) + "%</td>"
             +"<td>" + prop[i] + " orang</td>" 
             +"</tr>";
    }
    ret +="</tbody></table>";
    return ret;
  }


  function updategraph(){
    var par1=$('#kategori').val();
    var par2 = $("#entitas").val();
    var par3 = $("#batch").val();
  
    var ctx = $("#pie1");
    get1=getdata(1,par2,par3);
    label1=get1.label;
    data1=get1.proporsi;
    color1=get1.color;
    hover1=get1.hover;
    pie1=new Chart(ctx,dispgraph(label1,data1,color1,hover1));
    pie1.update();
    
    var ctx2 = $("#pie2");
    get2=getdata(2,par2,par3);
    label2=get2.label;
    data2=get1.proporsi;
    color2=get2.color;
    hover2=get2.hover;
    pie2=new Chart(ctx2,dispgraph(label2,data2,color2,hover2));
    pie2.update();
  
    var ctx3= $("#pie3");
    get3=getdata(3,par2,par3);
    label3=get3.label;
    data3=get3.proporsi;
    color3=get3.color;
    hover3=get3.hover;
    pie3=new Chart(ctx3,dispgraph(label3,data3,color3,hover3));
    pie3.update();
  
    var ctx4 = $("#pie4");
    get4=getdata(4,par2,par3);
    label4=get4.label;
    data4=get4.proporsi;
    color4=get4.color;
    hover4=get4.hover;
    pie4=new Chart(ctx4,dispgraph(label4,data4,color4,hover4));
    pie4.update();
   
    var ctx5 = $("#pie5");
    get5=getdata(5,par2,par3);
    label5=get5.label;
    data5=get5.proporsi;
    color5=get5.color;
    hover5=get5.hover;
    pie5=new Chart(ctx5,dispgraph(label5,data5,color5,hover5));
    pie5.update();

    var ctxall = $("#pieall");
    getall=getdata('all',par2,par3);
    labelall=getall.label;
    dataall=getall.proporsi;
    colorall=getall.color;
    hoverall=getall.hover;
    pieall=new Chart(ctxall,dispgraph(labelall,dataall,colorall,hoverall));
    pieall.update();
  
    
    $("#tab1").html(calcdata(label1,data1,1));
    $("#tab2").html(calcdata(label2,data2,2));
    $("#tab3").html(calcdata(label3,data3,3));
    $("#tab4").html(calcdata(label4,data4,4));
    $("#tab5").html(calcdata(label5,data5,5));
    $("#taball").html(calcdata(labelall,dataall,'all'));
  }

  })