<?php
    require_once('lib/connect.php');

    $sql = "SELECT password FROM member WHERE user_id = '".$_SESSION['user_id']."';";
    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)){
        $db_password = $row['password'];
    }

    if (!is_null($db_password) && $_POST['password'] == $db_password){
        echo("<script>alert('비밀번호 검증 성공')</script>");

        $_SESSION['user_pw_check'] = true;
    }
    else {
        echo("<script>alert('비밀번호 검증 실패')</script>");
    }

    echo("<script>window.location = '/web01/".$_POST['redirect']."';</script>");
?>