<?php
	function sanitise_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	require_once "settings.php";	// Load MySQL log in credentials
	$conn = mysqli_connect ($host,$user,$pwd,$sql_db);
	$username = ""; 
	$profile = ""; 
	$password = "";
	$conpassword = "";
	$server_date = date('Y-m-d');
	$err_msg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(sanitise_input($_POST["username"]) == "") {
			$err_msg .= "Please enter a username.";
		} else {
			  
			$sql = "SELECT friend_id FROM friends WHERE friend_email = ?";
			
			if($stmt = mysqli_prepare($conn, $sql)) {
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				$param_username = sanitise_input($_POST["username"]);

				if(mysqli_stmt_execute($stmt)) {

					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1) {
						$err_msg .= "This email already exists.";
					} else {
						$username = sanitise_input($_POST["username"]);
					}

				} else {
					echo "Something went wrong. Please try again later.";
				}
				mysqli_stmt_close($stmt);
			}
		}

		if(trim($_POST["profile"]) == "") {
			$err_msg .= "Please enter a profile name.";     
		} elseif(!preg_match('/^[A-Za-z ]+$/', trim($_POST["profile"]))) {
			$err_msg .= "Profile name must contain only letters."; 
		}
		else {
			$profile = trim($_POST["profile"]);
		}

		if(trim($_POST["password"]) == "") {
			$err_msg .= "Please enter a password.";     
		} elseif(!preg_match('/^[A-Za-z0-9]+$/', trim($_POST["password"]))) {
			$err_msg .= "Password must contain only letters and numbers."; 
		}
		else {
			$password = trim($_POST["password"]);
		}

		if(trim($_POST["conpassword"]) == "") {
			$err_msg .= "Please confirm password.";     
		} elseif(trim($_POST["conpassword"]) != trim($_POST["password"])) {
			$err_msg .= "Passwords don't match."; 
		}
		else {
			$conpassword = trim($_POST["conpassword"]);
		}

		if(empty($err_msg)) {
			$sql = "INSERT INTO friends (friend_email, profile_name, password, date_started) VALUES ('$username', '$profile', '$password', '$server_date')";
			$insert_result = mysqli_query ($conn, $sql);

			if ($insert_result) {	//   insert successfully 
				session_start();
				$_SESSION['loggedin'] = 'true';
				header("location:friendadd.php");
				exit();
			} else {
				$err_msg= "<p>Insert unsuccessful.</p>";
			}
		}
	}		
		// Close connection
		mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('./includes/header.inc'); $page="sign"; ?>
</head>
<!-- Body begin -->

<body>
	<!-- Navigation -->
	<header id="nav-bar">
		<?php include('./includes/nav.inc') ?>
	</header>
	<!-- Breadcrumbs -->
	<section id="breadcrumb-section">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="true">Sign Up</li>
			</ol>
		</nav>
	</section>
	<section id="contact">
		<h2>Sign Up</h2>
	</section>

	<section id="signupForm">
		<div class="container">
		<?php if($err_msg != "") { ?>
		<div class="alert alert-danger" role="alert">
			<?php echo $err_msg ?>
		</div>
		<?php } ?>

			<form action method="post">
				<div class="form-group">
					<label for="username">Email:</label>
					<input class="form-control" type="email" name="username" id="username" maxlength="25" size="25"
						required value="<?php echo $username; ?>" />
				</div>
				<div class="form-group">
					<label for="profile">Profile Name:</label>
					<input class="form-control" type="text" name="profile" id="profile" maxlength="25" size="25"
						required value="<?php echo $profile; ?>" />
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input class="form-control" type="password" name="password" id="password" maxlength="25" size="25"
						required />
				</div>
				<div class="form-group">
					<label for="conpassword">Confirm Password:</label>
					<input class="form-control" type="password" name="conpassword" id="conpassword" maxlength="25"
						size="25" required />
				</div>
				<button type="submit" name="submit" class="btn btn-primary">Sign Up</button>
				<p>Already have an account? <a href="login.php">Login here</a></p>
			</form>
		</div>
	</section>

	<!-- Footer -->
	<footer>
		<?php include('./includes/footer.inc') ?>
	</footer>
</body>

</html>