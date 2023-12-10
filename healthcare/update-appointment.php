<?php
include "php/update-appointment-config.php";

$id = $_GET['id'];
$errorMsg = '';

if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    // Add your styling for the success message
    $msgStyle = 'color: green; font-weight: bold; background-color: #0B666A';
} else {
    $msg = ''; // No message by default
    $msgStyle = ''; // Default styling
}

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $contactNo = $_POST['contactNo'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $time = $_POST['time'];
    $date = $_POST['date'];

    // Check for duplicate contact number or full name
    $duplicateCheck = mysqli_query($con, "SELECT id FROM appointment WHERE (contactNo = '$contactNo' OR fullname = '$fullname' OR email = '$email') AND id != '$id'");

    if (mysqli_num_rows($duplicateCheck) > 0) {
        $msg = "Duplicate contact number, name, or email address. Please enter a different account.";
    } else {
        // Update the database with the new values
        $sql = "UPDATE appointment SET fullname = '$fullname', email = '$email', address = '$address', contactNo = '$contactNo', sex = '$sex', time = '$time', date = '$date' WHERE id = '$id'";
        $result = mysqli_query($con, $sql);

        // Check if the update was successful
        if ($result) {
            header("Location: appointment-records.php?msg=Record updated successfully");
            exit(); // Stop further execution
        } else {
            $errorMsg = "Error updating record: " . mysqli_error($con);
        }
    }
}

// Retrieve existing user data for pre-filling the form
$query = mysqli_query($con, "SELECT * FROM appointment WHERE id=$id");

// Check if the user exists
if ($query && mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);

    // Assign values to variables for pre-filling the form
    $fullname = $result['fullname'];
    $contactNo = $result['contactNo'];
    $address = $result['address'];
    $email = $result['email'];
    $sex = $result['sex'];
    $time = $result['time'];
    $date = $result['date'];
} else {
    // Handle the case when the user does not exist
    echo "User not found";
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/pikaday.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css">

    <title class="mt-4">Update User</title>
</head>

<body style="background-color: rgba(151, 254, 237, 0.6);">

    <div class="container mt-5 rounded p-5" style="background-color: rgba(147, 215, 214, 0.6);">
        <div class="text-center mb-4">
            <h3>Update User</h3>
            <p class="text-dark ">Complete the form below to update the Appointment</p>
        </div>
        <?php if (!empty($msg)): ?>
            <div class="alert alert-success" role="alert" style="<?php echo $msgStyle; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;">
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Full Name:</label>
                        <input type="text" class="form-control rounded" name="fullname" value="<?php echo $fullname ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Email Address:</label>
                        <input type="email" class="form-control rounded" name="email" value="<?php echo $email ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Number:</label>
                    <input type="tel" class="form-control rounded" name="contactNo" value="<?php echo $contactNo ?>" minLength="11" maxlength="11" required>
                    <label class="form-label" for="address">Complete Address</label>
                    <input type="text" class="form-control rounded" name="address" value="<?php echo $address ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label>Sex:</label>
                    &nbsp;
                    <input type="radio" class="form-check-input" name="sex" id="male" value="Male" <?php echo ($sex === 'Male') ? 'checked' : ''; ?>>
                    <label for="male" class="form-input-label">Male</label>
                    &nbsp;
                    <input type="radio" class="form-check-input" name="sex" id="female" value="Female" <?php echo ($sex === 'Female') ? 'checked' : ''; ?>>
                    <label for="female" class="form-input-label">Female</label>
                </div>

                <div class="mb-3">
                     <div class="col">
                        <label class="form-label">Time:</label>
                        <input type="text" class="form-control rounded" name="time" id="timepicker" value="<?php echo $time ?>" required>
                     </div>
                    <div class="col">
                        <label class="form-label" for="date" id="datepicker">Date:</label>
                        <input type="text" class="form-control rounded" name="date" id="pikaday" value="<?php echo $date ?>" required>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-success" name="submit">Save</button>
                    <a href="appointment-records.php" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>


    <script src="pikaday.js"></script>
    <script>
  document.addEventListener('DOMContentLoaded', function () {
    var datepicker = new Pikaday({
            field: document.getElementById('pikaday'),
            format: 'ddd MMM D YYYY', // Adjust the date format as needed
        });


        flatpickr("#timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "h:i K", // Use 'h' for 12-hour time format, 'i' for minutes, and 'K' for AM/PM
            time_24hr: false, // Set to false for 12-hour time format
        });

        // Handle automatic AM/PM detection
        document.getElementById('timepicker').addEventListener('input', function (e) {
            var selectedTime = e.target.value;
            if (selectedTime) {
                var momentTime = moment(selectedTime, "h:mm A");
                var formattedTime = momentTime.format("h:mm A");

                e.target.value = formattedTime;
            }
        });
        var picker = new Pikaday(
    {
        field: document.getElementById('datepicker'),
        firstDay: 1,
        minDate: new Date(),
        maxDate: new Date(12, 31, 2023),
        yearRange: [2023, 2030]
    });

        var today = new Date();
        var selectedDates = []; // Add this line to initialize the selectedDates array

        function disableDates(date) {
            var formattedDate = formatDate(date);
            return date > today || dates.includes(date);
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = ('0' + (date.getMonth() + 1)).slice(-2);
            var day = ('0' + date.getDate()).slice(-2);
            return year + '-' + month + '-' + day;
        }

        function updateSelectedDates() {
            var selectedDatesElement = document.getElementById('selected-dates');
            selectedDatesElement.innerHTML = '<strong>Selected Dates:</strong> ' + selectedDates.join(', ');
        }

        var calendar = new Pikaday({
            field: document.getElementById('calendar'),
            disableDayFn: disableDates,
            onSelect: function (date) {
                var formattedDate = formatDate(date);
                selectedDates.push(formattedDate);
                updateSelectedDates();
            },
            maxDate: today
        });

        updateSelectedDates();
    });

    </script>
</body>

</html>
