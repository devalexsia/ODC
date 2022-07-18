<?php
include "../config.php";

//Check if someone is logged in
if (!isset($_SESSION['patient_id'])) {

    header('location:../../index.php');
}

$sessionUser = $_SESSION['patient_id'];

$patient_data = "SELECT * FROM patient_table WHERE patient_id='$sessionUser'";

$results = mysqli_query($conn, $patient_data);

$patient = mysqli_fetch_array($results);

$appointment_qry = "SELECT appointment_reason, appointment_comms, appointment_date, appointment_status FROM appointment_table WHERE patient_id='$sessionUser'";

$results = mysqli_query($conn, $appointment_qry);

$row_count = mysqli_num_rows($results);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>ODC E-Checkup</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-2 fixed-top">
        <div class="container">
            <!-- Branding -->
            <a href="menu.php"><img src="../img/logo.png" alt="logo"></a>
            <a href="menu.php" class="navbar-brand mx-1">OUR Dermatology Clinic</a>

            <!-- Menu -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="request_appointment.php">Request Appointment</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Appointment Record</a>
                    </li>

                    <li class="nav-item">
                        <div class="dropdown navbar-nav">
                            <button class="pt-2 dropdown-toggle" id="dropdown_logout" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="bi-person-fill"> </span><?php if (!empty($patient['patient_name'])) echo $patient['patient_name'];
                                                                        else echo $patient['patient_username']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdown_logout">
                                <li><a class="dropdown-item" data-bs-toggle="modal" onClick="location.href='profile.php'">Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" href="../logout.php">Log out</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Appointment Records -->
    <section>
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="h2">Appointment Records</span>
                        </div>
                        <div class="card-body">
                            <div class="container table-responsive-md">
                                <table class="table table-light caption-top">
                                    <thead>
                                        <th>No.</th>
                                        <th>Reason</th>
                                        <th>Communication</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php
                                        $appointment_number = 1;
                                        while ($appointments = mysqli_fetch_assoc($results)) {

                                            echo "<tr><td>" . $appointment_number . "</td><td>" .
                                                $appointments["appointment_reason"] . "</td><td>" .
                                                $appointments["appointment_comms"] . "</td><td>" .
                                                $appointments["appointment_date"] . "</td><td>" .
                                                $appointments["appointment_status"] . "</td></tr>";
                                            $appointment_number++;
                                        }

                                        echo "</table>";
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>