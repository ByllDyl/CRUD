<?php
    include "../database/config.php";
    $sql = mysqli_query($conn, "SELECT * FROM residents");

    $ageque = "SELECT *, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age FROM residents";
    $sql_age = mysqli_query($conn, $ageque);


    $nav_sql = "SELECT COUNT(*) as total FROM residents";
    $nav_result = mysqli_query($conn, $nav_sql);
    $nav_row = mysqli_fetch_assoc($nav_result);
    $total = $nav_row['total'];

    $cert_count_sql = "SELECT COUNT(*) as total FROM certificates";
    $cert_count_result = mysqli_query($conn, $cert_count_sql);
    $cert_count_row = mysqli_fetch_assoc($cert_count_result);
    $cert_count = $cert_count_row['total'];

    $blotter_count_sql = "SELECT COUNT(*) as total FROM blotter_records";
    $blotter_count_result = mysqli_query($conn, $blotter_count_sql);
    $blotter_count_row = mysqli_fetch_assoc($blotter_count_result);
    $blotter_count = $blotter_count_row['total'];

    $blotter_pending_sql = "SELECT COUNT(*) as total FROM blotter_records WHERE status = 'pending'";
    $blotter_pending_result = mysqli_query($conn, $blotter_pending_sql);
    $blotter_pending_row = mysqli_fetch_assoc($blotter_pending_result);
    $blotter_pending = $blotter_pending_row['total'];

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

    $household_sql = "SELECT COUNT(*) as total FROM household_records";
    $household_result = mysqli_query($conn, $household_sql);
    $household_row = mysqli_fetch_assoc($household_result);
    $households = $household_row['total'];


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
    <link rel="stylesheet" href="src/style.css?v=<?php echo time(); ?>">
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
        <a class="nav-item active" href="dashboard.php">
            <span class="nav-icon"><i class='bx bxs-dashboard'></i></span> Dashboard
        </a>
        <a class="nav-item" href="residents.php">
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
                        <div class="stat-value" id="dashHouseholds"><?php  echo $households;  ?></div>
                        <div class="stat-sub">↑ Registered</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#FFF3DB;">📋</div>
                    <div class="stat-info">
                        <div class="stat-label">Certificates Issued</div>
                        <div class="stat-value" id="dashCerts"><?php echo $cert_count; ?></div>
                        <div class="stat-sub">↑ This session</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#FDECEA;">📝</div>
                    <div class="stat-info">
                        <div class="stat-label">Blotter Records</div>
                        <div class="stat-value" id="dashBlotter"><?php echo $blotter_count; ?></div>
                        <div class="stat-sub" id="blotterPendingStat"><?php echo $blotter_pending; ?> pending</div>
                    </div>
                </div>
            </div>

            <div class="dash-grid">
                <!-- Recent Residents -->
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:16px">👥</span>
                        <div class="card-title">Recently Registered Residents</div>
                        <button class="btn btn-ghost btn-sm" onclick="window.location.href='residents.php'">View All</button>
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
                                $recent_sql = mysqli_query($conn, "SELECT * FROM residents ORDER BY id DESC LIMIT 10");
                                while ($row = mysqli_fetch_assoc($recent_sql)) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['last_name']; ?>,
                                            <?php echo $row['first_name']; ?>
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
                            <div class="quick-stat"><span class="quick-stat-label">Senior citizens (60+)</span><span class="quick-stat-val" id="qsSenior"><?php echo $seniors ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label">Minors (below 18)</span><span class="quick-stat-val" id="qsMinor"><?php echo $minor ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label">Voters registered</span><span class="quick-stat-val" id="qsVoter"><?php echo $voters ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.main -->

    <!-- Link to external JS -->
    <script src="src/index.js"></script>
</body>

</html>