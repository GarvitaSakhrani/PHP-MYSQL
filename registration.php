<?php 
require 'dataInput.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $new_user = new Data();
  $fname = trim($_POST['fname']);
  $lname = trim($_POST['lname']);
  $email = trim($_POST['email']);
  $contact = trim($_POST['contact']);
  $user_password = trim($_POST['password']);
  if($stmt = $new_user->con->prepare("SELECT * FROM user WHERE email = ?" )){
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows > 0){
      echo '<p class = "error"> This email address is already registered.</p>';
      $stmt->close();
      return;
    }
    else{
      $sql = $new_user->con->prepare("INSERT INTO user(fname, lname, email, contact, user_password) VALUES(?, ?, ?, ?, ?)");
      $sql->bind_param('sssss', $fname, $lname, $email, $contact, $user_password);
      if($sql->execute()){
        echo '<p class="success">User registered successfully.</p>';
      }
      else{
        echo '<p class="error">Error occured during registration.</p>';
      }
      $sql->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>Registration</title>
</head>
<body>
  <div class="container">
   <h1>Registration Form</h1>
   <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for = "fname">First Name</label><br>
    <input type = "text" name="fname" id = "fname" required>
    <br><br>
    <label for = "lname">Last Name</label><br>
    <input type = "text" name = "lname" id = "lname">
    <br><br>
    <label for = "email">Email</label><br>
    <input type = "email" name = "email" id = "email">
    <br><br>
    <label for = "contact">Contact Number</label><br>
    <input type = "tel" name = "contact" id = "contact">
    <br><br>
    <label for = "password">Password</label><br>
    <input type = "password" name = "password" id = "password">
    <br><br>
    <input type = "submit" value="submit">
    <br><br>
   </form>
  <div class="wrapper">
      <p>Already have an account.</p>
      <a href = "./login.php">Login Here</a>
  </div>
  </div>
</body>
</html>
