<?php

$host = "localhost"; // Replace with your database host
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$database = "healthcare"; // Replace with your database name

// Create a database connection
$con = mysqli_connect($host, $username, $password, $database);

// Retrieve selected dates from the database
// Adjust this query based on your database schema
$query = "SELECT date FROM appointment";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

$selectedDates = array();
while ($row = mysqli_fetch_assoc($result)) {
    $selectedDates[] = $row['selected_date'];
}

// Return selected dates as JSON
header('Content-Type: application/json');
echo json_encode($selectedDates);

// Close the database connection
mysqli_close($connection);

?>
