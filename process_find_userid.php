<?php
    require_once('lib/connect.php');

    $sql = "SELECT user_id FROM member WHERE email = '{$_POST['email']}' AND withdrawal_date IS NULL;";
    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)){
        echo("<script>alert('아이디: ".$row['user_id']."')</script>");
        echo("<script>window.location = '/web01/login.php';</script>");
        exit;
    }

    echo("<script>alert('존재하지 않는 이메일입니다.')</script>");
    echo("<script>window.location = '/web01/find_userid.php';</script>");
    exit;
?>