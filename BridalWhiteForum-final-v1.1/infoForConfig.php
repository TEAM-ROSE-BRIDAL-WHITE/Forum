<?php
include_once('db.php');
class infoForConfig extends dbConn{
    public function __construct(){
        parent::connect();
    }
    private function makeInfo($what){
        $result=parent::selectSomething($what, 'config');
        $row=mysqli_fetch_object($result);
        return $row->$what;
    }
    public function doInfo($what){
        return $this->makeInfo($what);
    }
}
if($_GET){
    $info=new infoForConfig();
    echo $info->doInfo($_GET['someInfo']);
}
?>