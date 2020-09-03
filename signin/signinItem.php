<!DOCTYPE html>
<html lang="vi">

<head>

    <link rel="stylesheet" type="text/css" href="signin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script type="text/javascript" src="signin.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/index/const/const.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Signin Form</title>

    <?php require '../const/const.php'; ?>

    <script>
        function validateCancel(form) {

            if (confirm('Do you really want to cancel sign ip')) {
                window.open(WELCOME, '_self');
            }
        }
    </script>

    <script>
        function createFakeID(realID){
            realID = parseInt(realID);
            //Self-defined Charset
            var possible = "ABCDEFGHIJ0123456789KLMNOPQRSTU0123456789VWXYZabcdefgh0123456789KLMNOPQRSTU0123456789Vijklmnopqrstuvwxyz";
            var text = "";

            //Take current minute
            var today = new Date();
            var hour = parseInt(today.getHours()) + 1;
            var secs = parseInt(today.getSeconds());

            //Padding time 
            if(secs >= 58) hour = hour + 1;

            //minute plus ID to hide real ID
            fakeID = hour * parseInt(realID);

            //Create an string with 80 chars, and hide fake ID based on minus
            for (var i = 0; i <= 79;){
                if(i==hour)
                {   //Fake ID 
                    text += fakeID;
                    i += parseInt(String(fakeID).length);
                    continue;
                }
                if(i== 79)
                {
                    //Index where embedded fake ID
                    text += String(fakeID).length;
                    i++;
                    continue;
                }
                text += possible.charAt(Math.floor(Math.random() * possible.length));
                i++;
            }
            fakeID = text;
            return fakeID;
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#signinform").on('submit', function (e) {
                e.preventDefault();

                var url = $(this).closest('form').attr('action'),
                    data = $(this).closest('form').serialize();

                var email = $("#email").val();
                var psw = $("#psw").val();

                email = email.trim();
                psw = psw.trim();

                if (email.substring(email.length - 11) != "@abc.edu.vn") {
                    alert("Email must finish with @abc.edu.vn");
                }
                else if (email.indexOf("'") != -1 || email.indexOf('"') != -1 || email.indexOf("\\") != -1 || email.indexOf("\"") != -1 || email.indexOf("\'") != -1 || email.indexOf("=") != -1 || email.indexOf(" ") != -1)
                    alert("INVALID EMAIL:  Email must have NO ',\",\\,= and space");
                else if (psw.indexOf("'") != -1 || psw.indexOf('"') != -1 || psw.indexOf("\\") != -1 || psw.indexOf("\"") != -1 || psw.indexOf("\'") != -1 || psw.indexOf("=") != -1 || psw.indexOf(" ") != -1)
                    alert("Password must have NO ',\",\\,= and space");
                else {
                    // Ajax code to submit form.
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        cache: false,
                        success: function (result) {
                            result = result.trim();

                            if (result.substring(0,2) == "OK"){
                                fakeID = createFakeID(result.substring(2,result.length));
                                window.open(MAIN + '?id=' + fakeID, '_self');
                            }
                            else alert(result);
                        }
                    });

                    return true;

                }
                return false;
            });
        });
    </script>

</head>


<body>
    <form id="signinform" action="<?php echo SIGNIN; ?>" method="POST">
        <div class="container">
            <h1 class="txt" style="margin: 10px;">Sign In</h1>
            <h4 class="txt">Please fill username and password in this form to log in the system.</h4>
            <hr>
            <form>
                <label class="txt" for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" id="email" required>

                <label class="txt" for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" id="psw" name="psw" style="margin-bottom:15px"
                    required>

                <input type="checkbox" name="showpsw" onclick="myFunction()">
                Show Password
                </label><br />
                <hr>
                <input type="checkbox" name="remember"> Remember me
                </label>

                <h3>Student Management System - ABC University of Technology</h3>

                <div class="clearfix">
                    <button type="button" class="cancelbtn" onclick="validateCancel(this)">Cancel</button>
                    <button type="submit" class="signinbtn">Sign In</button>
                </div>
            </form>
        </div>
    </form>
    <!-- <div class="footer">
        <p>
            Student Management System
        <p>
        <p style="font-size: 15px;">
            ABC University of Technology
        </p>
        <p style="font-size: 15px;">
            Contact: steve@gmail.com
        </p>
    </div> -->
</body>

</html>