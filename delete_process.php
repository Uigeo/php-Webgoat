<?php

  header("Progma:no-cache");
  header("Cache-Control:no-cache,must-revalidate");
  require_once("dbconfig.php");
  $id = $_GET["id"];

  $query = "DELETE FROM content WHERE id= {$id}";

  if(mysqli_query($conn, $query)){
    echo "Record delete successfully";
    header("Location: list.php");
  } else{
    echo "Error deleteing record: " . mysqli_error($conn);
  }



 ?>
