<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href="editAdmin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
        rel="stylesheet" type="text/html" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/index/const/const.js"></script>

    <title>Edit Form Received Data From Main Page</title>

    <script>
        function cancelFunc() {
            if (confirm("Do you want to cancel editting?")) {
                var aid = '<?php echo (string)$_REQUEST["aid"]; ?>';
                location.replace(MAIN + '?id=' + aid);
            }
        }
    </script>

    <!-- Encode image to base64  -->
    <script>
        function encodeImageFileAsURL(element) {
            var file = element.files[0];
            var reader = new FileReader();
            var image = document.getElementById('avatar');
            reader.onloadend = function () {
                image.src = reader.result;
            }
            reader.readAsDataURL(file);
        }  
    </script>

    <script>
        function myAlert() {
            alert("Insert successfully");
        } 
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#myform").on('submit', function (e) {
                e.preventDefault();

                var url = $(this).closest('form').attr('action'),
                    data = $(this).closest('form').serialize();

                var adminname = $("#adminname").val();
                adminname = adminname.trim();

                var birthday = $("#birthday").val();

                var adminphone = $("#adminphone ").val();

                var password = $("#password ").val();

                var username = $("#username").val();
                username = username.trim();

                var image = document.getElementById('avatar');

                document.getElementById('adminavatar').value = image.src;

                if (adminname == '' || birthday == '' || password == '') {
                    alert("Please fill in all fields");
                }
                else if (NAMEFORMAT.test(adminname) == false)
                {
                    //Check format of name             
                    alert("Name format is incorrect. Name must have only a-z, A-Z and white space");       
                }
                else if (adminphone != '' && !PHONEFORMAT.test(adminphone))
                {
                    alert("Phone number format is incorrect. Name must have only 0-9 and must start with 0; TOTAL 10 CHARACTER");
                }
                else if (!EMAILFORMAT.test(username.toLowerCase()))
                {
                    alert("Email format is incorrect. Please enter again!");
                }
                else {
                    // Ajax code to submit form.
                    // avatar = "https://www.extremetech.com/wp-content/uploads/2019/12/SONATA-hero-option1-764A5360-edit.jpg";
                    if (confirm('Do you really want to update this information?')) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            cache: false,
                            success: function (result) {
                                console.log(data);
                                alert(result);
                            }
                        });
                    }
                    else
                        alert("You have canceled to update this information");

                }
                return false;
            });
        });
    </script>

</head>

