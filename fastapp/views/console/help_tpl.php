<?php
/**
 * Modern Pharmacy Management Help Center & Interactive Tutorials
 * Professional AdminLTE / Bootstrap 3 responsive template
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Helper function to resolve image url
if (!function_exists('resolve_help_img_url')) {
    function resolve_help_img_url($raw_link) {
        $link = trim($raw_link);
        if (empty($link)) {
            return base_url('assets/backend/dist/img/noImage.jpg');
        }
        if (strpos($link, '{') !== false) {
            $parsed = json_decode($link, true);
            if (!empty($parsed['filename'])) {
                $link = $parsed['filename'];
            } elseif (!empty($parsed['thumbnail'])) {
                return $parsed['thumbnail'];
            }
        }
        if (strpos($link, 'http://') === 0 || strpos($link, 'https://') === 0) {
            return $link;
        }
        return base_url('uploads/' . ltrim($link, '/'));
    }
}

// Process help items
$processed_helps = array();

if (!empty($help_data) && is_array($help_data)) {
    foreach ($help_data as $row) {
        $type = isset($row['help_type']) ? trim($row['help_type']) : '';
        // Only show medical helps or matching NODETYPE
        if ($type !== 'medical' && defined('NODETYPE') && $type !== NODETYPE && $type !== '') {
            continue;
        }

        $title = trim(str_replace(array("\r", "\n"), '', $row['help_title']));
        if (empty($title)) continue;

        $img_url = resolve_help_img_url(isset($row['link']) ? $row['link'] : '');

        // Default meta classification
        $category = 'Master Records';
        $category_slug = 'masters';
        $icon = 'fa-folder-open';
        $badge_color = 'bg-purple';
        $target_url = console_url('medicine');
        $target_label = 'Open Module';
        $steps = array();

        $upper = strtoupper($title);

        if (strpos($upper, 'CATEGORY') !== false) {
            $category = 'Medicines & Inventory';
            $category_slug = 'inventory';
            $icon = 'fa-tags';
            $badge_color = 'bg-aqua';
            $target_url = console_url('medicine_category');
            $target_label = 'Medicine Categories';
            $steps = array(
                'Navigate to <strong>Entry &rarr; Medicine Categories</strong> in the sidebar menu.',
                'Click <strong>Add Category</strong> and type category name (e.g., Tablet, Syrup, Injection).',
                'Click <strong>Save</strong> to make it available during medicine registration.'
            );
        } elseif (strpos($upper, 'PURCHASE') !== false) {
            $category = 'Purchases & Stock In';
            $category_slug = 'purchase';
            $icon = 'fa-truck';
            $badge_color = 'bg-blue';
            $target_url = console_url('purchase');
            $target_label = 'Manage Purchases';
            $steps = array(
                'Go to <strong>Billing &rarr; Purchase</strong> and click <strong>Create Purchase</strong>.',
                'Select Supplier and enter Invoice Number, Invoice Date, and Payment Mode.',
                'Add medicine rows, enter Batch No, Expiry Date (MM/YYYY), Purchase Rate, MRP, and Quantity.',
                'Click <strong>Submit Purchase</strong>. Warehouse stock updates immediately.'
            );
        } elseif (strpos($upper, 'SALE') !== false || strpos($upper, 'INVOICE') !== false) {
            $category = 'Sales & POS Billing';
            $category_slug = 'sales';
            $icon = 'fa-shopping-cart';
            $badge_color = 'bg-green';
            $target_url = console_url('sale');
            $target_label = 'Open Sales POS';
            $steps = array(
                'Go to <strong>Billing &rarr; Sale &rarr; Create Sale</strong> to open POS Billing.',
                'Select walk-in or search registered Customer and prescribing Doctor.',
                'Type medicine name or scan barcode to automatically load batch & selling price.',
                'Enter quantity, adjust discount if needed, and click <strong>Generate & Print Invoice</strong>.'
            );
        } elseif (strpos($upper, 'PAYMENT') !== false || strpos($upper, 'DUE') !== false) {
            $category = 'Accounts & Payments';
            $category_slug = 'accounts';
            $icon = 'fa-money';
            $badge_color = 'bg-yellow';
            $target_url = console_url('payments');
            $target_label = 'View Payments';
            $steps = array(
                'Go to <strong>Billing &rarr; Payments</strong> or <strong>Customer Payments</strong>.',
                'Search customer or supplier ledger to view balance dues.',
                'Enter received payment amount, payment method (Cash, UPI, Card), and reference note.',
                'Save payment to automatically update ledger balance and print receipt.'
            );
        } elseif (strpos($upper, 'MEDICINE') !== false) {
            $category = 'Medicines & Inventory';
            $category_slug = 'inventory';
            $icon = 'fa-medkit';
            $badge_color = 'bg-teal';
            $target_url = console_url('medicine');
            $target_label = 'Medicines List';
            $steps = array(
                'Go to <strong>Entry &rarr; Medicine</strong> and click <strong>Add Medicine</strong>.',
                'Fill Medicine Name, Generic Composition, Category, Manufacturer, and Unit (Strips, Bottles).',
                'Specify default Rack/Storage shelf location for quick physical retrieval during sales.',
                'Click <strong>Save</strong> to register the medicine into catalog.'
            );
        } elseif (strpos($upper, 'DOCTOR') !== false) {
            $category = 'Master Records';
            $category_slug = 'masters';
            $icon = 'fa-user-md';
            $badge_color = 'bg-purple';
            $target_url = console_url('doctor');
            $target_label = 'Doctors Directory';
            $steps = array(
                'Go to <strong>Entry &rarr; Doctor</strong> and click <strong>Add Doctor</strong>.',
                'Enter Doctor Name, Specialization, Clinic/Hospital, Phone Number, and Registration No.',
                'Save details. Prescribing doctor can now be linked directly on sale bills.'
            );
        } elseif (strpos($upper, 'CUSTOMER') !== false) {
            $category = 'Master Records';
            $category_slug = 'masters';
            $icon = 'fa-users';
            $badge_color = 'bg-maroon';
            $target_url = console_url('customer');
            $target_label = 'Customer Records';
            $steps = array(
                'Go to <strong>Entry &rarr; Customer</strong> and click <strong>Add Customer</strong>.',
                'Enter Customer Full Name, Mobile Phone Number, Address, and GSTIN (if B2B).',
                'Save record for credit tracking, invoice history, and loyalty records.'
            );
        } elseif (strpos($upper, 'SUPPLIER') !== false) {
            $category = 'Master Records';
            $category_slug = 'masters';
            $icon = 'fa-briefcase';
            $badge_color = 'bg-navy';
            $target_url = console_url('supplier');
            $target_label = 'Suppliers Directory';
            $steps = array(
                'Go to <strong>Entry &rarr; Supplier</strong> and click <strong>Add Supplier</strong>.',
                'Enter Distributor Name, Drug License (DL) Number, GST Number, Address, and Contact.',
                'Save details to link vendor on purchase bills.'
            );
        } elseif (strpos($upper, 'MANUFACTUR') !== false) {
            $category = 'Master Records';
            $category_slug = 'masters';
            $icon = 'fa-industry';
            $badge_color = 'bg-gray';
            $target_url = console_url('manufacturer');
            $target_label = 'Manufacturers';
            $steps = array(
                'Go to <strong>Entry &rarr; Manufacturer</strong> and click <strong>Add Manufacturer</strong>.',
                'Add Pharma Company name (e.g., Cipla, Sun Pharma, Mankind, Abbott).',
                'Associate medicines to this manufacturer for filtered purchasing and reporting.'
            );
        } elseif (strpos($upper, 'DASHBOARD') !== false) {
            $category = 'Analytics & Overview';
            $category_slug = 'analytics';
            $icon = 'fa-tachometer';
            $badge_color = 'bg-red';
            $target_url = console_url('dashboard');
            $target_label = 'Main Dashboard';
            $steps = array(
                'Access central store overview showing daily sales totals, purchases, and profits.',
                'Review immediate shortage badges and expiring medicine notifications.',
                'Use quick action buttons for high-speed POS billing and purchase entry.'
            );
        }

        $processed_helps[] = array(
            'id' => isset($row['help_id']) ? $row['help_id'] : 0,
            'title' => $title,
            'desc' => !empty($row['help_description']) ? $row['help_description'] : '',
            'image' => $img_url,
            'category' => $category,
            'category_slug' => $category_slug,
            'icon' => $icon,
            'badge_color' => $badge_color,
            'target_url' => $target_url,
            'target_label' => $target_label,
            'steps' => $steps
        );
    }
}
?>

<div class="help-center-wrapper">
    <!-- Top Hero Banner -->
    <div class="help-hero-banner">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="help-hero-content">
                    <span class="help-badge-pill"><i class="fa fa-life-ring"></i> Knowledge Base & Video Guides</span>
                    <h2 class="help-hero-title">Medical Store Help & Interactive Walkthroughs</h2>
                    <p class="help-hero-subtitle">
                        Step-by-step visual tutorials, animated workflows, and quick-access operational guidelines to run your pharmacy efficiently.
                    </p>
                    
                    <!-- Search Input Box -->
                    <div class="help-search-container">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="fa fa-search text-muted"></i></span>
                            <input type="text" id="helpSearchInput" class="form-control" placeholder="Search guides (e.g. medicine, sale, doctor, purchase, payment)..." autocomplete="off" />
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="clearSearchBtn" title="Clear Search" style="display: none;">
                                    <i class="fa fa-times text-muted"></i>
                                </button>
                            </span>
                        </div>
                        <div class="help-search-meta">
                            <span id="helpResultCounter"><strong id="visibleCount"><?= count($processed_helps) ?></strong> of <?= count($processed_helps) ?> guides available</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Shortcut Cards -->
            <div class="col-md-4 col-sm-12">
                <div class="help-quick-nav-box">
                    <h4 class="quick-nav-title"><i class="fa fa-bolt text-warning"></i> Quick Module Shortcuts</h4>
                    <div class="quick-nav-links">
                        <a href="<?= console_url('medicine') ?>" class="quick-nav-btn">
                            <i class="fa fa-medkit text-teal"></i>
                            <div class="q-text">
                                <strong>Medicines Master</strong>
                                <span>Catalog, Batch & Rack</span>
                            </div>
                            <i class="fa fa-angle-right q-arrow"></i>
                        </a>
                        <a href="<?= console_url('sale') ?>" class="quick-nav-btn">
                            <i class="fa fa-shopping-cart text-green"></i>
                            <div class="q-text">
                                <strong>Sales POS & Billing</strong>
                                <span>Create Invoices & Receipts</span>
                            </div>
                            <i class="fa fa-angle-right q-arrow"></i>
                        </a>
                        <a href="<?= console_url('purchase') ?>" class="quick-nav-btn">
                            <i class="fa fa-truck text-blue"></i>
                            <div class="q-text">
                                <strong>Vendor Purchases</strong>
                                <span>Inward Stock & GST Bills</span>
                            </div>
                            <i class="fa fa-angle-right q-arrow"></i>
                        </a>
                        <a href="<?= console_url('medicine_stock/expiring_view') ?>" class="quick-nav-btn">
                            <i class="fa fa-calendar-times-o text-red"></i>
                            <div class="q-text">
                                <strong>Expiry & Shortage</strong>
                                <span>Stock Audit & Alerts</span>
                            </div>
                            <i class="fa fa-angle-right q-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter Bar -->
    <div class="help-filter-bar">
        <ul class="nav nav-pills" id="helpCategoryFilter">
            <li class="active"><a href="#" data-filter="all"><i class="fa fa-th-large"></i> All Tutorials (<?= count($processed_helps) ?>)</a></li>
            <li><a href="#" data-filter="inventory"><i class="fa fa-medkit"></i> Medicines & Inventory</a></li>
            <li><a href="#" data-filter="sales"><i class="fa fa-shopping-cart"></i> Sales & POS</a></li>
            <li><a href="#" data-filter="purchase"><i class="fa fa-truck"></i> Purchases</a></li>
            <li><a href="#" data-filter="accounts"><i class="fa fa-money"></i> Accounts & Payments</a></li>
            <li><a href="#" data-filter="masters"><i class="fa fa-address-book"></i> Masters (Doctors, Vendors)</a></li>
            <li><a href="#" data-filter="analytics"><i class="fa fa-tachometer"></i> Dashboard</a></li>
        </ul>
        <div class="help-expand-actions">
            <button type="button" class="btn btn-default btn-sm" id="btnExpandAll" title="Expand all guides">
                <i class="fa fa-plus-square-o"></i> Expand All
            </button>
            <button type="button" class="btn btn-default btn-sm" id="btnCollapseAll" title="Collapse all guides">
                <i class="fa fa-minus-square-o"></i> Collapse All
            </button>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="row">
        <!-- Guides Column -->
        <div class="col-md-9 col-sm-12">
            <div id="helpGuidesList" class="help-guides-container">
                <?php if (empty($processed_helps)): ?>
                    <div class="alert alert-info">
                        <h4><i class="fa fa-info-circle"></i> No Help Guides Found</h4>
                        <p>There are currently no tutorials registered for this module.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($processed_helps as $idx => $guide): ?>
                        <div class="help-guide-card" data-category="<?= $guide['category_slug'] ?>" data-title="<?= strtolower(htmlspecialchars($guide['title'])) ?>">
                            <!-- Card Header (Click to toggle) -->
                            <div class="guide-card-header" data-toggle="collapse" data-target="#guide-collapse-<?= $guide['id'] ?>" aria-expanded="<?= $idx === 0 ? 'true' : 'false' ?>">
                                <div class="guide-header-left">
                                    <span class="guide-num-badge">#<?= sprintf('%02d', $idx + 1) ?></span>
                                    <div class="guide-title-box">
                                        <h3 class="guide-title">
                                            <?= htmlspecialchars($guide['title']) ?>
                                        </h3>
                                        <div class="guide-badges">
                                            <span class="label <?= $guide['badge_color'] ?>"><i class="fa <?= $guide['icon'] ?>"></i> <?= $guide['category'] ?></span>
                                            <span class="label label-default"><i class="fa fa-play-circle"></i> Animated Guide</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="guide-header-right">
                                    <a href="<?= $guide['target_url'] ?>" class="btn btn-xs btn-primary guide-module-link" onclick="event.stopPropagation();" target="_blank" title="Open <?= $guide['target_label'] ?> in new tab">
                                        <i class="fa fa-external-link"></i> <?= $guide['target_label'] ?>
                                    </a>
                                    <span class="guide-toggle-icon">
                                        <i class="fa fa-chevron-down"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body (Collapsible) -->
                            <div id="guide-collapse-<?= $guide['id'] ?>" class="collapse <?= $idx === 0 ? 'in' : '' ?> guide-collapse-body">
                                <div class="guide-card-content">
                                    <!-- Step-by-Step Instructions -->
                                    <?php if (!empty($guide['steps'])): ?>
                                        <div class="guide-steps-box">
                                            <h5 class="steps-heading"><i class="fa fa-list-ol text-primary"></i> Step-by-Step Instructions:</h5>
                                            <ol class="guide-steps-list">
                                                <?php foreach ($guide['steps'] as $s): ?>
                                                    <li><?= $s ?></li>
                                                <?php endforeach; ?>
                                            </ol>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Visual GIF Screen Player -->
                                    <div class="guide-media-screen">
                                        <div class="screen-mac-bar">
                                            <span class="mac-dot red"></span>
                                            <span class="mac-dot yellow"></span>
                                            <span class="mac-dot green"></span>
                                            <span class="screen-title"><?= htmlspecialchars($guide['title']) ?> &mdash; Visual Walkthrough</span>
                                            <div class="screen-tools">
                                                <button type="button" class="btn btn-xs btn-default btn-zoom-preview" data-img="<?= $guide['image'] ?>" data-title="<?= htmlspecialchars($guide['title']) ?>" title="Enlarge Tutorial">
                                                    <i class="fa fa-search-plus"></i> Enlarge
                                                </button>
                                                <a href="<?= $guide['image'] ?>" download class="btn btn-xs btn-default" title="Download Animation" target="_blank">
                                                    <i class="fa fa-download"></i> Save
                                                </a>
                                            </div>
                                        </div>

                                        <div class="screen-media-canvas" onclick="openHelpModal('<?= $guide['image'] ?>', '<?= addslashes(htmlspecialchars($guide['title'])) ?>')">
                                            <img src="<?= $guide['image'] ?>" alt="<?= htmlspecialchars($guide['title']) ?>" class="img-responsive help-tutorial-gif" loading="lazy" />
                                            <div class="screen-hover-overlay">
                                                <span class="hover-tip"><i class="fa fa-expand"></i> Click to Enlarge / Fullscreen</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bottom Action Strip -->
                                    <div class="guide-footer-actions">
                                        <div class="footer-left-info text-muted">
                                            <i class="fa fa-check-circle text-success"></i> Verified for MedPulse Pharmacy ERP
                                        </div>
                                        <div class="footer-right-btn">
                                            <a href="<?= $guide['target_url'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-arrow-right"></i> Open <?= $guide['target_label'] ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- No Results Search Placeholder -->
                <div id="noResultsAlert" class="alert alert-warning" style="display: none;">
                    <h4><i class="fa fa-exclamation-triangle"></i> No Matching Guides Found</h4>
                    <p>No help tutorial matched your search criteria. Try a different term like <em>medicine</em>, <em>sale</em>, or <em>doctor</em>.</p>
                </div>
            </div>
        </div>

        <!-- Right Side Useful Tips & Help Widget -->
        <div class="col-md-3 col-sm-12">
            <!-- Daily Checklist Card -->
            <div class="box box-solid box-primary help-sidebar-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-calendar-check-o"></i> Daily Pharmacy Routine</h3>
                </div>
                <div class="box-body" style="padding: 12px;">
                    <ul class="checklist-items">
                        <li>
                            <i class="fa fa-clock-o text-aqua"></i>
                            <div><strong>Morning Stock Check:</strong> Review upcoming expiries & shortages.</div>
                        </li>
                        <li>
                            <i class="fa fa-barcode text-green"></i>
                            <div><strong>POS Billing:</strong> Verify batch number & expiry printed on patient bills.</div>
                        </li>
                        <li>
                            <i class="fa fa-inbox text-yellow"></i>
                            <div><strong>Purchase Entry:</strong> Record vendor bills on the same day stock arrives.</div>
                        </li>
                        <li>
                            <i class="fa fa-file-text-o text-purple"></i>
                            <div><strong>Night Closing:</strong> Cross-check cash counter with Daily Sales Summary.</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pharmacy Keyboard Shortcuts -->
            <div class="box box-solid box-info help-sidebar-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-keyboard-o"></i> Quick POS Shortcuts</h3>
                </div>
                <div class="box-body" style="padding: 12px;">
                    <table class="table table-condensed table-striped" style="margin-bottom: 0; font-size: 12px;">
                        <tbody>
                            <tr>
                                <td><kbd>Tab</kbd></td>
                                <td>Jump between inputs</td>
                            </tr>
                            <tr>
                                <td><kbd>Enter</kbd></td>
                                <td>Add item to bill</td>
                            </tr>
                            <tr>
                                <td><kbd>Ctrl + P</kbd></td>
                                <td>Print Invoice</td>
                            </tr>
                            <tr>
                                <td><kbd>Esc</kbd></td>
                                <td>Close Modal / Cancel</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Critical Management Links -->
            <div class="box box-solid box-default help-sidebar-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-shield"></i> Inventory Audit Tools</h3>
                </div>
                <div class="box-body" style="padding: 10px;">
                    <ul class="audit-quick-links">
                        <li><a href="<?= console_url('medicine_stock/expiring_view') ?>"><i class="fa fa-calendar text-danger"></i> Upcoming Expiry Report</a></li>
                        <li><a href="<?= console_url('medicine_stock/shortage_view') ?>"><i class="fa fa-exclamation-circle text-warning"></i> Stock Shortage Alert</a></li>
                        <li><a href="<?= console_url('medicine_stock/zeronegetive') ?>"><i class="fa fa-minus-circle text-danger"></i> Zero/Negative Stock</a></li>
                        <li><a href="<?= console_url('medicine/duplicate') ?>"><i class="fa fa-clone text-info"></i> Duplicate Medicine Merger</a></li>
                        <li><a href="<?= console_url('medicine/storage_unassigned') ?>"><i class="fa fa-cubes text-muted"></i> Unassigned Rack Storage</a></li>
                    </ul>
                </div>
            </div>

            <!-- Technical Support -->
            <div class="box box-solid box-success help-sidebar-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-phone"></i> Need Assistance?</h3>
                </div>
                <div class="box-body text-center" style="padding: 15px;">
                    <p style="font-size: 13px; color: #555; margin-bottom: 12px;">
                        Have questions about database backup, GST updates, or custom printer configuration?
                    </p>
                    <a href="mailto:support@msbbillings.in" class="btn btn-success btn-block btn-sm">
                        <i class="fa fa-envelope"></i> Contact Technical Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Enlarge / Fullscreen Preview -->
<div class="modal fade" id="helpImageModal" tabindex="-1" role="dialog" aria-labelledby="helpImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1100px;">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.4);">
            <div class="modal-header" style="background: #222d32; color: #fff; padding: 12px 20px;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.8; font-size: 24px;">&times;</button>
                <h4 class="modal-title" id="helpImageModalLabel" style="font-size: 16px; font-weight: 600;">
                    <i class="fa fa-television text-aqua" style="margin-right: 8px;"></i> <span id="modalImgTitle">Tutorial Walkthrough</span>
                </h4>
            </div>
            <div class="modal-body text-center" style="background: #111; padding: 10px; max-height: 80vh; overflow: auto;">
                <img id="modalEnlargedImg" src="" alt="Tutorial Preview" style="max-width: 100%; height: auto; border-radius: 4px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);" />
            </div>
            <div class="modal-footer" style="background: #f8f9fa; padding: 10px 20px;">
                <a id="modalDownloadBtn" href="#" download class="btn btn-primary btn-sm pull-left">
                    <i class="fa fa-download"></i> Download Video Guide
                </a>
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                    <i class="fa fa-times"></i> Close Window
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================================
   Modern Help Center Styles for AdminLTE Console
   ============================================================ */
