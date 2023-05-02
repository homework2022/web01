<?php
    require_once('view/top.php');
    require_once('lib/check.php');

    check_session();
?>

<p>
    <form action="process_create_post.php" method="POST">
        <select name="category">
            <option value="1" <?php if ($_SESSION['user_id'] != 'admin') { echo("disabled"); } ?>>공지사항(관리자만 작성 가능)</option>
            <option value="2" <?php if (isset($_GET['id']) && $_GET['id'] == 2) { echo("selected"); } ?>>자유</option>
            <option value="3" <?php if (isset($_GET['id']) && $_GET['id'] == 3) { echo("selected"); } ?>>Q&A</option>
            <option value="4" <?php if (isset($_GET['id']) && $_GET['id'] == 4) { echo("selected"); } ?>>정보공유</option>
        </select>
        <p>글 제목: <input type="text" name="title" placeholder="title" maxlength="50" required></p>
        <textarea name="content" name="content" placeholder="내용" rows="30" cols="100" required></textarea>
        <p><input type="submit"></p>
    </form>
</p>

<?php
    require_once('view/bottom.php');
?>
