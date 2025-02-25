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

$payment_id = $_POST['payment_id'];
$action = $_POST['action']; // 'verified' or 'rejected'

$sql = "UPDATE payments SET status='$action' WHERE id='$payment_id'";
$conn->query($sql);

// If payment is verified, update invoice status
if ($action === 'verified') {
    $sqlInvoice = "UPDATE invoices SET status='paid' WHERE id IN (SELECT invoice_id FROM payments WHERE id='$payment_id')";
    $conn->query($sqlInvoice);
}

header("Location: dashboard.php?success=Payment Updated");
$conn->close();
?>