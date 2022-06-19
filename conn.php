<?php
    $server_name = "localhost";
    $username = "han";
    $password = "123";
    $db_name = "han";

    $conn = new mysqli($server_name,$username,$password,$db_name);

    if ($conn->connect_error) {
        die("資料庫錯誤:". $conn->connect_error);
    };
?>