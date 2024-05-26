<?php
session_start();
include("config.php");

// Check if logged-in
if (!isset($_SESSION["UID"])) {
    header("location:index.php");
}

// Initialize variables
$sem = $_POST["sem"] ?? "";
$year = $_POST["year"] ?? "";
$student_aim = $_POST["student_aim"] ?? "";
$cgpa = $_POST["CGPA"] ?? "";
$total_std_activity = $_POST["total_std_activity"] ?? "";
$total_std_comp = $_POST["total_std_comp"] ?? "";
$leadership = $_POST["leadership"] ?? "";
$graduate_aim = trim($_POST["graduate_aim"] ?? "");
$professional_cert = $_POST["professional_cert"] ?? "";
$employability = $_POST["employability"] ?? "";
$mobility_program = $_POST["mobility_program"] ?? "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
  if (
    !isset($sem) || 
    !isset($year) || 
    !isset($student_aim) || 
    !isset($cgpa) || 
    !isset($total_std_activity) || 
    !isset($total_std_comp) || 
    !isset($leadership) || 
    !isset($graduate_aim) || 
    !isset($professional_cert) || 
    !isset($employability) || 
    !isset($mobility_program) || 
    ($sem === "") || 
    ($year === "") || 
    ($student_aim === "") || 
    ($cgpa === "") || 
    ($total_std_activity === "") || 
    ($total_std_comp === "") || 
    ($leadership === "") || 
    ($graduate_aim === "") || 
    ($professional_cert === "") || 
    ($employability === "") || 
    ($mobility_program === "")
  ) {
      echo '<a href="my_kpi.php">Back</a>';
    } else {
        // Insert data into kpi_indicator table using prepared statement
        $sql = "INSERT INTO kpi_indicator (userID, sem, year, student_aim, CGPA, total_std_activity, total_std_comp, leadership, graduate_aim, professional_cert, employability, mobility_program) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("Prepared statement error: " . mysqli_error($conn));
        }

        // Bind parameters in the correct order
        mysqli_stmt_bind_param($stmt, "isssdddsdddi", $_SESSION["UID"], $sem, $year, $student_aim, $cgpa, $total_std_activity, $total_std_comp, $leadership, $graduate_aim, $professional_cert, $employability, $mobility_program);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo "Form data inserted successfully!<br>";
            echo '<a href="my_kpi.php">Back</a>';
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            die("Error executing statement: " . mysqli_error($conn));
        }
    }
}
?>
