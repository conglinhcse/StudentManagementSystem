<!DOCTYPE html>
<html lang="vi">

<head>

    <link rel="stylesheet" type="text/css" href="signup.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css"
        rel="stylesheet" type="text/html" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://localhost:8080/index/const/const.js"></script>


    <title>Signup Form</title>

    <?php require '../const/const.php'; ?>

    <script>
        function validateCancel(form) {

            if (confirm('Do you really want to cancel sign up')) {
                window.open(WELCOME, '_self');
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#signupform").on('submit', function (e) {
                e.preventDefault();

                var url = $(this).closest('form').attr('action'),
                    data = $(this).closest('form').serialize();

                var email = $("#email").val();
                var psw = $("#psw").val();
                var pswrepeat = $("#pswrepeat").val();

                email = email.trim();
                psw = psw.trim();
                pswrepeat = pswrepeat.trim();

                if (email.substring(email.length - 11) != "@abc.edu.vn") {
                    alert("Email must finish with @abc.edu.vn");
                }
                else if (email.indexOf("'") != -1 || email.indexOf('"') != -1 || email.indexOf("\\") != -1 || email.indexOf("\"") != -1 || email.indexOf("\'") != -1 || email.indexOf("=") != -1 || email.indexOf(" ") != -1)
                    alert("INVALID EMAIL:  Email must have NO ',\",\\,= and space");

                else if (!EMAILFORMAT.test(email.toLowerCase()))
                    alert("Email format is incorrect. Please enter again!");

                else if (psw.indexOf("'") != -1 || psw.indexOf('"') != -1 || psw.indexOf("\\") != -1 || psw.indexOf("\"") != -1 || psw.indexOf("\'") != -1 || psw.indexOf("=") != -1 || psw.indexOf(" ") != -1)
                    alert("Password must have NO ',\",\\,= and space");
                else if (psw != pswrepeat) {
                    alert("Sorry, passwords do not match");
                }
                else {
                    // Ajax code to submit form.
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        cache: false,
                        success: function (result) {
                            result = result.trim();

                            alert(result);

                            if (result == "Sign Up Successfully!") {
                                window.open(SIGNINITEM, '_self');
                            }


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
    <form id="signupform" action="<?php echo SIGNUP ?>" method="POST">
        <div class="container">
            <h1 style="margin: 10px;" class="txt">Sign Up</h1>
            <h4 class="txt">Please fill in this form to create an account.</h4>
            <hr>

            <label class="txt" for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label class="txt" for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

            <label class="txt" for="psw-repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="pswrepeat" id="pswrepeat" required>
            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
            </label>

            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

            <div class="clearfix">
                <button type="button" class="cancelbtn" onclick="validateCancel(this)">Cancel</button>

                <button type="submit" class="signupbtn">Sign Up</button>

            </div>
        </div>
    </form>

    <div class="footer">
        <p>
            Student Management System
        <p>
        <p style="font-size: 15px;">
            ABC University of Technology
        </p>
        <p style="font-size: 15px;">
            Contact: steve@gmail.com
        </p>
    </div>
</body>

</html>



<!-- Cacel Warning -->
<!-- <div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
    <form class="modal-content" action="/action_page.php">
        <div class="container">
            <h1> Cancel </h1>
            <p>Are you sure you want to cancel?</p>

            <div class="clearfix">
                <button type="button" onclick="window.location.
                href='file:///home/conglinh/Desktop/index/welcome/welcome.html'" class="yesbtn">Yes</button>
                <button type="button" onclick="document.getElementById('id01').style.display='none'"
                    class="nobtn">No</button>
            </div>
        </div>
    </form>
</div>
<script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script> -->
<!--End  Modal -->