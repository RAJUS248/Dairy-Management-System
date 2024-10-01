<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dry";
$ename = "";
$phno = "";
$address = "";
$salary = "";
$designation = "";
$idupdate = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['eid'];

$showquery = "SELECT * FROM employee WHERE eid=$id";

$showdata = mysqli_query($conn, $showquery);

$arrdata = mysqli_fetch_array($showdata);

if (isset($_POST['updatestaffdata'])) {
    $idupdate = $_GET['eid'];
    $ename = $_POST['fname'];
    $phno = $_POST['phonenumber'];
    $salary = $_POST['salary'];
    $designation = $_POST['Designation'];
    $address = $_POST['staffaddress'];

    // Update query with proper parameter binding
    $sql = "UPDATE employee SET ename=?, phno=?, address=?, salary=?, designation=? WHERE eid=?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("sssssi", $ename, $phno, $address, $salary, $designation, $idupdate);
    
    // Execute statement
    $res = $stmt->execute();

    if ($res) {
        header('Location: staff.php');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Update Staff</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/farmer.css">
    <style media="screen">
        .delete-icon {
            position: absolute;
            padding: 4px 5px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 50px;
        }

        .delete-icon:hover {
            transform: scale(1.2);
            opacity: 0.8;
        }

        u {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <form class="modal-content animate" action="" method="POST">
        <h3><b><u> Update Staff details</u></b> <a class="delete-icon" href="staff.php"><i class="fas fa-arrow-circle-left"></i></a></h3>
        <div class="container">
            <label for="fname">First Name <sup>*</sup> </label>
            <input type="text" name="fname" value="<?php echo $arrdata['ename']; ?>" placeholder="first name" required/>
            <br>
            <label for="phonenumber">Phone number<sup>*</sup> </label>
            <input type="text" name="phonenumber" value="<?php echo $arrdata['phno']; ?>" placeholder="Phone Number" required/>
            <br>
            <label for="staffaddress">Address<sup>*</sup> </label>
            <input type="text" name="staffaddress" value="<?php echo $arrdata['address']; ?>" placeholder="address" required/>
            <br>
            <label for="salary">Salary<sup>*</sup> </label>
            <input type="text" name="salary" value="<?php echo $arrdata['salary']; ?>" placeholder="salary" required/>
            <br>
            <label for="Designation">Designation<sup>*</sup> </label>
            <input type="text" name="Designation" value="<?php echo $arrdata['designation']; ?>" placeholder="Designation" required/>
            <br>

            <input type="submit" name="updatestaffdata" class="submit-btn-add" value="Update">
        </div>
    </form>
</body>

</html>
