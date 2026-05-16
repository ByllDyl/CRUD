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

        <a class="nav-item" href="analytics.php">
            <span class="nav-icon"><i class="fa-solid fa-chart-bar"></i></span> Analytics
        </a>

        <div class="sidebar-section">Community</div>
        <a class="nav-item active" href="announcements.php">
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

        <!-- ── ANNOUNCEMENTS ── -->
        <div class="page-content active" id="page-announcements">
            <div class="page-header flex items-center">
                <div>
                    <h2>Announcements</h2>
                    <p>Community notices and updates</p>
                </div>
                <button class="btn btn-primary ml-auto" onclick="openModal('modalAnnounce')">+ Post Announcement</button>
            </div>
                <div class="announce-list" id="announceList">
                    <?php
                        $announcement = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC");
                        
                        if(mysqli_num_rows($announcement) == 0){
                            echo '<div class="empty-state"><div class="empty-icon">📢</div><p>No announcements posted</p></div>';
                        }
                        else {
                            $prio = [
                                'Normal' => 'normal',
                                'Urgent' => 'urgent',
                                'Important' => 'important'
                            ];
                            while($a = mysqli_fetch_assoc($announcement)):  
                                $priorityClass = $prio[$a['priority']] ?? 'normal';
                            ?>
                            <div class="announce-card <?php echo $priorityClass !== 'normal' ? $priorityClass : ''; ?>">
                                <div class="flex items-center gap-2 mb-4">
                                    <h4 style="flex:1;"><?= htmlspecialchars($a['title']) ?></h4>
                                    <?php if ($a['priority'] === 'Urgent'): ?>
                                        <span class="badge badge-red">URGENT</span>
                                    <?php elseif ($a['priority'] === 'Important'): ?>
                                        <span class="badge badge-gold">IMPORTANT</span> 
                                    <?php endif; ?>
                                    <form action="backend/action.php" method="post">
                                        <button onclick="return confirm('Are you sure you want to delete this announcement?');"  name="delete_announcement" value="<?php echo $a['id']; ?>" style="background:none;border:none;cursor:pointer;color:var(--gray-400);font-size:16px;padding:0 4px;">✕</button>
                                    </form>
                                </div>
                                <p><?= nl2br(htmlspecialchars($a['content'])) ?></p>
                                <div class="announce-meta">
                                    Posted by <?= htmlspecialchars($a['posted_by']) ?> &middot; 
                                    <?= date('M j, Y', strtotime($a['created_at'])) ?>
                                </div>
                            </div>
                            <?php 
                            endwhile;
                        }
                    ?>
                </div>
            </div>
    </div><!-- /.main -->

    <!-- ──────── MODALS ──────── -->
    <!-- ANNOUNCEMENT -->
    <div class="modal-overlay" id="modalAnnounce">
        <form action="backend/action.php" method="POST">
            <div class="modal">
                <div class="modal-header">
                    <div class="modal-title">Post Announcement</div>
                    <button type="button" class="modal-close" onclick="closeModal('modalAnnounce')">✕</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input class="form-control" name="aTitle" id="aTitle" placeholder="e.g. Barangay Assembly Meeting">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content *</label>
                        <textarea class="form-control" name="aContent" id="aContent" rows="4" placeholder="Write the announcement details..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Priority</label>
                            <select class="form-control" name="aPriority" id="aPriority">
                                <option value="Normal">Normal</option>
                                <option value="Urgent">Urgent</option>
                                <option value="Important">Important</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Posted By</label>
                            <input class="form-control" name="aAuthor" id="aAuthor" value="<?php echo $_SESSION['username']; ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost" onclick="closeModal('modalAnnounce')">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="postAnnouncement">Post</button>
                </div>
            </div>
        </form>
    </div>
    <script src="src/index.js"></script>
</body>

</html>