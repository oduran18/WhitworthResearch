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
