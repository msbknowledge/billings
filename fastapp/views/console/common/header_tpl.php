<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= isset($site_settings['site_setting_title']) ? $site_settings['site_setting_title'] : 'MSBBillings' ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="<?= isset($site_settings['site_setting_description']) ? $site_settings['site_setting_description'] : '' ?>">
    <meta name="theme-color" content="#424242" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= cdn_url() ?>img/simplebillingsfav.png" type="image/x-icon">

    <!-- Smart School & AdminLTE CSS (from assets/backend) -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/style-main.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/themes/default/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/themes/default/ss-main.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/ss-print.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/custom_style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/dropify.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/nprogress.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/datepicker/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/toast-alert/toastr.css">
    <link rel="stylesheet" href="<?= base_url(); ?>assets/backend/plugins/select2/select2.min.css">

    <!-- Compatibility & Tweaks for FastApp components -->
    <style type="text/css">
        span.flag-icon.flag-icon-us { text-orientation: mixed; }
        .label-important { background-color: #dd4b39; }
        .row-fluid { margin-left: 0; margin-right: 0; }
        .box { margin-bottom: 20px; background: #fff; border-radius: 4px; border-top: 3px solid #3c8dbc; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .box-header { padding: 10px 15px; border-bottom: 1px solid #f4f4f4; position: relative; }
        .box-header h2, .box-header .box-title { margin: 0; font-size: 18px; font-weight: 600; display: inline-block; color: #444; }
        .box-header .box-icon, .box-header .box-tools { float: right; margin-top: -2px; }
        .box-content, .box-body { padding: 15px; }
        .span12 { width: 100%; }
        .span6 { width: 50%; float: left; }
        .span4 { width: 33.3333%; float: left; }
        .span3 { width: 25%; float: left; }
        .span2 { width: 16.6666%; float: left; }
        .main-header .logo { display: block; float: left; height: 50px; font-size: 20px; line-height: 50px; text-align: center; width: 230px; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; padding: 0 15px; font-weight: 300; overflow: hidden; }
        .main-header .logo .logo-mini { display: none; }
        .sidebar-collapse .main-header .logo .logo-lg { display: none; }
        .sidebar-collapse .main-header .logo .logo-mini { display: inline-block; }
        .table_view_wrapper .pagination { margin: 10px 0; }
        .control-group { margin-bottom: 15px; }
        .control-group .control-label { font-weight: 600; margin-bottom: 5px; display: inline-block; }
        .control-group .controls input[type="text"], .control-group .controls input[type="password"], .control-group .controls select, .control-group .controls textarea {
            border-radius: 3px; border: 1px solid #d2d6de; padding: 6px 12px; height: 34px; line-height: 1.42857143;
        }
        .control-group .controls textarea { height: auto; }
        .sstopuser { padding: 15px; width: 280px; }
        .sstopuser .ssuserleft { float: left; margin-right: 15px; }
        .sstopuser .sstopuser-test { overflow: hidden; }
        .sstopuser .sspass { margin-top: 10px; padding-top: 10px; border-top: 1px solid #f4f4f4; }

        /* Select2 Multi-Select Choices / Badges UI Fix */
        .select2-container--default .select2-selection--multiple {
            background-color: #ffffff !important;
            border: 1px solid #d2d6de !important;
            border-radius: 4px !important;
            min-height: 34px !important;
            padding: 2px 6px !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3c8dbc !important;
            outline: 0 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3c8dbc !important;
            border: 1px solid #367fa9 !important;
            border-radius: 3px !important;
            color: #ffffff !important;
            padding: 3px 8px 3px 6px !important;
            margin: 3px 5px 3px 0 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            line-height: 18px !important;
            display: inline-block !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1) !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ffffff !important;
            font-size: 14px !important;
            font-weight: bold !important;
            margin-right: 6px !important;
            margin-left: 0 !important;
            cursor: pointer !important;
            display: inline-block !important;
            opacity: 0.8 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ffffff !important;
            opacity: 1 !important;
        }
        .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field {
            color: #333333 !important;
            font-size: 13px !important;
            margin-top: 3px !important;
            padding: 0 4px !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3c8dbc !important;
            color: #ffffff !important;
        }

        /* Universal Button Hover & Contrast System */
        .btn-primary {
            background-color: #3c8dbc !important;
            border-color: #367fa9 !important;
            color: #ffffff !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active, .btn-primary.hover {
            background-color: #286090 !important;
            border-color: #204d74 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-success, .btn-add-medicine, .addm {
            background-color: #00a65a !important;
            border-color: #008d4c !important;
            color: #ffffff !important;
        }
        .btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.hover,
        .btn-add-medicine:hover, .btn-add-medicine:focus, .addm:hover, .addm:focus {
            background-color: #008d4c !important;
            border-color: #00733e !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-info {
            background-color: #00c0ef !important;
            border-color: #00acd6 !important;
            color: #ffffff !important;
        }
        .btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.hover {
            background-color: #00acd6 !important;
            border-color: #0097bd !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-warning, .addmx {
            background-color: #f39c12 !important;
            border-color: #e08e0b !important;
            color: #ffffff !important;
        }
        .btn-warning:hover, .btn-warning:focus, .btn-warning:active, .btn-warning.hover,
        .addmx:hover, .addmx:focus {
            background-color: #d58512 !important;
            border-color: #c67605 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-danger {
            background-color: #dd4b39 !important;
            border-color: #d73925 !important;
            color: #ffffff !important;
        }
        .btn-danger:hover, .btn-danger:focus, .btn-danger:active, .btn-danger.hover {
            background-color: #c9302c !important;
            border-color: #ac2925 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .btn-default {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #334155 !important;
        }
        .btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.hover {
            background-color: #3c8dbc !important;
            border-color: #367fa9 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15) !important;
        }
        .btn-default:hover i, .btn-default:focus i, .btn-default:active i {
            color: #ffffff !important;
        }
        .search-form #search-btn, .search-form .topsidesearchbtn,
        #header_search_form #search-btn, #search-btn.topsidesearchbtn {
            background-color: #ffffff !important;
            border: 1px solid #d2d6de !important;
            border-left: none !important;
            color: #3c8dbc !important;
            height: 34px !important;
            line-height: 20px !important;
            padding: 6px 14px !important;
            border-radius: 0 4px 4px 0 !important;
            transition: all 0.2s ease-in-out !important;
        }
        .search-form #search-btn:hover, .search-form #search-btn:focus,
        .search-form .topsidesearchbtn:hover, .search-form .topsidesearchbtn:focus,
        #header_search_form #search-btn:hover, #header_search_form #search-btn:focus,
        #search-btn.topsidesearchbtn:hover, #search-btn.topsidesearchbtn:focus {
            background-color: #286090 !important;
            border-color: #204d74 !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2) !important;
        }
        .search-form #search-btn:hover i, .search-form #search-btn:focus i,
        .search-form .topsidesearchbtn:hover i, .search-form .topsidesearchbtn:focus i,
        #header_search_form #search-btn:hover i, #header_search_form #search-btn:focus i,
        #search-btn.topsidesearchbtn:hover i, #search-btn.topsidesearchbtn:focus i {
            color: #ffffff !important;
        }
        .search-table-form .input-group-btn .btn-default:hover,
        .table-filter-box .input-group-btn .btn-default:hover {
            background-color: #3c8dbc !important;
            border-color: #367fa9 !important;
            color: #ffffff !important;
        }
        .search-table-form .input-group-btn .btn-default:hover i,
        .table-filter-box .input-group-btn .btn-default:hover i {
            color: #ffffff !important;
        }
        a.btn[href*="add"]:hover, a.btn[href*="add"]:focus,
        a.btn[href*="create"]:hover, a.btn[href*="create"]:focus {
            color: #ffffff !important;
        }
        a.btn-primary[href*="add"]:hover, a.btn-primary[href*="add"]:focus {
            background-color: #286090 !important;
            color: #ffffff !important;
        }
        a.btn-success[href*="add"]:hover, a.btn-success[href*="add"]:focus {
            background-color: #008d4c !important;
            color: #ffffff !important;
        }
    </style>

    <!-- Global App Variables -->
    <script>
        var console_url = '<?= console_url() ?>';
        var cdn_url = '<?= cdn_url() ?>';
        var baseurl = '<?= base_url() ?>';
        var page_url = '<?= base_url() . $this->uri->segment(1) ?>/<?= $this->uri->segment(2) ?>/';
        var section = '<?= isset($orderByModelData) ? $orderByModelData : '' ?>';
    </script>

    <!-- jQuery from assets/backend -->
    <script src="<?= base_url(); ?>assets/backend/custom/jquery.min.js"></script>
    <script language="javascript" src="<?= base_url(); ?>assets/backend/custom/jquery-2.2.4.js"></script>
    <script language="Javascript" type="text/javascript" src="<?= cdn_url() ?>js/edit_area/edit_area_full.js"></script>
    <? execute_hook('header'); ?>
