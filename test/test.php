<!-- ################################################################################################################################################################## -->
<!-- <!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="test.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
</div>

<body>

  <h2>Three Equal Columns</h2>

  <div class="navrow">

    <div class="navcolumn">
      <div class="navcontainer">
        <i class="fa fa-id-card-o" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="text" name="name" placeholder="Name">
      </div>
    </div>


    <div class="navcolumn">
      <div class="navcontainer">

        <i class="fa fa-mortar-board" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="text" list="browsers" name="faculty" id="browsers1" placeholder="Faculty">
        <datalist id="browsers">
          <option value="Electrical & Electronics Engineering">
          <option value="Apllied Sci">
          <option value="Materials Technology">
          <option value="Civil Engineering">
          <option value="Chemical Engineering">
        </datalist>
      </div>
    </div>


    <div class="navcolumn">
      <div class="navcontainer">

        <i class="fa fa-institution" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="text" list="browserss" name="class" id="browsers2" placeholder="Class">
        <datalist id="browserss">
          <option value="MT17KH02">
          <option value="CO3029">
          <option value="CE1705">
          <option value="AS1708">
        </datalist>
      </div>
    </div>
  </div>

  <div class="navrow">

    <div class="navcolumn">
      <div class="navcontainer">

        <i class="fa fa-envelope" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="email" value="@hcmut.edu.vn" name="email" size="30" placeholder="Email">
      </div>
    </div>


    <div class="navcolumn">
      <div class="navcontainer">

        <i class="fa fa-phone" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="tel" value="" name="phone" size="30" placeholder="Phone">
      </div>
    </div>


    <div class="navcolumn">
      <div class="navcontainer">

        <i class="fa fa-birthday-cake" style="width: auto;margin-left: 2px;"></i>
        <input class="search" type="date" id="grayear" name="grayear" style="padding: 8px;">
      </div>
    </div>
  </div>

  <form class="formsearch" action="https://www.apple.com/">
    <button class="searchbutton" type="submit"><i class="fa fa-search"> Search
      </i></button>
  </form>

</body>

</html> -->

<!-- ################################################################################################################################################################## -->

<!-- 
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap 4 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

  <div class="container">
    <h1>My First Bootstrap Page</h1>
    <p>This is some text.</p>
  </div>

</body>

</html> -->

<!DOCTYPE html>
<html>

<head>
  <title>Table with database</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      color: #588c7e;
      font-family: monospace;
      font-size: 25px;
      text-align: left;
    }

    th {
      background-color: #588c7e;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2
    }
  </style>
</head>

<body>
  <table>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Password</th>
    </tr>
    <?php
$username = "user_std"; // Khai báo username

$password = "a123";      // Khai báo password

$server   = "localhost";   // Khai báo server

$dbname   = "stdmgn";

$conn = mysqli_connect($server, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT ids, full_name, faculty FROM Student";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr><td>" . $row["ids"]. "</td><td>" . $row["full_name"] . "</td><td>"
. $row["faculty"]. "</td></tr>";
}
echo "</table>";
} else { echo "0 results"; }
$conn->close();
?>
  </table>
</body>

</html>