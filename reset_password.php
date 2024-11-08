<?php
// Start the session
session_start();

// Include the configuration file
include('db.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token
    $query = $connection->prepare("SELECT * FROM users WHERE reset_token=:token");
    $query->bindParam("token", $token, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (isset($_POST['submit'])) {
            $new_password = $_POST['password'];
            $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password and clear the reset token
            $query = $connection->prepare("UPDATE users SET password=:password, reset_token=NULL WHERE reset_token=:token");
            $query->bindParam("password", $password_hash, PDO::PARAM_STR);
            $query->bindParam("token", $token, PDO::PARAM_STR);
            $query->execute();

            echo '<p class="success">Your password has been reset successfully.</p>';
        }
    } else {
        echo '<p class="error">Invalid or expired token.</p>';
    }
} else {
    echo '<p class="error">No token provided.</p>';
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const passwordError = document.getElementById('password_error');
            
            const passwordPattern = /^(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*\W).{6,}$/;

            if (!password.match(passwordPattern)) {
                passwordError.textContent = "Password must be at least 6 characters long, contain at least 2 alphabets (one in capital letter), and a special character.";
                return false;
            }

            if (password !== confirmPassword) {
                passwordError.textContent = "Passwords do not match.";
                return false;
            }

            passwordError.textContent = "";
            return true;
        }
    </script>
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
            <h2>Reset Password</h2>
            <form method="post" action="reset_password.php" name="reset-password-form">
                <div class="form-element">
                    <label>New Password</label>
                    <input type="password" name="password" required />
                </div>
                <div class="form-element">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required />
                </div>
                <p id="password_criteria" style="color:grey;">Password must be at least 6 characters long, contain at least 2 alphabets (one in capital letter), and a special character.</p>
                <p id="password_error" style="color:red;"></p>
                <button type="submit" name="submit" value="submit">Reset Password</button>
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

