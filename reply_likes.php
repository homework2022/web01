<?php
    require_once('view/top.php');
    require_once('lib/check.php');

    check_session();

    if (!isset($_GET['reply_no']) || !isset($_GET['board_no'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $sql = "(SELECT EXISTS (SELECT * FROM reply_likes WHERE user_id = '{$user_id}' AND reply_no = '{$_GET['reply_no']}' limit 1) as s);";
    $view_record = mysqli_fetch_array(myquery($dbConnect, $sql));
    if ($view_record['s'] == 0) {
        $sql = "UPDATE reply SET likes = likes + 1 WHERE reply_no = '{$_GET['reply_no']}';";
        myquery($dbConnect, $sql);
        $sql = "INSERT INTO reply_likes (user_id, reply_no) VALUES ('{$user_id}', '{$_GET['reply_no']}');";
        myquery($dbConnect, $sql);
    }

    echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
    exit;
?>