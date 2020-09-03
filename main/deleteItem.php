<?php

    require_once '../connect/connect.php';
    require_once '../connect/disconnect.php';

    $connect = connect();

    //Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.

    $ids = isset($_POST['ids']) ? $_POST['ids'] : 0;
    
    $sql = "DELETE FROM stdmgn.Student WHERE ids = $ids";
    $result = $connect->query($sql);

    echo "[SUCCESSFULLY] Delete student with ID: ".$ids ;
    
    disconnect($connect);
       
?>    