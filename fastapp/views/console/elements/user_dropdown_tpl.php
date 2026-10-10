<? if ($current_user_session): ?>
<li class="dropdown user-menu">
    <a class="dropdown-toggle" style="padding: 15px 12px; cursor: pointer; color: #fff;" data-toggle="dropdown" href="#" aria-expanded="false">
        <i class="fa fa-user-circle fa-lg" style="font-size: 20px; margin-right: 5px;"></i>
        <span class="hidden-xs"><?= $current_user_session['user_firstname'] . ' ' . $current_user_session['user_lastname'] ?></span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu dropdown-user menuboxshadow" style="width: 280px; padding: 10px; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
        <li>
            <div class="sstopuser">
                <div class="ssuserleft" style="float: left; margin-right: 15px;">
                    <i class="fa fa-user-circle text-primary" style="font-size: 46px; color: #3c8dbc;"></i>
                </div>
                <div class="sstopuser-test" style="overflow: hidden;">
                    <h4 class="text-capitalize" style="margin: 0; font-size: 16px; font-weight: 600;">
                        <a href="<?= console_url('user/profile') ?>" style="color: #333; text-decoration: none;"><?= $current_user_session['user_firstname'] . ' ' . $current_user_session['user_lastname'] ?></a>
                    </h4>
                    <h5 style="margin: 3px 0 6px 0; color: #777; font-size: 12px;">Administrator</h5>
                    <a href="<?= console_url('user/profile') ?>" class="btn btn-default btn-xs" style="font-size: 11px;"><i class="fa fa-user"></i> My Profile</a>
                </div>
                <div class="divider" style="margin: 10px 0; border-top: 1px solid #eee;"></div>
                <div class="sspass" style="display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= base_url() ?>" target="_blank" class="btn btn-default btn-sm" style="font-size: 12px;"><i class="fa fa-globe"></i> Front Site</a>
                    <a href="<?= console_url('user/logout') ?>" class="btn btn-danger btn-sm" style="font-size: 12px;"><i class="fa fa-sign-out"></i> Logout</a>
                </div>
            </div>
        </li>
    </ul>
</li>
<? endif; ?>