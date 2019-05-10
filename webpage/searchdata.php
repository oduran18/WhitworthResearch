<?php

function connect() {
    $server = 'localhost';
    $username = 'webuser';
    $password = 'IodV6WQCNTLo5Isx!';
    $dbname = 'undergrad_research';

    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die('error: ' . $conn->connect_error);
    }

    return $conn;
}

//Show the name of the author
// $n -- name of auther
// $u -- is this author an undergraduate (0 or 1). These authors are marked in italics
// $s -- the search keyword. If the keyword is in the author name, then that author is bold faced
function showName($n, $u, $s) {
    $ret = "";
    //Is this the searched author?
    if (strripos($n, $s) !== false)
        $ret .= "<b>";
    //Is this an undergrad?
    if ($u == 1)
        $ret .= "<i>";
    $ret .= $n;
    if ($u == 1)
        $ret .= "</i>";
    if (stripos($n, $s) !== false)
        $ret .= "</b>";

    return $ret;
}

// Show the title of the product
// $t -- product title
// $u -- url for the article
function showTitle($t, $u) {
    $ret = "";
    //Do we have a url? If so, anchor to it.
    if (isset($u) and strlen($u) > 0) {
        $ret .= "<a href='".$u."'>";
    }
    $ret .= $t;
    if (isset($u)) {
        $ret .= "</a>";
    }

    return $ret;
}

function fetchAuthors($conn, $pubid) {
    $res = $conn->query('select R.Name, R.Undergraduate ' .
                        'from ProductResearcher PR, Researchers R ' .
                        'where PR.ResearcherID = R.ID and PR.ProductID = '.$pubid.' ' .
                        'order by PR.AuthorOrder');
    $ret = array();
    while ($row = $res->fetch_assoc()) {
        $ret[] = (object)array('Name' => $row['Name'], 'Undergrad' => $row['Undergraduate']);
    }
    return $ret;
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
function showRow($row, $search) {
    global $pubids;

    if (isset($pubids[$row->id]))
        return;

    $ret = "";

    $i = 0;
    foreach ($row->authors as $auth) {
        if ($i !== 0)
            $ret .= ', ';
        $i = 1;
        $ret .= showName($auth->Name, $auth->Undergrad, $row->search);
    }

    $ret .= '. ';
    $ret .= showTitle($row->title, $row->url);
    $ret .= '. ';
    $ret .= '<i>' . $row->pub . '</i>. ';
    $ret .= $row->date . '. ';
    if (isset($row->awards) and strlen($row->awards) > 0)
        $ret .= '(' . $row->awards . ')';

    $ret .= '<br/>';

    $pubids[$row->id] = 1;

    return $ret;
}

function fetchData($conn, $searchitem, $searchterm, $searchdiscipline) {
    $pubids = array();

    //Find products by this author
    $search = $conn->real_escape_string($searchitem);
    if ($searchterm == 'Author') {
    $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
            "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
            "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
            "and R.Name LIKE '%" . $search . "%' " .
            "order by P.Date desc, P.ID, PR.AuthorOrder";
          }

    elseif ($searchterm == 'Keyword') {
    $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
            "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub, Keywords K, ProductKeyword PK " .
            "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID and PK.ProductID=P.ID and PK.KeywordID=K.ID " .
            "and K.Keyword LIKE '%".$search."%' ".
            "order by P.Date desc, P.ID, PR.AuthorOrder";
          }

    elseif ($searchterm == 'Title') {
      $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
              "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
              "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
              "and P.Title LIKE '%" . $search . "%' " .
              "order by P.Date desc, P.ID, PR.AuthorOrder";
    }
    elseif($searchterm == 'Discipline') {
      $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
              "from Products P, ProductResearcher PR, Researchers R, ProductDiscipline PD, ProductPublication PP, Publication Pub " .
              "where P.ID=PR.ProductID and P.ID=PP.ProductID and P.ID=PD.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID " .
              "and PD.DisciplineID=".$searchdiscipline . " " .
              "order by P.Date desc, P.ID, PR.AuthorOrder";
    }
    elseif($searchterm == 'Publication') {
        $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
               "from Products P, ProductResearcher PR, Researchers R, ProductPublication PP, Publication Pub " .
               "where P.ID=PR.ProductID and P.ID=PP.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID and " .
               "Pub.ID= ".$searchitem . " " .
               "order by P.Date desc, P.ID, PR.AuthorOrder";
      }
  
    //echo "<p>sql: ".$sql."</p>";
    $ret = array();
    $ret[] = (object)array('sql'=>$sql);
    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $id = $row['ID'];
        $title = $row['Title'];
        $url = $row['URL'];
        $date = $row['Date'];
        $awards = $row['Awards'];
        $pub = $row['Publication'];

        $ret[] = (object)array('id'=>$id, 'authors'=>fetchAuthors($conn, $id), 'title'=>$title, 'url'=>$url, 'publication'=>$pub,
                                'date'=>$date, 'awards'=>$awards);
        //$ret .= showRow($conn, $id, $search, $title, $url, $pub, $date, $awards);
    }

    return $ret;
}

