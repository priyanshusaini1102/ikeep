<?php
    session_start();
    if(isset($_SESSION['loggedin']) ){
        header("location: welcome.php");
        exit;
    }
  
    $blank = false;
    $showErr = false;
    // if($insert = true){
    //     header('location: /loginsystem/signup.php');
    // }
    $exists = false;
    $showAlert = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require 'partials/_dbconnect.php';
       
        $username = $_POST["username"];
        $username2 = mysqli_real_escape_string($con2, $_POST["username"]);
        $password = $_POST["password"];
        $cpassword = $_POST["cpassword"];
        $existSql = "SELECT * FROM `user` WHERE `username` = '$username'";
        $existResult = mysqli_query($con , $existSql);
        $numExistRows = mysqli_num_rows($existResult);
        if($numExistRows > 0){
            $exists = true;
        }else
        if($username=='' || $password==''){
            $blank = true;
        }else if(($password == $cpassword) && ($exists == false)){
            $hash = password_hash($password , PASSWORD_DEFAULT);

            $sql = "INSERT INTO `user` ( `username`, `password`, `dt`) VALUES ( '$username', '$hash', current_timestamp());";
            $result = mysqli_query($con, $sql);
            if($result){
                $showAlert = true;
                $mktble = mysqli_query($con2, "CREATE TABLE {$username2}( sno INT(11) AUTO_INCREMENT PRIMARY KEY, title VARCHAR(50) NOT NULL, description TEXT NOT NULL, stamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP )");
               
                // echo $result;
                // header('location: /loginsystem/login.php');
            }
        }else{
            $showErr = true;
        } 

    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />

    <title>iSecure | Sign Up</title>
</head>

<body style="background-color:rgb(163, 159, 225)">
     <?php require 'partials/_nav.php' ?>
     <?php
     if($showAlert){echo '
         <div class="alert alert-success alert-dismissible fade show text-success bg-light my-1" style="border-radius: 50px;" role="alert">
         <strong>Success!</strong> Your account is now created and you can login.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>';
         $password = "";
        };
        if($blank){echo '
            <div class="alert alert-danger alert-dismissible fade show text-danger bg-light my-1" style="border-radius: 50px;" role="alert">
            <strong>Sorry!</strong> You can not leave your username or password blank.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
           };
           if($showErr){echo '
            <div class="alert alert-danger alert-dismissible fade show text-danger bg-light my-1" style="border-radius: 50px;" role="alert">
            <strong>Sorry!</strong> Your password not match with confirm password.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
           };
           if($exists){echo '
            <div class="alert alert-danger alert-dismissible fade show text-danger bg-light my-1" style="border-radius: 50px;" role="alert">
            <strong>Sorry!</strong> Your username already taken.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
           };
           
     ?>
    <div class="container bg-dark text-light p-4 mt-5 col-md-6" style="border-radius: 15px; ">
        <h1 class="text-center">Sign Up to our Website</h1>
        <form action="/loginsystem/index.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" />
                
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" />
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" />
                <small id="emailHelp" class="form-text">
                    Make sure to type the same password.
                </small>
            </div>
            <div class="conatiner ">
                <button type="submit" class="btn btn-outline-success ">Sign Up</button>
                <button type="reset" class="mx-3 px-3 btn btn-outline-light"  >Reset</button>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
    <script src="index.js"></script>
    
    
</body>

</html>