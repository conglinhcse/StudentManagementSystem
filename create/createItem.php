<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href="create.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
        rel="stylesheet" type="text/html" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/index/const/const.js"></script>

    <title>Create New Form</title>

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
        function cancelFunc() {
            if (confirm("Do you want to cancel creating?")) {
                location.replace(MAIN);
            }
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
                var full_name = $("#full_name").val();
                full_name = full_name.trim();
                var birthday = $("#birthday").val();
                var address = $("#address").val();
                address = address.trim();
                var phone_number = $("#phone_number ").val();
                phone_number = phone_number.trim();
                
                var enryear = $("#enryear").val();
                var grayear = $("#grayear").val();

                var email = $("#email").val();
                email = email.trim();

                var image = document.getElementById('avatar');
                document.getElementById('linkavatar').value = image.src;

                if (full_name == '' || birthday == '' || address == '' || email == '' || enryear == '' || grayear == '') {
                    alert("Please fill in all fields");
                }
                else if (!NAMEFORMAT.test(full_name))
                {
                    //Check format of name             
                    alert("Name format is incorrect. Name must have only a-z, A-Z and white space");       
                }
                else if (phone_number != '' && !PHONEFORMAT.test(phone_number))
                {
                    alert("Phone number format is incorrect. Name must have only 0-9 and must start with 0; TOTAL 10 CHARACTER");
                }
                else if (!EMAILFORMAT.test(email.toLowerCase()))
                {
                    alert("Email format is incorrect. Please enter again!");
                }
                else if (!ADDRESSFORMAT.test(address.toLowerCase()))
                {
                    alert("Address format is incorrect. Please enter again!");
                }
                else if (parseInt(grayear.slice(0,4)) - parseInt(enryear.slice(0,4)) < 2)
                {
                    alert("Learing time is too short. Graduation Year must be 2 years bigger than Enrollment Year!");
                }
                else {
                    // Ajax code to submit form.
                    if (confirm('Do you really want to create new information?')) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            cache: false,
                            success: function (result) {
                                alert(result);
                            }
                        });
                    }
                    else
                        alert("You have canceled to create new information");
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

        $sql = "SELECT MAX(ids) FROM Student;";

        $result = $connect->query($sql);
        $row = $result->fetch_assoc();

        disconnect($connect);
    ?>

    <h1 style="color: antiquewhite;">Detail Student Information</h1>

    <!-- <form action="http://localhost:8080/index/edit/edit.php" method="POST" onsubmit="return validate(this)" id="myForm"> -->
    <form action="<?php echo CREATE; ?>" id="myform" autocomplete="on">
        <div class="row">
            <div class="col-75">
                <div class="container">
                    <form action="/action_page.php">

                        <div class="row">
                            <div class="col-50">
                                <h2 style="font-family: monospace;">Personal Information</h2>
                                <div class="row">
                                    <div class="col-75">
                                        <label for="full_name"><i class="fa fa-user"></i> Full Name</label>
                                        <input type="text" id="full_name" name="full_name" placeholder="John Stone"
                                        maxlength="50" required>
                                    </div>
                                    <div class="col-25">
                                        <label for="ids"><i class="fa fa-user"></i> ID </label>
                                        <input type="text" id="ids" name="ids" value="<?php printf('%05d', $row['MAX(ids)']+1); ?>" readonly>
                                    </div>
                                </div>

                                <label for="gender"><i class="fa fa-intersex"></i> Gender</label>
                                <input type="radio" style="margin-right: 5px;" name="sex" id="male" name="gender"
                                    value="Male" checked="checked">
                                Male</input>
                                <input type="radio" style="margin-left: 5px;" name="sex" id="female" name="gender"
                                    value="Female">
                                Female</input>


                                <label for="birthday"><i class="fa fa-birthday-cake"></i> Birthday</label>
                                <input type="date" id="birthday" name="birthday" style="padding: 10px;" required>

                                <label for="address"><i class="fa fa-address-card-o"></i> Address</label>
                                <input type="text" id="address" name="address"
                                    placeholder="542 W. Nguyen Sieu Street, Ho Chi Minh City" maxlength="100" required>

                                <label for="phone_number"><i class="fa fa-phone"></i> Phone</label>
                                <input type="tel" id="phone_number" name="phone_number" placeholder="Phone" maxlength="10"> 
                            </div>

                            <div class="col-50">
                                <h2 style="font-family: monospace;">Academic Information</h2>

                                <!-- <label for="faculty"><i class="fa fa-cogs"></i> Faculty</label>
                                <input type="text" list="browsers" name="faculty" id="browsers1" placeholder="Faculty" disabled 
                                    required>
                                <datalist id="browsers">
                                    <option value="Electrical & Electronics Engineering">
                                    <option value="Computer Science & Engineering">
                                    <option value="Apllied Sci">
                                    <option value="Materials Technology">
                                    <option value="Civil Engineering">
                                    <option value="Chemical Engineering">
                                </datalist> -->
                                
                                <label for="faculty"><i class="fa fa-cogs"></i> Faculty</label>
                                <select name="faculty" id="faculty" placeholder="Faculty" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                <optgroup label="Faculty" style="font-family: Arial;font-size: 20px">
                                    <option style="font-size: 15px;" value="<?php echo EEE ?>"> <?php echo EEE ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CSE ?>"> <?php echo CSE ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo APS ?>"> <?php echo APS ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo MAT ?>"> <?php echo MAT ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CIE ?>"> <?php echo CIE ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CHE ?>"> <?php echo CHE ?> </option>
                                </optgroup>
                                </select>


                                <label for="class_name"><i class="fa fa-institution"></i> Class</label>
                                <select name="class_name" id="class_name" placeholder="Faculty" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                <optgroup label="Class" style="font-family: Arial;font-size: 20px" selected>
                                    <option style="font-size: 15px;" value="<?php echo PH ?>" > <?php echo PH ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo LA ?>" > <?php echo LA ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo MT ?>" > <?php echo MT ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CO ?>" > <?php echo CO ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CE ?>" > <?php echo CE ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo ASS ?>" > <?php echo ASS ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo CH ?>" > <?php echo CH ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo ME ?>" > <?php echo ME ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo EE ?>" > <?php echo EE ?> </option>
                                    <option style="font-size: 15px;" value="<?php echo SP ?>" > <?php echo SP ?> </option>
                                </optgroup>
                                </select>

                                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                                <input type="text" id="email" name="email" placeholder="john@gmail.com" maxlength="50" required>

                                <div class="row">
                                    <div class="col-50">
                                        <label for="enryear"><i class="fa fa-address-card"></i> Enrollment Year</label>
                                        <input type="date" id="enryear" name="enryear" style="padding: 10px;">
                                    </div>
                                    <div class="col-50">
                                        <label for="grayear"><i class="fa fa-mortar-board"></i> Graduation Year</label>
                                        <input type="date" id="grayear" name="grayear" style="padding: 10px;">
                                    </div>

                                    <div class="col-50">
                                    <label for="formot"><i class="fa fa-cogs"></i> Form of training</label>
                                        <select name="formot" id="formot" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                        <optgroup label="Form of training" style="font-family: Arial;font-size: 20px">
                                            <option style="font-size: 15px;" value="<?php echo FT ?>"> <?php echo FT ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo PT ?>"> <?php echo PT ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo DL ?>"> <?php echo DL ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo SD ?>"> <?php echo SD ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo GS ?>"> <?php echo GS ?> </option>
                                        </optgroup>
                                        </select>
                                    </div>

                                    <div class="col-50">
                                    <label for="levelot"><i class="fa fa-institution"></i> Level of training</label>
                                        <select name="levelot" id="levelot" style="padding: 0 16px;width: 100%;margin-bottom: 20px;padding: 12px;border: 1px solid #ccc;border-radius: 10px;">
                                        <optgroup label="Level of training" style="font-family: Arial;font-size: 20px">
                                            <option style="font-size: 15px;" value="<?php echo UDG ?>"> <?php echo UDG ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo MTD ?>"> <?php echo MTD ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo DTD ?>"> <?php echo DTD ?> </option>
                                            <option style="font-size: 15px;" value="<?php echo SCD ?>"> <?php echo SCD ?> </option>
                                        </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <!-- Hidden input to send base64image to backend -->
                                <input type="text" id="linkavatar" name="linkavatar" style="display:none;">
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="col-25">
                <div class="container_2">                                     
                    <div style="text-align: center;">                    
                        <p style="text-align: center;">
                            <img id="avatar" src="https://www.w3schools.com/w3images/avatar2.png" alt="avatar">
                        </p>
                        <button class="clbt" id="clbt" for="getFile" type="button"
                            onclick="document.getElementById('getFile').click()">Change avatar</button>

                        <input type="file" id="getFile" name="img" accept="image/*" style="display:none;"
                        onchange="encodeImageFileAsURL(this)">
                        
                        <div class=" row">
                            <div class="col-50">
                                <input type="submit" value="Create" class="btn" onclick="return validate(this)">
                            </div>

                            <div class="col-50">
                                <input value="Cancel" class="btn" type="button" onclick="cancelFunc()">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>