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

// Capture form data
$invoice_number = $_POST['invoice_number'];
$order_id = $_POST['order_id'];
$amount = $_POST['amount'];
$billed_to = $_POST['billed_to'];
$due_date = $_POST['due_date'];
$user_id = $_POST['user_id'];

$sql = "INSERT INTO invoices (invoice_number, order_id, amount, billed_to, due_date, status, user_id) 
        VALUES ('$invoice_number', '$order_id', '$amount', '$billed_to', '$due_date', 'pending', '$user_id')";

if ($conn->query($sql)) {
    header("Location: dashboard.php?success=Invoice Created");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>