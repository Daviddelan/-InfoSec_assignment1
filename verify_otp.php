<?php
session_start();
$result = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_otp = $_POST['otp'];

    if (isset($_SESSION['otp'], $_SESSION['otp_expiry']) && time() <= $_SESSION['otp_expiry']) {
        if ($_SESSION['otp'] == $user_otp) {
            $result = "OTP verified successfully! Access granted. \nRedirecting to admin page...";
            // Grant access and destroy session
            unset($_SESSION['otp'], $_SESSION['otp_expiry'], $_SESSION['user_id']);
        } else {
            $result = "Incorrect OTP! Please go back & try again.";
        }
    } else {
        $result = "OTP expired or invalid! Please request a new one by logging in again.";
    }
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
        <h1>OTP Verification Status</h1>
        <br>
        <br>
        
        <div id="signin-container">
            <h2 id="signin-title">
                <?php 
                // Print the result of the OTP verification
                echo htmlspecialchars($result); 
                ?>
            </h2>
               
        </div>
    </div>
</div>
</body>

<script
    src = "js/login.js" defer>
</script>
</html>
