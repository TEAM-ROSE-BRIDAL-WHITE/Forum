<?php
include_once("db.php");
session_start();
class AddQuestions extends dBconn{
    private function add($name, $content, $id){
        parent::addSomething(
            'posts',
            array('name', 'content', 'user_id', 'timeadded', 'cat_id'),
            array($name, $content, $_SESSION['admin'], time(), $id));
    }
}
?>
