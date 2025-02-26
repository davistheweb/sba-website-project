<?php
$servername = "sql202.infinityfree.com";
$username = "if0_37330629";
$password = "lvdwqnWnZjwU5";
$dbname = "if0_37330629_grants";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['id'])) {
    // Get the value of 'id' from the URL
    $id = $_GET['id'];

    $sql = "SELECT * FROM UserInformation WHERE id = $id";

    // Execute the query
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Fetch the result row
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close the database connection
// mysqli_close($conn);

} else {
    header("Location: AdminDashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    // $status_qoute = $_POST['status_qoute'];
    // $your_qoute = $_POST['your_qoute'];
    // $status = $_POST['status'];
    // $disbursement_fee = $_POST['disbursement_fee'];
    // $disbursement_fee_status = $_POST['disbursement_fee_status'];
    // $over_age_payement = $_POST['over_age_payement'];
    // $over_age_payement_status = $_POST['over_age_payement_status'];
    // $verify_identification = $_POST['verify_identification'];
    // $electronic_disbursement = $_POST['electronic_disbursement'];
    $status_qoute = $_POST['status_qoute'] ?? '$row["status_qoute"]';
$your_qoute = $_POST['your_qoute'] ?? '$row["your_qoute"]';
$status = $_POST['status'] ?? '$row["status"]';
$disbursement_fee = $_POST['disbursement_fee'] ?? '$row["disbursement_fee"]';
$disbursement_fee_status = $_POST['disbursement_fee_status'] ?? '$row["disbursement_fee_status"]';
$over_age_payement = $_POST['over_age_payement'] ?? '$row["over_age_payement"]';
$over_age_payement_status = $_POST['over_age_payement_status'] ?? '$row["over_age_payement_status"]';
$verify_identification = $_POST['verify_identification'] ?? '$row["verify_identification"]';
$electronic_disbursement = $_POST['electronic_disbursement'] ?? '$row["electronic_disbursement"]';

// Prepare the SQL statement
$sql = "UPDATE UserInformation 
        SET status_qoute = '$status_qoute', 
            your_qoute = '$your_qoute', 
            status = '$status', 
            disbursement_fee = '$disbursement_fee', 
            disbursement_fee_status = '$disbursement_fee_status', 
            over_age_payement = '$over_age_payement', 
            over_age_payement_status = '$over_age_payement_status',
            verify_identification='$verify_identification', 
            electronic_disbursement = '$electronic_disbursement'
        WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // $_SESSION['user'] = 
        echo "<h1>Profile updated sucessfully!</h1>";
        header("Location: AdminDashboard.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1><?php echo $row["acct_name"] ?></h1>
        <!-- Form -->
        <form action="" method="POST">
                                <div class="row">
                                    <div class="col-lg-12">
                                    <h4>Applications:</h4>   
                                </div>
                                <div class="col-lg-12">
                                       <div class="single-form">
                                            <label>Status: <b><?php echo $row["status_qoute"] ?></b> </label>
                                            <select name="status_qoute" class="form-control">
                                                <!-- <option></option> -->
                                                <option value="amount_not_confirmed">Amount Not Confirmed</option>
                                            <option value="amount_confirmed">Amount Confirmed</option>
                                            <!-- <option value="approved">Approved</option> -->
                                            </select>
                                       </div>
                                    </div>
                                    <div class="col-lg-12">
                                       <div class="single-form">
                                            <label>Your qoute: </label>
                                            <input value="<?php echo $row["your_qoute"]; ?>" type="text" name="your_qoute" class="form-control" placeholder="Your qoute">
                                       </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="single-form">
                                            <label>Status: <b><?php echo $row["status"] ?></b></label>
                                            <!-- <input type="email" name="acct_email"  class="form-control" placeholder="Enter Email" required> -->
                                            <select class="form-control" name="status">
                                            <option value="is Pending">is Pending</option>
                                            <option value="is Rejected">is Rejected</option>
                                                <option value="is Approved">is Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    </div>

                                    <div class="row">
                                    <div class="col-lg-12">
                                    <h4>Disbursement:</h4>    
                                </div>
                                    <div class="col-lg-12">
                                       <div class="single-form">
                                            <label>Advance Type: (Disbursement fee)</label>
                                            <input value="<?php echo $row["disbursement_fee"]; ?>" type="text" name="disbursement_fee" class="form-control" placeholder="Disbursement fee">
                                       </div>

                                    </div>
                                    <div class="col-lg-6">
                                       <div class="single-form">
                                            <label>Status: <b><?php echo $row["disbursement_fee_status"] ?></b></label>
                                            <!-- <input type="email" name="acct_email"  class="form-control" placeholder="Enter Email" required> -->
                                            <select class="form-control" name="disbursement_fee_status">
                                            <option value="pending">Pending</option>
                                            <option value="not confirmed">Not Confirmed</option>
                                                <option value="confirmed">Confirmed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="single-form">
                                            <label>Advance Type: (Over Age Payement)</label>
                                            <input value="<?php echo $row["over_age_payement"]; ?>" type="text" name="over_age_payement"  class="form-control" placeholder="Over Age Payement" required>
                                            <!-- <a href="#">Approved</a> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                       <div class="single-form">
                                            <label>Status: <b><?php echo $row["over_age_payement_status"] ?></b></label>
                                            <!-- <input type="email" name="acct_email"  class="form-control" placeholder="Enter Email" required> -->
                                            <select class="form-control" name="over_age_payement_status">
                                            <option value="pending">Pending</option>
                                            <option value="not confirmed">Not Confirmed</option>
                                                <option value="confirmed">Confirmed</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    </div>

                                    <div class="row">
                                    <div class="col-lg-12">
                                    <h4>Steps To complete:</h4>   
                                </div>
                                <div class="col-lg-12">
                                       <div class="single-form">
                                            <label>Verify Identification: <b><?php echo $row["verify_identification"] ?></b></label>
                                            <select class="form-control" name="verify_identification">
                                                <option value="pending">Pending</option>
                                            <option value="failed">Failed</option>
                                            <option value="verified">Verified</option>
                                            </select>
                                       </div>
</div>
                                    <div class="col-lg-6">
                                       <div class="single-form">
                                            <label>Electronic Disbursement: <b><?php echo $row["electronic_disbursement"] ?></label>
                                            <!-- <input type="email" name="acct_email"  class="form-control" placeholder="Enter Email" required> -->
                                            <select class="form-control" name="electronic_disbursement">
                                            <option value="pending">Pending</option>
                                            <option value="failed">Failed</option>
                                            <option value="completed">completed</option>
                                            
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <!-- <div class="signle-form">
                                            <select class="form-control">
                                                <option value="Submit">Submit</option>
                                                <option value="Re Submit">Re Submit</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    
                                    </div>

                                    
           <button class="btn btn-success mt-4" type="submit">Edit</button>
        </form>
        <hr>
        <h1>Document</h1>
        <div class="d-flex justify-content-between flex-column w-100">
            <p>Front:</p>
        <?php
          if (isset($row['vfront'])) {
              echo '<img src="http://sbaorg.42web.io/uploads/' . htmlspecialchars($row['vfront']) . '" alt="Document">';
          } else {
            echo 'Image not found.';
          }
        ?>
        <br>
        <br>
        <p>Back:</p>
        <?php
          if (isset($row['vback'])) {
              echo '<img src="http://sbaorg.42web.io/uploads/' . htmlspecialchars($row['vback']) . '" alt="Document">';
          } else {
            echo 'Image not found.';
          }
        ?>
        </div>
    </div>
</body>
</html>