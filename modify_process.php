<?php

header("Progma:no-cache");
header("Cache-Control:no-cache,must-revalidate");
require_once("dbconfig.php");

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$writer = $_POST['writer'];

$query = "UPDATE content SET title='{$title}', content='{$content}', writer='{$writer}', write_date=NOW() WHERE id={$id}";
echo $query;
if(mysqli_query($conn, $query)){
  echo "Record delete successfully";
  header("Location: detail.php?id={$id}");
} else{
  echo "Error deleteing record: " . mysqli_error($conn);
}

?>
