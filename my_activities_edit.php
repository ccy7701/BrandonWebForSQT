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
    <title>Activities</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
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

<body onLoad="show_AddEntry()">
    <div class="header_activity">
    <video autoplay muted loop>
            <source src="img/activities.mp4" type="video/mp4"> <!-- Adjust the path to your video file -->
            Your browser does not support the video tag.
        </video>
    </div>

    <?php
    if (isset($_SESSION["UID"])) {
        include 'menu.php';
    } else {
        include 'logged_menu.php';
    }
    ?>

    <?php
    $id = "";
    $sem = "";
    $year = "";
    $activities = "";
    $remark = "";
    $userID = $_SESSION["UID"];

    if (isset($_GET["id"]) && $_GET["id"] != "") {
        $sql = "SELECT * FROM activity WHERE activity_id = " . $_GET["id"] . " AND activity_id = " . $_GET["id"];
        //echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = $row["activity_id"];
            $sem = $row["sem"];
            $year = $row["year"];
            $activities = $row["activities"];
            $remark = $row["remark"];
        }
    }
    mysqli_close($conn);
?>

    <!--This is the form-->
    <div style="padding: 0 10px;" id="activityDiv">
        <h3 align="center">Edit Activities</h3>
        <p align="center">Required field with mark*</p>

        <form method="POST" action="my_activities_edit_action.php" id="myForm" enctype="multipart/form-data">
            <!--hidden value: id to be submitted to action page-->
            <input type="hidden" id="cid" name="cid" value="<?=$_GET['id'];?>">
            <table border="1" id="myTable">
                <tr>
                    <td>Semester*</td>
                    <td width="1px">:</td>
                    <td>
                        <select size="1" name="sem" required>
                            <option value="">&nbsp;</option>
                            <?php
                            if($sem=="1")
                                echo '<option value="1" selected>1</option>';
                            else
                                echo '<option value="1">1</option>';
                            
                            if($sem=="2")
                                echo '<option value="2" selected>2</option>';
                            else
                                echo '<option value="2">2</option>';
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Year*</td>
                    <td>:</td>
                    <td>
                        <input type="text" name="year" size="5" value="<?php echo $year; ?>" required>
                    </td>
                </tr>
                <tr>
                    <td>Name of activities/competition/club*</td>
                    <td>:</td>
                    <td>
                        <textarea rows="4" name="activities" cols="20" required><?php echo $activities; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Remark</td>
                    <td>:</td>
                    <td>
                        <textarea rows="4" name="remark" cols="20"><?php echo $remark; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="right">
                        <input type="submit" value="Submit" name="B1">
                        <input type="button" value="Reset" name="B2" onclick="resetForm()">
                        <input type="button" value="Clear" name="B3" onclick="clearForm()">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <p></p>

    <div class="emptyspace">

    <footer class="footer">
        <p>Copyright (c) 2023 - Carl Brandon Valentine -BI21160464-</p>
    </footer>

    <script>
        // For responsive sandwich menu
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

        // this clear form to empty the form for new data
        function clearForm() {
            var form = document.getElementById("myForm");
            if (form) {
                var inputs = form.getElementsByTagName("input");
                var textareas = form.getElementsByTagName("textarea");

                // clear select
                form.getElementsByTagName("select")[0].selectedIndex = 0;

                // clear all inputs
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type !== "button" && inputs[i].type !== "submit" && inputs[i].type !== "reset") {
                        inputs[i].value = "";
                    }
                }

                // clear all textareas
                for (var i = 0; i < textareas.length; i++) {
                    textareas[i].value = "";
                }
            } else {
                console.error("Form not found");
            }
        }

        function show_AddEntry() {
            var x = document.getElementById("activityDiv");
            x.style.display = 'block';
            var firstField = document.getElementById('sem');
            firstField.focus();
        }
    </script>
</body>
</html>
