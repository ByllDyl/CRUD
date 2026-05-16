<?php
session_start();
require_once 'config.php';

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
            $_SESSION['just_logged_in'] = true;
            header("Location: choose.php");
            exit();
        } else {
            $_SESSION['just_logged_in'] = true;
            header("Location: portal.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password";
        $_SESSION["active_form"] = "login";
        header("Location: login.php");
        exit();
    }
}

if (isset($_POST['register'])) {

    $full_name = $_POST['first_name'] . ' ' . $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "INSERT INTO barangay_users (full_name, email, password, role) VALUES ('$full_name', '$email', '$password', 'user')";
    $result = mysqli_query($conn, $query);

    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $middle_name = $_POST['middle_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $contact = $_POST['contact'];
    $purok = $_POST['purok'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $full_name = $first_name . " " . $last_name;

    $query = "INSERT INTO `residents` (`id`, `first_name`, `last_name`, `middle_name`, `date_of_birth`, `gender`, `civil_status`, `purok_no`, `contact`, `address`, `occupation`, `voter`) 
              VALUES (NULL, '$first_name', '$last_name', '$middle_name', '$dob', '$gender', '$civil_status', '$purok', '$contact', '$address', 'Ninja', 'No');";


    if ($result) {
        $_SESSION['username'] = $full_name;
        $_SESSION['just_logged_in'] = true;
        header("Location: portal.php");
    } else {
        echo "Error registering user";
    }
}
