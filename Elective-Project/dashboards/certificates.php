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
                                <tr class="cert-row" 
                                    data-id="<?php echo $c['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($c['resident_name'], ENT_QUOTES); ?>"
                                    data-type="<?php echo htmlspecialchars($c['certificate_type'], ENT_QUOTES); ?>"
                                    data-purpose="<?php echo htmlspecialchars($c['purpose'], ENT_QUOTES); ?>"
                                    data-date="<?php echo $c['date_issued']; ?>"
                                    data-or="<?php echo htmlspecialchars($c['or_number'], ENT_QUOTES); ?>"
                                    onclick="openCertPreview(this, event)"
                                    title="Click to preview certificate"
                                    style="cursor:pointer;">
                                    <td class="text-muted text-sm"><?php echo $c['id']; ?></td>
                                    <td><strong><?php echo $c['resident_name']; ?></strong></td>
                                    <td><span class="badge badge-<?php echo $typeColors[$c['certificate_type']]; ?>"><?php echo $c['certificate_type']; ?></span></td>
                                    <td><?php echo $c['purpose']; ?></td>
                                    <td><?php echo $c['date_issued']; ?></td>
                                    <td><?php echo $c['or_number']; ?></td>
                                    <td><button class="btn btn-danger btn-sm" name="delete_cert" value="<?php echo $c['id']; ?>" onclick="event.stopPropagation()">Del</button></td>
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
                        <div class="form-group cPurpose">
                            <label class="form-label">Purpose *</label>
                            <input class="form-control" name="cPurpose" id="cPurpose" placeholder="e.g. Employment, Travel..." oninput="updateCertPreview()" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Certificate Preview</label>
                        <div class="cert-preview" id="certPreview">
                            <div class="cert-sub">Republic of the Philippines</div>
                            <div class="cert-title">Barangay Clearance</div>
                            <div class="cert-sub" style="margin-top:4px;">Barangay Purok ni Bulan</div>
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

    <!-- ──────── CERTIFICATE PREVIEW MODAL ──────── -->
    <div class="modal-overlay" id="modalCertPreview">
        <div class="modal" style="max-width:700px;">
            <div class="modal-header">
                <div class="modal-title">Certificate Preview</div>
                <button type="button" class="modal-close" onclick="closeModal('modalCertPreview')">✕</button>
            </div>
            <div class="modal-body">
                <div class="cert-preview" id="previewDocument" style="background:#fff;padding:40px 50px;">
                    <!-- Header -->
                    <div style="text-align:center;margin-bottom:6px;">
                        <div style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#555;">Republic of the Philippines</div>
                        <div style="font-size:11px;letter-spacing:1px;text-transform:uppercase;color:#555;">Province of [Province] · Municipality of [Municipality]</div>
                        <div style="font-size:22px;font-weight:700;color:#1a237e;margin:10px 0 2px;" id="pvCertTitle">Barangay Clearance</div>
                        <div style="font-size:13px;font-weight:600;color:#333;">Barangay Purok ni Bulan</div>
                        <hr style="border:none;border-top:2px solid #1a237e;margin:12px 0 6px;">
                        <hr style="border:none;border-top:1px solid #1a237e;margin:0 0 16px;">
                    </div>

                    <!-- OR / Date row -->
                    <div style="display:flex;justify-content:space-between;font-size:12px;color:#555;margin-bottom:20px;">
                        <span>OR No.: <strong id="pvOR">—</strong></span>
                        <span>Date Issued: <strong id="pvDate">—</strong></span>
                    </div>

                    <!-- Body -->
                    <div style="font-size:14px;line-height:1.9;color:#222;text-align:justify;" id="pvBody">
                        This is to certify that <strong id="pvName">___________</strong>, a bonafide resident of this barangay, is known to be a person of good moral character and has no derogatory record filed in this office.
                    </div>

                    <div style="font-size:13px;margin-top:14px;color:#444;">Purpose: <em id="pvPurpose">—</em></div>

                    <!-- Signature block -->
                    <div style="display:flex;justify-content:space-between;margin-top:50px;">
                        <div style="text-align:center;width:40%;">
                            <div style="border-top:1px solid #333;padding-top:6px;font-size:12px;">Requestor's Signature</div>
                        </div>
                        <div style="text-align:center;width:40%;">
                            <div style="border-top:1px solid #333;padding-top:6px;font-size:12px;">Punong Barangay</div>
                        </div>
                    </div>

                    <!-- Seal watermark -->
                    <div style="text-align:center;margin-top:24px;font-size:11px;color:#aaa;letter-spacing:1px;">— OFFICIAL DOCUMENT —</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modalCertPreview')">Close</button>
                <form id="deleteCertForm" action="backend/action.php" method="post" onsubmit="alert('Print successful!');">
                    <button type="submit" id="pvDeleteBtn" name="delete_cert" class="btn btn-primary"><i class="fa-solid fa-print"></i>&nbsp; Print</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .cert-row:hover { background: var(--gray-50, #f8f9fa); }
        @media print {
            body > *:not(#printRoot) { display: none !important; }
            #printRoot {
                display: block !important;
                position: fixed;
                inset: 0;
                z-index: 99999;
                background: #fff;
                padding: 40px 60px;
            }
        }
    </style>

    <script src="src/index.js"></script>

    <script>
    const certBodies = {
        'Barangay Clearance':
            'This is to certify that <strong>{name}</strong>, a bonafide resident of this barangay, is known to be a person of good moral character and has no derogatory record filed in this office.',
        'Certificate of Residency':
            'This is to certify that <strong>{name}</strong> is a bonafide resident of Barangay Purok ni Bulan. He/She has been residing in this barangay for an extended period of time and is known to be a law-abiding citizen.',
        'Certificate of Indigency':
            'This is to certify that <strong>{name}</strong> is a legitimate resident of this barangay and belongs to an indigent family. This certification is issued upon request of the interested party for whatever legal purpose it may serve.',
        'Business Permit Clearance':
            'This is to certify that <strong>{name}</strong> has been granted a Business Permit Clearance by this barangay. The establishment is duly registered and has complied with the requirements of this office.'
    };

    function openCertPreview(row, event) {
        if (event) event.stopPropagation();

        const id      = row.dataset.id;
        const name    = row.dataset.name;
        const type    = row.dataset.type;
        const purpose = row.dataset.purpose;
        const date    = row.dataset.date;
        const or      = row.dataset.or;

        document.getElementById('pvCertTitle').textContent = type;
        document.getElementById('pvDeleteBtn').value = id;
        document.getElementById('pvPurpose').textContent = purpose;
        document.getElementById('pvDate').textContent = date;
        document.getElementById('pvOR').textContent = or || '—';

        const bodyTpl = certBodies[type] ||
            'This is to certify that <strong>{name}</strong> is a resident of Barangay Purok ni Bulan.';
        document.getElementById('pvBody').innerHTML =
            bodyTpl.replace('{name}', name);

        openModal('modalCertPreview');
    }
    </script>
</body>

</html>