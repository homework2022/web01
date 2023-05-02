<?php
    require_once('view/top.php');

    if (!isset($_GET['id'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0';</script>");
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
        <a href="boardlist.php?id=0">
            <?php if ($_GET['id'] == 0) { echo ("<strong>전체</strong>"); } else { echo "전체"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=1">
            <?php if ($_GET['id'] == 1) { echo ("<strong>공지</strong>"); } else { echo "공지"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=2">
            <?php if ($_GET['id'] == 2) { echo ("<strong>자유</strong>"); } else { echo "자유"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=3">
            <?php if ($_GET['id'] == 3) { echo ("<strong>Q&A</strong>"); }  else { echo "Q&A"; } ?>
        </a>
    </li>
    <li>
        <a href="boardlist.php?id=4">
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
    $sql = "SELECT title, create_date, user_no, view, likes, reply_cnt FROM board ";
    if ($_GET['id'] != 0) {
        $sql = $sql."WHERE category = {$_GET['id']} ";
    }
    $sql = $sql."ORDER BY create_date LIMIT 20;";
    $result = myquery($dbConnect, $sql);
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
            $title = substr($title, 0, 30)."...";
        }
        $title = $title."[{$row['reply_cnt']}]";
        
        $sql = "SELECT user_id FROM member WHERE user_no = {$row['user_no']};";
        $user_id = mysqli_fetch_array(myquery($dbConnect, $sql));
?>
                <tr>
                    <td><?php echo $row['title'] ?></td>
                    <td><?php echo $user_id['user_id'] ?></td>
                    <td><?php echo $row['create_date'] ?></td>
                    <td><?php echo $row['view'] ?></td>
                    <td><?php echo $row['likes'] ?></td>
                </tr>
<?php
    }
?>
            </tbody>
        </table>
<?php
    require_once('view/bottom.php');
?>
