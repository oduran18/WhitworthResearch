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
    <title> Research Hub - Add new discipline</title>
    <link rel="stylesheet" href="css/webpage.css">
    <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left">Whitworth Research Hub - Add new discipline </h2>
      <br>
  </div>
  <nav>
      <ul>
          <li><a href="homepage.php">Home</a></li>
      </ul>
  </nav>
  <br>
<div style="clear: both">
  <p>Add new discipline, please fill all the fields</p>
  <form method='POST'>
    Discipline Name<br>
    <input type="text" name="Name"><br>
    <input type="submit" value="Submit">
  </form>
</div>
  <?php
    if (isset($_POST['Name']))
    {
      $newdiscipline = $conn->real_escape_string($_POST['Name']);
      $sql = "INSERT INTO Discipline(Name) values ('".$newdiscipline."')";
      $res = $conn->query($sql);
      $disc_id = $conn->insert_id();
    }
  ?>
</body>
</html>
