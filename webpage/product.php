<!doctype html>
<html>
    <head>
      <title>Research Hub - Product</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/webpage.css">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-16x16.png" sizes="16x16">
      <script src="js/SearchScript.js"></script>
      <script>
        function showByPub(id, name) {
          document.getElementById('content-title').innerHTML = 'Publications in ' + name;
          showByPublication(id);
        }
      </script>
  </head>
<body>
  <?php include 'searchdata.php'; ?>

  <?php include 'header.php'; showHeader('Products'); ?>
  <?php include 'navbar.php'; ?>

  <div>
  <div class='content-box'>
    <div class="dropdown">
      <button hover="dropfunc()" class="dropbtn">Publications</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Publication order by Name;');
        while ($row = $res->fetch_array()) {
          $pub = $row['Name'];
          if (strlen($pub) > 10)
            $pub = substr($pub, 0, 10) . "...";
          echo '<a href="#'.$row['Name'].'" onclick=\'showByPub("'.$row['ID'].'","'.$row['Name'].'")\'>'.$pub.'</a>';
        }
        ?>
      </div>

    </div>

    <button class='btn' onclick="window.location.href='addpublication.php'">Add New Publication</button><br/>
    <div style='clear:both'></div>

    <div id='content-title'></div>
    <div id='content-results'></div>
  </div>

  <?php include 'search.php'; ?>
  <div style='clear:both'></div>
</body>
</html>
