<?php
    require_once('view/top.php');

    if(!isset($_GET['id'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }

    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    $row = mysqli_fetch_array($result);
    if ($row == NULL) {
        $sql = "SELECT * FROM board WHERE board_no = '{$_GET['id']}';";
        $result = myquery($dbConnect, $sql);
        $row = mysqli_fetch_array($result);
    }

    if ($row['delete_date'] != NULL) {
        echo("<script>alert('삭제된 게시물입니다.')</script>");
        if ($_SESSION['user_id'] != 'admin') {
            echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
            exit;
        }
    }

    if ($row == NULL) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
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
    if (isset($row['nickname'])) {
        echo "작성자: {$row['nickname']}<br>";
    }
    else {
        echo "작성자: (알 수 없음)<br>";
    }
    echo "작성시각: {$row['create_date']}<br>";
    if ($row['update_date'] != NULL) {
        echo "수정시각: {$row['update_date']}<br>";
    }
    echo "게시글 번호: {$row['board_no']}<br>";

    if (!isset($row['user_id'])) {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 'admin') {
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
    }
    else if (isset($_SESSION['user_id']) && (($_SESSION['user_id'] == $row['user_id']) || ($_SESSION['user_id'] == 'admin'))) {
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

    echo "<div style=\"border: 1px solid black; width:900px; word-break:break-all;\">
        <p>{$row['content']}</p>
        </div>";
    echo "--------------------------------<br>";
?>
    <!-- 글 추천 -->
    <button onclick="location.href='board_likes.php?board_no=<?=$row['board_no']?>';">추천</button><br><br>

<?php
    echo "댓글({$row['reply_cnt']})<br>";
    
    // 댓글 표시
    $sql = "SELECT * FROM reply JOIN member ON reply.user_no = member.user_no WHERE board_no = '{$_GET['id']}' ORDER BY group_no, board_no;";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)) {
        $margin = $row['depth'] * 20;
?>
        <div style="margin-left: <?=$margin?>px;" id="reply<?=$row['reply_no']?>" class="0">
            <b><?=$row['nickname']?></b> (<?=$row['create_date']?>) <?php if ($row['update_date'] != NULL) { echo "(수정시각: {$row['update_date']})"; } ?>
            <button style = "font-size:0.2em; line-height: 0.9em;" onclick="control_reply(<?=$row['reply_no']?>)"><b>.<br>.<br>.<br><br></b></button><br>
            <button style = "display : none;" id="update<?=$row['reply_no']?>" onclick="location.href='update_reply.php?reply_no=<?=$row['reply_no']?>&board_no=<?=$_GET['id']?>';">수정</button>
            <button style = "display : none;" id="delete<?=$row['reply_no']?>" onclick="location.href='delete_reply.php?reply_no=<?=$row['reply_no']?>&board_no=<?=$_GET['id']?>';">삭제</button>
            <?php if ($row['to_user_nickname'] != "") echo "@{$row['to_user_nickname']}<br>"; ?>
            <?php if ($row['delete_date'] != "") {
                    if ($row['delete_by'] == 'a') {
                        echo "(댓글 작성자 본인이 삭제한 댓글입니다)";
                    }
                    else if ($row['delete_by'] == 'b') {
                        echo "(게시글 작성자가 삭제한 댓글입니다)";
                    }
                    else if ($row['delete_by'] == 'c') {
                        echo "(운영자가 삭제한 댓글입니다)";
                    }
                }
                else {
                    echo $row['content'];
                    echo " (추천 {$row['likes']})";
                }?> 
            <button onclick="reply_of_reply(<?=$row['reply_no']?>, <?=$row['group_no']?>)">답글</button>
            <!-- 댓글 추천 -->
            <button onclick="location.href='reply_likes.php?reply_no=<?=$row['reply_no']?>&board_no=<?=$row['board_no']?>';">추천</button><br><br>
        </div>
<?php
    }
?>
    <script>
        function reply_of_reply(reply_no, group_no) {
            if (document.getElementById("reply"+reply_no).className == "0") {
                document.getElementById("reply"+reply_no).innerHTML += '<p>\
                        <form action=\"create_reply.php\" method=\"POST\">\
                            <input type=\"text\" name=\"reply\" required>\
                            <input type=\"hidden\" name=\"board_no\" value=<?=$_GET['id']?>>\
                            <input type=\"hidden\" name=\"group_no\" value=' + group_no + '>\
                            <input type=\"hidden\" name=\"reply_no\" value=' + reply_no + '>\
                            <input type=\"submit\" value=\"댓글 작성\">\
                        </form>\
                    </p>';
                    document.getElementById("reply"+reply_no).className = "1";
            }
        }

        function control_reply(reply_no) {
            const btn1 = document.getElementById('update'+reply_no);
            
            if(btn1.style.display !== 'none') {
                btn1.style.display = 'none';
            }
            else {
                btn1.style.display = 'block';
            }

            const btn2 = document.getElementById('delete'+reply_no);
            
            if(btn2.style.display !== 'none') {
                btn2.style.display = 'none';
            }
            else {
                btn2.style.display = 'block';
            }
        }
    </script>
<?php
    // 댓글 쓰기
    echo "
        <p>
            <form action=\"create_reply.php\" method=\"POST\">
                <input type=\"text\" name=\"reply\" required>
                <input type=\"hidden\" name=\"board_no\" value={$_GET['id']}>
                <input type=\"submit\" value=\"댓글 작성\">
            </form>
        </p>
    ";

    require_once('view/bottom.php');
?>