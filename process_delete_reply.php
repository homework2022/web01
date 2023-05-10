<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    if (!isset($_GET['reply_no']) || !isset($_POST['final_decision'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }
    if ($_POST['final_decision'] != "true") {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $sql = "SELECT * FROM reply JOIN member ON reply.user_no = member.user_no WHERE reply_no = '{$_GET['reply_no']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)) {
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 댓글입니다.')</script>");
            if ($_SESSION['user_id'] != 'admin') {
                echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
                exit;
            }
        }

        $sql = "SELECT user_id as master_id FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$row['board_no']}';";
        $result2 = myquery($dbConnect, $sql);
        $row2 = mysqli_fetch_array($result2);

        if ($row['user_id'] != $_SESSION['user_id'] && $_SESSION['user_id'] != 'admin' && $_SESSION['user_id'] != $row2['master_id']) {
            echo("<script>alert('권한이 없습니다.')</script>");
            echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
            exit;
        }

        if ($row['user_id'] == $_SESSION['user_id']) {
            $delete_by = 'a';
        }
        if ($_SESSION['user_id'] == 'admin') {
            $delete_by = 'c';
        }
        if ($_SESSION['user_id'] == $row2['master_id']) {
            $delete_by = 'b';
        }

        $sql = "UPDATE reply SET delete_date = now(), delete_by = '{$delete_by}' WHERE reply_no = '{$_GET['reply_no']}';";
        if (myquery($dbConnect, $sql)) {
            echo("<script>alert('삭제되었습니다')</script>");
            echo("<script>window.location = '/web01/view_post.php?id={$_GET['board_no']}';</script>");
            exit;
        }
    }