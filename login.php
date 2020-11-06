<?php
	$page="login";
	function sanitise_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ 	//If already logged in, then go to manager page
		header("location: friendlist.php");
		exit;
	}
	require_once "settings.php";	// Load MySQL log in credentials
	$conn = mysqli_connect ($host,$user,$pwd,$sql_db);
	$username = ""; 
	$entered_password = "";
	$err_msg = "";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if (sanitise_input($_POST["username"]) == ""){
			$err_msg .= "Please enter username.";
		} else{
			$username = sanitise_input($_POST["username"]);
		}
		if (trim($_POST["password"]) == ""){
			$err_msg .= "Please enter your password.";
		} else{
			$entered_password = trim($_POST["password"]);
		}
		if ($err_msg == "") {
			$query="SELECT friend_id, friend_email, profile_name, password FROM friends WHERE friend_email = '$username' and password = '$entered_password'";
			if ($conn) { // connected
				$result = mysqli_query ($conn, $query);		
				if (mysqli_num_rows($result) == 1) {	//   query was successfully executed
					$record = mysqli_fetch_assoc ($result);
					$profile_name = "{$record['profile_name']}";
					$id = "{$record['friend_id']}";
					session_start();
					$_SESSION["loggedin"] = true;
					$_SESSION["profile_name"] = $profile_name;
					$_SESSION["id"] = $id;
					//$_SESSION["username"] = $username;                  
					// Redirect user to friendlist page
					header("location:friendlist.php");
				} else {
					// Display an error message
					$err_msg .= "Invalid password or username entered.";
				}
			}
		}

    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./includes/header.inc'); ?>
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
           <li class="breadcrumb-item active" aria-current="true">Login</li>
         </ol>
       </nav>
   </section>
   <section id="contact">
		<h2>Login</h2> 
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
				<input class="form-control" type="text" name="username" id="username" maxlength="25" size="25" required value="<?php echo $username; ?>" />
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input class="form-control" type="password" name="password" id="password" maxlength="25" size="25" required />
			</div>  
			<button type="submit" name="submit" class="btn btn-primary">Login</button>
			<p>Don't have an account? <a href="sign-up.php">Sign up here</a></p>
		</form>
	</div>
	</section>
   <!-- Footer -->
   <footer>
    <?php include('./includes/footer.inc'); ?>
	</footer>
</body>
</html>