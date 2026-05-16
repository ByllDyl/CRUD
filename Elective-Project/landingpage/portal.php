<?php
    session_start();
    require_once '../database/config.php';

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $show_animation = false;
    if (isset($_SESSION['just_logged_in']) && $_SESSION['just_logged_in'] === true) {
        $show_animation = true;
        unset($_SESSION['just_logged_in']);
    }

    $ann_sql = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resident Portal - Barangay Purok ni Bulan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="portal.css">
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
        
        .navbar-portal, .portal-container {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .navbar-portal.animate-in, .portal-container.animate-in {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    <div id="intro-overlay">
        <h1>Welcome to the Barangay Purok ni Bulan Portal</h1>
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
                    document.querySelector('.navbar-portal').classList.add('animate-in');
                    document.querySelector('.portal-container').classList.add('animate-in');
                }, 100);
            }, 2500);
        });
    </script>
    <?php endif; ?>

    <nav class="navbar-portal">
        <div class="container flex-between">
            <div class="brand">
                <div class="brand-seal">PnB</div>
                <div class="brand-text">
                    <h1>Barangay Purok ni Bulan</h1>
                </div>
            </div>
            <div class="nav-actions">
                <a href="../dashboards/logout.php" class="btn btn-outline">Logout <i class="fa-solid fa-right-from-bracket"></i></a>
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
                    <?php if (mysqli_num_rows($ann_sql) == 0): ?>
                        <div style="text-align:center;padding:48px 0;color:#94a3b8;">
                            <i class="fa-solid fa-bullhorn" style="font-size:2rem;"></i>
                            <p style="margin-top:12px;">No announcements posted yet.</p>
                        </div>
                    <?php else: ?>
                        <?php while ($ann = mysqli_fetch_assoc($ann_sql)): ?>
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <h3 class="announcement-title">
                                    <?php echo htmlspecialchars($ann['title']); ?>
                                    <?php if ($ann['priority'] === 'Urgent'): ?>
                                        <span style="font-size:11px;font-weight:600;background:#FEE2E2;color:#DC2626;padding:2px 8px;border-radius:20px;margin-left:8px;">URGENT</span>
                                    <?php elseif ($ann['priority'] === 'Important'): ?>
                                        <span style="font-size:11px;font-weight:600;background:#FEF3C7;color:#B45309;padding:2px 8px;border-radius:20px;margin-left:8px;">IMPORTANT</span>
                                    <?php endif; ?>
                                </h3>
                                <span class="announcement-date">
                                    <i class="fa-regular fa-calendar"></i>
                                    <?php echo date('M j, Y', strtotime($ann['created_at'])); ?>
                                    &middot; Posted by <?php echo htmlspecialchars($ann['posted_by']); ?>
                                </span>
                            </div>
                            <p class="announcement-body"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></p>
                        </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Certificates Tab -->
            <div id="certificates" class="tab-pane">
                <h2 class="section-title">Request Certificate</h2>
                <form class="portal-form" action="portalAction.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Type of Certificate</label>
                        <select class="form-select" name="cert_type" required>
                            <option value="" disabled selected>Select certificate type...</option>
                            <option value="Barangay Clearance">Barangay Clearance</option>
                            <option value="Certificate of Indigency">Certificate of Indigency</option>
                            <option value="Certificate of Residency">Certificate of Residency</option>
                            <option value="Business Permit Clearance">Business Permit Clearance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purpose</label>
                        <textarea class="form-textarea" name="purpose" placeholder="State the purpose of your request (e.g. Employment, Scholarship, Financial Assistance...)" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Delivery Method</label>
                        <select class="form-select" name="delivery" required>
                            <option value="Pick-up at Barangay Hall" selected>Pick-up at Barangay Hall</option>
                            <option value="Digital Copy(Email)">Digital Copy (Email)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit_cert">
                        Submit Request <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>

            <!-- Blotter Tab -->
            <div id="blotter" class="tab-pane">
                <h2 class="section-title">Report an Incident (Blotter)</h2>
                <form class="portal-form" action="portalAction.php" method="POST">
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
                        <label class="form-label">Incident Type</label>
                        <select class="form-select" name="incident_type" required>
                            <option value="" disabled selected>Select incident type...</option>
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
                        <label class="form-label">Incident Narrative</label>
                        <textarea class="form-textarea" name="narrative" placeholder="Describe the incident in detail..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit_blotter">
                        Submit Report <i class="fa-solid fa-shield-halved"></i>
                    </button>
                </form>
            </div>

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === 'blotter') {
                alert('✅ Blotter report submitted successfully!');
                history.replaceState(null, '', 'portal.php');
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
                document.querySelector('[data-target="blotter"]').classList.add('active');
                document.getElementById('blotter').classList.add('active');
            }

            const navItems = document.querySelectorAll('.nav-item');
            const tabPanes = document.querySelectorAll('.tab-pane');

            navItems.forEach(item => {
                item.addEventListener('click', () => {
                    navItems.forEach(nav => nav.classList.remove('active'));
                    item.classList.add('active');
                    tabPanes.forEach(pane => pane.classList.remove('active'));
                    const targetId = item.getAttribute('data-target');
                    document.getElementById(targetId).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>
