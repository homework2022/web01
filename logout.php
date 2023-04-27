<?php
    if (!session_id()) { 
        session_start(); 
    } 
    session_unset();
    session_destroy();
    echo("<script>alert('로그아웃되었습니다.')</script>");
    echo("<script>window.location = '/web01/index.php';</script>");
    exit;
?>