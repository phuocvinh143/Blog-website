<?php
	require('function.php');
	session_start();
	session_destroy();
	redirect('../index.php?page=1');
