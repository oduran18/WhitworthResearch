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
        function checkSearch(chk, id, arr, btn, lbl) {
          if (chk.checked)
            arr.push(id);
          else
            arr.splice(arr.indexOf(id), 1);

          var suff = (arr.length == 0) ? "" : " (" + arr.length.toString() + ")";
          document.getElementById(btn).innerHTML = lbl + suff;
        }

        var auths = [];
        function checkAuth(chk, id) {
          checkSearch(chk, id, auths, 'btnAuths', 'Researchers');
        }

        var disps = [];
        function checkDisp(chk, id) {
          checkSearch(chk, id, disps, 'btnDisps', 'Disciplines');
        }

        var pubs = [];
        function checkPub(chk, id) {
          checkSearch(chk, id, pubs, 'btnPubs', 'Publications');
        }

        function advsearch() {
          advpubsearch(auths, disps, pubs);
        }
      </script>
  </head>
<body>
  <?php include 'searchdata.php'; ?>

  <?php include 'header.php'; showHeader('Advanced Search'); ?>
  <?php include 'navbar.php'; ?>
  <?php
  function formatSearchItem($item, $id, $func) {
    return '<input type="checkbox" onclick="'.$func.'(this, '.$id.')"/><span>'.$item.'</span><br/>';
  }
  ?>

  <div>
  <div class='content-box'>
    <div class="dropdown">
      <button id='btnAuths' hover="dropfunc()" class="dropbtn">Researchers</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, FirstName, MiddleName, LastName, Undergraduate from Researchers order by LastName, FirstName;');
        while ($row = $res->fetch_array()) {
          echo formatSearchItem(showNameFull($row['FirstName'], $row['MiddleName'], $row['LastName'], $row['Undergraduate'], ''), $row['ID'], 'checkAuth');
        }
        ?>
      </div>
    </div>
    <div class="dropdown">
      <button id='btnDisps' hover="dropfunc()" class="dropbtn">Disciplines</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Discipline order by Name;');
        while ($row = $res->fetch_array()) {
          echo formatSearchItem($row['Name'], $row['ID'], 'checkDisp');
        }
        ?>
      </div>
    </div>
    <div class="dropdown">
      <button id='btnPubs' hover="dropfunc()" class="dropbtn">Publications</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Publication order by Name;');
        while ($row = $res->fetch_array()) {
          echo formatSearchItem($row['Name'], $row['ID'], 'checkPub');
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
