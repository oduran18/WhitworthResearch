<!doctype html>
<html>
    <head>
      <title>Research Hub - Advanced Search</title>
      <meta charset="utf-8">
      <link rel="stylesheet" href="css/webpage.css">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-32x32.png" sizes="32x32">
      <link rel="icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-16x16.png" sizes="16x16">
      <script src="js/SearchScript.js"></script>
      <script>
        function advsearch() {
          //document.getElementById('content-title').innerHTML = 'Publications in ' + name;
          //showByDiscipline(id);
        }
      </script>
  </head>
<body>
  <?php include 'searchdata.php'; ?>

  <?php include 'header.php'; showHeader('Advanced Search'); ?>
  <?php include 'navbar.php'; ?>

  <div>
  <div class='content-box'>
    <div class="dropdown">
      <button hover="dropfunc()" class="dropbtn">Researchers</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Researchers order by Name;');
        while ($row = $res->fetch_array()) {
          echo '<input type="checkbox" onclick="checkAuth(this, '.$row['ID'].')"/><span>'.$row['Name'].'</span>';
        }
        ?>
      </div>
    </div>
    <div class="dropdown">
      <button hover="dropfunc()" class="dropbtn">Disciplines</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Discipline order by Name;');
        while ($row = $res->fetch_array()) {
          echo '<input type="checkbox" onclick="checkDisp(this, '.$row['ID'].')"/><span>'.$row['Name'].'</span>';
        }
        ?>
      </div>
    </div>
    <div class="dropdown">
      <button hover="dropfunc()" class="dropbtn">Publications</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Publication order by Name;');
        while ($row = $res->fetch_array()) {
          echo '<input type="checkbox" onclick="checkPub(this, '.$row['ID'].')"/><span>'.$row['Name'].'</span>';
        }
        ?>
      </div>
    </div>

    <button class='btn' onclick="advsearch()">Search</button><br/>
    <div style='clear:both'></div>

    <div id='content-title'></div>
    <div id='content-results'></div>
  </div>

  <?php 
  include 'search.php'; 
  ?>
  <div style='clear:both'></div>
  </div>
</body>
</html>
