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

<ul>
    <li><a href="find_userid.php">아이디 찾기</a></li>
    <li><a href="reset_password.php">비밀번호 찾기</a></li>
</ul>

<?php
    require_once('view/bottom.php');
?>
