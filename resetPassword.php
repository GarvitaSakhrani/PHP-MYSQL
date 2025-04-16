<?php
session_start();
if(isset($_GET['email'])){
  $_SESSION['password_reset_email'] = $_GET['email'];
}
require 'dataInput.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(!isset($_SESSION['password_reset_email'])){
    echo "Session variable not set.";
  }
  else{
    if($_POST['new_password'] === $_POST['confirm_password']){
      $user_password = $_POST['confirm_password'];
      $email = $_SESSION['password_reset_email'];
      $update = new Data();
      $update->updateData($email,$user_password);
      header('Location: ./login.php');
      exit();
    }
    else{
      echo "<p class ='error'>Password entered in both fields do not match.</p>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset</title>
</head>
<body>
  <div class="container">
    <h2>Reset Password</h2>
    <form method = "POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     <label for = "new_password">Enter Password</label><br>
     <input type = "password" name = "new_password" id = "new_password" required>
     <br><br>
     <label for = "confirm_password">Confirm Password</label><br>
     <input type = "password" name = "confirm_password" id = "confirm_password" required>
     <br><br>
     <input type = "submit" value = "submit">
    </form>
  </div>
</body>
</html>
