<?php
 	require('db.inc.php');
	require('function.php');
	$id = $_GET['id'];

	$query = "DELETE FROM menu WHERE id = '$id'";
	$run = $conn->query($query);
	$query = "DELETE FROM submenu WHERE parent_menu_id = '$id'";
	$run = $conn->query($query);
	
	header('../admin/index.php?managemenu');
?>
