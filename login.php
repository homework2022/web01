<?php
    require_once('view/top.php');
?>

<p>
    <form action="process_login.php" method="POST">
        <p>아이디를 입력하세요: <input type="text" name="id" placeholder="id" maxlength='20' required></p>
        <p>비밀번호를 입력하세요: <input type="password" name="password" placeholder="password" maxlength='20' required></p>
        <p><input type="submit"></p>
    </form>
</p>

<?php
    require_once('view/bottom.php');
?>
