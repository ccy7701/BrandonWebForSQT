<?php
  session_start();
  include("config.php");
?>

<html>
<head>
  <title>Login Action</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="mystyle.css" media="screen" />
</head>

<body>
<h2>Login Information</h2>
<?php
//login values from login form
$userName = $_POST['userName'];
$userPwd = $_POST['userPwd'];

$sql = "SELECT * FROM user WHERE matricNo='$userName' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  //check password hash
  $row = mysqli_fetch_assoc($result);
  if (password_verify($_POST['userPwd'],$row['userPwd'])) {
    $_SESSION["UID"] = $row["userID"];//the first record set, bind to userID
    $_SESSION["userName"] = $row["matricNo"];

    //set logged in time
    $_SESSION['loggedin_time'] = time();
    header("location:profile.php");
  } else {
      echo 'Login error, user email and password is incorrect.<br>';//user email & pwd not correct
      echo '<a href="index.php?login=1"> | Login |</a> &nbsp;&nbsp;&nbsp; <br>';
  }
} else {
    echo "Login error, user <b>$userName</b> does not exist. <br>";//user not exist
    echo '<a href="index.php?login=1"> | Login |</a>&nbsp;&nbsp;&nbsp; <br>';
}

mysqli_close($conn);
?>
</body>
</html>
