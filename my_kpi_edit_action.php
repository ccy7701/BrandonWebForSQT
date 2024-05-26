<?php
session_start();
include("config.php");

// variables
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
$action = "";

//this block is called when button Submit is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //values for add or edit
    $id = $_POST["cid"];
    $sem = $_POST["sem"];  
    $year = $_POST["year"];            
    $student_aim = $_POST["student_aim"];
    $cgpa = $_POST["CGPA"];
    $total_std_activity = $_POST["total_std_activity"];
    $total_std_comp = $_POST["total_std_comp"];
    $leadership = $_POST["leadership"];
    $graduate_aim = $_POST["graduate_aim"];
    $professional_cert = $_POST["professional_cert"];
    $employability = $_POST["employability"];
    $mobility_program = $_POST["mobility_program"];

    // Update data in the kpi_indicator table
    $sql = "UPDATE kpi_indicator 
            SET sem = ?,
            year = ?,
            student_aim = ?, 
            CGPA = ?, 
            total_std_activity = ?, 
            total_std_comp = ?, 
            leadership = ?, 
            graduate_aim = ?, 
            professional_cert = ?, 
            employability = ?, 
            mobility_program = ? WHERE kpi_id = ? AND userID = ?";

    // Check if statement is prepared successfully
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        echo "Error in preparing statement: " . mysqli_error($conn);
    }

    // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, "iissiiisiiiii", $sem, $year, $student_aim, $cgpa, $total_std_activity, $total_std_comp, $leadership, $graduate_aim, $professional_cert, $employability, $mobility_program, $id, $_SESSION["UID"]);//s for string, i for integer
    if (mysqli_stmt_execute($stmt)) {
        echo "Form data updated successfully!<br>";
        echo '<a href="my_kpi.php">Back</a>';
    } else {
        echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
        echo '<a href="my_kpi.php">Back</a>';
    }
}

//close db connection
mysqli_close($conn);

//Function to insert data to database table
function update_DBTable($stmt){
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
        return false;
    }
}
?>
