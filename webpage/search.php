<div class='search-box'>
<div class="search">
      <div>
          <?php
              if (isset($_REQUEST['searchitem'])) { $value = " value='".$_REQUEST['searchitem']."'"; }
              else $value = "";
          ?>
          <span id='searchterm'></span>
          <input type='text' id='term' name='searchterm' hidden='true'>
          <input type='text' id='searchitem' name='searchitem'<?php echo $value;?>>
          <select id='discipline' name='searchdiscipline' hidden='true'>
              <?php
                $conn = connect();
                $res = $conn->query('select ID, Name from Discipline order by Name');
                while ($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['ID']."'>".$row['Name']."</option>";
                }
               ?>
          </select>
          <!--<input type='submit' value='search'>-->
          <button class='btn' onclick='pubsearch()'>Search</button>
            </div>
  </div>

  <div class="dropdown search">
    <button hover="dropfunc()" class="dropbtn">Search BY</button>
    <div id="dropfilter" class="dropdown-content">
      <a href="#Keyword" onclick="setTerm('Keyword')">Keyword</a>
      <a href="#Title" onclick="setTerm('Title')">Title</a>
      <a href="#Author" onclick="setTerm('Author')">Author</a>
      <a href="#Category" onclick="setTerm('Category')">Category</a>
      <a href="#Discipline" onclick="setTerm('Discipline')">Discipline</a>
    </div>
  </div>

  <div style='clear:both'></div>
  <div class="search-results" id='search-results'>
  </div>
</div>

<?php
    if (isset($_REQUEST['searchitem'])) {
        echo showData($conn, $_REQUEST['searchitem'], $_REQUEST['searchterm'], $_REQUEST['searchdiscipline']);
    }
?>
