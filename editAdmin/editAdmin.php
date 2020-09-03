<?php
	require_once '../connect/connect.php';
    require_once '../connect/disconnect.php';

    $connect = connect();
//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.

	if ($connect->connect_error) {
		exit("Connection failed: " . $connect->connect_error);
	}

	//Khai báo giá trị ban đầu, nếu không có thì khi chưa submit câu lệnh insert sẽ báo lỗi

	$adminid = "";

	$adminname = "";

	$sex = "";

	$birthday = "";

	$password = "";

	$degree = "";

	$adminposition = "";

	$adminphone = "";

	$username = "";

	$adminavatar = "";

	//Lấy giá trị POST từ form vừa submit

	if ($_SERVER["REQUEST_METHOD"] == "POST"){

		if (isset($_POST['adminid'])) {$adminid = $_POST['adminid'];}

		if (isset($_POST['adminname'])) {$adminname = $_POST['adminname'];}

		if (isset($_POST['sex'])) {$sex = $_POST['sex'];}

		if (isset($_POST['birthday'])) {$birthday = $_POST['birthday'];}
		$birthday = str_replace('/', '-', $birthday);
		$birthday = date('Y-m-d', strtotime($birthday));

		if (isset($_POST['password'])) {$password = $_POST['password'];}
		
		if (isset($_POST['degree'])) {$degree = $_POST['degree'];}

		if (isset($_POST['adminposition'])) {$adminposition = $_POST['adminposition'];}

		if (isset($_POST['adminphone'])) {$adminphone = $_POST['adminphone'];}

		if (isset($_POST['username'])) {$username = $_POST['username'];}
		// if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
		// 	$connect->close();
		// 	exit('Error: Invalid username format');
		// }

		if (isset($_POST['adminavatar'])) {$adminavatar = $_POST['adminavatar'];}
		if($adminavatar == "")
			$adminavatar = "https://www.w3schools.com/w3images/avatar2.png";

		//Code xử lý, update dữ liệu vào table

		$sql = "UPDATE AdminLogin SET 
					adminname = '$adminname',
					sex = '$sex',
					birthday = '$birthday',
					password = '$password',
					degree = '$degree',
					adminposition = '$adminposition',
					adminphone = '$adminphone',
					username = '$username',
					adminavatar = '$adminavatar'
				WHERE adminid = '$adminid';";

		$result = $connect->query($sql);

		
		if ($result == true){

			echo "Update successfully";
		}
		else 

			echo "Update failure".$connect->error;

	}

	disconnect($connect);
?>
