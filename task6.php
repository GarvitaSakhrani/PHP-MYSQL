<!-- Added validation script to authenticate user -->
<?php include 'session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form</title>
  <!-- link for embedding jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="./js/index.js"></script>
  <!-- css to display error message -->
  <style>
    .error {color: #FF0000;}
  </style>
</head>
<body>
<!-- embedding php script for checking the validity of form -->
<?php require 'form-validation.php';?>
<!-- Form to input First Name, Last Name and display Full Name -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?q=6";?>" enctype="multipart/form-data">
  <label for="fname">First Name:</label>
  <input type="text" id="fname" name="fname">
  <span class="error">* <?php echo $input->fnameErr;?></span>
  <br><br>
  <label for="lname">Last Name:</label>
  <input type="text" id="lname" name="lname">
  <span class="error">* <?php echo $input->lnameErr;?></span>
  <br><br>
  <label for="fullname">Full Name:</label>
  <input type="text" id="fullname" name="fullname" readonly>
  <br><br>
  <label for="image">Choose Image:</label>
  <input type="file" name="image" id="image">
  <span class="error">* <?php echo $input->imageErr;?></span>
  <br><br>
  <label for="result">Enter Marks(Please enter in the format subject|marks, one perline):</label><br>
  <textarea name="result" rows="5" cols="20"></textarea>
  <br><br>
  <label for="contact">Contact Number(Enter number followed by country code):</label>
  <input type="text" name="contact">
  <span class="error">* <?php echo $input->contactErr;?></span>
  <br><br>
  <label for="email">Email:</label>
  <input type="text" name="email">
  <span class="error">* <?php echo $input->emailErr;?></span>
  <br><br>
  <input type="submit" value="Submit">
  <br>
</form>
<!-- Added links to move from one page to another -->
<div class="navigation">
  <a href="index.php?q=1">Task 1</a>
  <a href="index.php?q=2">Task 2</a>
  <a href="index.php?q=3">Task 3</a>
  <a href="index.php?q=4">Task 4</a>
  <a href="index.php?q=5">Task 5</a>
  <a href="index.php?q=6">Task 6</a>
</div>
<br>
<!-- Logout Button -->
<a class = "btn" href = "./logout.php">Log Out</a>
</body>
</html>
