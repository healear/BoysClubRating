<?php
	header('Content-Type: text/html; charset=utf-8');

	$host = 'localhost'; // ����� ������� 
	$database = 'films'; // ��� ���� ������
	$user = 'root'; // ��� ������������
	$password = ''; // ������

	$conn = new mysqli($host, $user, $password, $database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	switch ($_POST['Action']) {
		//������
		case "Update":{
			$result_array = array();
			$FilmId = $_POST['FilmId'];
			$ActorsId = $_POST['ActorsId'];
			$Actors = $_POST['Actors'];
			$query = "DELETE FROM `actormid` WHERE actormid.Id_film = '".$FilmId."'";//�������� ������� ���� ������� � ��������� ������, ����� ����� ����� �������� �� �� ��
			$result = $conn->query($query);
			//��������� ����� ������� � ������ ������� (������ ������ ����� �� ��������� ��� ��� � ������� ���������� ���� - ���))
			for ($i = 0; $i<count($Actors); $i++)
			{
				$query = "INSERT INTO `actor` (`Id`, `Name`) VALUES (NULL, '".$Actors[$i]."')";
				$result = $conn->query($query);
				$query = "SELECT `Id` FROM `actor` WHERE `Name` = '".$Actors[$i]."'";
				$result = $conn->query($query);
				array_push($result_array, $result->fetch_assoc()["Id"]);
			}
			
			$query = "SELECT `Id` FROM `actor` JOIN `actormid` ON ";

			for ($i = 0; $i<count($result_array); $i++){
				$query = "INSERT INTO `actormid` (`Id`, `Id_actor`, `Id_film`) VALUES (NULL, '" . $result_array[$i] . "', '".$FilmId."')"; //�������� ��������� ������� ��� �������
				$result = $conn->query($query);
			}

			header('Content-type: application/json');
			
			echo json_encode($result_array);
		} break;

		case"Awards":{
			$FilmId = $_POST['FilmId'];
			$Awards = $_POST['Awards'];
			$query = "DELETE FROM `award` WHERE award.Id_film = '".$FilmId."'"; //������� ��� ������� � �������� �������
			$result = $conn->query($query);
			for ($i = 0; $i<count($Awards); $i++)
			{
				$query = "INSERT INTO `award` (`Id`, `Name`, `Id_film`) VALUES (NULL, '".$Awards[$i]."', '".$FilmId."')";
				$result = $conn->query($query);
			}
			header('Content-type: application/json');
			echo json_encode($result);
		} break;

		case"Rest":{
			$Id = $_POST['Id'];
			$Name = $_POST['Name'];
			$Year = $_POST['Year'];
			$Country = $_POST['Country'];
			$Genre = $_POST['Genre'];
			$query = "UPDATE film SET `Name` = '".$Name."', `Year` = '".$Year."', `Country` = '".$Country."', `Genre` = '".$Genre."' WHERE `Id` = '".$Id."'";
			$result = $conn->query($query);
			header('Content-type: application/json');
			echo json_encode($result);
		} break;
	default:
		{}
		break;
}




?>