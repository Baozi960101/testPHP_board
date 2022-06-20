<?php
    require_once("./conn.php");

    $limit = 10;
    $present_pages = 1;
    if (!empty($_GET['page'])) {
        $present_pages = $_GET['page'];
    };

    $offset_number = ($present_pages-1) * $limit;


    $sql = "SELECT ".
            "C.id , C.username , C.content , U.nickname , C.created_at ".
            "from comments as C LEFT JOIN users as U ".
            "ON C.username = U.username ".
            "WHERE C.is_deleted is NULL ".
            "ORDER BY C.created_at DESC ".
            "Limit ? offset ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$limit,$offset_number);
    $result = $stmt->execute();
    if (!$result) {
        die("error : " . $conn->error);
    }

    $result = $stmt->get_result();
    $comments = array();

    while ($row = $result->fetch_array()) {
        array_push($comments,array(
            "id"=>$row['id'],
            "username"=> $row['username'],
            "nickname"=> $row['nickname'],
            "content"=>$row['content'],
            "created_at"=>$row['created_at']
        ));
    };

   
    $response = json_encode(array("comments"=>$comments));

    header("Content-Type:text/html; charset=utf-8");
    
    echo  $response; 
?>