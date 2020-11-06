<?php
  session_start();

  require_once "settings.php";	// Load MySQL log in credentials
  $conn = mysqli_connect ($host,$user,$pwd,$sql_db);	// Log in and use database

  $friend_id1 = $_SESSION['id'];
  $friend_id2 = $_GET['id'];
  $page_id = $_GET['page_id'];

  if($friend_id1 != $friend_id2) {
    // Check if they're already friends
    $query = "SELECT * FROM myfriends WHERE (friend_id1 = $friend_id1 AND friend_id2 = $friend_id2) OR (friend_id1 = $friend_id2 AND friend_id2 = $friend_id1);";
    $result = mysqli_query($conn, $query);
    if(!mysqli_num_rows($result)) { // they're not already friends
      $query = "INSERT myfriends(friend_id1, friend_id2) VALUES($friend_id1, $friend_id2);";
      mysqli_query($conn, $query);

      // Updating friend_id1's number of friends
      $query = "UPDATE friends SET num_of_friends = (SELECT COUNT(*) FROM myfriends WHERE friend_id1 = friend_id OR friend_id2 = friend_id) WHERE friend_id = $friend_id1;";
      mysqli_query($conn, $query);

      // Updating friend_id2's number of friends
      $query = "UPDATE friends SET num_of_friends = (SELECT COUNT(*) FROM myfriends WHERE friend_id1 = friend_id OR friend_id2 = friend_id) WHERE friend_id = $friend_id2;";
      mysqli_query($conn, $query);
    }
  }

  header("Location: friendadd.php?p=$page_id");
?>