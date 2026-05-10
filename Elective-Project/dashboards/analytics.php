<?php
    include "../database/config.php";
    $sql = mysqli_query($conn, "SELECT * FROM residents");

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
                <h1>Barangay Purok ni Buulan</h1>
                <p>Management System</p>
            </div>
        </div>

        <div class="sidebar-section">Main</div>
        <a class="nav-item " href="dashboard.php">
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

        <a class="nav-item active" href="analytics.php">
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
            <div class="topbar-search">
                <span style="color:var(--gray-400);font-size:14px;"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" placeholder="Search residents..." id="globalSearch" oninput="handleGlobalSearch(this.value)">
            </div>
            <button class="topbar-btn" title="Notifications"><i class="fa-regular fa-bell"></i><span class="notif-dot"></span></button>
            <button class="topbar-btn" title="Print" onclick="window.print()"><i class="fa-solid fa-print"></i></button>
        </div>

        <!-- ── ANALYTICS ── -->
        <div class="page-content active" id="page-analytics">
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
                    <div class="card-body" style="padding:16px;">
                        <div style="position:relative;height:220px;">
                            <canvas id="chartGender"></canvas>
                        </div>
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
                    <div class="card-body" style="padding:16px;">
                        <div style="position:relative;height:200px;">
                            <canvas id="chartVoter"></canvas>
                        </div>
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
                    <div class="card-body" style="padding:16px;">
                        <div style="position:relative;height:220px;">
                            <canvas id="chartCivil"></canvas>
                        </div>
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
    <!-- Link to external JS -->
    <script src="src/index.js"></script>
</body>

</html>