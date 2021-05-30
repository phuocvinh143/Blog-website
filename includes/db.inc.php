<?php
	session_start();
	$host='db';
	$user='root';
	$password='root';
	$db='myblog';

	$conn = new mysqli($host, $user, $password, $db);
