<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    /* 입력 정보 유효성 검사 */
    if ($_POST['password'] != $_POST['password_check']) {
        echo("<script>alert('두 비밀번호가 일치하지 않습니다.')</script>");
        echo("<script>window.location = '/web01/signin.php';</script>");
        exit;
    }

    if (!check_user_input("user_id", $_POST['id'], $dbConnect)) {
        echo("<script>alert('이미 존재하는 user id입니다: \"".$_POST['id']."\"')</script>");
        echo("<script>window.location = '/web01/signin.php';</script>");
        exit;
    }
    if(!check_user_input("nickname", $_POST['nickname'], $dbConnect)) {
        echo("<script>alert('이미 존재하는 nickname입니다: \"".$_POST['nickname']."\"')</script>");
        echo("<script>window.location = '/web01/signin.php';</script>");
        exit;
    }
    if(!check_user_input("email", $_POST['email'], $dbConnect)) {
        echo("<script>alert('이미 존재하는 email입니다: \"".$_POST['email']."\"')</script>");
        echo("<script>window.location = '/web01/signin.php';</script>");
        exit;
    }

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

    $result = myquery($dbConnect, $sql);
    
    echo("<script>alert('회원 가입 성공')</script>");
    echo("<script>window.location = '/web01/index.php';</script>");
    exit;
?>