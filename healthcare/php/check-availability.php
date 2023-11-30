<?php
// Include your database connection code here
include("availability-config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch occupied dates and times from the database
    $occupiedDatesQuery = mysqli_query($con, "SELECT date FROM appointment");
    $occupiedTimesQuery = mysqli_query($con, "SELECT time FROM appointment");

    if ($occupiedDatesQuery && $occupiedTimesQuery) {
        $occupiedDates = [];
        while ($row = mysqli_fetch_assoc($occupiedDatesQuery)) {
            $occupiedDates[] = $row['date'];
        }

        $occupiedTimes = [];
        while ($row = mysqli_fetch_assoc($occupiedTimesQuery)) {
            $occupiedTimes[] = $row['time'];
        }

        // Return the list of occupied dates and times as JSON
        echo json_encode(['dates' => $occupiedDates, 'times' => $occupiedTimes]);
    } else {
        // Handle the case where the query fails
        echo json_encode(['dates' => [], 'times' => []]);
    }
} else {
    // Handle the case where the script is not accessed via POST
    echo "Invalid request.";
}
?>
