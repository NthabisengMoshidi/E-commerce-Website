<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include('db.php');

$username = $_SESSION['user_name'];
$query = $connection->prepare("SELECT * FROM users WHERE username=:username");
$query->bindParam("username", $username, PDO::PARAM_STR);
$query->execute();
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo '<p class="error">User not found!</p>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Account</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="account-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>
    <div class="container">
        <h2>Update Profile</h2>
        <a href="update.php" class="link"> Reset Password</a>
    </div>
    <div class="container">
        <h2>Order History</h2>
        <ul>
            <?php
            $query = $connection->prepare("SELECT * FROM orders WHERE user_id=:user_id");
            $query->bindParam("user_id", $user['id'], PDO::PARAM_INT);
            $query->execute();
            $orders = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach ($orders as $order) {
                echo '<li>Order ID: ' . htmlspecialchars($order['id']) . ', Total Amount: ' . htmlspecialchars($order['total_amount']) . ', Status: ' . htmlspecialchars($order['payment_status']) . '</li>';
            }
            ?>
        </ul>
        <p><a href="logout.php">Log Out</a></p>
    </div>
    <div class="button">
        <button onclick="goBack()">Go Back</button>
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 Bongani and Beauty. All Rights Reserved.</p>
        </div>
    </footer>
    <script>
            function goBack() {
                window.history.back();
            }
        </script>
</body>
</html>
