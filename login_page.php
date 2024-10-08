<?php
session_start();
include 'connection.php';
include 'email_utils.php';
include 'otp_utils.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, password, email FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $email);
    
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        // Generate OTP
        $otp = generate_otp();
        $expires_at = time() + 120; // OTP expires in 2 minutes
        
        // Save OTP in session
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_expiry'] = $expires_at;
        $_SESSION['user_id'] = $user_id;

        // Send OTP via PHPMailer
        send_otp_via_email($email, $otp);

        // Redirect to OTP verification page
        header('Location: otp_verification.php');
        exit();
    } else {
        echo "<script>alert('Invalid login! Please check your username or password.');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="login.css">
</head>
<body>


<div class="modal-backdrop"></div>


<div class="modal-container">
    <div class="signin-container">
        <h1>Welcome back.</h1>
        <br>
        <br>
        
        <div id="signin-container">
            <form action="login_page.php" method="post">
                <h2 id="signin-title">Sign in with the email address associated with your account</h2>
                <div id="email-group">
                    <input type="text" id="email-input" name="username" placeholder="Username" required>
                    <input type="password" id="password-input" name="password" placeholder="Password" required>
                </div>
                <div id="submit-group">
                <!-- <button id="submit-button" type="submit" name = "submit">Submit</button>-->
                <input type="submit" id="submit-button" value="Login">
                </div>
            </form>
        </div>
        
        <br>
        <div class="signup-link">
            No account? <a href="Register_page.php" style="color: #008000; text-decoration: none;">Create one</a>
        </div>
        
        
    </div>
</div>
</body>

<script
    src = "js/login.js" defer>
</script>
</html>
<!-- login_form.php
<form action="login_page.php" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" value="Login">
</form> -->