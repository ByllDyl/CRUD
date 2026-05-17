<?php
session_start();
include "config.php";

if (isset($_POST['submit_blotter'])) {
    $incident_type      = $_POST['incident_type'];
    $narrative          = $_POST['narrative'];
    $name               = $_SESSION['username'];
    $person_involved    = $_POST['persons_involved'];
    $incident_location  = $_POST['incident_location'];
    $incident_date      = $_POST['incident_date'];

    $sql = "INSERT INTO blotter_records (complainant, respondent, incident_type, incident_narrative, incident_date, location) 
                VALUES ('$name', '$person_involved', '$incident_type', '$narrative', '$incident_date', '$incident_location')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: portal.php?success=blotter");
        exit();
    } else {
        die("Blotter report could not be submitted. Error: " . mysqli_error($conn));
    }
} 

if (isset($_POST['submit_cert'])) {
    $cert_type          = $_POST['cert_type'];
    $purpose            = $_POST['purpose'];
    $delivery           = $_POST['delivery'];
    $name               = $_SESSION['username'];

    $sql = "INSERT INTO `certificates` (`id`, `resident_name`, `certificate_type`, `purpose`, `or_number`, `date_issued`, `delivery_methods`) 
            VALUES (NULL, '$name', '$cert_type', '$purpose', NULL, NOW(), '$delivery')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        header("Location: portal.php?success=certificate");
        exit();
    } else {
        die("Certificate request could not be submitted. Error: " . mysqli_error($conn));
    }
}
