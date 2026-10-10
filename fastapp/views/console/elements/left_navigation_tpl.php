<? 
$nav = null;
if (isset($site_menu) && is_array($site_menu)) {
    foreach ($site_menu as $menu) {
        if (empty($menu['menu_parent_id'])) {
            if (isset($nav[$menu['menu_ID']]['child'])) {
                $children = $nav[$menu['menu_ID']]['child'];
                $nav[$menu['menu_ID']] = $menu;
                $nav[$menu['menu_ID']]['child'] = $children;
            } else {
                $nav[$menu['menu_ID']] = $menu;
            }
        } else {
            $nav[$menu['menu_parent_id']]['child'][$menu['menu_ID']] = $menu;
        }
    }
}
$currentSegment = $this->uri->segment(2);
if (empty($currentSegment)) $currentSegment = 'dashboard';
?>
<? if ($current_user_session): ?>
<ul class="sidebar-menu">
    <li class="header" style="color: #4b646f; background: #1a2226; padding: 10px 25px 10px 15px; font-size: 12px; text-transform: uppercase;">MAIN NAVIGATION</li>
    <li class="<?= ($currentSegment == 'dashboard') ? 'active' : '' ?>">
        <a href="<?= console_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <? if (is_array($nav)): ?>
        <? foreach ($nav as $key => $value): ?>
            <? 
            $icon = !empty($value['menu_icon_class']) ? $value['menu_icon_class'] : 'fa fa-folder-open-o';
            if (strpos($icon, 'icon-') !== false) {
                $icon = 'fa ' . str_replace('icon-', 'fa-', $icon);
            }
            if (strpos($icon, 'fa ') === false && strpos($icon, 'fa-') !== false) {
                $icon = 'fa ' . $icon;
            }
            ?>
            <? if (empty($value['child'])): ?>
                <? $isActive = ($currentSegment == $value['menu_link'] || $this->uri->segment(1) == $value['menu_link']) ? 'active' : ''; ?>
                <li class="<?= $isActive ?>">
                    <a href="<?= console_url($value['menu_link']) ?>" title="<?= isset($value['menu_hint']) ? $value['menu_hint'] : '' ?>">
                        <i class="<?= $icon ?>"></i> <span><?= $value['menu_name'] ?></span>
                    </a>
                </li>
            <? else: ?>
                <? 
                $isChildActive = false;
                foreach ($value['child'] as $ck => $cv) {
                    if ($currentSegment == $cv['menu_link'] || $this->uri->segment(1) == $cv['menu_link']) {
                        $isChildActive = true;
                        break;
                    }
                }
                ?>
                <li class="treeview <?= $isChildActive ? 'active' : ''; ?>">
                    <a href="#" title="<?= isset($value['menu_hint']) ? $value['menu_hint'] : '' ?>">
                        <i class="<?= $icon ?>"></i> <span><?= $value['menu_name'] ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        <? foreach ($value['child'] as $ckey => $cvalue): ?>
                            <? 
                            $cicon = !empty($cvalue['menu_icon_class']) ? $cvalue['menu_icon_class'] : 'fa fa-angle-double-right';
                            if (strpos($cicon, 'icon-') !== false) {
                                $cicon = 'fa ' . str_replace('icon-', 'fa-', $cicon);
                            }
                            if (strpos($cicon, 'fa ') === false && strpos($cicon, 'fa-') !== false) {
                                $cicon = 'fa ' . $cicon;
                            }
                            $isCActive = ($currentSegment == $cvalue['menu_link'] || $this->uri->segment(1) == $cvalue['menu_link']) ? 'active' : '';
                            ?>
                            <li class="<?= $isCActive ?>">
                                <a href="<?= console_url($cvalue['menu_link']) ?>" title="<?= isset($cvalue['menu_hint']) ? $cvalue['menu_hint'] : '' ?>">
                                    <i class="<?= $cicon ?>"></i> <span><?= $cvalue['menu_name'] ?></span>
                                </a>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </li>
            <? endif; ?>
        <? endforeach; ?>
    <? endif; ?>
</ul>
<? endif; ?>
