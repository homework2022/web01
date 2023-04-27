<!DOCTYPE html>
<html>
    <head>
        <title>Web01 - main page</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
            $dbConnect = mysqli_connect(
                'localhost',
                'root',
                '',
                'web01'
            );

            if(mysqli_connect_errno()){
                echo 'db connect fail..';
                echo mysqli_connect_error();
            }

            if(!session_id()) { 
                session_start(); 
            }
        ?>

        <h1>
            <a href="index.php">
                Main page
            </a>
        </h1>
        <ol>
            <?php
                if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
                    echo("hello, ".$_SESSION['user_id']);
                    echo('<li>
                            <a href="mypage.php">
                                마이페이지
                            </a>
                        </li>
                        <li>
                            <a href="logout.php">
                                로그아웃
                            </a>
                        </li>');
                }
                else {
                    echo('<li>
                            <a href="signin.php">
                                회원가입
                            </a>
                        </li>
                        <li>
                            <a href="login.php">
                                로그인
                            </a>
                        </li>');
                }
            ?>
            <li>
                <a href="boardlist.php">
                    게시판
                </a>
            </li>
        </ol>