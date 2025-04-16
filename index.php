<?php
include 'session.php';
if(isset($_GET['q'])){
  $task_number = (int)$_GET['q'];
}
else{
  $task_number = 6;
}

switch($task_number){
   case 1:
    include 'task1.php';
    break;
   case 2:
    include 'task2.php';
    break;
   case 3:
    include 'task3.php';
    break;
   case 4:
    include 'task4.php';
    break;
   case 5:
    include 'task5.php';
    break;
   case 6:
    include 'task6.php';
    break;
   default:
    echo "Invalid task value entered.";
}
?>
