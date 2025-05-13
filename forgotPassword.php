<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="./css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./js/index.js"></script>
</head>
<body>
  <div class="container">
   <h2 class="heading">Forgot Password</h2>
   <form id="form" method ="Post" action="sendEmail.php">
    <label for = "email">Email</label><br>
    <input type = "email" name = "email" id = "email">
    <br><br>
    <input type = "submit" value = "submit">
   </form>
  </div>
</body>
</html>
