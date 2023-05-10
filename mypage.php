<?php
    require_once('view/top.php');

    check_session();
?>

<ul>
    <li><a href="editprofile.php">개인정보 수정</a></li>
    <li><a href="feed.php">피드</a></li>
    <li><a href="withdrawal.php">회원탈퇴</a></li>
</ul>

<?php
    require_once('view/bottom.php');
?>
