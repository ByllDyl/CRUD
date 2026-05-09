<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Portal - Barangay Purok ni Bulan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="portal.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar-portal">
        <div class="container flex-between">
            <div class="brand">
                <div class="brand-seal">PnB</div>
                <div class="brand-text">
                    <h1>Barangay Purok ni Bulan</h1>
                </div>
            </div>
            <div class="nav-actions">
                <a href="index.php" class="btn btn-outline">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="portal-container">
        
        <!-- Sidebar -->
        <aside class="portal-sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="user-name"><?php echo $_SESSION['username']; ?></div>
                <div class="user-role">Purok 1</div>
            </div>

            <div class="nav-menu">
                <div class="nav-item active" data-target="announcements">
                    <i class="fa-solid fa-bullhorn"></i> Announcements
                </div>
                <div class="nav-item" data-target="certificates">
                    <i class="fa-solid fa-file-signature"></i> Request Certificate
                </div>
                <div class="nav-item" data-target="blotter">
                    <i class="fa-solid fa-scale-balanced"></i> Report Blotter
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="portal-content">
            
            <!-- Announcements Tab -->
            <div id="announcements" class="tab-pane active">
                <h2 class="section-title">Latest Announcements</h2>
                <div class="announcement-list">
                    <div class="announcement-item">
                        <div class="announcement-header">
                            <h3 class="announcement-title">Community Vaccination Drive</h3>
                            <span class="announcement-date"><i class="fa-regular fa-calendar"></i> May 12, 2026</span>
                        </div>
                        <p class="announcement-body">
                            A free vaccination drive will be held at the barangay covered court this coming weekend. Please bring your valid IDs and vaccination cards if available. Open to all residents aged 18 and above.
                        </p>
                    </div>
                    <div class="announcement-item">
                        <div class="announcement-header">
                            <h3 class="announcement-title">Scheduled Power Interruption</h3>
                            <span class="announcement-date"><i class="fa-regular fa-calendar"></i> May 10, 2026</span>
                        </div>
                        <p class="announcement-body">
                            Please be advised of a scheduled power interruption on Friday, May 15, from 8:00 AM to 5:00 PM for maintenance works by the electric cooperative. Plan your activities accordingly.
                        </p>
                    </div>
                    <div class="announcement-item">
                        <div class="announcement-header">
                            <h3 class="announcement-title">Relief Goods Distribution</h3>
                            <span class="announcement-date"><i class="fa-regular fa-calendar"></i> May 08, 2026</span>
                        </div>
                        <p class="announcement-body">
                            The barangay will be distributing relief goods for families affected by the recent typhoon. Please coordinate with your respective Purok Leaders for the schedule of distribution.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Certificates Tab -->
            <div id="certificates" class="tab-pane">
                <h2 class="section-title">Request Certificate</h2>
                <form class="portal-form" action="#" method="POST">
                    <div class="form-group">
                        <label class="form-label">Type of Certificate</label>
                        <select class="form-select" name="cert_type" required>
                            <option value="" disabled selected>Select certificate type...</option>
                            <option value="Clearance">Barangay Clearance</option>
                            <option value="Indigency">Certificate of Indigency</option>
                            <option value="Residency">Certificate of Residency</option>
                            <option value="Business">Business Clearance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purpose</label>
                        <textarea class="form-textarea" name="purpose" placeholder="State the purpose of your request (e.g. Employment, Scholarship, Financial Assistance...)" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Method</label>
                        <select class="form-select" name="delivery" required>
                            <option value="Pickup">Pick-up at Barangay Hall</option>
                            <option value="Digital">Digital Copy (Email)</option>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="alert('Certificate Request Submitted Successfully!')">
                        Submit Request <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Blotter Tab -->
            <div id="blotter" class="tab-pane">
                <h2 class="section-title">Report an Incident (Blotter)</h2>
                <form class="portal-form" action="#" method="POST">
                    <div class="form-group">
                        <label class="form-label">Incident Date & Time</label>
                        <input type="datetime-local" class="form-control" name="incident_date" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Location of Incident</label>
                        <input type="text" class="form-control" name="incident_location" placeholder="e.g. Purok 1, near the basketball court" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Persons Involved (if known)</label>
                        <input type="text" class="form-control" name="persons_involved" placeholder="Names of individuals involved">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Incident Narrative</label>
                        <textarea class="form-textarea" name="narrative" placeholder="Describe the incident in detail..." required></textarea>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="alert('Blotter Report Submitted Successfully!')">
                        Submit Report <i class="fa-solid fa-shield-halved"></i>
                    </button>
                </form>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navItems = document.querySelectorAll('.nav-item');
            const tabPanes = document.querySelectorAll('.tab-pane');

            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    // Remove active class from all nav items
                    navItems.forEach(nav => nav.classList.remove('active'));
                    // Add active class to clicked nav item
                    item.classList.add('active');

                    // Hide all tab panes
                    tabPanes.forEach(pane => pane.classList.remove('active'));
                    
                    // Show target tab pane
                    const targetId = item.getAttribute('data-target');
                    document.getElementById(targetId).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