function fetchAdvSearch($conn, $auths, $discs, $pubs) {
    $ret = array();

    if (count($auths) == 0 and count($discs) == 0 and count($pubs) == 0)
        return "";

    $sql = "SELECT P.ID, P.Title, P.URL, P.Date, P.Awards, R.Name, R.Undergraduate, Pub.Name as Publication " .
           "from Products P, ProductResearcher PR, Researchers R, ProductDiscipline PD, ProductPublication PP, Publication Pub " .
           "where P.ID=PR.ProductID and P.ID=PP.ProductID and P.ID=PD.ProductID and PR.ResearcherID=R.ID and PP.PublicationID = Pub.ID and ";

    $whereIDs = "";
    if (count($auths) > 0) {
        $whereIDs .= "R.ID in (" . implode(",", $auths) . ")";
    }
    if (count($discs) > 0) {
        if (strlen($whereIDs) > 0)
            $whereIDs .= " and ";
        $whereIDs .= "PD.DisciplineID in (" . implode(",", $discs) . ")";
    }
    if (count($pubs) > 0) {
        if (strlen($whereIDs) > 0)
            $whereIDs .= " and ";
        $whereIDs .= "Pub.ID in (" . implode(",", $pubs) . ")";
    }

    $sql .= "(" . $whereIDs . ") order by P.Date desc, P.ID, PR.AuthorOrder";

    $ret[] = (object)array('sql'=>$sql);

    $res = $conn->query($sql);
    while ($row = $res->fetch_assoc()) {
        $id = $row['ID'];
        $title = $row['Title'];
        $url = $row['URL'];
        $date = $row['Date'];
        $awards = $row['Awards'];
        $pub = $row['Publication'];

        $ret[] = (object)array('id'=>$id, 'authors'=>fetchAuthors($conn, $id), 'title'=>$title, 'url'=>$url, 'publication'=>$pub,
                                'date'=>$date, 'awards'=>$awards);
    }

    return $ret;
}

function showData($conn, $searchitem, $searchterm, $searchdiscipline) {
    $data = fetchData($conn, $searchitem, $searchterm, $searchdiscipline);
    
    foreach ($data as $row) {
        echo showRow($row, $searchterm);
    }
}

if (isset($_POST['json']) and isset($_POST['searchitem'])) {
    $data = fetchData(connect(), $_REQUEST['searchitem'], $_REQUEST['searchterm'], $_REQUEST['searchdiscipline']);
    echo json_encode($data);
}
elseif (isset($_POST['json']) and isset($_POST['auths'])) {
    $data = fetchAdvSearch(connect(), json_decode($_REQUEST['auths']), json_decode($_REQUEST['discs']), json_decode($_REQUEST['pubs']));
    echo json_encode($data);
}

?>
