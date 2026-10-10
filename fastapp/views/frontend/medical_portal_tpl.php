<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= htmlspecialchars($site_title ?? 'MedPulse Pharmacy & Healthcare Portal', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="MedPulse Pharmacy & Healthcare - Search 17,900+ genuine medicines, book top doctors, and order online with express 2-hour doorstep delivery.">
    <meta name="keywords" content="pharmacy, medicines, online medicine order, doctor consultation, prescription upload, medical store, generic medicine">

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons (v6 + fallback) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('backend/dist/css/font-awesome.min.css') ?>">

    <!-- MedPulse Custom Design System CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/frontend/css/medical_portal.css') ?>">
</head>
<body>

    <!-- 1. TOP ANNOUNCEMENT & EMERGENCY BAR -->
    <div class="topbar">
        <div class="container">
            <div class="topbar-left">
                <span class="topbar-badge"><span class="pulse-dot"></span> <?= htmlspecialchars($announcement ?? 'Pharmacy Open 24/7', ENT_QUOTES, 'UTF-8') ?></span>
                <span><i class="fa fa-phone-alt"></i> Emergency Helpline: <a href="tel:<?= $contact['helpline'] ?>"><strong><?= $contact['helpline'] ?></strong></a></span>
                <span><i class="fa fa-truck-fast"></i> <?= htmlspecialchars($delivery_badge ?? 'Express 2-Hour Doorstep Delivery', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="topbar-right">
                <span><i class="fa fa-shield-halved"></i> 100% Genuine Certified Stock</span>
                <a href="<?= base_url('console') ?>" title="Pharmacy Staff & Management Login"><i class="fa fa-lock"></i> Staff Console</a>
            </div>
        </div>
    </div>

    <!-- 2. STICKY GLASSMORPHIC NAVBAR -->
    <header class="header-sticky">
        <div class="container">
            <nav class="navbar">
                <!-- Brand Logo -->
                <a href="<?= base_url() ?>" class="brand-logo">
                    <div class="brand-icon-box">
                        <i class="fa-solid fa-notes-medical"></i>
                    </div>
                    <div class="brand-text">
                        <div class="brand-name">Med<span>Pulse</span></div>
                        <div class="brand-sub">Pharmacy & Healthcare</div>
                    </div>
                </a>

                <!-- Nav Menu -->
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#home" class="nav-link active">Home</a></li>
                    <li><a href="#medicines-catalog" class="nav-link">Medicines</a></li>
                    <li><a href="#categories" class="nav-link">Categories</a></li>
                    <li><a href="#doctors" class="nav-link">Find Doctors</a></li>
                    <li><a href="#services" class="nav-link">Services</a></li>
                    <li><a href="#contact" class="nav-link">Contact</a></li>
                </ul>

                <!-- Nav Actions -->
                <div class="nav-actions">
                    <button class="btn btn-primary btn-sm" onclick="openRxModal()">
                        <i class="fa-solid fa-file-prescription"></i> Upload Rx
                    </button>
                    <a href="tel:<?= $contact['helpline'] ?>" class="btn btn-secondary btn-sm" title="Call Pharmacy">
                        <i class="fa-solid fa-phone"></i> Call
                    </a>
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <!-- 3. HERO SECTION -->
    <section class="hero-section" id="home">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        <div class="container">
            <div class="hero-grid">
                <!-- Left: Content & Live Search -->
                <div class="hero-content">
                    <div class="hero-pill">
                        <span class="pulse-dot"></span>
                        Govt. Licensed Pharmacy &bull; Reg #WB-PHARM-2024
                    </div>
                    <h1 class="hero-title">
                        Genuine Medicines &amp; <br>
                        <span class="gradient-text">Healthcare at Your Doorstep</span>
                    </h1>
                    <p class="hero-desc">
                        Search across <strong><?= $stats['medicines'] ?></strong> genuine pharmaceutical drugs, connect with <strong><?= $stats['doctors'] ?>+ certified specialists</strong>, or quickly upload your doctor's prescription for guaranteed authentic doorstep delivery.
                    </p>

                    <!-- Hero Live Search Component -->
                    <div class="hero-search-wrapper" id="heroSearchWrapper">
                        <select class="search-category-select" id="searchCategorySelect" aria-label="Select Category">
                            <option value="">All Categories</option>
                            <option value="TABLET">Tablets</option>
                            <option value="SYRUP">Syrups</option>
                            <option value="CAPSULE">Capsules</option>
                            <option value="INJECTION">Injections</option>
                            <option value="CREAM">Creams &amp; Ointments</option>
                            <option value="DROPS">Drops</option>
                            <option value="INHALER">Inhalers</option>
                        </select>
                        <div class="search-input-box">
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                            <input type="text" id="heroSearchInput" class="hero-search-input" placeholder="Search by medicine name, brand, or manufacturer..." autocomplete="off">
                            <button type="button" class="search-clear-btn" id="searchClearBtn" title="Clear search">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary" id="heroSearchSubmitBtn" type="button">
                            <i class="fa-solid fa-search"></i> Search
                        </button>

                        <!-- Autocomplete Dropdown Popover -->
                        <div class="search-results-dropdown" id="searchResultsDropdown"></div>
                    </div>

                    <!-- Quick Search Popular Tags -->
                    <div class="quick-search-tags">
                        <span><i class="fa-solid fa-fire text-amber"></i> Popular Searches:</span>
                        <span class="tag-pill" onclick="quickFillSearch('PARACIN')">Paracetamol</span>
                        <span class="tag-pill" onclick="quickFillSearch('GLUCONORM')">Gluconorm</span>
                        <span class="tag-pill" onclick="quickFillSearch('ALLEGRA')">Allegra</span>
                        <span class="tag-pill" onclick="quickFillSearch('NODOSIS')">Nodosis</span>
                        <span class="tag-pill" onclick="quickFillSearch('PEGALUP')">Pegalup Syrup</span>
                        <span class="tag-pill" onclick="quickFillSearch('ADMENTA')">Admenta</span>
                    </div>
                </div>

                <!-- Right: Quick Prescription Fast-Track Card -->
                <div class="hero-prescription-card">
                    <div class="rx-card-header">
                        <div class="rx-card-title">
                            <h3><i class="fa-solid fa-receipt text-teal"></i> Upload Prescription</h3>
                            <p>Get authentic medicines delivered in 2 hours</p>
                        </div>
                        <div class="rx-discount-badge">
                            <i class="fa-solid fa-bolt"></i> Flat 20% OFF
                        </div>
                    </div>

                    <!-- Drag & Drop Zone -->
                    <div class="rx-drop-zone" id="heroDropZone" onclick="openRxModal()">
                        <div class="rx-drop-icon">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <div class="rx-drop-text">Click or Drag Prescription Here</div>
                        <div class="rx-drop-sub">Supports JPG, PNG, WEBP or PDF (Max 12MB)</div>
                    </div>

                    <div class="rx-fast-bullets">
                        <div class="rx-bullet-item"><i class="fa-solid fa-circle-check"></i> Registered Pharmacist Review</div>
                        <div class="rx-bullet-item"><i class="fa-solid fa-circle-check"></i> 100% Genuine Sealed Drugs</div>
                        <div class="rx-bullet-item"><i class="fa-solid fa-circle-check"></i> Free Dosage Consultation</div>
                        <div class="rx-bullet-item"><i class="fa-solid fa-circle-check"></i> Cold-Chain Delivery</div>
                    </div>

                    <button class="btn btn-primary" style="width: 100%;" onclick="openRxModal()">
                        <i class="fa-solid fa-camera"></i> Upload &amp; Order Prescription
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. LIVE METRICS COUNTER STRIP -->
    <div class="stats-strip">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-pills"></i></div>
                    <div class="stat-info">
                        <h4><?= $stats['medicines'] ?></h4>
                        <p>Genuine Medicines in Catalog</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
                    <div class="stat-info">
                        <h4><?= $stats['doctors'] ?>+</h4>
                        <p>Specialist Doctors Available</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-truck-medical"></i></div>
                    <div class="stat-info">
                        <h4>2 Hours</h4>
                        <p>Express Doorstep Delivery</p>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="stat-info">
                        <h4>24 / 7</h4>
                        <p>Round-the-Clock Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. MEDICINE CATEGORIES SECTION -->
    <section class="section" id="categories">
        <div class="container">
            <div class="section-head">
                <span class="section-subtitle"><i class="fa-solid fa-shapes"></i> Browse by Form</span>
                <h2 class="section-title">Explore Medicine Categories</h2>
                <p class="section-desc">Browse through our comprehensively categorized catalog of verified pharmaceuticals, clinical supplies, and healthcare essentials.</p>
            </div>

            <div class="categories-grid">
                <?php foreach (array_slice($categories, 0, 12) as $category): ?>
                    <div class="category-card" onclick="filterCatalogByCategory('<?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>')">
                        <div class="category-icon-box" style="background: <?= $category['color'] ?>15; color: <?= $category['color'] ?>;">
                            <i class="fa-solid <?= $category['icon'] ?>"></i>
                        </div>
                        <div class="category-title"><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></div>
                        <div class="category-desc"><?= htmlspecialchars($category['desc'], ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 6. LIVE MEDICINE CATALOG & SEARCH RESULTS -->
    <section class="section section-bg-alt" id="medicines-catalog">
        <div class="container">
            <div class="section-head">
                <span class="section-subtitle"><i class="fa-solid fa-prescription-bottle-medical"></i> Authentic Inventory</span>
                <h2 class="section-title">Featured Medicines Catalog</h2>
                <p class="section-desc">Search, filter, and quick-order certified prescription drugs and over-the-counter essentials with batch verification.</p>
            </div>

            <!-- Catalog Toolbar -->
            <div class="catalog-toolbar">
                <div class="catalog-filter-tabs" id="catalogFilterTabs">
                    <button class="filter-tab active" data-category="all" onclick="filterCatalog('all', this)">All Medicines</button>
                    <button class="filter-tab" data-category="TABLET" onclick="filterCatalog('TABLET', this)">Tablets</button>
                    <button class="filter-tab" data-category="SYRUP" onclick="filterCatalog('SYRUP', this)">Syrups</button>
                    <button class="filter-tab" data-category="CAPSULE" onclick="filterCatalog('CAPSULE', this)">Capsules</button>
                    <button class="filter-tab" data-category="INJECTION" onclick="filterCatalog('INJECTION', this)">Injections</button>
                    <button class="filter-tab" data-category="CREAM" onclick="filterCatalog('CREAM', this)">Creams &amp; Ointments</button>
                    <button class="filter-tab" data-category="DROPS" onclick="filterCatalog('DROPS', this)">Drops</button>
                </div>

                <div class="catalog-search-box">
                    <i class="fa-solid fa-filter"></i>
                    <input type="text" id="catalogSearchInput" placeholder="Filter medicines in view...">
                </div>
            </div>

            <!-- Medicines Grid -->
            <div class="medicines-grid" id="medicinesGrid">
                <?php foreach ($featured_medicines as $med): ?>
                    <div class="medicine-card" data-name="<?= strtolower(htmlspecialchars($med['medicine_name'], ENT_QUOTES, 'UTF-8')) ?>" data-category="<?= strtoupper(htmlspecialchars($med['medicine_category'], ENT_QUOTES, 'UTF-8')) ?>">
                        <div class="med-header">
                            <span class="med-category-pill"><?= htmlspecialchars($med['medicine_category'] ?: 'GENERAL', ENT_QUOTES, 'UTF-8') ?></span>
                            <?php if (!empty($med['medicine_schedule'])): ?>
                                <span class="med-schedule-pill"><?= htmlspecialchars($med['medicine_schedule'], ENT_QUOTES, 'UTF-8') ?></span>
                            <?php else: ?>
                                <span class="badge badge-emerald"><i class="fa-solid fa-check"></i> Genuine</span>
                            <?php endif; ?>
                        </div>

                        <div class="med-name"><?= htmlspecialchars($med['medicine_name'], ENT_QUOTES, 'UTF-8') ?></div>
                        
                        <div class="med-manufacturer">
                            <i class="fa-solid fa-industry"></i>
                            <span><?= htmlspecialchars($med['medicine_manufacturer'] ?: 'Verified Manufacturer', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>

                        <div class="med-specs">
                            <div class="med-specs-item">
                                <i class="fa-solid fa-box-archive"></i>
                                <span>Unit: <?= intval($med['medicine_unit']) > 0 ? intval($med['medicine_unit']) : '10' ?>s</span>
                            </div>
                            <div class="med-specs-item">
                                <i class="fa-solid fa-temperature-low"></i>
                                <span><?= htmlspecialchars($med['medicine_storage'] ?: 'Cool & Dry', ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                        </div>

                        <div class="med-footer">
                            <div class="med-price-box">
                                <span class="med-price-label">Verified MRP</span>
                                <span class="med-price-val">Best Price</span>
                            </div>
                            <div class="med-actions">
                                <button class="btn btn-outline btn-sm" onclick="openDetailsModal(<?= $med['medicine_id'] ?>)" title="View Specifications">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="openOrderModal(<?= $med['medicine_id'] ?>, '<?= addslashes($med['medicine_name']) ?>')">
                                    <i class="fa-solid fa-bag-shopping"></i> Order
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Empty Search State -->
            <div id="catalogEmptyState" style="display: none; text-align: center; padding: 60px 20px;">
                <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 3rem; margin-bottom: 16px;"></i>
                <h3>No medicines found matching your query</h3>
                <p class="text-muted">Try searching with a generic drug name, active salt, or check another category.</p>
                <button class="btn btn-secondary mt-3" onclick="resetCatalogFilters()">Reset Filters</button>
            </div>
        </div>
    </section>

    <!-- 7. DOCTOR DIRECTORY & CONSULTATION BOOKING -->
    <section class="section" id="doctors">
        <div class="container">
            <div class="section-head">
                <span class="section-subtitle"><i class="fa-solid fa-user-doctor"></i> Medical Experts</span>
                <h2 class="section-title">Consult Certified Doctors</h2>
                <p class="section-desc">Connect with our panel of over 600+ experienced physicians, surgeons, and specialists for expert diagnosis, prescription validation, and clinic consultations.</p>
            </div>

            <div class="doctors-grid">
                <?php foreach ($doctors as $doctor): ?>
                    <div class="doctor-card">
                        <div class="doctor-profile-top">
                            <div class="doctor-avatar">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div>
                                <div class="doctor-name"><?= htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8') ?></div>
                                <div class="doctor-specialty"><?= htmlspecialchars($doctor['specialty'], ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                        </div>

                        <ul class="doctor-details-list">
                            <li><i class="fa-solid fa-certificate"></i> Verified Medical Practitioner</li>
                            <li><i class="fa-solid fa-briefcase"></i> <?= $doctor['experience'] ?></li>
                            <li><i class="fa-solid fa-calendar-check"></i> <?= $doctor['availability'] ?></li>
                        </ul>

                        <div style="margin-top: auto;">
                            <button class="btn btn-secondary" style="width: 100%;" onclick="openConsultationModal(<?= $doctor['id'] ?>, '<?= addslashes($doctor['name']) ?>', '<?= addslashes($doctor['specialty']) ?>')">
                                <i class="fa-solid fa-calendar-plus"></i> Book Consultation
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- 8. WHY CHOOSE MEDPULSE & CLINICAL SERVICES -->
    <section class="section section-bg-alt" id="services">
        <div class="container">
            <div class="section-head">
                <span class="section-subtitle"><i class="fa-solid fa-heart-pulse"></i> Patient Care First</span>
                <h2 class="section-title">Comprehensive Pharmacy Services</h2>
                <p class="section-desc">We bridge modern digital healthcare with trusted clinical expertise to provide reliable pharmacy care 24 hours a day.</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-truck-fast"></i></div>
                    <h4>2-Hour Express Delivery</h4>
                    <p>Temperature-controlled delivery right to your doorstep within 120 minutes. All packages are sealed and tamper-proof.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-shield-virus"></i></div>
                    <h4>100% Genuine Guarantee</h4>
                    <p>Every single strip, vial, and syrup is procured directly from licensed manufacturers and certified pharmaceutical distributors.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <h4>Generic Alternative Savings</h4>
                    <p>Our pharmacists help you choose bio-equivalent generic formulations to save up to 70% on recurring monthly medical bills.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-user-nurse"></i></div>
                    <h4>Pharmacist Dosage Guidance</h4>
                    <p>Have questions about side-effects, interactions, or timings? Consult directly with our on-duty licensed pharmacist.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-calendar-days"></i></div>
                    <h4>Chronic Refill Care</h4>
                    <p>Never run out of essential diabetes, cardiac, or thyroid medication. Enjoy hassle-free automated monthly refill alerts.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon-box"><i class="fa-solid fa-kit-medical"></i></div>
                    <h4>24/7 Emergency Support</h4>
                    <p>Round-the-clock emergency medical response for critical injections, life-support medications, and ICU supplies.</p>
                </div>
            </div>

            <!-- Emergency Banner -->
            <div class="emergency-banner" id="contact">
                <div class="emergency-content">
                    <h3><i class="fa-solid fa-truck-medical"></i> Need Urgent Medical Assistance?</h3>
                    <p>Our emergency hotline is active 24 hours a day, 7 days a week for immediate medicine dispatch.</p>
                </div>
                <div class="emergency-actions">
                    <a href="tel:<?= $contact['helpline'] ?>" class="btn btn-emergency">
                        <i class="fa-solid fa-phone-volume"></i> Call <?= $contact['helpline'] ?>
                    </a>
                    <a href="https://wa.me/<?= str_replace(['+', ' '], '', $contact['whatsapp']) ?>?text=Hello%20MedPulse%20I%20need%20urgent%20medicines" target="_blank" class="btn btn-primary" style="background: #25d366; border-color: #25d366;">
                        <i class="fa-brands fa-whatsapp"></i> WhatsApp Order
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Col 1: About -->
                <div class="footer-col">
                    <div class="brand-logo" style="margin-bottom: 16px;">
                        <div class="brand-icon-box">
                            <i class="fa-solid fa-notes-medical"></i>
                        </div>
                        <div class="brand-text">
                            <div class="brand-name" style="color: #ffffff;">Med<span>Pulse</span></div>
                            <div class="brand-sub">Healthcare &amp; Pharmacy</div>
                        </div>
                    </div>
                    <p style="font-size: 0.88rem; line-height: 1.6; margin-bottom: 18px;">
                        Your trusted digital healthcare provider and neighborhood pharmacy, delivering authentic medications and certified doctor appointments around the clock.
                    </p>
                    <div class="badge badge-teal" style="background: rgba(13, 148, 136, 0.2); color: #2dd4bf;">
                        <i class="fa-solid fa-shield-check"></i> Licensed Pharmacy Reg: WB/KOL/2024
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="footer-col">
                    <h5>Quick Navigation</h5>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#medicines-catalog">Search Medicines</a></li>
                        <li><a href="#categories">Medicine Categories</a></li>
                        <li><a href="#doctors">Find Doctors</a></li>
                        <li><a href="#services">Our Healthcare Services</a></li>
                        <li><a href="javascript:void(0)" onclick="openRxModal()">Upload Prescription</a></li>
                    </ul>
                </div>

                <!-- Col 3: Categories -->
                <div class="footer-col">
                    <h5>Popular Categories</h5>
                    <ul class="footer-links">
                        <li><a href="javascript:void(0)" onclick="filterCatalogByCategory('TABLET')">Tablets &amp; Capsules</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCatalogByCategory('SYRUP')">Syrups &amp; Suspensions</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCatalogByCategory('INJECTION')">Injections &amp; IV Fluids</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCatalogByCategory('CREAM')">Dermatological Creams</a></li>
                        <li><a href="javascript:void(0)" onclick="filterCatalogByCategory('DROPS')">Pediatric &amp; Eye Drops</a></li>
                        <li><a href="<?= base_url('console') ?>"><i class="fa-solid fa-lock"></i> Staff Administration</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div class="footer-col">
                    <h5>Pharmacy Contact</h5>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><?= htmlspecialchars($contact['address'], ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>Helpline: <a href="tel:<?= $contact['helpline'] ?>"><?= $contact['helpline'] ?></a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>Email: <a href="mailto:<?= $contact['email'] ?>"><?= $contact['email'] ?></a></span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-clock"></i>
                        <span>Operating Hours: 24 Hours / 7 Days Open</span>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div>
                    &copy; <?= date('Y') ?> MedPulse Pharmacy &amp; Healthcare Portal. All rights reserved.
                </div>
                <div style="font-size: 0.8rem; color: #64748b;">
                    <i class="fa-solid fa-circle-exclamation"></i> Prescription Required: Schedule H, H1, &amp; X drugs are dispensed only against a valid prescription from a registered medical practitioner.
                </div>
            </div>
        </div>
    </footer>

    <!-- ==========================================================================
         MODALS
         ========================================================================== -->

    <!-- 1. PRESCRIPTION UPLOAD MODAL -->
    <div class="modal-overlay" id="rxModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fa-solid fa-file-prescription text-teal"></i> Upload Doctor's Prescription</h3>
                <button class="modal-close-btn" onclick="closeRxModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="rxUploadForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Patient Full Name *</label>
                        <input type="text" name="patient_name" class="form-control" placeholder="e.g. Rahul Sharma" required>
                    </div>

                    <div class="form-group">
                        <label>Contact Mobile Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="e.g. 9876543210" required>
                    </div>

                    <div class="form-group">
                        <label>Email Address (Optional)</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. patient@example.com">
                    </div>

                    <div class="form-group">
                        <label>Delivery Address *</label>
                        <textarea name="address" class="form-control" placeholder="Enter complete address with house number, street, city, and pin code..." rows="2" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Attach Prescription File (JPG, PNG, PDF, WEBP) *</label>
                        <input type="file" name="prescription_file" id="prescriptionFileInput" class="form-control" accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                        <small class="text-muted" style="font-size: 0.76rem; display: block; margin-top: 4px;">
                            Please ensure patient name, doctor's signature/stamp, and medicines are clearly readable. Max size 12MB.
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Additional Notes / Special Instructions</label>
                        <input type="text" name="notes" class="form-control" placeholder="e.g. Need urgent delivery, substitute with generic if available...">
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary" id="rxSubmitBtn" style="width: 100%;">
                            <i class="fa-solid fa-paper-plane"></i> Submit Prescription for Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. DOCTOR CONSULTATION BOOKING MODAL -->
    <div class="modal-overlay" id="consultationModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fa-solid fa-stethoscope text-teal"></i> Book Doctor Consultation</h3>
                <button class="modal-close-btn" onclick="closeConsultationModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="consultationForm">
                    <input type="hidden" name="doctor_id" id="modalDoctorId" value="">
                    
                    <div class="form-group">
                        <label>Selected Doctor / Specialist</label>
                        <input type="text" id="modalDoctorName" class="form-control" readonly style="background: #f8fafc; font-weight: 700;">
                    </div>

                    <div class="form-group">
                        <label>Specialty Department</label>
                        <input type="text" name="department" id="modalDoctorDept" class="form-control" readonly style="background: #f8fafc;">
                    </div>

                    <div class="form-group">
                        <label>Patient Full Name *</label>
                        <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name" required>
                    </div>

                    <div class="form-group">
                        <label>Contact Mobile Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="Enter 10-digit mobile number" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label>Preferred Date *</label>
                            <input type="date" name="preferred_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Time Slot *</label>
                            <select name="preferred_time" class="form-control">
                                <option>Morning (10:00 AM - 1:00 PM)</option>
                                <option>Afternoon (1:00 PM - 4:00 PM)</option>
                                <option>Evening (4:00 PM - 8:00 PM)</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Symptoms / Medical Reason</label>
                        <textarea name="message" class="form-control" placeholder="Briefly describe health concern or symptoms..." rows="2"></textarea>
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary" id="consultationSubmitBtn" style="width: 100%;">
                            <i class="fa-solid fa-check-circle"></i> Confirm Appointment Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. MEDICINE QUICK ORDER MODAL -->
    <div class="modal-overlay" id="orderModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fa-solid fa-cart-shopping text-teal"></i> Quick Medicine Order</h3>
                <button class="modal-close-btn" onclick="closeOrderModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="quickOrderForm">
                    <input type="hidden" name="medicine_id" id="modalOrderMedId" value="">
                    
                    <div class="form-group">
                        <label>Selected Medicine</label>
                        <input type="text" name="medicine_name" id="modalOrderMedName" class="form-control" readonly style="background: #f8fafc; font-weight: 700;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label>Quantity *</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" max="20" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <select name="payment_method" class="form-control">
                                <option>Cash on Delivery (COD)</option>
                                <option>UPI / QR Code on Delivery</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Your Full Name *</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label>Contact Mobile Number *</label>
                        <input type="tel" name="phone" class="form-control" placeholder="Enter 10-digit phone number" required>
                    </div>

                    <div class="form-group">
                        <label>Doorstep Delivery Address *</label>
                        <textarea name="delivery_address" class="form-control" placeholder="Enter flat/house no, street, locality, landmark, pincode..." rows="2" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Delivery Instructions (Optional)</label>
                        <input type="text" name="order_notes" class="form-control" placeholder="e.g. Deliver before 5 PM, ring bell...">
                    </div>

                    <div style="margin-top: 20px;">
                        <button type="submit" class="btn btn-primary" id="orderSubmitBtn" style="width: 100%;">
                            <i class="fa-solid fa-paper-plane"></i> Place Express Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. MEDICINE FULL DETAILS MODAL -->
    <div class="modal-overlay" id="detailsModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3><i class="fa-solid fa-circle-info text-teal"></i> Medicine Details</h3>
                <button class="modal-close-btn" onclick="closeDetailsModal()">&times;</button>
            </div>
            <div class="modal-body" id="detailsModalBody">
                <div style="text-align: center; padding: 30px;">
                    <i class="fa-solid fa-spinner fa-spin text-teal" style="font-size: 2rem;"></i>
                    <p style="margin-top: 10px;">Loading medicine specifications...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Floating Actions (WhatsApp & Back to Top) -->
    <div class="floating-actions">
        <a href="https://wa.me/<?= str_replace(['+', ' '], '', $contact['whatsapp']) ?>?text=Hello%20MedPulse%20I%20have%20an%20inquiry" target="_blank" class="fab fab-whatsapp" title="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
        <button class="fab fab-top" id="backToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" title="Back to Top">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </div>

    <!-- ==========================================================================
         JAVASCRIPT LOGIC
         ========================================================================== -->
    <script>
        const BASE_URL = '<?= base_url() ?>';

        // 1. Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
        }

        // 2. Toast Notification Function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            const icon = type === 'success' ? 'fa-circle-check text-emerald' : 'fa-circle-exclamation text-rose';
            toast.innerHTML = `
                <i class="fa-solid ${icon}" style="font-size: 1.25rem;"></i>
                <div style="font-size: 0.9rem; font-weight: 600;">${message}</div>
            `;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // 3. Live Medicine Search with Debouncing
        const heroSearchInput = document.getElementById('heroSearchInput');
        const searchResultsDropdown = document.getElementById('searchResultsDropdown');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const searchCategorySelect = document.getElementById('searchCategorySelect');
        let searchTimeout = null;

        if (heroSearchInput) {
            heroSearchInput.addEventListener('input', function() {
                const term = this.value.trim();
                searchClearBtn.style.display = term.length > 0 ? 'block' : 'none';
                clearTimeout(searchTimeout);

                if (term.length < 2) {
                    searchResultsDropdown.style.display = 'none';
                    return;
                }

                searchTimeout = setTimeout(() => {
                    performLiveSearch(term, searchCategorySelect.value);
                }, 280);
            });

            searchClearBtn.addEventListener('click', () => {
                heroSearchInput.value = '';
                searchClearBtn.style.display = 'none';
                searchResultsDropdown.style.display = 'none';
                heroSearchInput.focus();
            });

            document.getElementById('heroSearchSubmitBtn').addEventListener('click', () => {
                const term = heroSearchInput.value.trim();
                if (term.length > 0) {
                    performLiveSearch(term, searchCategorySelect.value);
                    const catalog = document.getElementById('medicines-catalog');
                    if (catalog) catalog.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        function quickFillSearch(term) {
            heroSearchInput.value = term;
            searchClearBtn.style.display = 'block';
            heroSearchInput.focus();
            performLiveSearch(term, searchCategorySelect.value);
            const catalog = document.getElementById('medicines-catalog');
            if (catalog) catalog.scrollIntoView({ behavior: 'smooth' });
        }

        function performLiveSearch(term, category = '') {
            searchResultsDropdown.innerHTML = '<div style="padding: 16px; text-align: center; color: #64748b;"><i class="fa-solid fa-spinner fa-spin"></i> Searching medicines...</div>';
            searchResultsDropdown.style.display = 'block';

            const url = `${BASE_URL}landing/search_medicines?term=${encodeURIComponent(term)}&category=${encodeURIComponent(category)}&limit=15`;
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.results.length > 0) {
                        let html = '';
                        data.results.forEach(med => {
                            html += `
                                <div class="search-result-item" onclick="selectMedicineFromSearch(${med.medicine_id}, '${escapeJs(med.medicine_name)}')">
                                    <div class="search-result-info">
                                        <div class="search-result-name">${escapeHtml(med.medicine_name)}</div>
                                        <div class="search-result-sub">${escapeHtml(med.medicine_manufacturer || 'Verified Manufacturer')} &bull; Unit: ${med.medicine_unit || 10}</div>
                                    </div>
                                    <span class="search-result-badge">${escapeHtml(med.medicine_category || 'GENERAL')}</span>
                                </div>
                            `;
                        });
                        searchResultsDropdown.innerHTML = html;
                    } else {
                        searchResultsDropdown.innerHTML = `<div style="padding: 16px; text-align: center; color: #64748b;">No medicines found for "${escapeHtml(term)}".</div>`;
                    }
                })
                .catch(err => {
                    searchResultsDropdown.innerHTML = '<div style="padding: 16px; text-align: center; color: #ef4444;">Search request error. Please try again.</div>';
                });
        }

        // Close dropdown on click outside
        document.addEventListener('click', (e) => {
            const wrapper = document.getElementById('heroSearchWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                searchResultsDropdown.style.display = 'none';
            }
        });

        function selectMedicineFromSearch(id, name) {
            searchResultsDropdown.style.display = 'none';
            openOrderModal(id, name);
        }

        // 4. In-Catalog Client Filtering
        const catalogSearchInput = document.getElementById('catalogSearchInput');
        if (catalogSearchInput) {
            catalogSearchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const cards = document.querySelectorAll('.medicine-card');
                let visibleCount = 0;

                cards.forEach(card => {
                    const name = card.getAttribute('data-name');
                    if (name.includes(term)) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                const emptyState = document.getElementById('catalogEmptyState');
                if (emptyState) {
                    emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        }

        function filterCatalog(category, tabBtn) {
            const tabs = document.querySelectorAll('.filter-tab');
            tabs.forEach(t => t.classList.remove('active'));
            if (tabBtn) tabBtn.classList.add('active');

            const cards = document.querySelectorAll('.medicine-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const medCat = card.getAttribute('data-category');
                if (category === 'all' || medCat.includes(category)) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const emptyState = document.getElementById('catalogEmptyState');
            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        }

        function filterCatalogByCategory(catName) {
            const catUpper = catName.toUpperCase();
            const catalog = document.getElementById('medicines-catalog');
            if (catalog) catalog.scrollIntoView({ behavior: 'smooth' });

            const tab = document.querySelector(`.filter-tab[data-category="${catUpper}"]`);
            if (tab) {
                filterCatalog(catUpper, tab);
            } else {
                filterCatalog(catUpper, null);
            }
        }

        function resetCatalogFilters() {
            catalogSearchInput.value = '';
            const allTab = document.querySelector('.filter-tab[data-category="all"]');
            filterCatalog('all', allTab);
        }

        // 5. Prescription Modal Logic & AJAX Submit
        function openRxModal() {
            document.getElementById('rxModal').classList.add('active');
        }
        function closeRxModal() {
            document.getElementById('rxModal').classList.remove('active');
        }

        document.getElementById('rxUploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('rxSubmitBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading & Verifying...';
            btn.disabled = true;

            const formData = new FormData(this);
            fetch(`${BASE_URL}landing/upload_prescription`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                if (data.status === 'success') {
                    showToast(data.message, 'success');
                    closeRxModal();
                    this.reset();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(err => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                showToast('Upload failed. Please check network connection.', 'error');
            });
        });

        // 6. Consultation Booking Modal Logic
        function openConsultationModal(doctorId, doctorName, doctorSpecialty) {
            document.getElementById('modalDoctorId').value = doctorId;
            document.getElementById('modalDoctorName').value = doctorName;
            document.getElementById('modalDoctorDept').value = doctorSpecialty;
            document.getElementById('consultationModal').classList.add('active');
        }
        function closeConsultationModal() {
            document.getElementById('consultationModal').classList.remove('active');
        }

        document.getElementById('consultationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('consultationSubmitBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Confirming Appointment...';
            btn.disabled = true;

            const formData = new FormData(this);
            fetch(`${BASE_URL}landing/book_consultation`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                if (data.status === 'success') {
                    showToast(data.message, 'success');
                    closeConsultationModal();
                    this.reset();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(err => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                showToast('Appointment booking failed. Please try again.', 'error');
            });
        });

        // 7. Quick Order Modal Logic
        function openOrderModal(medicineId, medicineName) {
            document.getElementById('modalOrderMedId').value = medicineId;
            document.getElementById('modalOrderMedName').value = medicineName;
            document.getElementById('orderModal').classList.add('active');
        }
        function closeOrderModal() {
            document.getElementById('orderModal').classList.remove('active');
        }

        document.getElementById('quickOrderForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('orderSubmitBtn');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Order...';
            btn.disabled = true;

            const formData = new FormData(this);
            fetch(`${BASE_URL}landing/quick_order`, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                if (data.status === 'success') {
                    showToast(data.message, 'success');
                    closeOrderModal();
                    this.reset();
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(err => {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                showToast('Order placement failed. Please try again.', 'error');
            });
        });

        // 8. Medicine Details Modal Logic
        function openDetailsModal(medId) {
            const modalBody = document.getElementById('detailsModalBody');
            modalBody.innerHTML = `
                <div style="text-align: center; padding: 30px;">
                    <i class="fa-solid fa-spinner fa-spin text-teal" style="font-size: 2rem;"></i>
                    <p style="margin-top: 10px;">Loading medicine specifications...</p>
                </div>
            `;
            document.getElementById('detailsModal').classList.add('active');

            fetch(`${BASE_URL}landing/get_medicine_details?id=${medId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const m = data.medicine;
                        modalBody.innerHTML = `
                            <h3 style="font-size: 1.3rem; margin-bottom: 6px;">${escapeHtml(m.medicine_name)}</h3>
                            <p class="text-muted" style="margin-bottom: 16px;">${escapeHtml(m.medicine_manufacturer || 'Verified Manufacturer')}</p>
                            
                            <table style="width: 100%; font-size: 0.9rem; border-collapse: collapse; margin-bottom: 20px;">
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px 0; color: #64748b; font-weight: 600;">Form / Category:</td>
                                    <td style="padding: 10px 0; font-weight: 700;">${escapeHtml(m.medicine_category || 'General')}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px 0; color: #64748b; font-weight: 600;">Packaging Unit:</td>
                                    <td style="padding: 10px 0; font-weight: 700;">${m.medicine_unit || 10} Units per pack</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px 0; color: #64748b; font-weight: 600;">Storage Condition:</td>
                                    <td style="padding: 10px 0; font-weight: 700;">${escapeHtml(m.medicine_storage || 'Store in cool and dry place')}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 10px 0; color: #64748b; font-weight: 600;">Schedule / Regulatory:</td>
                                    <td style="padding: 10px 0; font-weight: 700;">${escapeHtml(m.medicine_schedule || 'General / Non-restricted')}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0; color: #64748b; font-weight: 600;">HSN Code:</td>
                                    <td style="padding: 10px 0; font-weight: 700;">${m.medicine_hsn || '3004'}</td>
                                </tr>
                            </table>

                            <div style="display: flex; gap: 10px;">
                                <button class="btn btn-primary" style="flex: 1;" onclick="closeDetailsModal(); openOrderModal(${m.medicine_id}, '${escapeJs(m.medicine_name)}')">
                                    <i class="fa-solid fa-cart-shopping"></i> Order This Medicine
                                </button>
                                <button class="btn btn-secondary" onclick="closeDetailsModal()">Close</button>
                            </div>
                        `;
                    } else {
                        modalBody.innerHTML = `<div style="text-align: center; color: #ef4444; padding: 20px;">${data.message}</div>`;
                    }
                })
                .catch(err => {
                    modalBody.innerHTML = '<div style="text-align: center; color: #ef4444; padding: 20px;">Failed to load medicine details.</div>';
                });
        }
        function closeDetailsModal() {
            document.getElementById('detailsModal').classList.remove('active');
        }

        // Close modals on Escape key or outside click
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeRxModal();
                closeConsultationModal();
                closeOrderModal();
                closeDetailsModal();
            }
        });
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });

        // 9. Back to Top Button
        const backToTopBtn = document.getElementById('backToTopBtn');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTopBtn.style.display = 'grid';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });

        // Helper string sanitizers
        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>"']/g, function(m) {
                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'}[m];
            });
        }
        function escapeJs(str) {
            if (!str) return '';
            return String(str).replace(/['"\\]/g, '\\$&').replace(/\n/g, ' ');
        }
    </script>
</body>
</html>