.help-center-wrapper {
    margin: 0 -5px;
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Hero Section */
.help-hero-banner {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    border-radius: 8px;
    padding: 24px 28px;
    color: #fff;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(30, 60, 114, 0.2);
}

.help-badge-pill {
    display: inline-block;
    background: rgba(255, 255, 255, 0.18);
    color: #e0f2fe;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.help-hero-title {
    margin: 0 0 8px 0;
    font-size: 24px;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: -0.3px;
}

.help-hero-subtitle {
    font-size: 14px;
    color: #cbd5e1;
    margin-bottom: 18px;
    line-height: 1.5;
}

.help-search-container {
    max-width: 640px;
}

.help-search-container .input-group-addon {
    background: #ffffff;
    border-color: #ffffff;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
    padding-left: 15px;
}

.help-search-container input.form-control {
    border: none;
    height: 46px;
    font-size: 14px;
    border-radius: 0;
    box-shadow: none;
}

.help-search-container .btn-default {
    background: #ffffff;
    border-color: #ffffff;
    height: 46px;
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
}

.help-search-meta {
    margin-top: 8px;
    font-size: 12px;
    color: #e2e8f0;
}

/* Quick Nav Box on Hero */
.help-quick-nav-box {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 15px;
}

.quick-nav-title {
    margin: 0 0 12px 0;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #fff;
}

.quick-nav-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.quick-nav-btn {
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 8px 12px;
    border-radius: 6px;
    color: #333333;
    text-decoration: none !important;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.quick-nav-btn:hover {
    transform: translateX(4px);
    background: #f8fafc;
    color: #1e3c72;
}

.quick-nav-btn i.fa:first-child {
    font-size: 18px;
    width: 28px;
    text-align: center;
    margin-right: 10px;
}

.quick-nav-btn .q-text {
    flex: 1;
}

.quick-nav-btn .q-text strong {
    display: block;
    font-size: 13px;
    line-height: 1.2;
}

.quick-nav-btn .q-text span {
    font-size: 11px;
    color: #64748b;
}

.quick-nav-btn .q-arrow {
    color: #94a3b8;
    font-size: 14px;
}

/* Filter Bar */
.help-filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    border-radius: 6px;
    padding: 8px 14px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    flex-wrap: wrap;
    gap: 10px;
}

.help-filter-bar .nav-pills > li > a {
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    border-radius: 20px;
    color: #475569;
    transition: all 0.2s;
}

.help-filter-bar .nav-pills > li.active > a,
.help-filter-bar .nav-pills > li.active > a:hover {
    background-color: #3c8dbc;
    color: #ffffff;
}

.help-expand-actions .btn {
    border-radius: 4px;
    font-weight: 500;
}

/* Guide Card */
.help-guide-card {
    background: #ffffff;
    border-radius: 8px;
    margin-bottom: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: box-shadow 0.2s;
}

.help-guide-card:hover {
    box-shadow: 0 4px 14px rgba(0,0,0,0.1);
}

.guide-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    cursor: pointer;
    background: #ffffff;
    border-bottom: 1px solid transparent;
    user-select: none;
    transition: background 0.2s;
}

