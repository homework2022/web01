<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if (!isset($_GET['id'])) {
        echo("<script>window.location = '/web01/boardlist.php';</script>");
        exit;
    }

    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)) {
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 게시물입니다.')</script>");
            echo("<script>window.location = '/web01/boardlist.php';</script>");
            exit;
        }

        if ($row['user_id'] != $_SESSION['user_id']) {
            echo("<script>alert('권한이 없습니다.')</script>");
            echo("<script>window.location = '/web01/boardlist.php';</script>");
            exit;
        }

        if ($_POST['final_decision'] == "true") {
            $sql = "UPDATE board SET delete_date = now() WHERE board_no = '{$_GET['id']}';";
            if (myquery($dbConnect, $sql)) {
                echo("<script>alert('삭제되었습니다')</script>");
                echo("<script>window.location = '/web01/boardlist.php';</script>");
                exit;
            }
        }
        else {
            echo("<script>window.location = '/web01/boardlist.php';</script>");
            exit;
        }
    }
?>