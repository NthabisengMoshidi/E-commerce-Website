<?php
session_start();
require 'email.php'; 

$host = '127.0.0.1';
$db = 'bb';
$user = 'root';
$pass = 'nth@bi';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $connection = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username']; 
        $service = $_POST['service'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $stmt = $connection->prepare("INSERT INTO appointments (user_id, service, date, time) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $service, $date, $time])) {
            $user_email = $_SESSION['email']; 
            $subject = "Appointment Confirmation";
            $body = "Dear user, <br><br>Your appointment for <strong>$service</strong> on <strong>$date</strong> at <strong>$time</strong> has been confirmed.<br><br>Thank you for choosing Bongani and Beauty.<br><br>Best regards,<br>Bongani and Beauty Team";

            if (sendEmail($user_email, $subject, $body)) {
                echo "Booking confirmed and email sent.";
            } else {
                echo "Booking confirmed but failed to send email.";
            }
        } else {
            echo "Failed to book appointment.";
        }
    } else {
        echo "Please log in to book an appointment.";
    }
} else {
    header("Location: ../index.php");
}
?>
