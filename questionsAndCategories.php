<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include_once('db.php');
include_once('miscFunctions.php');
class questionsAndCategories extends dbConn{
    private $questionsPerPage;
    private $arrResultQuestions;
    public function __construct(){
        parent::connect();
    }
    //select from database and return the limit for paging the questions per page
    private function selectLimit(){
        $result=parent::selectSomething('*', 'config');
        $row=mysqli_fetch_object($result);
        $this->questionsPerPage=$row->questionsperpage;
    }
    //select from db the questions in order from new to older
    private function selectQuestions(){
        $this->selectLimit();
        $this->arrResultQuestions=parent::selectSomething('*', 'posts', '', '', '', null, null, null, null, 'lastanswer',
            'desc', $this->questionsPerPage);
    }
    //extract the database results from "selectQuestions()" and use them
    private function extractQuestions(){
        $this->selectQuestions();
        $num=mysqli_num_rows($this->arrResultQuestions);
        for($i=0; $i<$num; $i++):
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
                <span class="homePageQuestionAllAnswers"><?php echo $this->allAnsweres($post_id); ?></span>
            </div>
            <?php
        endif;
    }
    //function which will say us how many answeres are there for current question
    private function allAnsweres($post_id){
        $selectAllAnswers=parent::selectSomething('*', 'answers', 'post_id', '=', $post_id);
        $num=mysqli_num_rows($selectAllAnswers);
        return $num;
    }
    //show the questions and categories
    public function showResults(){
        $this->extractQuestions();
    }
}
class questionBody extends dbConn{
    private $questionId;
    private $arrQuestionInfo;
    private $post_id;
    private $arrAnswers;
    private $limit;
    public function __construct($id){
        parent::connect();
        $this->questionId=$id;
    }
    private function selectQuestion(){
        $this->arrQuestionInfo=parent::selectSomething('*', 'posts', 'post_id', '=', $this->questionId);
    }
    private function extractQuestionInfo(){
        $this->selectQuestion();
        $misc=new misc();
        $row=mysqli_fetch_object($this->arrQuestionInfo);
        $this->incrementVisits($row->visits);
        $fromWho=$misc->singleSelection('username', 'users', 'user_id', '=', $row->user_id);
        $fromCategory=$misc->singleSelection('name', 'categories', 'cat_id', '=', $row->cat_id);
        $tags=$misc->selectSomething('*', 'tags', 'post_id', '=', $row->post_id);
        $this->post_id=$row->post_id;
        ?>
        <article class="questionBody">
            <h3 class="questionBodyHeading"><?php echo $row->name; ?></h3>
            <span class="questionBodyAddFrom"><a href="?user=<?php echo $row->user_id; ?>"><?php echo $fromWho; ?></a></span>
            <span class="questionBodyAddTime"><?php echo date('d.m.Y в H:i', $row->timeadded); ?></span>
            <span class="questionBodyFromCategory"><?php echo $fromCategory; ?></span>
            <?php echo $row->content; ?>
            <span class="questionBodyTags"><?php echo $this->tagExtractor($tags); ?></span>
            <span class="questionBodyAddAnswer"><input type="button" class="addAnswer" value="Отговори" /></span>
        </article>
        <?php
        $this->extractAnswers();
    }
    private function incrementVisits($counter){
        $counter+=1;
        parent::updateSomething(
            'posts',
            array('visits'),
            array($counter),
            array('post_id', '='),
            array($this->questionId, '=')
        );

    }
    private function tagExtractor($arrTags){
        $num=mysqli_num_rows($arrTags);
        $result='';
        for($i=0; $i<$num; $i++){
            $row=mysqli_fetch_object($arrTags);
            $result.=$row->tagname;
            if($i!=$num-1){
                $result.=', ';
            }
        }
        return $result;
    }
    private function selectAllAnswers(){
        $this->selectLimit();
        $this->arrAnswers=parent::selectSomething('*', 'answers', 'post_id', '=', $this->post_id, null, null, null, null, 'timeadded', 'asc', $this->limit);
    }
    //select from database and return the limit for paging the questions per page
    private function selectLimit(){
        $result=parent::selectSomething('*', 'config');
        $row=mysqli_fetch_object($result);
        $this->limit=$row->answersperpage;
    }
    private function extractAnswers(){
        $this->selectAllAnswers();
        $num=mysqli_num_rows($this->arrAnswers);
        if($num > 0):
            $misc=new misc();
            for($i=0; $i<$num; $i++):
                $row=mysqli_fetch_object($this->arrAnswers);
                $fromWho=$misc->singleSelection('username', 'users', 'user_id', '=', $row->user_id);
                ?>
                <article class="questionBodyAnswer answer<?php echo $i; ?>">
                    <h4 class="questionBodyAnswerHeading"><a href="?user=<?php echo $row->user_id; ?>"><?php echo $fromWho; ?></a></h4>
                    <span class="questionBodyAnswerAddTime"><?php echo date('d.m.Y в H:i', $row->timeadded); ?></span>
                    <?php echo $row->content; ?>
                </article>
            <?php
            endfor;
        endif;
    }
    public function showQuestion(){
        $this->extractQuestionInfo();
    }
}
/*if(isset($_GET['questionBody'])){
    $questionBody=new questionBody($_GET['questionBody']);
    $questionBody->showQuestion();
}*/
?>
