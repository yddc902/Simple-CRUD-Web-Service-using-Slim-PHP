<?php
	$conn = new mysqli('localhost', 'root', '', 'restapi');
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
} 

 