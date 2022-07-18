<?php

include "dbConn.php";

//Initialize variables
$message = "";
$errors = array();
$username = "";
$email = "";
$patient_name = "";
$patient_sex = "";
$patient_age = "";
$patient_birthdate = "";
$patient_birthdate = "";
$patient_phone_no = "";
$patient_email = "";
$patient_address = "";
$patient_civil_status = "";
$patient_nationality = "";
$patient_religion = "";
$appointment_reason = "";
$appointment_comms = "";

// Sign UP
if (isset($_POST['sign_Up'])) {

	//Receive all input values from the form
	$username = mysqli_real_escape_string($conn, $_POST['patient_username']);
	$email = mysqli_real_escape_string($conn, $_POST['patient_email']);
	$password = mysqli_real_escape_string($conn, $_POST['patient_password']);
	$passwordConfirm = mysqli_real_escape_string($conn, $_POST['patient_passwordConfirm']);

	//Form validation: ensure that the form is correctly filled by adding (array_push()) corresponding error unto $errors array
	if (empty($username)) {

		array_push($errors, "Username is required");
	}

	if (empty($email)) {

		array_push($errors, "Email is required");
	}

	if (empty($password)) {

		array_push($errors, "Password is required");
	}

	if ($password != $passwordConfirm) {

		array_push($errors, "Passwords do not match!");
	}

	//First check the database to make sure a patient does not already exist with the same username and/or email
	$sql_query = "SELECT * FROM patient_table WHERE patient_username='$username' OR patient_email='$email' LIMIT 1";
	$result = mysqli_query($conn, $sql_query);
	$patient = mysqli_fetch_assoc($result);

	//If patient exists
	if ($patient) {

		if ($patient['patient_username'] === $username) {

			array_push($errors, "Username already exists!");
		}

		if ($patient['patient_email'] === $email) {
			array_push($errors, "Email already exists!");
		}
	}

	//Finally, register user if there are no errors in the form
	if (count($errors) == 0) {

		//Encrypt the password before saving in the database
		$password = md5($password);

		$sql_query = "INSERT INTO patient_table (patient_email, patient_username, patient_password) VALUES('$email', '$username', '$password')";

		mysqli_query($conn, $sql_query);

		$message = "Sign Up Successful! Set up your account now, and book an appointment!";
	}
}

// Patient Log in
if (isset($_POST['login_patient'])) {

	//Receive all input values from the form
	$username = mysqli_real_escape_string($conn, $_POST['patient_username']);
	$password = mysqli_real_escape_string($conn, $_POST['patient_password']);

	if (empty($username)) {

		array_push($errors, "Username is required");
	}

	if (empty($password)) {

		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		//Encrypt password to match from database
		$password = md5($password);

		$sql_query = "SELECT * FROM patient_table WHERE patient_username='$username' AND patient_password='$password'";
		$results = mysqli_query($conn, $sql_query);

		if (mysqli_num_rows($results) == 1) {

			$patient = mysqli_fetch_array($results);

			$_SESSION['patient_id'] = $patient['patient_id'];

			echo "<script>alert('Logged In Successfully!');</script>";
			echo "<script>window.location.href='assets/patient/menu.php'</script>";
		} else {

			array_push($errors, "Wrong username/password combination.");
		}
	}
}

