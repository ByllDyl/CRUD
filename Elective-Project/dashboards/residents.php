<?php
    session_start();
    include "../database/config.php";
    $sql = mysqli_query($conn, "SELECT * FROM residents");

    $ageque = "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM residents";
    $sql_age = mysqli_query($conn, $ageque);

    $nav_sql = "SELECT COUNT(*) as total FROM residents";
    $nav_result = mysqli_query($conn, $nav_sql);
    $nav_row = mysqli_fetch_assoc($nav_result);
    $total = $nav_row['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <link rel="stylesheet" href="src/style.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-seal">BG</div>
            <div class="brand-text">
                <h1>Barangay Purok ni Buulan</h1>
                <p>Management System</p>
            </div>
        </div>

        <div class="sidebar-section">Main</div>
        <a class="nav-item " href="dashboard.php">
            <span class="nav-icon"><i class='bx bxs-dashboard'></i></span> Dashboard
        </a>
        <a class="nav-item active" href="residents.php">
            <span class="nav-icon"><i class='bx bx-group'></i></span> Residents
            <span class="nav-badge" id="residentBadge"><?php echo $total; ?></span>
        </a>
        <a class="nav-item" href="household.php">
            <span class="nav-icon"><i class="fa-solid fa-house"></i></span> Households
        </a>

        <div class="sidebar-section">Services</div>
        <a class="nav-item" href="certificates.php">
            <span class="nav-icon"><i class="fa-regular fa-certificate"></i></span> Certificates
        </a>
        <a class="nav-item" href="blotter.php">
            <span class="nav-icon"><i class="fa-solid fa-file"></i></span> Blotter
        </a>

        <a class="nav-item" href="analytics.php">
            <span class="nav-icon"><i class="fa-solid fa-chart-bar"></i></span> Analytics
        </a>

        <div class="sidebar-section">Community</div>
        <a class="nav-item" href="announcements.php">
            <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span> Announcements
        </a>
        <a class="nav-item" href="officials.php">
            <span class="nav-icon"><i class="fa-solid fa-building-columns"></i></span> Officials
        </a>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar"><?php
                    $words = explode(' ', trim($_SESSION['username']));
                    $initials = '';
                    foreach($words as $w) { if(!empty($w)) $initials .= strtoupper($w[0]); }
                    echo substr($initials, 0, 2);
                ?></div>
                <div class="user-info">
                    <span><?php echo $_SESSION['username']; ?></span>
                    <small><?php echo $_SESSION['role']; ?></small>
                </div>
            </div>
            <a href="logout.php" class="nav-logout">
                <span class="nav-icon"><i class='bx bxs-log-out'></i></span>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
        <!-- TOPBAR -->
        <div class="topbar">
            <button class="hamburger" onclick="toggleSidebar()">☰</button>
            <div class="topbar-title" id="topbarTitle">Dashboard</div>
            <span class="topbar-date" id="topbarDate"></span>
            <button class="topbar-btn" title="Notifications"><i class="fa-regular fa-bell" onclick="window.location.href='announcements.php'"></i><span class="notif-dot"></span></button>
            <button class="topbar-btn" title="Print" onclick="window.print()"><i class="fa-solid fa-print"></i></button>
        </div>
        <!-- ── RESIDENTS ── -->
        <div class="page-content active" id="page-residents">
            <div class="page-header flex items-center">
                <div>
                    <h2>Residents Registry</h2>
                    <p>Manage all registered barangay residents</p>
                </div>
                <button class="btn btn-primary ml-auto" onclick="openModal('modalResident')">+ Add Resident</button>
            </div>

            <div class="filter-bar">
                <input type="text" placeholder="🔍 Search by name, address..." id="residentSearch" oninput="renderResidents()">
                <select id="residentPurok" onchange="renderResidents()">
                    <option value="">All Puroks</option>
                    <option>Purok 1</option>
                    <option>Purok 2</option>
                    <option>Purok 3</option>
                    <option>Purok 4</option>
                    <option>Purok 5</option>
                </select>
                <select id="residentGender" onchange="renderResidents()">
                    <option value="">All Genders</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
                <select id="residentStatus" onchange="renderResidents()">
                    <option value="">All Voter Status</option>
                    <option value="Yes">Registered Voter</option>
                    <option value="No">Non-Voter</option>
                </select>
            </div>

            <div class="card">
                <div class="tbl-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Purok</th>
                                <th>Civil Status</th>
                                <th>Voter</th>
                                <th>Occupation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="residentTable">
                            <?php
                            $recent_sql = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM residents");
                            while ($row = mysqli_fetch_assoc($recent_sql)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['first_name']; ?>
                                        <?php echo $row['last_name']; ?>
                                        <?php echo $row['middle_name']; ?>
                                    </td>
                                    <td><?php echo $row['age']; ?></td>
                                    <td><?php echo $row['gender']; ?></td>
                                    <td><?php echo $row['purok_no']; ?></td>
                                    <td><?php echo $row['civil_status']; ?></td>
                                    <td><?php echo $row['voter']; ?></td>
                                    <td><?php echo $row['occupation']; ?></td>
                                    <td>
                                        <button class="btn btn-primary" onclick="viewResident(this)" 
                                            data-name="<?php echo htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']); ?>"
                                            data-dob="<?php echo htmlspecialchars($row['date_of_birth']); ?>"
                                            data-age="<?php echo $row['age']; ?>"
                                            data-gender="<?php echo htmlspecialchars($row['gender']); ?>"
                                            data-civil="<?php echo htmlspecialchars($row['civil_status']); ?>"
                                            data-purok="<?php echo htmlspecialchars($row['purok_no']); ?>"
                                            data-contact="<?php echo htmlspecialchars($row['contact'] ?? 'N/A'); ?>"
                                            data-address="<?php echo htmlspecialchars($row['address'] ?? 'N/A'); ?>"
                                            data-occupation="<?php echo htmlspecialchars($row['occupation'] ?? 'N/A'); ?>"
                                            data-added="<?php echo htmlspecialchars($row['created_at'] ?? 'N/A'); ?>"
                                            data-voter="<?php echo htmlspecialchars($row['voter']); ?>">View</button>
                                        <form action="backend/action.php" method="POST" style="display:inline-block;">
                                            <button type="submit" class="btn btn-danger delete" name="delete_id" value="<?= isset($row['id']) ? $row['id'] : '' ?>" onclick="return confirm('Are you sure you want to delete this resident?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ──────── MODALS ──────── -->
    <!-- ADD RESIDENT -->
    <div class="modal-overlay" id="modalResident">
        <form action="backend/action.php" method="post">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Register New Resident</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalResident')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name *</label>
                            <input class="form-control" name="firstName" id="rFirstName" placeholder="Juan" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name *</label>
                            <input class="form-control" name="lastName" id="rLastName" placeholder="Dela Cruz" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input class="form-control" name="middleName" id="rMiddleName" placeholder="Santos">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date of Birth *</label>
                            <input class="form-control" type="date" name="dob" id="rDob" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select class="form-control" name="gender" id="rGender" required>
                                <option value="">Select...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Civil Status</label>
                            <select class="form-control" name="civilStatus" id="rCivil">
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Separated">Separated</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Purok *</label>
                            <select class="form-control" name="purok" id="rPurok" required>
                                <option value="">Select...</option>
                                <option value="Purok 1">Purok 1</option>
                                <option value="Purok 2">Purok 2</option>
                                <option value="Purok 3">Purok 3</option>
                                <option value="Purok 4">Purok 4</option>
                                <option value="Purok 5">Purok 5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Number</label>
                            <input class="form-control" name="contact" id="rContact" placeholder="09XX XXX XXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Complete Address</label>
                        <input class="form-control" name="address" id="rAddress" placeholder="House No., Street, Purok">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Occupation</label>
                            <input class="form-control" name="occupation" id="rOccupation" placeholder="e.g. Farmer, Teacher...">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Registered Voter?</label>
                            <select class="form-control" name="voter" id="rVoter">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalResident')">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add_resident">Register Resident</button>
                </div>
            </div>
        </form>
    </div>
 
    <!-- VIEW RESIDENT -->
    <div class="modal-overlay" id="modalViewResident">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Resident Details</div>
                <button class="modal-close" onclick="closeModal('modalViewResident')">✕</button>
            </div>
            <div class="modal-body" id="viewResidentBody">
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('modalViewResident')">Close</button>
            </div>
        </div>
    </div>
    <script src="src/index.js"></script>
</body>

</html>