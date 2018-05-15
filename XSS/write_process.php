<?php
  header("Progma:no-cache");
  header("Cache-Control:no-cache,must-revalidate");
  require_once("dbconfig.php");

  // if(strlen(trim($_POST["title"]))==0){
  //   header("Location: list.php");
  // }
  if (strlen(str_replace(" ","",$_POST["title"]))!=0) {

    $stmt = $conn->prepare("INSERT INTO content (title, writer, content) VALUES (?,?,?)");
    $stmt->bind_param("sss", $title, $writer, $content);

    $title = $_POST["title"]; // htmlspecialchars($_POST["content"])
    $writer =$_POST["writer"]; //htmlspecialchars($_POST["content"])
    $content = $_POST["content"]; //htmlspecialchars($_POST["content"])

    $stmt->execute();

    //$result = mysqli_query($conn, $query);

    $stmt->close();
    $conn->close();


  }

  header("Location: list.php");
  // $query = "INSERT INTO content (title, writer, content)
  //           VALUES ('".$title."','".$writer."','".$content."')";


?>
