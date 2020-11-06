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
	<?php include('./includes/header.inc'); $page="friendadd"; ?>
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
				<li class="breadcrumb-item active" aria-current="true">Friend Add</li>
			</ol>
		</nav>
	</section>
	<section id="contact">
		<div class="table-responsive">
			<h2><?php echo $profile_name; ?>'s Add Friend Page</h2>
			<p class="text-center">You have <?php echo $num_friends; ?> friends</p>
		</div>
	</section>
	<section id="friendsForm">
		<?php 
		$query = "SELECT friend_id, profile_name FROM friends WHERE friend_id <> $id AND (SELECT COUNT(*) FROM myfriends WHERE ((friend_id1 = $id AND friend_id2 = friend_id) OR (friend_id1 = friend_id AND friend_id2 = $id))) = 0;";	
		if ($conn) { // connected
			$result = mysqli_query ($conn, $query);		
			if ($result) {	//   query was successfully executed
				$row_count = mysqli_num_rows($result);
				if($row_count) {
					$page_count = ceil($row_count / 5);
					// Get Page ID from URL
					$page_id = (int) $_GET['p'];
					if($page_id > 0 && $page_id <= $page_count) {
						$start_row_count = 5 * ($page_id - 1);
						$end_row_count = $start_row_count + (5 - 1);
						$result = mysqli_fetch_all($result);

						// Table for all non-friend users
						echo "<table class='table-bordered text-center center' id='friendsList'>";
						echo "<tr><th class='px-5 py-2'>Profile Name</th><th class='px-5 py-2'>Mutual Friends</th><th class='px-5 py-2'>Add Friend</th></tr>";
						$i = 0;
						foreach($result as $row) {
							if($i >= $start_row_count && $i <= $end_row_count && $i < $row_count) {
								$friend_id1 = $_SESSION['id'];
								$friend_id2 = $row[0];

								// friend_id1's all friends
								$query = "SELECT CASE WHEN friend_id1 = $friend_id1 THEN friend_id2 WHEN friend_id2 = $friend_id1 THEN friend_id1 ELSE -1 END AS all_friends FROM myfriends WHERE friend_id1 = $friend_id1 OR friend_id2 = $friend_id1;";
								$result = mysqli_query($conn, $query);
								$friend_id1_friends = array();
								if(mysqli_num_rows($result)) {
									$result = mysqli_fetch_all($result);
									foreach($result as $each_row) {
										$friend_id1_friends[] = $each_row[0];
									}
								}

								// friend_id2's all friends
								$query = "SELECT CASE WHEN friend_id1 = $friend_id2 THEN friend_id2 WHEN friend_id2 = $friend_id2 THEN friend_id1 ELSE -1 END AS all_friends FROM myfriends WHERE friend_id1 = $friend_id2 OR friend_id2 = $friend_id2;";
								$result = mysqli_query($conn, $query);
								$friend_id2_friends = array();
								if(mysqli_num_rows($result)) {
									$result = mysqli_fetch_all($result);
									foreach($result as $each_row) {
										$friend_id2_friends[] = $each_row[0];
									}
								}

								$mutual_friends = array_intersect($friend_id1_friends, $friend_id2_friends);
								$mutual_friends_count = count($mutual_friends);

								echo "<tr><td class='px-5 py-2'>$row[1]</td>";
								echo "<td class='px-5 py-2'>$mutual_friends_count mutual friends</td>";
								echo "<td class='px-5 py-2'><button class='btn btn-primary'><a style='text-decoration: none; color: white;' href='addfriend.php?page_id=$page_id&id=$row[0]'>Add as Friend</a></button></td></tr>";
							}
							$i++;
						}
						echo "</table>";

						// Prev and Next Page
						echo "<div class='d-flex justify-content-center my-5'>";
						if($page_id != 1) {
							$prev_page_id = $page_id - 1;
							echo "<button class='btn btn-primary mr-5'><a style='text-decoration: none; color: white;' href='friendadd.php?p=$prev_page_id'>Previous</a></button>";
						} if($page_id != $page_count) {
							$next_page_id = $page_id + 1;
							echo "<button class='btn btn-primary ml-5'><a style='text-decoration: none; color: white;' href='friendadd.php?p=$next_page_id'>Next</a></button>";
						}
						echo "</div>";
					} else {
						header("Location: friendadd.php?p=1");
					}
				} else {
					echo "<p class=\"text-center\">No record found.</p>";
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