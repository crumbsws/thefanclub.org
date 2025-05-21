

<?php
include('./utils/DBConnector.php');
include('./modules/header.php');
?>

<div class='view_box' >
  <h2>
    <?php

    if(!empty($_GET['validator'])) {
        $validator = $_GET['validator'];
        $validator = (int) $validator;
        $stmt = $conn->prepare("SELECT mail FROM mails WHERE validator=?");
        $stmt->bind_param("i", $validator);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
          $stmt = $conn->prepare("UPDATE mails SET status='validated' WHERE validator=? AND status='pending'");
          $stmt->bind_param("i", $validator);
          $stmt->execute();
        echo 'You are now subscribed!';
      } else {
        echo 'An error occured.';
      }

        $stmt->close();
        $conn->close();

    } else {
        header('Location: index.php');
        exit;
      }
    ?>
  </h2>
<p>You may now close this page.</p>

</div>
<?php
include('./modules/footer.php');
?>
