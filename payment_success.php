<?php
session_start();
include('db.php');
include('email.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['username'];
    $amount = $_POST['amount'];
    $paymentStatus = 'Completed';

    try {
        
        $query = $connection->prepare("INSERT INTO payments (user_id, amount, status) VALUES (:user_id, :amount, :status)");
        $query->bindParam(':username', $userId);
        $query->bindParam(':amount', $amount);
        $query->bindParam(':status', $paymentStatus);
        $query->execute();

        
        $query = $connection->prepare("SELECT email FROM users WHERE id = :user_id");
        $query->bindParam(':username', $userId);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        
        $subject = "Payment Confirmation";
        $body = "<p>Dear User,</p><p>Your payment of R$amount has been received and processed successfully.</p><p>Thank you for choosing Bongani and Beauty!</p>";
        sendEmail($user['email'], $subject, $body);

        
        header('Location: payment_success.php');
        exit;
    } catch (Exception $e) {
        echo "<p class='error'>There was an error with your payment. Please try again.</p>";
    }
}
?>
