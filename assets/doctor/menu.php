<?php
include "../config.php";

//Check if someone is logged in
if (!isset($_SESSION['doctor_id'])) {

	header('location:../../index.php');
}

$sessionUser = $_SESSION['doctor_id'];

$doctor_data = "SELECT * FROM doctor_table WHERE doctor_id='$sessionUser'";

$results = mysqli_query($conn, $doctor_data);

$doctor = mysqli_fetch_array($results);
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
			<a href="#"><img src="../img/logo.png" alt="logo"></a>
			<a href="#" class="navbar-brand mx-1">OUR Dermatology Clinic</a>

			<!-- Menu -->
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navmenu">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link" href="appointment_records.php">My Appointments</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="appointment_requests_list.php">Appointment Requests</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="patients.php">Patients</a>
					</li>

					<li class="nav-item">
						<div class="dropdown navbar-nav">
							<button class="pt-2 dropdown-toggle" id="dropdown_logout" data-bs-toggle="dropdown" aria-expanded="false">
								<span class="bi-person-fill"> Dr. </span><?php if (!empty($doctor['doctor_name'])) echo $doctor['doctor_name'];
																			else echo $doctor['doctor_usernaname']; ?>
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
	<div id="welcomeUser">
		<p>Welcome, Doctor <?php echo $doctor['doctor_name']; ?>!</p>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>

</html>