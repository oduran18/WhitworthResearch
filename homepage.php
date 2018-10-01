<!doctype html>
<html>
    <head>
            <title>Whitworth Research Hub</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="css/webpage.css">
   <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left">Whitworth Research Hub </h2>
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
          <li><a href="#">TAB</a>
              <ul>
                  <li><a href="#">TAB</a></li>
                  <li><a href="#">TAB</a></li>
              </ul>
          </li>
          <li><a href="#">TAB</a></li>
          <li><a href="resources.php">Resources</a></li>
      </ul>
  </nav>
  <!--script src="js/SearchScript.js"></script-->
</body>

<body>
<!--  <input type="text" placeholder="Search" onfocus="this.value=''" id="inputsearch" onkeyup="filterfunction()">-->

  <div class="search">
      <?php include 'search.php';?>
  </div>
  <div class="dropdown">
    <button hover="dropfunc()" class="dropbtn">Search BY</button>
    <div id="dropfilter" class="dropdown-content">
      <a onclick="setTerm('Keyword')">Keyword</a>
      <a onclick="setTerm('Title')">Title</a>
      <a onclick="setTerm('Author')">Author</a>
      <a onclick="setTerm('Category')">Category</a>
      <a onclick="setTerm('Discipline')">Discipline</a>
    </div>
  </div>
</body>
</html>
