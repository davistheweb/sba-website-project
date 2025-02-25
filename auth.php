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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare a SQL statement using a prepared statement
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Authentication successful
            $_SESSION['email'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            // Authentication failed
            $error = "Incorrect email address or password. Please check and try again.";
        }

        $stmt->close();
    } else {
        // Handle missing form fields
        $error = "Email and password fields are required.";
    }
}

// Close connection
$conn->close();
?>
