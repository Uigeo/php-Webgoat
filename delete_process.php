<?php
header("Progma:no-cache");
header("Cache-Control:no-cache,must-revalidate");
require_once("dbconfig.php");
$id = $_GET["id"];

$query = "UPDATE content SET deleted=1 WHERE id= {$id}";

if(mysqli_query($conn, $query)){
  echo "Record delete successfully";
  header("Location: list.php");
} else{
  echo "Error deleteing record: " . mysqli_error($conn);
}

?>
