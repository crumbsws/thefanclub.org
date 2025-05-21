<?php
include('./modules/header.php');
include('./utils/Mail.php');
include('./utils/CallAPI.php');

$answer = callAPI();
$stmt = $conn->prepare("SELECT mail FROM mails");
$stmt->execute();
$result = $stmt->get_result();
foreach ($result as $result => $mail) {
  $subject = "The Fanclub - Your Daily Mail";
  $body = $answer;


  sendMail($subject, $body, $mail);
}


?>
