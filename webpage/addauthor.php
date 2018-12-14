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
    <title> Research Hub - Add new author</title>
    <link rel="stylesheet" href="css/webpage.css">
    <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left">Whitworth Research Hub - Add new author </h2>
      <br>
  </div>
  <nav>
      <ul>
          <li><a href="homepage.php">Home</a></li>
      </ul>
  </nav>
  <br>
  <div style="clear: both">
  <p>Add new authors form, please fill all the fields</p>
  <form method='POST'>
    Author Name<br>
    <input type="text" name="Name"><br>
    <input type="submit" value="Submit">
  </form>
</div>
  <?php
    if (isset($_POST['Name']))
    {
      $newauthor = $conn->real_escape_string($_POST['Name']);
      $sql = "INSERT INTO Researchers (Name, Undergraduate, DisciplineID) values ('".$newauthor."')";
      $res = $conn->query($sql);
      $auth_id = $conn->insert_id();
    }
    else if (count($_POST) > 0)
      print_r($_POST);
  ?>
</body>
</html>
