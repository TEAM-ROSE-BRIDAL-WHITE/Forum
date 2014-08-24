function ScrollingConstructor(){
    this.articleId='';
    this.pathToScripts='';
    this.step='';
    this.counter=0;
    $(document).ready(function(){
        $(document).on("scroll", function(){
            catchScrolling.setId();
            if( ( $('.homePageArticle' + catchScrolling.articleId).offset().top <= ( $(window).scrollTop() + $(window).height() ) ) ) {
                catchScrolling.doScroll();
                catchScrolling.counter+=1;
            }
        });
    });
}
ScrollingConstructor.prototype.setId=function setId(){
    if(this.counter==0){
        this.articleId=document.getElementsByClassName('homePageQuestionsPaging')[0].value - 1;
    }
    else{
        this.articleId=document.getElementsByClassName('homePageQuestionsPaging')[0].value;
    }
    this.step=this.articleId;
};
ScrollingConstructor.prototype.fillHiddenField=function fillHiddenField(){
    var fieldVal=parseInt(document.getElementsByClassName('homePageQuestionsPaging')[0].value);
    document.getElementsByClassName('homePageQuestionsPaging')[0].value=fieldVal + this.step;
};
ScrollingConstructor.prototype.doScroll=function doScroll(){
    var currentId=catchScrolling.articleId;
    $.ajax({
        url: this.pathToScripts + 'scrollingQuestions.php',
        type: 'GET',
        data: {scrolling: this.articleId},
        success: function(result){
            $('.homePageArticle' + currentId).after(result);
        }
    });
    catchScrolling.fillHiddenField();
};
var catchScrolling=new ScrollingConstructor();
