<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $valid_email = "admin";
    $valid_password = "123";

    // Get the form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate the user credentials
    if ($email === $valid_email && $password === $valid_password) {
        header("Location: /AdminDashboard.php");
        exit;
    } else {
        // Invalid credentials
        echo "Incorrect username or password. Please try again.";
    }
}
?>


