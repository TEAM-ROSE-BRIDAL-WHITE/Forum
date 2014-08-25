$(document).ready(function(){
    var pathToScripts='';
    $.ajax({
        url: pathToScripts + 'infoForConfig.php',
        type: 'GET',
        data: {
            someInfo: 'questionsperpage'
        },
        success: function(result){
            $('.homePageQuestionsPaging').val(result);
        }
    });
    $.ajax({
        url: pathToScripts + 'infoForConfig.php',
        type: 'GET',
        data: {
            someInfo: 'answersperpage'
        },
        success: function(result){
            $('.questionBodyAnswersPaging').val(result);
        }
    });
});