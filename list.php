<?php
  require_once("dbconfig.php");
  $page = $_GET["page"];
  if ($page == NULL) {
    $page = 1;
  }else{
    $page = (int)$page;
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="list.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>21300267</title>
  </head>
  <body>

      <div class="container">
        <table class="table table-hover">
          <thead>
            <tr>
              <th id="number">#</th>
              <th id="title">title</th>
              <th id="writer">writer</th>
              <th id="date">date</th>
            </tr>
          </thead>
            <tbody>
              <?php
                $one_page_contents =5;
                $cur_page_contents = $one_page_contents * ($page-1);
                if ($_GET['search'] == NULL) {
                  $query = "SELECT id, title, writer, write_date FROM content LIMIT {$cur_page_contents} , {$one_page_contents}";
                } else{
                    $query = "SELECT id, title, writer, write_date FROM content WHERE {$_GET['pivot']} LIKE '%{$_GET['search']}%' LIMIT {$cur_page_contents} , {$one_page_contents}";
                }

                echo $query;
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_array($result)){

                  echo "<tr>";
                    //echo "<a href = 'detail.php?id={$row["id"]}'";
                    echo "<td>{$row["id"]}</td>";
                    echo "<td>{$row["title"]}</td>";
                    echo "<td>{$row["writer"]}</td>";
                    echo "<td>{$row["write_date"]}</td>";
                    //echo "</a>"
                  echo "</tr>";
                }
              ?>
            </tbody>
        </table>

        <button id="write-btn" type="button" class="btn btn-default" name="write">Write</button>
        <form class="" action="list.php" method="get">
          <select name="pivot">
             <option value="title" selected="selected">title</option>
             <option value="content">content</option>
             <option value="writer">writer</option>
          </select>
          <input type="text" name="search" value="">
          <input type="submit" name="" value="search">
        </form>


        <div class="text-center">
          <ul class="pagination col-md-12">
              <?php
                if ($_GET['search'] == NULL) {
                  $query = "SELECT id FROM content";
                }
                else {
                  $query = "SELECT id FROM content WHERE {$_GET['pivot']} LIKE '%{$_GET['search']}%'";
                }
                $result = mysqli_query($conn, $query);
                $rows = mysqli_num_rows($result);

              if (($rows > $one_page_contents)) {
                if ($page == 1)
                  echo "<li class='disabled'><a href='#'><span>&laquo;</span></a></li>";
                else
                  echo "<li><a href='list.php?page=".($page - 1)."'><span>&laquo;</span></a></li>";
                for ($i = 1; $i <= (int)($rows / $one_page_contents + 1); $i++) {
                  if ($page == $i)
                    echo "<li class='active'><a href='list.php?page={$i}&search={$_GET['search']}&pivot={$_GET['pivot']}'>{$i}</a></li>";
                  else
                    echo "<li><a href='list.php?page={$i}&search={$_GET['search']}&pivot={$_GET['pivot']}'>{$i}</a></li>";
                }
                if ($page == (int)($rows / $one_page_contents + 1))
                  echo "<li class='disabled'><a href='#'><span>&raquo;</span></a></li>";
                else
                  echo "<li><a href='list.php?page=".($page + 1)."'><span>&raquo;</span></a></li>";
                }
              ?>
          </ul>
        </div>
      </div>
      <script>
        $(function(){
          $("table > tbody > tr").click(function(){
            var id = $(this).find("td").eq(0).text();
            var url = "detail.php?id=" + id;
            location.href = url;
          })
        });

        $("#write-btn").click(function() {
            location.href = "write.php";
        });

      </script>
  </body>
</html>
