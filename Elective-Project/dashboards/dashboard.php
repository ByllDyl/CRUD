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

if ($total > 10) {
    $_SESSION['total'] = "9+";
} else {
    $_SESSION['total'] = $total;
}

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

$show_animation = false;
if (isset($_SESSION['just_logged_in']) && $_SESSION['just_logged_in'] === true) {
    $show_animation = true;
    unset($_SESSION['just_logged_in']);
}

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
    <?php if ($show_animation): ?>
    <style>
        #intro-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 100%);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        #intro-overlay h1 {
            color: #ffffff;
            font-size: 2.8rem;
            opacity: 0;
            transform: translateY(30px);
            animation: textIntro 2.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            text-align: center;
            padding: 0 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        @keyframes textIntro {
            0% { opacity: 0; transform: translateY(30px); }
            20% { opacity: 1; transform: translateY(0); }
            80% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-30px); }
        }
        
        .main, .sidebar {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .main.animate-in, .sidebar.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <div id="intro-overlay">
        <h1>Welcome to the Admin Dashboard</h1>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                const overlay = document.getElementById('intro-overlay');
                if (overlay) {
                    overlay.style.opacity = '0';
                    overlay.style.visibility = 'hidden';
                }
                setTimeout(() => {
                    const sidebar = document.querySelector('.sidebar');
                    const main = document.querySelector('.main');
                    if(sidebar) sidebar.classList.add('animate-in');
                    if(main) main.classList.add('animate-in');
                }, 100);
            }, 2500);
        });
    </script>
    <?php endif; ?>

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
        <a class="nav-item active" href="dashboard.php">
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
                                            foreach ($words as $w) {
                                                if (!empty($w)) $initials .= strtoupper($w[0]);
                                            }
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

        <!-- ── DASHBOARD ── -->
        <div class="page-content active" id="page-dashboard">
            <div class="stat-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background:var(--primary-light); color:var(--primary);">
                        <i class="fa-solid fa-users"></i>
                    </div>
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
                    <div class="stat-icon" style="background:#d1fae5; color:#10b981;">
                        <i class="fa-solid fa-house-chimney"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Households</div>
                        <div class="stat-value" id="dashHouseholds"><?php echo $households;  ?></div>
                        <div class="stat-sub">↑ Registered</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fef3c7; color:#f59e0b;">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Certificates Issued</div>
                        <div class="stat-value" id="dashCerts"><?php echo $cert_count; ?></div>
                        <div class="stat-sub">↑ This session</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background:#fee2e2; color:#ef4444;">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-label">Blotter Records</div>
                        <div class="stat-value" id="dashBlotter"><?php echo $blotter_count; ?></div>
                        <div class="stat-sub down" id="blotterPendingStat"><?php echo $blotter_pending; ?> pending</div>
                    </div>
                </div>
            </div>

            <div class="dash-grid">
                <!-- Recent Residents -->
                <div class="card">
                    <div class="card-header" style="display:flex;align-items:center;gap:12px;">
                        <div style="background:var(--primary-light); color:var(--primary); width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px;">
                            <i class="fa-solid fa-user-clock"></i>
                        </div>
                        <div class="card-title" style="flex:1;">Recently Registered Residents</div>
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
                        <div class="card-header" style="display:flex;align-items:center;gap:12px;">
                            <div style="background:#e0e7ff; color:#4f46e5; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px;">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <div class="card-title" style="flex:1;">Population by Purok</div>
                        </div>
                        <div class="card-body" style="padding:16px;">
                            <canvas id="chartPurokBar" height="160"></canvas>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" style="display:flex;align-items:center;gap:12px;">
                            <div style="background:#fef08a; color:#ca8a04; width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px;">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div class="card-title" style="flex:1;">Quick Stats</div>
                        </div>
                        <div class="card-body" style="padding-top:8px;">
                            <div class="quick-stat"><span class="quick-stat-label"><i class="fa-solid fa-person" style="color:var(--primary); width:18px; margin-right:4px;"></i> Male residents</span><span class="quick-stat-val" id="qsMale"><?php echo $male; ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label"><i class="fa-solid fa-person-dress" style="color:#f472b6; width:18px; margin-right:4px;"></i> Female residents</span><span class="quick-stat-val" id="qsFemale"><?php echo $female; ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label"><i class="fa-solid fa-person-cane" style="color:#38bdf8; width:18px; margin-right:4px;"></i> Senior citizens (60+)</span><span class="quick-stat-val" id="qsSenior"><?php echo $seniors ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label"><i class="fa-solid fa-child" style="color:#10b981; width:18px; margin-right:4px;"></i> Minors (below 18)</span><span class="quick-stat-val" id="qsMinor"><?php echo $minor ?></span></div>
                            <div class="quick-stat"><span class="quick-stat-label"><i class="fa-solid fa-check-to-slot" style="color:#f59e0b; width:18px; margin-right:4px;"></i> Voters registered</span><span class="quick-stat-val" id="qsVoter"><?php echo $voters ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /.main -->
    <script src="src/index.js"></script>
</body>

</html>