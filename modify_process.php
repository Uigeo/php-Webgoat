<?php

header("Progma:no-cache");
header("Cache-Control:no-cache,must-revalidate");
require_once("dbconfig.php");


if (strlen(str_replace(" ","",$_POST["title"]))!=0) {

  $query = "UPDATE content SET title='{$title}', content='{$content}', writer='{$writer}', write_date=NOW() WHERE id={$id}";
  $stmt = $conn->prepare("UPDATE content SET title=?, content=?, writer=?, write_date=NOW() WHERE id=?");
  $stmt->bind_param("sssi", $title,  $content, $writer,$id);

  $id = (int)htmlspecialchars($_POST['id']);
  $title = htmlspecialchars($_POST['title']);
  $content = htmlspecialchars($_POST['content']);
  $writer = htmlspecialchars($_POST['writer']);

  $stmt->execute();

  $stmt->close();
  $conn->close();

}

header("Location: detail.php?id={$id}");


?>
