<?php

	header('Content-Type: text/html; charset=utf-8');

	$host = 'localhost'; // адрес сервера 
	$database = 'films'; // имя базы данных
	$user = 'root'; // имя пользователя
	$password = ''; // пароль

	$conn = new mysqli($host, $user, $password, $database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	switch ($_GET['Action']) 
	{
		case "GetId":
		{
			$Name = $_GET['Name'];
			$Pas = $_GET['Pas'];
			$querry = "SELECT Id FROM `user` WHERE Name = '".$Name."' AND Password = '".$Pas."'";
			$result = $conn->query($querry);
			header('Content-type: application/json');
			echo json_encode($result->fetch_assoc());		
		}
		break;
	};





?>