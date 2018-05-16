<?php
  require_once("dbconfig_user.php");
  $email = $_POST["email"];
  $pw = $_POST["pw"];
    $query = "SELECT * FROM users WHERE email='{$email}' AND pw='{$pw}'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
    while( $row = mysqli_fetch_array($result)){
        setrawcookie('email',$row['email'], 0,'/');
        setrawcookie('pw',$row['pw'], 0,'/');
    }
    echo "login successful";
  }else{
    echo " Fail to Login " . mysqli_error($conn);
    header("Location: login.php");
  }

  header("Location: main.php");
?>