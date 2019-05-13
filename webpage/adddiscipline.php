<!doctype html>
<html>
  <head>
    <title>Whitworth Research Hub</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/webpage.css">
    <link rel="shortcut icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="shortcut icon" type="image/png" href="https://www.whitworth.edu/favicon/favicon-16x16.png" sizes="16x16">
    <script src="js/SearchScript.js"></script>
  </head>
<body>
  <?php include 'searchdata.php'; ?>

  <?php include 'header.php'; showHeader('Add Discipline'); ?>
  <?php include 'navbar.php'; ?>

  <?php
    if (isset($_POST['Name']))
    {
      $newdiscipline = $conn->real_escape_string($_POST['Name']);
      $sql = "INSERT INTO Discipline (Name) values ('".$newdiscipline."')";
      $res = $conn->query($sql);
      echo '<p>added ' . $newdiscipline . '.</p>';
    }
  ?>

  <div>
  <div class='content-box'>
  <form method='POST' style='float:left; margin-right:50px'>
      Discipline: 
      <input type="text" name="Name">
      <input type="submit" value="Submit" class='btn'>
    </form>
    <div class='dropdown'>
      <button hover="dropfunc()" class="dropbtn">Existing Disciplines</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $conn = connect();
        $res = $conn->query('select ID, Name from Discipline order by Name;');
        while ($row = $res->fetch_array()) {
          $disp = $row['Name'];
          echo '<p>'.$disp.'</p>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