// Patient Updates Profile
if (isset($_POST['patient_profile'])) {

	//Receive all input values from the form

	//Get all edited value from form
	$patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
	$patient_sex = mysqli_real_escape_string($conn, $_POST['patient_sex']);
	$patient_age = mysqli_real_escape_string($conn, $_POST['patient_age']);
	$patient_birthdate = mysqli_real_escape_string($conn, $_POST['patient_birthdate']);
	$patient_birthplace = mysqli_real_escape_string($conn, $_POST['patient_birthplace']);
	$patient_phone_no = mysqli_real_escape_string($conn, $_POST['patient_phone_no']);
	$patient_email = mysqli_real_escape_string($conn, $_POST['patient_email']);
	$patient_address = mysqli_real_escape_string($conn, $_POST['patient_address']);
	$patient_civil_status = mysqli_real_escape_string($conn, $_POST['patient_civil_status']);
	$patient_nationality = mysqli_real_escape_string($conn, $_POST['patient_nationality']);
	$patient_religion = mysqli_real_escape_string($conn, $_POST['patient_religion']);

	//Get patients row on the table
	$patient_id = $_SESSION['patient_id'];

	$sql_query = "SELECT * FROM patient_table WHERE patient_id='$patient_id'";
	$results = mysqli_query($conn, $sql_query);

	if (mysqli_num_rows($results) == 1) {

		if (!empty($patient_name)) {

			$sql_query = "UPDATE patient_table SET patient_name = '$patient_name' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_sex)) {

			$sql_query = "UPDATE patient_table SET patient_sex = '$patient_sex' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_age)) {

			$sql_query = "UPDATE patient_table SET patient_age = '$patient_age' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_birthdate)) {

			$sql_query = "UPDATE patient_table SET patient_birthdate = '$patient_birthdate' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_birthplace)) {

			$sql_query = "UPDATE patient_table SET patient_birthplace = '$patient_birthplace' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_phone_no)) {

			$sql_query = "UPDATE patient_table SET patient_phone_no = '$patient_phone_no' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_email)) {

			$sql_query = "UPDATE patient_table SET patient_email = '$patient_email' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_address)) {

			$sql_query = "UPDATE patient_table SET patient_address = '$patient_address' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_civil_status)) {

			$sql_query = "UPDATE patient_table SET patient_civil_status = '$patient_civil_status' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_nationality)) {

			$sql_query = "UPDATE patient_table SET patient_nationality = '$patient_nationality' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($patient_religion)) {

			$sql_query = "UPDATE patient_table SET patient_religion = '$patient_religion' WHERE patient_id='$patient_id'";
			mysqli_query($conn, $sql_query);
		}

		$message = "Changes saved!";
	}
}

// Patient Makes Appointment Request
if (isset($_POST['request'])) {

	$patient_id = $_SESSION['patient_id'];
	$appointment_reason = mysqli_real_escape_string($conn, $_POST['appointment_reason']);
	$appointment_comms = mysqli_real_escape_string($conn, $_POST['appointment_comms']);

	if (empty($appointment_reason) && empty($appointment_comms)) {

		array_push($errors, "Empty Request!");
	}

	if (empty($appointment_reason)) {

		array_push($errors, "No Reason for Appointment");
	}

	if (empty($appointment_comms)) {

		array_push($errors, "No type of Communication");
	}

	if (count($errors) == 0) {

		$sql_query = "INSERT INTO appointment_table (patient_id, appointment_reason, appointment_comms) VALUES('$patient_id', '$appointment_reason', '$appointment_comms')";
		mysqli_query($conn, $sql_query);

		$message = "Request Sent!";
	}
}

// Doctor Log In
if (isset($_POST['login_doctor'])) {

	//Receive all input values from the form
	$username = mysqli_real_escape_string($conn, $_POST['doctor_username']);
	$password = mysqli_real_escape_string($conn, $_POST['doctor_password']);

	if (empty($username)) {

		array_push($errors, "Username is required");
	}

	if (empty($password)) {

		array_push($errors, "Password is required");
	}

	if (count($errors) == 0) {

		//Encrypt password to match from database
		$password = md5($password);

		$sql_query = "SELECT * FROM doctor_table WHERE doctor_username='$username' AND doctor_password='$password'";
		$results = mysqli_query($conn, $sql_query);

		if (mysqli_num_rows($results) == 1) {

			$doctor = mysqli_fetch_array($results);

			$_SESSION['doctor_id'] = $doctor['doctor_id'];

			echo "<script>alert('Logged In Successfully!');</script>";
			echo "<script>window.location.href='assets/doctor/menu.php'</script>";
		} else {

			array_push($errors, "Wrong username/password combination");
		}
	}
}

