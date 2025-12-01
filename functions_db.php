<?php

require_once "credentials_db.php";

function connect_db() {
    global $servername, $username, $password, $database;

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Erro na conexão: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8mb4");

    return $conn;
}

function close_db($conn) {
    if ($conn) {
        mysqli_close($conn);
    }
}