</head>

<? if ($current_user_session) { ?>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header" id="alert">
            <a href="<?= console_url() ?>" class="logo">
                <span class="logo-mini"><img src="<?= base_url() ?>msb/msbbillingslogo.png" onerror="this.onerror=null;this.src='<?= base_url() ?>backend/images/s-favican.png';" style="height:36px; max-width:40px;" alt="MSB" /></span>
                <span class="logo-lg"><img src="<?= base_url() ?>msb/msbbillingslogo.png" onerror="this.onerror=null;this.src='<?= base_url() ?>backend/images/s_logo.png';" style="height:42px; max-width:180px;" alt="MSB School" /></span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a class="sidebar-toggle" data-toggle="offcanvas" role="button" aria-label="Toggle sidebar">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="col-lg-4 col-md-3 col-sm-2 col-xs-4">
                    <span class="sidebar-session"><?= isset($site_settings['site_setting_title']) && !empty($site_settings['site_setting_title']) ? $site_settings['site_setting_title'] : 'MSB School' ?></span>
                </div>
                <div class="col-lg-8 col-md-9 col-sm-10 col-xs-8">
                    <div class="pull-right">
                        <form id="header_search_form" class="navbar-form navbar-left search-form" role="search" action="<?= console_url() ?>search" method="POST">
                            <input type='hidden' name='ci_csrf_token' value='' />
                            <div class="input-group">
                                <input type="text" value="" name="search_text1" id="search_text1" class="form-control search-form search-form3" placeholder="Search By Student Name, Roll Number, Enroll Number, National Id, Local Id Etc.">
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search-btn" class="btn btn-flat topsidesearchbtn"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </form>
                        <div class="navbar-custom-menu">
                            <div class="currency-icon-list" data-placement="bottom" data-toggle="tooltip" title="Currency">
                                <select class="languageselectpicker" id="currencySwitcher">
                                    <option data-content='EUR (€)' value="50"></option>
                                    <option data-content='GBP (£)' value="53"></option>
                                    <option data-content='INR (₹)' value="68" selected></option>
                                    <option data-content='RUB (RUB)' value="122"></option>
                                    <option data-content='SGD (SGD)' value="129"></option>
                                    <option data-content='USD ($)' value="150"></option>
                                </select>
                            </div>

                            <div class="langdiv" data-placement="bottom" data-toggle="tooltip" title="Language">
                                <select class="languageselectpicker" onchange="if(typeof set_languages === 'function') set_languages(this.value);" id="languageSwitcher">
                                    <option data-content='<span class="flag-icon flag-icon-us"></span> English' value="4" selected></option>
                                    <option data-content='<span class="flag-icon flag-icon-in"></span> Hindi' value="82"></option>
                                    <option data-content='<span class="flag-icon flag-icon-sa"></span> Arabic' value="5"></option>
                                    <option data-content='<span class="flag-icon flag-icon-ke"></span> Swahili' value="67"></option>
                                    <option data-content='<span class="flag-icon flag-icon-fr"></span> French' value="81"></option>
                                    <option data-content='<span class="flag-icon flag-icon-tr"></span> Turkish' value="75"></option>
                                    <option data-content='<span class="flag-icon flag-icon-ru"></span> Russian' value="61"></option>
                                    <option data-content='<span class="flag-icon flag-icon-de"></span> German' value="52"></option>
                                    <option data-content='<span class="flag-icon flag-icon-nl"></span> Dutch' value="19"></option>
                                </select>
                            </div>

                            <ul class="nav navbar-nav headertopmenu">
                                <li class="cal15" data-placement="bottom" data-toggle="tooltip" title="Switch Branch">
                                    <a href="#" data-toggle="modal" data-target="#multiBranchSwitchModal"><i class="fa fa-exchange" aria-hidden="true"></i></a>
                                </li>
                                <li class="cal15 d-sm-none">
                                    <a data-placement="bottom" data-toggle="tooltip" title="Calendar" href="<?= console_url() ?>calendar/events"><i class="fa fa-calendar"></i></a>
                                </li>
                                <li class="dropdown" data-placement="bottom" data-toggle="tooltip" title="Task">
                                    <a href="#" class="dropdown-toggle todoicon" data-toggle="dropdown">
                                        <i class="fa fa-check-square-o"></i>
                                        <span class="todo-indicator">1</span>
                                    </a>
                                    <ul class="dropdown-menu menuboxshadow">
                                        <li class="todoview plr10 ssnoti">Today You Have 1 Pending Task.<a href="<?= console_url() ?>calendar/events" class="pull-right pt0">View All</a></li>
                                        <li>
                                            <ul class="todolist">
                                                <li>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" id="newcheck805" onclick="if(typeof markc === 'function') markc('805');" name="eventcheck" value="805">World Environment Day</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown user-menu">
                                    <a class="dropdown-toggle" style="padding: 15px 12px;" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <img src="<?= !empty($current_user_session['user_image']) ? base_url('uploads/' . NODE . '/' . $current_user_session['user_image']) : 'https://demo.smart-school.in/uploads/staff_images/1.jpg?1785952647' ?>" class="topuser-image" alt="User Image">
                                    </a>
                                    <ul class="dropdown-menu dropdown-user menuboxshadow">
                                        <li>
                                            <div class="sstopuser">
                                                <div class="ssuserleft">
                                                    <a href="<?= console_url() ?>user/profile"><img src="<?= !empty($current_user_session['user_image']) ? base_url('uploads/' . NODE . '/' . $current_user_session['user_image']) : 'https://demo.smart-school.in/uploads/staff_images/1.jpg?1785952647' ?>" alt="User Image"></a>
                                                </div>
                                                <div class="sstopuser-test">
                                                    <h4 class="text-capitalize mb0">
                                                        <a href="<?= console_url() ?>user/profile">
                                                            <?= trim(($current_user_session['user_firstname'] ?? '') . ' ' . ($current_user_session['user_lastname'] ?? '')) ?: 'Admin' ?>
                                                        </a>
                                                    </h4>
                                                    <h5 class="mt0"><?= $current_user_session['user_login'] ?? 'admin' ?></h5>
                                                    <a href="<?= console_url() ?>user/edit_profile"><i class="fa fa-key"></i> Password</a>
                                                </div>
                                                <div class="divider"></div>
                                                <div class="sspass">
                                                    <a href="<?= base_url() ?>" target="_blank" class="forgot"><i class="fa fa-empire"></i> Front Site</a>
                                                    <a href="<?= console_url() ?>user/logout"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Left Sidebar (Smart School Style) -->
        <aside class="main-sidebar" id="alert2">
            <section class="sidebar" id="sibe-box">
                <? $this->load->view('console/elements/left_navigation_tpl'); ?>
            </section>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Breadcrumbs / Content Header -->
            <? $this->load->view('console/elements/breadcrumb_tpl'); ?>

            <!-- Main content section -->
            <section class="content" id="content">
                <noscript>
                    <div class="alert alert-warning">
                        <h4><i class="fa fa-warning"></i> Warning!</h4>
                        <p>You need to have JavaScript enabled to use this site.</p>
                    </div>
                </noscript>
<? } else { ?>
<body class="hold-transition login-page" style="background:#f0f2f5;">
    <div id="content">
<? } ?>