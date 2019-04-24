/*when the user clicks on the button, toggle between hiding and showing the dropdown content*/
function dropfunc()
{
  document.getElementById("dropfilter").classList.toggle("show");
}

function setTerm(t) {
  var st = document.getElementById('searchterm');
  st.innerHTML = t;
  var term = document.getElementById('term');
  term.value = t;

  var dis = (t == 'Discipline');
  document.getElementById('discipline').hidden = !dis;
  document.getElementById('searchitem').hidden = dis;

}

function filterfunction()
{
  var input, filter, ul, li, a, i;
  input = document.getElementById("inputsearch");
  filter = input.value.toUpperCase();
  div = document.getElementById("dropfilter");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++)
  {
    if(a[i].innerHTML.toUpperCase().indexOf(filter) > -1)
    {
      a[i].style.display = "";
    }
    else
    {
      a[i].style.display = "";
    }
  }
}

function formatAuth(auth, index) {
  var term = document.getElementById('term').value;
  var item = document.getElementById('searchitem').value;

  if (index != 0)
    disp = disp + ", ";
  
  if (term == 'Author' && auth.Name.indexOf(item) != -1)
    disp = disp + "<b>";
  if (auth.Undergrad == 1)
    disp = disp + "<i>";
  disp = disp + auth.Name;
  if (auth.Undergrad == 1)
    disp = disp + "</i>";
  if (term == 'Author' && auth.Name.indexOf(item) != -1)
    disp = disp + "</b>";
}

function showTitle(title, url) {
  var ret = "";
  //Do we have a url? If so, anchor to it.
  if (url.length > 0) {
      ret = "<a href='"+url+"'>";
  }
  ret = ret + title;
  if (url.length > 0) {
      ret = ret + "</a>";
  }

  return ret;
}

var pubids = new Set();
var disp = "";

function formatPub(pub, index) {
  if (pubids.has(pub.id) || pub.authors == null)
    return;
  pubids.add(pub.id);

  disp = disp + "<p class='pub'>"

  pub.authors.forEach(formatAuth);
  
  disp = disp + '. ';
  disp = disp + showTitle(pub.title, pub.url);
  disp = disp + '. ';
  disp = disp + '<i>' + pub.publication + '</i>. ';
  disp = disp + pub.date + '. ';
  if (pub.awards.length > 0)
    disp = disp +  '(' + pub.awards + ')';

  disp = disp +  '</p>';
}

function formatPubs(pubs, res_div) {
  var res = document.getElementById(res_div);
  if (pubs.length == 0)
    res.innerHTML = "<p>no results</p>";
  else {
    pubids = new Set();
    disp = '';
    pubs.forEach(formatPub);
    disp = "<p><span class='results'>"+pubids.size+" results</span></p>" + disp;
    res.innerHTML = disp;
  }
}

function pubsearch() {
  var term = document.getElementById('term').value;
  var item = document.getElementById('searchitem').value;
  var e = document.getElementById('discipline');
  var discipline = e.options[e.selectedIndex].value;
  fetchPubs(term, item, discipline);
}

function fetchPubs(term, item, discipline, res_div='search-results') {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      formatPubs(JSON.parse(this.responseText), res_div);
    }
  };
  xhttp.open("POST", "searchdata.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("json=1&searchitem="+item+"&searchterm="+term+"&searchdiscipline="+discipline+"");
}

function showByDiscipline(discipline) {
  fetchPubs('Discipline', '', discipline, 'content-results');
}

function showByPublication(publication) {
  fetchPubs('Publication', publication, '', 'content-results');
}
