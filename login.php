<?php
session_start();
if(isset($_SESSION['userid']) && $_SESSION['userid'] === true) {
    header("Location: index.php");
    exit();
  }
require 'dataInput.php';
$data = new Data();
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $email = $_POST['email'];
  $password = $_POST['password'];

  if($stmt = $data->con->prepare("SELECT * FROM user WHERE email = ?")) {
     $stmt->bind_param('s', $email);
     $stmt->execute();
     $result = $stmt->get_result();
     if ($result->num_rows >0 ) {
        $row = $result->fetch_assoc();
        if ($password == $row['user_password']) {
          $_SESSION["userid"] = $row['userid'];
          header("location: index.php");
          exit();
        } 
      else {
          echo '<p class="error">The password is not valid.</p>';
        }
    } else {
            echo '<p class="error">No User exist with that email address.</p>';
          }
      }
      $stmt->close();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel = "stylesheet" href = "./css/style.css">
  <title>Login Form</title>
</head>
<body>
  <div class="container">
   <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for = "email">Email</label><br>
    <input type = "email" name = "email" id = "email" required>
    <br><br>
    <label for = "password">Password</label><br>
    <input type = "password" name = "password" id = "password" required>
    <br><br>
    <input type = "submit" value = "submit">
    <br><br>
   </form>
  <div class="wrapper">
      <p>Don't have an account?</p>
      <a href="registration.php">Register Here</a>
  </div>
  <a href="forgotPassword.php">Forgot Password</a>
  </div>
</body>
</html>
