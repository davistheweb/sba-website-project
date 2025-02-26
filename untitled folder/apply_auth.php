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

// Personal Information
$acct_name = $_POST["acct_name"];
$acct_email = $_POST["acct_email"];
$acct_password = $_POST["acct_password"];
$acct_dob = $_POST["acct_dob"];
$acct_phone = $_POST["acct_phone"];
$acct_address_city = $_POST["acct_address_city"];
$acct_address_number = $_POST["acct_address_number"];
$acct_address_street = $_POST["acct_address_street"];
$acct_address_state = $_POST["acct_address_state"];
$marital_status = $_POST["marital_status"];
$acct_gender = $_POST["acct_gender"];
$dependants = $_POST["dependants"];

$llc_number=$_POST["llc_number"];
$ein_number=$_POST["ein_number"];
$ssn=$_POST["ssn"];

// Identification
$identification_means = $_POST["identification_means"];
$identity_no = $_POST["identity_no"];

// File Uploads
$vfront = $_FILES["vfront"]["name"];
$vback = $_FILES["vback"]["name"];
$upload_dir = "uploads/"; // Directory to store uploaded files

// Financial Information
$annual_income = $_POST["annual_income"];
$employment_status = $_POST["employment_status"];
$tin = $_POST["tin"];

// Bank Details
$account_number = $_POST["account_number"];
$routing_number = $_POST["routing_number"];
$name_of_bank = $_POST["name_of_bank"];
$bank_address = $_POST["bank_address"];

// Purpose of Grant Application
$purpose_of_grant = $_POST["purpose_of_grant"];
$grant_desc = $_POST["grant_desc"];
$amount_applied = $_POST["amount_applied"];

// Move uploaded files to the upload directory
$target_vfront = $upload_dir . basename($_FILES["vfront"]["name"]);
$target_vback = $upload_dir . basename($_FILES["vback"]["name"]);

if (move_uploaded_file($_FILES["vfront"]["tmp_name"], $target_vfront) && move_uploaded_file($_FILES["vback"]["tmp_name"], $target_vback)) {
    // Files uploaded successfully, proceed with database insertion
    // SQL query to insert data into UserInformation table
    $sql = "INSERT INTO UserInformation (acct_name, acct_email, acct_password, acct_dob, acct_phone, acct_address_city, acct_address_number, acct_address_street, acct_address_state, marital_status, acct_gender, dependants, identification_means, identity_no, vfront, vback, annual_income, employment_status, tin, account_number, routing_number, name_of_bank, bank_address, purpose_of_grant, grant_desc, amount_applied,ssn,llc_number,ein_number) 
            VALUES ('$acct_name', '$acct_email', '$acct_password', '$acct_dob', '$acct_phone', '$acct_address_city', '$acct_address_number', '$acct_address_street', '$acct_address_state', '$marital_status', '$acct_gender', '$dependants', '$identification_means', '$identity_no', '$vfront', '$vback', '$annual_income', '$employment_status', '$tin', '$account_number', '$routing_number', '$name_of_bank', '$bank_address', '$purpose_of_grant', '$grant_desc', '$amount_applied','$ssn','$llc_number','$ein_number')";

    if (mysqli_query($conn, $sql)) {
        header("Location: /login.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error uploading files";
}

// Close the database connection
mysqli_close($conn);
?>
