<?php
session_start();
include 'connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Password validation (at least 8 characters, mix of letters and numbers)
    if (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        echo "Password must be at least 8 characters long, with letters and numbers.";
        return;
    }

    //
    $options = ['cost' => 10]; //
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);

    // Insert into database
    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->bind_param("sss", $username, $hashed_password, $email);

    if ($query->execute()) {
        header("Location: login_page.php");
        exit();
    } else {
        echo "Registration failed!";
    }
    $query->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome CSS -->

    <style>
         body {
            background-color: gray;
        }

        .info-form {
            background-color: #c4f0ff; 
            padding: 20px;
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            width: 700px;
            height: 900px;
            margin: 50px auto; 
        }

        /* Basic style for strength bar */
        #passwordStrength {
            height: 10px;
            width: 100%;
            background-color: #ddd;
            margin-top: 5px;
            border-radius: 3px;
            overflow: hidden;
        }
        #passwordStrength div {
            height: 100%;
            width: 0;
            background-color: red;
            transition: width 0.3s, background-color 0.3s;
        }
        /* Disable submit button initially */
        #registerr:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <div class="info-form">
        <h2>Please Enter Your Information To Register</h2>
        <form id="registrationForm" method="post" action="">
            <label for="username">Please enter your username:</label><br>
            <input type="text" id="username" name="username" placeholder="Please enter your username" required><br>
            <div id="nameError" style="color: red;"></div>

            <label for="email">Please enter your Email address:</label><br>
            <input type="email" id="email" name="email" placeholder="e.g dela.nuworkpor@gmail.com" required><br>
            <div id="emailError" style="color: red;"></div>

            <label for="password">Please enter your password:</label><br>
            <!-- <input type="password" id="password" name="password" placeholder="Enter password" required> -->
            <div style="position: relative;">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    <i class="far fa-eye" id="passwordIcon"></i>
                </span>
            </div>
            
            <div id="passwordRequirements">
                <p>Password must contain:</p>
                <p id="minLength">At least 8 characters</p>
                <p id="upperCase">At least one uppercase letter</p>
                <p id="lowerCase">At least one lowercase letter</p>
                <p id="number">At least one number</p>
            </div>

            <!-- Password strength bar -->
            <div id="passwordStrength">
                <div></div>
            </div>

            <label for="confirmPassword">Confirm Password:</label><br>
            <!-- <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Retype password" required><br> -->
            <div style="position: relative;">
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Retype password" required>
                <span id="toggleConfirmPassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                    <i class="far fa-eye" id="confirmPasswordIcon"></i>
                </span>
            </div>
            <div id="passwordError" style="color: red;"></div>

            <input type="submit" name="register" id="registerr" value="Register" disabled>
        </form>
    </div>

    <script>
        // Elements
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirmPassword");
        const passwordStrengthBar = document.getElementById("passwordStrength").firstElementChild;
        const registerButton = document.getElementById("registerr");
        const passwordError = document.getElementById("passwordError");
        
        const minLength = document.getElementById("minLength");
        const upperCase = document.getElementById("upperCase");
        const lowerCase = document.getElementById("lowerCase");
        const number = document.getElementById("number");




        //
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.src = 'hide-icon.png';
            } else {
                passwordField.type = 'password';
                passwordIcon.src = 'eye-icon.png';
            }
        });

        // Toggle password visibility for the confirm password field
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordField = document.getElementById('confirmPassword');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            if (confirmPasswordField.type === 'password') {
                confirmPasswordField.type = 'text';
                confirmPasswordIcon.src = 'hide-icon.png';
            } else {
                confirmPasswordField.type = 'password';
                confirmPasswordIcon.src = 'eye-icon.png';
            }
        });

        
        // Password validation function
        function validatePassword() {
            const passwordValue = password.value;
            let strength = 0;

            // Check length
            if (passwordValue.length >= 8) {
                minLength.style.color = "green";
                strength++;
            } else {
                minLength.style.color = "red";
            }

            // Check uppercase letters
            if (/[A-Z]/.test(passwordValue)) {
                upperCase.style.color = "green";
                strength++;
            } else {
                upperCase.style.color = "red";
            }

            // Check lowercase letters
            if (/[a-z]/.test(passwordValue)) {
                lowerCase.style.color = "green";
                strength++;
            } else {
                lowerCase.style.color = "red";
            }

            // Check for numbers
            if (/\d/.test(passwordValue)) {
                number.style.color = "green";
                strength++;
            } else {
                number.style.color = "red";
            }

            // Update the strength bar
            updatePasswordStrengthBar(strength);

            // Disable or enable the submit button
            if (strength === 4 && passwordValue === confirmPassword.value) {
                registerButton.disabled = false;
            } else {
                registerButton.disabled = true;
            }

            // Validate password match
            validatePasswordMatch();
        }

        // Function to update password strength bar
        function updatePasswordStrengthBar(strength) {
            switch (strength) {
                case 1:
                    passwordStrengthBar.style.width = "25%";
                    passwordStrengthBar.style.backgroundColor = "red";
                    break;
                case 2:
                    passwordStrengthBar.style.width = "50%";
                    passwordStrengthBar.style.backgroundColor = "orange";
                    break;
                case 3:
                    passwordStrengthBar.style.width = "75%";
                    passwordStrengthBar.style.backgroundColor = "yellowgreen";
                    break;
                case 4:
                    passwordStrengthBar.style.width = "100%";
                    passwordStrengthBar.style.backgroundColor = "green";
                    break;
                default:
                    passwordStrengthBar.style.width = "0";
                    passwordStrengthBar.style.backgroundColor = "red";
                    break;
            }
        }

        // Confirm password matching
        function validatePasswordMatch() {
            if (confirmPassword.value !== password.value) {
                passwordError.textContent = "Passwords do not match.";
                registerButton.disabled = true;
            } else {
                passwordError.textContent = "";
                registerButton.disabled = false;
            }
        }

        // Event listeners
        password.addEventListener("input", validatePassword);
        confirmPassword.addEventListener("input", validatePasswordMatch);
    </script>

</body>
</html>
