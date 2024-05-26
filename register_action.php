<?php
  include("config.php");
?>

<!DOCTYPE html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
<?php
  //STEP 1: Form data handling using mysqli_real_escape_string function to escape special characters for use in an SQL query,
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userMatric = mysqli_real_escape_string($conn, $_POST['matricNo']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);

    //Validate pwd and confrimPwd
    if ($userPwd !== $confirmPwd) {
      die("Password and confirm password do not match.");
    }

    //STEP 2: Check if userEmail already exist
    $sql = "SELECT * FROM user WHERE userEmail='$userEmail' or matricNo='$userMatric' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
      echo "<p ><b>Error: </b> User exist, please register a new user</p>";
  } else {
    // User does not exist, insert new user record, hash the password
    $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));
    //echo $pwdHash;
    $sql = "INSERT INTO user (matricNo, userEmail, userPwd ) VALUES
    ('$userMatric', '$userEmail', '$pwdHash')";
    $insertOK=0;
    if (mysqli_query($conn, $sql)) {
      echo "<p>New user record created successfully.</p>";
      $insertOK=1;
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    if($insertOK==1){
      $lastInsertedId = mysqli_insert_id($conn);
      $sql = "INSERT INTO profile (userID, username, program, mentor, motto ) VALUES ('$lastInsertedId', '','', '','')";
      if (mysqli_query($conn, $sql)) {
        echo "<p>New user pofile record created successfully. Welcome <b>".$userMatric."</b></p>";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
  }
}
mysqli_close($conn);

?>
  <p><a href="index.php"> | Login |</a></p>
</body>
</html>
