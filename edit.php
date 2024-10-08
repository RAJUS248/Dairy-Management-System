<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dry";
$fname = '';
$ph = '';
$f_vid = '';
$milk_type = '';
$min_litre = '';
$animalID = '';
$idupdate = '';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$showquery = "SELECT * FROM farmer WHERE id=$id";

$showdata = mysqli_query($conn, $showquery);

$arrdata = mysqli_fetch_array($showdata);

if (isset($_POST['updatefarmerdata'])) {
    $idupdate = $_GET['id'];
    $fname = $_POST['fname'];
    $ph = $_POST['ph'];
    $f_vid = $_POST['f_vid'];
    $milk_type = $_POST['milk_type'];
    $min_litre = $_POST['min_litre'];
    $animalID = $_POST['animalID'];

    // Update query with proper parameter binding
    $sql = "UPDATE farmer SET fname=?, ph=?, f_vid=?, milk_type=?, min_litre=?, animalID=? WHERE id=?";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param("ssisiss", $fname, $ph, $f_vid, $milk_type, $min_litre, $animalID, $idupdate);
    
    // Execute statement
    $res = $stmt->execute();

    if ($res) {
        header('Location: farmer.php');
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
    <title>Update</title>
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
        <h3><b><u>Update Customer Details</u></b> <a class="delete-icon" href="farmer.php"><i class="fas fa-arrow-circle-left"></i></a> </h3>
        <div class="container">
            <label for="fname">First Name <sup>*</sup> </label>
            <input type="text" name="fname" value="<?php echo $arrdata['fname']; ?>" placeholder="first name" size="5" required/>
            <br>
            <label for="ph">Phone number<sup>*</sup> </label>
            <input type="text" name="ph" value="<?php echo $arrdata['ph']; ?>" placeholder="Phone Number" maxlength="10" required/>
            <br>
            <label for="f_vid">Village ID<sup>*</sup> </label>
            <input type="number" name="f_vid" value="<?php echo $arrdata['f_vid']; ?>" placeholder="Village ID" maxlength="2" required/>
            <br>
            <label for="milk_type">Milk Type<sup>*</sup> </label>
            <input type="text" name="milk_type" value="<?php echo $arrdata['milk_type']; ?>" placeholder="cow or Buffalo" required/>
            <br>
            <label for="min_litre">Minimum Litre<sup>*</sup> </label>
            <input type="number" name="min_litre" value="<?php echo $arrdata['min_litre']; ?>" placeholder="/day" required/>
            <br>
            <label for="animalID">Animal Health ID<sup>*</sup> </label>
            <input type="text" name="animalID" value="<?php echo $arrdata['animalID']; ?>" placeholder="Issued by Health Ministry" maxlength="5" required/>
            <br>
            <input type="submit" name="updatefarmerdata" class="submit-btn-add" value="Update">
        </div>
    </form>
</body>

</html>
