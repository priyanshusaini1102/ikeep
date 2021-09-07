var disble = true;

var disblecl = "disabled";
if(disble){
    var logout = document.getElementById("logout");
    logout.classList.add("disabled");
}

if ( window.history.replaceState ) {
    
  window.history.replaceState( null, null, window.location.href );
}
