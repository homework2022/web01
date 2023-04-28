<?php
    require_once('view/top.php');
?>

<p>
    <form action="process_find_userid.php" method="POST">
        <p>이메일을 입력하세요: <input type="text" name="email" placeholder="email" maxlength='128' required></p>
        <p><input type="submit"></p>
    </form>
</p>

<?php
    require_once('view/bottom.php');
?>