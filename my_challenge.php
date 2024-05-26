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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Challenge and Plan</title>


    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header_challenge {
            position: relative;
            height: 450px;
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

</head>

<body>
  <div class="header_challenge">
  <video autoplay muted loop>
            <source src="img/challenge.mp4" type="video/mp4"> <!-- Adjust the path to your video file -->
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
   
   <br>

   <!--Search bar and button-->
   <div style="padding:0 10px;">
    <div style="text-align: right; padding: 10px;">
      <form action="my_challenge_search.php" method="post">
          <input type="text" placeholder="Search.." name="search">
          <input type="submit" value="Search">
      </form>
    </div>

    <!--Table for displaying the submitted data-->
    <h3 align="center">List of challenges</h3>
    <table border="1" width="100%" id="challengetable">
        <tr>
            <th width="5%">No</th>
            <th width="10%">Sem & Year</th>
            <th width="30%">Challenge</th>
            <th width="30%">Plan</th>
            <th width="15%">Remark</th>
            <th width="10%">Photo</th>
            <th width="10%" colspan="2">Action</th>
        </tr>
          <!--retrieve data from database-->
          <?php
            $sql = "SELECT * FROM challenge WHERE userID=" . $_SESSION["UID"];
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
              //Output data of each rows
              $numrow = 1;
              while($row = mysqli_fetch_assoc($result)){
                  echo "<tr>";
                  echo "<td>" . $numrow . "</td>
                  <td>". $row["sem"] . " " . $row["year"]. "</td>
                  <td>" . $row["challenge"] . "</td>
                  <td>" . $row["plan"] . "</td>
                  <td>" . $row["remark"] . "</td>
                  <td>" . $row["img_path"] . "</td>";

                  //edit and delete
                  echo '<td> <a href="my_challenge_edit.php?id=' . $row["ch_id"] . '">Edit</a>&nbsp;|&nbsp;';
                  echo '<a href="my_challenge_delete.php?id=' . $row["ch_id"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                  echo "</tr>" . "\n\t\t";
                  $numrow++;
                }
            } else {
                echo '<tr><td colspan="7">0 results</td></tr>';
            }

            mysqli_close($conn);
          ?>
    </table>
    
  <!--ADD NEW button will show the form-->
    <?php
      if(isset($_SESSION["UID"])){
    ?>
      <div style="text-align: right; padding-top:10px;">
        <input type="button" value="Add New" onclick="show_AddEntry()">
      </div>

    <?php
    }
    ?>
</div>

<!--This is the form-->
  <div style="padding: 0 10px;" id="challengeDiv">
    <h3 align="center">Add Challenge and Plan</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="my_challenge_action.php" enctype="multipart/form-data" id="myForm">
      <table border="1" id="myTable">
        <tr>
          <td>Semester*</td>
          <td width="1px">:</td>
          <td>
            <select size="1" id="sem" name="sem" required>
              <option value="">&nbsp;</option>;
              <option value="1">1</option>;
              <option value="2">2</option>;
            </select>
          </td>
        </tr>
        <tr>
            <td>Year*</td>
            <td>:</td>
            <td>
              <input type="text" name="year" size="5" required>
            </td>
        </tr>
        <tr>
            <td>Challenge*</td>
            <td>:</td>
            <td>
              <textarea rows="4" name="challenge" cols="20" required></textarea>
            </td>
        </tr>
        <tr>
            <td>Plan*</td>
            <td>:</td>
            <td>
              <textarea rows="4" name="plan" cols="20" required></textarea>
            </td>
        </tr>
        <tr>
            <td>Remark</td>
            <td>:</td>
            <td>
              <textarea rows="4" name="remark" cols="20"></textarea>
            </td>
        </tr>
        <tr>
            <td>Upload Photo</td>
            <td>:</td>
            <td> Max size: 488.28KB<br>
              <input type="file" name="filetoUpload" id="filetoUpload" accept=".jpg, .jpeg, png">
            </td>
        </tr>
        <tr>
            <td colspan="3" align="right">
              <input type="submit" value="Submit" name="B1">
              <input type="reset" value="Reset" name="B2">
            </td>
        </tr>
      </table>
    </form>
  </div>

  <div class="emptyspace"></div>
  
<p></p>

<footer class="footer">
  <p>Copyright (c) 2023 - Carl Brandon Valentine -BI21160464-</p>
</footer>


<script>
//For responsive sandwich menu
function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
      x.className += " responsive";
    } else {
      x.className = "topnav";
    }
}

function show_AddEntry() { 
    var x = document.getElementById("challengeDiv");
    x.style.display = 'block';
    var firstField = document.getElementById('sem');
    firstField.focus();
}
</script>
</body>
</html>
