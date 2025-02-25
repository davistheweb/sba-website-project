<?php
session_start();
$servername = "sql202.infinityfree.com";
$username = "if0_37330629";
$password = "lvdwqnWnZjwU5";
$dbname = "if0_37330629_grants";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get invoice ID
$invoice_id = $_POST['invoice_id'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["payment_proof"]["name"]);
move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $target_file);

$sql = "INSERT INTO payments (invoice_id, payment_proof, status) VALUES ('$invoice_id', '$target_file', 'pending')";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php?success=Payment Submitted");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>