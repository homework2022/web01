<!DOCTYPE html>
<html>
    <head>
        <title>Web01 - board list</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            if(mysqli_connect_errno()){
                echo 'db connect fail..';
                echo mysqli_connect_error();
            } else {
                echo "db conneted..";
            }
        ?>

        <h1>
            <a href="index.php">
                Main page
            </a>
        </h1>
        <ol>
            <li>
                <a href="signin.php">
                    회원가입
                </a>
            </li>
            <li>
                <a href="login.php">
                    로그인
                </a>
            </li>
            <li>
                <a href="boardlist.php">
                    게시판
                </a>
            </li>
        </ol>
    </body>
</html>