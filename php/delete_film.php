<?php
	header('Content-Type: text/html; charset=utf-8');

	$host = 'localhost';
	$database = 'films'; 
	$user = 'root'; 
	$password = '';

	$conn = new mysqli($host, $user, $password, $database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	};
	
	switch ($_POST['Action']) {
		case "Delete":{
			$FilmId = $_POST['FilmId'];
			$query = "DELETE FROM `actormid` WHERE Id_film = '".$FilmId."'";
			$result = $conn->query($query);
			$query = "DELETE FROM `award` WHERE Id_film = '".$FilmId."'";
			$result = $conn->query($query);
			$query = "DELETE FROM `rating` WHERE Id_film = '".$FilmId."'";
			$result = $conn->query($query);
			$query = "DELETE FROM `film` WHERE Id = '".$FilmId."'";
			$result = $conn->query($query);
			header('Content-type: application/json');			
			echo json_encode($result);
		} break;
	default:
		{}
		break;
	}



		
	
	
	$conn->close();
?>