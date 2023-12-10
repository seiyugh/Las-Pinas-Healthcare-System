<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Appointment Records</title>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="background-color: rgba(151, 254, 237, 0.6); justify-content:center; padding: 0;">
    <div class="navbar navbar-expand-lg" style="background-color: rgba(147, 215, 214, 0.6);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mx-3" id="patient-registered" href="patient-registered.php">Patients Registered</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-3 rounded" href="appointment-history.php" style="background-color: rgba(0, 0, 0, 0.7); color: white;">Appointment History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link rounded mx-3" href="appointment-records.php">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fa fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="php/logout.php"><i class="fa fa-sign-out"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container mt-4 justify-content-center">
        <?php
        $errorMsg = '';

        if (isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            // Add your styling for the success message
            $msgStyle = 'color: green; font-weight: bold; background-color: #0B666A';
        } else {
            $msg = ''; // No message by default
            $msgStyle = ''; // Default styling
        }

        if (isset($_GET["msg"])) {
            $msg = $_GET["msg"];
            echo '<div class="alert alert-warning alert-dismissible mx-auto text-center" role="alert" style="max-height: 100px;">
                ' . $msg . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>

<div class="table-responsive mx-1 w-100" style="background-color: rgba(147,215,214, 0.6); max-width:120vw; border-radius:10px">
    <table class="table table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Fullname</th>
                <th scope="col">Contact Number</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Age</th>
                <th scope="col">Sex</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if the deletedId parameter is set
            if (isset($_GET['deletedId'])) {
                $deletedId = $_GET['deletedId'];
                // Use $deletedId as needed (e.g., display a message or perform further actions)
            }

            include "php/config.php";
            $sql = "SELECT * FROM `deleted_appointments`";
            $result = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr style="font-size: large">
                    <td><?php echo $row["id"] ?></td>
                    <td><?php echo $row["fullname"] ?></td>
                    <td><?php echo $row["contactNo"] ?></td>
                    <td><?php echo $row["email"] ?></td>
                    <td><?php echo $row["address"] ?></td>
                    <td><?php echo $row["age"] ?></td>
                    <td><?php echo $row["sex"] ?></td>
                    <td><?php echo $row["date"] ?></td>
                    <td><?php echo $row["time"] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

<script>
      function confirmDelete(userId) {
            var result = window.confirm("Are you sure you want to delete this appointment?");
            if (result) {
                // If the user confirms, redirect to the delete script with the appointment ID
                window.location.href = "delete-appointment.php?id=" + userId + "&redirect=appointment-history.php";
            }
        }
</script>
</html>
