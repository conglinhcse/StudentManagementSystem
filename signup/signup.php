

<?php

$username = "root"; // Khai báo username

$password = "conglinh";      // Khai báo password

$server   = "localhost";   // Khai báo server

$dbname   = "stdmgn";      // Khai báo database



// Kết nối database student

$connect = new mysqli($server, $username, $password, $dbname);



//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.

if ($connect->connect_error) {

    exit("Connection failed: " . $connect->connect_error);
    
}

$email = "";

$psw = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if (isset($_POST['email'])) {$email = trim($_POST['email']);}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$connect->close();
		exit('Error: Invalid email format');
    }
    $len = strlen($email);
    if (substr($email, $len - 11) != '@abc.edu.vn')
    {
        $connect->close();
		exit('Error: Email must finish with @abc.edu.vn');
    }

    if (isset($_POST['psw'])) {$psw = trim($_POST['psw']);}

    $sql = "SELECT * FROM AdminLogin WHERE username LIKE '%$email%'";
    $result = $connect->query($sql);

    // if ($result && $result->num_rows > 0) 
    // {
        
    //     echo "EXIST";
    // }
    // else
    // {
    //     $sql = "INSERT INTO AdminLogin (username, password)
    //         VALUES ('$email', '$psw');";

    //     $result = $connect->query($sql);


    //     if ($result)
    //         echo "OK";
    //     else
    //         echo "Sign Up Failure".$connect->error;
    // }

    if ($result) 
    {
        if ( $result->num_rows > 0)
            echo "This account is already existed!";
        else {
            $sql = "INSERT INTO AdminLogin (username, password)
            VALUES ('$email', '$psw');";

            $result = $connect->query($sql);

            if ($result)
                echo "Sign Up Successfully!";
            else
                echo "Sign Up Failure".$connect->error;
        }
    }
    else
        echo "Sign Up Failure".$connect->error;
    
}   
$connect->close();

?>