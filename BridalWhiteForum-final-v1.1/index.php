<?php
include('db.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design/index/style/bootstrap.css" />
    <link rel="stylesheet" href="design/index/style/style.css" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css" />
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
<header id="header">
    <div class="row">
        <div class="col-sm-2">
            <a href="index.php">
                <img src="design/index/images/logo_It_Studdents.png" />
            </a>
        </div>
        <?php include('logRegForm.php'); ?>
    </div>
</header>
<aside class="col-sm-3">
    <h4>Category</h4>
    <ul>
        <li><a href="#">Money online</a> COUNT?</li>
    </ul>
</aside>
<section class="col-sm-9">
            <h2 class="sectionHeading"><a href="index.php">Make Money Online</a></h2>
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
</section>
<footer class="col-sm-12">
    TEAM-ROSE-BRIDAL-WHITE
</footer>
</body>
</html>
