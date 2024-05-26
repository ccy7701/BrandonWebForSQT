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
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<title>Profile updates</title>

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
      include 'menulogin.php';
    }
   ?>

   <?php
    $sql = "SELECT * FROM user WHERE userID = $userID";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);

      // Add checks for each key
      $username = isset($row["username"]) ? $row["username"] : '';
      $matricNo = isset($row["matricNo"]) ? $row["matricNo"] : '';
      $userEmail = isset($row["userEmail"]) ? $row["userEmail"] : '';
      $program = isset($row["program"]) ? $row["program"] : '';
      $mentor = isset($row["mentor"]) ? $row["mentor"] : '';
      $motto = isset($row["motto"]) ? $row["motto"] : '';
    }
    ?>
    
    <div class="column">
      <div class="column-left">
        <br>
        <img class="image" src="img/photo.png" alt="Profile Picture"> <!--default profile picture-->
      </div>

      <div class="column-right"> 
        <form id="profile" action="profile_edit_action.php" method="post">
          <table id="profile_table" width="80%">
          <tr>
            <td class="coloring" width="164">Name</td>
            <td><input type="text" name="username" size="20" value="<?=$username?>"></td>
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
            <td><select size="1" name="program">
            <option value="" <?php echo ($program == '') ? 'selected' : ''; ?> disabled >Select Program</option>  
            <option <?php echo ($program == 'Software Engineering') ? 'selected' : ''; ?>>Software Engineering</option>
            <option <?php echo ($program == 'Network Engineering') ? 'selected' : ''; ?>>Network Engineering</option>
            <option <?php echo ($program == 'Data Science') ? 'selected' : ''; ?>>Data Science</option>
            </select></td>
          </tr>
          <tr>
            <td class="coloring" width="164">Mentor Name</td>
            <td><input type="text" name="mentor" size="20" value="<?=$mentor?>"></td>
          </tr>
          <tr>
            <td colspan="2"><br>
            My Study Motto: 
            <textarea rows="2" name="motto" style="width:98%"><?=$motto?></textarea>
            </td>
          </tr>
          </table>
        <div style="text-align: right; padding-bottom:5px;">
          <input type="submit" value="Update"> <input type="reset" value="Reset">
        </div>
        </form>
      </div>
    </div>

  <footer class="footer">
    <p>Copyright (c) 2023 - Carl Brandon Valentine -BI21160464-</p>
  </footer>
</body>
</html>
