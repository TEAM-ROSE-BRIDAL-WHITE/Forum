<?php
include('db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forum</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/jQuery.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/hiddenFieldsFiller.js"></script>
    <script src="js/scrolling.js"></script>
    <?php
    include('scrollHelper.php');
    include('questionsAndCategories.php');
    include('search.php');
    ?>
</head>
<body>
<?php
if(isset($_GET['questionBody'])){
    $answers=new questionBody($_GET['questionBody']);
    $answers->showQuestion();
}
else if(isset($_GET['search'])){
    $search=new search($_GET['search']);
    $search->doSearch();
}
else{
    $posts=new questionsAndCategories();
    $posts->showResults();
}
include('hiddenFields.html');
?>
<div class="debugger"></div>
</body>
</html>
