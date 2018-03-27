<?php
  require_once("dbconfig.php");
  $id = $_GET["id"];
  $query = "SELECT * FROM content WHERE id={$id}";
  if($result = mysqli_query($conn, $query)){
    //echo "Record select successfully";
    $row = mysqli_fetch_array($result);
  }else{
    echo "Error deleteing record: " . mysqli_error($conn);
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="write.css">
    <title>21300267-문의거</title>
  </head>
  <body>
    <div class="container">
      <form class="form-horizontal" action="modify_process.php" method="post">
        <div class="form-group">
          <label class="col-md-2 control-label">Title</label>
          <div class="col-md-10">
            <input class="form-control" type="text" name="title" placeholder="Enter the title" value=<?="\"{$row['title']}\""?> >
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Writer</label>
          <div class="col-md-10">
            <input class="form-control" type="text" name="writer" placeholder="Enter within 30 characters." value=<?="\"{$row['writer']}\""?>  >
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-2 control-label">Content</label>
          <div class="col-md-10">
            <textarea class="form-control" name="content" rows="10" placeholder="Enter the content"><?="{$row['content']}"?></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-2 col-md-10">
            <input type="text" hidden name="id" value=<?="\"{$row['id']}\""?> >
            <button class="btn btn-default" type="submit">modify</button>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
