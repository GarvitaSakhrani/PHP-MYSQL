<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
class form{
  public $fname, $lname , $result, $contact, $email = "";
  public $fnameErr, $lnameErr ,$contactErr, $imageErr, $emailErr = "";
  public $image_path="";
  public $marks =[];
  public $validemail ="";
  public $filename="";
  public $content="";
  public $Filedir ="./files";
  // function to check obtained values
  public function validate(){
    // First Name validation
    if (empty($_POST["fname"])) {
      $this->fnameErr = "First Name is required.";
    } 
    else {
      $this->fname = $this->test_data($_POST["fname"]);
      if (!preg_match("/^[a-zA-Z ]*$/", $this->fname)) {
      $this->fnameErr = "Only alphabets are allowed for First Name.";
      }
    }
    
    // Last Name validation
    if (empty($_POST["lname"])) {
      $this->lnameErr = "Last Name is required.";
    } 
    else {
      $this->lname = $this->test_data($_POST["lname"]);
      if (!preg_match("/^[a-zA-Z ]*$/", $this->lname)) {
          $this->lnameErr = "Only alphabets are allowed for Last Name.";
      }
    }
    $this->content.= $this->fnameErr;
    $this->content.= $this->lnameErr;

  }
  // function to refine the input values
  public function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  // function to validate image
  public function imgcheck(){
    if(!isset($_FILES['image'])){
      $this->imageErr = "Upload an image.";
    }
    else{
      $image_dir = "./uploads";
      $image_file = $image_dir . "/" . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
      $extensions = array("jpeg","jpg","png","gif"); 
      
      if(!in_array($imageFileType, $extensions)) {      
        $this->imageErr = "File type not supported.";
        return;
      }
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_file)) {
        $imageData = base64_encode(file_get_contents($image_file));
        $this->image_path = 'data:image/' . $imageFileType . ';base64,' . $imageData;
      } 
      else {
          $this->imageErr = "Sorry, there was an error uploading your file.";
      }
    }
    $this->content.=$this->imageErr;
  }
  // function to validate entered subject and marks
  public function resultcheck(){
    $this->result = $_POST["result"];
    $lines=explode("\n",$this->result);
    foreach($lines as $x){
      $x= trim($x);
      if(!empty($x)){
        $item = explode("|",$x);
        if(count($item)==2 && is_numeric($item[1])){
          $this->marks[] = ["subject"=>trim($item[0]), "mark"=>trim($item[1])];
        }
      }
    }
  }
  // function to validate contact number
  public function numbercheck(){
    if (empty($_POST["contact"])) {
      $this->contactErr = "Contact Number is required.";
    } else {
      $this->contact = $this-> test_data($_POST["contact"]);
      if (!preg_match('/^(\+91)[6-9]\d{9}$/', $this->contact)) {
        $this->contactErr = "Only Numeric 10 digit number is allowed";
      }
    }
    $this->content.=$this->contactErr;
  }

  // function to validate email address
  public function emailcheck(){
    if(empty($_POST["email"])){
      $this->emailErr = "Email Id is required.";
    }
    else{
      $this->email = $this->test_data($_POST["email"]);
      if(!preg_match("/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/",$this->email)){
        $this->emailErr = "Please enter correct email address.";
      }
      else{
        // API Access Key
        $access_key = '2ba2666ced6f9df40d4ecf002b34e212';

        //email address to check
        $email_address = $this->email;

        // Initialize CURL
        $ch = curl_init('http://apilayer.net/api/bulk_check?access_key='.$access_key.'&email='.$email_address.'');  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $validationResult = json_decode($json, true);
       
        //Condition to check if mail address is available
        if($validationResult['mx_found']){
         echo "Email registered successfully.";
        }
        else{
         $this->emailErr = "Enter valid email.";
       }
      }
    }
    $this->content.=$this->emailErr;
  }

  // function to collect data to display within file
  public function output(){
    if (!empty($this->fname) && !empty($this->lname) && empty($this->fnameErr) && empty($this->lnameErr)) {
      $this->content.= "<h1>Hello, $this->fname " . "$this->lname</h1>\n";
    }
    if(!empty($this->image_path)){
      $this->content.= "<img width=\"600\" height=\"600\" src =\"$this->image_path\" alt =\"Uploaded Image by user\" title=\"Image\">\n";
    }
    if(!empty($this->marks)){
      $this->content.= "<table border=1>" ;
      $this->content.= "<tr><th>Subject</th><th>Marks</th></tr>\n";
      foreach($this->marks as $a){
        $this->content.= "<tr>";
        $this->content.= "<td>" . $a['subject'] . "</td>";
        $this->content.= "<td>" . $a['mark'] . "</td>";
        $this->content.= "</tr>\n";
      }
      $this->content.= "</table>\n";
    }
    if(!empty($this->contact) && empty($this->contactErr)){
      $this->content.= "<h3>Contact Details:" . $this->contact . ".</h3>\n";
    }
    if(!empty($this->email) && empty($this->emailErr)){
      $this->content.= "<h3>Email Details:" . $this->email . ".</h3>\n";
    }
 
  }
  //function to convert html data into pdf
  public function pdfConvertor(){
    $dompdf = new Dompdf();
    $dompdf->loadHtml($this->content);
    $dompdf->setPaper('A4', 'Portrait');
    $dompdf->render();
    $output = $dompdf->output();
    $filename = $this->fname . "_" . $this->lname . "_data.pdf";
    $filepath = $this->Filedir . "/" . $filename;
    file_put_contents($filepath, $output);
    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $output;
  }
}
// Creates object when the form is submitted successfully.
if($_SERVER["REQUEST_METHOD"] === "POST") {
  $input = new form();
  $q = isset($_GET["q"]) ? $_GET["q"] : null;
  // switch case statement for calling functions based on the task number entered.
  switch($q){
    case 1:
      $input->validate();
      break;
    case 2:
      $input->validate();
      $input->imgcheck();
      break;
    case 3:
      $input->validate();
      $input->imgcheck();
      $input->resultcheck();
      break;
    case 4:
      $input->validate();
      $input->imgcheck();
      $input->resultcheck();
      $input->numbercheck();
      break;
    case 5:
      $input->validate();
      $input->imgcheck();
      $input->resultcheck();
      $input->numbercheck();
      $input->emailcheck();
      break;
    case 6:
      $input->validate();
      $input->imgcheck();
      $input->resultcheck();
      $input->numbercheck();
      $input->emailcheck();
      $input->output();
      $input->pdfConvertor();
      break;
    default:
      echo "Invalid Input";
  }
  echo $input->content;
}
?>
