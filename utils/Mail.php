<?php




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$mailObject = new PHPMailer(true);
$smtpServ = $_ENV['SMTP_HOST'];
$smtpUser = $_ENV['SMTP_USER'];
$smtpPassword = $_ENV['SMTP_PWD'];


function sendMail($title, $body, $receiver) {
    global $mailObject;  // Make the $mail object accessible inside the function
    global $smtpServ;
    global $smtpUser;
    global $smtpPassword;

    try {
        //Server settings
        $mailObject->isSMTP();                                            // Set mailer to use SMTP

        $mailObject->Host = $smtpServ;                               // Set the SMTP server to send through
        $mailObject->SMTPAuth = true;                                       // Enable SMTP authentication
        $mailObject->Username = $smtpUser;                     // SMTP username
        $mailObject->Password = $smtpPassword;                        // SMTP password (use an app password for Gmail if 2FA is enabled)

        $mailObject->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
        $mailObject->Port = 587;                                            // TCP port to connect to

        //Recipients
        $mailObject->setFrom($smtpUser, 'The Fanclub');          // Sender's email

        $mailObject->addAddress($receiver); // Add a recipient

        // Content
        $mailObject->isHTML(true);                                          // Set email format to HTML
        $mailObject->Subject = $title;                  // Email subject
        $mailObject->Body    = $body; // HTML email body
        $mailObject->AltBody = $body; // Plain text body for non-HTML clients

        $mailObject->send();
                                                   // Send email
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mailObject->ErrorInfo}";

    }
}
?>
