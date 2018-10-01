<!doctype html>
<html>
    <head>
            <title>Research - Category</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="css/webpage.css">
   <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left"><a href="homepage.php">Whitworth Research Hub - Category</a></h2>
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
  <input type="text" placeholder="Search" onfocus="this.value=''" id="inputsearch" onkeyup="filterfunction()">
  <div class="dropdown">
    <button hover="dropfunc()" class="dropbtn">Search BY</button>
    <div id="dropfilter" class="dropdown-content">
      <a href="#keyword">Keyword</a>
      <a href="#title">Title</a>
      <a href="#author">Author</a>
      <a href="#category">Category</a>
      <a href="#discipline">Discipline</a>
    </div>
  </div>
</body>
</html>
