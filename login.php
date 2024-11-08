<?php
session_start();
include('db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $connection->prepare("SELECT * FROM users WHERE username=:username");
    $query->bindParam("username", $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        echo '<p class="error">Username password combination is wrong!</p>';
    } else {
        if (password_verify($password, $result['password'])) {
            $_SESSION['username'] = $result['username'];
            header("location: homepage.php");
            exit;
        } else {
            echo '<p class="error">Username password combination is wrong!</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
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
            <h2>Login</h2>
            <form method="post" action="" name="signin-form">
                <div class="form-element">
                    <label>Username</label>
                    <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
                </div>
                <div class="form-element">
                    <label>Password</label>
                    <input type="password" name="password" required />
                </div>
                <a href="forgot-password.html" class="forgot-password">Forgot Password?</a>
                <button type="submit" name="login" value="login">Log In</button>
                <p>Do not have an account? <a href="register.php">Register here</a></p>
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
