<?php
include_once('db.php');
include('miscFunctions.php');
class scrollingAnswers extends dbConn{
    private $arrAnswers;
    private $post_id;
    private $scrolling;
    private $answersPerPage;
    public function __construct($post_id, $scrolling){
        parent::connect();
        $this->post_id=$post_id;
        $this->scrolling=$scrolling;
    }
    //select from database and return the limit for paging the questions per page
    private function selectLimit(){
        $result=parent::selectSomething('*', 'config');
        $row=mysqli_fetch_object($result);
        $this->answersPerPage=$row->answersperpage;
    }
    private function selectAllAnswers(){
        $this->selectLimit();
        $this->arrAnswers=parent::selectSomething('*', 'answers', 'post_id', '=', $this->post_id, null, null, null, null,
            'answer_id', '', ($this->scrolling + 1).', '.$this->answersPerPage);
    }
    private function extractAnswers(){
        $this->selectAllAnswers();
        $num=mysqli_num_rows($this->arrAnswers);
        if($num > 0):
            $misc=new misc();
            for($i=$this->scrolling + 1; $i<=$this->scrolling + $num; $i++):
                $row=mysqli_fetch_object($this->arrAnswers);
                $fromWho=$misc->singleSelection('username', 'users', 'user_id', '=', $row->user_id);
                ?>
                <article class="questionBodyAnswer answer<?php echo $i; ?>">
                    <span class="questionBodyAnswerHeading"><span class="glyphicon glyphicon-user"></span><a href="?user=<?php echo $row->user_id; ?>"><?php echo $fromWho; ?></a></span>
                    <span class="questionBodyAnswerAddTime"><span class="glyphicon glyphicon-time"></span><?php echo date('d.m.Y в H:i', $row->timeadded); ?></span><br /><br />
                    <?php echo $row->content; ?>
                </article>
                <?php
            endfor;
        endif;
    }
    public function showResults(){
        $this->extractAnswers();
    }
}
if(isset($_GET['scrolling'])){
    $scrollingDown=new scrollingAnswers(17, $_GET['scrolling']);
    $scrollingDown->showResults();
}
?>