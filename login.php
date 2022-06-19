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
                <div>
                    <a class="border__btn" href="./index.php">回留言板</a>
                    <a class="border__btn" href="./register.php">註冊</a>
                </div>
               <h1>登入</h1>
               <?php
                    if (!empty($_GET['err'])) {
                        $err = "資料請填完整";
                        if ($_GET['err'] === "2") {
                            $err = "帳號或密碼錯誤";
                        }
                        echo "<div class='err'>$err</div>";
                    }
               ?>
               <form class="board__comment-form" method="POST" action="handle_login.php">
                    <div class="board__nickname">
                        <span>帳號:</span>
                        <input type="text" name="username"/>
                    </div>
                    <div class="board__nickname">
                        <span>密碼:</span>
                        <input type="password" name="password"/>
                    </div>
                    <input class="board__submit" type="submit" value="送出"/>
               </form>
            </div>
        </main>
    </body>
</html>