<?php
//Show the name of the author
// $n -- name of auther
// $u -- is this author an undergraduate (0 or 1). These authors are marked in italics
// $s -- the search keyword. If the keyword is in the author name, then that author is bold faced
function showName($n, $u, $s) {
    //Is this the searched author?
    if (strripos($n, $s) !== false)
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
    <?php
        if (isset($_REQUEST['searchitem'])) {
            //Find products by this author
            $search = $conn->real_escape_string($_REQUEST['searchitem']);
            if ($_REQUEST['searchterm'] == 'Author') {
            $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
                    "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
                    "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
                    "and R.Name LIKE '%" . $search . "%' " .
                    "order by P.Date desc, P.ID, PR.AuthorOrder";
                  }

            elseif ($_REQUEST['searchterm'] == 'Keyword') {
            $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
                    "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub, Keywords K, ProductKeyword PK " .
                    "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID and PK.ProductID=P.ID and PK.KeywordID=K.ID " .
                    "and K.Keyword LIKE '%".$search."%' ".
                    "order by P.Date desc, P.ID, PR.AuthorOrder";
                  }

            elseif ($_REQUEST['searchterm'] == 'Title') {
              $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
                      "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
                      "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
                      "and P.Title LIKE '%" . $search . "%' " .
                      "order by P.Date desc, P.ID, PR.AuthorOrder";
            }

            elseif($_REQUEST['searchterm'] == 'Discipline') {
              $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
                      "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub, ProductDiscipline PD ".
                      "where PD.ProductID=P.ID and P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID and PD.DisciplineID = ".$_REQUEST['disciplines']." ".
                      "order by P.Date desc, P.ID, PR.AuthorOrder ";
            }

            //echo "<p>sql: ".$sql."</p>";
            $res = $conn->query($sql);

            while ($row = $res->fetch_assoc()) {
                $id = $row['ID'];
                $title = $row['Title'];
                $url = $row['URL'];
                $date = $row['Date'];
                $awards = $row['Awards'];
                $pub = $row['Publication'];
                showRow($conn, $id, $search, $title, $url, $pub, $date, $awards);
            }
        }
    ?>
