<?php
    session_start();
    require_once("./conn.php");
    require_once("./utils.php");

    if (empty($_POST['content'])) {
        header("Location: index.php?err=1");
        die( "請填入完整資料");
    }

    $user = getUserFormSession($_SESSION['username']);

    $username = $_SESSION['username'];
    $nickname = $user['nickname'];
    $content = $_POST['content'];

    $sql = "INSERT INTO comments(username,nickname,content) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss",$username,$nickname,$content);
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    };

    header("Location: index.php");
?>