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
	  <title>Activities</title>

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header_activity {
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
</head>

<body>
    <div class="header_activity">
    <video autoplay muted loop>
            <source src="img/activities.mp4" type="video/mp4"> <!-- Adjust the path to your video file -->
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
      <form action="my_activities_search.php" method="post">
          <input type="text" placeholder="Search.." name="search">
          <input type="submit" value="Search">
      </form>
    </div>
        
    <!--Table for displaying the submitted data-->
    <h3 align="center">List of Activities</h3>
    <table border="1" width="100%" id="activitytable">
        <tr>
            <th width="3%">No</th>
            <th width="10%">Sem & Year</th>
            <th width="30%">Name of Activities</th>
            <th width="20%">Remark</th>
            <th width="10%">Action</th>
        </tr>
    
        <!--retrieve data from database-->
        <?php
            $sql = "SELECT * FROM activity WHERE userID=" . $_SESSION["UID"];
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) > 0){
              //Output data of each rows
              $numrow = 1;
              while($row = mysqli_fetch_assoc($result)){
                  echo "<tr>";
                  echo "<td>" . $numrow . "</td><td>". $row["sem"] . " " . $row["year"]. "</td><td>" . $row["activities"] . "</td><td>" . $row["remark"] . "</td>";

                  //edit and delete
                  echo '<td> <a href="my_activities_edit.php?id=' . $row["activity_id"] . '">Edit</a>&nbsp;|&nbsp;';
                  echo '<a href="my_activities_delete.php?id=' . $row["activity_id"] . '" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                  echo "</tr>" . "\n\t\t";
                  $numrow++;
                }
            } else {
                echo '<tr><td colspan="6">0 results</td></tr>';
            }

            mysqli_close($conn);
          ?>
    </table>

    <!--ADD NEW button-->
    <?php
      if(isset($_SESSION["UID"])){
    ?>
        <div style="text-align: right; padding-top:10px;">
            <input type="button" value="Add New" onclick="show_AddEntry()">
        </div>
        
    <?php }
    ?>
</div>

<div class="emptyspace"></div>

<!--This is the form-->
<div style="padding: 0 10px;" id="activityDiv">
    <h3 align="center">Add Activities</h3>
    <p align="center">Required field with mark*</p>

    <form method="POST" action="my_activities_action.php" enctype="multipart/form-data" id="myForm">
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
            <td>Name of activities/competition/club*</td>
            <td>:</td>
            <td>
              <textarea rows="4" name="activities" cols="20" required></textarea>
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
    var x = document.getElementById("activityDiv");
    x.style.display = 'block';
    var firstField = document.getElementById('sem'); //first input
    firstField.focus();
}
</script>

</body>
</html>
