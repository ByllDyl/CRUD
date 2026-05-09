<?php
session_start();
include "config.php";

// Check if the form was submitted
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM barangay_users WHERE email = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['full_name'];
        $_SESSION['role'] = $row['role'];
        if ($row['role'] == 'admin') {
            header("Location: choose.php");
            exit();
        } else {
            header("Location: portal.php");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }
}

if (isset($_POST['register'])) {

    $full_name = $_POST['first_name'] . ' ' . $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO barangay_users (full_name, email, password) VALUES ('$full_name', '$email', '$password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['username'] = $full_name;
        header("Location: portal.php");
    } else {
        echo "Error registering user";
    }
}
