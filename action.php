<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['add_resident'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
        $gender = mysqli_real_escape_string($conn, $_POST['Gender']);
        $voter = mysqli_real_escape_string($conn, $_POST['Voter']);
        
        $query = "INSERT INTO residents (first_name, last_name, gender, voter) VALUES ('$fname', '$lname', '$gender', '$voter')";
        mysqli_query($conn, $query);
        header("Location: ../residents.php");
        exit();
    }

    if (isset($_POST['delete_id'])) {
        $id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        
        $query = "DELETE FROM residents WHERE id='$id'";
        mysqli_query($conn, $query);
        header("Location: index.php");
        exit();
    }
}
?>
