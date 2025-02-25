<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="container">
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

$sql = "SELECT * FROM UserInformation";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class=\"table table-bordered\">
    <thead>
    <tr>
      <th scope=\"col\">#</th>
      <th scope=\"col\">Name</th>
      <th scope=\"col\">Email</th>
      <th scope=\"col\">Action</th>
    </tr>
  </thead>";

    while($row = $result->fetch_assoc()) {
      $id = $row["id"];
      echo "<tbody><tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["acct_name"] . "</td>";
        echo "<td>" . $row["acct_email"] . "</td>";
        echo "<td><a href='/edit.php?id=$id' class='text-warning'>Edit</a></td>";
        echo "</tr></tbody>";
        // echo "ID: " . $row["id"]. " - Name: " . $row["full_name"]. " - Email: " . $row["email"]. "<br>";
    }
    echo "</table>";
} else {
    echo "<h1>No user found!</h1>";
}

// Close connection
$conn->close();
?>

</body>
</html>
