<?php
    session_start();
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
        <a class="nav-item active" href="blotter.php">
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

        <!-- ── BLOTTER ── -->
        <div class="page-content active" id="page-blotter">
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
                            <tr>
                                <th>#</th>
                                <th>Case No.</th>
                                <th>Complainant</th>
                                <th>Respondent</th>
                                <th>Incident</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th> 
                            </tr>
                        </thead> 
                        <tbody id="blotterTable">
                            <?php
                                $blotterRes = mysqli_query($conn, "SELECT * FROM blotter_records ORDER BY incident_date DESC");
                                if(mysqli_num_rows($blotterRes) == 0){
                                    echo '<tr><td colspan="8"><div class="empty-state"><div class="empty-icon">📝</div><p>No blotter records</p></div></td></tr>';
                                }
                                else{
                                    while($b = mysqli_fetch_assoc($blotterRes)){
                            ?>
                            <tr class="blotter-row">
                                <td class="text-muted text-sm"><?php echo $b['id']; ?></td>
                                <td><?php echo $b['case_no']; ?></td>
                                <td><?php echo $b['complainant']; ?></td>
                                <td><?php echo $b['respondent']; ?></td>
                                <td><?php echo $b['incident_type']; ?></td>
                                <td class="text-sm"><?php echo $b['incident_date']; ?></td>
                                <td>
                                    <select class="form-control" style="width:120px;padding:4px 8px;font-size:12px;" onchange="updateBlotterStatus(<?php echo $b['id']; ?>, this.value)">
                                        <option value="Pending" <?php echo (strcasecmp(trim($b['status']), 'Pending') == 0) ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Under Investigation" <?php echo (strcasecmp(trim($b['status']), 'Under Investigation') == 0) ? 'selected' : ''; ?>>Under Investigation</option>
                                        <option value="Settled" <?php echo (strcasecmp(trim($b['status']), 'Settled') == 0) ? 'selected' : ''; ?>>Settled</option>
                                        <option value="Referred to Court" <?php echo (strcasecmp(trim($b['status']), 'Referred to Court') == 0) ? 'selected' : ''; ?>>Referred to Court</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="viewBlotter(this)" data-narrative="<?php echo htmlspecialchars($b['incident_narrative'] ?? 'No narrative provided.'); ?>">View</button>
                                    <form action="backend/action.php" method="POST" style="display:inline;">
                                        <button class="btn btn-danger btn-sm" type="submit" name="delete_blotter" value="<?php echo $b['id']; ?>" onclick="return confirm('Are you sure you want to delete this blotter record?');">Del</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->
    <!-- BLOTTER -->
    <div class="modal-overlay" id="modalBlotter">
        <form method="POST" action="backend/action.php" class="modal-content">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">File Blotter Report</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalBlotter')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">  
                        <div class="form-group">
                            <label class="form-label">Complainant *</label>
                            <input class="form-control" id="bComplainant" placeholder="Full name" name="bComplainant">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Respondent *</label>
                            <input class="form-control" id="bRespondent" placeholder="Full name" name="bRespondent">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Incident Type *</label>
                        <select class="form-control" id="bIncident" name="bIncident">
                            <option value="Physical Altercation">Physical Altercation</option>
                            <option value="Verbal Assault">Verbal Assault</option>
                            <option value="Theft / Robbery">Theft / Robbery</option>
                            <option value="Property Damage">Property Damage</option>
                            <option value="Noise Complaint">Noise Complaint</option>
                            <option value="Domestic Dispute">Domestic Dispute</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Incident Narrative *</label>
                        <textarea class="form-control" id="bNarrative" rows="3" placeholder="Describe the incident in detail..." name="bNarrative"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Date & Time of Incident *</label>
                            <input class="form-control" type="datetime-local" id="bDate" name="bDate">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input class="form-control" id="bLocation" placeholder="e.g. Purok 3, near market" name="bLocation">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalBlotter')">Cancel</button>
                    <button class="btn btn-primary" type="submit" name="save_blotter">File Report</button>
                </div>           
            </div>
        </form>
    </div>

    <!-- VIEW BLOTTER MODAL -->
    <div class="modal-overlay" id="modalViewBlotter">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Incident Narrative</div>
                <button type="button" class="modal-close" onclick="closeModal('modalViewBlotter')">✕</button>
            </div>
            <div class="modal-body">
                <p id="viewBlotterNarrative" style="white-space: pre-wrap; font-size: 14px; color: var(--gray-600); line-height: 1.6;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal('modalViewBlotter')">Close</button>
            </div>
        </div>
    </div>

    <script src="src/index.js?v=<?php echo time(); ?>"></script>
</body>

</html>