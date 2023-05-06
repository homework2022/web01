<?php
    require_once('view/top.php');
    
    if (!isset($_GET['id']) || !isset($_GET['p'])) {
        echo("<script>alert('카테고리와 페이지가 설정되지 않음.')</script>");
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
    }
    if ($_GET['id'] < 0 || $_GET['id'] > 4
        || $_GET['p'] <= 0) {
            echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
    }
?>
<style>
  table {
    width: 100%;
    border-top: 1px solid #444444;
    border-collapse: collapse;
  }
  th, td {
    border-bottom: 1px solid #444444;
    border-left: 1px solid #444444;
    padding: 10px;
  }
  th:first-child, td:first-child {
    border-left: none;
  }
</style>
--------------------------------<br>
<h3>카테고리</h3>

<ol>
    <li>
        <a href="boardlist.php?id=0?p=1">
            <?php if ($_GET['id'] == 0) { echo ("<strong>전체</strong>"); } else { echo "전체"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=1&p=1">
            <?php if ($_GET['id'] == 1) { echo ("<strong>공지</strong>"); } else { echo "공지"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=2&p=1">
            <?php if ($_GET['id'] == 2) { echo ("<strong>자유</strong>"); } else { echo "자유"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=3&p=1">
            <?php if ($_GET['id'] == 3) { echo ("<strong>Q&A</strong>"); }  else { echo "Q&A"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=4&p=1">
            <?php if ($_GET['id'] == 4) { echo ("<strong>정보공유</strong>"); } else { echo "정보공유"; } ?>
        </a>
    </li>
</ol>

--------------------------------<br>

<p>
    <form action="create_post.php" method="GET">
        <input type="hidden" name="id" value=<?php echo $_GET['id']?>>
        <input type="submit" value="글쓰기">
    </form>
</p>

<?php
    echo ".......................";
    if (!isset($_GET['sort'])) {
        $sort = 1;
    }
    else {
        $sort = $_GET['sort'];
    }
?>

<p>
    <form action="<?php echo "{$_SERVER['PHP_SELF']}"; ?>" method="GET">
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
        <input type="hidden" name="p" value="1">
        <select name="sort">
            <option value="1" <?php if ($sort == 1) { echo("selected"); } ?>>최신순</option>
            <option value="2" <?php if ($sort == 2) { echo("selected"); } ?>>좋아요순</option>
            <option value="3" <?php if ($sort == 3) { echo("selected"); } ?>>조회순</option>
        </select>
        <select name="search">
            <option value="1" >제목+내용</option>
            <option value="2" >제목</option>
            <option value="3" >작성자</option>
        </select>
        <input type="text" name="word" maxlength="20">
        <input type="submit" value="검색 + 정렬하기">
    </form>
</p>

<?php
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM board WHERE 1=1 "; 
    if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 'admin')) {
        $sql = $sql."AND delete_date IS NULL ";
    }

    if ($_GET['id'] != 0) {
        $sql = $sql."AND category = {$_GET['id']} ";
    }

    if (isset($_GET['search'])) {
        if ($_GET['search'] == '1') {
            $sql = $sql."AND (title LIKE '%{$_GET['word']}%' OR content LIKE '%{$_GET['word']}%') ";
        }
        else if ($_GET['search'] == '2') {
            $sql = $sql."AND title LIKE '%{$_GET['word']}%' ";
        }
        else if ($_GET['search'] == '3') {
            $sql = $sql."AND user_no IN (SELECT user_no FROM member WHERE nickname LIKE '%{$_GET['word']}%') ";
        }
    }

    if ($sort == '1') {
        $sql = $sql."ORDER BY board_no DESC ";
    }
    else if ($sort == '2') {
        $sql = $sql."ORDER BY likes DESC, board_no DESC ";
    }
    else if ($sort == '3') {
        $sql = $sql."ORDER BY view DESC, board_no DESC ";
    }

    $offset = ($_GET['p'] - 1) * 20;
    $sql = $sql."LIMIT {$offset}, 20;";
    $result = myquery($dbConnect, $sql);

    echo $sql;
    
    $sql = "SELECT FOUND_ROWS() AS total;";
    $tmp = mysqli_fetch_array(myquery($dbConnect, $sql));
    $total_page = intdiv($tmp['total'], 20) + ($tmp['total'] % 20 > 0);
    
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
        </tr>
    </thead>
    <tbody>
<?php
    while ($row = mysqli_fetch_array($result)){
        $title = $row['title'];
        if (strlen($title) > 30) {
            $title = mb_substr($title, 0, 30, 'UTF-8')."...";
        }
        $title = $title."<b>[{$row['reply_cnt']}]</b>";
        
        $sql = "SELECT nickname FROM member WHERE user_no = {$row['user_no']};";
        $nickname = mysqli_fetch_array(myquery($dbConnect, $sql));
?>
        <tr>
            <td><?php echo "<a href='view_post.php?id={$row['board_no']}'>{$title}</a>"; ?></td>
            <td><?php echo $nickname['nickname']; ?></td>
            <td><?php echo $row['create_date']; ?></td>
            <td><?php echo $row['view']; ?></td>
            <td><?php echo $row['likes']; ?></td>
        </tr>
<?php
    }
?>
    </tbody>
</table>

<!-- 페이지네이션 -->
<p>
    <center style = " font-size:1.5em;  color: green;">
        <?php
            $url = "boardlist.php?id={$_GET['id']}&sort={$sort}";
            if (isset($_GET['search'])) {
                $url = $url."&search={$_GET['search']}";
            }
            if (isset($_GET['word'])) {
                $url = $url."&word={$_GET['word']}";
            }

            $left = ($_GET['p'] - 1) - ($_GET['p'] - 1) % 10 + 1;
            if ($left > 1) {
                $previous = $left - 1;
                echo "<a href='{$url}&p={$previous}'><이전</a> ";
            }
            else {
                echo "<이전 ";
            }

            for ($i = $left; $i <= $total_page && $i < $left + 10; $i++) {
                if ($i == $_GET['p']) {
                    echo "<b>
                            <a href='{$url}&p={$i}'>{$i}</a>
                        </b> ";
                }
                else {
                    echo "<a href='{$url}&p={$i}'>{$i}</a> ";
                }
            }

            if ($i <= $total_page) {
                $next = $i;
                echo "<a href='{$url}&p={$next}'>다음></a>";
            }
            else {
                echo "다음>";
            }
        ?>
    </center>
</p>

<?php
    require_once('view/bottom.php');
?>
