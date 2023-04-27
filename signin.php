<?php
    require_once('view/top.php');
?>

<p>
    <form action="process_signin.php" method="POST">
        <p>아이디를 입력하세요(최대 20자): <input type="text" name="id" placeholder="id" maxlength='20' required></p>
        <p>비밀번호를 입력하세요(최대 20자): <input type="password" name="password" placeholder="password" maxlength='20' required></p>
        <p>비밀번호를 한 번 더 입력하세요: <input type="password" name="password_check" placeholder="password 확인" maxlength='20' required></p>
        <p>이메일을 입력하세요: <input type="text" name="email" placeholder="ex: your@email.com" maxlength='128' required></p>
        <p>닉네임을 입력하세요(최대 20자): <input type="text" name="nickname" placeholder="nickname" maxlength='20' required></p>
        <p><input type="submit"></p>
    </form>
</p>

<?php
    require_once('view/bottom.php');
?>