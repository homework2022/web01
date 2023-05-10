<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    if (!isset($_GET['reply_no'])) {
        echo("<script>window.location = '/web01/boardlist.php?id=0&p=1';</script>");
        exit;
    }
?>

<script>
    var final_decision = confirm("정말 삭제하시겠습니까?");
</script>

<form id='decision' method='post' action='process_delete_reply.php?reply_no=<?=$_GET['reply_no']?>&board_no=<?=$_GET['board_no']?>'> 
    <input type="hidden" name="final_decision" id="final_decision"> 
</form> 

<script> 
    document.getElementById('final_decision').value = final_decision;
    document.getElementById('decision').submit();
</script> 