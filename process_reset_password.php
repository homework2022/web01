<?php
    require_once('lib/connect.php');

    $rand_str = substr(uniqid(), 7, 12);

    $sql = "SELECT user_id FROM member WHERE email = '{$_POST['email']}' AND withdrawal_date is NULL";
    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)){
        $sql = "UPDATE member SET password = '{$rand_str}' WHERE email = '{$_POST['email']}'";
        if (myquery($dbConnect, $sql)) {
            echo("<script>alert('초기화한 비밀번호를 이메일로 발송하였습니다. (발송했다 치고): ".$rand_str."')</script>");
            echo("<script>window.location = '/web01/login.php';</script>");
            exit;
        }
    }
    if ($row == NULL) {
        echo("<script>alert('존재하지 않는 이메일입니다.')</script>");
        echo("<script>window.location = '/web01/reset_password.php';</script>");
        exit;
    }
?>