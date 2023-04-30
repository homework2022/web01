<?php
    require_once('lib/connect.php');

    $sql = "SELECT password FROM member WHERE user_id = '".$_POST['id']."' AND withdrawal_date IS NULL;";
    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)){
        $db_password = $row['password'];
    }

    if (!is_null($db_password) && $_POST['password'] == $db_password){
        echo("<script>alert('login 성공')</script>");

        if(!session_id()) { 
            session_start(); 
        }
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