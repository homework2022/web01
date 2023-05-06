<?php
    require_once('view/top.php');

    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)){
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 게시물입니다.')</script>");
            if ($_SESSION['user_id'] != 'admin') {
                echo("<script>window.location = '/web01/boardlist.php';</script>");
                exit;
            }
        }
        
        /* 조회수 증가 */
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }
        else {
            $user_id = session_id();
        }

        $sql = "(SELECT EXISTS (SELECT * FROM view WHERE user_id = '{$user_id}' AND board_no = '{$row['board_no']}' limit 1) as s);";
        $view_record = mysqli_fetch_array(myquery($dbConnect, $sql));
        if ($view_record['s'] == 0) {
            $sql = "UPDATE board SET view = {$row['view']} + 1 WHERE board_no = '{$row['board_no']}';";
            myquery($dbConnect, $sql);
            $sql = "INSERT INTO view (user_id, board_no) VALUES ('{$user_id}', '{$row['board_no']}');";
            myquery($dbConnect, $sql);
        }

        echo "--------------------------------<br>";

        echo "<h3>제목: {$row['title']}</h3>";
        echo "작성자: {$row['nickname']}<br>";
        echo "작성시각: {$row['create_date']}<br>";
        if ($row['update_date'] != NULL) {
            echo "수정시각: {$row['update_date']}<br>";
        }
        echo "게시글 번호: {$row['board_no']}<br>";

        if (isset($_SESSION['user_id']) && 
            ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['user_id'] == 'admin')) {
            echo "
                <p>
                    <form action=\"update_post.php\" method=\"GET\">
                        <input type=\"hidden\" name=\"id\" value={$_GET['id']}>
                        <input type=\"submit\" value=\"수정\">
                    </form>
                    <form action=\"delete_post.php\" method=\"GET\">
                        <input type=\"hidden\" name=\"id\" value={$_GET['id']}>
                        <input type=\"submit\" value=\"삭제\">
                    </form>
                </p>";
        }

        echo "--------------------------------<br>";

        echo "<p>{$row['content']}</p>";
        echo "--------------------------------<br>";

        echo "댓글({$row['reply_cnt']})<br>";
    }

    require_once('view/bottom.php');
?>