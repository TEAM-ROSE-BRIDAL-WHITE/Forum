<?php
include_once('miscFunctions.php');
class logStatus extends dbConn{
    public function __construct(){
        parent::connect();
    }
    private function status(){
        if(isset($_SESSION['user'])):
            ?>
            <div class="col-sm-1 col-sm-offset-5">
                <?php
                echo '<div class="logHolder">Привет! ';
                ?>
                <strong>
                <?php
                $this->sayUserName($_SESSION['user']);
                ?>
                </strong>
                <a href="user.php?logout">[изход]</a>
                <?php
                ?>
            </div>
            <div class="col-sm-2">
                <form class="navbar-form" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="search" id="srch-term">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        <?php
        else:
            ?>
            <div class="col-sm-1 col-sm-offset-5">
                <a href="Registration.html"><button type="button" class="btn btn-default navbar-btn">Registration</button></a>
            </div>
            <div class="col-sm-1">
                <a href="Login.html"><button type="button" class="btn btn-default navbar-btn">Login</button></a>
            </div>
            <div class="col-sm-2">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search" id="srch-term">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
            <?php
        endif;
    }
    private function sayUserName($user_id){
        $misc=new misc();
        $result=$misc->singleSelection('username', 'users', 'user_id', '=', $user_id);
        echo $result;
    }
    public function sayStatus(){
        $this->status();
    }
}
$logStatus=new logStatus();
$logStatus->sayStatus();
?>