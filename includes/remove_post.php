<?php
	require('db.inc.php');

	$id = $_GET['id'];	

	// delete image in server storage
	$query = "SELECT image FROM images WHERE post_id = '$id'";
	$run = $conn->query($query);
	while ($d = $run->fetch_assoc()) {
		unlink('../images/'. $d['image']);
	}

	// delete image in Database
	$query = "DELETE FROM images WHERE post_id = '$id'";
	$run = $conn->query($query);

	// delete post
	$query = "DELETE FROM posts WHERE id = '$id'";
	$run = $conn->query($query);

	header('location:../admin.php?managepost');
?>

