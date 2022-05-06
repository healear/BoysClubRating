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
            $name = $_GET['Name'];
            $pwd = $_GET['Pas'];
            $querry = "SELECT Password, Id FROM `user` WHERE Name = '".$name."'";
            $result = $conn->query($querry);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    if(password_verify($pwd, $row['Password']))
                    {
                        echo $row['Id'];
                    }
                    else{
                        echo "WRONG PASSWORD";
                    }
                }
            }
        }
        break;
};





?>