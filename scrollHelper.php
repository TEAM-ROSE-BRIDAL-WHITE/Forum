<?php
if(isset($_GET['questionBody'])):
    ?>
    <script>
        var catchScrolling=new ScrollingConstructor('questionBodyAnswersPaging', 'answer', 'scrollingAnswers');
    </script>
    <?php
elseif(isset($_GET['search'])):
    ?>
    <script>
        var catchScrolling=new ScrollingConstructor('homePageQuestionsPaging', 'homePageArticle', 'scrollingSearch', <?php echo $_GET['search']; ?>);
    </script>
    <?php
else:
    ?>
    <script>
        var catchScrolling=new ScrollingConstructor('homePageQuestionsPaging', 'homePageArticle', 'scrollingQuestions');
    </script>
<?php
endif;
?>
