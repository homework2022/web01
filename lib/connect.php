<?php
    $dbConnect = mysqli_connect(
        'localhost',
        'root',
        '',
        'web01'
    );
    
    function myquery($dbConnect, $sql){
        $result = mysqli_query($dbConnect, $sql);
        if ($result == false) {
            echo mysqli_error($dbConnect);
            echo("<script>alert('db 오류: {$sql}')</script>");
            exit;
        }
        else {
            return $result;
        }
    }

    function garbage_collect($dbConnect) {
        /* 탈퇴한 지 1분 지난 유저 영구삭제 */
        $sql = "SELECT withdrawal_date, user_no FROM member WHERE withdrawal_date IS NOT NULL;";
        $result = myquery($dbConnect, $sql);
        while ($row = mysqli_fetch_array($result)){
            $sql = "SELECT TIMESTAMPDIFF(SECOND, '{$row['withdrawal_date']}', now()) AS tdiff;";
            $row2 = mysqli_fetch_array(myquery($dbConnect, $sql));
            if ($row2['tdiff'] > 60) {
                $sql = "DELETE FROM member WHERE user_no = '{$row['user_no']}';";
                myquery($dbConnect, $sql);
            }
        }
        /* 삭제한 지 1분 지난 게시글 영구삭제 */
        $sql = "SELECT delete_date, board_no FROM board WHERE delete_date IS NOT NULL;";
        $result = myquery($dbConnect, $sql);
        while ($row = mysqli_fetch_array($result)){
            $sql = "SELECT TIMESTAMPDIFF(SECOND, '{$row['delete_date']}', now()) AS tdiff;";
            $row2 = mysqli_fetch_array(myquery($dbConnect, $sql));
            if ($row2['tdiff'] > 60) {
                $sql = "DELETE FROM board WHERE board_no = '{$row['board_no']}';";
                myquery($dbConnect, $sql);
            }
        }
        /* 삭제한 지 1분 지난 댓글 영구삭제 */
        $sql = "SELECT delete_date, reply_no FROM reply WHERE delete_date IS NOT NULL;";
        $result = myquery($dbConnect, $sql);
        while ($row = mysqli_fetch_array($result)){
            $sql = "SELECT TIMESTAMPDIFF(SECOND, '{$row['delete_date']}', now()) AS tdiff;";
            $row2 = mysqli_fetch_array(myquery($dbConnect, $sql));
            if ($row2['tdiff'] > 60) {
                $sql = "DELETE FROM reply WHERE reply_no = '{$row['reply_no']}';";
                myquery($dbConnect, $sql);
            }
        }

        /* 댓글 단 사람이 영구삭제되고, 게시글도 영구삭제된 댓글을 찾아 영구삭제 */
        $sql = "SELECT reply_no FROM reply WHERE user_no IS NULL AND board_no IS NULL;";
        $result = myquery($dbConnect, $sql);
        while ($row = mysqli_fetch_array($result)){
            $sql = "DELETE FROM reply WHERE reply_no = '{$row['reply_no']}';";
            myquery($dbConnect, $sql);
        }
    }

    function feed_alarm($dbConnect) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $sql = "SELECT board_no FROM board JOIN member ON board.user_no = member.user_no WHERE board.user_no 
        IN (SELECT target_no FROM follow WHERE follow.user_id = '{$_SESSION['user_id']}') ORDER BY board_no DESC;";

        $result = myquery($dbConnect, $sql);
        while ($row = mysqli_fetch_array($result)){
            $sql = "(SELECT EXISTS (SELECT * FROM view WHERE user_id = '{$_SESSION['user_id']}' AND board_no = '{$row['board_no']}' limit 1) as s);";
            $view_record = mysqli_fetch_array(myquery($dbConnect, $sql));
            if ($view_record['s'] == 0) {
                echo "<script>alert('읽지 않은 새 글이 있습니다. 피드를 확인하세요.')</script>";
                return true;
            }
        }
        return false;
    }

    if (mysqli_connect_errno()) {
        echo 'db connect fail..';
        echo mysqli_connect_error();
    }

    if(!session_id()) { 
        session_start();
    }

    garbage_collect($dbConnect);
    feed_alarm($dbConnect);
?>