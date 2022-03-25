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
	
	switch( $_POST['Action'] ) {
		case "Create":{
		   $result_array = array();
			$Name = $_POST['Name'];
			$Year = $_POST['Year'];
			$Country = $_POST['Country'];
			$Genre = $_POST['Genre'];
			$Actors = $_POST['Actors'];
			$Awards = $_POST['Awards'];
			$query = "INSERT INTO `film` (`Id`, `Name`, `Year`, `Country`,`Genre`) VALUES (NULL, '" . $Name . "', ' " . $Year . " ', ' " . $Country . " ', ' " . $Genre . " ');";
			$result = $conn->query($query);
			$filmId = $conn->insert_id;
			for ($i = 0; $i<count($Actors); $i++)
			{
				$query1 = "INSERT INTO `actor` (`Id`, `Name`) VALUES (NULL, '" . $Actors[$i] . "');";
				$result = $conn->query($query1);
				$lastInsertId = $conn->insert_id;
				//get the ids of Actors
				$queryId = "SELECT Id FROM `actor` WHERE (Name = '".$Actors[$i]."')";
				$actorId = $conn->query($queryId);
				if ($actorId->num_rows!=0){
				$query2 = "INSERT INTO `actormid` (`Id`,`Id_actor`,`Id_film`) VALUES (NULL, '" . $actorId->fetch_assoc()["Id"] . "', '" . $filmId . "');";
				$result = $conn->query($query2);
				}
				else{
				$query2 = "INSERT INTO `actormid` (`Id`,`Id_actor`,`Id_film`) VALUES (NULL, '" . $lastInsertId . "', '" . $filmId . "');";
				$result = $conn->query($query2);
				}
			}
			for ($i = 0; $i<count($Awards); $i++)
			{
				$query = "INSERT INTO `award` (`Id`, `Name`, `Id_film`) VALUES (NULL, '". $Awards[$i] ."', '". $filmId ."')";
				$result = $conn->query($query);
			}
			header('Content-type: application/json');
			echo json_encode(count($result));
		}break;

		case "GetGroups":{
			$result_array = array();
			$query = "SELECT * FROM groups WHERE 1"; // Query

			$result = $conn->query($query);

			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					array_push($result_array, $row);
				}
			}
			header('Content-type: application/json');
			echo json_encode($result_array);
		}break;

		case "Delete":{
		   $result_array = array();
			$query = "DELETE FROM students WHERE Id = ". $_POST['Id'] . ""; // Query

			$result = $conn->query($query);

			header('Content-type: application/json');
			echo json_encode($query);
		}break;

		case "Update":{
			$result_array = array();
			$Id = $_POST['Id'];
			$name = $_POST['Name'];
			$Birthday = $_POST['Birthday'];
			$GroupId = $_POST['Group'];
			$query = "UPDATE `students` SET `Fio` = '" . $name . "', `Birthday` = '" . $Birthday . "', `GroupId` = '" . $GroupId . "' WHERE `Id` = '" . $Id . "'";

			$result = $conn->query($query);

			header('Content-type: application/json');
			echo json_encode($query);
		}break;
		
		default: {
		  // do not forget to return default data, if you need it...
		}
	}



		
	
	
	$conn->close();
?>