<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Purok ni Buulan | Official Portal</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
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
                <!-- Abstract Glassmorphism Card as a visual placeholder -->
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
                <!-- Card 1 -->
                <div class="news-card">
                    <div class="news-img bg-indigo-light">
                        <i class="fa-solid fa-syringe text-indigo"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fa-regular fa-calendar"></i> May 12, 2026</span>
                            <span class="news-tag tag-urgent">Health</span>
                        </div>
                        <h3>Community Vaccination Drive</h3>
                        <p>A free vaccination drive will be held at the barangay covered court this coming weekend. Please bring your valid IDs.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="news-card">
                    <div class="news-img bg-orange-light">
                        <i class="fa-solid fa-bolt text-orange"></i>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span class="news-date"><i class="fa-regular fa-calendar"></i> May 10, 2026</span>
                            <span class="news-tag tag-warning">Advisory</span>
                        </div>
                        <h3>Scheduled Power Interruption</h3>
                        <p>Please be advised of a scheduled power interruption on Friday, May 15, from 8:00 AM to 5:00 PM for maintenance works.</p>
                    </div>
                </div>
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
                    <a href="../dashboards/dashboard.php" class="btn btn-white btn-lg">Access Portal</a>
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
                    <li><a href="../dashboards/dashboard.php">Portal Login</a></li>
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
