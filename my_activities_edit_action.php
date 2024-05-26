<?php
session_start();
include("config.php");

// Variables
$action = "";
$id = "";
$sem = "";
$year = "";
$activities = "";
$remark = "";

// This block is called when the submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Values for add or edit
    $id = $_POST["cid"];
    $sem = $_POST["sem"];
    $year = $_POST["year"];
    $activities = trim($_POST["activities"]);
    $remark = trim($_POST["remark"]);
    $userID = trim($_SESSION["UID"]);

    // Update the value in the activity table using prepared statement
    $sql = "UPDATE activity SET sem = ?, year = ?, activities = ?, remark = ? WHERE activity_id = ? AND userID = ?";
    
    // Check if statement is prepared successfully
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Error in preparing statement: " . mysqli_error($conn));
    }

   // Bind parameters and execute
    mysqli_stmt_bind_param($stmt, "ssssii", $sem, $year, $activities, $remark, $id, $_SESSION["UID"]);
    if (mysqli_stmt_execute($stmt)) {
        echo "Form data updated successfully!<br>";
        echo '<a href="my_activities.php">Back</a>';
    } else {
        echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
        echo '<a href="my_activities.php">Back</a>';
    }
}

mysqli_close($conn);

// Function to insert data to the database table
function update_DBTable($stmt){
    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        echo "Error updating data: " . mysqli_stmt_error($stmt) . "<br>";
        return false;
    }
}
?>
