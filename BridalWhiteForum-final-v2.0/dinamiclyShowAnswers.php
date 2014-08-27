<?php
include_once('db.php');
include_once('miscFunctions.php');
class dinamiclyShowAnswers extends dbConn{
    private $arrAnswers;
    private $limit;
    private $post_id;
    public function __construct($post_id){
        parent::connect();
        $this->post_id=$post_id;
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
            ?>
            <article class="answersHolder">
            <?php
            for($i=0; $i<$num; $i++):
                $row=mysqli_fetch_object($this->arrAnswers);
                $fromWho=$misc->singleSelection('username', 'users', 'user_id', '=', $row->user_id);
                ?>
                <article class="questionBodyAnswer answer<?php echo $i; ?>">
                    <span class="questionBodyAnswerHeading"><span class="glyphicon glyphicon-user"></span>
                        <a href="?user=<?php echo $row->user_id; ?>"><?php echo $fromWho; ?></a></span>
                    <span class="questionBodyAnswerAddTime"><span class="glyphicon glyphicon-time"></span>
                        <?php echo date('d.m.Y в H:i', $row->timeadded); ?></span><br /><br />
                    <?php echo $row->content; ?>
                </article>
            <?php
            endfor;
            ?>
            </article>
            <?php
        endif;
    }
    public function showAnswers(){
        $this->extractAnswers();
    }
}
if(isset($_GET['giveMeAnswers'])){
    $showAnswers=new dinamiclyShowAnswers($_GET['giveMeAnswers']);
    $showAnswers->showAnswers();
}
?>