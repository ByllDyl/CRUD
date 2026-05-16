<?php
    session_start();
    include "../database/config.php";
    $sql = mysqli_query($conn, "SELECT * FROM residents");
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
                <h1>Barangay Purok ni Bulan</h1>
                <p>Management System</p>
            </div>
        </div>

        <div class="sidebar-section">Main</div>
        <a class="nav-item " href="dashboard.php">
            <span class="nav-icon"><i class='bx bxs-dashboard'></i></span> Dashboard
        </a>
        <a class="nav-item" href="residents.php">
            <span class="nav-icon"><i class='bx bx-group'></i></span> Residents
            <span class="nav-badge" id="residentBadge"><?php echo $_SESSION['total']; ?></span>
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

        <!-- ── ANALYTICS ── -->
        <div class="page-content active" id="page-analytics">
            <div class="page-header">
                <h2>Analytics &amp; Reports</h2>
                <p>Visual data overview of the barangay population and records</p>
            </div>

            <!-- TOP STATS / CHARTS -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(79, 70, 229, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-venus-mars"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Gender Distribution</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:240px;">
                            <canvas id="chartGender"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(56, 189, 248, 0.1); color: #38BDF8; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-children"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Age Group Breakdown</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:240px;">
                            <canvas id="chartAge"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN CHART -->
            <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:24px;">
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(52, 211, 153, 0.1); color: #34D399; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Population per Purok</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:280px;">
                            <canvas id="chartPurokBar"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(251, 191, 36, 0.1); color: #FBBF24; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-check-to-slot"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Voter Status</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:280px;">
                            <canvas id="chartVoter"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(244, 114, 182, 0.1); color: #F472B6; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-ring"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Civil Status Distribution</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:240px;">
                            <canvas id="chartCivil"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card" style="border:none; box-shadow: var(--shadow-md);">
                    <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                        <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(248, 113, 113, 0.1); color: #F87171; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>
                        <div class="card-title" style="font-size: 16px;">Blotter Case Status</div>
                    </div>
                    <div class="card-body" style="padding:24px;">
                        <div style="position:relative;height:240px;">
                            <canvas id="chartBlotterStatus"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="border:none; box-shadow: var(--shadow-md); margin-bottom:24px;">
                <div class="card-header" style="border-bottom: 1px solid var(--gray-100); padding: 20px 24px;">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: rgba(167, 139, 250, 0.1); color: #A78BFA; display: flex; align-items: center; justify-content: center; font-size: 16px; margin-right: 12px;">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div class="card-title" style="font-size: 16px;">Certificates Issued by Type</div>
                </div>
                <div class="card-body" style="padding:24px;">
                    <div style="position:relative;height:250px;">
                        <canvas id="chartCertType"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.main -->

    <script src="src/index.js"></script>
</body>

</html>