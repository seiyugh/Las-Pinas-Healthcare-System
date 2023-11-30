<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

   
    <div class="home">
        <a href="index.php">Home</a>
    </div>
    <div class="container">
        <div class="box form-box">
        <?php
            include("php/config.php");

            $popupMessage = ""; // Initialize the popup message as an empty string
            $popupFailedNameMessage = ""; // Initialize the popup message as an empty string
            $popupFailedContactNoMessage = ""; // Initialize the popup message as an empty string

            if (isset($_POST['submit'])) {
                $fullname = $_POST['fullname'];
                $dateOfBirth = $_POST['dateOfBirth'];
                $contactNo = $_POST['contactNo'];
                $address = $_POST['address'];
                $sex = $_POST['sex'];

                // Verify the uniqueness of the Fullname (assuming Fullname is supposed to be unique)
                $fullname_query = mysqli_query($con, "SELECT Fullname FROM patients WHERE Fullname='$fullname'");
                $contactNo_query = mysqli_query($con, "SELECT ContactNo FROM patients WHERE ContactNo='$contactNo'");

                if (mysqli_num_rows($fullname_query) > 0) {
                    // Handle the Fullname is already in use case
                    $popupFailedNameMessage = "Name is already in use.";
                } elseif (mysqli_num_rows($contactNo_query) > 0) {
                    // Handle the Contact Number is already in use case
                    $popupFailedContactNoMessage = "Contact Number is already in use.";
                } else {
                    // Insert user data into the database
                    $query = "INSERT INTO patients (fullname, dateOfBirth, contactNo, address , sex) 
                              VALUES ('$fullname', '$dateOfBirth', '$contactNo', '$address', '$sex')";

                    $insert_result = mysqli_query($con, $query);
                    if ($insert_result) {
                        $popupMessage = "Congratulations! You are now registered to the Barangay Talon 3 Healthcare Center!";
                    } else {
                        $popupMessage = "Error occurred while registering.";
                    }
                }
            }
            ?>


            
           <div class="patient-registration"> <h2>Patient Registration</h2></div>
            <form action="" method="post">
                <div class="field-input">
                    <label for="fullname">Full Name</label>
                    <input type="text" name="fullname" id="fullname" autocomplete="off" required>
                </div>

                <div class="field-input" style="padding-top:20px">
                    <label for="dateOfBirth">Date of Birth</label>
                    <input type="date" name="dateOfBirth" id="dateOfBirth" required>
                </div>
                
                <div class="separate">
                <div class="field-input">
                    <label for="address">Complete Address</label>
                    <input type="text" name="address" id="address" autocomplete="off" required min="1">
                </div>
                <div class="field-input" style="padding-top:20px">
                    <label for="contactNo">Contact Number</label>
                    <input type="tel" name="contactNo" id="contact" autocomplete="off" required min="1">
                </div>
        <!-- Elements you want to move to the end -->
        
        <!-- Radio buttons can stay within the "separate" div as well -->
        
        <div class="sex-selector">
        <label for="sex">Male</label>
        <input type="radio" name="sex" id="sex" value="Male" autocomplete="off" required>
        <label for="sex">Female</label>
        <input type="radio" name="sex" id="sex" value="Female" autocomplete="off" required>
    </div></div>
    <button type="submit" name="submit" class="register-btn" value="Register">Register</button>
    
   
</div></form>
<div class="appointment">Already Registered?<a href="appointment.php">Book an Appointment now</a>
        </div> 
    
</body>
<script>
    function openAvailabilityPopup(availabilityMessage) {
        var popupAvailability = document.getElementById('popupAvailability');
        var availabilityMessageElement = document.getElementById('availabilityMessage');

        availabilityMessageElement.innerHTML = availabilityMessage;
        popupAvailability.style.display = 'block';
    }

    // Function to check availability
    function checkAvailability() {
        var selectedDate = document.getElementById('date').value;
        var selectedTime = document.getElementById('time').value;

        // You can send an AJAX request to your PHP script to check availability
        // and update the availabilityMessage with the response.

        // Example: Send an AJAX request to check_availability.php
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                var response = xhttp.responseText;
                openAvailabilityPopup(response);
            }
        };
        xhttp.open("POST", "check_availability.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("date=" + selectedDate + "&time=" + selectedTime);
    }

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
    }
</script>
</body>
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
    }
</script>
<div class="popup-container" id="popupSuccess" style="<?php echo !empty($popupMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupMessage; ?></p>
        <a href="appointment.php"><button class='failed-btn'>Book an Appointment</button></a>
        <span class="popup-close-btn" onclick="closePopup('popupSuccess')">&times;</span>
    </div>
</div>

<div class="popup-container" id="popupFailedName" style="<?php echo !empty($popupFailedNameMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupFailedNameMessage; ?></p>
        <a href="javascript:void(0);" onclick="history.back(); closePopup('popupFailedName');"><button class='failed-btn'>Retry</button></a>
        <span class="popup-close-btn" onclick="closePopup('popupFailedName')">&times;</span>
    </div>
</div>

<div class="popup-container" id="popupFailedContactNo" style="<?php echo !empty($popupFailedContactNoMessage) ? 'display:block;' : 'display:none;'; ?>">
    <div class='message'>
        <p><?php echo $popupFailedContactNoMessage; ?></p>
        <a href="javascript:void(0);" onclick="history.back(); closePopup('popupFailedContactNo');"><button class='failed-btn'>Retry</button></a>
        <span class="popup-close-btn" onclick="closePopup('popupFailedContactNo')">&times;</span>
    </div>
</div>

</html>