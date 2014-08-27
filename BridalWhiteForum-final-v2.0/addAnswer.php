<?php
include_once('db.php');
session_start();
class AddAnswer extends dbConn{
    protected $regUser;
    public function __construct(){
        parent::connect();
    }
    private function setUser(){
        if(isset($_SESSION['user'])){
            $this->regUser=$_SESSION['user'];
        }
    }
    protected function add($post_id, $content){
        $this->setUser();
        if(is_numeric($this->regUser)){
            parent::addSomething(
                'answers',
                array('post_id', 'timeadded', 'user_id', 'content'),
                array($post_id, time(), $this->regUser, $content)
            );
            $this->updateQuestion($post_id);
        }
    }
    protected function updateQuestion($post_id){
        parent::updateSomething(
            'posts',
            array('lastanswered', 'lastanswer'),
            array($this->regUser, time()),
            array('post_id', '='),
            array($post_id, '=')
        );
    }
    public function doAdd($post_id, $content){
        $this->add($post_id, $content);
    }
}
if(isset($_GET['giveMeAnswers'])){
    $add=new AddAnswer();
    $add->doAdd($_GET['post_id'], $_GET['content']);
}
?>