<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>

    <link rel="stylesheet" href="styles/appointment-3.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/css/pikaday.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="home">
        <a href="index.php">Home</a>
    </div>

    <div class="container">
        <div class="box form-box">
        <?php
                include("php/availability-config.php");

                $defaultDate = date("Y-m-d");

                $popupSuccessMessage = "";
                $popupFailedNameMessage = "";
                $popupFailedContactNoMessage = "";
                $popupUnregNameMessage = "";
                $popupFailedContactNoMessage = "";

                if (isset($_POST['submit'])) {
                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $address = $_POST['address'];
                    $age = $_POST['age'];
                    $sex = $_POST['sex'];
                    $contactNo = $_POST['contactNo'];


                    $fullname_query = mysqli_query($con, "SELECT fullname FROM appointment WHERE fullname='$fullname'");
                    $contactNo_query = mysqli_query($con, "SELECT contactNo FROM appointment WHERE contactNo='$contactNo'");
                    $email_query = mysqli_query($con, "SELECT email FROM appointment WHERE email='$email'");
                    $fullname_unreg = mysqli_query($con, "SELECT fullname FROM patients WHERE fullname='$fullname'");
                    
                    
                    if (mysqli_num_rows($fullname_query) > 0) {
                        $popupFailedNameMessage = "Name is already in use.";
                    } elseif (mysqli_num_rows($fullname_unreg) == 0) {
                        $popupUnregNameMessage = "Name is not registered, Register first.";
                    } elseif (mysqli_num_rows($contactNo_query) > 0) {
                        $popupFailedContactNoMessage = "Contact Number is already in use.";
                    } elseif (mysqli_num_rows($email_query) > 0) {
                        $popupFailedEmailMessage = "Email is already in use.";
                    } else {

                            // Extract selectedDate and selectedTime from the form
                            $selectedDate = $_POST['date'];
                            $selectedTime = $_POST['time'];

                        // Assuming $user_id, $formattedDate, and $selectedTime are defined somewhere
                        $query = "INSERT INTO appointment (fullname, contactNo, email, address, age, sex, date, time) 
                        VALUES ('$fullname', '$contactNo', '$email', '$address', '$age', '$sex', '$selectedDate', '$selectedTime')";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            $popupMessage = "Congratulations! You are now registered and have booked an appointment.";
                        } else {
                            $popupMessage = "Error occurred while registering the appointment. " . mysqli_error($con);
                        }
                        
                    }
                }
                    $selectedDate = isset($_SESSION['selectedDate']) ? $_SESSION['selectedDate'] : '';
                    $selectedTime = isset($_SESSION['selectedTime']) ? $_SESSION['selectedTime'] : '';
        ?>
            <div class="patient-registration">
                <h2 style="padding-bottom: 15px;">Set an Appointment</h2>
            </div>
            <div class="form-container">
            <form action="appointment.php" method="post">
                   <div class="separate1">
                     <div class="field-input" >
                        <label for="fullname">Full Name</label>
                        <input type="text" name="fullname" id="fullname" autocomplete="off" required>
                    </div>

                    
                    <div class="field-input" style="padding-top:20px">
                        <label for="contactNo">Contact Number</label>
                        <input type="tel" name="contactNo" id="contact" autocomplete="off" required min="1" maxLength="11">
                    </div>
                    
                    <div class="field-input"style="padding-top:20px">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </div>
                    <div class="field-input"style="padding-top:20px">
                        <label for="address">Complete Address</label>
                        <input type="text" name="address" id="address" autocomplete="off" required min="1">
                        <a href="available-appointments.php" class="avail-btn" id="avail-btn" onclick="checkAvailability()">Check Availability</a>
                    </div>
                </div>
                    <div class="separate">
                        <!-- Elements you want to move to the end -->
                        <div class="field-input">
                            <label for="age">Age</label>
                            <input type="number" name="age" id="age" autocomplete="off" required min="1">
                        </div>
                        <!-- Radio buttons can stay within the "separate" div as well -->
                        <label for="sex">Sex</label>
                        <div class="sex-selector">
                        Male <input type="radio" name="sex" id="sex" value="Male" autocomplete="off" required>
                        
                        Female <input type="radio" name="sex" id="sex" value="Female" autocomplete="off" required>
                        </div>
                        <label for="time">Select a time</label>
                            <div class="field-input">
                                <input type="time" name="time" id="timepicker" autocomplete="off" required>
                            </div>

                            <label for="date" id="calendar">Select a Date</label>
                            <div class="field-input">
                                <input type="text" name="date" id="pikaday" autocomplete="off" required>
                            </div>
                            
                            <button type="submit" class="register-btn" name="submit" value="Register">Submit</button>
                        </div>
                <!-- Check Availability Button -->
                

                <!-- Submit Button -->
                <div class="register-now">Not registered?<a href="register-user.php">Register now!</a></div>    

                </form>
            </div>
        </div>
         
    </div>
