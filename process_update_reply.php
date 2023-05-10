<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if (!isset($_GET['reply_no']) || !isset($_GET['board_no'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $sql = "SELECT * FROM reply JOIN member ON reply.user_no = member.user_no WHERE reply_no = '{$_GET['reply_no']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)){
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 댓글입니다.')</script>");
            echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
            exit;
        }

        if ($row['user_id'] != $_SESSION['user_id']) {
            echo("<script>alert('권한이 없습니다.')</script>");
            echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
            exit;
        }
    }

    $sql = "UPDATE reply 
        SET content = '{$_POST['reply_content']}', 
        update_date = now() WHERE reply_no = '{$_GET['reply_no']}';";
    $result = myquery($dbConnect, $sql);
    echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
?>