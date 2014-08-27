<?php
include_once('db.php');
class permission extends dbConn{
    private $permission;
    public function __construct(){
        parent::connect();
    }
    private function selectPermission($sess){
        $permission=parent::selectSomething('permission', 'users', 'user_id', '=', $sess);
        $row=mysqli_fetch_object($permission);
        $this->permission=$row->permission;
    }
    private function checkPermission(){
        if(isset($_SESSION['user'])){
            $this->selectPermission($_SESSION['user']);
            if($this->permission > 0){
                $_SESSION['admin']=$_SESSION['user'];
            }
        }
    }
    public function returnPermission(){
        $this->checkPermission();
    }
}
$perm=new permission();
$perm->returnPermission();
?>