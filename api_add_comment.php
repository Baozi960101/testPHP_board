<?php
    session_start();
    require_once("./conn.php");
    header("Content-Type:text/html; charset=utf-8");

    if (empty($_POST['content'])) {
        $json = array(
            "ok"=> "false",
            "message"=> "input no content"
        );
        $response = json_encode($json);
        echo $response ;
        die();
    }


    $username = $_SESSION['username'];
    $content = $_POST['content'];

    $sql = "INSERT INTO comments(username,content) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$username,$content);
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