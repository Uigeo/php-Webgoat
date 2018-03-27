<?php

  header("Progma:no-cache");
  header("Cache-Control:no-cache,must-revalidate");
  require_once("dbconfig.php");


  $query = "DELETE FROM content WHERE deleted=1";

  if(mysqli_query($conn, $query)){
    echo "backup delete successfully";
    header("Location: list.php");
  } else{
    echo "Error deleteing record: " . mysqli_error($conn);
  }

 ?>
