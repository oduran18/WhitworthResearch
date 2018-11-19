<!doctype html>
<?php
  $server = 'localhost';
  $username = 'webuser';
  $password = 'IodV6WQCNTLo5Isx!';
  $dbname = 'undergrad_research';

  $conn = new mysqli($server, $username, $password, $dbname);
  if ($conn->connect_error) {
      die('error: ' . $conn->connect_error);
  }
?>
<html>
    <head>
            <title>Research Hub - Publish</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="css/webpage.css">
   <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left">Whitworth Research Hub - Publish </h2>
  </div>
  <nav>
      <ul>
          <li><a href="homepage.php">Home</a></li>
          <li><a href="#">Researcher</a>
              <ul>
                  <li><a href="discipline.php">Discipline</a></li>
                  <li><a href="product.php">Product</a></li>
                  <li><a href="category.php">Category</a>
                  </li>
              </ul>
          </li>
          <li><a href="resources.php">Resources</a></li>
          <li><a href="publish.php">Publish</a></li>
      </ul>
  </nav>

  <div class="search">
    <form>
        <?php
            if (isset($_REQUEST['searchitem'])) { $value = " value='".$_REQUEST['searchitem']."'"; }
            else $value = "";
        ?>
        <span id='searchterm'></span>
        <input type='text' id='term' name='searchterm' hidden="term">
        <input type='text' id='searchitem' name='searchitem'<?php echo $value;?>>
        <select name='disciplines' id='disciplines' style='display:none'>
          <option value="" selected disabled hidden>Discipline</option>
        <?php
          $res = $conn->query('select ID, Name from Discipline order by Name');
          while ($res and $row = $res->fetch_assoc()) {
            echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
          }
        ?>
        </select>
        <input type='submit' value='search'>
    </form>
  </div>

  <div class="dropdown">
    <button hover="dropfunc()" class="dropbtn">Search BY</button>
    <div id="dropfilter" class="dropdown-content">
      <a href="#Keyword" onclick="setTerm('Keyword')">Keyword</a>
      <a href="#Title" onclick="setTerm('Title')">Title</a>
      <a href="#Author" onclick="setTerm('Author')">Author</a>
      <a href="#Category" onclick="setTerm('Category')">Category</a>
      <a href="#Discipline" onclick="setTerm('Discipline')">Discipline</a>
    </div>
  </div>

  <br>

  <div style='clear:both'></div>
  <div>
    <br><?php include 'search.php';?>
  </div>

  <!--This Form is for the Publication part of the page. It will allow users to add new publications-->
  <p>Publication Form, please fill all the fields provided</p>
  <form>

    <!--Add Author field-->
    <span id='chooseauthors'>
      Author Name:<br>
      <select name="selAuthor0" onchange="addselect()">
        <option value="" selected disabled hidden>Author</option>
        <?php
        $res = $conn->query('select ID, Name from Researchers order by Name');
        while ($row = $res->fetch_assoc()) {
          echo "<option value=".$row[ 'ID'].">".$row['Name']."</option>";
        }

        echo "<p>sql: ".$sql."</p>";
        $res = $conn->query($sql);
        ?>
      </select>
    </span>
    <br>

    <!--In case there are more than one author, this field will be available-->
    <script>
      var authors = [
        <?php
        $res = $conn->query('select ID, Name from Researchers order by Name');
        $first=true;
        while ($row = $res->fetch_assoc()) {
          if ($first == false) {
            echo ",";
          }
          $first=false;
          echo "{id:".$row[ 'ID'].",name:'".$row['Name']."'}";
        }
        ?>
      ];
    </script>

    <!--Add Title filed-->
    Publication Title:<br>
    <input type="text" name="title"><br>

    <!--Add Discipline field-->
    <span id="choosediscipline">
    Discipline:<br>
    <select name="discipline" onchange="addselectdis()">
      <option value="" selected disabled hidden>Discipline</option>
      <?php
        $res = $conn->query('select ID, Name from Discipline order by Name');
        while ($res and $row = $res->fetch_assoc()) {
          echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
        }
      ?>
    </select>
    </span>
    <br>

    <!--In case there are several disciplines to add -->
    <!--Script to handle multiple adding multiple disciplines -->
    <script>
      var discipline = [
        <?php
        $res = $conn->query('select ID, Name from Discipline order by Name');
        $first=true;
        while ($row = $res->fetch_assoc()) {
          if ($first == false) {
            echo ",";
          }
          $first=false;
          echo "{id:".$row[ 'ID'].",name:'".$row['Name']."'}";
        }
        ?>
      ];
    </script>

    <br>
    PDF URL (if available)<br>
    <input type="text" name="URL"><br>
</body>
</html>
