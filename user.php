<?php
include_once("db.php");
class reg extends dbConn{
    private $mail;
    private $password;
    private $password2;
    private $username;
    private $currentUserId;
    public function __construct(){
        parent::connect();
    }
    //function which set variables that we will use for register a user
    private function setUserCoords($user, $pass1, $pass2, $mail){
        $this->username=$user;
        $this->password=md5($pass1);
        $this->password2=md5($pass2);
        $this->mail=$mail;
    }
    //try to register someone
    private function checkData(){
        if($this->checkPass()==false){
            return 'Паролата ви трябва да е поне 6 символа!';
        }
        else if($this->checkPassWords()==false){
            return 'Паролите не съвпадат!';
        }
        else if($this->checkMail()==false){
            return 'Невалиден имейл!';
        }
        else if($this->checkExists('mail')==false){
            return 'Този имейл вече е зает!';
        }
        else if($this->checkExists('username')==false){
            return 'Потребителското име е заето!';
        }
        else if($this->checkUserName()==false){
            return 'Потребителското име трябва да е поне 3 символа!';
        }
        else{
            $this->register();
        }
    }
    //do the registration
    private function register(){
        parent::addSomething(
            'users',
            array('username', 'password', 'mail', 'permission'),
            array($this->username, $this->password, $this->mail, 0)
        );
        $this->currentUserId=mysqli_insert_id($this->db);
        $_SESSION['user']=$this->currentUserId;
        //header('Location: index.php');
    }
    //when a user try to register we will alert him in case of short username
    private function checkUserName(){
        if(strlen($this->username)<3){
            return false;
        }
        return true;
    }
    //when a user try to register we will alert him in case of different passwords
    private function checkPassWords(){
        if($this->password!=$this->password2){
            return false;
        }
        return true;
    }
    //when a user try to register we will alert him in case of short password
    private function checkPass(){
        if(strlen($this->password)<6){
            return false;
        }
        return true;
    }
    //when a uset try to register we will alert him in case of wrong email
    private function checkMail(){
        $partsOfMail=explode('@', $this->mail);
        if(!@$partsOfMail[1]){
            return false;
        }
        if(strlen($partsOfMail[0])<3 || strlen($partsOfMail[1])<5){
            return false;
        }
        $secondPartOfMail=explode('.', $partsOfMail[1]);
        if(!$secondPartOfMail[1]){
            return false;
        }
        if(strlen($secondPartOfMail[0])<2 || strlen($secondPartOfMail[1])<2){
            return false;
        }
        return true;
    }
    private function checkExists($what){
        $isExist=parent::selectSomething($what, 'users', $what, '=', $this->$what);
        if(mysqli_num_rows($isExist)>0){
            return false;
        }
        return true;
    }
    public function doSetCoords($user, $pass1, $pass2, $mail){
        $this->setUserCoords($user, $pass1, $pass2, $mail);
    }
    public function tryReg(){
        $this->checkData();
    }
}
?>
