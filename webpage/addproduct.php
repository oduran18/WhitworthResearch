<!doctype html>
<html>
  <head>
    <title>Whitworth Research Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/webpage.css">
    <link rel="shortcut icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-16x16.png" sizes="16x16">
    <script src="js/SearchScript.js"></script>
    <script>
        function checkProd(chk, id, arr, btn, lbl) {
          if (chk.checked)
            arr.push(id);
          else
            arr.splice(arr.indexOf(id), 1);

          var suff = (arr.length == 0) ? "" : " (" + arr.length.toString() + ")";
          document.getElementById(btn).innerHTML = lbl + suff;
        }

        var auths = [];
        function checkAuth(chk, id) {
          checkProd(chk, id, auths, 'btnAuths', 'Researchers');
        }

        var disps = [];
        function checkDisp(chk, id) {
          checkProd(chk, id, disps, 'btnDisps', 'Disciplines');
        }

        var pubs = [];
        function checkPub(chk, id) {
          checkProd(chk, id, pubs, 'btnPubs', 'Publications');
        }

        function submitProd() {
          submitProduct(auths, disps, pubs);
        }

        function submitProduct(authids, discids, pubids, res_div='content-results') {
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {};
          xhttp.open("POST", "addproduct.php", true);
          xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          var title = document.getElementById('title').value;
          var date = document.getElementById('date').value;
          var url = document.getElementById('url').value;
          var awards = document.getElementById('award').value;
          xhttp.send("auths="+JSON.stringify(authids)+"&discs="+JSON.stringify(discids)+"&pubs="+JSON.stringify(pubids)+"&title="+title+"&date="+date+"&url="+url+"&award="+awards);
        }
      </script>
  </head>
<body>
  <?php include 'searchdata.php'; ?>

  <?php include 'header.php'; showHeader('Add Product'); ?>
  <?php include 'navbar.php'; ?>

  <?php
  function formatDropboxItem($item, $id, $func) {
    return '<input type="checkbox" onclick="'.$func.'(this, '.$id.')"/><span>'.$item.'</span><br/>';
  }

  $conn = connect();
    if (isset($_POST['title']))
    {
      $title = $conn->real_escape_string($_POST['title']);
      $url = $conn->real_escape_string($_POST['url']);
      $award = $conn->real_escape_string($_POST['award']);
      $sql = "INSERT INTO Products (Title, URL, Date, Awards) values ('".$title."', '".$url."', '".$_POST['date']."', '".$award."')";
      echo $sql;
      $res = $conn->query($sql);
      $prodid = $conn->insert_id;
      echo $prodid;
      $auths = json_decode($_POST['auths']);
      $disps = json_decode($_POST['discs']);
      $pubs = json_decode($_POST['pubs']);
      for ($i = 0; $i < count($auths); $i++) {
        $sql = 'insert into ProductResearcher (AuthorOrder, ProductID, ResearcherID) values ('.$i.', '.$prodid.', '.$auths[$i].');';
        $conn->query($sql);
      }
      foreach ($disps as $d) {
        $sql = 'insert into ProductDiscipline (DisciplineID, ProductID) values ('.$d.', '.$prodid.');';
        $conn->query($sql);
      }
      foreach ($pubs as $p) {
        $sql = 'insert into ProductPublication (PublicationID, ProductID) values ('.$p.', '.$prodid.');';
        $conn->query($sql);
      }
      echo '<p id="add">added ' . $title . '.<button class="hidebtn" onclick="hideParent(this)">X</button></p>';
    }
  ?>

  <div class='content-box' style='width:90%'>
    <input type='text' id='title' placeholder='Title'>
    <input type='text' id='url' placeholder='URL'>
    <input type='date' id='date' placeholder='Date Published'>
    <input type='text' id='award' placeholder='Awards'><br/>
    <div class='dropdown'>
      <button id='btnAuths' hover="dropfunc()" class="dropbtn">Researchers</button>
      <button class='btn' onclick="window.location.href='addauthor.php'">Add New Author</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $sql = 'select ID, FirstName, MiddleName, LastName, Undergraduate from Researchers order by LastName, FirstName;';
        $res = $conn->query($sql);
        while ($row = $res->fetch_array()) {
          $n = showNameFull($row['FirstName'], $row['MiddleName'], $row['LastName'], $row['Undergraduate'], '');
          echo formatDropboxItem($n, $row['ID'], 'checkAuth');
        }
        ?>
      </div>
    </div>

    <div class='dropdown' style='margin-left:20px;margin-right:20px'>
      <button id='btnPubs' hover="dropfunc()" class="dropbtn">Publication</button>
      <button class='btn' onclick="window.location.href='addpublication.php'">Add New Publication</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $res = $conn->query('select ID, Name from Publication order by Name;');
        while ($row = $res->fetch_array()) {
          echo formatDropboxItem($row['Name'], $row['ID'], 'checkPub');
        }
        ?>
      </div>
    </div>

    <div class='dropdown'>
      <button id='btnDisps' hover="dropfunc()" class="dropbtn">Discipline</button>
      <button class='btn' onclick="window.location.href='adddiscipline.php'">Add New Discipline</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $res = $conn->query('select ID, Name from Discipline order by Name;');
        while ($row = $res->fetch_array()) {
          echo formatDropboxItem($row['Name'], $row['ID'], 'checkDisp');
        }
        ?>
      </div>
    </div>

    <p><button class='btn' onclick="submitProd()">Submit</button></p>
  </div>
</body>
</html>
