<?php
    require_once('view/top.php');

    check_session();

    if(!isset($_SESSION['user_pw_check'])) {
?>
                <p>
                    <form action="process_check_password.php" method="POST">
                        비밀번호를 입력하세요: <input type="password" name="password" placeholder="password" maxlength='20' required>
                        <input type="hidden" name="redirect" value="withdrawal.php">
                        <input type="submit">
                    </form>
                </p>
        
<?php
            }
            else {
?>
                    <p>
                        <form action="process_withdrawal.php" method="POST">
                            정말 탈퇴하시겠습니까? (Y/N): <input type="text" name="final_decision" maxlength='1' required>
                            <input type="submit">
                        </form>
                    </p>

<?php
            }
    require_once('view/bottom.php');
?>