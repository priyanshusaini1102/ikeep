<?php

    $servername = "sql110.epizy.com";
    $username = "epiz_29655074";
    $password = "ALE9lWJSphK8P1I";
    $databse = "epiz_29655074_users";

    $con = mysqli_connect($servername, $username, $password, $databse);

    if(!$con){
        die("error" . mysqli_connect_error());
    }

    $database = "epiz_29655074_notes";

    $con2 = mysqli_connect($servername, $username, $password, $database);
    if(!$con2){
        die("error" . mysqli_connect_error());
    }


?>
