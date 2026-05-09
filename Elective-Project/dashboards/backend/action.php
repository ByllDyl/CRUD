<?php

include "../../database/config.php";

if (isset($_POST['add_resident'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
    $mname = mysqli_real_escape_string($conn, $_POST['middleName']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $civilStatus = mysqli_real_escape_string($conn, $_POST['civilStatus']);
    $purok = mysqli_real_escape_string($conn, $_POST['purok']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $voter = mysqli_real_escape_string($conn, $_POST['voter']);

    $query = "INSERT INTO residents (first_name, last_name, middle_name, date_of_birth, gender, civil_status, purok_no, contact, address, occupation, voter) 
                  VALUES ('$fname', '$lname', '$mname', '$dob', '$gender', '$civilStatus', '$purok', '$contact', '$address', '$occupation', '$voter')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../residents.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}

if (isset($_POST['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_id']);

    $query = "DELETE FROM residents WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: ../residents.php");
    exit();
}
if (isset($_POST['delete_cert'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_cert']);

    $query = "DELETE FROM certificates WHERE id='$id'";
    mysqli_query($conn, $query);
    header("Location: ../certificates.php");
    exit();
}

if (isset($_POST['issue_cert'])) {
    $cType = mysqli_real_escape_string($conn, $_POST['cType']);
    $cResident = mysqli_real_escape_string($conn, $_POST['cResident']);
    $cPurpose = mysqli_real_escape_string($conn, $_POST['cPurpose']);
    $cOR = mysqli_real_escape_string($conn, $_POST['cOR']);
    $query = "INSERT INTO certificates (certificate_type, resident_name, purpose, or_number, date_issued) VALUES ('$cType', '$cResident', '$cPurpose', '$cOR', CURDATE())";
    mysqli_query($conn, $query);

    header("Location: ../certificates.php");
    exit();
}

if (isset($_POST['save_blotter'])) {
    $bComplainant = mysqli_real_escape_string($conn, $_POST['bComplainant']);
    $bRespondent = mysqli_real_escape_string($conn, $_POST['bRespondent']);
    $bIncident = mysqli_real_escape_string($conn, $_POST['bIncident']);
    $bNarrative = mysqli_real_escape_string($conn, $_POST['bNarrative']);
    $bDate = mysqli_real_escape_string($conn, $_POST['bDate']);
    $bLocation = mysqli_real_escape_string($conn, $_POST['bLocation']);
    $query = "INSERT INTO blotter_records (complainant, respondent, incident_type, incident_narrative, incident_date, location, status) VALUES ('$bComplainant', '$bRespondent', '$bIncident', '$bNarrative', '$bDate', '$bLocation', 'Pending')";
    mysqli_query($conn, $query);
    header("Location: ../blotter.php");
    exit();
}
if (isset($_POST['delete_blotter'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_blotter']);

    $query = "DELETE FROM blotter_records WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../blotter.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}

if (isset($_POST['postAnnouncement'])) {
    $aTitle = mysqli_real_escape_string($conn, $_POST['aTitle']);
    $aContent = mysqli_real_escape_string($conn, $_POST['aContent']);
    $aPriority = mysqli_real_escape_string($conn, $_POST['aPriority']);
    $aAuthor = mysqli_real_escape_string($conn, $_POST['aAuthor']);
    $query = "INSERT INTO announcements (title, content, priority, posted_by) VALUES ('$aTitle', '$aContent', '$aPriority', '$aAuthor')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../announcements.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}

if (isset($_POST['delete_announcement'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_announcement']);

    $query = "DELETE FROM announcements WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../announcements.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}


if (isset($_POST['add_official'])) {
    $oName = mysqli_real_escape_string($conn, $_POST['oName']);
    $oPosition = mysqli_real_escape_string($conn, $_POST['oPosition']);
    $oCommittee = mysqli_real_escape_string($conn, $_POST['oCommittee']);
    $oContact = mysqli_real_escape_string($conn, $_POST['oContact']);
    $oTerm = mysqli_real_escape_string($conn, $_POST['oTerm']);
    $query = "INSERT INTO barangay_officials (full_name, position, committee, contact_number, term) VALUES ('$oName', '$oPosition', '$oCommittee', '$oContact', '$oTerm')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../officials.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}

if (isset($_POST['delete_official'])) {
    $id = mysqli_real_escape_string($conn, $_POST['delete_official']);

    $query = "DELETE FROM barangay_officials WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../officials.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}

if (isset($_POST['edit_official'])) {
    $id = mysqli_real_escape_string($conn, $_POST['edit_id']);
    $oName = mysqli_real_escape_string($conn, $_POST['oName']);
    $oPosition = mysqli_real_escape_string($conn, $_POST['oPosition']);
    $oCommittee = mysqli_real_escape_string($conn, $_POST['oCommittee']);
    $oContact = mysqli_real_escape_string($conn, $_POST['oContact']);
    $oTerm = mysqli_real_escape_string($conn, $_POST['oTerm']);
    $query = "UPDATE barangay_officials SET full_name='$oName', position='$oPosition', committee='$oCommittee', contact_number='$oContact', term='$oTerm' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../officials.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
    exit();
}
