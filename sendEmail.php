<?php
require 'dataInput.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class SendEmail{
  public $mail , $email;
  public function setvalue(){
    $this->email = $_POST['email'];
    $this->mail = new PHPMailer(true); 
  }
  public function settings(){
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $email = $_POST['email'];
      $verify = new Data();
      $stmt = $verify->con->prepare('SELECT * FROM user WHERE email = ?');
      $stmt->bind_param('s',$email);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows>0){
        try {
          //Server settings
          $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
          $this->mail->isSMTP();                                            
          $this->mail->Host       = 'smtp.gmail.com';                     
          $this->mail->SMTPAuth   = true;                                   
          $this->mail->Username   = 'testing3846@gmail.com';                     +
          $this->mail->Password   = 'qekx okbf ityf cwkv';                               
          $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
          $this->mail->Port       = 587;                                    
        
          //Recipients
          $this->mail->setFrom('testing3846@gmail.com', 'Admin');
          $this->mail->addAddress($this->email, 'User');                    
          $this->mail->addReplyTo('testing3846@gmail.com', 'Admin');
      
          //Content
          $this->mail->isHTML(true);                                  
          $this->mail->Subject = 'Password Reset';
          $this->mail->Body    = '<p>Click on the below link to reset your password.</p><br>
                                    <a href="http://PHP-MYSQL.com/resetPassword.php?email=' . $this->email . '">Password Reset Link</a>';
          $this->mail->send();
          echo '<div class="success">Mail has been sent.</div>';
          header('Location: ./login.php');
        } catch (Exception $e) {
          echo '<div class="error">Mail could not be sent. Error:'. $this->mail->ErrorInfo. '</div>';
        }
      }
      else{
        echo '<p class = "error">User not registered.</p>';
        echo '<a href = "./register.php">Register Here.</a>';
        }
    }
  }
}
if($_SERVER["REQUEST_METHOD"] === "POST") {
  if(isset($_POST['email'])){
    $object = new SendEmail();
    $object->setvalue();
    $object->settings();
  }
  else{
    echo '<div class="error">Please provide an Email.</div>';
  }
}
?>
