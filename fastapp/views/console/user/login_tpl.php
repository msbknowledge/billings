<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0d9488" />
        <title>Login &bull; <?= isset($name) ? html_escape($name) : 'MsbBillings - Pharmacy & Medical Store Billing'; ?></title>
        <link href="<?= base_url() ?>assets/backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;700&display=swap">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">
        <style>
            :root {
                --primary: #0d9488;
                --primary-dark: #0f766e;
                --primary-light: #ccfbf1;
                --primary-glow: rgba(13, 148, 136, 0.25);
                --accent-blue: #0284c7;
                --slate-900: #0f172a;
                --slate-800: #1e293b;
                --slate-700: #334155;
                --slate-600: #475569;
                --slate-500: #64748b;
                --slate-400: #94a3b8;
                --slate-200: #e2e8f0;
                --slate-100: #f1f5f9;
                --slate-50: #f8fafc;
                --surface-card: #ffffff;
                --radius-lg: 14px;
                --radius-md: 10px;
                --radius-sm: 6px;
            }

            * { box-sizing: border-box; }
            html, body {
                min-height: 100vh;
                margin: 0;
                padding: 0;
                font-family: 'Plus Jakarta Sans', 'Roboto', sans-serif;
                background: #f8fafc;
                color: var(--slate-700);
            }

            .top-content {
                min-height: 100vh;
                padding: 0;
                background: transparent;
            }

            .bgoffsetbg {
                position: relative;
                display: flex;
                min-height: 100vh;
                align-items: stretch;
                justify-content: flex-start;
                overflow: hidden;
                background: #ffffff;
            }

            .bgoffsetbg > [class*="col-"] {
                float: none;
            }

            /* Left Login Sidebar */
            .login-sidebar-col {
                flex: 0 0 38%;
                max-width: 520px;
                min-width: 360px;
                background: #ffffff;
                border-right: 1px solid #e2e8f0;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                padding: 36px 38px 24px;
                position: relative;
                z-index: 5;
                box-shadow: 4px 0 24px rgba(15, 23, 42, 0.04);
            }

            .login-brand {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 24px;
            }

            .login-brand-logo {
                max-height: 52px;
                max-width: 170px;
                object-fit: contain;
            }

            .login-brand-badge {
                display: inline-block;
                background: var(--primary-light);
                color: var(--primary-dark);
                font-size: 11px;
                font-weight: 700;
                letter-spacing: 0.5px;
                padding: 3px 8px;
                border-radius: 999px;
                text-transform: uppercase;
            }

            .login-header-text h2 {
                margin: 0 0 6px;
                font-size: 24px;
                font-weight: 800;
                color: var(--slate-900);
                letter-spacing: -0.5px;
            }

            .login-header-text p {
                margin: 0 0 20px;
                color: var(--slate-500);
                font-size: 13.5px;
                line-height: 1.5;
            }

            /* Alert Messages */
            #login-message {
                margin-bottom: 18px;
                padding: 11px 14px;
                border-radius: var(--radius-md);
                font-size: 13px;
                display: flex;
                align-items: center;
                gap: 10px;
                border: 1px solid transparent;
                transition: all 0.25s ease;
            }

            #login-message.alert-info {
                background: #f0fdfa;
                color: #0f766e;
                border-color: #ccfbf1;
            }

            #login-message.alert-danger {
                background: #fef2f2;
                color: #b91c1c;
                border-color: #fee2e2;
            }

            #login-message.alert-success {
                background: #f0fdf4;
                color: #15803d;
                border-color: #dcfce7;
            }

            /* Form Elements & Inputs */
            .form-group-custom {
                margin-bottom: 18px;
                position: relative;
            }

            .form-group-custom label {
                display: block;
                font-size: 13px;
                font-weight: 600;
                color: var(--slate-700);
                margin-bottom: 6px;
                text-align: left;
            }

            .input-wrapper {
                position: relative;
                display: flex;
                align-items: center;
                width: 100%;
            }

            .input-icon-left {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--slate-500);
                font-size: 15px;
                line-height: 1;
                pointer-events: none;
                z-index: 5;
                width: 18px;
                text-align: center;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                transition: color 0.2s ease;
            }

            .input-wrapper:focus-within .input-icon-left {
                color: var(--primary);
            }

            .login-sidebar-col input[type="text"].login-input,
            .login-sidebar-col input[type="password"].login-input,
            .login-input {
                width: 100% !important;
                height: 48px !important;
                padding-left: 48px !important;
                padding-right: 48px !important;
                padding-top: 10px !important;
                padding-bottom: 10px !important;
                border: 1.5px solid #cbd5e1 !important;
                border-radius: var(--radius-md) !important;
                background: #ffffff !important;
                color: var(--slate-900) !important;
                font-size: 14.5px !important;
                font-family: inherit !important;
                line-height: normal !important;
                box-shadow: none !important;
                transition: all 0.2s ease !important;
                box-sizing: border-box !important;
            }

            .login-sidebar-col input[type="text"].login-input:focus,
            .login-sidebar-col input[type="password"].login-input:focus,
            .login-input:focus {
                outline: none !important;
                border-color: var(--primary) !important;
                box-shadow: 0 0 0 3px var(--primary-glow) !important;
                background: #ffffff !important;
            }

            .login-sidebar-col input[type="text"].login-input::placeholder,
            .login-sidebar-col input[type="password"].login-input::placeholder,
            .login-input::placeholder {
                color: #94a3b8 !important;
                font-size: 14px !important;
            }

            .password-toggle-btn {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: transparent !important;
                border: 0 !important;
                color: var(--slate-500) !important;
                cursor: pointer !important;
                padding: 6px 8px !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 4px !important;
                z-index: 5;
                font-size: 14px !important;
                line-height: 1 !important;
                height: auto !important;
                width: auto !important;
                box-shadow: none !important;
                transition: color 0.2s ease, background 0.2s ease !important;
            }

            .password-toggle-btn:hover {
                color: var(--slate-900) !important;
                background: rgba(15, 23, 42, 0.05) !important;
            }

            .help-inline-msg {
                display: none;
                margin-top: 5px;
                font-size: 12px;
                font-weight: 500;
                color: #dc2626;
                text-align: left;
            }

            /* Remember & Forgot Row */
            .login-meta-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 4px 0 20px;
                font-size: 13px;
            }

            .remember-label {
                display: flex;
                align-items: center;
                gap: 8px;
                cursor: pointer;
                color: var(--slate-600);
                user-select: none;
                margin: 0;
                font-weight: 500;
            }

            .remember-label input[type="checkbox"] {
                width: 16px;
                height: 16px;
                accent-color: var(--primary);
                cursor: pointer;
                margin: 0;
            }

            .forgot-link {
                color: var(--primary);
                font-weight: 600;
                text-decoration: none;
                transition: color 0.2s;
            }

            .forgot-link:hover {
                color: var(--primary-dark);
                text-decoration: underline;
            }

            /* Submit Button */
            .btn-login-submit {
                width: 100%;
                height: 48px;
                background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
                color: #ffffff;
                border: 0;
                border-radius: var(--radius-md);
                font-size: 15px;
                font-weight: 700;
                letter-spacing: 0.3px;
                cursor: pointer;
                box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 0.2s ease;
            }

            .btn-login-submit:hover {
                background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
                box-shadow: 0 6px 18px rgba(13, 148, 136, 0.45);
                transform: translateY(-1px);
                color: #fff;
            }

            .btn-login-submit:active {
                transform: translateY(0);
            }

            .btn-login-submit:disabled {
                opacity: 0.7;
                cursor: not-allowed;
                transform: none;
            }

            /* Quick Demo Section */
            .quick-demo-wrapper {
                margin-top: 24px;
                padding-top: 18px;
                border-top: 1px dashed #e2e8f0;
            }

            .quick-demo-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
            }

            .quick-demo-title {
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.6px;
                color: var(--slate-500);
                margin: 0;
            }

            .quick-demo-hint {
                font-size: 11px;
                color: var(--primary);
                font-weight: 600;
            }

            .demo-pills-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .demo-pill-btn {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: var(--radius-sm);
                padding: 8px 6px;
                font-size: 12px;
                font-weight: 600;
                color: var(--slate-700);
                cursor: pointer;
                transition: all 0.18s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 2px;
                line-height: 1.2;
                text-align: center;
            }

            .demo-pill-btn span.role-title {
                font-weight: 700;
                color: var(--slate-800);
            }

            .demo-pill-btn span.role-tag {
                font-size: 10px;
                color: var(--slate-500);
            }

            .demo-pill-btn:hover {
                background: #f0fdfa;
                border-color: #99f6e4;
                color: var(--primary-dark);
                transform: translateY(-1px);
            }

            .demo-pill-btn.active {
                background: #0d9488;
                border-color: #0d9488;
                color: #ffffff;
            }

            .demo-pill-btn.active span.role-title,
            .demo-pill-btn.active span.role-tag {
                color: #ffffff;
            }

            .demo-status-banner {
                margin-top: 10px;
                padding: 6px 10px;
                background: #f0fdfa;
                border: 1px solid #ccfbf1;
                border-radius: var(--radius-sm);
                font-size: 12px;
                color: var(--primary-dark);
                display: none;
                align-items: center;
                gap: 6px;
            }

            .demo-status-banner.is-visible {
                display: flex;
            }

            /* Bottom navigation */
            .sidebar-bottom-links {
                margin-top: 24px;
                padding-top: 14px;
                border-top: 1px solid #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 13px;
            }

            .sidebar-bottom-links a {
                color: var(--slate-500);
                text-decoration: none;
                font-weight: 600;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                transition: color 0.2s;
            }

            .sidebar-bottom-links a:hover {
                color: var(--primary);
                text-decoration: none;
            }

            /* Right Showcase Hero Panel */
            .hero-showcase-col {
                flex: 1 1 auto;
                min-width: 0;
                background: linear-gradient(135deg, #042f2e 0%, #0f172a 60%, #1e293b 100%),
                            url('<?= base_url() ?>assets/backend/images/login_bg1.jpg') center/cover no-repeat;
                background-blend-mode: overlay;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px;
                position: relative;
            }

            .hero-showcase-col::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at top right, rgba(13, 148, 136, 0.35) 0%, transparent 60%);
                pointer-events: none;
            }

            .hero-card-container {
                width: 100%;
                max-width: 680px;
                position: relative;
                z-index: 2;
            }

            .hero-glass-box {
                background: rgba(15, 23, 42, 0.72);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: var(--radius-lg);
                padding: 38px 40px;
                color: #ffffff;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            }

            .hero-tag {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: rgba(13, 148, 136, 0.25);
                border: 1px solid rgba(45, 212, 191, 0.35);
                color: #5eead4;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.6px;
                padding: 4px 12px;
                border-radius: 999px;
                margin-bottom: 16px;
                text-transform: uppercase;
            }

            .hero-title {
                font-size: 28px;
                font-weight: 800;
                letter-spacing: -0.6px;
                line-height: 1.3;
                margin: 0 0 12px;
                color: #ffffff;
            }

            .hero-desc {
                font-size: 14.5px;
                color: #cbd5e1;
                line-height: 1.6;
                margin: 0 0 28px;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
                margin-bottom: 24px;
            }

            .feature-item {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: var(--radius-md);
                padding: 16px 18px;
                transition: all 0.25s ease;
            }

            .feature-item:hover {
                background: rgba(255, 255, 255, 0.09);
                border-color: rgba(45, 212, 191, 0.3);
                transform: translateY(-2px);
            }

            .feature-item-header {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 6px;
            }

            .feature-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: rgba(13, 148, 136, 0.3);
                color: #2dd4bf;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
            }

            .feature-item h4 {
                margin: 0;
                font-size: 14px;
                font-weight: 700;
                color: #f8fafc;
            }

            .feature-item p {
                margin: 0;
                font-size: 12px;
                color: #94a3b8;
                line-height: 1.5;
            }

            .hero-footer-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-top: 20px;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                font-size: 12.5px;
                color: #94a3b8;
            }

            .hero-footer-bar a {
                color: #2dd4bf;
                text-decoration: none;
                font-weight: 600;
            }

            .hero-footer-bar a:hover {
                text-decoration: underline;
            }

            /* Responsive */
            @media (max-width: 991px) {
                .bgoffsetbg { flex-direction: column; }
                .login-sidebar-col {
                    flex: 1 1 auto;
                    max-width: 100%;
                    min-width: 0;
                    padding: 30px 24px;
                    border-right: 0;
                    box-shadow: none;
                }
                .hero-showcase-col {
                    display: none;
                }
            }

            @media (max-width: 480px) {
                .demo-pills-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>
    </head>
    <body>
        <div class="top-content">
            <div class="bgoffsetbg">
                <!-- Left Column: Modern Authentication Form -->
                <div class="login-sidebar-col">
                    <div>
                        <!-- Logo & Branding -->
                        <div class="login-brand">
                            <img src="<?= base_url() ?>msb/msbbillingslogo.png" 
                                 onerror="this.onerror=null;this.src='<?= base_url() ?>assets/backend/images/s_logo.png';" 
                                 alt="MsbBillings Logo" 
                                 class="login-brand-logo" />
                            <span class="login-brand-badge">Pharmacy POS</span>
                        </div>

                        <div class="login-header-text">
                            <h2>Sign In to Console</h2>
                            <p>Enter your credentials to access the Medical Store & Pharmacy Billing System.</p>
                        </div>

                        <!-- System / AJAX Alert Banner -->
                        <div id="login-message" class="alert alert-info" role="alert">
                            <i class="fa fa-info-circle"></i>
                            <span id="login-message-text">Please enter your Username and Password to continue.</span>
                        </div>

                        <?php if (isset($error_message) && !empty($error_message)): ?>
                            <div class="alert alert-danger" style="border-radius: var(--radius-md);">
                                <i class="fa fa-exclamation-triangle"></i> <?= html_escape($error_message) ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert alert-success" style="border-radius: var(--radius-md);">
                                <i class="fa fa-check-circle"></i> <?= $this->session->flashdata('message') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form id="signin_form" action="<?= console_url('user/login') ?>" method="post" autocomplete="on">
                            
                            <!-- Username -->
                            <div class="form-group-custom">
                                <label for="username">Username or Email</label>
                                <div class="input-wrapper">
                                    <i class="fa fa-user input-icon-left" aria-hidden="true"></i>
                                    <input type="text" 
                                           id="username" 
                                           name="username" 
                                           class="login-input" 
                                           style="padding-left: 48px !important; padding-right: 48px !important;" 
                                           placeholder="e.g. admin or pharmacist1" 
                                           from-validation="required" 
                                           autocomplete="username" 
                                           autofocus 
                                           required />
                                </div>
                                <span class="help-inline-msg" id="username-error">Please enter username</span>
                            </div>

                            <!-- Password -->
                            <div class="form-group-custom">
                                <label for="password">Password</label>
                                <div class="input-wrapper">
                                    <i class="fa fa-lock input-icon-left" aria-hidden="true"></i>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="login-input" 
                                           style="padding-left: 48px !important; padding-right: 48px !important;" 
                                           placeholder="Enter your password" 
                                           from-validation="required" 
                                           autocomplete="current-password" 
                                           required />
                                    <button type="button" 
                                            class="password-toggle-btn" 
                                            id="btnTogglePassword" 
                                            title="Toggle password visibility" 
                                            aria-label="Toggle password visibility">
                                        <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <span class="help-inline-msg" id="password-error">Please enter password</span>
                            </div>

                            <!-- Optional Captcha (if active) -->
                            <?php if (isset($is_captcha) && $is_captcha): ?>
                                <div class="form-group-custom">
                                    <label for="captcha">Security Verification</label>
                                    <div class="row" style="margin: 0; gap: 8px; display: flex; align-items: center;">
                                        <div style="flex: 1; display: flex; align-items: center; gap: 8px;">
                                            <span id="captcha_image"><?= $captcha_image ?? '' ?></span>
                                            <button type="button" class="btn btn-default" title="Refresh Captcha" onclick="refresh_captcha()">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                        <div style="flex: 1;">
                                            <input type="text" name="captcha" id="captcha" class="login-input" style="padding-left: 14px !important; padding-right: 14px !important;" placeholder="Captcha" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Remember & Forgot Password -->
                            <div class="login-meta-row">
                                <label class="remember-label" for="remember">
                                    <input type="checkbox" name="remember" id="remember" value="1" />
                                    <span>Remember me</span>
                                </label>
                                <a href="<?= console_url('user/forgot_password'); ?>" class="forgot-link">
                                    <i class="fa fa-key"></i> Forgot Password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-login-submit" id="btnSubmit">
                                <i class="fa fa-sign-in"></i>
                                <span id="btnSubmitText">Sign In</span>
                            </button>
                        </form>

                        <!-- Quick Demo Roles Section -->
                        <div class="quick-demo-wrapper">
                            <div class="quick-demo-header">
                                <h4 class="quick-demo-title"><i class="fa fa-bolt" style="color: #f59e0b;"></i> Quick Demo Login</h4>
                                <span class="quick-demo-hint">Click role to autofill</span>
                            </div>
                            <div class="demo-pills-grid">
                                <button type="button" 
                                        class="demo-pill-btn active" 
                                        data-demo-role="Admin" 
                                        data-demo-username="admin" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Admin</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                                <button type="button" 
                                        class="demo-pill-btn" 
                                        data-demo-role="Super Admin" 
                                        data-demo-username="superadmin1" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Super Admin</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                                <button type="button" 
                                        class="demo-pill-btn" 
                                        data-demo-role="Pharmacist" 
                                        data-demo-username="pharmacist1" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Pharmacist</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                                <button type="button" 
                                        class="demo-pill-btn" 
                                        data-demo-role="Pathologist" 
                                        data-demo-username="pathologist1" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Pathologist</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                                <button type="button" 
                                        class="demo-pill-btn" 
                                        data-demo-role="Billing POS" 
                                        data-demo-username="admin" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Billing POS</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                                <button type="button" 
                                        class="demo-pill-btn" 
                                        data-demo-role="Stock Manager" 
                                        data-demo-username="pharmacist1" 
                                        data-demo-password="admin123" 
                                        onclick="select_demo_role(this)">
                                    <span class="role-title">Stock Mgr</span>
                                    <span class="role-tag">admin123</span>
                                </button>
                            </div>
                            <div class="demo-status-banner" id="quick-demo-status">
                                <i class="fa fa-check-circle"></i>
                                <span id="quick-demo-status-text">Credentials filled. Click Sign In to proceed.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Link bar -->
                    <div class="sidebar-bottom-links">
                        <a href="<?= base_url() ?>">
                            <i class="fa fa-globe"></i> Front Portal
                        </a>
                        <span style="color: #94a3b8; font-size: 12px;">&copy; <?= date('Y') ?> MsbBillings</span>
                    </div>
                </div>

                <!-- Right Column: Premium Pharmacy Highlights & Showcase -->
                <div class="hero-showcase-col">
                    <div class="hero-card-container">
                        <div class="hero-glass-box">
                            <div class="hero-tag">
                                <i class="fa fa-medkit"></i> Pharmacy & Healthcare POS Suite
                            </div>
                            <h1 class="hero-title">Smart Medical Store & Pharmacy Billing System</h1>
                            <p class="hero-desc">
                                Streamline your retail pharmacy operations with automated expiry alerts, real-time GST invoicing, barcode scanning, wholesale supplier management, and unified prescription tracking.
                            </p>

                            <!-- Feature Cards -->
                            <div class="features-grid">
                                <div class="feature-item">
                                    <div class="feature-item-header">
                                        <div class="feature-icon"><i class="fa fa-cubes"></i></div>
                                        <h4>Batch & Expiry Control</h4>
                                    </div>
                                    <p>Intelligent upcoming expiry radar, zero/negative stock alerts, and storage rack management.</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-item-header">
                                        <div class="feature-icon"><i class="fa fa-calculator"></i></div>
                                        <h4>Speed POS & GST Billing</h4>
                                    </div>
                                    <p>Quick barcode sales, GSTIN customer records, instant thermal receipts, and seamless sale returns.</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-item-header">
                                        <div class="feature-icon"><i class="fa fa-file-text-o"></i></div>
                                        <h4>Digital Prescriptions</h4>
                                    </div>
                                    <p>Review customer prescription uploads, online order dispatch, and doctor appointment scheduling.</p>
                                </div>
                                <div class="feature-item">
                                    <div class="feature-item-header">
                                        <div class="feature-icon"><i class="fa fa-line-chart"></i></div>
                                        <h4>Financial Intelligence</h4>
                                    </div>
                                    <p>Daily ledger summaries, supplier balance sheets, customer due reports, and profit & loss analysis.</p>
                                </div>
                            </div>

                            <div class="hero-footer-bar">
                                <span><i class="fa fa-shield" style="color: #2dd4bf;"></i> Secure SSL Protected Session</span>
                                <span>Need Assistance? <a href="<?= base_url('contact_us') ?>" target="_blank">Contact Support</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- JS Scripts from valid assets/backend directory -->
        <script src="<?= base_url(); ?>assets/backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url(); ?>assets/backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js"></script>
        <script src="<?= base_url(); ?>assets/backend/usertemplate/assets/js/jquery.mousewheel.min.js"></script>

        <!-- Form Validation and AJAX Logic -->
        <script type="text/javascript">
            $(document).ready(function() {
                // Toggle Password Visibility
                $('#btnTogglePassword').on('click', function(e) {
                    e.preventDefault();
                    var $pwd = $('#password');
                    var $icon = $('#togglePasswordIcon');
                    if ($pwd.attr('type') === 'password') {
                        $pwd.attr('type', 'text');
                        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        $pwd.attr('type', 'password');
                        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

                // Clear inline validation on typing
                $('#username').on('input', function() {
                    $('#username-error').hide();
                });
                $('#password').on('input', function() {
                    $('#password-error').hide();
                });

                // Bind form submit event
                $('#signin_form').on('submit', function(e) {
                    e.preventDefault();
                    validate_signin_form($(this));
                    return false;
                });
            });

            function validate_signin_form(targetForm) {
                var $form = $(targetForm);
                var username = $.trim($('#username').val());
                var password = $.trim($('#password').val());
                var valid = true;

                if (username === '') {
                    $('#username-error').show();
                    valid = false;
                } else {
                    $('#username-error').hide();
                }

                if (password === '') {
                    $('#password-error').show();
                    valid = false;
                } else {
                    $('#password-error').hide();
                }

                if (valid) {
                    ajax_signin_form_submit($form);
                }
                return false;
            }

            function ajax_signin_form_submit(targetForm) {
                var $btn = $('#btnSubmit');
                var $btnText = $('#btnSubmitText');
                var $msg = $('#login-message');
                var $msgText = $('#login-message-text');

                // Loading state
                $btn.prop('disabled', true);
                $btnText.html('<i class="fa fa-spinner fa-spin"></i> Authenticating...');

                $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData) {
                    if (typeof respData === 'string') {
                        try {
                            respData = JSON.parse(respData);
                        } catch(e) {}
                    }

                    if (respData && respData.status === 'success') {
                        $msg.removeClass('alert-info alert-danger')
                            .addClass('alert-success')
                            .find('i').attr('class', 'fa fa-check-circle');
                        $msgText.html(respData.message || 'Login successful! Redirecting to console...');
                        
                        $btnText.html('<i class="fa fa-check"></i> Success!');
                        setTimeout(function() {
                            window.location = '<?= console_url() ?>';
                        }, 800);
                    } else {
                        var err = (respData && respData.message) ? respData.message : 'Invalid username or password.';
                        $msg.removeClass('alert-info alert-success')
                            .addClass('alert-danger')
                            .find('i').attr('class', 'fa fa-exclamation-circle');
                        $msgText.html(err);

                        $btn.prop('disabled', false);
                        $btnText.text('Sign In');
                        $('#password').val('').focus();
                    }
                }, 'json').fail(function() {
                    $msg.removeClass('alert-info alert-success')
                        .addClass('alert-danger')
                        .find('i').attr('class', 'fa fa-exclamation-triangle');
                    $msgText.html('Network error occurred. Please check server connection.');

                    $btn.prop('disabled', false);
                    $btnText.text('Sign In');
                });
            }

            function select_demo_role(btn) {
                var $btn = $(btn);
                var role = $btn.data('demo-role');
                var username = $btn.data('demo-username');
                var password = $btn.data('demo-password');

                $('.demo-pill-btn').removeClass('active');
                $btn.addClass('active');

                if (username) {
                    $('#username').val(username);
                    $('#username-error').hide();
                }
                if (password) {
                    $('#password').val(password);
                    $('#password-error').hide();
                }

                $('#quick-demo-status-text').html('<strong>' + role + '</strong> credentials loaded (' + username + '). Ready to login.');
                $('#quick-demo-status').addClass('is-visible');
                $('#password').focus();
            }

            function refresh_captcha() {
                $.post('<?= base_url('site/refreshCaptcha'); ?>', {data: 'refresh'}, function(respData) {
                    $('#captcha_image').html(respData);
                }, 'html');
            }
        </script>
    </body>
</html>