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
               <h1>Comments</h1>
               <form class="board__comment-form" id="board__comment-form">
                    <textarea id="content" name="content" rows="5"></textarea>
                    <input class="board__submit" type="submit" value="送出"/>
               </form>
               <div class="board__hr"></div>
               <section id="section">
               </section>
               <div class="board__hr"></div>
               </div>
            </div>
        </main>
        <script>
            let request = new XMLHttpRequest();
            request.open('get', "api_comments.php", true);
            request.onload = function() {
                if (this.status >= 200 && this.status < 400) {
                    let resp = this.response;
                    let json = JSON.parse(resp);
                    let comments = json.comments

                    for (let i = 0; i < comments.length; i++) {
                        let comment = comments[i];
                        let div = document.createElement("div")
                        div.innerHTML = `
                            <div class="card">                        
                                <div class="card_avatar"></div>
                                <div class="card_body">
                                    <div class="card__info">
                                        <span class="card__auther">
                                            ${comment.nickname}
                                            ${comment.username}
                                        </span>
                                        <span class="card__time">
                                            ${comment.created_at}
                                        </span>
                                    </div>
                                    <div class="card__content">${escapeHtml(comment.content)}</div>
                                </div> 
                            </div>     
                        `
                        document.getElementById("section").appendChild(div)
                    }
                }
            };
            request.send();

            document.getElementById("board__comment-form").addEventListener("submit",function (e) {
                e.preventDefault();
                let value = document.getElementById("content").value
                var request = new XMLHttpRequest();
                request.open('post', 'api_add_comment.php', true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send("username=aa&&content=" + encodeURIComponent(value));
                request.onload = function() {
                if (this.status >= 200 && this.status < 400) {
                    let resp = this.response;
                    let json = JSON.parse(resp);
                        if (json.ok) {
                            location.reload()
                        } else {
                            alert(json.message)
                        }
                    }
                }
            })

            function escapeHtml(unsafe)
                {
                    return unsafe
                        .replace(/&/g, "&amp;")
                        .replace(/</g, "&lt;")
                        .replace(/>/g, "&gt;")
                        .replace(/"/g, "&quot;")
                        .replace(/'/g, "&#039;");
                }
        </script>
    </body>
</html>