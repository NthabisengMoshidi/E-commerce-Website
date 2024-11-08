<?php
// Start the session
session_start();

// Include the configuration file
include('db.php');

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        
        // Store the token in the database
        $query = $connection->prepare("UPDATE users SET reset_token=:token WHERE email=:email");
        $query->bindParam("token", $token, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();

        // Send the reset email
        $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click on this link to reset your password: $resetLink";
        $headers = "From: no-reply@yourdomain.com";

        mail($email, $subject, $message, $headers);

        echo '<p class="success">A password reset link has been sent to your email address.</p>';
    } else {
        echo '<p class="error">No account found with that email address.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Forgot Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="navbar_container">
                <a href="index.html" id="navbar_logo">Bongani and Beauty</a>
                <div class="navbar_toggle" id="mobile-menu">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <form method="post" action="">
              <h2>Forgot Password</h2>
                 <div class="form-element">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                 </div>
                   <button type="submit" name="submit">Submit</button>
                   <p>Remember your password? <a href="login.php">Login here</a></p>
            </form>              
        </div>                    
   </main>
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
