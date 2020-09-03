<?php
	require_once '../connect/connect.php';
    require_once '../connect/disconnect.php';

    $connect = connect();
//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.

	if ($connect->connect_error) {
		exit("Connection failed: " . $connect->connect_error);
	}

	//Khai báo giá trị ban đầu, nếu không có thì khi chưa submit câu lệnh insert sẽ báo lỗi

	$ids = "";

	$full_name = "";

	$sex = "";

	$birthday = "";

	$address = "";

	$faculty = "";

	$class_name = "";

	$phone_number = "";

	$email = "";

	$enryear = "";

	$grayear = "";

	$formot = "";

	$levelot = "";

	$avatar = "";

	//Lấy giá trị POST từ form vừa submit

	if ($_SERVER["REQUEST_METHOD"] == "POST"){

		if (isset($_POST['ids'])) {$ids = $_POST['ids'];}

		if (isset($_POST['full_name'])) {$full_name = $_POST['full_name'];}

		if (isset($_POST['sex'])) {$sex = $_POST['sex'];}

		if (isset($_POST['birthday'])) {$birthday = $_POST['birthday'];}
		$birthday = str_replace('/', '-', $birthday);
		$birthday = date('Y-m-d', strtotime($birthday));

		if (isset($_POST['address'])) {$address = $_POST['address'];}
		
		if (isset($_POST['faculty'])) {$faculty = $_POST['faculty'];}

		if (isset($_POST['class_name'])) {$class_name = $_POST['class_name'];}

		if (isset($_POST['phone_number'])) {$phone_number = $_POST['phone_number'];}

		if (isset($_POST['email'])) {$email = $_POST['email'];}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$connect->close();
			exit('Error: Invalid email format');
		}


		if (isset($_POST['enryear'])) {$enryear = $_POST['enryear'];}
		$enryear = str_replace('/', '-', $enryear);
		$enryear = date('Y-m-d', strtotime($enryear));

		if (isset($_POST['grayear'])) {$grayear = $_POST['grayear'];}
		$grayear = str_replace('/', '-', $grayear);
		$grayear = date('Y-m-d', strtotime($grayear));

		if (isset($_POST['formot'])) {$formot = $_POST['formot'];}

		if (isset($_POST['levelot'])) {$levelot = $_POST['levelot'];}

		if (isset($_POST['linkavatar'])) {$avatar = $_POST['linkavatar'];}
		if($avatar == "")
			$avatar = "https://www.w3schools.com/w3images/avatar2.png";

		//Code xử lý, update dữ liệu vào table

		$sql = "UPDATE Student SET 
					full_name = '$full_name',
					sex = '$sex',
					birthday = '$birthday',
					address = '$address',
					faculty = '$faculty',
					class_name = '$class_name',
					phone_number = '$phone_number',
					email = '$email',
					enryear = '$enryear',
					grayear = '$grayear',
					formot = '$formot',
					levelot = '$levelot',
					avatar = '$avatar'
				WHERE ids = '$ids';";

		$result = $connect->query($sql);

		
		if ($result == true){

			echo "Update successfully";
		}
		else 

			echo "Update failure".$connect->error;

	}

	disconnect($connect);
?>
