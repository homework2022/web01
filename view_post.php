<?php
    require_once('view/top.php');

    $sql = "SELECT * FROM board WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)){
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 게시물입니다.')</script>");
            if ($_SESSION['user_id'] != 'admin') {
                echo("<script>window.location = '/web01/boardlist.php';</script>");
                exit;
            }
        }
        echo "--------------------------------<br>";

        echo "<h3>제목: {$row['title']}</h3>";
        $sql = "SELECT nickname FROM member WHERE user_no = {$row['user_no']};";
        $nickname = mysqli_fetch_array(myquery($dbConnect, $sql));
        echo "작성자: {$nickname['nickname']}<br>";
        echo "작성시각: {$row['create_date']}<br>";
        if ($row['update_date'] != NULL) {
            echo "수정시각: {$row['update_date']}<br>";
        }
        echo "게시글 번호: {$row['board_no']}<br>";
?>
        <p>
            <form action="update_post.php" method="GET">
                <input type="hidden" name="id" value=<?php echo $_GET['id']?>>
                <input type="submit" value="수정">
            </form>
            <form action="delete_post.php" method="GET">
                <input type="hidden" name="id" value=<?php echo $_GET['id']?>>
                <input type="submit" value="삭제">
            </form>
        </p>
<?php
        echo "--------------------------------<br>";

        echo "<p>{$row['content']}</p>";
        echo "--------------------------------<br>";

        echo "댓글({$row['reply_cnt']})<br>";
    }

    require_once('view/bottom.php');
?>