<?php
    require_once('lib/connect.php');

    $sql = "SELECT password FROM member WHERE user_id = '".$_POST['id']."';";
    $result = mysqli_query($dbConnect, $sql);
    if ($result == false) {
        echo mysqli_error($dbConnect);
        echo("<script>alert('db 오류')</script>");
        exit;
    }
    while ($row = mysqli_fetch_array($result)){
        $db_password = $row['password'];
    }

    if (!is_null($db_password) && $_POST['password'] == $db_password){
        echo("<script>alert('login 성공')</script>");

        session_start();
        $_SESSION['user_id'] = $_POST['id']; 

        echo("<script>window.location = '/web01/index.php';</script>");
        exit;
    }
    else {
        echo("<script>alert('login fail')</script>");
        echo("<script>window.location = '/web01/login.php';</script>");
        exit;
    }
?>