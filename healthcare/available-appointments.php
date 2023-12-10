<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Appointments</title>
    <link rel="stylesheet" href="styles/avail-appointments.css">
</head>

<body>
    <h2>Available Appointments</h2>
    <div class="popup-container" id="availableAppointmentsPopup">
        <h3>Select an Appointment</h3>
        <div id="popupAppointments">
            <?php
            // Include the fetch-appointments.php file to echo the table HTML
            include 'fetch-appointments.php';
            ?>
        </div>
        <a href="appointment.php">Back</a>
    </div>
    <script>

document.addEventListener('DOMContentLoaded', function () {
            var appointmentSlots = document.querySelectorAll('.appointmentSlot');

            appointmentSlots.forEach(function (slot) {
                slot.addEventListener('click', function () {
                    // Extract the date and time from the appointment slot text
                    var slotText = slot.innerText;
                    var dateAndTime = slotText.split(' - ');

                    // Redirect to appointment.php with selected date and time as query parameters
                    window.location.href = 'appointment.php?date=' + encodeURIComponent(dateAndTime[0]) +
                        '&time=' + encodeURIComponent(dateAndTime[1]);
                });
            });


        function openPopup() {
            document.getElementById('availableAppointmentsPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('availableAppointmentsPopup').style.display = 'none';
        }

        function selectAppointment(selectedDate, selectedTime) {
            // Redirect to appointment.php with selected date and time as query parameters
            window.location.href = 'appointment.php?date=' + encodeURIComponent(selectedDate) +
                '&time=' + encodeURIComponent(selectedTime);
        }

        // Fetch modified appointments and update the UI
        function fetchModifiedAppointments() {
            fetch('modify-appointments.php')
                .then(response => response.json())
                .then(modifiedAppointments => {
                    // Clear existing appointments
                    document.getElementById('popupAppointments').innerHTML = '';

                    // Update the UI with the fetched appointments
                    modifiedAppointments.forEach(appointment => {
                        const appointmentSlot = document.createElement('div');
                        appointmentSlot.className = 'appointmentSlot';
                        appointmentSlot.innerHTML = `${appointment.date} - ${appointment.time} (Modified)`;
                        appointmentSlot.onclick = function () {
                            selectAppointment(appointment.date, appointment.time);
                        };

                        document.getElementById('popupAppointments').appendChild(appointmentSlot);
                    });
                })
                .catch(error => console.error('Error fetching modified appointments:', error));
        }

        // Open the popup when the page loads (you can trigger this event as needed)
        window.addEventListener('load', function () {
            openPopup();
            // Fetch and display modified appointments
            fetchModifiedAppointments();
        });

});
    </script>

</body>

</html>
