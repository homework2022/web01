<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    $sql = "SELECT IFNULL(MAX(group_no), 0) AS max_group_no FROM reply WHERE board_no = '{$_POST['board_no']}';";
    $row = mysqli_fetch_array(myquery($dbConnect, $sql));
    $current_group_no = $row['max_group_no'] + 1;
    $depth = 0;
    $nickname = NULL;

    if (isset($_POST['group_no'])) {
        $current_group_no = $_POST['group_no'];
        $depth = 1;
        $sql = "SELECT nickname FROM member WHERE user_no = (SELECT user_no FROM reply WHERE reply_no = '{$_POST['reply_no']}');";
        $row = mysqli_fetch_array(myquery($dbConnect, $sql));
        $nickname = $row['nickname'];
    }
    $sql = "INSERT INTO reply (content, depth, to_user_nickname, group_no, create_date, user_no, board_no) 
        VALUES ('{$_POST['reply']}', '{$depth}', '$nickname', 
            {$current_group_no}, 
            now(), 
            (SELECT user_no FROM member WHERE user_id = '{$_SESSION['user_id']}'), 
            '{$_POST['board_no']}');";
    
    myquery($dbConnect, $sql);

    $sql = "UPDATE board SET reply_cnt = reply_cnt + 1 WHERE board_no = '{$_POST['board_no']}';";

    myquery($dbConnect, $sql);

    echo("<script>window.location = '/web01/view_post.php?id={$_POST['board_no']}';</script>");
    exit;
?>