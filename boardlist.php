<?php
    require_once('view/top.php');

    if (!isset($_GET['id']) || !isset($_GET['p'])) {
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
    $sql = "SELECT SQL_CALC_FOUND_ROWS title, create_date, user_no, view, likes, reply_cnt, board_no FROM board "; 
    if (!isset($_SESSION['user_id']) || (isset($_SESSION['user_id']) && $_SESSION['user_id'] != 'admin')) {
        $sql = $sql."WHERE delete_date IS NULL ";
    }
    if ($_GET['id'] != 0) {
        $sql = $sql."AND category = {$_GET['id']} ";
    }
    $offset = ($_GET['p'] - 1) * 20;
    $sql = $sql."ORDER BY board_no DESC LIMIT {$offset}, 20;";
    $result = myquery($dbConnect, $sql);
    
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

<p>
    <center style = " font-size:1.5em;  color: green;">
        <?php
            $left = ($_GET['p'] - 1) - ($_GET['p'] - 1) % 10 + 1;
            if ($left > 1) {
                $previous = $left - 1;
                echo "<a href='boardlist.php?id={$_GET['id']}&p={$previous}'><이전</a> ";
            }
            else {
                echo "<이전 ";
            }

            for ($i = $left; $i <= $total_page && $i < $left + 10; $i++) {
                if ($i == $_GET['p']) {
                    echo "<b>
                            <a href='boardlist.php?id={$_GET['id']}&p={$i}'>{$i}</a>
                        </b> ";
                }
                else {
                    echo "<a href='boardlist.php?id={$_GET['id']}&p={$i}'>{$i}</a> ";
                }
            }

            if ($i <= $total_page) {
                $next = $i;
                echo "<a href='boardlist.php?id={$_GET['id']}&p={$next}'>다음></a>";
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
