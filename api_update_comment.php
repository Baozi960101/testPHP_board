<?php
    session_start();
    require_once("./conn.php");

    header("Content-Type:text/html; charset=utf-8");

    // $id = $_POST['id'];
    if (empty($_POST['content'])) {
        $json = array(
            "ok"=> "false",
            "message"=> "input no content"
        );
        $response = json_encode($json);
        echo $response ;
        die();
    }

    $username = $_POST['username'];
    $user = getUserFormSession($_SESSION['username']);
    $id = $_POST['id'];
    $content = $_POST['content'];


    $sql = "UPDATE comments SET content=? WHERE id=? AND username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis",$content,$id,$username);
    $result = $stmt->execute();

    if (!$result) {
        $json = array(
            "ok"=> "false",
            "message"=> $conn->$error
        );
        $response = json_encode($json);
        echo $response ;
        die();
    };

    $json = array(
        "ok"=> "true",
        "message"=> "success!!"
    );
    $response = json_encode($json);
    echo $response ;
?>