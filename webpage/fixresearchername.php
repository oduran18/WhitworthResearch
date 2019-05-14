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
  <?php include 'searchdata.php';
    $conn = connect();
    $res = $conn->query('select ID, Name from Researchers order by Name;');
    while ($row = $res->fetch_array()) {
        $auth = $row['Name'];
        $names = explode(" ", $auth);
        if ($names[0] == "Peter" or $names[0] == "Paul") {
            $fname = $names[0];
            if (count($names) == 3) {
                $mname = $names[1];
                $lname = $names[2];
            }
            else {
                $mname = "";
                $lname = $names[1];
            }
        }
        else {
            $lname = $names[0];
            if (count($names) == 3) {
                $mname = $names[1];
                $fname = $names[2];
            }
            else {
                $mname = "";
                $fname = $names[1];
            }
        }

        $updsql = "update Researchers set FirstName='".$fname."', MiddleName='".$mname."', LastName='".$lname."' where ID=".$row['ID'].";";
        echo "<p>".$updsql."</p>";
        $upd = $conn->query($updsql);
    }
?>
</body>
</html>