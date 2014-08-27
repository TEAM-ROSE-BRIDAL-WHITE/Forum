$(document).ready(function(){
    $('.addQuestionButton').on('click', function(){
        $('.addQuestion').show();
    });
    $('.addQuestionForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'addQuestion.php',
            type: 'POST',
            data: {
                questionPlease: 1234,
                name: $('.addQuestionField').val(),
                content: $('.addQuestionContent').val(),
                cat_id: $('.addQuestionChooseCategory').val(),
                tags: $('.addTags').val()
            }
        });
        $('.addQuestion input').val('');
        $('.addQuestion textarea').val('');
        $('.addQuestion').hide();
        setTimeout(function(){
            $.ajax({
                url: 'questionsAndCategories.php',
                type: 'GET',
                data: {
                    giveMeQuestions: 1234
                },
                success: function(result){
                    $('.questionsHolder').html(result)
                }
            });
        }, 50);
    });

    $('.addAnswer').on("click", function(){
        $('.addAnswerBody').show();
    });
    $('.addAnswerForm').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            url: 'addAnswer.php',
            data: {
                giveMeAnswers: 1234,
                post_id: $('.postIdHolder').val(),
                content: $('.addAnswerContent').val()
            },
            type: 'GET'
        });
        $('.addAnswerBody').hide();
        $('.addAnswerForm textarea').val('');
        setTimeout(function(){
            $.ajax({
                url: 'dinamiclyShowAnswers.php',
                data: {
                    giveMeAnswers: $('.postIdHolder').val()
                },
                type: 'GET',
                success: function(result){
                    $('.answersHolder').html(result);
                }
            });
            showMeFooter(location.href);
        }, 50);
    });
    $('.closeAnswer').on('click', function(){
        $('.addAnswerBody').hide();
    });
    $('.closeQuestion').on('click', function(){
        $('.addQuestion').hide();
    });
});
function showMeFooter(href){
    var hrefer=href.split('#');
    if(!hrefer[1] || hrefer[1]!='footer'){
        location.href=location.href + '#footer';
    }
}