<?php 
    require_once('dbconfig_user.php');
    $eamil = $_COOKIE['email'];
    $pw = $_COOKIE['pw'];
    $auth = false;
    $auth_query = "SELECT * FROM user WHERE email='{$id}' AND pw='{$pw}'";
    if($result = mysqli_query($conn, $auth_query)){
        $auth = true;
    }else{
        $auth = false;
    }
?>