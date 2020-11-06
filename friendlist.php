<?php
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login.php");
		exit;
	} else {
		$profile_name = $_SESSION["profile_name"];
		$id = $_SESSION["id"];
	}
	$query = "SELECT * FROM friends WHERE friend_id='$id';";	
	
	require_once "settings.php";	// Load MySQL log in credentials
	$conn = mysqli_connect ($host,$user,$pwd,$sql_db);	// Log in and use database

	if ($conn) { // connected
		$result = mysqli_query ($conn, $query);		
		if ($result) {	//   query was successfully executed
			$record = mysqli_fetch_assoc ($result);
			if ($record) { //   record exists
				$num_friends = "{$record['num_of_friends']}";	
				mysqli_free_result ($result);
			} else {
				echo "<p class=\"text-center\">No record found.</p>";
			}
		} else {
			echo "<p>Friends table doesn't exist or select operation unsuccessful.</p>";
		}
		//mysqli_close ($conn);	// Close the database connection
	} else {
		echo "<p>Unable to connect to the database.</p>";
	}




?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include('./includes/header.inc'); $page="friendlist"; ?>
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
				<li class="breadcrumb-item active" aria-current="true">Friend List</li>
			</ol>
		</nav>
	</section>
	<section id="contact">
		<h2><?php echo $profile_name; ?>'s Friend List</h2>
		<p class="text-center">You have <?php echo $num_friends; ?> friends</p>
	</section>
	<section id="friendsForm">
		<?php 
		$query = "SELECT friend_id, profile_name FROM friends WHERE 
								(
									SELECT COUNT(*) FROM myfriends WHERE
										CASE 
											WHEN friend_id1 = $id THEN friend_id2 = friend_id
											WHEN friend_id2 = $id THEN friend_id1 = friend_id
											ELSE friend_id1 = -1
										END                                        
								) = 1;";
		if ($conn) { // connected
			$result = mysqli_query ($conn, $query);
				if ($result) { 	//   query was successfully executed
					$numrows = mysqli_num_rows($result);
					if ($numrows == 0) {
						echo "<h5 class='text-center'>You have no friends. :(</h5>";
					} else {
						echo "<table class='table-bordered text-center center' id='friendsList'>";
						echo "<tr><th class='px-5 py-2'>Friend Name</th><th class='px-5 py-2'>Unfriend</th></tr>";
						while($row = mysqli_fetch_assoc($result)) {
							echo "<tr><td class='px-5 py-2'>{$row['profile_name']}</td>";
							echo "<td class='px-5 py-2'><button class='btn btn-danger'><a style='color: white; text-decoration: none;' href='unfriend.php?id={$row['friend_id']}'>Unfriend</a></button></td></tr>";
						}
						echo "</table>";
					}
			} else {
				echo "<p>Friends table doesn't exist or select operation unsuccessful.</p>";
			}
			mysqli_close ($conn);	// Close the database connection
		} else {
			echo "<p>Unable to connect to the database.</p>";
		}
	
	?>
	</section>

	<!-- Footer -->
	<footer>
		<?php include('./includes/footer.inc') ?>
	</footer>
</body>

</html>