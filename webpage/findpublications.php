<?php
$server = 'localhost';
$username = 'webuser';
$password = 'IodV6WQCNTLo5Isx!';
$dbname = 'undergrad_research';

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die('error: ' . $conn->connect_error);
}


//Show the name of the author
// $n -- name of auther
// $u -- is this author an undergraduate (0 or 1). These authors are marked in italics
// $s -- the search keyword. If the keyword is in the author name, then that author is bold faced
function showName($n, $u, $s) {
    //Is this the searched author?
    if (stripos($n, $s) !== false)
        echo "<b>";
    //Is this an undergrad?
    if ($u == 1)
        echo "<i>";
    echo $n;
    if ($u == 1)
        echo "</i>";
    if (stripos($n, $s) !== false)
        echo "</b>";
}

// Show the title of the product
// $t -- product title
// $u -- url for the article
function showTitle($t, $u) {
    //Do we have a url? If so, anchor to it.
    if (isset($u) and strlen($u) > 0) {
        echo "<a href='".$u."'>";
    }
    echo $t;
    if (isset($u)) {
        echo "</a>";
    }
}

//Show an entire product
// $conn -- the MySQLi Connection object
// $id -- the ID for the product, so we can get all the authors
// $search -- what was the search keyword (if it exists)
// $title -- the title of the product
// $url -- the url for the product (empty if it doesn't exist)
// $pub -- where the product was published
// $date -- when the product was published
// $awards -- did this receive any awards?
function showRow($conn, $id, $search, $title, $url, $pub, $date, $awards) {
    $res = $conn->query('select R.Name, R.Undergraduate ' .
                        'from ProductResearcher PR, Researchers R ' .
                        'where PR.ResearcherID = R.ID and PR.ProductID = '.$id.' ' .
                        'order by PR.AuthorOrder');
    $i = 0;
    while ($row = $res->fetch_assoc()) {
        if ($i !== 0)
            echo ', ';
        $i = 1;
        showName($row['Name'], $row['Undergraduate'], $search);
    }
    echo '. ';
    showTitle($title, $url);
    echo '. ';
    echo '<i>' . $pub . '</i>. ';
    echo $date . '. ';
    if (isset($awards) and strlen($awards) > 0)
        echo '(' . $awards . ')';
    
    echo '<br/>';
}
?>

<html>
<head>
    <title>Find Undergraduate Publications</title>
</head>
<body>
    <form>
        <?php 
            if (isset($_REQUEST['author'])) { $avalue = " value='".$_REQUEST['author']."'"; }
            else $avalue = "";
            if (isset($_REQUEST['publication'])) { $pvalue = " value='".$_REQUEST['publication']."'"; }
            else $pvalue = "";
            if (isset($_REQUEST['title'])) { $tvalue = " value='".$_REQUEST['title']."'"; }
            else $tvalue = "";
        ?>
        <table border='0'>
            <tr><td>Author name:</td><td><input type='text' name='author'<?php echo $avalue;?>></td></tr>
            <tr><td>Title:</td><td><input type='text' name='title'<?php echo $tvalue;?>></td></tr>
            <tr><td>Publication:</td><td><input type='text' name='publication'<?php echo $pvalue;?>></td></tr>
            <tr><td>Discipline:</td><td><select name='discipline'>
                <option value='0'>--all--</option>
                <?php
                $res = $conn->query('select * from Discipline order by Name');
                while ($row = $res->fetch_assoc()) {
                    if ($row['ID'] == $_REQUEST['discipline'])
                        $sel = " selected";
                    else
                        $sel = "";
                    echo "<option value='".$row['ID']."'".$sel.">".$row['Name']."</option>";
                }
                ?>
            </select></td></tr>
        </table>
        <input type='submit' value='search'>
    </form>
    <?php
        if (isset($_REQUEST['author']) and strlen($_REQUEST['author']) > 0) {
            $search = $conn->real_escape_string($_REQUEST['author']);
            $wauthor = "and R.Name LIKE '%" . $search . "%' ";
        }
        else {
            $search = "";
            $wauthor = "";
        }
        if (isset($_REQUEST['title']) and strlen($_REQUEST['title']) > 0) {
            $tsearch = $conn->real_escape_string($_REQUEST['title']);
            $wtitle = "and P.Title LIKE '%" . $tsearch . "%' ";
        }
        else {
            $psearch = "";
            $wpub = "";
        }
        if (isset($_REQUEST['publication']) and strlen($_REQUEST['publication']) > 0) {
            $psearch = $conn->real_escape_string($_REQUEST['publication']);
            $wpub = "and Pub.Name LIKE '%" . $psearch . "%' ";
        }
        else {
            $psearch = "";
            $wpub = "";
        }
        if (isset($_REQUEST['discipline']) and $_REQUEST['discipline'] !== '0') {
            $wdisc = "and R.DisciplineID=" . intval($_REQUEST['discipline']) . " ";
        }
        else {
            $wdisc = "";
        }

        if ((isset($_REQUEST['author']) and strlen($_REQUEST['author']) > 0) or isset($_REQUEST['discipline'])) {
            //Find products by this author
            $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
                    "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
                    "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
                    $wauthor .
                    $wtitle .
                    $wpub .
                    $wdisc .
                    "order by P.Date desc, P.ID, PR.AuthorOrder";
            $res = $conn->query($sql);

            $ids = (object)array();
            while ($row = $res->fetch_assoc()) {
                $id = strval($row['ID']);
                $title = $row['Title'];
                $url = $row['URL'];
                $date = $row['Date'];
                $awards = $row['Awards'];
                $pub = $row['Publication'];
                //This is sort of a hacked-up hash table. I add "properties" to the ids object
                //  where the name of the property is the publication id. If the ID isn't already a
                //  property in the hash table, we'll print out this product. Otherwise we've already
                //  printed it out, so don't do it again.
                if (isset($ids->{$id}) === false) {
                    $ids->{$id} = 1;
                    showRow($conn, $id, $search, $title, $url, $pub, $date, $awards);
                }
            }
        }
    ?>
</body>
</html>