<?php
    require_once('view/top.php');

    check_session();
?>

<p>
    <form action="process_feed.php" method="POST">
        팔로우할 유저의 닉네임 입력: <input type="text" name="target_nickname" maxlength="20" required>
        <input type="submit">
    </form>
</p>

<p>
    <form action="process_feed_cancel.php" method="POST">
        팔로우 취소할 유저의 닉네임 입력: <input type="text" name="target_nickname" maxlength="20" required>
        <input type="submit">
    </form>
</p>

현재 팔로우하고 있는 사람의 목록:<br>

<?php
    $sql = "SELECT * FROM follow JOIN member ON follow.target_no = member.user_no WHERE follow.user_id = '{$_SESSION['user_id']}';";
    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)) {
        echo $row['nickname']."<br>";
    }

    echo "--------------피드--------------";
?>
<table>
    <thead>
        <tr>
            <td>
                제목
            </td>
            <td>
                글쓴이
            </td>
            <td>
                등록일
            </td>
            <td>
                조회
            </td>
            <td>
                추천
            </td>
            <td>
                읽음
            </td>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board.user_no 
        IN (SELECT target_no FROM follow WHERE follow.user_id = '{$_SESSION['user_id']}') ORDER BY board_no DESC;";

    $result = myquery($dbConnect, $sql);
    while ($row = mysqli_fetch_array($result)){
        $title = $row['title'];
        if (strlen($title) > 30) {
            $title = mb_substr($title, 0, 30, 'UTF-8')."...";
        }
        $title = $title."<b>[{$row['reply_cnt']}]</b>";
    ?>
        <tr>
            <td><?php echo "<a href='view_post.php?id={$row['board_no']}'>{$title}</a>"; ?></td>
            <td><?= $row['nickname'] ?></td>
            <td><?= $row['create_date'] ?></td>
            <td><?= $row['view'] ?></td>
            <td><?= $row['likes'] ?></td>
            <td>
                <?php
                    $sql = "(SELECT EXISTS (SELECT * FROM view WHERE user_id = '{$_SESSION['user_id']}' AND board_no = '{$row['board_no']}' limit 1) as s);";
                    $view_record = mysqli_fetch_array(myquery($dbConnect, $sql));
                    if ($view_record['s'] == 0) {
                        echo "N";
                    }
                    else {
                        echo "Y";
                    }
                ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
<?php
    require_once('view/bottom.php');
?>
