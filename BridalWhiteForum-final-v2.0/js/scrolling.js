function ScrollingConstructor(hiddenFieldClass, itemsClass, PHPFile, searchWord){
    this.searchWord=searchWord;
    this.hiddenField=hiddenFieldClass;
    this.targetClass=itemsClass;
    this.fileName=PHPFile;
    this.articleId='';
    this.pathToScripts='';
    this.step='';
    this.counter=0;
    $(document).ready(function(){
        $(document).on("scroll", function(){
            catchScrolling.setId();
            //catchScrolling.debuger();
            if( ( $('.' + itemsClass + '' + catchScrolling.articleId).offset().top <= ( $(window).scrollTop() + $(window).height() ) ) ) {
                catchScrolling.doScroll();
                catchScrolling.counter+=1;
            }
        });
    });
}
ScrollingConstructor.prototype.setId=function setId(){
    if(this.counter==0){
        this.articleId=document.getElementsByClassName(this.hiddenField)[0].value - 1;
        this.step=parseInt(this.articleId);
    }
    else{
        this.articleId=document.getElementsByClassName(this.hiddenField)[0].value;
    }
};
ScrollingConstructor.prototype.fillHiddenField=function fillHiddenField(){
    var fieldVal=parseInt(document.getElementsByClassName(this.hiddenField)[0].value);
    if(this.counter>0){
        document.getElementsByClassName(this.hiddenField)[0].value=fieldVal + this.step + (this.counter - (this.counter - 1));
    }
    else{
        document.getElementsByClassName(this.hiddenField)[0].value=fieldVal + this.step;
    }
};
ScrollingConstructor.prototype.doScroll=function doScroll(){
    var currentId=catchScrolling.articleId;
    $.ajax({
        url: this.pathToScripts + this.fileName + '.php',
        type: 'GET',
        data: {
            scrolling: this.articleId,
            search: this.searchWord},
        success: function(result){
            $('.' + catchScrolling.targetClass + '' + currentId).after(result);
        }
    });
    this.fillHiddenField();
};
/*ScrollingConstructor.prototype.debuger=function debuger(){
    $('.debugger').css({
        position: 'fixed',
        top: 0,
        left: 0,
        border: '1px solid red',
        width: '300px',
        height: '300px'
    });
    $('.debugger').text(this.counter);

};*/
//var catchScrolling=new ScrollingConstructor('homePageQuestionsPaging', 'homePageArticle', 'scrollingQuestions');
//var catchScrolling=new ScrollingConstructor('questionBodyAnswersPaging', 'answer', 'scrollingAnswers');