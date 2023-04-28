<?php
    require_once('view/top.php');
    require_once('lib/check.php');

    check_session();

    /*현재 설정된 이메일 가져오기 */
    $sql = "SELECT email FROM member WHERE user_id = '{$_SESSION['user_id']}';";
    $result = mysqli_query($dbConnect, $sql);
    if ($result == false) {
        echo mysqli_error($dbConnect);
        echo("<script>alert('db 오류')</script>");
        exit;
    }
    while ($row = mysqli_fetch_array($result)){
        $email = $row['email'];
    }

    /*현재 설정된 닉네임 가져오기 */
    $sql = "SELECT nickname FROM member WHERE user_id = '{$_SESSION['user_id']}';";
    $result = mysqli_query($dbConnect, $sql);
    if ($result == false) {
        echo mysqli_error($dbConnect);
        echo("<script>alert('db 오류')</script>");
        exit;
    }
    while ($row = mysqli_fetch_array($result)){
        $nickname = $row['nickname'];
    }
?>

<h3>변경할 정보를 입력하고 제출을 누르세요</h3>

<p>
    <form action="process_editprofile.php" method="POST">
        변경할 아이디를 입력하세요(최대 20자): <input type="text" name="id" placeholder="id" maxlength='20' required>
        <input type="submit">
    </form>
</p>
<p>
    <form action="process_editprofile.php" method="POST">
        비밀번호를 입력하세요(최대 20자): <input type="password" name="password" placeholder="password" maxlength='20' required>
        비밀번호를 한 번 더 입력하세요: <input type="password" name="password_check" placeholder="password 확인" maxlength='20' required>
        <input type="submit">
    </form>
</p>
<p>
    <form action="process_editprofile.php" method="POST">
        이메일을 입력하세요(현재 <?php echo $email?>): <input type="text" name="email" placeholder="ex: your@email.com" maxlength='128' required>
        <input type="submit">
    </form>
</p>
<p>
    <form action="process_editprofile.php" method="POST">
        닉네임을 입력하세요(최대 20자, 현재 <?php echo $nickname?>): <input type="text" name="nickname" placeholder="nickname" maxlength='20' required>
        <input type="submit">
    </form>
</p>

<?php
    require_once('view/bottom.php');
?>