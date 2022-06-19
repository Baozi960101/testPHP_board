<?php
    session_start();
    require_once("./conn.php");
    require_once("./utils.php");
    
    $username = NULL;
    if (!empty($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $user = getUserFormSession($username);
        $nickname = $user['nickname'];
    };

    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM comments WHERE id=?");
    $stmt->bind_param('i',$id);
    $result = $stmt->execute();
    if (!$result) {
        die("error : " . $conn->error);
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>留言板</title>
        <link rel="stylesheet" href="./index.css"/>
    </head>
    <body>
        <header class="warning">
            注意 ! 本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼。
        </header>
        <main>
            <div class="board">
               <h1>編輯留言</h1>
               <?php
                    if (!empty($_GET['err'])) {
                        echo "<div class='err'>資料請填完整</div>";
                    }
               ?>
               <form class="board__comment-form" method="POST" action="handle_update_comment.php">
                    <textarea name="content" rows="5"><?php echo $row['content']?>
                    </textarea>
                    <input type="hidden" name="id" value=<?php echo $row['id'] ?>/>
                    <input class="board__submit" type="submit" value="送出"/>
               </form>
            </div>
        </main>
    </body>
</html>