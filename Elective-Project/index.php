<?php
    include "config.php";
    $sql = mysqli_query($conn, "SELECT * FROM residents");

    $ageque = "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM residents";
    $sql_age = mysqli_query($conn, $ageque);


    $nav_sql = "SELECT COUNT(*) as total FROM residents";
    $nav_result = mysqli_query($conn, $nav_sql);
    $nav_row = mysqli_fetch_assoc($nav_result);
    $total = $nav_row['total'];

    $female_sql = "SELECT COUNT(*) as total FROM residents WHERE TRIM(gender) = 'Female'";
    $female_result = mysqli_query($conn, $female_sql);
    $female_row = mysqli_fetch_assoc($female_result);
    $female = $female_row['total'];

    $male_sql = "SELECT COUNT(*) as total FROM residents WHERE TRIM(gender) = 'Male'";
    $male_result = mysqli_query($conn, $male_sql);
    $male_row = mysqli_fetch_assoc($male_result);
    $male = $male_row['total'];

    $seniors_sql = "SELECT COUNT(*) as total FROM residents WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 60";
    $seniors_result = mysqli_query($conn, $seniors_sql);
    $seniors_row = mysqli_fetch_assoc($seniors_result);
    $seniors = $seniors_row['total'];   

    $minor_sql = "SELECT COUNT(*) as total FROM residents WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 18";
    $minor_result = mysqli_query($conn, $minor_sql);
    $minor_row = mysqli_fetch_assoc($minor_result);
    $minor = $minor_row['total'];

    $voter_sql = "SELECT COUNT(*) as total FROM residents WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 18";
    $voter_result = mysqli_query($conn, $voter_sql);
    $voter_row = mysqli_fetch_assoc($voter_result);
    $voters = $voter_row['total'];


?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Barangay Management System</title>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
        <!-- Link to external CSS -->
        <link rel="stylesheet" href="style.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
