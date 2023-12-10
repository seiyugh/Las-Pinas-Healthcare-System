<?php
session_start(); 


include("php/admin-config.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $Username = $_POST["email"];
    $Password = $_POST["password"];


    if ($Username === $Username && $Password === $Username && $password) {

        $_SESSION["admin_logged_in"] = true; 
        header("Location: patient-registered.php"); 
        exit();
    } else {

        $error = "<div class='message'>
        <p>Wrong Username or Password</p>
         </div> <br>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>

</head>
<div class="home">
    <a href="index.php" >Home</a>
</div>

<body>
    <div class="admin-login">
        <div class="admin-login-form">
        <form id="admin-login" method="POST" action="admin.php">
    <!-- Set the form method and action -->
    <div class="logo">
        <img src="images/logo.png">
    </div>
    <h2>ADMIN LOGIN</h2>
    <?php if (isset($error)) { ?>
        <div class="error-message">
            <?php echo $error; ?>
        </div>
                        <?php } ?>
                <label for="email">Enter your Email</label>
                <input type="email" name="email" placeholder="username@example.com">
                <label for="password">Enter your Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="password">
                    <i class="fa" id="eye-icon" onclick="togglePassword()">&#xf06e;</i>
                </div>
                <button id="submit-button" type="submit">Login</button>

                <script>
                    function togglePassword() {
                        var passwordInput = document.getElementById("password");
                        var eyeIcon = document.getElementById("eye-icon");

                        if (passwordInput.type === "password") {
                            passwordInput.type = "text";
                            eyeIcon.style.color = "#007BFF"; // Change color to indicate password is visible
                        } else {
                            passwordInput.type = "password";
                            eyeIcon.style.color = ""; // Reset color
                        }
                    }
                </script>
            </form>
        </div>
    </div>
</body>


</html>