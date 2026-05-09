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
        <a class="nav-item active" href="certificates.php">
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

        <!-- ── CERTIFICATES ── -->
        <div class="page-content active" id="page-certificates">
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
                <form action = "backend/action.php" method = "post">
                    <div class="tbl-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Resident</th>
                                    <th>Certificate Type</th>
                                    <th>Purpose</th>
                                    <th>Date Issued</th> 
                                    <th>OR No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="certTable">
                                <?php
                                    $certRes = mysqli_query($conn,"SELECT * FROM certificates ORDER BY date_issued DESC");
                                    if(mysqli_num_rows($certRes) == 0) {
                                        echo '<tr><td colspan="7"><div class="empty-state"><div class="empty-icon">📋</div><p>No certificates yet</p></div></td></tr>';
                                    }
                                    else{
                                        while($c = mysqli_fetch_assoc($certRes)){
                                        $typeColors = [
                                            'Barangay Clearance' => 'blue',
                                            'Certificate of Residency' => 'green',
                                            'Certificate of Indigency' => 'gold',
                                            'Business Permit Clearance' => 'orange'
                                        ];
                                ?>
                                <tr>
                                    <td class="text-muted text-sm"><?php echo $c['id']; ?></td>
                                    <td><strong><?php echo $c['resident_name']; ?></strong></td>
                                    <td><span class="badge badge-<?php echo $typeColors[$c['certificate_type']]; ?>"><?php echo $c['certificate_type']; ?></span></td>
                                    <td><?php echo $c['purpose']; ?></td>
                                    <td><?php echo $c['date_issued']; ?></td>
                                    <td><?php echo $c['or_number']; ?></td>
                                    <td><button class="btn btn-danger btn-sm" name="delete_cert" value="<?php echo $c['id']; ?>">Del</button></td>
                                </tr>

                                <?php }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->
    <!-- ISSUE CERTIFICATE -->
    <div class="modal-overlay" id="modalCert">
        <form action="backend/action.php" method="post">
            <div class="modal" style="max-width:680px;">
                <div class="modal-header">
                    <div class="modal-title">Issue Certificate</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalCert')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Certificate Type *</label>
                            <select class="form-control" name="cType" id="cType" onchange="updateCertPreview()" required>
                                <option>Barangay Clearance</option>
                                <option>Certificate of Residency</option>
                                <option>Certificate of Indigency</option>
                                <option>Business Permit Clearance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Resident Name *</label>
                            <input class="form-control" name="cResident" id="cResident" placeholder="Full name of requestor" oninput="updateCertPreview()" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Purpose *</label>
                            <input class="form-control" name="cPurpose" id="cPurpose" placeholder="e.g. Employment, Travel..." oninput="updateCertPreview()" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">OR Number</label>
                            <input class="form-control" name="cOR" id="cOR" placeholder="e.g. 2024-0001">
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
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalCert')">Cancel</button>
                    <button class="btn btn-primary" name = "issue_cert">Issue Certificate</button>
                </div>
            </div>
        </form>
    </div>
    <!-- Link to external JS -->
    <script src="src/index.js"></script>
</body>

</html>