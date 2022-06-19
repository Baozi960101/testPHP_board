<?php
    session_start();
    require_once("./conn.php");
    require_once("./utils.php");

    if (empty($_POST['nickname'])) {
        header("Location: index.php?err=1");
        die( "請填入完整資料");
    }

    $user = getUserFormSession($_SESSION['username']);
    $nickname = $_POST['nickname'];
    $username = $user['username'];


    $sql = "UPDATE users SET nickname=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$nickname,$username);
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    };

    header("Location: index.php");
?>