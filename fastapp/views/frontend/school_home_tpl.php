<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= htmlspecialchars($settings['school_name'] ?? 'RRSV School', ENT_QUOTES, 'UTF-8') ?> - Empowering Young Minds</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Official website of RRSV School. Providing holistic education, modern facilities, and academic brilliance.">

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome & Bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>backend/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>backend/dist/css/font-awesome.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #e0e7ff;
            --secondary: #06b6d4;
            --accent: #f59e0b;
            --dark: #0f172a;
            --dark-muted: #334155;
            --light-bg: #f8fafc;
            --card-border: #e2e8f0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #334155;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Outfit', sans-serif;
            color: var(--dark);
        }

        /* 1. Top Bar */
        .topbar {
            background-color: #0f172a;
            color: #94a3b8;
            font-size: 13px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .topbar a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }
        .topbar a:hover {
            color: #ffffff;
        }
        .notice-ticker {
            display: inline-flex;
            align-items: center;
            overflow: hidden;
            white-space: nowrap;
        }
        .notice-tag {
            background: #ef4444;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            margin-right: 10px;
            text-transform: uppercase;
        }

        /* 2. Navigation */
        .navbar-custom {
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        .nav-logo-box {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
        }
        .nav-logo-box img {
            height: 48px;
            width: auto;
        }
        .nav-school-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
            line-height: 1.1;
        }
        .nav-school-sub {
            font-size: 11px;
            color: #64748b;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .nav-link-custom {
            color: #1e293b;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 16px !important;
            transition: color 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .nav-link-custom:hover {
            color: var(--primary);
        }
        .btn-portal-login {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #ffffff !important;
            font-weight: 600;
            font-size: 13px;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        .btn-portal-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(79, 70, 229, 0.45);
        }

        /* 3. Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            color: #ffffff;
            padding: 85px 0 100px;
            position: relative;
            overflow: hidden;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .hero-title {
            font-size: 46px;
            font-weight: 800;
            line-height: 1.15;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .hero-subtitle {
            font-size: 18px;
            color: #c7d2fe;
            margin-bottom: 35px;
            font-weight: 400;
            max-width: 600px;
        }
        .btn-hero-primary {
            background: #ffffff;
            color: var(--primary-dark);
            font-weight: 700;
            padding: 14px 30px;
            border-radius: 6px;
            text-decoration: none !important;
            font-size: 15px;
            display: inline-block;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.2s;
        }
        .btn-hero-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            color: var(--primary);
        }
        .btn-hero-outline {
            border: 2px solid rgba(255, 255, 255, 0.6);
            color: #ffffff;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none !important;
            font-size: 15px;
            display: inline-block;
            margin-left: 12px;
            transition: all 0.2s;
        }
        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        /* 4. Stat Bar */
        .stat-bar {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: -50px;
            position: relative;
            z-index: 10;
            padding: 30px 20px;
            border: 1px solid var(--card-border);
        }
        .stat-item {
            text-align: center;
            border-right: 1px solid #e2e8f0;
        }
        .stat-item:last-child {
            border-right: none;
        }
        .stat-num {
            font-size: 32px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 6px;
        }
        .stat-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
        }

        /* 5. Section Basics */
        .section-padding {
            padding: 80px 0;
        }
        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-tag {
            color: var(--primary);
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }
        .section-title {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 12px;
        }
        .section-desc {
            color: #64748b;
            font-size: 16px;
            max-width: 650px;
            margin: 0 auto;
        }

        /* 6. Notice Cards */
        .notice-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 22px;
            margin-bottom: 20px;
            transition: all 0.25s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            gap: 16px;
        }
        .notice-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }
        .notice-date-box {
            background: #eef2ff;
            color: var(--primary);
            border-radius: 8px;
            padding: 10px 14px;
            text-align: center;
            min-width: 70px;
            height: fit-content;
        }
        .notice-date-day {
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
        }
        .notice-date-month {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .notice-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }
        .notice-text {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }

        /* 7. Event Cards */
        .event-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.04);
            margin-bottom: 25px;
            transition: all 0.25s;
        }
        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.09);
        }
        .event-card-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            color: #ffffff;
            padding: 18px 20px;
        }
        .event-card-body {
            padding: 20px;
        }

        /* 8. Gallery Grid */
        .gallery-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            position: relative;
            background: #f1f5f9;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .gallery-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        }
        .gallery-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, transparent 100%);
            padding: 16px;
            color: #ffffff;
        }

        /* 9. Feature Box */
        .feature-box {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 30px 24px;
            text-align: center;
            margin-bottom: 25px;
            transition: all 0.25s;
        }
        .feature-box:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.1);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: #eef2ff;
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 18px;
        }

        /* 10. Footer */
        .site-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 70px 0 30px;
            font-size: 14px;
        }
        .footer-heading {
            color: #ffffff;
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-links li {
            margin-bottom: 10px;
        }
        .footer-links a {
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-links a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- 1. TOP BAR -->
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-7 col-sm-12">
                    <div class="notice-ticker">
                        <span class="notice-tag">Notice</span>
                        <?php if (!empty($notices)): ?>
                            <span><?= htmlspecialchars($notices[0]['title'] ?? '', ENT_QUOTES, 'UTF-8') ?> (<?= date('d M Y', strtotime($notices[0]['notice_date'])) ?>)</span>
                        <?php else: ?>
                            <span>Admissions Open for Academic Session 2026-27</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 text-right">
                    <span><i class="fa fa-phone" style="margin-right: 5px;"></i> <?= htmlspecialchars($settings['contact_phone'] ?? '+91 98765 43210', ENT_QUOTES, 'UTF-8') ?></span>
                    <span style="margin: 0 10px;">|</span>
                    <span><i class="fa fa-envelope" style="margin-right: 5px;"></i> <?= htmlspecialchars($settings['contact_us_email'] ?? 'info@rrsvschool.edu', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. NAVBAR -->
    <nav class="navbar-custom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center" style="display: flex; justify-content: space-between; align-items: center;">
                <!-- Brand -->
                <a href="<?= base_url() ?>" class="nav-logo-box">
                    <img src="<?= base_url() ?>backend/images/s_logo.png" alt="RRSV School" onerror="this.src='<?= base_url() ?>uploads/school_content/logo/1.png'">
                    <div>
                        <div class="nav-school-title"><?= htmlspecialchars($settings['school_name'] ?? 'RRSV School', ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="nav-school-sub">Recognized Institution</div>
                    </div>
                </a>

                <!-- Navigation Links -->
                <div class="d-none d-md-flex align-items-center" style="display: flex; align-items: center; gap: 8px;">
                    <a href="#home" class="nav-link-custom">Home</a>
                    <a href="#about" class="nav-link-custom">About Us</a>
                    <a href="#notices" class="nav-link-custom">Notices</a>
                    <a href="#events" class="nav-link-custom">Events</a>
                    <a href="#gallery" class="nav-link-custom">Gallery</a>
                    <a href="#admissions" class="nav-link-custom">Admissions</a>
                    <a href="#contact" class="nav-link-custom">Contact</a>
                    <a href="<?= console_url('user/login') ?>" class="btn-portal-login">
                        <i class="fa fa-lock"></i> Portal Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- 3. HERO BANNER -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <div class="hero-badge">
                        <i class="fa fa-graduation-cap"></i> Admissions Open 2026 - 2027
                    </div>
                    <h1 class="hero-title">
                        <?= htmlspecialchars($settings['banner_title'] ?? 'Empowering Young Minds for Excellence', ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    <p class="hero-subtitle">
                        <?= htmlspecialchars($settings['banner_subtitle'] ?? 'A premier educational institution fostering academic brilliance, leadership, and moral values since 2010.', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <div style="margin-top: 30px;">
                        <a href="#admissions" class="btn-hero-primary">
                            <i class="fa fa-pencil-square-o"></i> Apply for Admission
                        </a>
                        <a href="#about" class="btn-hero-outline">
                            <i class="fa fa-compass"></i> Discover Campus
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <div style="background: rgba(255,255,255,0.1); border-radius: 16px; padding: 40px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="fa fa-institution" style="font-size: 80px; color: #ffffff; margin-bottom: 20px;"></i>
                        <h3 style="color: #fff; font-weight: 700; margin-bottom: 10px;">Excellence in Education</h3>
                        <p style="color: #e0e7ff; font-size: 14px; margin: 0;">Comprehensive curriculum with smart digital classrooms, sports training, and individual student care.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. STAT COUNTERS -->
    <div class="container">
        <div class="stat-bar">
            <div class="row">
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-num">500+</div>
                    <div class="stat-label">Students Enrolled</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-num">35+</div>
                    <div class="stat-label">Expert Faculty</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-num">100%</div>
                    <div class="stat-label">Board Success</div>
                </div>
                <div class="col-md-3 col-6 stat-item">
                    <div class="stat-num">15+</div>
                    <div class="stat-label">Years of Trust</div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. ABOUT SCHOOL -->
    <section class="section-padding" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="section-tag">About Our School</span>
                    <h2 class="section-title">Nurturing Leaders of Tomorrow</h2>
                    <p style="color: #475569; font-size: 15px; margin-bottom: 20px;">
                        <?= htmlspecialchars($settings['school_name'] ?? 'RRSV School', ENT_QUOTES, 'UTF-8') ?> provides a safe, nurturing, and intellectually challenging environment that empowers students to achieve their full academic, emotional, and social potential.
                    </p>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <strong style="color: var(--primary);"><i class="fa fa-check-circle"></i> Digital Smart Class</strong>
                            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Interactive teaching aids & multimedia learning modules.</p>
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <strong style="color: var(--primary);"><i class="fa fa-check-circle"></i> Modern Science Labs</strong>
                            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Hands-on practical experiments for deep understanding.</p>
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <strong style="color: var(--primary);"><i class="fa fa-check-circle"></i> Athletic Complex</strong>
                            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Extensive grounds for sports, football, and physical fitness.</p>
                        </div>
                        <div class="col-sm-6" style="margin-bottom: 15px;">
                            <strong style="color: var(--primary);"><i class="fa fa-check-circle"></i> Holistic Values</strong>
                            <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Moral ethics, leadership workshops, and civic awareness.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div style="background: #eef2ff; border-radius: 16px; padding: 40px; border: 1px dashed var(--primary);">
                        <i class="fa fa-book" style="font-size: 64px; color: var(--primary); margin-bottom: 20px;"></i>
                        <h4 style="font-weight: 700; color: #1e1b4b;">Principal's Message</h4>
                        <p style="font-style: italic; color: #4b5563; font-size: 14px; margin-bottom: 15px;">
                            "Education is not the learning of facts, but the training of the mind to think. We welcome you to experience an education of lifelong value at RRSV School."
                        </p>
                        <strong style="color: var(--primary-dark); font-size: 14px;">- Administration & Faculty Desk</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. LATEST NOTICES (Live from rrsv_notice) -->
    <section class="section-padding" style="background: #f8fafc;" id="notices">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Announcements</span>
                <h2 class="section-title">Official School Notices</h2>
                <p class="section-desc">Stay informed with real-time official notices, examination dates, and administrative circulars.</p>
            </div>

            <div class="row">
                <?php if (empty($notices)): ?>
                    <div class="col-12 text-center text-muted">No notices published at the moment.</div>
                <?php else: ?>
                    <?php foreach (array_slice($notices, 0, 6) as $nt): ?>
                    <div class="col-md-6">
                        <div class="notice-card">
                            <div class="notice-date-box">
                                <div class="notice-date-day"><?= date('d', strtotime($nt['notice_date'])) ?></div>
                                <div class="notice-date-month"><?= date('M', strtotime($nt['notice_date'])) ?></div>
                            </div>
                            <div>
                                <div class="notice-title"><?= htmlspecialchars($nt['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                <p class="notice-text">
                                    <?= !empty($nt['description']) ? htmlspecialchars(substr($nt['description'], 0, 110), ENT_QUOTES, 'UTF-8') : 'Official circular issued by school administration.' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 7. UPCOMING EVENTS (Live from rrsv_event) -->
    <section class="section-padding" id="events">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Activities & Gatherings</span>
                <h2 class="section-title">Upcoming School Events</h2>
                <p class="section-desc">Celebrate learning, teamwork, and milestones across our campus.</p>
            </div>

            <div class="row">
                <?php if (empty($events)): ?>
                    <div class="col-12 text-center text-muted">No scheduled events at this time.</div>
                <?php else: ?>
                    <?php foreach (array_slice($events, 0, 3) as $ev): ?>
                    <div class="col-md-4">
                        <div class="event-card">
                            <div class="event-card-header">
                                <div style="font-size: 12px; opacity: 0.9; text-transform: uppercase;">Date of Event</div>
                                <div style="font-size: 18px; font-weight: 700;"><?= date('l, d M Y', strtotime($ev['d_o_e'])) ?></div>
                            </div>
                            <div class="event-card-body">
                                <h4 style="font-size: 17px; font-weight: 700; margin-bottom: 10px;"><?= htmlspecialchars($ev['event_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                <p style="color: #64748b; font-size: 13px; margin: 0;">
                                    <?= !empty($ev['event_desc']) ? htmlspecialchars(substr($ev['event_desc'], 0, 120), ENT_QUOTES, 'UTF-8') : 'School activity and general meeting.' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 8. PHOTO GALLERY (Live from rrsv_gallery) -->
    <section class="section-padding" style="background: #f8fafc;" id="gallery">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Campus Life</span>
                <h2 class="section-title">Campus Photo Gallery</h2>
                <p class="section-desc">A glimpse into our classrooms, sports tournaments, laboratory experiments, and ceremonies.</p>
            </div>

            <div class="row">
                <?php if (empty($gallery)): ?>
                    <div class="col-12 text-center text-muted">No gallery photos added yet.</div>
                <?php else: ?>
                    <?php foreach (array_slice($gallery, 0, 6) as $img): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="gallery-card">
                            <i class="fa fa-image" style="font-size: 48px; color: #a5b4fc;"></i>
                            <div class="gallery-overlay">
                                <strong style="display: block; font-size: 14px;"><?= htmlspecialchars($img['title'] ?? 'Campus Activity', ENT_QUOTES, 'UTF-8') ?></strong>
                                <span style="font-size: 11px; opacity: 0.8;"><?= $img['category'] ?? 'Campus' ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 9. ADMISSION INQUIRY -->
    <section class="section-padding" id="admissions">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="section-tag">Enrollment</span>
                    <h2 class="section-title">Admissions Open 2026-27</h2>
                    <p style="color: #475569; font-size: 15px; margin-bottom: 25px;">
                        Give your child the foundation for a lifetime of success. Admissions are currently open from Nursery to Standard 5. Limited seats available per class.
                    </p>
                    <div style="background: #f1f5f9; border-radius: 8px; padding: 20px; border-left: 4px solid var(--primary);">
                        <h5 style="font-weight: 700; margin: 0 0 6px;">Admission Helpdesk</h5>
                        <p style="margin: 0; font-size: 14px; color: #64748b;">
                            Call: <strong><?= htmlspecialchars($settings['contact_phone'] ?? '+91 98765 43210', ENT_QUOTES, 'UTF-8') ?></strong><br>
                            Email: <strong><?= htmlspecialchars($settings['contact_us_email'] ?? 'info@rrsvschool.edu', ENT_QUOTES, 'UTF-8') ?></strong>
                        </p>
                    </div>
                </div>
                <div class="col-md-6" id="contact">
                    <div style="background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); border: 1px solid var(--card-border);">
                        <h4 style="font-weight: 700; margin-bottom: 20px;"><i class="fa fa-envelope-o text-primary"></i> Quick Inquiry Form</h4>
                        <form onsubmit="alert('Thank you for your inquiry! Our admission office will get back to you shortly.'); return false;">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="font-weight: 600; font-size: 13px;">Parent / Guardian Name *</label>
                                <input type="text" class="form-control" required placeholder="Full Name">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="font-weight: 600; font-size: 13px;">Mobile Phone Number *</label>
                                <input type="tel" class="form-control" required placeholder="Mobile Number">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="font-weight: 600; font-size: 13px;">Applying for Class *</label>
                                <select class="form-control">
                                    <option>NURSERY</option>
                                    <option>KINDER GARDEN</option>
                                    <option>Class 1 / STANDERD 1</option>
                                    <option>STANDERD 2</option>
                                    <option>STANDERD 3</option>
                                    <option>STANDERD 4</option>
                                    <option>STANDERD 5</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-portal-login" style="width: 100%; justify-content: center; padding: 12px;">
                                Submit Admission Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 10. FOOTER -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12" style="margin-bottom: 30px;">
                    <div style="font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 12px;">
                        <?= htmlspecialchars($settings['school_name'] ?? 'RRSV School', ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <p style="color: #94a3b8; font-size: 13px; max-width: 350px;">
                        Committed to building a foundation of knowledge, values, and character for the next generation.
                    </p>
                    <p style="color: #94a3b8; font-size: 13px;">
                        <i class="fa fa-map-marker" style="margin-right: 8px;"></i> <?= htmlspecialchars($settings['school_address'] ?? 'RRSV Campus, Main Road', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                <div class="col-md-3 col-6" style="margin-bottom: 30px;">
                    <div class="footer-heading">Quick Links</div>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About School</a></li>
                        <li><a href="#notices">Notice Board</a></li>
                        <li><a href="#events">School Events</a></li>
                        <li><a href="#gallery">Photo Gallery</a></li>
                        <li><a href="#admissions">Admissions</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-6" style="margin-bottom: 30px;">
                    <div class="footer-heading">Portals & Administration</div>
                    <ul class="footer-links">
                        <li><a href="<?= console_url('user/login') ?>"><i class="fa fa-lock"></i> Staff & Admin Login</a></li>
                        <li><a href="<?= console_url('student') ?>"><i class="fa fa-users"></i> Student Management</a></li>
                        <li><a href="<?= console_url('role/permission/1') ?>"><i class="fa fa-key"></i> Roles & Permissions</a></li>
                        <li><a href="<?= console_url('frontcms') ?>"><i class="fa fa-desktop"></i> Front CMS Manager</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.08); margin: 30px 0 20px;">
            <div class="row align-items-center">
                <div class="col-md-6 col-sm-12">
                    <p style="margin: 0; font-size: 12px; color: #64748b;">
                        <?= htmlspecialchars($settings['footer_text'] ?? '© 2026 RRSV School. All Rights Reserved.', ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <span style="font-size: 12px; color: #64748b;">Powered by RRSV Smart School CMS</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery & Bootstrap Scripts -->
    <script src="<?= base_url() ?>backend/custom/jquery.min.js"></script>
    <script src="<?= base_url() ?>backend/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
