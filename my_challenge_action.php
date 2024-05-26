<?php
session_start();
include("config.php");

// Function to insert data into the database table
function insertTo_DBTable($conn, $sql)
{
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        echo "Error: " . $sql . " : " . mysqli_error($conn) . "<br>";
        return false;
    }
}

// Variables
$action = "";
$id = "";
$sem = "";
$year = "";
$challenge = "";
$remark = "";

// For upload
$target_dir = "uploads/";
$target_file = "";
$uploadOk = 0;
$imageFileType = "";
$uploadfileName = "";

// This block is called when the Submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['UID'])) {
    // Values for add or edit
    $sem = mysqli_real_escape_string($conn, $_POST["sem"]);
    $year = mysqli_real_escape_string($conn, $_POST["year"]);
    $challenge = trim(mysqli_real_escape_string($conn, $_POST["challenge"]));
    $plan = trim(mysqli_real_escape_string($conn, $_POST["plan"]));
    $remark = trim(mysqli_real_escape_string($conn, $_POST["remark"]));

    $filetmp = $_FILES["filetoUpload"];
    // File of the image/photo file
    $uploadfileName = $filetmp["name"];

    // Check if there is an image to be uploaded
    // If no image
    if (isset($_FILES["filetoUpload"]) && $_FILES["filetoUpload"]["name"] == "") {
        $sql = "INSERT INTO challenge (userID, sem, year, challenge, plan, remark, img_path) VALUES (" . $_SESSION["UID"] . ", " . $sem . ", '" . $year . "', '" . $challenge . "','" . $plan . "', '" . $remark . "', '" . $uploadfileName . "')";
        $status = insertTo_DBTable($conn, $sql);

        if ($status) {
            echo "Form data saved successfully!<br>";
            echo '<a href="my_challenge.php">Back</a>';
        } else {
            echo '<a href="my_challenge.php">Back</a>';
        }
    }

    // If there is an image
    else if (isset($_FILES["filetoUpload"]) && $_FILES["filetoUpload"]["error"] == UPLOAD_ERR_OK) {
        // Variable to determine if image upload is OK
        $uploadOk = 1;
        $filetmp = $_FILES["filetoUpload"];

        // File of the image/photo file
        $uploadfileName = $filetmp["name"];

        $target_file = $target_dir . basename($_FILES["filetoUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "ERROR: Sorry, image file $uploadfileName already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size <= 488.28KB or 500000 bytes
        if ($_FILES["filetoUpload"]["size"] > 500000) {
            echo "ERROR: Sorry, your file is too large. Try resizing your image.<br>";
            $uploadOk = 0;
        }

        // Allow only these file formats
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFileTypes)) {
            echo "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        // If uploadOk, then try to add to the database first
        // uploadOk = 1 if there is an image to be uploaded, file size is ok, and format ok
        if ($uploadOk) {
            // Ensure the upload directory exists
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Move uploaded file to the target directory
            if (move_uploaded_file($_FILES["filetoUpload"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO challenge (userID, sem, year, challenge, plan, remark, img_path) VALUES (" . $_SESSION["UID"] . ", " . $sem . ", '" . $year . "', '" . $challenge . "','" . $plan . "', '" . $remark . "', '" . $uploadfileName . "')";

                $status = insertTo_DBTable($conn, $sql);

                if ($status) {
                    echo "Form data saved successfully!<br>";
                    echo '<a href="my_challenge.php">Back</a>';
                } else {
                    echo "Sorry, there was an error updating your data.<br>";
                    echo '<a href="javascript:history.back()">Back</a>';
                }
            } else {
                echo "Sorry, there was an error uploading your file.<br>";
                echo '<a href="javascript:history.back()">Back</a>';
            }
        } else {
            echo '<a href="javascript:history.back()">Back</a>';
        }
    } else {
        echo '<a href="javascript:history.back()">Back</a>';
    }
}

// Close the db connection
mysqli_close($conn);

?>
