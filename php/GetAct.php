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

	switch ($_GET['Action']) {
		case "GetAct":{
			$result_array = array();
			$FilmId = $_GET['FilmId'];
			$Actors = $_GET['Actors'];

			for ($i = 0; $i<count($Actors); $i++)
			{
				$query = "SELECT `Id_actor` FROM `actormid` JOIN `actor` ON actor.`Name` = '".$Actors[$i]."' AND actor.Id = actormid.Id_actor AND actormid.Id_film ='".$FilmId."'";
				$result = $conn->query($query);
				if ($result->num_rows>0)
				{
					while ($row = $result->fetch_assoc())
					{
						array_push($result_array,$row);
					}
				}
			}
			header('Content-type: application/json');			
			echo json_encode($result_array);
		} break;
	default:
		{}
		break;
	}




?>