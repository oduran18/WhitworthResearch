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

  <?php include 'header.php'; showHeader('Add Author'); ?>
  <?php include 'navbar.php'; ?>

  <?php
    $conn = connect();
    if (isset($_POST['LastName']))
    {
      $fname = $conn->real_escape_string($_POST['FirstName']);
      $mname = $conn->real_escape_string($_POST['MiddleName']);
      $lname = $conn->real_escape_string($_POST['LastName']);
      $disp = $_POST['Discipline'];
      if (isset($_POST['Undergrad']))
        $undergrad = 1;
      else
        $undergrad = 0;
      $sql = "INSERT INTO Researchers (FirstName, MiddleName, LastName, Undergraduate, DisciplineID) values ('".$fname."', '".$mname."', '".$lname."', ".$undergrad.", ".$disp.")";
      echo "<p>".$sql."</p>";
      $res = $conn->query($sql);
      echo '<p id="add">added ' . showNameFull($fname, $mname, $lname, $undergrad, "") . '.<button class="hidebtn" onclick="hideParent(this)">X</button></p>';
    }
  ?>

  <div>
  <div class='content-box'>
  <form method='POST' style='float:left; margin-right:50px'>
      Author:<br/>
      <input type="text" name="FirstName" placeholder="First Name"><br/>
      <input type="text" name="MiddleName" placeholder="Middle Name"><br/>
      <input type="text" name="LastName" placeholder="Last Name"><br/>
      <select name='Discipline'>
        <?php
          $res = $conn->query('select ID, Name from Discipline order by Name;');
          while ($row = $res->fetch_array()) {
            echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
          }
        ?>
      </select>
      <input type="checkbox" name="Undergrad">Undergraduate<br/>
      <input type="submit" value="Submit" class='btn'>
    </form>
    <div class='dropdown'>
      <button hover="dropfunc()" class="dropbtn">Existing Authors</button>
      <div id="dropfilter" class="dropdown-content">
        <?php
        $res = $conn->query('select ID, FirstName, MiddleName, LastName, Undergraduate from Researchers order by LastName;');
        while ($row = $res->fetch_array()) {
          $auth = showNameFull($row['FirstName'], $row['MiddleName'], $row['LastName'], $row['Undergraduate'], '');
          echo '<p>'.$auth.'</p>';
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