.guide-card-header:hover {
    background: #f8fafc;
}

.guide-card-header[aria-expanded="true"] {
    background: #f1f5f9;
    border-bottom-color: #e2e8f0;
}

.guide-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex: 1;
}

.guide-num-badge {
    background: #e2e8f0;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    padding: 6px 10px;
    border-radius: 6px;
    letter-spacing: 0.5px;
}

.guide-card-header[aria-expanded="true"] .guide-num-badge {
    background: #3c8dbc;
    color: #ffffff;
}

.guide-title-box {
    flex: 1;
}

.guide-title {
    margin: 0 0 5px 0;
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.3;
}

.guide-badges {
    display: flex;
    gap: 6px;
}

.guide-badges .label {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 4px;
}

.guide-header-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.guide-module-link {
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 4px;
}

.guide-toggle-icon {
    color: #94a3b8;
    transition: transform 0.25s ease;
    font-size: 14px;
}

.guide-card-header[aria-expanded="true"] .guide-toggle-icon {
    transform: rotate(180deg);
    color: #3c8dbc;
}

/* Card Body */
.guide-card-content {
    padding: 20px;
}

/* Steps Box */
.guide-steps-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-left: 4px solid #3c8dbc;
    border-radius: 4px;
    padding: 12px 18px;
    margin-bottom: 18px;
}

