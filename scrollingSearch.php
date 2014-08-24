<?php
include_once('db.php');
include_once('miscFunctions.php');
class scrollingSearch extends dbConn{
    private $word;
    private $questionsPerPage;
    private $arrResultQuestions;
    public function __construct($word){
        parent::connect();
        $this->word=$word;
    }

    //select from database and return the limit for paging the questions per page
    private function selectLimit(){
        $result=parent::selectSomething('*', 'config');
        $row=mysqli_fetch_object($result);
        $this->questionsPerPage=$row->questionsperpage;
    }
    //if we scrolling down we will select database results with this function
    private function selectScrollingQuestions(){
        $this->selectLimit();
        $this->arrResultQuestions=mysqli_query($this->db, 'select * from posts where name like "%'.$this->word.'%"
        order by lastanswer desc limit '.($_GET['scrolling'] + 1).', '.$this->questionsPerPage);
    }
    //extract the database results from "selectQuestions()" and use them
    private function extractQuestions(){
        if(isset($_GET['scrolling'])){
            $this->selectScrollingQuestions();
        }
        $num=mysqli_num_rows($this->arrResultQuestions);
        for($i=$_GET['scrolling'] + 1; $i<=$_GET['scrolling'] + $num; $i++):
            $row=mysqli_fetch_object($this->arrResultQuestions);
            $misc=new misc();
            $fromWho=$misc->singleSelection('username', 'users', 'user_id', '=', $row->user_id);
            ?>
            <article class="homePageQuestions homePageArticle<?php echo $i; ?>">
                <h3 class="homePageQuestionHeading"><a href="?questionBody=<?php echo $row->post_id; ?>"><?php echo $row->name; ?></a></h3>
                <span class="homePageQuestionAddFrom"><a href="?user=<?php echo $row->user_id; ?>"><?php echo $fromWho; ?></a></span>
                <span class="homePageQuestionAddTime"><?php echo date('d.m.Y в H:i', $row->timeadded); ?></span>
                <span class="homePageQuestionVisits"><?php echo $row->visits ?></span><br />
                <?php echo $row->content; ?>
                <?php
                $this->showingQuestionsFooter($row->lastanswered, $row->lastanswer, $row->post_id);
                ?>
            </article>
        <?php
        endfor;
    }
    //function that will show which user is last answered the current question, when and how much answers are there
    private function showingQuestionsFooter($lastAnswered, $lastAnswer, $post_id){
        if($lastAnswered!=0):
            ?>
            <div class="homePageQuestionFooter">
                <span class="homePageQuestionLastAnswered"><?php echo $lastAnswered; ?></span>
                <span class="homePageQuestionLastAnswer"><?php echo date('d.m.Y в H:i', $lastAnswer); ?></span>
                <span class="homePageQuestionAllAnswers"><?php echo $this->allAnswers($post_id); ?></span>
            </div>
        <?php
        endif;
    }
    //function which will say us how many answeres are there for current question
    private function allAnswers($post_id){
        $selectAllAnswers=parent::selectSomething('*', 'answers', 'post_id', '=', $post_id);
        $num=mysqli_num_rows($selectAllAnswers);
        return $num;
    }
    //show the questions and categories
    public function doSearch(){
        $this->extractQuestions();
    }
}
if(isset($_GET['search'])){
    $search=new scrollingSearch($_GET['search']);
    $search->doSearch();
}
?>
