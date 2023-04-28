<?php
    $dbConnect = mysqli_connect(
        'localhost',
        'root',
        '',
        'web01'
    );

    if (mysqli_connect_errno()) {
        echo 'db connect fail..';
        echo mysqli_connect_error();
    }

    if(!session_id()) { 
        session_start(); 
    }

    function myquery($dbConnect, $sql){
        $result = mysqli_query($dbConnect, $sql);
        if ($result == false) {
            echo mysqli_error($dbConnect);
            echo("<script>alert('db 오류')</script>");
            exit;
        }
        else {
            return $result;
        }
    }
?>