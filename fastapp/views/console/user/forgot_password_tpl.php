<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#424242" />
    <title>Forgot Password - <?= isset($site_settings['site_setting_title']) ? html_escape($site_settings['site_setting_title']) : 'Medical Shop' ?></title>
    <link href="<?= base_url(); ?>assets/backend/images/s-favican.png" rel="shortcut icon" type="image/x-icon">

    <!-- CSS from assets/backend -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/style-main.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/usertemplate/assets/css/style.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 20px 0;
        }
        .login-box-custom {
            width: 100%;
            max-width: 440px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            overflow: hidden;
            margin: 0 auto;
        }
        .login-header-custom {
            background: #002b49;
            padding: 26px 20px 20px;
            text-align: center;
            color: #fff;
        }
        .login-header-custom img {
            max-height: 52px;
            margin-bottom: 10px;
        }
        .login-header-custom h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 500;
            color: #fff;
        }
        .login-body-custom {
            padding: 25px 30px;
        }
        .form-group.has-feedback .form-control {
            padding-right: 42.5px;
            height: 42px;
            border-radius: 4px;
        }
        .form-control-feedback {
            line-height: 42px;
            width: 42px;
            color: #888;
        }
        .btn-custom-primary {
            background: #0084b4;
            border-color: #0077a3;
            color: #fff;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 15px;
            border-radius: 4px;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-custom-primary:hover {
            background: #006b94;
            color: #fff;
        }
        .auth-footer-links {
            margin-top: 15px;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="login-box-custom">
    <div class="login-header-custom">
        <a href="<?= base_url(); ?>">
            <img src="<?= cdn_url(); ?>uploads/medicalbillings.png" alt="Logo" onerror="this.style.display='none'">
        </a>
        <h3><?= isset($site_settings['site_setting_title']) ? html_escape($site_settings['site_setting_title']) : 'Medical Shop' ?></h3>
        <p style="margin: 5px 0 0; color: #a0c4de; font-size: 13px;">Password Recovery</p>
    </div>

    <div class="login-body-custom">
        <div id="alert-box" class="alert alert-info" style="font-size: 13px;">
            <i class="fa fa-info-circle"></i> Please enter your registered username or email to recover password.
        </div>

        <form id="forgot_form" action="<?= console_url() ?>user/forgot_password" method="post" onsubmit="return handleForgotSubmit(this);">
            <div class="form-group has-feedback" id="group-username">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username / Email" required autofocus autocomplete="username">
                <span class="fa fa-user form-control-feedback"></span>
                <span class="help-block text-danger" id="help-username" style="display:none; font-size: 12px; margin-top: 4px;"></span>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" id="btn-submit" class="btn btn-custom-primary">
                    <i class="fa fa-paper-plane"></i> Reset Password
                </button>
            </div>

            <div class="auth-footer-links">
                <a href="<?= console_url('user/login'); ?>"><i class="fa fa-arrow-left"></i> Back to Login</a>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="<?= base_url(); ?>assets/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?= base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>

<script>
function handleForgotSubmit(form) {
    var $btn = $('#btn-submit');
    var origText = $btn.html();
    $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function(respData) {
            $btn.prop('disabled', false).html(origText);
            if (respData.status === 'success') {
                $('#alert-box').removeClass('alert-info alert-danger').addClass('alert alert-success')
                    .html('<i class="fa fa-check"></i> ' + respData.message);
                setTimeout(function() {
                    window.location = '<?= console_url("user/login") ?>';
                }, 2000);
            } else {
                $('#alert-box').removeClass('alert-info alert-success').addClass('alert alert-danger')
                    .html('<i class="fa fa-exclamation-triangle"></i> ' + (respData.message || 'Error occurred. Please try again.'));
            }
        },
        error: function() {
            $btn.prop('disabled', false).html(origText);
            $('#alert-box').removeClass('alert-info alert-success').addClass('alert alert-danger')
                .html('<i class="fa fa-exclamation-triangle"></i> Server error. Please try again later.');
        }
    });
    return false;
}
</script>

</body>
</html>