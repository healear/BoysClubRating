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

    $userName = $_POST['UserName'];
    $pwd = password_hash($_POST['Password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO `user`(`Name`, `Password`) VALUES ('" . $userName . "', '" . $pwd . "' );";
    $result = $conn->query($query);
    header('Content-type: application/json');
    echo json_encode([
        'Name' => $userName,
        'Password' => $pwd
    ]);