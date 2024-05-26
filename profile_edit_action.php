<?php
session_start();
include('config.php');

// Check if user is logged-in
if (!isset($_SESSION["UID"])) {
    header('Location: index.php');
    exit();
}

// Initialize variables
$username = "";
$program = "";
$mentor = "";
$motto = "";

// Constants for file upload
$target_dir = "uploads/";
$uploadOk = 1;
$uploadFileName = "";

// Function to handle database updates using prepared statements
function update_DBTable($conn, $sql, $params) {
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        if ($params) {
            mysqli_stmt_bind_param($stmt, ...$params);
        }
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    } else {
        return false;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $program = trim($_POST["program"]);
    $mentor = trim($_POST["mentor"]);
    $motto = trim($_POST["motto"]);
    $userID = trim($_SESSION["UID"]);

    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES["fileToUpload"];
        $uploadFileName = basename($fileTmp["name"]);
        $target_file = $target_dir . $uploadFileName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "ERROR: Sorry, image file $uploadFileName already exists.<br>";
            $uploadOk = 0;
        }

        // Check file size <= 488.28KB or 500000 bytes
        if ($fileTmp["size"] > 500000) {
            echo "ERROR: Sorry, your file is too large. Try resizing your image.<br>";
            $uploadOk = 0;
        }

        // Allow only these file formats
        $allowedFormats = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "ERROR: Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
            $uploadOk = 0;
        }

        if ($uploadOk) {
            // Update database with the new data
            $sql = "UPDATE profile
                    SET username = ?,
                        program = ?,
                        mentor = ?,
                        motto = ?,
                        img_path = ?
                    WHERE userID = ?";
            $params = [
                "sssssi",
                $username,
                $program,
                $mentor,
                $motto,
                $uploadFileName,
                $userID
            ];

            if (update_DBTable($conn, $sql, $params)) {
                if (move_uploaded_file($fileTmp["tmp_name"], $target_file)) {
                    echo "Data updated successfully!<br>";
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                }
            } else {
                echo "Error updating the database.<br>";
            }
        }
    } else {
        // Handle the case when no image is uploaded
        $sql = "UPDATE profile
                SET username = ?,
                    program = ?,
                    mentor = ?,
                    motto = ?
                WHERE userID = ?";
        $params = [
            "ssssi",
            $username,
            $program,
            $mentor,
            $motto,
            $userID
        ];

        if (update_DBTable($conn, $sql, $params)) {
            echo "Data updated successfully!<br>";
            echo '<a href="profile.php">Back</a>';
        } else {
            echo "Error updating the database.<br>";
        }
    }
}

// Close database connection
mysqli_close($conn);
?>
