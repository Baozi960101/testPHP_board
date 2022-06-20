<?php
    session_start();
    require_once("./conn.php");
    require_once("./utils.php");

    if (empty($_GET['id'])) {
        header("Location: index.php?err=1");
        die( "請填入完整資料");
    }
    $username = $_SESSION['username'];
    $id = $_GET['id'];

    $sql = "UPDATE comments SET is_deleted=1 WHERE id=? and username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is",$id,$username);
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    };

    header("Location: index.php");
?>