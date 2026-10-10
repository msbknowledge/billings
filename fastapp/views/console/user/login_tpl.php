<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#424242" />
        <title>Login : <?php echo isset($name) ? $name : 'MsbBillings'; ?></title>
        <link href="<?= base_url() ?>backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>backend/usertemplate/assets/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=DM+Sans:400,500,600,700">
        <style>
            html, body { min-height: 100%; }
            body { background: #fff; color: #39434b; font-family: 'Roboto', sans-serif; }
            .top-content { min-height: 100vh; padding: 0; }
            .inner-bg { padding: 0; background: transparent; }
            .top-content .container-fluid { width: 100%; max-width: none; padding: 0; }
            .top-content .row { margin: 0; }
            .bgoffsetbg { position: relative; display: flex; min-height: 100vh; align-items: stretch; justify-content: flex-start; overflow: hidden; background: #fff; }
            .bgoffsetbg > [class*="col-"] { float: none; }
            .bgoffsetbg > .nopadding { position: static; flex: 0 0 32%; }
            .bgoffsetbg > .nopadding-2 { display: flex; min-width: 0; flex: 1 1 auto; align-items: center; justify-content: center; background: #898989; }
            .bgoffsetbg .nopadding, .bgoffsetbg .nopadding-2 { padding: 0; }
            .loginbg { display: flex; width: 100%; max-width: none; min-height: 100%; flex-direction: column; align-items: stretch; justify-content: flex-start; background: #fff; }
            .loginbg .form-top { width: 100%; padding: 35px 28px 18px; border: 0; background: transparent; }
            .loginbg .form-top img { max-width: 100%; max-height: 80px !important; }
            .loginbg .form-bottom { position: static; box-sizing: border-box; width: 100%; max-width: 100%; margin: 0 auto; padding: 18px 28px 30px; background: transparent; }
            .loginbg .form-bottom h3 { margin: 0 0 22px; color: #35404a; font-size: 22px; font-weight: 500; }
            .login-intro { display: none; }
            #login-message { margin-bottom: 18px; border: 0; border-radius: 4px; }
            .loginbg .form-group { margin: 0 0 16px; }
            .loginbg .form-control { height: 50px; padding: 12px 15px; border: 1px solid #dce6e0; border-radius: 6px; box-shadow: none; color: #20352e; }
            .loginbg .form-control:focus { border-color: #37856a; box-shadow: 0 0 0 3px rgba(55, 133, 106, .12); }
            .loginbg .form-control-feedback { top: 8px; right: 10px; color: #87968e; }
            .loginbg .help-inline { display: block; margin-top: 5px; }
            .login-options { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin: 4px 0 20px; color: #65756d; }
            .login-options label { margin: 0; font-weight: 400; }
            .login-options input { margin-right: 6px; accent-color: #28694f; }
            .login-options a { color: #28694f; }
            .login-submit { height: 50px; border: 0; border-radius: 4px; background: #28a745; font-size: 15px; font-weight: 600; transition: background .2s; }
            .login-submit:hover, .login-submit:focus { background: #218838; }
            .login-demo-note { margin: 18px 0 0; color: #839088; font-size: 12px; text-align: center; }
                        .login-demo-note { display: none; }
                        .quick-demo { margin-top: 22px; padding-top: 16px; border-top: 1px solid #dfe5ea; }
                        .quick-demo-title { margin: 0 0 12px; color: #63717e; font-size: 13px; font-weight: 700; }
                        .quick-demo-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 9px; }
                        .quick-demo-button { min-width: 0; min-height: 48px; padding: 7px 5px; border: 0; border-radius: 5px; color: #fff; font-size: 13px; font-weight: 700; line-height: 1.2; }
                        .quick-demo-button:hover, .quick-demo-button:focus { filter: brightness(.92); }
                        .quick-demo-button:focus-visible { outline: 3px solid rgba(0, 150, 136, .3); outline-offset: 2px; }
                        .demo-super-admin, .demo-accountant { background: #078bb4; }
                        .demo-admin, .demo-nurse { background: #18b8ce; }
                        .demo-doctor, .demo-pharmacist { background: #999; }
                        .demo-pathologist { background: #e91e63; }
                        .demo-radiologist { background: #43a047; }
                        .demo-receptionist { background: #008db3; }
                        .quick-demo-status { display: none; margin: 10px 0 0; color: #6e7b86; font-size: 12px; }
                        .quick-demo-status.is-visible { display: block; }
                        .login-footer-links { display: flex; justify-content: space-between; gap: 12px; margin-top: 20px; padding-top: 14px; border-top: 1px solid #dfe5ea; }
                        .login-footer-links a { color: #00a99d; font-size: 14px; font-weight: 700; text-decoration: none; }
                        .login-footer-links a:hover { color: #087f78; text-decoration: underline; }
            .login-news-layout { width: 92%; max-width: 940px; }
            .login-news-card { padding: 30px 36px; border-radius: 6px; background: #3d3d3d; box-shadow: 0 8px 26px rgba(0,0,0,.18); color: #fff; }
            .login-news-card > h3 { margin: 0 0 26px; color: #fff; font-size: 26px; font-weight: 700; text-align: center; }
            .login-news-card .loginright { max-height: 410px; overflow-y: auto; padding: 0 14px; }
            .login-news-card .messages h4 { margin: 0 0 12px; color: #fff; font-size: 17px; font-weight: 500; }
            .login-news-card .messages p { margin: 0 0 8px; color: #eee; font-size: 14px; line-height: 1.5; }
            .login-news-card .messages a { color: #42b95d; text-decoration: none; }
            .login-news-card .logdivider { margin: 20px 0; border-top: 1px solid #777; }
            @media (max-width: 767px) {
                .top-content { padding: 0; }
                .bgoffsetbg { min-height: 100vh; }
                .bgoffsetbg { flex-direction: column; }
                .bgoffsetbg > .nopadding { width: 100%; flex-basis: auto; }
                .bgoffsetbg > .nopadding-2 { display: none; }
                .loginbg .form-top { padding: 28px 24px 12px; }
                .loginbg .form-bottom { padding: 16px 24px 30px; }
                .loginbg .form-bottom h3 { font-size: 26px; }
                .login-news-card { padding: 24px; }
            }
            @media (max-width: 420px) {
                .login-options { align-items: flex-start; flex-direction: column; }
                .quick-demo-button { min-height: 44px; font-size: 11px; }
            }
        </style>
   <body>
        <!-- Top content -->
        <div class="top-content">
            <div class="inner-bg">
                <div class="container-fluid">
                    <div class="row">
                        <div class="bgoffsetbg">
                                <!-- Login Box (Left Column) -->
                                <div class="col-lg-4 col-md-4 col-sm-12 nopadding ">
                                    <div class="loginbg">
                                        <div class="form-top">
                                            <div class="form-top-left logowidth text-center">
                                                <img src="<?= base_url() ?>backend/images/s_logo.png" onerror="this.onerror=null;this.src='<?= base_url() ?>backend/images/mount-carmel-logo.png';" alt="MsbBillings Logo" style="clear: both; margin: 0 auto; text-align: center; max-height: 80px;" />
                                            </div>
                                        </div>
                                        <div class="form-bottom">
                                            <h3 class="font-white">Welcome To MsbBillings</h3>
                                            
                                            <!-- Alert Message Display -->
                                            <div id="login-message" class="alert alert-info">
                                                <div>Please login with your Username and Password.</div>
                                            </div>
    
                                            <?php if (isset($error_message)): ?>
                                                <div class='alert alert-danger'><?= $error_message ?></div>
                                            <?php endif; ?>
    
                                            <?php if ($this->session->flashdata('message')): ?>
                                                <div class='alert alert-success'><?= $this->session->flashdata('message') ?></div>
                                            <?php endif; ?>
    
                                            <!-- Sign-in Form -->
                                            <form class="form-horizontal" id="signin_form" action="<?= console_url() ?>user/login" onsubmit="return false" method="post">
                                                
                                                <!-- Username Input -->
                                                <div class="form-group has-feedback">
                                                    <label class="sr-only" for="username">Username</label>
                                                    <input autofocus autocomplete="username" class="form-control" from-validation="required" name="username" id="username" placeholder="Username" type="text" value="" />
                                                    <span class="fa fa-user form-control-feedback"></span>
                                                    <span class="help-inline text-danger" style="display:none">Please Enter Username</span>
                                                </div>
    
                                                <!-- Password Input -->
                                                <div class="form-group has-feedback">
                                                    <label class="sr-only" for="password">Password</label>
                                                    <input autocomplete="current-password" class="form-control" from-validation="required" name="password" id="password" placeholder="Password" type="password" value="" />
                                                    <span class="fa fa-lock form-control-feedback"></span>
                                                    <span class="help-inline text-danger" style="display:none">Please Enter Password</span>
                                                </div>
    
                                                <!-- Optional Captcha (if active) -->
                                                <?php if (isset($is_captcha) && $is_captcha): ?>
                                                    <div class="form-group has-feedback row">
                                                        <div class='col-lg-7 col-md-12 col-sm-6'>
                                                            <span id="captcha_image"><?= $captcha_image ?? '' ?></span>
                                                            <span class="fa fa-refresh captcha" title="Refresh Captcha" onclick="refresh_captcha()"></span>
                                                        </div>
                                                        <div class='col-lg-5 col-md-12 col-sm-6'>
                                                            <input type="text" name="captcha" placeholder="Captcha" autocomplete="off" class="form-control" id="captcha">
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
    
                                                <!-- Form Options -->
                                                <div class="form-group login-options">
                                                    <label for="remember">
                                                        <input type="checkbox" name="remember" id="remember" /> Remember me
                                                    </label>
                                                    <a href="<?= console_url('user/forgot_password'); ?>" class="forgot">
                                                        <i class="fa fa-key"></i> Forgot Password?
                                                    </a>
                                                </div>
    
                                                <!-- Submit Button -->
                                                <button type="submit" onclick="validate_signin_form($('#signin_form'));" class="btn btn-primary btn-block login-submit">
                                                    Login
                                                </button>
                                            </form>
                                            <section class="quick-demo" aria-labelledby="quick-demo-title">
                                                <h4 class="quick-demo-title" id="quick-demo-title">QUICK DEMO LOGIN</h4>
                                                <div class="quick-demo-grid">
                                                    <button class="quick-demo-button demo-super-admin" type="button" data-demo-role="Super Admin" data-demo-username="admin" data-demo-password="admin123" onclick="select_demo_role(this)">Super Admin</button>
                                                    <button class="quick-demo-button demo-admin" type="button" data-demo-role="Admin" onclick="select_demo_role(this)">Admin</button>
                                                    <button class="quick-demo-button demo-doctor" type="button" data-demo-role="Doctor" onclick="select_demo_role(this)">Doctor</button>
                                                    <button class="quick-demo-button demo-pharmacist" type="button" data-demo-role="Pharmacist" onclick="select_demo_role(this)">Pharmacist</button>
                                                    <button class="quick-demo-button demo-pathologist" type="button" data-demo-role="Pathologist" onclick="select_demo_role(this)">Pathologist</button>
                                                    <button class="quick-demo-button demo-radiologist" type="button" data-demo-role="Radiologist" onclick="select_demo_role(this)">Radiologist</button>
                                                    <button class="quick-demo-button demo-accountant" type="button" data-demo-role="Accountant" onclick="select_demo_role(this)">Accountant</button>
                                                    <button class="quick-demo-button demo-receptionist" type="button" data-demo-role="Receptionist" onclick="select_demo_role(this)">Receptionist</button>
                                                    <button class="quick-demo-button demo-nurse" type="button" data-demo-role="Nurse" onclick="select_demo_role(this)">Nurse</button>
                                                </div>
                                                <p class="quick-demo-status" id="quick-demo-status" role="status" aria-live="polite"></p>
                                            </section>
                                            <nav class="login-footer-links" aria-label="Login links">
                                                <a href="#signin_form" onclick="document.getElementById('username').focus();">User Login</a>
                                                <a href="<?= base_url('landing') ?>">Front Site</a>
                                            </nav>
                                    </div>
                                </div>
                                </div>

                            <div class="col-lg-8 col-md-8 col-sm-12 nopadding-2">
                                       <div class="login-news-layout">
                                        <div class="login-news-card">
                                                                           
                                        <h3 class="h3">What's New In Mount Carmel School   </h3>
                                        <div class="loginright mCustomScrollbar _mCS_1"><div id="mCSB_1" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px;" dir="ltr">
                                            <div class="messages"> 
    
                                                                                                <h4>National Level Workshop for Science Teachers Teaching in Class X to XII (Online)</h4>
    
    													<p>A two-day capacity building programme was... <a class="more" href="https://demo.smart-school.in/read/national-level-workshop-for-science-teachers-teaching-in-class-x-to-xii-online-2" target="_blank">Read More</a></p>
                                                    <div class="logdivider"></div>
                                                                                                    <h4>New Books Added to Library</h4>
    
    													<p>The school library has added new educational and... <a class="more" href="https://demo.smart-school.in/read/new-books-added-to-library" target="_blank">Read More</a></p>
                                                    <div class="logdivider"></div>
                                                                                                    <h4>Unit Test Schedule Released</h4>
    
    													<p>The schedule for the upcoming unit test has been... <a class="more" href="https://demo.smart-school.in/read/unit-test-schedule-released" target="_blank">Read More</a></p>
                                                    <div class="logdivider"></div>
                                                                                                    <h4>The Junior Red Cross</h4>
    
    													<p>“Happiness doesn’t result from what we get, but... <a class="more" href="https://demo.smart-school.in/read/the-junior-red-cross" target="_blank">Read More</a></p>
                                                    <div class="logdivider"></div>
                                                                                                    <h4>Parents and Guardians Teacher's Meeting</h4>
    
    													<p>Dear parents and guardians,&nbsp;
    
    &nbsp;There... <a class="more" href="https://demo.smart-school.in/read/parents-and-guardians-teachers-meeting" target="_blank">Read More</a></p>
                                                    <div class="logdivider"></div>
                                                                                            </div>  
                                        </div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 200px; display: block; height: 141px; max-height: 260px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 200px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
                                                                          </div>  
                                      </div>  
                                    </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
        <!-- JS Scripts -->
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.backstretch.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mCustomScrollbar.min.js"></script>
        <script src="<?php echo base_url(); ?>backend/usertemplate/assets/js/jquery.mousewheel.min.js"></script>

        <!-- Form Validation and AJAX Logic -->
        <script type="text/javascript">
            function validate_signin_form(targetForm) {
                if (typeof validate_form === "function") {
                    if (validate_form(targetForm, {
                        beforeValidation: function (targetObject) {
                            $(targetObject).parent().children('.help-inline').hide().css('color', '#333333');
                        },
                        onValidationError: function (targetObject) {
                            $(targetObject).parent().children('.help-inline').show().css('color', 'red');
                        },
                        captchaValidator: function (targetObject) {
                            return validate_captcha(targetObject);
                        },
                        duplicateValidator: function (targetObject) {
                            return duplicate_check(targetObject);
                        }
                    })) {
                        ajax_signin_form_submit(targetForm);
                    }
                } else {
                    // Fallback basic client-side check if custom validate_form library isn't loaded
                    var valid = true;
                    $(targetForm).find('input[from-validation="required"]').each(function() {
                        if ($(this).val().trim() === '') {
                            $(this).siblings('.help-inline').show().css('color', 'red');
                            valid = false;
                        } else {
                            $(this).siblings('.help-inline').hide();
                        }
                    });
                    if (valid) {
                        ajax_signin_form_submit(targetForm);
                    }
                }
                return false;
            }

            function ajax_signin_form_submit(targetForm) {
                $.post($(targetForm).attr('action'), $(targetForm).serialize(), function (respData) {
                    if (respData.status === 'success') {
                        $('.alert').removeClass('alert-info alert-danger')
                        $('#login-message').removeClass('alert-info alert-danger')
                                   .addClass('alert-success')
                                   .html(respData.message);
                        setTimeout(function () {
                            window.location = '<?= console_url() ?>';
                        }, 1000);
                    } else {
                        $('.alert').removeClass('alert-info alert-success')
                        $('#login-message').removeClass('alert-info alert-success')
                                   .addClass('alert-danger')
                                   .html(respData.message);
                    }
                }, 'json');
            }

            function validate_captcha(targetObject) {
                var success = false;
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "<?= base_url('site/captcha_check'); ?>",
                    dataType: 'json',
                    data: {captcha: $(targetObject).val()}
                }).done(function (respData) {
                    success = (respData.status === 'success');
                });
                return success;
            }

            function refresh_captcha() {
                $.post('<?= base_url('site/refreshCaptcha'); ?>', {data: 'refresh'}, function (respData) {
                    $('#captcha_image').html(respData);
                }, 'html');
            }

            function duplicate_check(targetObject) {
                var success = false;
                $.ajax({
                    type: "POST",
                    async: false,
                    url: "duplicate_check",
                    dataType: 'json',
                    data: {duplicate: $(targetObject).val()}
                }).done(function (respData) {
                    if (respData.status === 'success') {
                        success = true;
                    } else {
                        alert(respData.message);
                        success = false;
                    }
                });
                return success;
            }
        </script>
        <script>
    function select_demo_role(button) {
        var status = document.getElementById('quick-demo-status');
        var username = button.getAttribute('data-demo-username');
        var password = button.getAttribute('data-demo-password');

        if (username !== null && password !== null) {
            document.getElementById('username').value = username;
            document.getElementById('password').value = password;
            status.textContent = button.getAttribute('data-demo-role') + ' credentials filled.';
        } else {
            status.textContent = button.getAttribute('data-demo-role') + ' selected. Enter the account credentials above.';
        }
        status.classList.add('is-visible');
        document.getElementById('username').focus();
    }

    function copy(email, password)
    {
        document.getElementById("username").value = email;
        document.getElementById("password").value = password;
    }
</script>
    </body>
</html>