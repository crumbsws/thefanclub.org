

<?php

include('./modules/header.php');
include('./utils/Mail.php');

?>

<div class='view_box' >
  <h2>
<?php

if(isset($_GET['ref']) && $_GET['ref'] == 'invite') {

    echo 'You have been invited to Fanclub.';

} else {

    echo 'Receive your daily dose of humor.';
    }
?>

  </h2>
<p>Delivered to your doorstep (mailbox) daily.</p>
<form action="./index.php" method="POST">
<input type="email" placeholder='kirk@enterprise.com' name="mail"></input>
<input type="submit" value='Subscribe'></input>
<?php
include('./utils/DBConnector.php');

if(isset($_GET['subscribed']) && $_GET['subscribed'] == 'true') {

    echo '<p>Confirmation is sent!</p>';

}

if(isset($_POST['mail'])) {

  $mail = $_POST['mail'];
  $validator = rand(59999, 99999);
  $stmt = $conn->prepare("INSERT IGNORE INTO mails (mail, validator, status) VALUES (?, ?, 'pending')");
  $stmt->bind_param("si", $mail, $validator);
  $stmt->execute();
  $stmt->close();
  $conn->close();
  $subject = "Validation Link";
  $body = $_SERVER['HTTP_HOST'] . '/validate.php?validator=' . $validator;


  sendMail($subject, $body, $mail);

  header("Location: ./index.php?subscribed=true");
  exit;
}

?>
<img src="./images/dan_transparent.png" alt="Dan putting the mail in the box"></img>
</form>
</div>
<?php
include('./modules/footer.php');
?>