<body>

    <?php
        require_once '../connect/connect.php'; //CONNECT TO DATABASE
        require_once '../connect/disconnect.php'; //DISCONNECT TO DATABASE
        require '../const/const.php'; //KEYWORD CONST

        $connect = connect();

        //Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
        $link = (string)$_REQUEST["ids"];

        $date = getdate();
        $min = (int)$date['minutes'];
        $sec = (int)$date['seconds'];

        // Padding time
        if ($sec > 55) $min = ($min + 1)%60;
        
        //Lay chieu dai cua fakeID tu index 79 den het chuoi
        $leng = substr($link, 79, strlen($link)-79);

        // Tach fakeID trong chuoi
        $fakeID = substr($link, $min, (int)$leng);

        // Tinh toan ra realID 
        //Filter real ID from fake ids
        $realID = (int)$fakeID - $min;

        $sql = "SELECT * FROM stdmgn.AdminLogin WHERE adminid = $realID;";
        $result = $connect->query($sql);
        $row = $result->fetch_assoc();
        
        disconnect($connect);
        
    ?>

    <script> 
        if ('<?php echo $row ?>' == '')
                window.open('<?php echo FORBIDDEN ?>' , '_self');
    </script>

    <h1 style="color: antiquewhite;">Detail Admin Information</h1>

    <!-- <form action="http://localhost:8080/index/edit/edit.php" method="POST" onsubmit="return validate(this)" id="myForm"> -->
    <form action="<?php echo EDITADMIN; ?>" id="myform" autocomplete="on">
        <div class="row">
            <div class="col-75">
                <div class="container">
                    <form action="/action_page.php">

                        <div class="row">
                            <div class="col-50">
                                <h2 style="font-family: monospace;">Admin Information</h2>
                                <div class="row">
                                    <div class="col-75">
                                        <label for="adminname"><i class="fa fa-user"></i> Full Name</label>
                                        <input type="text" id="adminname" name="adminname" value="<?php echo $row['adminname']; ?>"
                                        maxlength="50" required>
                                    </div>
                                    <div class="col-25">
                                        <label for="adminid"><i class="fa fa-user"></i> ID</label>
                                        <input type="text" id="adminid" name="adminid" value="<?php echo $row['adminid']; ?>" readonly>
                                    </div>
                                </div>

                                <label for="gender"><i class="fa fa-intersex"></i> Gender</label>
                                <input type="radio" style="margin-right: 5px;" name="sex" id="male" name="gender"
                                    value="Male" <?php echo ($row['sex'] == 'Male') ? 'checked' : ''?> >
                                Male</input>
                                <input type="radio" style="margin-left: 5px;" name="sex" id="female" name="gender"
                                    value="Female" <?php echo ($row['sex'] == 'Female') ? 'checked' : ''?>>
                                Female</input>


                                <label for="birthday"><i class="fa fa-birthday-cake"></i> Birthday</label>
                                <input type="date" id="birthday" name="birthday" style="padding: 10px;" value="<?php echo $row['birthday']; ?>" required>

                                <label for="adminphone"><i class="fa fa-phone"></i> Phone</label>
                                <input type="tel" id="adminphone" name="adminphone" value="<?php echo $row['adminphone']; ?>" maxlength="10">
                            </div>

                            <div class="col-50">
                                <h2 style="font-family: monospace;">Academic Information</h2>

                                <label for="degree"><i class="fa fa-cogs"></i> Degree</label>
                                <select name="degree" id="degree" placeholder="Degree" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                <optgroup label="Degree" style="font-family: Arial;font-size: 20px">
                                    <option style="font-size: 15px;" <?php echo ($row['degree'] == PHD) ? 'selected' : ''?> value="<?php echo PHD ?>"> <?php echo PHD ?> </option>
                                    <option style="font-size: 15px;" <?php echo ($row['degree'] == DBA) ? 'selected' : ''?> value="<?php echo DBA ?>"> <?php echo DBA ?> </option>
                                    <option style="font-size: 15px;" <?php echo ($row['degree'] == BSC) ? 'selected' : ''?> value="<?php echo BSC ?>"> <?php echo BSC ?> </option>
                                    <option style="font-size: 15px;" <?php echo ($row['degree'] == MSI) ? 'selected' : ''?> value="<?php echo MSI ?>"> <?php echo MSI ?> </option>
                                    <option style="font-size: 15px;" <?php echo ($row['degree'] == DSI) ? 'selected' : ''?> value="<?php echo DSI ?>"> <?php echo DSI ?> </option>                                   
                                </optgroup>
                                </select>


                                <label for="adminposition"><i class="fa fa-institution"></i> Position</label>
                                <select name="adminposition" id="adminposition" placeholder="Position" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                <optgroup label="Position" style="font-family: Arial;font-size: 20px" selected>
                                    <option style="font-size: 15px;" value="<?php echo FOU ?>" <?php echo ($row['adminposition'] == FOU) ? 'selected' : ''?> > <?php echo FOU ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo TEA ?>" <?php echo ($row['adminposition'] == TEA) ? 'selected' : ''?> > <?php echo TEA ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo TRA ?>" <?php echo ($row['adminposition'] == TRA) ? 'selected' : ''?> > <?php echo TRA ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo TAS ?>" <?php echo ($row['adminposition'] == TAS) ? 'selected' : ''?> > <?php echo TAS ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo DIR ?>" <?php echo ($row['adminposition'] == DIR) ? 'selected' : ''?> > <?php echo DIR ?> </option>
                            
                                </optgroup>
                                </select>

                                <label for="username"><i class="fa fa-envelope"></i> Email </label>
                                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" maxlength="50" required readonly>

                                <label for="password"><i class="fa fa-envelope"></i> Password </label>
                                <input type="text" id="password" name="password" value="<?php echo $row['password']; ?>" maxlength="50" required>

                                <input type="text" id="adminavatar" name="adminavatar" style="display:none;">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-25">
                <div class="container_2">
                    <div style="text-align: center;">
                        <p style="text-align: center;">
                            <img id="avatar" src="<?php echo $row['adminavatar']; ?>" alt="avatar">
                        </p>
                        <button class="clbt" id="clbt" for="getFile" type="button"
                            onclick="document.getElementById('getFile').click()">Change avatar</button>

                        <input type="file" id="getFile" name="img" accept="image/*" style="display:none;"
                        onchange="encodeImageFileAsURL(this)">

                        <div class=" row">
                            <div class="col-50">
                                <input type="submit" value="Update" class="btn">
                            </div>

                            <div class="col-50">
                                <input type="button" value="Cancel" class="btn" onclick="cancelFunc()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


</body>

</html>