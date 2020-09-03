<?php
    function disconnect($connect){
        //Đóng kết nối database stdmgn
        $connect->close();
    }
?>