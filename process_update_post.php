<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if (!isset($_GET['id'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)){
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 게시물입니다.')</script>");
            if ($_SESSION['user_id'] != 'admin') {
                echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
                exit;
            }
        }

        if ($row['user_id'] != $_SESSION['user_id']) {
            echo("<script>alert('권한이 없습니다.')</script>");
            echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
            exit;
        }
    }

    $sql = "UPDATE board 
        SET title = '{$_POST['title']}', 
        content = '{$_POST['content']}', 
        category = '{$_POST['category']}', 
        update_date = now() WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);
    echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
?>