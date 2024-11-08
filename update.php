<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_name'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Include the configuration file
include('db.php');

$username = $_SESSION['user_name'];
$email = $_POST['email'];
$password = $_POST['password'];

if (!empty($password)) {
    // If the password is provided, hash it
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $connection->prepare("UPDATE users SET email=:email, password=:password WHERE username=:username");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->bindParam("password", $password_hash, PDO::PARAM_STR);
} else {
    // If no password is provided, only update the email
    $query = $connection->prepare("UPDATE users SET email=:email WHERE username=:username");
    $query->bindParam("email", $email, PDO::PARAM_STR);
}

$query->bindParam("username", $username, PDO::PARAM_STR);
$result = $query->execute();

if ($result) {
    echo '<p class="success">Profile updated successfully!</p>';
} else {
    echo '<p class="error">Failed to update profile. Please try again.</p>';
}
header('Location: my_account.php');
?>
