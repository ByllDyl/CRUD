<?php
    require_once '../database/config.php';
    $ann_sql = mysqli_query($conn, "SELECT * FROM announcements ORDER BY created_at DESC LIMIT 2");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Purok ni Buulan | Official Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container nav-container">
            <div class="brand">
                <div class="brand-seal">BG</div>
                <div class="brand-text">
                    <h1>Barangay Purok ni Buulan</h1>
                </div>
            </div>
            
            <div class="nav-links">
                <a href="#home" class="active">Home</a>
                <a href="#services">Services</a>
                <a href="#announcements">Announcements</a>
                <a href="#contact">Contact</a>
            </div>

            <div class="nav-actions">
                <a href="login.php" class="btn btn-primary">Portal Login <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            
            <button class="mobile-menu-btn"><i class="fa-solid fa-bars"></i></button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-bg-shape"></div>
        <div class="container hero-container">
            <div class="hero-content">
                <div class="badge-pill">
                    <span class="pulse-dot"></span> Official Barangay Portal
                </div>
                <h1 class="hero-title">Empowering the Community of <span>Purok ni Bulan</span></h1>
                <p class="hero-subtitle">
                    Stay connected, request official documents, and get the latest announcements right at your fingertips. We are bringing barangay services closer to your home.
                </p>
                <div class="hero-buttons">
                    <a href="#services" class="btn btn-primary btn-lg">Explore Services</a>
                    <a href="#announcements" class="btn btn-outline btn-lg">View Updates</a>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-num">5,000+</span>
                        <span class="stat-text">Residents</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">1,200+</span>
                        <span class="stat-text">Households</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">24/7</span>
                        <span class="stat-text">Support</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="glass-card main-glass">
                    <div class="glass-header">
                        <i class="fa-regular fa-file-lines icon-lg"></i>
                        <h3>Fast Certificate Processing</h3>
                    </div>
                    <div class="glass-body">
                        <div class="skeleton-line"></div>
                        <div class="skeleton-line short"></div>
                        <div class="status-badge success">Approved</div>
                    </div>
                </div>
                
                <div class="glass-card float-glass-1">
                    <i class="fa-solid fa-shield-halved text-primary"></i>
                    <div>
                        <h4>Secure Records</h4>
                        <span>Encrypted Data</span>
                    </div>
                </div>

                <div class="glass-card float-glass-2">
                    <i class="fa-solid fa-bullhorn text-orange"></i>
                    <div>
                        <h4>Real-time Updates</h4>
                        <span>Community News</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services section-padding">
        <div class="container">
            <div class="section-header text-center">
                <h2>E-Services Available</h2>
                <p>Request documents and access essential barangay services online without the hassle of long lines.</p>
            </div>
            
            <div class="service-grid">
                <div class="service-card">
                    <div class="service-icon bg-indigo-light text-indigo">
                        <i class="fa-regular fa-id-card"></i>
                    </div>
                    <h3>Barangay Clearance</h3>
                    <p>Request your official barangay clearance for employment, business, or personal requirements easily.</p>
                    <a href="#" class="service-link">Learn More <i class="fa-solid fa-angle-right"></i></a>
                </div>
                
                <div class="service-card">
                    <div class="service-icon bg-green-light text-green">
                        <i class="fa-solid fa-file-signature"></i>
                    </div>
                    <h3>Certificate of Indigency</h3>
                    <p>Apply for a certificate of indigency required for financial assistance, scholarships, and medical aid.</p>
                    <a href="#" class="service-link">Learn More <i class="fa-solid fa-angle-right"></i></a>
                </div>

                <div class="service-card">
                    <div class="service-icon bg-orange-light text-orange">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <h3>Blotter Reporting</h3>
                    <p>Submit a formal complaint or report an incident securely through our online blotter system.</p>
                    <a href="#" class="service-link">Learn More <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Announcements Section -->
    <section id="announcements" class="announcements section-padding bg-gray-50">
        <div class="container">
            <div class="section-header flex-between">
                <div>
                    <h2>Latest Announcements</h2>
                    <p>Stay informed with the latest news and advisories in our barangay.</p>
                </div>
                <a href="#" class="btn btn-outline">View All</a>
            </div>
            
            <div class="announcement-grid">
                <?php
                $icons = ['fa-bullhorn', 'fa-star', 'fa-bell', 'fa-circle-info', 'fa-triangle-exclamation', 'fa-flag'];
                $colors = ['bg-indigo-light text-indigo', 'bg-orange-light text-orange', 'bg-indigo-light text-indigo'];
                $i = 0;
                if (mysqli_num_rows($ann_sql) == 0):
                ?>
                    <div class="news-card" style="grid-column:1/-1;text-align:center;padding:40px;">
                        <i class="fa-solid fa-bullhorn" style="font-size:2rem;color:var(--gray-300);"></i>
                        <p style="margin-top:12px;color:var(--gray-400);">No announcements yet.</p>
                    </div>
                <?php
                else:
                    while ($ann = mysqli_fetch_assoc($ann_sql)):
                        $icon = $icons[$i % count($icons)];
                        $colorClass = $colors[$i % count($colors)];
                        $badgeClass = '';
                        $badgeLabel = '';
                        if ($ann['priority'] === 'Urgent') { $badgeClass = 'tag-urgent'; $badgeLabel = 'Urgent'; }
                        elseif ($ann['priority'] === 'Important') { $badgeClass = 'tag-warning'; $badgeLabel = 'Important'; }
                        $formattedDate = date('M j, Y', strtotime($ann['created_at']));
                        $excerpt = mb_strlen($ann['content']) > 120 ? mb_substr($ann['content'], 0, 120) . '...' : $ann['content'];
                        $i++;
                ?>
                <div class="news-card">
                    <div class="news-img <?php echo $colorClass; ?>">
                        <i class="fa-solid <?php echo $icon; ?>"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fa-regular fa-calendar"></i> <?php echo $formattedDate; ?></span>
                            <?php if ($badgeLabel): ?>
                            <span class="news-tag <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($badgeLabel); ?></span>
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($ann['title']); ?></h3>
                        <p><?php echo htmlspecialchars($excerpt); ?></p>
                    </div>
                </div>
                <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta-section section-padding">
        <div class="container">
            <div class="cta-card">
                <div class="cta-content">
                    <h2>Ready to get started?</h2>
                    <p>Create your account today or log in to the portal to request services and track your documents.</p>
                </div>
                <div class="cta-actions">
                    <a href="login.php" class="btn btn-white btn-lg">Access Portal</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container footer-container">
            <div class="footer-brand">
                <div class="brand">
                    <div class="brand-seal">BG</div>
                    <div class="brand-text">
                        <h1>Barangay Purok ni Buulan</h1>
                    </div>
                </div>
                <p>Dedicated to serving the community with transparency, efficiency, and compassion.</p>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#announcements">Announcements</a></li>
                    <li><a href="login.php">Portal Login</a></li>
                </ul>
            </div>
            
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fa-solid fa-location-dot"></i> Barangay Hall, Poblacion St.</li>
                    <li><i class="fa-solid fa-phone"></i> (123) 456-7890</li>
                    <li><i class="fa-solid fa-envelope"></i> official@brgypoblacion.gov</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container text-center">
                <p>&copy; 2026 Barangay Purok ni Buulan Management System. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
