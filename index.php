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
                <?php
                    if (!$username) { ?>
                    <div>
                        <a class="border__btn" href="./register.php">註冊</a>
                        <a class="border__btn" href="./login.php">登入</a>
                    </div>
                <?php } else { ?>
                    <div>
                        <a class="border__btn" href="./loginout.php">登出</a>
                        <span id="nickname" class="border__btn cursor">編輯暱稱</span>
                    </div>
                    <form id="nickname_form" class="hide margin_top board__comment-form" method="POST" action="update_nickname.php">
                        <div class="board__nickname">
                            <span>新暱稱:</span>
                            <input type="text" name="nickname"/>
                        </div>
                        <input class="board__submit" type="submit" value="送出"/>
                    </form>
                    <h3>Hello : <?php echo escapeHtml($nickname);?></h3>
                <?php }  ?>
               <h1>Comments</h1>
               <?php
                    if (!empty($_GET['err'])) {
                        echo "<div class='err'>資料請填完整</div>";
                    }
               ?>
               <form class="board__comment-form" method="POST" action="handle_add_comment.php">
                    <textarea name="content" rows="5"></textarea>
                    <?php
                        if (!$username) {
                    ?>
                        <h2>請登入再送出留言</h2>
                    <?php } else { ?>
                        <input class="board__submit" type="submit" value="送出"/>
                    <?php } ?>
               </form>
               <div class="board__hr"></div>
               <section>
                   <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="card">
                            <div class="card_avatar"></div>
                            <div class="card_body">
                                <div class="card__info">
                                    <span class="card__auther">
                                        <?php echo escapeHtml($row['nickname']); ?>
                                        (@<?php echo escapeHtml($row['username'])?>)
                                    </span>
                                    <span class="card__time">
                                        <?php echo escapeHtml($row['created_at']);?>
                                        <?php if($username === $row['username']){?>
                                            <a class="update__btn" href="./update_comments.php?id=<?php echo $row['id'];?>">編輯</a>
                                            <a class="update__btn" href="./handle_delete_comment.php?id=<?php echo $row['id'];?>">刪除</a>
                                        <?php }?>
                                    </span>
                                </div>
                                <div class="card__content"><?php echo escapeHtml($row['content']);?>
                                </div>
                            </div>
                        </div>
                    <?php }?> 
               </section>
               <div class="board__hr"></div>
               <?php 
                    $sql = "SELECT COUNT(id) as count FROM comments WHERE is_deleted is NULL";
                    $stmt = $conn->prepare($sql);
                    $result = $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $total_page = ceil($row['count'] / $limit);
               ?>
               <div class="page_info">
                    <span>目前在 <?php echo $present_pages ; ?> / <?php echo $total_page ; ?> 頁</span>
                    <span>，共 <?php echo $row['count']; ?> 筆資料</span>
               </div>
               <div class="page_btn">
                    <?php if($present_pages != 1){?>
                        <a href="./index.php?page=1">首頁</a>
                        <a href="./index.php?page=<?php echo ($present_pages-1) ; ?>">上一頁</a>
                    <?php }?>
                    <?php if($present_pages != $total_page){?>
                        <a href="./index.php?page=<?php echo ($present_pages+1) ; ?>">下一頁</a>
                        <a href="./index.php?page=<?php echo $total_page ; ?>">最後頁</a>
                    <?php }?>
               </div>
            </div>
        </main>
        <script>
            const nickname = document.getElementById("nickname");
            nickname.addEventListener("click" , function(){
                const nickname_form = document.getElementById("nickname_form");
                nickname_form.classList.toggle("hide");
            })
        </script>
    </body>
</html>