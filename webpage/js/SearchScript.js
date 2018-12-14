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
  if (dis) {
    //document.getElementById('disciplines').style.visibility = 'visible';
    document.getElementById('disciplines').style.display = 'inline';
    document.getElementById('searchitem').style.display = 'none';
  }
  else {
    document.getElementById('disciplines').style.display = 'none';
    document.getElementById('searchitem').style.display = 'inline';
  }
}

  /*var auth =(a == 'Authors');
  if (auth) {
    document.getElementById('authors').style.display = 'inline';
  }
  else {
    document.getElementById('authors').style.display = 'none';
  }

}*/

var selauthorid=1;
function addselect(){
  var s = document.getElementById('chooseauthors');
  var sel = document.createElement('select');
  sel.name = "selAuthor"+(selauthorid);
  selauthorid=selauthorid+1;
  s.appendChild(sel);
  var opt = document.createElement('option');
  //<option value="" selected disabled hidden>Author</option>
  opt.value = '';
  opt.innerHTML='Author';
  sel.appendChild(opt);
  for (var i=0; i<authors.length; i++) {
    opt = document.createElement('option');
    opt.id=authors[i].id;
    opt.innerHTML = authors[i].name;
    sel.appendChild(opt);
  }
}

//Fucntion for adding multiple disciplines
function addselectdis(){
  var d = document.getElementById('choosediscipline');
  var sel = document.createElement('select');
  d.appendChild(sel);
  var opt = document.createElement('option');
  opt.value = '';
  opt.innerHTML='Discipline';
  sel.appendChild(opt);
  for (var i=0; i<discipline.length; i++) {
    opt = document.createElement('option');
    opt.id=discipline[i].id;
    opt.innerHTML = discipline[i].name;
    sel.appendChild(opt);
  }
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
