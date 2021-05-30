<?php
 	require('db.inc.php');
	require('function.php');
	$cid = $_GET['id'];
	$query = "DELETE FROM category WHERE id = '$cid'";
	$run = $conn->query($query);
	redirect('../admin.php?managecategory');
