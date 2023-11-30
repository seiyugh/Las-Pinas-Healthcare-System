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
      $msg = "Duplicate contact number, name or email address. Please enter a different account.";
  }else {
        // Update the database with the new values
        $sql = "UPDATE appointment SET fullname = '$fullname',email = '$email', address = '$address', contactNo = '$contactNo', sex = '$sex', time = '$time', date = '$date' WHERE id = '$id'";
        echo $sql;
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

   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
               <input type="tel" class="form-control rounded" name="contactNo" value="<?php echo $contactNo ?>" maxlength="11" required>
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

            <div class="row mb-3">
               <div class="col">
                  <label class="form-label">Time:</label>
                  <input type="time" class="form-control rounded" name="time" value="<?php echo $time ?>" required>
               </div>
               <div class="col">
                  <label class="form-label">Date:</label>
                  <input type="date" class="form-control rounded" name="date" value="<?php echo $date ?>" required>
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