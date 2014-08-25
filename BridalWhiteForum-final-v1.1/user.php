<?php
include_once("db.php");
session_start();
class regLogMisc{
    //when a user try to register we will alert him in case of short password
    public static function checkPass($pass){
        if(strlen($pass)<6){
            return false;
        }
        return true;
    }
    //when a uset try to register we will alert him in case of wrong email
    public static function checkMail($mail){
        $partsOfMail=explode('@', $mail);
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
}
class Reg extends dbConn{
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
        //get the static class with helping function
        $misc=new regLogMisc();
        if($misc::checkPass($this->password)==false){
            echo 'Паролата ви трябва да е поне 6 символа!';
            return false;
        }
        else if($this->checkPassWords()==false){
            echo 'Паролите не съвпадат!';
            return false;
        }
        else if($misc::checkMail($this->mail)==false){
            echo 'Невалиден имейл!';
            return false;
        }
        else if($this->checkExists('mail')==false){
            echo 'Този имейл вече е зает!';
            return false;
        }
        else if($this->checkExists('username')==false){
            echo 'Потребителското име е заето!';
            return false;
        }
        else if($this->checkUserName()==false){
            echo 'Потребителското име трябва да е поне 3 символа!';
            return false;
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
        echo 'Пренасочваме ви!';
        return true;
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
if(isset($_POST['reg'])){
    $reg=new Reg();
    $reg->doSetCoords($_POST['username'], $_POST['pass1'], $_POST['pass2'], $_POST['mail']);
    $reg->tryReg();
}

class Login extends dbConn{
    private $mail;
    private $password;
    public function __construct(){
        parent::connect();
    }
    public function setVars($mail, $pass){
        $this->mail=$mail;
        $this->password=$pass;
    }
    private function logIn($mail, $pass){
        $misc=new regLogMisc();
        if(!$misc::checkMail($mail)){
            echo "Невалиден имейл";
            return false;
        }
        if(!$misc::checkPass($pass)){
            echo "Тази парола е невалидна";
            return false;
        }
        return true;
    }
    private function checkUser(){
        $mail=$this->mail;
        $pass=md5($this->password);
        if($this->logIn($mail, $pass)===false){
            return false;
        }
        if(mysqli_num_rows($this->isThareAUser($mail, $pass))<1){
            if(mysqli_num_rows($this->isValidMail($mail))>0){
                echo 'неправилна парола';
                return false;
            }
            echo 'няма такъв имейл';
            return false;
        }
        $_SESSION['user']=$this->getUserId($this->isThareAUser($mail, $pass));
        echo 'Пренасочваме ви!';
        return true;
    }
    private function isThareAUser($mail, $pass){
        $isThare=parent::selectSomething('user_id', 'users', 'mail', '=', $mail,
            array('password', '='),
            array($pass, '=')
        );
        return $isThare;
    }
    private function isValidMail($mail){
        $isValidMail=parent::selectSomething('*', 'users', 'mail', '=', $mail);
        return $isValidMail;
    }
    private function getUserId($result){
        $getId=mysqli_fetch_object($result);
        return $getId->user_id;
    }
    public function logOut(){
        session_destroy();
        header('Location: index.php');
    }
    public function doLog(){
        $this->checkUser();
    }
}
$log=new Login();
if(isset($_POST['log'])){
    $log->setVars($_POST['mail'], $_POST['pass']);
    $log->doLog();
}
if(isset($_GET['logout'])){
    $log->logOut();
}
?>