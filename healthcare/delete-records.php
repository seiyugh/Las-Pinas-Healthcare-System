<?php
include "php/config.php";

// Check if the appointment ID is provided in the URL
if (isset($_GET['id'])) {
    $appointmentIdToRemove = $_GET['id'];

    // Retrieve the appointment details before removal
    $query = mysqli_query($con, "SELECT * FROM appointment WHERE id = $appointmentIdToRemove");
    $appointmentDetails = mysqli_fetch_assoc($query);

    // Insert the appointment details into the deleted_appointments table
    $insertQuery = "INSERT INTO deleted_appointments (id, fullname, contactNo, email, address, age, sex, date, time) 
                    VALUES (
                        {$appointmentDetails['id']},
                        '{$appointmentDetails['fullname']}',
                        '{$appointmentDetails['contactNo']}',
                        '{$appointmentDetails['email']}',
                        '{$appointmentDetails['address']}',
                        {$appointmentDetails['age']},
                        '{$appointmentDetails['sex']}',
                        '{$appointmentDetails['date']}',
                        '{$appointmentDetails['time']}'
                    )";
    mysqli_query($con, $insertQuery);

    // Delete the appointment from the original table
    $deleteQuery = "DELETE FROM appointment WHERE id = $appointmentIdToRemove";
    $result = mysqli_query($con, $deleteQuery);

    if ($result) {
        // Appointment removed successfully, set the success message and redirect
        $successMessage = "Appointment removed, and stored successfully!";
        header("Location: appointment-history.php?msg=" . urlencode($successMessage));
        exit();
    } else {
        // Handle the case when removal fails
        echo "Error removing appointment: " . mysqli_error($con);
    }
} else {
    // Handle the case when no appointment ID is provided
    echo "No appointment ID provided for removal.";
}
?>
