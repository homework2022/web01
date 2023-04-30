<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if(isset($_SESSION['user_pw_check'])) {
        if($_POST['final_decision'] == 'Y') {
            
            $sql = "UPDATE member SET withdrawal_date = now() WHERE user_id = '{$_SESSION['user_id']}'";
            if (myquery($dbConnect, $sql)) {
                echo("<script>alert('탈퇴 성공')</script>");
                echo("<script>window.location = '/web01/logout.php';</script>");
                exit;
            }
        }
    }
    unset($_SESSION['user_pw_check']);
    echo("<script>alert('탈퇴하지 않음')</script>");
    echo("<script>window.location = '/web01/index.php';</script>");
?>