<!doctype html>
<html>
    <head>
            <title>Research Hub - Product</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="css/webpage.css">
   <script src="js/SearchScript.js"></script>
  </head>
<body>
  <div style="clear: both">
      <h1 style="float: left"><img src="images/whitlogo.jpg" alt="logo"></h1>
      <h2 style="float: left">Whitworth Research Hub - Product </h2>
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
          <li><a href="resources.php">Resources</a></li>
      </ul>
  </nav>

  <div class="search">
      <form>
          <?php
              if (isset($_REQUEST['searchitem'])) { $value = " value='".$_REQUEST['searchitem']."'"; }
              else $value = "";
          ?>
          <span id='searchterm'></span>
          <input type='text' id='term' name='searchterm' hidden="term">
          <input type='text' name='searchitem'<?php echo $value;?>>
          <input type='submit' value='search'>
      </form>
  </div>

  <div class="dropdown">
    <button hover="dropfunc()" class="dropbtn">Search BY</button>
    <div id="dropfilter" class="dropdown-content">
      <a href="#Keyword" onclick="setTerm('Keyword')">Keyword</a>
      <a href="#Title" onclick="setTerm('Title')">Title</a>
      <a href="#Author" onclick="setTerm('Author')">Author</a>
      <a href="#Category" onclick="setTerm('Category')">Category</a>
      <a href="#Discipline" onclick="setTerm('Discipline')">Discipline</a>
    </div>
  </div>

  <br>

  <div style='clear:both'></div>
  <div>
    <br><?php include 'search.php';?>
  </div>
</body>
</html>
