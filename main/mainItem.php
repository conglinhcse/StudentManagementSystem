<!DOCTYPE html>
<html lang="vi">

    <head>

        <link rel="stylesheet" type="text/css" href="main.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
        <script type="text/javascript" src="http://localhost:8080/index/const/const.js"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=33%">

        <title>Main Form</title>

        <script type="text/javascript">
        $(document).ready(function () {
            $("#adminform").on('click','#editbtn', function (e) {
                var realAdminID = document.getElementById("aid").value;
                var fakeAdminID = createFakeID(realAdminID);
                var adminid =  '<?php 
                    $adminid = '';
                    if (!empty($_GET['id'])) {
                        $adminid = $_GET['id'];
                    }
                    echo $adminid ?>';
                link = EDITADMINITEM + "?ids=" + fakeAdminID + "&aid=" + adminid;
                window.open(link, '_blank');
                });
            });
        </script>
        

        <script>
            function logoutFunc(){
                if(confirm("Do you want to log out of system?")){
                    location.replace(WELCOME);
                }
            }
        </script>

        <script>
            /* When the user clicks on the button,
            toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            function filterFunction() {
                var input, filter, ul, li, a, i;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                div = document.getElementById("myDropdown");
                a = div.getElementsByTagName("a");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    } else {
                        a[i].style.display = "none";
                    }
                }
            }
        </script>

        <script>
            function myFunctionLightMode() {
                var element = document.body;
                element.classList.toggle("light-mode");
            }
        </script>

        <script>
            function myFunction(x) {
            alert("Row index is: " + x.rowIndex);
            }
        </script>

        <script>
            var ids = '';  
            $(document).ready(function(){             
            // code to read selected table row cell data (values).
            $("#myTable").on('click','#editbtn',function(){
                // get the current row
                var chosenRow=$(this).closest("tr");             
                ids=chosenRow.find("td:eq(0)").text(); // get current row 1st TD value 
                editItem(ids);
                });
            });
            
        </script>

        <script>
            function editItem(realID){
                fakeID = createFakeID(realID);
                var adminid =  '<?php 
                $adminid = '';
                if (!empty($_GET['id'])) {
                    $adminid = $_GET['id'];
                }
                echo $adminid ?>';
                link = EDITITEM + "?ids=" + fakeID + "&aid=" + adminid;
                window.open(link);
            }
        </script>

        <script>
            function createFakeID(realID){
                //Self-defined Charset
                var possible = "ABCDEFGHIJ0123456789KLMNOPQRSTU0123456789VWXYZabcdefgh0123456789KLMNOPQRSTU0123456789Vijklmnopqrstuvwxyz";
                var text = "";

                //Take current minute
                var today = new Date();
                var mins = parseInt(today.getMinutes());
                var secs = parseInt(today.getSeconds());

                //Padding time 
                if(secs >= 55) mins = (mins + 1)%60;

                //minute plus ID to hide real ID
                fakeID = mins + parseInt(realID);

                //Create an string with 80 chars, and hide fake ID based on minus
                for (var i = 0; i <= 79;){
                    if(i==mins)
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

        <script>
            var ids = '';
            $(document).ready(function(){
                
            // code to read selected table row cell data (values).
            $("#myTable").on('click','#deletebtn',function(){
                // get the current row
                var chosenRow=$(this).closest("tr"); 
            
                ids=chosenRow.find("td:eq(0)").text(); // get current row 1st TD value   

                if(confirm("Do you really want to delete student with ID: " + ids + " ?")) {
                
                    $.ajax({
                            url : "deleteItem.php",
                            type : "POST",
                            dataType:"text",
                            data : {
                                ids : ids
                            },
                            success : function (result){
                                alert(result);
                                location.reload();
                            }
                        });
                }
            
                });
            });
            
        </script>
    

    </head>

    <body>

        <?php
        require_once '../connect/connect.php';
        require_once '../connect/disconnect.php';
        require '../const/const.php';

        $connect = connect();
        // Kết nối database student
        ?>

        <div class="header">
            <div class="row">
                <form id="adminform" name="adminform">
                    <div class="column">
                        <div class="card">

                            <?php 
                                $adminid = '';
                                if (!empty($_GET['id'])) {
                                    $adminid = $_GET['id'];
                                }

                                $date = getdate();
                                $sec = (int)$date['seconds'];
                                $hour = (int)$date['hours'] + 1;

                                // Padding time
                                if ($sec > 58) $hour += 1;

                                /////////////////////////////////
                                $hour += 5;
                                /////////////////////////////////
                                
                                //Lay chieu dai cua fakeID tu index 79 den het chuoi
                                $leng = substr($adminid, 79, strlen($adminid)-79);

                                // Tach fakeID trong chuoi
                                $fakeID = substr($adminid, $hour, (int)$leng);

                                // Tinh toan ra realID 
                                //Filter real ID from fake ids
                                $realID = floor((int)$fakeID / $hour);

                                if ($realID == '')
                                    echo "<script> location.replace(FORBIDDEN); </script>" ;

                                $sql = "SELECT * FROM AdminLogin WHERE adminid = '$realID';";
                                $result = $connect->query($sql);
                                $row = $result->fetch_assoc();

                                if ($row == ''){
                                    echo "<script> location.replace(FORBIDDEN); </script>" ;
                                }
                            ?>

                            <img class="avatar" id="adminavatar" name="adminavatar" src="<?php echo $row['adminavatar']; ?>" alt="AdminAvatar">
                            <h1 id="adminname" name="adminname"> <?php echo $row['adminname']; ?> </h1>
                            <p class="title" id="adminposition" name="adminposition"> <?php echo $row['adminposition']; ?> </p>
                            <p style="margin: 2px;" id="adminid" name="adminid" value ="<?php echo $row['adminid']; ?>" > <?php echo $row['adminid']; ?> </p>
                            <div style="margin: 5px 0px;">
                                <a href="#"><i class="fa fa-envelope"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            <p style="margin: 2px 0px;" id="adminphone" name="adminphone">Phone: <span> <?php echo $row['adminphone']; ?> </span></p>
                            <input type="text" id="aid" name="aid" style="display:none;" value="<?php echo $row['adminid']; ?>" >
                            <p style="margin: 2px 0px;" id="adminemail" name="adminemail">Email: <span> <?php echo $row['username']; ?> </span></p>

                                <button class="editbtn" type="button" id="editbtn">Edit</button>
                            
                        </div>
                    </div>
                </form>
                <div class="column">
                    
                    <button class="logoutbtn" onclick="logoutFunc()"><strong>Log out</strong></button>

                    <p class="biguniinfo"><strong>Student Management</strong></p>
                    <p class="smluniinfo"><strong>ABC University of Technology</strong></p>

                </div>
            </div>
        </div>

        <hr style="margin: 10px 0px;">

        <form method="POST">
            <div class="navrow">
                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Name</label> -->
                        <i class="fa fa-id-card-o" style="width: auto;margin-left: 2px; color: aliceblue;"></i>
                        <input class="navsearch" type="text" name="full_name" placeholder="Name" maxlength="50">
                    </div>
                </div>


                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Falcuty</label> -->
                        <i class="fa fa-mortar-board" style="width: auto;margin-left: 2px;color: aliceblue;"></i>
                        <input class="navsearch" type="text" list="browsers" name="faculty" id="browsers1"
                            placeholder="Faculty">
                        <datalist id="browsers">
                            <option value="<?php echo EEE ?>"></option>
                            <option value="<?php echo CSE ?>"></option>
                            <option value="<?php echo APS ?>"></option>
                            <option value="<?php echo MAT ?>"></option>
                            <option value="<?php echo CIE ?>"></option>
                            <option value="<?php echo CHE ?>"></option>
                        </datalist>
                    </div>
                </div>


                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Class</label> -->
                        <i class="fa fa-institution" style="width: auto;margin-left: 2px;color: aliceblue;"></i>
                        <input class="navsearch" type="text" list="browserss" name="class_name" id="browsers2" placeholder="Class">
                        <datalist id="browserss">
                        <option value="<?php echo PH ?>" > <?php echo PH ?> </option>
                            <option value="<?php echo LA ?>" ></option>
                            <option value="<?php echo MT ?>" ></option>
                            <option value="<?php echo CO ?>" ></option>
                            <option value="<?php echo CE ?>" ></option>
                            <option value="<?php echo ASS ?>" ></option>
                            <option value="<?php echo CH ?>" ></option>
                            <option value="<?php echo ME ?>" ></option>
                            <option value="<?php echo EE ?>" ></option>
                            <option value="<?php echo SP ?>" ></option>
                        </datalist>
                    </div>
                </div>

            <div class="navrow">
                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Email</label> -->
                        <i class="fa fa-envelope" style="width: auto;margin-left: 2px;color: aliceblue;"></i>
                        <input class="navsearch" type="email" name="email" size="30" maxlength="50"
                            placeholder="Email">
                    </div>
                </div>


                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Phone</label> -->
                        <i class="fa fa-phone" style="width: auto;margin-left: 2px;color: aliceblue;"></i>
                        <input class="navsearch" type="tel" value="" name="phone_number" size="30" placeholder="Phone" maxlength="10"> 
                    </div>
                </div>


                <div class="navcolumn">
                    <div class="navcontainer">
                        <!-- <label class="txt">Birthday</label> -->
                        <i class="fa fa-birthday-cake" style="width: auto;margin-left: 2px;color: aliceblue;"></i>
                        <input class="navsearch" type="date" id="birthday" name="birthday" style="padding: 8px;">
                    </div>
                </div>
            </div>


            <div class="formsearch">
                <button class="searchbutton" type="submit" ><i class="fa fa-search"> Search
                    </i></button>
            </div>
        </form>



        <div class="main">
            <table id="myTable" style="width:100%">
                <caption class="bigcaption"><strong>Student Information</strong>
                </caption>
                <tr>
                    <th>ID</th>
                    <th>FullName</th>
                    <th>Gender</th>
                    <th>Birthday</th>
                    <th>Falcuty</th>
                    <th>Class</th>
                    <th>PhoneNumber</th>
                    <th>Email</th>
                    <th colspan="2">Modification</th>
                </tr>

                <?php 
                
                $full_name = "";
                
                $birthday = "";
                
                $faculty = "";
                
                $class_name = "";
                
                $phone_number = "";
                
                $email = "";
        
                $sql = "";
                $condition = "";
        
                if ($_SERVER["REQUEST_METHOD"] == "POST"){
                
                    if (!empty($_POST['full_name'])) {
                        $full_name = $_POST['full_name'];
                        $condition.= "full_name LIKE '%$full_name%'";
                    }
                    
                    if (!empty($_POST['faculty'])) {
                        $faculty = $_POST['faculty'];
                        if ($condition != "")
                            $condition.= " AND ";    
                        $condition.= "faculty LIKE '%$faculty%'";
                    }
                
                    if (!empty($_POST['class_name'])) {
                        $class_name = $_POST['class_name'];
                        if ($condition != "")
                            $condition.= " AND ";    
                        $condition.= "class_name LIKE '%$class_name%'";
                    }
        
                    if (!empty($_POST['email'])) {
                        $email = $_POST['email'];

                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            if ($condition != "")
                                $condition.= " AND ";    
                            $condition.= "email LIKE '%$email%'";
                        }
                    }
                
                    if (!empty($_POST['phone_number'])) {
                        $phone_number = $_POST['phone_number'];
                        if ($condition != "")
                            $condition.= " AND ";    
                        $condition.= "phone_number LIKE '%$phone_number%'";
                    }
        
                    if (!empty($_POST['birthday'])) {
                        $birthday = $_POST['birthday'];
                        $birthday = str_replace('/', '-', $birthday);
                        $birthday = date('Y-m-d', strtotime($birthday));
                        if ($condition != "")
                            $condition.= " AND ";    
                        $condition.= "birthday='$birthday'";
                    }
                
                    
                }
        
                    $sql     = "SELECT ids, full_name, sex, birthday, faculty, class_name, phone_number, email FROM stdmgn.Student";
                    if ($condition != ""){               
                        $sql .= " WHERE ";
                        $sql .= $condition;
                    }
                    $sql .= ";";
        
                $result = $connect->query($sql);
                // var_dump($result);

                if (!$result || $result->num_rows == 0) 
                    echo "<script type='text/javascript'>alert('NOT FOUND! Please enter another key!');</script>";
                else
                {
                    while ($row = $result->fetch_assoc()) {
                        

                ?>

                <!-- <tr onclick="myFunction(this)"> -->
                <tr>
                    <td id='idrow'> <?php echo $row['ids']; ?> </td>
                    <td> <?php echo $row['full_name']; ?> </td>
                    <td> <?php echo $row['sex'] ?> </td>
                    <td> <?php echo $row['birthday']; ?> </td>
                    <td> <?php echo $row['faculty']; ?> </td>
                    <td> <?php echo $row['class_name']; ?> </td>
                    <td> <?php echo $row['phone_number']; ?> </td>
                    <td> <?php echo $row['email']; ?> </td>
                    <td>
                        <form>
                            <button id="editbtn" type="button" value="Edit" class="submit" >
                                <i class="fa fa-edit"></i>
                            </button>
                        </form>

                    </td>
                    <td>
                     <form>
                        <button id="deletebtn" type="button" value="Delete"
                            class="submit"><i class="fa fa-close"></i>

                        </button>
                    </form>
 
                </td>
                </tr>
                <?php } }?>
            </table>
        </div>


        <?php
        //Đóng kết nối database stdmgn
        disconnect($connect);
        ?>

        <div style="margin-top: 30px;">
            <form action="<?php echo CREATEITEM; ?>" target="_blank">
                <button class="create">Create New</button>
            </form>
        </div>

        <div class="footer">
            <p>
                Student Management System
            <p>
            <p style="font-size: 15px;">
                Contact: steve@gmail.com
            </p>
            <p style="font-size: 15px;">
                Phone: 0123456789
            </p>
        </div>

    </body>

</html>