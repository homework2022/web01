<?php
    require_once('view/top.php');

    check_session();
?>

<ul>
    <li><a href="editprofile.php">개인정보 수정</a></li>
    <li>내가 쓴 글</li>
    <li>내가 쓴 댓글</li>
    <li>피드</li>
    <li><a href="withdrawal.php">회원탈퇴</a></li>
</ul>



<?php
    require_once('view/bottom.php');
?>
