<!doctype html>
<html>
    <head>
      <title>Research Hub - Author</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/webpage.css">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-16x16.png" sizes="16x16">
      <script src="js/SearchScript.js"></script>
      <script>
        function showByAuth(id, name) {
          document.getElementById('content-title').innerHTML = 'Publications by ' + name;
          showByAuthor(id);
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
      <button hover="dropfunc()" class="dropbtn">Authors</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, LastName, MiddleName, FirstName, Undergraduate from Researchers order by LastName, FirstName;');
        while ($row = $res->fetch_array()) {
          $auth = showNameFull($row['FirstName'], $row['MiddleName'], $row['LastName'], $row['Undergraduate'], '');
          echo '<a href="#'.$row['ID'].'" onclick=\'showByAuth("'.$row['ID'].'","'.$auth.'")\'>'.$auth.'</a>';
        }
        ?>
      </div>

    </div>

    <button class='btn' onclick="window.location.href='addauthor.php'">Add New Author</button><br/>
    <div style='clear:both'></div>

    <div id='content-title'></div>
    <div id='content-results'></div>
  </div>

  <?php include 'search.php'; ?>
  <div style='clear:both'></div>
</body>
</html>
