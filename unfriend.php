<?php
  session_start();

  require_once "settings.php";	// Load MySQL log in credentials
  $conn = mysqli_connect ($host,$user,$pwd,$sql_db);	// Log in and use database
  
  $unfriend_id = (int) $_GET['id'];
  if($_SESSION['id'] != $unfriend_id) {
    // Deleting the friend relation
    $user_id = $_SESSION['id'];
    $query = "DELETE FROM myfriends WHERE ((friend_id1 = $unfriend_id AND friend_id2 = $user_id) OR (friend_id1 = $user_id AND friend_id2 = $unfriend_id));";
    mysqli_query($conn, $query);

    // Updating user's number of friends
    $query = "UPDATE friends SET num_of_friends = (SELECT COUNT(*) FROM myfriends WHERE friend_id1 = friend_id OR friend_id2 = friend_id) WHERE friend_id = $user_id;";
    mysqli_query($conn, $query);

    // Updating friend's number of friends
    $query = "UPDATE friends SET num_of_friends = (SELECT COUNT(*) FROM myfriends WHERE friend_id1 = friend_id OR friend_id2 = friend_id) WHERE friend_id = $unfriend_id;";
    mysqli_query($conn, $query);
  }

  header("Location: friendlist.php");
?>