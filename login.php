<?php
    session_start();
    if(isset($_SESSION['loggedin']) ){
        header("location: welcome.php");
        exit;
    }
    $err = false;
    $blank = false;
    $login = false;
    // if($insert = true){
    //     header('location: /loginsystem/signup.php');
    // }
    // $showAlert = false;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require 'partials/_dbconnect.php';
        $username = $_POST["username"];
        $password = $_POST["password"];
        $hash = password_hash($password , PASSWORD_DEFAULT);

            $sql = "SELECT * FROM `user` WHERE `username` = '$username' ";
            $result = mysqli_query($con, $sql);
            $num = mysqli_num_rows($result);
            if($username=='' || $password==''){
                $blank = true;
            }else if($num == 1){
                while($row=mysqli_fetch_assoc($result)){
                    if(password_verify($password, $row['password'])){

                        $login = true;
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        header('location: /loginsystem/welcome.php');
                    }else{
                        $err = true;
                    }
                    };
            }else{
              $err = true;
            };
       
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

    <title>iSecure | Log In</title>
</head>

<body style="background-color:rgb(163, 159, 225)">
     <?php require 'partials/_nav.php' ?>
     <?php
        if($err){echo '
          <div class="alert alert-danger alert-dismissible fade show text-danger bg-light my-1" style="border-radius: 50px;" role="alert">
          <strong>Sorry!</strong> Please Sign Up first.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
         
        };
        if($login){echo '
          <div class="alert alert-success alert-dismissible fade show text-success bg-light my-1" style="border-radius: 50px;" role="alert">
          <strong>Success!</strong> Your account is loged in.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
          
         };
         if($blank){echo '
            <div class="alert alert-success alert-dismissible fade show text-danger bg-light my-1" style="border-radius: 50px;" role="alert">
            <strong>Sorry!</strong> Username or Password can not be blank.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            
           };

     ?>
    
    <div class="container bg-dark text-light p-4 mt-5 col-md-6" style="border-radius: 15px; ">
        <h1 class="text-center">Log In to our Website</h1>
        <form action="/loginsystem/login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" />
                
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" />
            </div>
           
            <div class="conatiner mt-4 ">
                <button type="submit" class="btn btn-outline-success ">Log In</button>
                <button type="reset" class="mx-3 px-3 btn btn-outline-light"  >Reset</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
        crossorigin="anonymous"></script>

    
        <script src="index.js"></script>
    
</body>

</html>