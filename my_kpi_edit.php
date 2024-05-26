<?php
session_start();
include("config.php");

//check if logged-in
if(!isset($_SESSION["UID"])){
  header("location:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <title>Edit KPI</title>
</head>

<body onLoad="show_AddEntry()">
    <div class="header_indicator"></div>

    <?php
     if(isset($_SESSION["UID"])){
       $userID = $_SESSION["UID"];
       include 'menu.php';
     } else {
       include 'logged_menu.php';
     }
    ?>

<?php
    $id = "";
    $sem = "";
    $year = "";
    $student_aim = "";
    $cgpa = ""; 
    $total_std_activity = "";   
    $total_std_comp = "";  
    $leadership = "";         
    $graduate_aim = "";         
    $professional_cert = "";         
    $employability = "";         
    $mobility_program = "";               
    $userID = $_SESSION["UID"]; 

    if(isset($_GET["id"]) && $_GET["id"] != ""){
      $sql = "SELECT * FROM kpi_indicator WHERE kpi_id = " . $_GET["id"] . " AND kpi_id = " . $_GET["id"];
      //echo $sql . "<br>";
      $result = mysqli_query($conn, $sql);
  
      if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          $id = $row["kpi_id"];
          $sem = $row["sem"];  
          $year = $row["year"];            
          $student_aim = $row["student_aim"];
          $cgpa = $row["CGPA"];
          $total_std_activity = $row["total_std_activity"];
          $total_std_comp = $row["total_std_comp"];
          $leadership = $row["leadership"];
          $graduate_aim = $row["graduate_aim"];
          $professional_cert = $row["professional_cert"];
          $employability = $row["employability"];
          $mobility_program = $row["mobility_program"];
        }
    }
    mysqli_close($conn);
?>

  <!--this is the form-->
  <div style="padding: 0 10px;" id=kpiDiv>
  <h3 align="center">Add your KPI</h3>
  <p align="center">All field are required*</p>
      
      <form method="POST" action="my_kpi_edit_action.php" id="myForm" enctype="multipart/form-data">
      <input type="hidden" id="cid" name="cid" value="<?=$_GET['id'];?>">
      <table border="1" id="myTable">
        <tr>
          <td>Semester*</td>
          <td>
            <select size="1" id="sem" name="sem" required>
              <option value="">&nbsp;</option>;
              <?php
              if($sem == "1")
                  echo '<option value="1" selected>1</option>';
              else 
                  echo '<option value="1">1</option>';
              
              if($sem == "2")
                  echo '<option value="2" selected>2</option>';
              else
                  echo '<option value="2">2</option>';
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>Year*</td>
          <td>
            <select size="1" id="year" name="year" required>
              <option value="">&nbsp;</option>;
              <?php
              if ($year == 1)
                  echo '<option value="1" selected>1</option>';
              else 
                  echo '<option value="1">1</option>';

              if ($year == 2)
                  echo '<option value="2" selected>2</option>';
              else 
                  echo '<option value="2">2</option>';
              
              if ($year == 3)
                  echo '<option value="3" selected>3</option>';
              else 
                  echo '<option value="3">3</option>';

              if ($year == 4)
                  echo '<option value="4" selected>4</option>';
              else 
                  echo '<option value="4">4</option>';

              if ($year == 5)
                  echo '<option value="5" selected>5</option>';
              else 
                  echo '<option value="5">5</option>';
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="student_aim">Student Aim*</label>
          </td>
          <td>
            <input type="text" name="student_aim" value="<?php echo $student_aim; ?>" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="CGPA">CGPA*</label>
          </td>
          <td>
            <input type="text" name="CGPA" value="<?php echo $cgpa; ?>" required>
          </td>
        </tr>
        <tr>
            <td colspan="2">
              <label><b>STUDENT ACTIVITY AND COMPETITION</b></label>
            </td>
        </tr>
        <tr>
          <td>
            <label for="total_std_activity">Total Activity Participated*</label>
          </td>
          <td>
            <input type="text" name="total_std_activity" value="<?php echo $total_std_activity; ?>"required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="total_std_comp">Total Competition Participated*</label>
          </td>
          <td>
            <input type="text" name="total_std_comp" value="<?php echo $total_std_comp; ?>" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="leadership">Leadership*</label>
          </td>
          <td>
            <input type="text" name="leadership" value="<?php echo $leadership; ?>" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="graduate_aim">Graduate Aim*</label>
          </td>
          <td>
            <select size="1" id="graduate_aim" name="graduate_aim" required>
              <option value="">&nbsp;</option>;
              <?php
              if($graduate_aim == "ON TIME")
                  echo '<option value="ON TIME" selected>ON TIME</option>';
              else
                  echo '<option value="ON TIME">ON TIME</option>'
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <label for="professional_cert">Professional Certification*</label>
          </td>
          <td>
            <input type="text" name="professional_cert" value="<?php echo $professional_cert; ?>"required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="employability">Employability*<br></label>
          </td>
          <td>
            <input type="text" name="employability" value="<?php echo $employability; ?>" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="mobility_program">Mobility Program*</label>
          </td>
          <td>
          <input type="text" name="mobility_program" value="<?php echo $mobility_program; ?>" required>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <input type="submit" value="Submit" name="B1">
            <input type="button" value="Reset" name="B2" onclick="resetForm()">
          </td>
        </tr>
  </form>
  </table>

    <div class="emptyspace">
    <div class="emptyspace">

    <footer class="footer">
        <p>Copyright (c) 2023 - Carl Brandon Valentine -BI21160464-</p>
    </footer>

    <script>
    function myFunction() {
      var x = document.getElementById("myTopnav");
      if (x.className === "topnav") {
      x.className += " responsive";
      } else {
      x.className = "topnav";
      }
    }

    // reset form after modification to a php echo to fields
    function resetForm() {
            document.getElementById("myForm").reset();
    }

    // Function to show the kpiDiv element
    function show_AddEntry() { 
        var x = document.getElementById("kpiDiv");
        x.style.display = 'block';
        var firstField = document.getElementById('sem');
        firstField.focus();
    }


</script>
</body>
</html>
