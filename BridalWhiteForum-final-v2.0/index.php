<?php
session_start();
include('permission.php');
?>
<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="design/style/bootstrap.css" />
        <link rel="stylesheet" href="design/style/style.css" />
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jQuery.js"></script>
        <script src="js/misc.js"></script>
        <script src="js/hiddenFieldsFiller.js"></script>
        <script src="js/scrolling.js"></script>
        <script src="js/adminJS.js"></script>
        <script src="js/loadChanges.js"></script>
        <script src="js/addQuestion.js"></script>
        <?php
        include('scrollHelper.php');
        include('questionsAndCategories.php');
        include('search.php');
        include('addQuestionForm.php');
        ?>
	</head>
	<body>
		<header id="header">
			<div class="row">
				<div class="col-sm-2">
                    <a href="index.php">
					    <img src="design/images/logo_It_Studdents.png" />
                    </a>
				</div>
                <?php include('logRegForm.php'); ?>
		    </div>
		</header>
		<div class="row">
			<div class="col-sm-3">
				<aside>
					<h4>Category</h4>
                    <?php $categories=new selectAllCats(); ?>
	                <ul class="catList">
                        <?php $categories->showCategories(); ?>
	                </ul>
                    <?php
                    if(isset($_SESSION['admin'])){
                        $categories->addCategory();
                    }
                    ?>
				</aside>
			</div>
			<div class="col-sm-9">
				<section>
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
			</div>
		</div>
		<footer id="footer">
            TEAM-ROSE-BRIDAL-WHITE
		</footer>
	</body>
</html>