// Doctor Accepts an Apponitement
if (isset($_POST['accept_appointment'])) {
	$appointment_id = mysqli_real_escape_string($conn, $_POST['accept_appointment']);
	$appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);

	$sql_query = "SELECT * FROM appointment_table WHERE appointment_id ='$appointment_id'";
	$results = mysqli_query($conn, $sql_query);

	if (mysqli_num_rows($results) == 1) {

		$sql_query = "UPDATE appointment_table SET doctor_id = '$_SESSION[doctor_id]', appointment_date = '$appointment_date', appointment_status = 'Scheduled' WHERE appointment_id ='$appointment_id'";
		mysqli_query($conn, $sql_query);

		$message = "Appointment Request is Scheduled!";
	}
}

// Doctor Sets Apponitement Status to Complete
if (isset($_POST['complete_appointment'])) {
	$appointment_id = mysqli_real_escape_string($conn, $_POST['complete_appointment']);

	$sql_query = "SELECT * FROM appointment_table WHERE appointment_id ='$appointment_id'";
	$results = mysqli_query($conn, $sql_query);

	if (mysqli_num_rows($results) == 1) {
		$sql_query = "UPDATE appointment_table SET appointment_status = 'Completed' WHERE appointment_id ='$appointment_id'";
		mysqli_query($conn, $sql_query);

		$sql_query = "UPDATE appointment_table SET appointment_status = 'Completed' WHERE appointment_id ='$appointment_id'";
		mysqli_query($conn, $sql_query);

		$message = "Appointment Status is Updated!";
	}
}

// Doctor Updates Profile
if (isset($_POST['doctor_profile'])) {

	//Receive all input values from the form

	//Get all edited value from form
	$doctor_name = mysqli_real_escape_string($conn, $_POST['doctor_name']);
	$doctor_sex = mysqli_real_escape_string($conn, $_POST['doctor_sex']);
	$doctor_age = mysqli_real_escape_string($conn, $_POST['doctor_age']);
	$doctor_birthdate = mysqli_real_escape_string($conn, $_POST['doctor_birthdate']);
	$doctor_phone_no = mysqli_real_escape_string($conn, $_POST['doctor_phone_no']);
	$doctor_email = mysqli_real_escape_string($conn, $_POST['doctor_email']);
	$doctor_address = mysqli_real_escape_string($conn, $_POST['doctor_address']);

	//Get doctors row on the table
	$doctor_id = $_SESSION['doctor_id'];

	$sql_query = "SELECT * FROM doctor_table WHERE doctor_id='$doctor_id'";
	$results = mysqli_query($conn, $sql_query);

	if (mysqli_num_rows($results) == 1) {

		if (!empty($doctor_name)) {

			$sql_query = "UPDATE doctor_table SET doctor_name = '$doctor_name' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_sex)) {

			$sql_query = "UPDATE doctor_table SET doctor_sex = '$doctor_sex' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_age)) {

			$sql_query = "UPDATE doctor_table SET doctor_age = '$doctor_age' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_birthdate)) {

			$sql_query = "UPDATE doctor_table SET doctor_birthdate = '$doctor_birthdate' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_birthplace)) {

			$sql_query = "UPDATE doctor_table SET doctor_birthplace = '$doctor_birthplace' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_phone_no)) {

			$sql_query = "UPDATE doctor_table SET doctor_phone_no = '$doctor_phone_no' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_email)) {

			$sql_query = "UPDATE doctor_table SET doctor_email = '$doctor_email' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		if (!empty($doctor_address)) {

			$sql_query = "UPDATE doctor_table SET doctor_address = '$doctor_address' WHERE doctor_id='$doctor_id'";
			mysqli_query($conn, $sql_query);
		}

		$message = "Changes saved!";
	}
}
