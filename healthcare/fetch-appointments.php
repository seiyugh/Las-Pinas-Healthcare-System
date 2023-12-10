<?php
// Function to get appointments from JSON file
function getAppointments() {
    $appointmentsFile = 'appointments.json';

    if (file_exists($appointmentsFile)) {
        $appointmentsData = file_get_contents($appointmentsFile);
        return json_decode($appointmentsData, true);
    } else {
        return [];
    }
}

// Fetch all appointments
$appointments = getAppointments();

// Echo the table HTML
echo '<table border="1" style="width: 100%;">';
echo '<thead>';
echo '<tr>';
echo '<th>Date</th>';
echo '<th>Time</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($appointments as $index => $appointment) {
    echo '<tr>';
    echo '<td>' . $appointment['date'] . '</td>';
    echo '<td>' . $appointment['time'] . '</td>';
    echo '<td style="text-align: center; color: black">';
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
?>
