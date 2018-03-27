<?php
  require_once("dbconfig.php");
  $id = $_GET["id"];
  $query = "SELECT deleted FROM content WHERE id = {$id}";
  $result = mysqli_query($conn, $query);
  if (!$row = mysqli_fetch_array($result)) {
    echo "<body> <script> alert('Content dose not exited.'); window.location.href = 'list.php';</script> </body>";
  }
  elseif($id == NULL){
    echo "<body> <script> alert('This is not the right access.'); window.location.href = 'list.php'; </script> </body>";
  }
  elseif ($row['deleted']) {
    echo "<body> <script> alert('This content was deleted.'); window.location.href = 'list.php'; </script> </body>";
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>21300267-문의거 </title>
  </head>
  <body>
    <div class="container">
      <?php
        $query = "SELECT title, writer, content FROM content WHERE id = {$id}";

        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_array($result)) {
          echo "<div class='page-header'>";
          echo "<h1><small>Title:</small> ".$row["title"]."</h1>";
          echo "</div>";
          echo "<div class='panel panel-default'>";
          echo "<div class='panel-heading'>Writer: ".$row["writer"]."</div>";
          echo "<div class='panel-body'>".$row["content"]."</div>";
          echo "</div>";
        }
      ?>
      <button class="btn btn-default" id="list-btn" type="button">List</button>
      <button class="btn btn-default" id="delete-btn" type="button">Delete</button>
      <button class="btn btn-default" id="modify-btn" type="button">Modify</button>
      <?php include 'footer.html' ?>
    </div>
    <script>

      $.urlParam = function(name){
      var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
      return results[1] || 0;
      }

      $("#list-btn").click(function() {
        location.href="list.php";
      });
      
      $("#delete-btn").click(function() {
        var check = confirm('Are you sure you want to delete this item?');
        if(check){
          location.href="delete_process.php?id="+ $.urlParam('id');
        }
      });

      $("#modify-btn").click(function() {
        location.href="modify.php?id="+ $.urlParam('id');
      });


    </script>
  </body>
</html>
