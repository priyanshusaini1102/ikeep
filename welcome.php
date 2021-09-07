<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true){
  header("location: login.php");
  exit;
}

  $servername = "sql110.epizy.com";
  $username = "epiz_29655074";
  $password = "ALE9lWJSphK8P1I";
  $database = "epiz_29655074_notes";

  $con = mysqli_connect($servername, $username, $password, $database);

  $insert = false;
  $update = false;
  $delete = false;
  $error = false;
  
  // if(!$con){
  //   die("Sorry we failed to connect: ". mysqli_connect_error());
  // };
  
  // if(isset($_GET['delete'])){
  //   $sno = $_GET['delete'];
  //   $sql = "DELETE FROM `note` WHERE `sno` = $sno";
  //   $result = mysqli_query($con, $sql);
  //   if($result){
  //     $delete = true;
  //   }
  // }
  $username2 = mysqli_real_escape_string($con, $_SESSION["username"]);
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['snoEdit'])){
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
       $description = $_POST["descriptionEdit"];
       
       $sql = "UPDATE {$username2} SET `title` = '$title' , `description` = '$description' WHERE `note`.`sno` = $sno";
      //  UPDATE `note` SET `title` = 'Youtube Channels', `description` = 'jklmn' WHERE `note`.`sno` = 4;
       $result = mysqli_query($con, $sql);
       if($result){
        echo '<div class="alert alert-primary d-flex align-items-center alert-dismissible fade show " role="alert" style="border-radius: 25px; ">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
        
        <strong>Success! </strong> Your note successfully Updated.
        <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="alert" aria-label="Close"></button>
        
      </div>';
      }
     
     }else if(isset($_POST['snoDelete'])){
      $sno = $_POST['snoDelete'];
      $sql = "DELETE FROM {$username2} WHERE `sno` = $sno";
      $result = mysqli_query($con, $sql);
      if($result){
        $delete = true;
      }


     }else{
       if($_POST['title'] == '' || $_POST['description'] == ''){
         $error = true;
        
       }else{

         $title = $_POST["title"];
         $description = $_POST["description"];
         
         $sql = "INSERT INTO {$username2} (`title`, `description`) VALUES ('$title','$description')";
         $result = mysqli_query($con, $sql);
         
         if($result){
           $insert = true;
          }
       }

      };
  };

  
?>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
  <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
  </symbol>
  <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
  </symbol>
  <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </symbol>
</svg>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/jquery.dataTables.min.css">
    
    <title>Notes App</title>
  </head>
  <body style="background-color:rgb(163, 159, 225)" >
  
<!-- Delete Modal -->
<div class="modal fade "  id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog  text-dark">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title text-danger" id="deleteModalLabel">Delete Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <form action="/loginsystem/welcome.php" method="POST" >
          <!-- <h1 class="text-center" style="text-decoration: underline;">Add a Note</h1> -->
          <input type="hidden" name="snoDelete" id="snoDelete">
          <h3 >Are you really want to delete the note?</h3><br>
          <div class="modal-footer pt-3 ">
              <button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-outline-danger ">Confirm</button>
</div>
        </form>
      </div>
    </div>
  </div>
</div>
  

