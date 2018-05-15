<?php

header("Progma:no-cache");
header("Cache-Control:no-cache,must-revalidate");
require_once("dbconfig.php");


if (strlen(str_replace(" ","",$_POST["title"]))!=0) {

  $query = "UPDATE content SET title='{$title}', content='{$content}', writer='{$writer}', write_date=NOW() WHERE id={$id}";
  $stmt = $conn->prepare("UPDATE content SET title=?, content=?, writer=?, write_date=NOW() WHERE id=?");
  $stmt->bind_param("sssi", $title,  $content, $writer,$id);

  $id = (int)$_POST['id']; //htmlspecialchars($_POST["something"])
  $title = $_POST['title']; //htmlspecialchars($_POST["something"])
  $content = $_POST['content']; //htmlspecialchars($_POST["something"])
  $writer = $_POST['writer']; //htmlspecialchars($_POST["something"])

  $stmt->execute();
  $stmt->close();
  $conn->close();
}

header("Location: detail.php?id={$id}");


?>
