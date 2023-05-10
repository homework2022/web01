<?php
    require_once('lib/connect.php');
    require_once('lib/check.php');

    check_session();

    if (!isset($_POST['target_nickname'])) {
        echo("<script>window.location = '/web01/feed.php';</script>");
        exit;
    }
    $sql = "SELECT user_no FROM member WHERE nickname = '{$_POST['target_nickname']}';";
    $row = mysqli_fetch_array(myquery($dbConnect, $sql));

    if ($row == NULL) {
        echo("<script>alert('잘못된 닉네임입니다.')</script>");
        echo("<script>window.location = '/web01/feed.php';</script>");
        exit;
    }

    $sql = "DELETE FROM follow WHERE user_id = '{$_SESSION['user_id']}' AND target_no = '{$row['user_no']}';";
    myquery($dbConnect, $sql);
    echo("<script>window.location = '/web01/feed.php';</script>");
    exit;
?>