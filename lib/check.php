<?php
    /* 중복 검사 */
    function check_user_input($col, $post_val, $dbConnect) {
        $sql = "SELECT ".$col." FROM member WHERE ".$col." = '".$post_val."'";
        $result = myquery($dbConnect, $sql);

        $row = mysqli_fetch_array($result);

        if ($row) {
            return false;
        }
        return true;
    }

    /* 사용자 정보 수정 */
    function update_user($col, $post_val, $dbConnect) {
        $sql = "UPDATE member SET ";

        if (check_user_input($col, $post_val, $dbConnect)) {
            $sql = $sql.$col." = '{$post_val}' WHERE user_id = '{$_SESSION['user_id']}';";
            $result = mysqli_query($dbConnect, $sql);
            $result = myquery($dbConnect, $sql);
            return true;
        }
        else {
            return false;
        }
    }

    function check_session(){
        if(!isset($_SESSION['user_id'])) {
            echo("<script>alert('로그인하세요')</script>");
            echo("<script>window.location = '/web01/login.php';</script>");
            exit;
        }
    }
?>