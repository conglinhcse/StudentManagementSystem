<?php

    require_once '../connect/connect.php';
    require_once '../connect/disconnect.php';

    $connect = connect();

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


    if (isset($_POST['psw'])) {$psw = trim($_POST['psw']);}

    $sql = "SELECT * 
            FROM AdminLogin 
            WHERE username = '$email' AND password = '$psw';";


    $result = $connect->query($sql);

    if ($result) 
    {   if ($result->num_rows == 1)
            {
                $row = $result->fetch_assoc();
                echo "OK".$row['adminid'];
            }
        else    
            echo "Wrong email or password! Please enter again!";
    }
    else        
        echo "Sign In Failure".$connect->error;
}   

    disconnect($connect);

?>