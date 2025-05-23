<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
var_dump($_ENV);
$dotenv->load();



$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PWD'];
$dbname = $_ENV['DB_NAME'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);



$sql = 'CREATE TABLE IF NOT EXISTS mails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mail VARCHAR(100) NOT NULL,
    validator INT NOT NULL,
    status TEXT NOT NULL
)';
mysqli_query($conn, $sql);


?>
