<?php
    session_start();
    require_once("./conn.php");
    require_once("./utils.php");

    $id = $_POST['id'];
    if (empty($_POST['content'])) {
        header("Location: update_comments.php?err=1&id=$id");
        die( "請填入完整資料");
    }

    $username = $_SESSION['username'];
    $user = getUserFormSession($_SESSION['username']);
    $id = $_POST['id'];
    $content = $_POST['content'];


    $sql = "UPDATE comments SET content=? WHERE id=? AND username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis",$content,$id,$username);
    $result = $stmt->execute();

    if (!$result) {
        die($conn->error);
    };

    header("Location: index.php");
?>