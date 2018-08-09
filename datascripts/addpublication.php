<?php

//Clean the database of all data so that we can recreate it
function cleandb($conn) {
    $conn->query('delete from Discipline');
    $conn->query('delete from Researchers');
    $conn->query('delete from Publication');
    $conn->query('delete from Products');
    $conn->query('delete from ResearcherOrganization');
    $conn->query('delete from ProductKeyword');
    $conn->query('delete from ProductDiscipline');
    $conn->query('delete from ProductPublication');
    $conn->query('delete from ProductResearcher');
}

//Execute an INSERT query and return the ID for that insert
function execInsert($sql, $conn) {
    echo $sql.": ";
    $id = 0;
    if ($conn->query($sql)) {
        $id = $conn->insert_id;
    }
    else {
        echo "error: " . $conn->error;
    }
    echo "<br/>";
    return $id;
}

//Add a new Discipline to the database
// $d -- the discipine name (e.g. Computer Science)
// $conn -- the connection to the database
function addDiscipline($d, $conn) {
    $sql = "INSERT INTO Discipline(Name) VALUES ('".$d->Name."');";
    $d->ID = execInsert($sql, $conn);
}

//Add a new Researcher to the database
// Also add this researcher as a Whitworth person since all the people we're adding in this script are Whitworth
// $r -- the name of the Author (e.g. Kent Jones)
// $conn -- the connection to the database
function addResearcher($r, $conn) {
    $sql = "INSERT INTO Researchers(Name, Undergraduate, DisciplineID) VALUES ('".$r->Name."', ".$r->Undergrad.", ".$r->Discipline->ID.");";
    $r->ID = execInsert($sql, $conn);
    $sql = "INSERT INTO ResearcherOrganization(ResearcherID, OrganizationID) VALUES (".$r->ID.", 1);";
    execInsert($sql, $conn);
}

//Search the array of researchers for a name. We'll use this when adding their products
// $rs -- array of Researcher objects
// $name -- the name of person to look for
function findResearcher($rs, $name) {
    for ($i=0; $i<sizeof($rs); $i=$i+1) {
        if (strpos($rs[$i]->Name, $name) !== false)
            return $rs[$i];
    }
}

//Search the array of publications for a name. We'll use this when adding products
// $ps -- array of Publication objects
// $name -- the name of publication to look for (e.g. Spokane Intercollegiate Research Conference)
function findPub($ps, $name) {
    for ($i=0; $i < sizeof($ps); $i=$i+1) {
        if (strpos($ps[$i]->Name, $name) !== false)
            return $ps[$i];
    }
}

//Add a new Publication to the database
// $p -- the name of the Publication (e.g. Spokane Intercollegiate Research Conference)
// $conn -- the connection to the database
function addPublication($p, $conn) {
    $sql = "INSERT INTO Publication(Name) VALUES ('".$p->Name."');";
    $p->ID = execInsert($sql, $conn);
}

//Add a new Product to the database (e.g. article, poster, presentation)
// Also match the researchers for this product to it
// And match the publication to this product
// $p -- the Product object to add (has title, URL, researchers, and publication)
// $conn -- the connection to the database
function addProduct($p, $conn) {
    $sql = "INSERT INTO Products(Title, URL, Date, Awards) VALUES ('".$p->Title."', '".$p->URL."', '".$p->Date."', '".$p->Awards."');";
    $p->ID = execInsert($sql, $conn);
    for ($i=0; $i<sizeof($p->Researchers); $i=$i+1) {
        $sql = "INSERT INTO ProductResearcher(AuthorOrder, ProductID, ResearcherID) VALUES (".$i.", ".$p->ID.", ".$p->Researchers[$i]->ID.");";
        execInsert($sql, $conn);
    }
    $sql = "INSERT INTO ProductPublication(ProductID, PublicationID) VALUES (".$p->ID.", ".$p->Publication->ID.");";
    execInsert($sql, $conn);
}

//Connect information for the database
$server = 'localhost';
$username = 'webuser';
$password = 'IodV6WQCNTLo5Isx!';
$dbname = 'undergrad_research';

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    die('error: ' . $conn->connect_error);
}

$whitworth = 1;

$disciplines = array((object)array('ID'=>0, 'Name'=>'Computer Science'), 
                        (object)array('ID'=>0, 'Name'=>'Chemistry'), 
                        (object)array('ID'=>0, 'Name'=>'Biology')
                    );
