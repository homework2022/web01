<?php
    function check_user_input($col, $post_val, $dbConnect) {
        $sql = "SELECT ".$col." FROM member WHERE ".$col." = '".$post_val."'";
        $result = mysqli_query($dbConnect, $sql);

        if ($result == false) {
            echo mysqli_error($dbConnect);
            echo("<script>window.location = '/web01/signin.php';</script>");
        }

        $row = mysqli_fetch_array($result);

        if ($row) {
            echo("<script>alert('이미 존재하는 ".$col."입니다: \"".$post_val."\"')</script>");
            echo("<script>window.location = '/web01/signin.php';</script>");
            exit;
        }
    }

    $dbConnect = mysqli_connect(
        'localhost',
        'root',
        '',
        'web01'
    );

    if (mysqli_connect_errno()) {
        echo 'db connect fail..';
        echo mysqli_connect_error();
    }

    /* 입력 정보 유효성 검사 */
    if ($_POST['password'] != $_POST['password_check']) {
        echo("<script>alert('두 비밀번호가 일치하지 않습니다.')</script>");
        echo("<script>window.location = '/web01/signin.php';</script>");
        exit;
    }

    check_user_input("user_id", $_POST['id'], $dbConnect);
    check_user_input("nickname", $_POST['nickname'], $dbConnect);
    check_user_input("email", $_POST['email'], $dbConnect);

    /* 회원가입 */
    $sql = "INSERT INTO member (user_id, password, nickname, email, join_date)
     VALUES (
        '{$_POST['id']}',
        '{$_POST['password']}',
        '{$_POST['nickname']}',
        '{$_POST['email']}',
        now()
     )
    ";

    $result = mysqli_query($dbConnect, $sql);

    if ($result == false) {
        echo mysqli_error($dbConnect);
    }
    echo("<script>alert('회원 가입 성공')</script>");
    echo("<script>window.location = '/web01/index.php';</script>");
?>