</body>
<script src="pikaday.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.8.0/pikaday.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
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

                    flatpickr("#pikaday", {
                        enableTime: false,
                        dateFormat: "D M d Y",
                        maxDate: "none",
                    });

                    function openAvailabilityPopup(availabilityMessage) {
                        var popupAvailability = document.getElementById('popupAvailability');
                        var availabilityMessageElement = document.getElementById('availabilityMessage');

                        availabilityMessageElement.innerHTML = availabilityMessage;
                        popupAvailability.style.display = 'block';
                    }

                    function checkAvailability() {
                        var selectedDate = document.getElementById('pikaday').value;
                        var selectedTime = document.getElementById('timepicker').value;

                    fetch('check-availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: "date=" + selectedDate + "&time=" + selectedTime,
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(responseData => {
                        console.log('Response Data:', responseData);

                        // You should adjust this part based on the actual response structure
                        if (responseData.available) {
                            openAvailabilityPopup("Appointment slot is available!");
                        } else {
                            openAvailabilityPopup("Sorry, the selected slot is not available. Please choose another.");
                        }
                    })
                    .catch(error => {
                        console.error('Error checking availability:', error);
                    });

                    // Fetch occupied dates and times from the server
                    fetch('check-availability.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Disable occupied dates in the calendar
                        var calendarInput = document.getElementById('pikaday');
                        data.forEach(item => {
                            var option = calendarInput.querySelector(`option[value="${item.date}"]`);
                            if (option) {
                                option.disabled = true;
                            }
                        });

                        // Disable occupied times in the time input
                        var timeInput = document.getElementById('timepicker');
                        data.forEach(item => {
                            var option = timeInput.querySelector(`option[value="${item.time}"]`);
                            if (option) {
                                option.disabled = true;
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching occupied dates and times:', error);
                    });
                }
});
</script>
<script>
    // Function to open the popup
    function openPopup(popupId) {
        var popup = document.getElementById(popupId);
        popup.style.display = 'block';
    }

    function closePopup(popupId) {
        var popup = document.getElementById(popupId);
        popup.style.display = 'none';
    }

    // Trigger the relevant popup based on the message
    if ("<?php echo $popupMessage; ?>" !== "") {
        openPopup('popupSuccess');
    } else if ("<?php echo $popupFailedNameMessage; ?>" !== "") {
        openPopup('popupFailedName');
    } else if ("<?php echo $popupFailedContactNoMessage; ?>" !== "") {
        openPopup('popupFailedContactNo');
    }else if ("<?php echo $popupUnregnameMessage; ?>" !== "") {
        openPopup('popupFailedContactNo');
    }
</script>


<div class="popup-container" id="popupSuccess" style="<?php echo !empty($popupMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupSuccessMessage; ?> Congratulations! You are now registered and have booked an appointment.</p>
        <a href="index.php"><button class='failed-btn'>Back to Home</button></a>
       
    </div>
</div>

<div class="popup-container" id="popupFailedName" style="<?php echo !empty($popupFailedNameMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupFailedNameMessage; ?></p>
        <a href="javascript:void(0);" onclick="history.back(); closePopup('popupFailedName');"><button class='failed-btn'>Retry</button></a>
       
    </div>
</div>
<div class="popup-container" id="popupUnregName" style="<?php echo !empty($popupUnregNameMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupUnregNameMessage; ?></p>
        <a href="register-user.php" onclick="history.back(); closePopup('popupUnregName');"><button class='failed-btn'>Register</button></a>    
    </div>
</div>

<div class="popup-container" id="popupFailedContactNo" style="<?php echo !empty($popupFailedContactNoMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupFailedContactNoMessage; ?></p>
        <a href="javascript:void(0);" onclick="history.back(); closePopup('popupFailedContactNo');"><button class='failed-btn'>Retry</button></a>
       
</div>
<div class="popup-container" id="popupFailedEmail" style="<?php echo !empty($popupFailedEmailMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupFailedEmailMessage; ?></p>
        <a href="javascript:void(0);" onclick="history.back(); closePopup('popupFailedEmail');"><button class='failed-btn'>Retry</button></a>
      
    </div>
</div>


</html>