<?php
    require_once('view/top.php');
    require_once('lib/check.php');

    check_session();

    if (!isset($_GET['board_no'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $sql = "(SELECT EXISTS (SELECT * FROM board_likes WHERE user_id = '{$user_id}' AND board_no = '{$_GET['board_no']}' limit 1) as s);";
    $view_record = mysqli_fetch_array(myquery($dbConnect, $sql));
    if ($view_record['s'] == 0) {
        $sql = "UPDATE board SET likes = likes + 1 WHERE board_no = '{$_GET['board_no']}';";
        myquery($dbConnect, $sql);
        $sql = "INSERT INTO board_likes (user_id, board_no) VALUES ('{$user_id}', '{$_GET['board_no']}');";
        myquery($dbConnect, $sql);
    }

    echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
    exit;
?>