<!-- Edit Modal -->
<div class="modal fade "  id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog  text-dark">
    <div class="modal-content">
      <div class="modal-header ">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
        <form action="/loginsystem/welcome.php" method="POST" >
          <!-- <h1 class="text-center" style="text-decoration: underline;">Add a Note</h1> -->
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your data with anyone else.</div>
          </div>
          
          <div class="mb-3">
              <label for="desc" class="form-label">Description</label>
              <textarea id="descriptionEdit" name="descriptionEdit" class="form-control" aria-label="With textarea"></textarea>
            </div>
          
            <div class="modal-footer  ">
              <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success mb-0">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark " >
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Notes App</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              
              <li class="nav-item">
          <a class="nav-link " onclick="logoutfun" id="logout" href="/loginsystem/logout.php" >Log Out</a>
          </li>
              
            </ul>
            
          </div>
        </div>
      </nav>
      <?php
             if($delete){
              echo '<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show " role="alert" style="border-radius: 25px; ">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
              <strong>Success! </strong> Your note successfully deleted.
              <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="alert" aria-label="Close"></button>
              
            </div>';
            }
            
            ?>

            <?php
             if($error){
              echo '<div class="alert alert-danger d-flex align-items-center alert-dismissible fade show " role="alert" style="border-radius: 25px; ">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
              <strong style="padding-right:4px;">Sorry! </strong >Your note may be blank.
              <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="alert" aria-label="Close"></button>
              
            </div>';
            }
            
            ?>

      <div class="container p-5 my-3 bg-dark text-light col-md-6" style=" border-radius: 25px; ">
        <form action="/loginsystem/welcome.php" method="POST">
            <h1 class="text-center" style="text-decoration: underline;">Add a Note</h1>
            <?php
             if($insert){
              echo '<div class="alert alert-success d-flex align-items-center alert-dismissible fade show " role="alert" style="border-radius: 25px; ">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              
              <strong>Success! </strong> Your note successfully added.
              <button type="button" class="btn-close" style="color: white;" data-bs-dismiss="alert" aria-label="Close"></button>
              
            </div>';
            }
            
            ?>
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your data with anyone else.</div>
            </div>
            
            <div class="mb-3">
                <label for="desc" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" aria-label="With textarea"></textarea>
              </div>
            <button type="submit" class="btn btn-outline-success col-md-12 p-3 mt-4 " >Add Note</button>
          </form>
      </div>
      <div class="container m-auto p-4 my-5 bg-light" style=" border-radius: 25px; text-color: black;">

        <table class="table" id="myTable" >
          <thead>
            <tr>
              <th scope="col p-2">S.No.</th>
              <th scope="col p-2">Title</th>
              <th scope="col p-2" style="width: 700px;">Description</th>
              <th scope="col p-2" style="width: 200px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $sql = "SELECT * FROM {$username2}";
            $result = mysqli_query($con, $sql);
            $sno = 0;
            while($row = mysqli_fetch_assoc($result)){
              $sno = $sno + 1;
              //echo var_dump($row);
              echo "
              <tr>
              <th scope='row'>". $sno . "</th>
              <td>". $row['title'] . "</td>
              <td>". $row['description'] . "</td>
              <td class='text-center'>
                <button class='delete btn btn-sm btn-outline-danger px-2 m-2' id=d".$row['sno'].">Delete</button>
                <button id=". $row['sno'] ." class='edit btn btn-sm btn-outline-primary'>Edit</button>
                  
              </td>
              </tr>";
              
            };
            
            ?>
          
        </tbody>
      </table>
    </div>
<div class="container">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready( function () {
      $('#myTable').DataTable();
    } );
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element)=>{
        element.addEventListener('click', (e)=>{
          console.log("edit ", e.target.parentNode.parentNode);
          tr = e.target.parentNode.parentNode;

          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;

          snoEdit.value = e.target.id;
          descriptionEdit.value = description;
          titleEdit.value = title;
        
          
          $('#editModal').modal('toggle');
          
        });
      })

      deletes = document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element)=>{
        element.addEventListener('click', (e)=>{
          
          snoDelete.value = e.target.id.substr(1,);
          console.log(snoDelete.value);
          $('#deleteModal').modal('toggle');

          // if(confirm("Are you sure!")){
          //   console.log("yes");
          //   window.location = `/crud/index.php?delete=${sno}`;
            
          // }else{
          //   console.log("no");
          // }
          
        });
      })
      </script>
      <script>
        if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
        }
        </script>
        
    
      </div>

  </body>
  <script >
       

        if ( window.history.replaceState ) {
            
        window.history.replaceState( null, null, window.location.href );
        }
        const logoutfun = () =>{
          window.location = '/loginsystem/login.php';

        }

    </script>
</html>