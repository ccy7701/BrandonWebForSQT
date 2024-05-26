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
  <title>My KPI Indicator</title>

  <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header_indicator {
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
  <div class="header_indicator">
  <video autoplay muted loop>
            <source src="img/kpindicator.mp4" type="video/mp4"> <!-- Adjust the path to your video file -->
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

  <!--Table for displaying the submitted data-->
<div style="padding: 0 100px;">
<table border="1" id="kpitable">  
    <tr>
      <th>No.</th>
      <th>Sem</th>
      <th>Year</th>
      <th>Student Aim</th>
      <th>CGPA</th>
      <th>Total Activity Student Participated</th>
      <th>Total Competition Student Participated</th>
      <th>Leadership</th>
      <th>Graduate Aim</th>
      <th>Professional Certification</th>
      <th>Employability</th>
      <th>Mobility Program</th>
      <th>Action</th>
    </tr>
      <!--Fetch data from the database-->
      <?php
        $sql = "SELECT * FROM kpi_indicator WHERE userID=" . $_SESSION["UID"];
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          // Output data of each row
          $numrow = 1;
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $numrow . "</td>
              <td>" . $row["sem"] . "</td>
              <td>" . $row["year"] . "</td>
              <td>" . $row["student_aim"] . "</td>
              <td>" . $row["CGPA"] . "</td>
              <td>" . $row["total_std_activity"] . "</td>
              <td>" . $row["total_std_comp"] . "</td>
              <td>" . $row["leadership"] . "</td>
              <td>" . $row["graduate_aim"] . "</td>
              <td>" . $row["professional_cert"] . "</td>
              <td>" . $row["employability"] . "</td>
              <td>" . $row["mobility_program"] . "</td>
              ";

              // Edit
              echo '<td> <a href="my_kpi_edit.php?id=' . $row["kpi_id"] . '">Edit</a>&nbsp;';
              echo "</tr>" . "\n\t\t";
              $numrow++;
            }
        } else {
            echo '<tr><td colspan="14">0 results</td></tr>';
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

<div class="emptyspace">

  <!--This is the form-->
  <div style="padding: 0 10px;" id=kpiDiv>
  <h3 align="center">Add KPI</h3>
  <p align="center">All field are required*</p>
      
      <form method="POST" action="my_kpi_action.php" enctype="multipart/form-data" id="myForm">
      <table border="1" id="myTable">
        <tr>
          <td>Semester*</td>
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
          <td>
            <select size="1" id="year" name="year" required>
              <option value="">&nbsp;</option>;
              <option value="1">1</option>;
              <option value="2">2</option>;
              <option value="3">3</option>;
              <option value="4">4</option>;
              <option value="4">5</option>;
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="student_aim">Student Aim*</label>
          </td>
          <td>
            <input type="text" id="student_aim" name="student_aim" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="CGPA">CGPA</label>
          </td>
          <td>
            <input type="text" id="CGPA" name="CGPA" required>
          </td>
        </tr>
        <tr>
            <td colspan="2">
              <label><b>STUDENT ACTIVITY AND COMPETITION</b></label>
            </td>
        </tr>
        <tr>
          <td>
            <label for="total_std_activity">Total Activity Participated</label>
          </td>
          <td>
            <input type="text" id="total_std_activity" name="total_std_activity" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="total_std_comp">Total Competition Participated</label>
          </td>
          <td>
            <input type="text" id="total_std_comp" name="total_std_comp" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="leadership">Leadership</label>
          </td>
          <td>
            <input type="text" id="leadership" name="leadership" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="graduate_aim">Graduate Aim</label>
          </td>
          <td>
            <select size="1" id="graduate_aim" name="graduate_aim" required>
              <option value="">&nbsp;</option>;
              <option value="ON TIME">ON TIME</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="professional_cert">Professional Certification</label>
          </td>
          <td>
            <input type="text" id="professional_cert" name="professional_cert" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="employability">Employability<br></label>
          </td>
          <td>
            <input type="text" id="employability" name="employability" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="mobility_program">Mobility Program</label>
          </td>
          <td>
          <input type="text" id="mobility_program" name="mobility_program" required>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="SUBMIT" name="B1">
            <input type="submit" value="RESET" name="B1">
          </td>
        </tr>
  </form>
  </table>
  </div>

    <div class="emptyspace"></div>
    <div class="emptyspace"></div>

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
    var x = document.getElementById("kpiDiv");
    x.style.display = 'block';
    var firstField = document.getElementById('sem'); //first input
    firstField.focus();
}
</script>
</body>
</html>
