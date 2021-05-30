<?php 
	require('db.inc.php');
	$id = $_GET['post_id'];
	$query = "SELECT title, content, category_id FROM posts WHERE id = $id";
	$run = mysqli_query($conn, $query);
	$reviews = mysqli_fetch_all($run, MYSQLI_ASSOC);
	echo json_encode($reviews);
