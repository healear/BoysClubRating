<?php
	header('Content-Type: text/html; charset=utf-8');

	$host = 'localhost'; // ????? ??????? 
	$database = 'films'; // ??? ???? ??????
	$user = 'root'; // ??? ????????????
	$password = ''; // ??????

	$conn = new mysqli($host, $user, $password, $database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	};
	switch($_POST['Action']){
		case "Update":{
			$result_array = array();
			$Id = $_POST['Id'];
			$UId = $_POST['UId'];
			$Rating = $_POST['Rating'];
			$querry = "DELETE FROM `rating` WHERE rating.Id_user = '".$UId."' AND rating.Id_film = '".$Id."';";
			$conn->query($querry);
			$querry = "INSERT INTO `rating`(`Id`, `Value`, `Id_user`, `Id_film`) VALUES (NULL, '".$Rating."', '".$UId."', '".$Id."');";
			$conn->query($querry);
			$querry = "UPDATE `film` SET rating = (SELECT AVG(`Value`) FROM rating WHERE Id_film = '".$Id."') WHERE Id = '".$Id."';";
			$conn->query($querry);
		}break;
	};
?>