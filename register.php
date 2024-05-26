<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,  initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  	<title>Register user</title>
  </head>
  <body>
    <div class="header">
    </div>

    <?php include 'logged_menu.php';?>

  <style>
    form {
      
        padding: 50px;
        border-radius: 8px;
        width: 280px; /* Adjust width as needed */
        margin: 0 auto; /* This will center the form */
      }

      label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
      }

      input[type="text"],
      input[type="password"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px; 
      }

      input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box; 
      }

      input[type="submit"],
      input[type="reset"],
      input[type="button"] {
        width: 100%;
        padding: 8px 5px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
        --margin-top: 10px;
      }

      input[type="submit"] {
        background-color: #000000;
        color: #fff;
      }

      input[type="reset"] {
        background-color: #FF0000;
        color: #fff;
      }

      input[type="button"] {
        background-color: #FFFF00;
        color: #fff;
      }

     
      input[type="submit"]:hover,
      input[type="reset"]:hover,
      input[type="button"]:hover {
        opacity: 0.9;
      }
  </style>

    <form class="" action="register_action.php" method="post" autocomplete="off">
      <label for="matricNo">MATRIC NO:</label>
      <input type="text" name="matricNo" id="matricNo" required>
      <label for="userEmail">EMAIL:</label>
      <input type="email" id="userEmail" name="userEmail" required><br><br>
      <label for="userPwd">PASSWORD:</label>
      <input type="password" id="userPwd" name="userPwd" required maxlength="8"><br><br>
      <label for="userPwd">CONFIRM PASSWORD:</label>
      <input type="password" id="confirmPwd" name="confirmPwd" required><br><br>
      <input type="submit" value="Register" style="cursor: pointer;">
      <input type="reset" value="Reset">
      <input type="reset" value="Cancel" onClick="redirectIndex()">
    </form>

    <script>
      function redirectIndex() {
        window.location.href = "index.php";
      }
    </script>

  </body>
</html>
