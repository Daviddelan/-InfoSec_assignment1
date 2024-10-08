<?php
// otp_utils.php
function generate_otp() {
    return rand(100000, 999999); // 6-digit OTP
}
?>