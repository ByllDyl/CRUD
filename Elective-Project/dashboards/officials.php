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
                <h1>Barangay Poblacion</h1>
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

        <a class="nav-item" href="analytics.php">
            <span class="nav-icon"><i class="fa-solid fa-chart-bar"></i></span> Analytics
        </a>

        <div class="sidebar-section">Community</div>
        <a class="nav-item" href="announcements.php">
            <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span> Announcements
        </a>
        <a class="nav-item active" href="officials.php">
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

        <!-- ── OFFICIALS ── -->
        <div class="page-content active" id="page-officials">
            <div class="page-header flex items-center">
                <div>
                    <h2>Barangay Officials</h2>
                    <p>Elected and appointed officials directory</p>
                </div>
                <button class="btn btn-primary ml-auto" onclick="openModal('modalOfficial')">+ Add Official</button>
            </div>
            <div id="officialsGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px;">
    
                <?php
                $officials = mysqli_query($conn, "SELECT * FROM barangay_officials"); 
                
                if(mysqli_num_rows($officials) == 0){
                    echo '<div class="empty-state" style="grid-column:1/-1;"><div class="empty-icon">🏛️</div><p>No officials added</p></div>';
                } else {
                    $posColors = [
                        'Punong Barangay' => 'navy',
                        'Barangay Kagawad' => 'blue',
                        'SK Chairperson' => 'green',
                        'Barangay Secretary' => 'gold',
                        'Barangay Treasurer' => 'green',
                        'Barangay Tanod' => 'gray'
                    ];
                    
                    $bgMap = [
                        'navy' => '#0B1F3A', 
                        'blue' => '#1565C0', 
                        'green' => '#1A7A4A', 
                        'gold' => '#C9922A', 
                        'gray' => '#5C5A55'
                    ];
                    while($o = mysqli_fetch_assoc($officials)){
                        $words = explode(' ', trim($o['full_name']));
                        $initials = '';
                        foreach($words as $w) {
                            if(!empty($w)) {
                                $initials .= $w[0];
                            }
                        }
                        $initials = strtoupper(substr($initials, 0, 2));
                        $position = $o['position'];
                        $colorCategory = isset($posColors[$position]) ? $posColors[$position] : 'navy';
                        $bg = $bgMap[$colorCategory];
                        $contact = !empty($o['contact_number']) ? $o['contact_number'] : '—';
                        ?>
                        
                        <div class="card" style="padding:20px;text-align:center;transition:transform 0.2s;cursor:pointer;" onmouseenter="this.style.transform='translateY(-3px)'" onmouseleave="this.style.transform=''" onclick="editOfficial(<?php echo $o['id']; ?>, '<?php echo addslashes($o['full_name']); ?>', '<?php echo addslashes($o['position']); ?>', '<?php echo addslashes($o['committee']); ?>', '<?php echo addslashes($o['contact_number']); ?>', '<?php echo addslashes($o['term']); ?>')">
                            <div style="width:56px;height:56px;border-radius:50%;background:<?php echo $bg; ?>;color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;margin:0 auto 12px;">
                                <?php echo htmlspecialchars($initials); ?>
                            </div>
                            
                            <div style="font-weight:600;font-size:14.5px;"><?php echo htmlspecialchars($o['full_name']); ?></div>
                            <div style="font-size:12px;color:var(--gold);font-weight:600;margin:4px 0;"><?php echo htmlspecialchars($o['position']); ?></div>
                            <div style="font-size:12px;color:var(--gray-400);">Committee: <?php echo htmlspecialchars($o['committee']); ?></div>
                            <div style="font-size:12px;color:var(--gray-400);margin-top:2px;"><?php echo htmlspecialchars($contact); ?></div>
                            <div style="font-size:11px;color:var(--gray-200);margin-top:6px;">Term: <?php echo htmlspecialchars($o['term']); ?></div>
                            
                            <form action="backend/action.php" method="post" onclick="event.stopPropagation();">
                                <button onclick="return confirm('Are you sure you want to delete this official?');" class="btn btn-danger btn-sm" style="margin-top:12px;width:100%;" name="delete_official" value="<?php echo $o['id']; ?>">Remove</button>
                            </form>
                        </div>
                        <?php
                    } 
                } 
                ?>
            </div>
        </div>

    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->

    <!-- OFFICIAL -->
    <div class="modal-overlay" id="modalOfficial">
        <form action="backend/action.php" method="post">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Add Barangay Official</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalOfficial')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input name="oName" class="form-control" id="oName" placeholder="Full name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Position *</label>
                            <select name="oPosition" class="form-control" id="oPosition">
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
                            <input name="oCommittee" class="form-control" id="oCommittee" placeholder="e.g. Peace & Order">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact</label>
                            <input name="oContact" class="form-control" id="oContact" placeholder="09XX XXX XXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term (e.g. 2023–2026)</label>
                        <input name="oTerm" class="form-control" id="oTerm" placeholder="2023–2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalOfficial')">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add_official">Add Official</button>
                </div>
            </div>
        </form>
    </div>

    <!-- EDIT OFFICIAL -->
    <div class="modal-overlay" id="modalEditOfficial">
        <form action="backend/action.php" method="post">
            <input type="hidden" name="edit_id" id="edit_oId">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Edit Barangay Official</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalEditOfficial')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Full Name *</label>
                            <input name="oName" class="form-control" id="edit_oName" placeholder="Full name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Position *</label>
                            <select name="oPosition" class="form-control" id="edit_oPosition">
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
                            <input name="oCommittee" class="form-control" id="edit_oCommittee" placeholder="e.g. Peace & Order">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact</label>
                            <input name="oContact" class="form-control" id="edit_oContact" placeholder="09XX XXX XXXX">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Term (e.g. 2023–2026)</label>
                        <input name="oTerm" class="form-control" id="edit_oTerm" placeholder="2023–2026">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalEditOfficial')">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="edit_official">Save Changes</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Link to external JS -->
    <script src="src/index.js"></script>
</body>

</html>