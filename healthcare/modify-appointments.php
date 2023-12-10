<?php
session_start();

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

// Function to save appointments to JSON file
function saveAppointments($appointments) {
    $appointmentsFile = 'appointments.json';
    file_put_contents($appointmentsFile, json_encode($appointments, JSON_PRETTY_PRINT));
}

// Fetch existing appointments
$appointments = getAppointments();

// Handle form submission and modification logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modifiedDate = $_POST['modifiedDate'];
    $modifiedTime = $_POST['modifiedTime'];

    // Perform validation - check if the date and time are valid (you can add more specific checks)
    if (isValidDateTime($modifiedDate, $modifiedTime)) {
        // Modify the appointment data as needed
        // For example, add the modified date and time to the appointments array
        $appointments[] = [
            'date' => $modifiedDate,
            'time' => $modifiedTime,
        ];

        // Save the modified appointments
        saveAppointments($appointments);

        // Redirect to the appointment admin page with a success message
        header('Location: modify-appointments.php?success=1');
        exit;
    } else {
        // Redirect back to the modification page with an error message
        header('Location: modify-appointments.php?error=1');
        exit;
    }
}

// Handle appointment deletion logic
if (isset($_GET['delete'])) {
    $deleteIndex = $_GET['delete'];
    
    // Check if the index is valid
    if (isset($appointments[$deleteIndex])) {
        // Remove the appointment at the specified index
        unset($appointments[$deleteIndex]);
        
        // Save the updated appointments
        saveAppointments($appointments);
        
        // Redirect back to the modification page with a success message
        header('Location: modify-appointments.php?success=2');
        exit;
    } else {
        // Redirect back to the modification page with an error message
        header('Location: modify-appointments.php?error=2');
        exit;
    }
}

// Function to check if a date and time are valid
function isValidDateTime($date, $time) {
    // Add your validation logic here
    // For example, you can use strtotime() to check if the date and time are valid
    return (strtotime($date . ' ' . $time) !== false);
}

$selectedDate = isset($_SESSION['selectedDate']) ? $_SESSION['selectedDate'] : '';
$selectedTime = isset($_SESSION['selectedTime']) ? $_SESSION['selectedTime'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Appointments</title>
    <link rel="stylesheet" href="styles/availability.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="box" style="margin-top:20px; display:flex; text-align:start">
    <h3>Existing Appointment dates</h3>
        <div class="text-appointments" style="overflow-y:scroll">
            
            <table border="1" style="width: 100%;">
                <thead>
                    <tr >
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $index => $appointment) : ?>
                        <tr>
                            <td><?php echo $appointment['date']; ?></td>
                            <td><?php echo $appointment['time']; ?></td>
                            <td style="text-align: center; color:black">
                                <a href="?delete=<?php echo $index; ?>" onclick="return confirm('Are you sure you want to delete this appointment?')"><i class="fa fa-trash" style="font-size: 1.5rem" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <h2>Modify Appointments</h2>
    <div class="box form-box">
        <!-- Modification form -->
        <form action="" method="post">
            <label for="modifiedDate">Modified Date:</label>
            <input type="text" id="modifiedDate" class="field-input" name="modifiedDate" placeholder="Enter date" required>

            <label for="modifiedTime">Modified Time:</label>
            <input type="text" id="modifiedTime" class="field-input" name="modifiedTime" placeholder="Enter time" required>

            <button type="submit" class="failed-btn">Submit Modification</button>
        </form>
        <a href="appointment-records.php">Back to Appointment Admin</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr for date input
        flatpickr("#modifiedDate", {
            enableTime: false,
            dateFormat: 'D M d Y',
        });

        // Initialize Flatpickr for time input with 12-hour time format
        var modifiedTimePicker = flatpickr("#modifiedTime", {
            enableTime: true,
            noCalendar: true,
            time_24hr: false,
            dateFormat: 'h:i K', // 'h' for 12-hour format, 'i' for minutes, 'K' for AM/PM
        });

        // Set initial time value in 12-hour format
        var initialTime = moment().format("h:mm A");
        modifiedTimePicker.setDate(initialTime, true, "h:i K");
    });
</script>

</body>

</html>