<?php

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $statement = $conn->prepare("SELECT AccountID, AdminPassword FROM administrator WHERE AdminUsername = ?");
    $statement->bind_param('s', $username);

    $statement->execute();
    $statement->store_result();

    if($statement->num_rows > 0) {
        $statement->bind_result($accountID, $adminPassword);
        $statement->fetch();


        if ($password === $adminPassword) {
            $_SESSION['username'] = $username;
            $_SESSION['accountID'] = $accountID;

            header("Location: home.php");
        } else {
            echo "Please Check Password";
        }
    } else {
        echo "Please check username or password";
    }

}

$statement->close();
$conn->close();