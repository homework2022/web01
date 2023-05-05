<?php
    require_once('view/top.php');
    require_once('lib/check.php');

    check_session();

    if (!isset($_GET['id'])) {
        echo("<script>window.location = '/web01/boardlist.php';</script>");
        exit;
    }

    $sql = "SELECT * FROM board JOIN member ON board.user_no = member.user_no WHERE board_no = '{$_GET['id']}';";
    $result = myquery($dbConnect, $sql);

    while ($row = mysqli_fetch_array($result)){
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
?>

        <p>
            <form action="process_update_post.php?id=<?php echo $_GET['id']?>" method="POST">
                <select name="category">
                    <option value="1" <?php if ($_SESSION['user_id'] != 'admin') { echo("disabled"); } ?>>공지사항(관리자만 작성 가능)</option>
                    <option value="2" <?php if ($row['category'] == 2) { echo("selected"); } ?>>자유</option>
                    <option value="3" <?php if ($row['category'] == 3) { echo("selected"); } ?>>Q&A</option>
                    <option value="4" <?php if ($row['category'] == 4) { echo("selected"); } ?>>정보공유</option>
                </select>
                <p>글 제목: <input type="text" name="title" value=<?php echo "'{$row['title']}'" ?> placeholder="title" maxlength="50" required></p>
                <textarea name="content" name="content" placeholder="내용" rows="30" cols="100" required><?php echo "{$row['content']}" ?></textarea>
                <p><input type="submit"></p>
            </form>
        </p>

<?php
    }
    require_once('view/bottom.php');
?>