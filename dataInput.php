<?php
class Data{
  private $servername = "localhost";
  private $username = "garvita";
  private $password = "1234";
  private $db = "UsersDatabase";
  public $con;
  public $fname, $lname, $email, $user_password = "";
  public $contact;

  public function __construct(){
    $this->con = new mysqli($this->servername,$this->username,$this->password,$this->db);
    if ($this->con->connect_error) {
      die("Connection failed: " . $this->con->connect_error);
    }
    $this->con->select_db($this->db);
  }
  public function createTable() {
    $sql = "CREATE TABLE IF NOT EXISTS user(
            userid int AUTO_INCREMENT PRIMARY KEY,
            fname varchar(100) NOT NULL,
            lname varchar(100) NOT NULL,
            email varchar(50) NOT NULL UNIQUE KEY,
            contact varchar(13) NOT NULL,
            user_password varchar(100)
            )";
    if($this->con->query($sql) !== true){
       echo "Error creating user table." . $this->con->error;
       return;
    }
  }
  public function insertData(){
    $this->fname = $_POST['fname'];
    $this->lname = $_POST['lname'];
    $this->email = $_POST['email'];
    $this->contact = $_POST['contact'];
    $this->user_password = $_POST['user_password'];
    $sql = "INSERT INTO user(fname, lname, email, contact, user_password) VALUES('" . $this->fname . "','" . $this->lname . "','" . $this->email . "','" . $this->contact ."','" . $this->user_password . "')";
    if ($this->con->query($sql) !== TRUE) {
      echo "Error inserting data: " . $this->con->error;
    }
    else{
      echo "Your registration was successful!";
    }
  }
  public function updateData($email, $user_password){
    $stmt = $this->con->prepare("UPDATE user SET user_password = ? WHERE email = ?");
    $stmt->bind_param("ss", $user_password, $email);

    if (!$stmt->execute()) {
        echo "Error resetting password: " . $stmt->error;
    } else {
        echo "Your password has been reset!";
    }

    $stmt->close();
  }
  public function __destruct(){
    $this->con->close();
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])){
   $user = new Form();
   $user->createTable();
   $user->insertData();
}
?>
