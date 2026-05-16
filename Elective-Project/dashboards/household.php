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
        <a class="nav-item active" href="household.php">
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

        <!-- ── HOUSEHOLDS ── -->
        <div class="page-content active" id="page-households">
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
                        <form action="backend/action.php" method="post">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Household Head</th>
                                    <th>Address</th>
                                    <th>Purok</th>
                                    <th>Members</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="householdTable">
                                <?php 
                                    $sql_res = mysqli_query($conn, "SELECT * FROM household_records");
                                    while($row = mysqli_fetch_assoc($sql_res)):
                                        $id = $row['id'];
                                        $household_head = $row['household_head'];
                                        $purok_no = $row['purok_no'];
                                        $no_members = $row['no_of_members'];
                                        $complete_address = $row['complete_address'];
                                        $housing_type = $row['housing_type'];
                                        $contact = $row['contact'];
                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $household_head; ?></td>
                                    <td><?php echo $complete_address; ?></td>
                                    <td><?php echo $purok_no; ?></td>
                                    <td><?php echo $no_members; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="viewHousehold(this)" 
                                            data-head="<?php echo htmlspecialchars($household_head); ?>"
                                            data-address="<?php echo htmlspecialchars($complete_address); ?>"
                                            data-purok="<?php echo htmlspecialchars($purok_no); ?>"
                                            data-members="<?php echo htmlspecialchars($no_members); ?>"
                                                data-housing="<?php echo htmlspecialchars($housing_type); ?>"
                                                data-contact="<?php echo htmlspecialchars($contact); ?>">View</button>
                                            <button type="submit" class="btn btn-danger" name="delete_household" value="<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this household?');">Delete</button>
                                        </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </form>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->

    <!-- ADD HOUSEHOLD -->
    <div class="modal-overlay" id="modalHousehold">
        <form action="backend/action.php" method="post">
            <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Register Household</div>
                <button class="modal-close" onclick="closeModal('modalHousehold')">✕</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Household Head (Full Name) *</label>
                    <input class="form-control" name="hhName" id="hhHead" placeholder="Juan Dela Cruz">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Purok *</label>
                        <select class="form-control" name="hhPurok" id="hhPurok">
                            <option value="">Select...</option>
                            <option>Purok 1</option>
                            <option>Purok 2</option>
                            <option>Purok 3</option>
                            <option>Purok 4</option>
                            <option>Purok 5</option>
                            <option>Purok 6</option>
                            <option>Purok 7</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. of Members *</label>
                        <input class="form-control" type="number" name="hhMembers" id="hhMembers" min="1" placeholder="4">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Complete Address *</label>
                    <input class="form-control" name="hhAddress" id="hhAddress" placeholder="House No., Street">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Housing Type</label>
                        <select class="form-control" name="hhHousing" id="hhType">
                            <option>Owned</option>
                            <option>Rented</option>
                            <option>Shared</option>
                            <option>Government Lot</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact</label>
                        <input class="form-control" name="hhContact" id="hhContact" placeholder="09XX XXX XXXX">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modalHousehold')">Cancel</button>
                <button class="btn btn-primary" name="add_household">Save Household</button>
            </div>
        </div>
        </form>
    </div>

    <!-- VIEW HOUSEHOLD -->
    <div class="modal-overlay" id="modalViewHH">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Household Details</div>
                <button class="modal-close" onclick="closeModal('modalViewHH')">✕</button>
            </div>
            <div class="modal-body" id="viewHHBody">
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" onclick="closeModal('modalViewHH')">Close</button>
            </div>
        </div>
    </div>
    <script src="src/index.js"></script>
</body>

</html>