<?php
session_start();
include("config.php");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,  initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<title>Profile</title>
  
  <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header_profile {
            position: relative;
            height: 300px;
            text-align: center;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</head>
<body>
  <div class="header_profile">
  <video autoplay muted loop>
            <source src="img/profile.mp4" type="video/mp4"> <!-- Adjust the path to your video file -->
            Your browser does not support the video tag.
        </video>
	</div>

  <?php
    if(isset($_SESSION["UID"])){
      $userID = $_SESSION["UID"];
      include 'menu.php';
    } else {
      include 'logged_menu.php';
    }
   ?>

<!--retrieve data from database and display--> 
   <?php
     $userID = $_SESSION["UID"];
     $sql = "SELECT * FROM profile WHERE userID = $userID";
     $sql2 = "SELECT matricNo, userEmail FROM user WHERE userID = $userID";
     $result1 = mysqli_query($conn, $sql);
     $result2 = mysqli_query($conn, $sql2);

     if(mysqli_num_rows($result1) > 0){
     $row = mysqli_fetch_assoc($result1);

     // Assign fetched data to variables
     $username = $row["username"] ?? '';
     $program = $row["program"] ?? '';
     $mentor = $row["mentor"] ?? '';
     $motto = $row["motto"] ?? '';
     }
     if(mysqli_num_rows($result2) > 0){
     $row = mysqli_fetch_assoc($result2);

     // Assign fetched data to variables
     $matricNo = $row["matricNo"] ?? '';
     $userEmail = $row["userEmail"] ?? '';
      }
   ?>

   <div class="column">
           <div class="column-left">
               <br>
               <img class="image" src="img/mypic.jpg">
           </div>
           <div class="column-right">
                 <div style="text-align: right; padding-bottom:5px;">
                   <a href="profile_edit.php"><u>Edit</a></u>
                 </div>

                 <table border="1" width="100%">
                    <tr>
                       <td class="coloring" width="164">Name</td>
                       <td><?=$username?></td>
                   </tr>
                   <tr>
                       <td class="coloring" width="164">Matric No.</td>
                       <td><?=$matricNo?></td>
                   </tr>
                   <tr>
                       <td class="coloring" width="164">Email</td>
                       <td><?=$userEmail?></td>
                   </tr>
                   <tr>
                       <td class="coloring" width="164">Program</td>
                       <td><?=$program?></td>
                   </tr>
                   <tr>
                       <td class="coloring" width="164">Mentor Name</td>
                       <td><?=$mentor?></td>
                   </tr>
               </table>

               
               <table border="1" width="100%">
                <th>My Study Motto</th>
                   <tr>
                       <td>
                           <?php
                             if($motto == ""){
                                 echo "&nbsp;";
                             } else {
                                 echo $motto;
                             }
                             ?>
                       </td>
                   </tr>
               </table>
           </div>
       </div>
       <footer class="footer">
         <p>Copyright (c) 2023 - Carl Brandon Valentine -BI21160464-</p>
       </footer>
   </body>
   </html>
