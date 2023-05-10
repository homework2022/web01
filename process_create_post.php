<?php
    require_once('lib/check.php');
    require_once('lib/connect.php');

    check_session();

    $category = $_POST['category'];
    $sql = "INSERT INTO board (user_no, category, title, content, create_date)
     VALUES (
        (SELECT user_no FROM member WHERE user_id = '{$_SESSION['user_id']}'),
        '{$_POST['category']}',
        '{$_POST['title']}',
        '{$_POST['content']}',
        now()
     )
    ";

    $result = myquery($dbConnect, $sql);
    
    echo("<script>alert('글쓰기 성공')</script>");
    echo("<script>window.location = '/web01/boardlist.php?id={$_POST['category']}&p=1';</script>");
    exit;
?>

