$(document).ready(function() {
  ////Konten ////

  var data = getsurvey();
  window.survey = new Survey.Model(data);
  $("#myContainer").Survey({
    model: survey,
    onComplete: sendDataToServer
  });
  
  function sendDataToServer(survey) {
    var resultAsString = JSON.stringify(survey.data);
    // send the resultAsString to the server
    var editurl=base_url + 'submitevaluasi';
    var project =$('#pro').val();
    var jenis =$('#eval').val();
    var target =$('#target').val();
    var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
    var csrfHash = $('.txt_csrfname').val(); // CSRF hash
    $.ajax({
        url  : editurl,
        type : 'POST',
        data : {evaluasi: survey.data,target:target ,project:project,jenis:jenis,[csrfName]: csrfHash },
        dataType: 'json',
        success: function(result){
            alert(result)
        }
   })
  }
  
  Survey.StylesManager.applyTheme("defaultV2");
  Survey.surveyLocalization.locales[Survey.surveyLocalization.defaultLocale].requiredError = "Pertanyaan harus dijawab dulu";
  survey.showPreviewBeforeComplete = 'showAnsweredQuestions';

  //get data konten
    function getsurvey(){
    var ipro=$('#pro').val();
    var eval=$('#eval').val();
    var urlget=base_url + 'loadsoal';
    var j= $.ajax({
            url: urlget,
            data: {pro:ipro,eval:eval},
            type: 'get',
            async:false,
            success: function(result) {
              
            }
        }).responseText;
    
        return j;
    }
  ///end konten //
  })