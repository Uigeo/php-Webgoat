<?php
  header("Progma:no-cache");
  header("Cache-Control:no-cache,must-revalidate");
  require_once("dbconfig.php");
  $title = $_POST["title"];
  $writer = $_POST["writer"];
  $content = $_POST["content"];
  $query = "INSERT INTO content (title, writer, content)
            VALUES ('".$title."','".$writer."','".$content."')";
  $result = mysqli_query($conn, $query);
  if ($result == FALSE) {
    echo "Failed to insert data into database<br>";
    echo "Error: ".mysqli_error($conn);
  }
  else {
    header("Location: list.php");
  }
?>
