<?php
    function connect()  {
        define("username", "user_std"); // Khai báo username

        define("password", "a123");      // Khai báo password

        define("server"  , "localhost");   // Khai báo server

        define("dbname"  , "stdmgn");      // Khai báo database

        // Kết nối database student

        $connect = new mysqli(server, username, password, dbname);

        if ($connect->connect_error) {

            die("Not connection :" . $connect->connect_error);
    
            exit();
    
        }

        return $connect;
    };
?>