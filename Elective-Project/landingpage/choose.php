<?php
session_start();
// Redirect to login if not logged in or not admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$name = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Destination - Barangay Purok ni Bulan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary: #4F46E5;
            --primary-hover: #4338ca;
            --primary-light: #EEF2FF;
            --text-main: #0F172A;
            --text-muted: #64748B;
            --white: #FFFFFF;
            --gray-200: #E2E8F0;
            --green: #10B981;
            --green-light: #D1FAE5;
            --radius: 16px;
            --shadow-lg: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2ff 0%, #c7d2fe 100%);
            padding: 40px 20px;
        }

        .choose-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 520px;
            padding: 48px 40px;
            text-align: center;
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-icon {
            width: 64px;
            height: 64px;
            background: var(--primary);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 22px;
            font-weight: 800;
            margin: 0 auto 24px;
            box-shadow: 0 10px 20px rgba(79, 70, 229, 0.3);
        }

        .greeting {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 15px;
            color: var(--text-muted);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        .choice-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .choice-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            padding: 28px 20px;
            border-radius: 12px;
            border: 2px solid var(--gray-200);
            background: var(--white);
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            color: var(--text-main);
        }

        .choice-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .choice-btn.admin-btn {
            border-color: rgba(79, 70, 229, 0.3);
            background: var(--primary-light);
        }

        .choice-btn.admin-btn:hover {
            border-color: var(--primary);
            box-shadow: 0 12px 24px rgba(79, 70, 229, 0.15);
        }

        .choice-btn.portal-btn {
            border-color: rgba(16, 185, 129, 0.3);
            background: var(--green-light);
        }

        .choice-btn.portal-btn:hover {
            border-color: var(--green);
            box-shadow: 0 12px 24px rgba(16, 185, 129, 0.15);
        }

        .choice-icon {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .admin-btn .choice-icon {
            background: var(--primary);
            color: var(--white);
        }

        .portal-btn .choice-icon {
            background: var(--green);
            color: var(--white);
        }

        .choice-label {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        .choice-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .logout-link {
            font-size: 13.5px;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .logout-link:hover {
            color: var(--text-main);
        }

        @media (max-width: 480px) {
            .choose-card { padding: 36px 24px; }
            .choice-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="choose-card">
        <div class="brand-icon">PnB</div>
        <p class="greeting">Welcome back, Admin</p>
        <h1>Hello, <?php echo htmlspecialchars($name); ?>!</h1>
        <p class="subtitle">Where would you like to go today?</p>

        <div class="choice-grid">
            <a href="../dashboards/dashboard.php" class="choice-btn admin-btn">
                <div class="choice-icon">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
                <span class="choice-label">Admin Dashboard</span>
                <span class="choice-sub">Manage records & system</span>
            </a>

            <a href="portal.php" class="choice-btn portal-btn">
                <div class="choice-icon">
                    <i class="fa-solid fa-house-chimney-user"></i>
                </div>
                <span class="choice-label">Resident Portal</span>
                <span class="choice-sub">Browse as a resident</span>
            </a>
        </div>

        <a href="login.php" class="logout-link">
            <i class="fa-solid fa-arrow-left-long"></i> Not you? Sign out
        </a>
    </div>
</body>
</html>
