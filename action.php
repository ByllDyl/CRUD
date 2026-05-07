<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Add User
    if (isset($_POST['add_user'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
        $gender = mysqli_real_escape_string($conn, $_POST['Gender']);
        $voter = mysqli_real_escape_string($conn, $_POST['Voter']);
        
        $query = "INSERT INTO residents (first_name, last_name, gender, voter) VALUES ('$fname', '$lname', '$gender', '$voter')";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }

    // Edit User
    if (isset($_POST['edit_user'])) {
        $id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
        $gender = mysqli_real_escape_string($conn, $_POST['Gender']);
        $voter = mysqli_real_escape_string($conn, $_POST['Voter']);
        
        $query = "UPDATE residents SET first_name='$fname', last_name='$lname', gender='$gender', voter='$voter' WHERE id='$id'";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }

    // Delete User
    if (isset($_POST['delete_id'])) {
        $id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        
        $query = "DELETE FROM residents WHERE id='$id'";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }
}
?>