$researchers = array((object)array('ID'=>0, 'Name'=>'Peter A. Tucker', 'Undergrad'=>0, 'Discipline'=>$disciplines[0]),
                        (object)array('ID'=>0, 'Name'=>'Paul Stephens', 'Undergrad'=>1, 'Discipline'=>$disciplines[0]),
                        (object)array('ID'=>0, 'Name'=>'Wheeler, K.A.', 'Undergrad'=>0, 'Discipline'=>$disciplines[1]),
                        (object)array('ID'=>0, 'Name'=>'Cantrell, L.S.', 'Undergrad'=>1, 'Discipline'=>$disciplines[1]),
                        (object)array('ID'=>0, 'Name'=>'Pinter, E.N.', 'Undergrad'=>1, 'Discipline'=>$disciplines[1]),
                        (object)array('ID'=>0, 'Name'=>'Tinsley, I.C.', 'Undergrad'=>1, 'Discipline'=>$disciplines[1]),
                        (object)array('ID'=>0, 'Name'=>'Wagner, B.L.', 'Undergrad'=>1, 'Discipline'=>$disciplines[1]),
                        (object)array('ID'=>0, 'Name'=>'Spencer, E.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Putzke, A.', 'Undergrad'=>0, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Calderon, A.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Mila, D.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Watson, M.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Genzink, K.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Baldwin, A.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Phillips, B.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Hoffman, A.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Sinha, V.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Andrianu, J.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Caccavo, F.', 'Undergrad'=>0, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Bax, P.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Billquist, E.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Witze, E.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Bulman, G.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Rajah, S.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Jones, K.', 'Undergrad'=>1, 'Discipline'=>$disciplines[0]),
                        (object)array('ID'=>0, 'Name'=>'Moore, K.M.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Brown, A.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Dunn, E.M.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'VanderStoep, A.L.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Westrate, L.M..', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'McLellan, L.K..', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'Peterson, S.C..', 'Undergrad'=>1, 'Discipline'=>$disciplines[2]),
                        (object)array('ID'=>0, 'Name'=>'MacKeigan, J.P.', 'Undergrad'=>1, 'Discipline'=>$disciplines[2])
                    );

$publications = array((object)array('ID'=>0, 'Name'=>'IEEE Transactions on Knowledge and Data Engineering'), 
                    (object)array('ID'=>0, 'Name'=>'American Chemical Society National Meeting'), 
                    (object)array('ID'=>0, 'Name'=>'Spokane Intercollegiate Research Conference'),
                    (object)array('ID'=>0, 'Name'=>'American Chemical Society Northwest Regional Meeting'),
                    (object)array('ID'=>0, 'Name'=>'NCUR Conference'), 
                    (object)array('ID'=>0, 'Name'=>'International C.elegans Meeting'), 
                    (object)array('ID'=>0, 'Name'=>'Murdock Research Symposium'), 
                    (object)array('ID'=>0, 'Name'=>'Genetics'), 
                    (object)array('ID'=>0, 'Name'=>'NCBI BioProject'), 
                    (object)array('ID'=>0, 'Name'=>'Biology')
                );

$products = array((object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2007-09-01', 'Title'=>'Using Punctuation Schemes to Characterize Strategies for Querying over Data Streams', 'URL'=>'https://www.whitworth.edu/academic/department/mathcomputerscience/faculty/tuckerpeter/pdf/tkde-0545-1206-2.pdf', 'Researchers'=>array(findResearcher($researchers, 'Tucker'), findResearcher($researchers, 'Stephens')), 'Publication'=>findPub($publications, 'IEEE')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2018-03-19', 'Title'=>'Prescribed Molecular Assemblies via Shape Mimicry', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Wheeler'), findResearcher($researchers, 'Cantrell'), findResearcher($researchers, 'Pinter'), findResearcher($researchers, 'Tinsley'), findResearcher($researchers, 'Wagner')), 'Publication'=>findPub($publications, 'Chemical Society National')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2018-03-19', 'Title'=>'Probing Molecular Recognition Phenomena using Hot Stage Thermomicroscopy', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Wheeler'), findResearcher($researchers, 'Cantrell'), findResearcher($researchers, 'Pinter'), findResearcher($researchers, 'Tinsley'), findResearcher($researchers, 'Wagner')), 'Publication'=>findPub($publications, 'Chemical Society National')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2018-04-28', 'Title'=>'Uncharacteristic Quasiracemic Assemblies Derived from Tartaramide/Malamide Molecular Frameworks', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Cantrell'), findResearcher($researchers, 'Wheeler')), 'Publication'=>findPub($publications, 'Spokane')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2018-06-24', 'Title'=>'Successes with Undergraduates Through Innovations in Solid-State Organic Chemistry Research', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Wheeler'), findResearcher($researchers, 'Cantrell'), findResearcher($researchers, 'Pinter'), findResearcher($researchers, 'Tinsley'), findResearcher($researchers, 'Wagner')), 'Publication'=>findPub($publications, 'Chemical Society Northwest')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2015-03-01', 'Title'=>'Dual Roles of Fer kinase are Required for Proper Hematopoiesis and Vascular Endothelium Organization during Zebrafish Development', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Spencer'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'NCUR Conference')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2015-03-01', 'Title'=>'FRK-1 Regulation of Post-embryonic Seam Cell Proliferation and Identity via Asymmetric Wnt signaling', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Calderon'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'NCUR Conference')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2015-03-01', 'Title'=>'Asymmetric Wnt Pathway Regulation of Post-embryonic Seam Cell Proliferation and Identity via the Non-receptor Tyrosine Kinase FRK-1', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Calderon'), findResearcher($researchers, 'Mila'), findResearcher($researchers, 'Watson'), findResearcher($researchers, 'Genzink'), findResearcher($researchers, 'Baldwin'), findResearcher($researchers, 'Phillips'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'elegans')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2015-11-01', 'Title'=>'Asymmetric Wnt Pathway Regulation of Post-embryonic Seam Cell Proliferation and Identity via the Non-receptor Tyrosine Kinase FRK-1', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Calderon'), findResearcher($researchers, 'Mila'), findResearcher($researchers, 'Watson'), findResearcher($researchers, 'Genzink'), findResearcher($researchers, 'Baldwin'), findResearcher($researchers, 'Phillips'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Murdock')),
                    (object)array('ID'=>0, 'Awards'=>'winner best oral presentation John Van Zytveld Award In The Life Sciences', 'Date'=>'2015-03-01', 'Title'=>'ual Roles of Fer Kinase are Required for Proper Hematopoiesis and Vascular Endothelium Organization During Zebrafish Development', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Hoffman'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Murdock')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2016-04-01', 'Title'=>'Investigating the Role of Fer Kinase in the Early Blood Development of Zebrafish', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Sinha'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Spokane')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2016-11-01', 'Title'=>'Molecular Quantification of Dissimilatory Arsenic-Reducing Bacteria Within Arsenic-Contaminated Sediments of The Spokane River', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Andrianu'), findResearcher($researchers, 'Caccavo'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Murdock')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2016-11-01', 'Title'=>'Wnt5a and APT1 Regulate Protein Depalmitoylation during Zebrafish Convergent Extension and Gastrulation', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Bax'), findResearcher($researchers, 'Witze'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Murdock')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2017-04-01', 'Title'=>'Wnt5a Induced Protein Depalmitoylation is Required for Cell Movement in Zebrafish', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Bax'), findResearcher($researchers, 'Billquist'), findResearcher($researchers, 'Witze'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Spokane')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2017-11-01', 'Title'=>'Global Gene Expression Analysis in the Absence of a Non-Receptor Tyrosine Kinase during Post-Embryonic Development of the Nematode C. elegans', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Bulman'), findResearcher($researchers, 'Rajah'), findResearcher($researchers, 'Jones'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Murdock')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2018-04-01', 'Title'=>'Global Gene Expression Analysis in the Absence of a Non-Receptor Tyrosine Kinase during Post-Embryonic Development of the Nematode C. elegans', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Bulman'), findResearcher($researchers, 'Rajah'), findResearcher($researchers, 'Jones'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Spokane')),
                    (object)array('ID'=>0, 'Awards'=>'Highlighted article', 'Date'=>'2015-03-01', 'Title'=>'Asymmetric Wnt pathway signaling facilitates stem cell-like divisions via the non-receptor Tyrosine Kinase FRK-1 in Caenorhabditis elegans', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Mila'), findResearcher($researchers, 'Calderon'), findResearcher($researchers, 'Baldwin'), findResearcher($researchers, 'Moore'), findResearcher($researchers, 'Watson'), findResearcher($researchers, 'Phillips'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Genetics')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2017-06-01', 'Title'=>'Global Gene Expression profile in homozygous frk-1(ok760) mutants versus wildtype in the nematode, Caenorhabditis elegans using RNA Seq', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Putzke'), findResearcher($researchers, 'Brown')), 'Publication'=>findPub($publications, 'NCBI')),
                    (object)array('ID'=>0, 'Awards'=>'', 'Date'=>'2017-06-01', 'Title'=>'Dual Roles of Fer Kinase Are Required for Proper Hematopoiesis and Vascular Endothelium Organization during Zebrafish Development', 'URL'=>'', 'Researchers'=>array(findResearcher($researchers, 'Dunn'), findResearcher($researchers, 'Billquist'), findResearcher($researchers, 'VanderStoep'), findResearcher($researchers, 'Bax'), findResearcher($researchers, 'Westrate'), findResearcher($researchers, 'McLellan'), findResearcher($researchers, 'Peterson'), findResearcher($researchers, 'MacKeigan'), findResearcher($researchers, 'Putzke')), 'Publication'=>findPub($publications, 'Biology')),
            );

cleandb($conn);

for ($i=0; $i<sizeof($disciplines); $i=$i+1) {
    if ($disciplines[$i]->ID == 0)
        addDiscipline($disciplines[$i], $conn);
}

for ($i=0; $i<sizeof($researchers); $i=$i+1) {
    if ($researchers[$i]->ID == 0)
        addResearcher($researchers[$i], $conn);
}

for ($i=0; $i<sizeof($publications); $i=$i+1) {
    if ($publications[$i]->ID == 0)
        addPublication($publications[$i], $conn);
}

for ($i=0; $i<sizeof($products); $i=$i+1) {
    if ($products[$i]->ID == 0)
        addProduct($products[$i], $conn);
}
?>