<body>
 
    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-seal">BG</div>
            <div class="brand-text">
            <h1>Barangay Poblacion</h1>
            <p>Management System</p>
            </div>
        </div>

        <div class="sidebar-section">Main</div>
        <a class="nav-item active" onclick="navigate('dashboard', this)">
            <span class="nav-icon"><i class='bx bxs-dashboard'></i></span> Dashboard
        </a>
        <a class="nav-item" onclick="navigate('residents', this)">
            <span class="nav-icon"><i class='bx bx-group'></i></span> Residents
            <span class="nav-badge" id="residentBadge"><?php echo $total; ?></span>
        </a>
        <a class="nav-item" onclick="navigate('households', this)">
            <span class="nav-icon"><i class="fa-solid fa-house"></i></span> Households
        </a>

        <div class="sidebar-section">Services</div>
        <a class="nav-item" onclick="navigate('certificates', this)">
            <span class="nav-icon"><i class="fa-regular fa-certificate"></i></span> Certificates
        </a>
        <a class="nav-item" onclick="navigate('blotter', this)">
            <span class="nav-icon"><i class="fa-solid fa-file"></i></span> Blotter
        </a>

        <a class="nav-item" onclick="navigate('analytics', this)">
            <span class="nav-icon"><i class="fa-solid fa-chart-bar"></i></span> Analytics
        </a>

        <div class="sidebar-section">Community</div>
        <a class="nav-item" onclick="navigate('announcements', this)">
            <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span> Announcements
        </a>
        <a class="nav-item" onclick="navigate('officials', this)">
            <span class="nav-icon"><i class="fa-solid fa-building-columns"></i></span> Officials
        </a>

        <div class="sidebar-footer">
            <div class="sidebar-user">
            <div class="user-avatar">CP</div>
            <div class="user-info">
                <span>Capt. Pedro Reyes</span>
                <small>Punong Barangay</small>
            </div>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">
    <!-- TOPBAR -->
        <div class="topbar">
            <button class="hamburger" onclick="toggleSidebar()">☰</button>
            <div class="topbar-title" id="topbarTitle">Dashboard</div>
            <span class="topbar-date" id="topbarDate"></span>
            <div class="topbar-search">
            <span style="color:var(--gray-400);font-size:14px;"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" placeholder="Search residents..." id="globalSearch" oninput="handleGlobalSearch(this.value)">
            </div>
            <button class="topbar-btn" title="Notifications"><i class="fa-regular fa-bell"></i><span class="notif-dot"></span></button>
            <button class="topbar-btn" title="Print" onclick="window.print()"><i class="fa-solid fa-print"></i></button>
        </div>

        <!-- ── DASHBOARD ── -->
        <div class="page-content active" id="page-dashboard">
            <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#EEF2FF;"><i class="fa-solid fa-people-group"></i></div>
                <div class="stat-info">
                <div class="stat-label">Total Residents</div>
                <?php
                    $sql1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM residents");
                    $row1 = mysqli_fetch_assoc($sql1);
                ?>
                <div class="stat-value" id="dashTotalRes"><?php echo $row1['total']; ?></div>
                <div class="stat-sub">↑ Live count</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#E6F5ED;">🏘️</div>
                <div class="stat-info">
                <div class="stat-label">Households</div>
                <div class="stat-value" id="dashHouseholds">0</div>
                <div class="stat-sub">↑ Registered</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#FFF3DB;">📋</div>
                <div class="stat-info">
                <div class="stat-label">Certificates Issued</div>
                <div class="stat-value" id="dashCerts">0</div>
                <div class="stat-sub">↑ This session</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#FDECEA;">📝</div>
                <div class="stat-info">
                <div class="stat-label">Blotter Records</div>
                <div class="stat-value" id="dashBlotter">0</div>
                <div class="stat-sub" id="blotterPendingStat">0 pending</div>
                </div>
            </div>
            </div>

            <div class="dash-grid">
            <!-- Recent Residents -->
            <div class="card">
                <div class="card-header">
                    <span style="font-size:16px">👥</span>
                    <div class="card-title">Recently Registered Residents</div>
                    <button class="btn btn-ghost btn-sm" onclick="navigate('residents', null)">View All</button>
                    </div>
                <div class="tbl-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Purok</th>
                        <th>Occupation</th>
                        <th>Birthdate</th>
                    </tr>
                    </thead>
                    <tbody id="dashResTable">
                        <?php
                            $recent_sql = mysqli_query($conn, "SELECT * FROM residents ORDER BY id DESC LIMIT 5");
                            while($row = mysqli_fetch_assoc($recent_sql)){
                        ?>
                        <tr>
                            <td><?php echo $row['first_name']; ?>
                                <?php echo $row['last_name']; ?>
                                <?php echo $row['middle_name']; ?>
                            </td>
                            <td><?php echo $row['purok_no']; ?></td>
                            <td><?php echo $row['occupation']; ?></td>
                            <td><?php echo $row['date_of_birth']; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
                </div>
            </div>

            <!-- Quick Stats Panel -->
            <div style="display:flex;flex-direction:column;gap:16px;">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:16px">📊</span>
                        <div class="card-title">Population by Purok</div>
                    </div>
                    <div class="card-body" style="padding:16px;">
                        <canvas id="chartPurok" height="160"></canvas>
                    </div>
                    </div>
                    <div class="card">
                    <div class="card-header">
                        <span style="font-size:16px">⚡</span>
                        <div class="card-title">Quick Stats</div>
                    </div>
                    <div class="card-body" style="padding-top:8px;">
                        <div class="quick-stat"><span class="quick-stat-label">Male residents</span><span class="quick-stat-val" id="qsMale"><?php echo $male; ?></span></div>
                        <div class="quick-stat"><span class="quick-stat-label">Female residents</span><span class="quick-stat-val" id="qsFemale"><?php echo $female; ?></span></div>
                        <div class="quick-stat"><span class="quick-stat-label">Senior citizens (60+)</span><span class="quick-stat-val" id="qsSenior"><?php echo $seniors?></span></div>
                        <div class="quick-stat"><span class="quick-stat-label">Minors (below 18)</span><span class="quick-stat-val" id="qsMinor"><?php echo $minor?></span></div>
                        <div class="quick-stat"><span class="quick-stat-label">Voters registered</span><span class="quick-stat-val" id="qsVoter"><?php echo $voters?></span></div>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <!-- ── RESIDENTS ── -->
        <div class="page-content" id="page-residents">
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
                <option>Purok 1</option><option>Purok 2</option><option>Purok 3</option>
                <option>Purok 4</option><option>Purok 5</option>
            </select>
            <select id="residentGender" onchange="renderResidents()">
                <option value="">All Genders</option>
                <option>Male</option><option>Female</option>
            </select>
            <select id="residentStatus" onchange="renderResidents()">
                <option value="">All Status</option>
                <option>Active</option><option>Inactive</option>
            </select>
            </div>

            <div class="card">
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th><th>Full Name</th><th>Age</th><th>Gender</th>
                            <th>Purok</th><th>Civil Status</th><th>Voter</th><th>Occupation</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="residentTable">
                        <?php
                            $recent_sql = mysqli_query($conn, "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM residents");
                            while($row = mysqli_fetch_assoc($recent_sql)){
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
                                <button class="btn btn-primary" onclick="openEditResident('<?php echo $row['id']; ?>')">Edit</button>
                                <button class="btn btn-danger" onclick="deleteResident('<?php echo $row['id']; ?>')">Delete</button>
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

        <!-- ── HOUSEHOLDS ── -->
        <div class="page-content" id="page-households">
            <div class="page-header flex items-center">
            <div>
                <h2>Household Records</h2>
                <p>Track family units within the barangay</p>
            </div>
            <button class="btn btn-primary ml-auto" onclick="openModal('modalHousehold')">+ Add Household</button>
            </div>
            <div class="card">
            <div class="tbl-wrap">
                <table>
                <thead>
                    <tr><th>#</th><th>Household Head</th><th>Address</th><th>Purok</th><th>Members</th><th>Actions</th></tr>
                </thead>
                <tbody id="householdTable"></tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- ── CERTIFICATES ── -->
        <div class="page-content" id="page-certificates">
            <div class="page-header flex items-center">
            <div>
                <h2>Certificate Issuance</h2>
                <p>Generate official barangay documents</p>
            </div>
            <button class="btn btn-primary ml-auto" onclick="openModal('modalCert')">+ Issue Certificate</button>
            </div>

            <div class="pill-tabs">
            <button class="pill-tab active" onclick="filterCerts('all', this)">All</button>
            <button class="pill-tab" onclick="filterCerts('Barangay Clearance', this)">Clearance</button>
            <button class="pill-tab" onclick="filterCerts('Certificate of Residency', this)">Residency</button>
            <button class="pill-tab" onclick="filterCerts('Certificate of Indigency', this)">Indigency</button>
            </div>

            <div class="card">
            <div class="tbl-wrap">
                <table>
                <thead>
                    <tr><th>#</th><th>Resident</th><th>Certificate Type</th><th>Purpose</th><th>Date Issued</th><th>OR No.</th><th>Actions</th></tr>
                </thead>
                <tbody id="certTable"></tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- ── BLOTTER ── -->
        <div class="page-content" id="page-blotter">
            <div class="page-header flex items-center">
            <div>
                <h2>Barangay Blotter</h2>
                <p>Incident and complaint records</p>
            </div>
            <button class="btn btn-primary ml-auto" onclick="openModal('modalBlotter')">+ New Report</button>
            </div>
            <div class="card">
            <div class="tbl-wrap">
                <table>
                <thead>
                    <tr><th>#</th><th>Case No.</th><th>Complainant</th><th>Respondent</th><th>Incident</th><th>Date</th><th>Status</th><th>Actions</th></tr>
                </thead>
                <tbody id="blotterTable"></tbody>
                </table>
            </div>
            </div>
        </div>

        <!-- ── ANNOUNCEMENTS ── -->
        <div class="page-content" id="page-announcements">
            <div class="page-header flex items-center">
            <div>
                <h2>Announcements</h2>
                <p>Community notices and updates</p>
            </div>
            <button class="btn btn-primary ml-auto" onclick="openModal('modalAnnounce')">+ Post Announcement</button>
            </div>
            <div class="announce-list" id="announceList"></div>
        </div>

        <!-- ── OFFICIALS ── -->
        <div class="page-content" id="page-officials">
            <div class="page-header flex items-center">
            <div>
                <h2>Barangay Officials</h2>
                <p>Elected and appointed officials directory</p>
            </div>
            <button class="btn btn-primary ml-auto" onclick="openModal('modalOfficial')">+ Add Official</button>
            </div>
            <div id="officialsGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;"></div>
        </div>

        <!-- ── ANALYTICS ── -->
        <div class="page-content" id="page-analytics">
            <div class="page-header">
            <h2>Analytics &amp; Reports</h2>
            <p>Visual data overview of the barangay population and records</p>
            </div>

            <!-- Row 1: Gender pie + Age group bar -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">🧑‍🤝‍🧑</span>
                <div class="card-title">Gender Distribution</div>
                </div>
                <div class="card-body" style="display:flex;align-items:center;justify-content:center;padding:20px;">
                <canvas id="chartGender" style="max-width:220px;max-height:220px;"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">👶</span>
                <div class="card-title">Age Group Breakdown</div>
                </div>
                <div class="card-body" style="padding:16px;">
                <canvas id="chartAge" height="200"></canvas>
                </div>
            </div>
            </div>

            <!-- Row 2: Purok population horizontal bar -->
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:20px;">
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">🏘️</span>
                <div class="card-title">Population per Purok</div>
                </div>
                <div class="card-body" style="padding:16px;">
                <canvas id="chartPurokBar" height="180"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">🗳️</span>
                <div class="card-title">Voter Status</div>
                </div>
                <div class="card-body" style="display:flex;align-items:center;justify-content:center;padding:20px;">
                <canvas id="chartVoter" style="max-width:180px;max-height:180px;"></canvas>
                </div>
            </div>
            </div>

            <!-- Row 3: Civil status doughnut + Blotter status bar -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">💍</span>
                <div class="card-title">Civil Status Distribution</div>
                </div>
                <div class="card-body" style="display:flex;align-items:center;justify-content:center;padding:20px;">
                <canvas id="chartCivil" style="max-width:220px;max-height:220px;"></canvas>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                <span style="font-size:16px">📝</span>
                <div class="card-title">Blotter Case Status</div>
                </div>
                <div class="card-body" style="padding:16px;">
                <canvas id="chartBlotterStatus" height="200"></canvas>
                </div>
            </div>
            </div>

            <!-- Row 4: Certificates by type -->
            <div class="card" style="margin-bottom:20px;">
            <div class="card-header">
                <span style="font-size:16px">📋</span>
                <div class="card-title">Certificates Issued by Type</div>
            </div>
            <div class="card-body" style="padding:16px;">
                <canvas id="chartCertType" height="110"></canvas>
            </div>
            </div>
        </div>

    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->

    <!-- ADD RESIDENT -->
    <div class="modal-overlay" id="modalResident">
        <form action="" method="post">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Register New Resident</div>
                    <button class="modal-close" onclick="closeModal('modalResident')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name *</label>
                            <input class="form-control" id="rFirstName" placeholder="Juan">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name *</label>
                            <input class="form-control" id="rLastName" placeholder="Dela Cruz">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Middle Name</label>
                            <input class="form-control" id="rMiddleName" placeholder="Santos">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Date of Birth *</label>
                            <input class="form-control" type="date" id="rDob">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Gender *</label>
                            <select class="form-control" id="rGender">
                                <option value="">Select...</option>
                                <option>Male</option><option>Female</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label class="form-label">Civil Status</label>
                    <select class="form-control" id="rCivil">
                        <option>Single</option><option>Married</option>
                        <option>Widowed</option><option>Separated</option>
                    </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                    <label class="form-label">Purok *</label>
                    <select class="form-control" id="rPurok">
                        <option value="">Select...</option>
                        <option>Purok 1</option><option>Purok 2</option><option>Purok 3</option>
                        <option>Purok 4</option><option>Purok 5</option>
                    </select>
                    </div>
                    <div class="form-group">
                    <label class="form-label">Contact Number</label>
                    <input class="form-control" id="rContact" placeholder="09XX XXX XXXX">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Complete Address</label>
                    <input class="form-control" id="rAddress" placeholder="House No., Street, Purok">
                </div>
                <div class="form-row">
                    <div class="form-group">
                    <label class="form-label">Occupation</label>
                    <input class="form-control" id="rOccupation" placeholder="e.g. Farmer, Teacher...">
                    </div>
                    <div class="form-group">
                    <label class="form-label">Registered Voter?</label>
                    <select class="form-control" id="rVoter">
                        <option>Yes</option><option>No</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('modalResident')">Cancel</button>
                <button class="btn btn-primary" onclick="saveResident()">Register Resident</button>
            </div>
        </div>
        </form>
    </div>

    <!-- ADD HOUSEHOLD -->
    <div class="modal-overlay" id="modalHousehold">
        <div class="modal">
            <div class="modal-header">
            <div class="modal-title">Register Household</div>
            <button class="modal-close" onclick="closeModal('modalHousehold')">✕</button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Household Head (Full Name) *</label>
                <input class="form-control" id="hhHead" placeholder="Juan Dela Cruz">
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Purok *</label>
                <select class="form-control" id="hhPurok">
                    <option value="">Select...</option>
                    <option>Purok 1</option><option>Purok 2</option><option>Purok 3</option>
                    <option>Purok 4</option><option>Purok 5</option>
                </select>
                </div>
                <div class="form-group">
                <label class="form-label">No. of Members *</label>
                <input class="form-control" type="number" id="hhMembers" min="1" placeholder="4">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Complete Address *</label>
                <input class="form-control" id="hhAddress" placeholder="House No., Street">
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Housing Type</label>
                <select class="form-control" id="hhType">
                    <option>Owned</option><option>Rented</option><option>Shared</option><option>Government Lot</option>
                </select>
                </div>
                <div class="form-group">
                <label class="form-label">Contact</label>
                <input class="form-control" id="hhContact" placeholder="09XX XXX XXXX">
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalHousehold')">Cancel</button>
            <button class="btn btn-primary" onclick="saveHousehold()">Save Household</button>
            </div>
        </div>
    </div>

    <!-- ISSUE CERTIFICATE -->
    <div class="modal-overlay" id="modalCert">
        <div class="modal" style="max-width:680px;">
            <div class="modal-header">
            <div class="modal-title">Issue Certificate</div>
            <button class="modal-close" onclick="closeModal('modalCert')">✕</button>
            </div>
            <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Certificate Type *</label>
                <select class="form-control" id="cType" onchange="updateCertPreview()">
                    <option>Barangay Clearance</option>
                    <option>Certificate of Residency</option>
                    <option>Certificate of Indigency</option>
                    <option>Business Permit Clearance</option>
                </select>
                </div>
                <div class="form-group">
                <label class="form-label">Resident Name *</label>
                <input class="form-control" id="cResident" placeholder="Full name of requestor" oninput="updateCertPreview()">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Purpose *</label>
                <input class="form-control" id="cPurpose" placeholder="e.g. Employment, Travel..." oninput="updateCertPreview()">
                </div>
                <div class="form-group">
                <label class="form-label">OR Number</label>
                <input class="form-control" id="cOR" placeholder="e.g. 2024-0001">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Certificate Preview</label>
                <div class="cert-preview" id="certPreview">
                <div class="cert-sub">Republic of the Philippines</div>
                <div class="cert-title">Barangay Clearance</div>
                <div class="cert-sub" style="margin-top:4px;">Barangay Poblacion</div>
                <div class="cert-body" id="certBody" style="margin-top:16px;">
                    This is to certify that <strong id="certName">___________</strong> is a bonafide resident of this barangay and is known to be a person of good moral character and has no derogatory record filed in this office.
                </div>
                <div style="font-size:12px;color:var(--gray-400);margin-top:12px;">Purpose: <strong id="certPurpose">___________</strong></div>
                <div class="cert-sig">
                    <div class="cert-sig-block">
                    <div class="cert-sig-line"></div>
                    <span>Requestor's Signature</span>
                    </div>
                    <div class="cert-sig-block">
                    <div class="cert-sig-line"></div>
                    <span>Punong Barangay</span>
                    <span style="font-size:11px;font-weight:600;margin-top:2px;">Capt. Pedro Reyes</span>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalCert')">Cancel</button>
            <button class="btn btn-primary" onclick="saveCert()">Issue Certificate</button>
            </div>
        </div>
    </div>

    <!-- BLOTTER -->
    <div class="modal-overlay" id="modalBlotter">
        <div class="modal">
            <div class="modal-header">
            <div class="modal-title">File Blotter Report</div>
            <button class="modal-close" onclick="closeModal('modalBlotter')">✕</button>
            </div>
            <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Complainant *</label>
                <input class="form-control" id="bComplainant" placeholder="Full name">
                </div>
                <div class="form-group">
                <label class="form-label">Respondent *</label>
                <input class="form-control" id="bRespondent" placeholder="Full name">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Incident Type *</label>
                <select class="form-control" id="bIncident">
                <option>Physical Altercation</option>
                <option>Verbal Assault</option>
                <option>Theft / Robbery</option>
                <option>Property Damage</option>
                <option>Noise Complaint</option>
                <option>Domestic Dispute</option>
                <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Incident Narrative *</label>
                <textarea class="form-control" id="bNarrative" rows="3" placeholder="Describe the incident in detail..."></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Date & Time of Incident *</label>
                <input class="form-control" type="datetime-local" id="bDate">
                </div>
                <div class="form-group">
                <label class="form-label">Location</label>
                <input class="form-control" id="bLocation" placeholder="e.g. Purok 3, near market">
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalBlotter')">Cancel</button>
            <button class="btn btn-primary" onclick="saveBlotter()">File Report</button>
            </div>
        </div>
    </div>

    <!-- ANNOUNCEMENT -->
    <div class="modal-overlay" id="modalAnnounce">
        <div class="modal">
            <div class="modal-header">
            <div class="modal-title">Post Announcement</div>
            <button class="modal-close" onclick="closeModal('modalAnnounce')">✕</button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Title *</label>
                <input class="form-control" id="aTitle" placeholder="e.g. Barangay Assembly Meeting">
            </div>
            <div class="form-group">
                <label class="form-label">Content *</label>
                <textarea class="form-control" id="aContent" rows="4" placeholder="Write the announcement details..."></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Priority</label>
                <select class="form-control" id="aPriority">
                    <option value="normal">Normal</option>
                    <option value="urgent">Urgent</option>
                    <option value="gold">Important</option>
                </select>
                </div>
                <div class="form-group">
                <label class="form-label">Posted By</label>
                <input class="form-control" id="aAuthor" value="Capt. Pedro Reyes">
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalAnnounce')">Cancel</button>
            <button class="btn btn-primary" onclick="saveAnnouncement()">Post</button>
            </div>
        </div>
    </div>

    <!-- OFFICIAL -->
    <div class="modal-overlay" id="modalOfficial">
        <div class="modal">
            <div class="modal-header">
            <div class="modal-title">Add Barangay Official</div>
            <button class="modal-close" onclick="closeModal('modalOfficial')">✕</button>
            </div>
            <div class="modal-body">
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input class="form-control" id="oName" placeholder="Full name">
                </div>
                <div class="form-group">
                <label class="form-label">Position *</label>
                <select class="form-control" id="oPosition">
                    <option>Punong Barangay</option>
                    <option>Barangay Kagawad</option>
                    <option>SK Chairperson</option>
                    <option>Barangay Secretary</option>
                    <option>Barangay Treasurer</option>
                    <option>Barangay Tanod</option>
                </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                <label class="form-label">Committee</label>
                <input class="form-control" id="oCommittee" placeholder="e.g. Peace & Order">
                </div>
                <div class="form-group">
                <label class="form-label">Contact</label>
                <input class="form-control" id="oContact" placeholder="09XX XXX XXXX">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Term (e.g. 2023–2026)</label>
                <input class="form-control" id="oTerm" placeholder="2023–2026">
            </div>
            </div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalOfficial')">Cancel</button>
            <button class="btn btn-primary" onclick="saveOfficial()">Add Official</button>
            </div>
        </div>
    </div>

    <!-- VIEW RESIDENT -->
    <div class="modal-overlay" id="modalViewResident">
        <div class="modal">
            <div class="modal-header">
            <div class="modal-title">Resident Details</div>
            <button class="modal-close" onclick="closeModal('modalViewResident')">✕</button>
            </div>
            <div class="modal-body" id="viewResidentBody"></div>
            <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal('modalViewResident')">Close</button>
            </div>
        </div>
    </div>

    <!-- Link to external JS -->
    <script src="index.js"></script>
</body>
</html>