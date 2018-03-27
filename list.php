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
    <title>21300267-문의거</title>
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

                if ($_GET['num_el']==NULL) {
                  $one_page_contents=10;
                }else{
                  $one_page_contents=$_GET["num_el"];
                }

                $cur_page_contents = $one_page_contents * ($page-1);
                if ($_GET['search'] == NULL) {
                  $stmt = $conn->prepare("SELECT id, title, writer, write_date FROM content WHERE deleted=0 LIMIT {$cur_page_contents} , {$one_page_contents}");

                } else{
                  //$query = "SELECT id, title, writer, write_date FROM content WHERE deleted=0 AND {$_GET['pivot']} LIKE '%{$_GET['search']}%' LIMIT {$cur_page_contents} , {$one_page_contents}";
                  $pivot = htmlspecialchars($_GET['pivot']);
                  $search = htmlspecialchars($_GET['search']);
                  $stmt = $conn->prepare("SELECT id, title, writer, write_date FROM content WHERE deleted=0 AND {$pivot} LIKE '%{$search}%' LIMIT {$cur_page_contents} , {$one_page_contents}");

                }
                //
                //echo $query;
                if (!$stmt->execute()) {
                     echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                }

                $stmt->bind_result($c_id,$c_title,$c_writer,$c_date);
                while($stmt->fetch()){
                  $time = date("m/d/Y g:i A", strtotime($c_date) );
                  echo "<tr>";
                    echo "<td>{$c_id}</td>";
                    echo "<td>{$c_title}</td>";
                    echo "<td>{$c_writer}</td>";
                    echo "<td>{$time}</td>";
                  echo "</tr>";
                }
              ?>
            </tbody>
        </table>

        <button id="backup-btn" type="button" class="btn btn-default" name="backup">backup del</button>
        <button id="write-btn" type="button" class="btn btn-default" name="write">Write</button>
        <form class="col-md-10" id="form-search" action="list.php" method="get" onsubmit="">
          <div class="form-row">
            <div class="form-group col-md-2">
              <select id='sel-pivot' name="pivot" class="form-control">
                 <option value="title">title</option>
                 <option value="content">content</option>
                 <option value="writer">writer</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <input type="text" id='text-search' name="search" value="<?=$_GET['search']?>" class="form-control">
            </div>
            <div class="form-group col-md-2">
              <input type="submit" id="btn-search" value="search" class="btn btn-default">
            </div>
              <div class="form-group col-md-2">
                <select id='sel-el' name="num_el" class="form-control" >
                   <option value=5>5개</option>
                   <option value=10>10개</option>
                   <option value=15>15개</option>
                </select>
              </div>
          </div>
        </form>



        <div class="text-center">
          <ul class="pagination col-md-12">
              <?php

                if ($_GET['search'] == NULL) {
                  $query = "SELECT id FROM content WHERE deleted=0";
                }
                else {
                  $query = "SELECT id FROM content WHERE {$_GET['pivot']} LIKE '%{$_GET['search']}%'";
                }
                $result = mysqli_query($conn, $query);
                $rows = mysqli_num_rows($result);

              if (($rows > $one_page_contents)) {
                //echo $rows;
                if ($page == 1){
                  echo "<li class='disabled'><a href='#'><span>&laquo;</span></a></li>";}
                else{
                  $p_page = $page -1;
                  echo "<li><a href='list.php?page={$p_page}&search={$_GET['search']}&pivot={$_GET['pivot']}&num_el={$one_page_contents}'><span>&laquo;</span></a></li>";
                }
                for ($i = 1; $i <= (int)(($rows-1) / $one_page_contents + 1); $i++) {
                  if ($page == $i)
                    echo "<li class='active'><a href='list.php?page={$i}&search={$_GET['search']}&pivot={$_GET['pivot']}&num_el={$one_page_contents}'>{$i}</a></li>";
                  else
                    echo "<li><a href='list.php?page={$i}&search={$_GET['search']}&pivot={$_GET['pivot']}&num_el={$one_page_contents}'>{$i}</a></li>";
                }
                if ($page == (int)($rows / $one_page_contents + 1)){
                  echo "<li class='disabled'><a href='#'><span>&raquo;</span></a></li>";
                }
                else{
                  $n_page = $page + 1;
                  echo "<li><a href='list.php?page={$n_page}&search={$_GET['search']}&pivot={$_GET['pivot']}&num_el={$one_page_contents}'><span>&raquo;</span></a></li>";
                  }
                }
              ?>
          </ul>
        </div>
        <?php include 'footer.html' ?>
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

        $("#backup-btn").click(function() {
            var backup = confirm('Are you sure you want to delete backup?');
            if (backup) {
              location.href = "backup_process.php";
            }
        });

        $("#form-search").submit(function(e) {
          if(document.getElementById('text-search').value.length < 2){
            alert("You have to type more than 2 characters!");
            e.preventDefault();
          }
        });

        $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
        }

        if(!window.location.href.includes('num_el')){
          document.getElementById('sel-el').selectedIndex=1;
        }else{
          document.getElementById('sel-el').selectedIndex = Number($.urlParam('num_el'))/5-1;
        }

        if(!window.location.href.includes('pivot')){
          document.getElementById('sel-pivot').selectedIndex=0;
        }else if($.urlParam('pivot')=='title'){
          document.getElementById('sel-pivot').selectedIndex = 0;
        }else if($.urlParam('pivot')=='writer'){
          document.getElementById('sel-pivot').selectedIndex = 2;
        }else if($.urlParam('pivot')=='content'){
          document.getElementById('sel-pivot').selectedIndex = 1;
        }

        $('#sel-el').change(function(){
          var url = window.location.href;
          var n_url ="list.php?";
          if(url.includes('page'))n_url = n_url+ 'page='+$.urlParam('page')+'&';
          if(url.includes('pivot'))n_url = n_url + 'pivot='+$.urlParam('pivot')+'&';
          if(url.includes('search'))n_url = n_url + 'search='+$.urlParam('search')+'&';
          n_url = n_url + 'num_el='+ document.getElementById('sel-el').selectedOptions[0].value;
          window.location.href = n_url;
        });


      </script>


  </body>
</html>
