<?php
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "healthcare"; 


$con = mysqli_connect($host, $username, $password, $database);


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


$error = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Username = $_POST['email'];
    $Password = $_POST['password'];

    if (isValidAdminCredentials($Username, $Password)) {

        session_start();
        $_SESSION['admin_logged_in'] = true; 
        header("Location: patient-registered.php"); 
                exit();
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}


function isValidAdminCredentials($username, $password) {
    global $con; 


    $query = "SELECT * FROM admin WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) >= 1) {
        return true; 
    } else {
        return false; 
    }
}
?>
