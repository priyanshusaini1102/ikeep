<?php
  $loggedin = false;
  if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    $loggedin = true;
  }

echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/loginsystem">iSecure</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/loginsystem">Home </a>
        </li>';
        if(!$loggedin){
        echo '
        <li class="nav-item">
          <a class="nav-link" id="login" href="/loginsystem/login.php">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="signup" href="/loginsystem/index.php">Sign Up</a>
        </li>';
      }

        if($loggedin==true){

          echo '
          <li class="nav-item">
          <a class="nav-link " onclick="logoutfun" id="logout" href="/loginsystem/logout.php" >Log Out</a>
          </li>';
        }

        echo '
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>'
?>