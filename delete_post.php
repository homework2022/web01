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

    while ($row = mysqli_fetch_array($result)) {
        if ($row['delete_date'] != NULL) {
            echo("<script>alert('삭제된 게시물입니다.')</script>");
            if ($_SESSION['user_id'] != 'admin') {
                echo("<script>window.location = '/web01/boardlist.php';</script>");
                exit;
            }
        }

        if ($row['user_id'] != $_SESSION['user_id'] && $_SESSION['user_id'] != 'admin') {
            echo("<script>alert('권한이 없습니다.')</script>");
            echo("<script>window.location = '/web01/boardlist.php';</script>");
            exit;
        }
?>

<script>
    var final_decision = confirm("정말 삭제하시겠습니까?");
</script>

<form id='decision' method='post' action='process_delete_post.php?id=<?php echo "{$_GET['id']}" ?>'> 
    <input type="hidden" name="final_decision" id="final_decision"> 
    <!--<input type="hidden" name="id" value = > -->
</form> 

<script> 
    document.getElementById('final_decision').value = final_decision;
    document.getElementById('decision').submit();
</script> 

<?php
    }
    require_once('view/bottom.php');
?>