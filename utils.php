<?php
    require_once("./conn.php");

function generateToken() {
    $s = '';
    for ($i=0; $i < 16 ; $i++) { 
        $s = $s . chr(rand(65,90));
    }
    return $s;
};

function getUserFormSession($username){
    global $conn;

    $sql = sprintf("SELECT * FROM users WHERE username = '%s'",
        $username
    );
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();

    return $user;
};

function escapeHtml($string){
    return htmlspecialchars( $string , ENT_QUOTES );
};

?>