.steps-heading {
    margin: 0 0 8px 0;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.guide-steps-list {
    margin: 0;
    padding-left: 20px;
    font-size: 13px;
    color: #334155;
    line-height: 1.6;
}

.guide-steps-list li {
    margin-bottom: 4px;
}

/* Screen Media Frame */
.guide-media-screen {
    background: #1e293b;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    border: 1px solid #334155;
    margin-bottom: 15px;
}

.screen-mac-bar {
    background: #0f172a;
    padding: 8px 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    border-bottom: 1px solid #334155;
}

.mac-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

.mac-dot.red { background: #ef4444; }
.mac-dot.yellow { background: #f59e0b; }
.mac-dot.green { background: #10b981; }

.screen-title {
    color: #94a3b8;
    font-size: 12px;
    margin-left: 10px;
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.screen-tools {
    display: flex;
    gap: 6px;
}

.screen-tools .btn {
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 3px;
}

.screen-media-canvas {
    position: relative;
    cursor: zoom-in;
    background: #000;
    text-align: center;
}

.help-tutorial-gif {
    display: block;
    margin: 0 auto;
    max-width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.screen-hover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.4);
    opacity: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.25s ease;
}

.screen-media-canvas:hover .screen-hover-overlay {
    opacity: 1;
}

.hover-tip {
    background: rgba(0, 0, 0, 0.85);
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

/* Card Footer */
.guide-footer-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}

.footer-left-info {
    font-size: 12px;
}

/* Sidebar Cards */
.help-sidebar-card {
    border-radius: 6px;
    margin-bottom: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.help-sidebar-card .box-title {
    font-size: 14px;
    font-weight: 600;
}

.checklist-items {
    list-style: none;
    padding: 0;
    margin: 0;
}

.checklist-items li {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
    font-size: 12px;
    line-height: 1.4;
}

.checklist-items li i {
    font-size: 14px;
    margin-top: 2px;
}

.audit-quick-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.audit-quick-links li {
    padding: 6px 0;
    border-bottom: 1px dashed #e2e8f0;
}

.audit-quick-links li:last-child {
    border-bottom: none;
}

.audit-quick-links li a {
    font-size: 12px;
    color: #334155;
    text-decoration: none;
    display: block;
    font-weight: 500;
}

.audit-quick-links li a:hover {
    color: #3c8dbc;
    padding-left: 4px;
    transition: padding 0.15s ease;
}

.audit-quick-links li a i {
    margin-right: 6px;
    width: 14px;
}

kbd {
    background: #334155;
    color: #f8fafc;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.2);
    font-size: 11px;
}

@media (max-width: 768px) {
    .help-hero-banner { padding: 18px; }
    .help-hero-title { font-size: 20px; }
    .guide-card-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .guide-header-right { width: 100%; justify-content: space-between; }
}
</style>

<script>
$(document).ready(function() {
    var $cards = $('.help-guide-card');
    var $searchInput = $('#helpSearchInput');
    var $clearBtn = $('#clearSearchBtn');
    var $visibleCount = $('#visibleCount');
    var $noResultsAlert = $('#noResultsAlert');

    // Live search filter
    function applyFilters() {
        var searchTerm = $.trim($searchInput.val()).toLowerCase();
        var selectedCat = $('#helpCategoryFilter li.active a').data('filter');
        var visible = 0;

        $cards.each(function() {
            var $card = $(this);
            var cardCat = $card.data('category');
            var cardTitle = $card.data('title');

            var catMatch = (selectedCat === 'all' || cardCat === selectedCat);
            var searchMatch = (!searchTerm || cardTitle.indexOf(searchTerm) !== -1);

            if (catMatch && searchMatch) {
                $card.fadeIn(150);
                visible++;
            } else {
                $card.hide();
            }
        });

        $visibleCount.text(visible);
        if (visible === 0) {
            $noResultsAlert.fadeIn(150);
        } else {
            $noResultsAlert.hide();
        }

        if (searchTerm.length > 0) {
            $clearBtn.show();
        } else {
            $clearBtn.hide();
        }
    }

    $searchInput.on('keyup input', function() {
        applyFilters();
    });

    $clearBtn.on('click', function() {
        $searchInput.val('');
        applyFilters();
        $searchInput.focus();
    });

    // Category Filter pills
    $('#helpCategoryFilter a').on('click', function(e) {
        e.preventDefault();
        $('#helpCategoryFilter li').removeClass('active');
        $(this).parent().addClass('active');
        applyFilters();
    });

    // Expand / Collapse all
    $('#btnExpandAll').on('click', function() {
        $('.guide-collapse-body').collapse('show');
        $('.guide-card-header').attr('aria-expanded', 'true');
    });

    $('#btnCollapseAll').on('click', function() {
        $('.guide-collapse-body').collapse('hide');
        $('.guide-card-header').attr('aria-expanded', 'false');
    });

    // Enlarge preview buttons
    $('.btn-zoom-preview').on('click', function(e) {
        e.stopPropagation();
        var imgUrl = $(this).data('img');
        var imgTitle = $(this).data('title');
        openHelpModal(imgUrl, imgTitle);
    });

    // Update aria-expanded state on bootstrap collapse events
    $('.guide-collapse-body').on('shown.bs.collapse', function() {
        $(this).prev('.guide-card-header').attr('aria-expanded', 'true');
    }).on('hidden.bs.collapse', function() {
        $(this).prev('.guide-card-header').attr('aria-expanded', 'false');
    });
});

// Modal preview function
function openHelpModal(imgUrl, title) {
    $('#modalImgTitle').text(title);
    $('#modalEnlargedImg').attr('src', imgUrl);
    $('#modalDownloadBtn').attr('href', imgUrl);
    $('#helpImageModal').modal('show');
}
</script>