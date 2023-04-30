<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if(isset($_POST['id'])) {
        if(update_user("user_id", $_POST['id'], $dbConnect)) {
            $_SESSION['user_id'] = $_POST['id'];
            echo("<script>alert('변경 성공')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
        else{
            echo("<script>alert('이미 존재하는 아이디입니다: \"".$_POST['id']."\"')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
    }

    if (isset($_POST['password'])) {
        if ($_POST['password'] != $_POST['password_check']) {
            echo("<script>alert('두 비밀번호가 일치하지 않습니다.')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
        else {
            $sql = "UPDATE member SET password = '{$_POST['password']}' WHERE user_id = '{$_SESSION['user_id']}';";
            $result = myquery($dbConnect, $sql);
            echo("<script>alert('변경 성공')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
        }
    }

    if(isset($_POST['nickname'])) {
        if(update_user("nickname", $_POST['nickname'], $dbConnect)) {
            echo("<script>alert('변경 성공')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
        else{
            echo("<script>alert('이미 존재하는 닉네임입니다: \"".$_POST['nickname']."\"')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
    }
    
    if(isset($_POST['email'])) {
        if(update_user("email", $_POST['email'], $dbConnect)) {
            echo("<script>alert('변경 성공')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
        else{
            echo("<script>alert('이미 존재하는 이메일입니다: \"".$_POST['email']."\"')</script>");
            echo("<script>window.location = '/web01/editprofile.php';</script>");
            exit;
        }
    }
?>