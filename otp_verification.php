<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Verification</title>
<link rel="stylesheet" href="login.css">
</head>
<body>


<div class="modal-backdrop"></div>


<div class="modal-container">
    <div class="signin-container">
        <h1>One Moment please.</h1>
        <br>
        <br>
        
        <div id="signin-container">
            <form action="verify_otp.php" method="post">
                <h2 id="signin-title">Please enter the OTP code</h2>
                <div id="email-group">
                    <input type="text" id="email-input" name="otp" placeholder="Enter OTP that was sent to your Email" required>
                </div>
                <div id="submit-group">
                <input type="submit" id="submit-button" value="Verify OTP">
                </div>
            </form>
        </div>
        
        
    </div>
</div>
</body>

</html>


