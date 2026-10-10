<?php
/**
 * Advanced Pharmacy Management Analytics Dashboard
 * Complete Charts, Graphs, Inventory Health & POS Performance
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

$cur_sales_total = isset($total_sales['total']) ? (float)$total_sales['total'] : 0;
$cur_sales_count = isset($total_sales['count']) ? (int)$total_sales['count'] : 0;
$cur_today_sales = isset($today_sales['total']) ? (float)$today_sales['total'] : 0;
$cur_today_sales_count = isset($today_sales['count']) ? (int)$today_sales['count'] : 0;

$cur_purchases_total = isset($total_purchases['total']) ? (float)$total_purchases['total'] : 0;
$cur_purchases_count = isset($total_purchases['count']) ? (int)$total_purchases['count'] : 0;
$cur_today_purchases = isset($today_purchases['total']) ? (float)$today_purchases['total'] : 0;

$cnt_meds = isset($total_medicines) ? (int)$total_medicines : 0;
$cnt_customers = isset($total_customers) ? (int)$total_customers : 0;
$cnt_doctors = isset($total_doctors) ? (int)$total_doctors : 0;
$cnt_suppliers = isset($total_suppliers) ? (int)$total_suppliers : 0;

$cnt_portal_orders = isset($portal_orders) ? (int)$portal_orders : 0;
$cnt_portal_rx = isset($portal_prescriptions) ? (int)$portal_prescriptions : 0;
$cnt_portal_consults = isset($portal_consultations) ? (int)$portal_consultations : 0;

$cnt_duplicate = isset($count_duplicate) ? (int)$count_duplicate : 0;
$cnt_no_unit = isset($count_no_unit) ? (int)$count_no_unit : 0;
$cnt_unassigned = isset($count_unassigned_storage) ? (int)$count_unassigned_storage : 0;
$cnt_expired = isset($count_expired) ? (int)$count_expired : 0;
$cnt_expiring_soon = isset($count_expiring_soon) ? (int)$count_expiring_soon : 0;

function format_inr($number) {
    if ($number >= 10000000) {
        return '₹' . number_format($number / 10000000, 2) . ' Cr';
    } elseif ($number >= 100000) {
        return '₹' . number_format($number / 100000, 2) . ' L';
    } elseif ($number >= 1000) {
        return '₹' . number_format($number / 1000, 1) . ' K';
    }
    return '₹' . number_format($number, 2);
}
?>

<!-- Load Chart.js 4 (Local UMD Bundle with CDN Fallback) -->
<script src="<?= base_url('assets/backend/plugins/chartjs/chart.umd.min.js') ?>"></script>
<script>
    if (typeof Chart === 'undefined') {
        document.write('<script src="https://cdn.jsdelivr.net/npm/chart.js"><\/script>');
    }
</script>

<div class="dashboard-analytics-wrapper">

    <!-- Top Action & Quick Entry Bar -->
    <div class="dash-quick-bar">
        <div class="dash-quick-left">
            <h3 class="dash-page-title"><i class="fa fa-tachometer text-primary"></i> Pharmacy Analytics & Operations</h3>
            <span class="dash-date-badge"><i class="fa fa-clock-o"></i> Live Data &bull; <?= date('l, d F Y') ?></span>
        </div>
        <div class="dash-quick-right">
            <a href="<?= console_url('sale/add_detail') ?>" class="btn btn-success btn-sm btn-action-pill">
                <i class="fa fa-plus-circle"></i> New POS Sale
            </a>
            <a href="<?= console_url('purchase/add_detail') ?>" class="btn btn-primary btn-sm btn-action-pill">
                <i class="fa fa-truck"></i> Inward Purchase
            </a>
            <a href="<?= console_url('medicine/add_detail') ?>" class="btn btn-info btn-sm btn-action-pill">
                <i class="fa fa-medkit"></i> Add Medicine
            </a>
            <a href="<?= console_url('medicine_stock/expiring_view') ?>" class="btn btn-warning btn-sm btn-action-pill" title="Check Upcoming Expire">
                <i class="fa fa-calendar-times-o"></i> Expiries (<?= $cnt_expiring_soon ?>)
            </a>
        </div>
    </div>

    <!-- Announcement & Subscription Banner -->
    <div class="box box-primary box-solid dash-notice-box" style="margin-bottom: 20px;">
        <div class="box-header with-border" style="padding: 10px 15px;">
            <h3 class="box-title" style="font-size: 14px;"><i class="fa fa-bullhorn"></i> System Notification & Services</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-success btn-xs" id="paynow"><i class="fa fa-credit-card"></i> Renew Subscription</button>
            </div>
        </div>
        <div class="box-body" style="padding: 10px 15px;">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <p style="margin: 0; font-size: 13px; color: #333;">
                        <strong>Plan:</strong> <span class="label label-info"><?= defined('PLAN_NAME') ? PLAN_NAME : 'Medical Standard' ?></span>
                        <span style="margin: 0 8px;">|</span>
                        <strong>Valid Until:</strong> <span class="text-danger"><strong><?= defined('DEACTIVATION_DATE') ? DEACTIVATION_DATE : 'Active' ?></strong></span>
                        <span style="margin: 0 8px;">|</span>
                        <strong>Active Modules:</strong> <span class="text-muted"><?= defined('PLAN_PACKAGES') ? str_ireplace(",", ", ", PLAN_PACKAGES) : 'Medical ERP, Billing, Stock, Portal' ?></span>
                    </p>
                </div>
                <div class="col-md-4 col-sm-12 text-right">
                    <small class="text-muted"><i class="fa fa-whatsapp text-green"></i> Support: +91 9382509991 (12pm - 6pm)</small>
                </div>
            </div>
            <input type="text" id="deactive_date" value="<?= defined('DEACTIVATION_DATE') ? DEACTIVATION_DATE : '' ?>" style="display:none">
        </div>
    </div>

    <!-- Top KPI Performance Cards (6 Columns Grid) -->
    <div class="row">
        <!-- Card 1: Total Sales Revenue -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="dash-kpi-card bg-kpi-green">
                <div class="kpi-icon-wrap"><i class="fa fa-inr"></i></div>
                <div class="kpi-details">
                    <span class="kpi-label">Total Sales Revenue</span>
                    <h3 class="kpi-value"><?= format_inr($cur_sales_total) ?></h3>
                    <div class="kpi-sub">
                        <span><i class="fa fa-shopping-cart"></i> <?= number_format($cur_sales_count) ?> Bills</span>
                        <span class="pull-right">Today: ₹<?= number_format($cur_today_sales, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Inward Purchases -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="dash-kpi-card bg-kpi-blue">
                <div class="kpi-icon-wrap"><i class="fa fa-truck"></i></div>
                <div class="kpi-details">
                    <span class="kpi-label">Inward Purchases</span>
                    <h3 class="kpi-value"><?= format_inr($cur_purchases_total) ?></h3>
                    <div class="kpi-sub">
                        <span><i class="fa fa-file-text-o"></i> <?= number_format($cur_purchases_count) ?> Invoices</span>
                        <span class="pull-right">Today: ₹<?= number_format($cur_today_purchases, 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Medicines Catalog -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="dash-kpi-card bg-kpi-teal">
                <div class="kpi-icon-wrap"><i class="fa fa-medkit"></i></div>
                <div class="kpi-details">
                    <span class="kpi-label">Medicines In Catalog</span>
                    <h3 class="kpi-value"><?= number_format($cnt_meds) ?></h3>
                    <div class="kpi-sub">
                        <span><i class="fa fa-cubes"></i> 4 Lakh+ Database</span>
                        <span class="pull-right"><a href="<?= console_url('medicine') ?>" style="color: inherit; text-decoration: underline;">View &rarr;</a></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Registered Patients & Customers -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="dash-kpi-card bg-kpi-purple">
                <div class="kpi-icon-wrap"><i class="fa fa-users"></i></div>
                <div class="kpi-details">
                    <span class="kpi-label">Customers / Patients</span>
                    <h3 class="kpi-value"><?= number_format($cnt_customers) ?></h3>
                    <div class="kpi-sub">
                        <span><i class="fa fa-user-md"></i> <?= $cnt_doctors ?> Doctors</span>
                        <span class="pull-right"><?= $cnt_suppliers ?> Vendors</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metric Strip: Online Portal & Inventory Health Badges -->
    <div class="row" style="margin-top: 5px; margin-bottom: 20px;">
        <div class="col-md-12">
            <div class="dash-status-strip">
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-globe text-primary"></i> Online Orders:</span>
                    <span class="badge bg-blue"><?= $cnt_portal_orders ?></span>
                </div>
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-file-text text-green"></i> Prescriptions Uploaded:</span>
                    <span class="badge bg-green"><?= $cnt_portal_rx ?></span>
                </div>
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-user-md text-purple"></i> Doctor Appointments:</span>
                    <span class="badge bg-purple"><?= $cnt_portal_consults ?></span>
                </div>
                <div class="status-strip-divider"></div>
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-calendar-times-o text-red"></i> Upcoming Expiry (<90d):</span>
                    <a href="<?= console_url('medicine_stock/expiring_view') ?>" class="badge bg-red"><?= $cnt_expiring_soon ?> View</a>
                </div>
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-ban text-yellow"></i> Already Expired:</span>
                    <a href="<?= console_url('medicine_stock/expired_view') ?>" class="badge bg-yellow"><?= $cnt_expired ?> View</a>
                </div>
                <div class="status-strip-item">
                    <span class="strip-label"><i class="fa fa-clone text-muted"></i> Duplicate Medicines:</span>
                    <a href="<?= console_url('medicine/duplicate') ?>" class="badge bg-gray"><?= $cnt_duplicate ?> Fix</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================================
         MAIN ANALYTICS SECTION: GRAPHS & CHARTS
         ======================================================== -->

    <!-- ROW 1 OF GRAPHS: Monthly Sales vs Purchases & Payment Modes -->
    <div class="row">
        <!-- Graph 1: Monthly Sales vs Purchases Area/Line Chart -->
        <div class="col-lg-8 col-md-12">
            <div class="box box-primary dash-chart-card">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-line-chart text-primary"></i> Monthly Sales Revenue vs. Purchases Procurement
                    </h3>
                    <div class="box-tools pull-right">
                        <span class="label label-success" style="margin-right: 5px;"><i class="fa fa-circle"></i> Sales (₹)</span>
                        <span class="label label-primary"><i class="fa fa-circle"></i> Purchases (₹)</span>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart-canvas-container" style="height: 330px;">
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row text-center">
                        <div class="col-xs-4 border-right">
                            <span class="text-muted">Total Sales Turnover</span>
                            <h4 class="font-bold text-green"><?= format_inr($cur_sales_total) ?></h4>
                        </div>
                        <div class="col-xs-4 border-right">
                            <span class="text-muted">Total Procurement</span>
                            <h4 class="font-bold text-blue"><?= format_inr($cur_purchases_total) ?></h4>
                        </div>
                        <div class="col-xs-4">
                            <span class="text-muted">Estimated Margin Spread</span>
                            <h4 class="font-bold text-aqua">
                                <?= format_inr(abs($cur_sales_total - ($cur_purchases_total * 0.35))) ?>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graph 2: Sales by Payment Mode Donut Chart -->
        <div class="col-lg-4 col-md-12">
            <div class="box box-info dash-chart-card">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-pie-chart text-info"></i> Revenue by Payment Mode
                    </h3>
                </div>
                <div class="box-body">
                    <div class="chart-canvas-container" style="height: 250px;">
                        <canvas id="paymentModeChart"></canvas>
                    </div>
                    <div class="pay-legend-list" style="margin-top: 15px;">
                        <?php 
                        $mode_colors = array('#00a65a', '#3c8dbc', '#f39c12', '#dd4b39', '#605ca8');
                        if (!empty($payment_modes)): 
                            foreach ($payment_modes as $mi => $pm): 
                                $col = isset($mode_colors[$mi]) ? $mode_colors[$mi] : '#00c0ef';
                        ?>
                            <div class="pay-legend-item">
                                <span class="legend-color-dot" style="background-color: <?= $col ?>;"></span>
                                <span class="legend-mode-name"><?= htmlspecialchars($pm['mode']) ?></span>
                                <span class="legend-mode-val pull-right">
                                    <?= format_inr($pm['total']) ?> (<?= number_format($pm['count']) ?> bills)
                                </span>
                            </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2 OF GRAPHS: Daily Sales Velocity & Top Selling Medicines -->
    <div class="row">
        <!-- Graph 3: Daily Sales Turnover (Last 14 Billing Days) -->
        <div class="col-lg-6 col-md-12">
            <div class="box box-success dash-chart-card">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-bar-chart text-success"></i> Daily Sales Velocity (Recent Billing Days)
                    </h3>
                    <div class="box-tools pull-right">
                        <span class="badge bg-green">Last 14 Active Days</span>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart-canvas-container" style="height: 310px;">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graph 4: Top 10 Best-Selling Medicines Horizontal Bar Chart -->
        <div class="col-lg-6 col-md-12">
            <div class="box box-warning dash-chart-card">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-trophy text-warning"></i> Top 10 High-Moving Medicines (By Revenue)
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?= console_url('medicine_stock/stock_view') ?>" class="btn btn-default btn-xs">
                            <i class="fa fa-cubes"></i> Stock Report
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart-canvas-container" style="height: 310px;">
                        <canvas id="topMedicinesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3 OF GRAPHS: Top Prescribing Doctors & Stock Health Breakdown -->
    <div class="row">
        <!-- Graph 5: Top Prescribing Doctors -->
        <div class="col-lg-6 col-md-12">
            <div class="box box-purple dash-chart-card" style="border-top-color: #605ca8;">
                <div class="box-header with-border">
                    <h3 class="box-title" style="color: #605ca8;">
                        <i class="fa fa-user-md"></i> Top Prescribing Doctors (Prescription Volume)
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?= console_url('doctor') ?>" class="btn btn-default btn-xs">
                            <i class="fa fa-external-link"></i> Doctor Directory
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart-canvas-container" style="height: 280px;">
                        <canvas id="topDoctorsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graph 6: Inventory Audit & Risk Health Breakdown -->
        <div class="col-lg-6 col-md-12">
            <div class="box box-danger dash-chart-card">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i class="fa fa-shield text-danger"></i> Inventory Quality & Audit Health
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="<?= console_url('help') ?>" class="btn btn-default btn-xs">
                            <i class="fa fa-question-circle"></i> Guide
                        </a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="chart-canvas-container" style="height: 250px;">
                                <canvas id="inventoryHealthChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="audit-status-list">
                                <a href="<?= console_url('medicine_stock/expiring_view') ?>" class="audit-item warning">
                                    <i class="fa fa-clock-o"></i>
                                    <div class="audit-text">
                                        <strong>Upcoming Expiries (<90d)</strong>
                                        <small><?= $cnt_expiring_soon ?> Batches nearing expiry</small>
                                    </div>
                                    <span class="badge bg-yellow"><?= $cnt_expiring_soon ?></span>
                                </a>
                                <a href="<?= console_url('medicine_stock/expired_view') ?>" class="audit-item danger">
                                    <i class="fa fa-times-circle"></i>
                                    <div class="audit-text">
                                        <strong>Already Expired Stock</strong>
                                        <small><?= $cnt_expired ?> Batches past expiry</small>
                                    </div>
                                    <span class="badge bg-red"><?= $cnt_expired ?></span>
                                </a>
                                <a href="<?= console_url('medicine/duplicate') ?>" class="audit-item info">
                                    <i class="fa fa-clone"></i>
                                    <div class="audit-text">
                                        <strong>Duplicate Medicines</strong>
                                        <small><?= $cnt_duplicate ?> Redundant drug names</small>
                                    </div>
                                    <span class="badge bg-aqua"><?= $cnt_duplicate ?></span>
                                </a>
                                <a href="<?= console_url('medicine/no_unit') ?>" class="audit-item default">
                                    <i class="fa fa-cubes"></i>
                                    <div class="audit-text">
                                        <strong>Missing Unit Measure</strong>
                                        <small><?= $cnt_no_unit ?> Medicines without units</small>
                                    </div>
                                    <span class="badge bg-gray"><?= $cnt_no_unit ?></span>
                                </a>
                                <a href="<?= console_url('medicine/storage_unassigned') ?>" class="audit-item default">
                                    <i class="fa fa-inbox"></i>
                                    <div class="audit-text">
                                        <strong>Unassigned Storage Rack</strong>
                                        <small><?= $cnt_unassigned ?> Medicines without rack</small>
                                    </div>
                                    <span class="badge bg-gray"><?= $cnt_unassigned ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 4: RECENT TRANSACTIONS & RECENT PORTAL ORDERS TABLES -->
    <div class="row">
        <!-- Recent Counter Sales Table -->
        <div class="col-md-6 col-sm-12">
            <div class="box box-default dash-table-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-receipt text-primary"></i> Recent Counter Sales</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= console_url('sale') ?>" class="btn btn-default btn-xs">View All Sales &rarr;</a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px;">
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px;">
                            <?php if (!empty($recent_sales)): foreach ($recent_sales as $rs): ?>
                                <tr>
                                    <td>
                                        <a href="<?= console_url('sale/view_detail/' . base64_encode($rs['sale_invoice'])) ?>" target="_blank" style="font-weight: 600;">
                                            <?= htmlspecialchars($rs['sale_invoice']) ?>
                                        </a>
                                    </td>
                                    <td><?= date('d M Y', strtotime($rs['sale_date'])) ?></td>
                                    <td><?= htmlspecialchars($rs['customer_name']) ?></td>
                                    <td><strong>₹<?= number_format($rs['sale_total'], 2) ?></strong></td>
                                    <td><span class="label label-success"><?= htmlspecialchars($rs['sale_paid_by'] ? $rs['sale_paid_by'] : 'Cash') ?></span></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="text-center text-muted">No sales found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Online Portal Orders Table -->
        <div class="col-md-6 col-sm-12">
            <div class="box box-default dash-table-card">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe text-success"></i> Recent Online Portal Orders</h3>
                    <div class="box-tools pull-right">
                        <a href="<?= console_url('customer_order') ?>" class="btn btn-default btn-xs">Manage Orders &rarr;</a>
                    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr style="background: #f8fafc; font-size: 12px;">
                                <th>Order #</th>
                                <th>Patient / Customer</th>
                                <th>Phone</th>
                                <th>Medicine Item</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 13px;">
                            <?php if (!empty($recent_orders)): foreach ($recent_orders as $ro): 
                                $status_badge = 'label-warning';
                                $st = strtolower($ro['status']);
                                if ($st == 'delivered' || $st == 'completed') $status_badge = 'label-success';
                                elseif ($st == 'confirmed' || $st == 'processing') $status_badge = 'label-info';
                                elseif ($st == 'cancelled') $status_badge = 'label-danger';
                            ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($ro['order_code']) ?></strong></td>
                                    <td><?= htmlspecialchars($ro['customer_name']) ?></td>
                                    <td><?= htmlspecialchars($ro['phone']) ?></td>
                                    <td><?= htmlspecialchars($ro['medicine_name']) ?> <small class="text-muted">(Qty: <?= (int)$ro['quantity'] ?>)</small></td>
                                    <td><span class="label <?= $status_badge ?>"><?= htmlspecialchars($ro['status']) ?></span></td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="text-center text-muted">No web orders yet. Customer orders will appear here automatically.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Pay Now Modal -->
<div id="paynowModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #3c8dbc; color: #fff;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: #fff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title" style="text-align: center;"><i class="fa fa-qrcode"></i> Subscription Payment</h4>
            </div>
            <div class="modal-body text-center">
                <p class="text-muted">Scan the QR code below using Google Pay / PhonePe / Paytm to renew.</p>
                <img src="<?= base_url(); ?>msb/g-pay4500.jpeg" alt="QR Code" style="max-height: 350px; max-width: 100%; border: 1px solid #eee; border-radius: 8px; padding: 5px;" />
                <div style="margin-top: 15px; font-size: 13px; color: #555;">
                    <p><strong>Bank:</strong> UCO Bank | <strong>A/C Name:</strong> BAPAN ROY</p>
                    <p><strong>A/C No:</strong> 11760110012932 | <strong>IFSC:</strong> UCBA0001176</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================
     CHART.JS DATA PREPARATION & SCRIPT INITIALIZATION
     ======================================================== -->
<?php
// Prepare JSON data arrays for Chart.js
$monthly_labels = array();
$monthly_sales_data = array();
$monthly_purchases_data = array();
if (!empty($monthly_trends)) {
    foreach ($monthly_trends as $mt) {
        $monthly_labels[] = $mt['label'];
        $monthly_sales_data[] = (float)$mt['sales'];
        $monthly_purchases_data[] = (float)$mt['purchases'];
    }
}

$daily_labels = array();
$daily_sales_data = array();
$daily_counts_data = array();
if (!empty($daily_trends)) {
    foreach ($daily_trends as $dt) {
        $daily_labels[] = $dt['label'];
        $daily_sales_data[] = (float)$dt['total'];
        $daily_counts_data[] = (int)$dt['bill_count'];
    }
}

$top_med_labels = array();
$top_med_values = array();
$top_med_strips = array();
if (!empty($top_medicines)) {
    foreach ($top_medicines as $tm) {
        $top_med_labels[] = $tm['medicine_name'];
        $top_med_values[] = (float)$tm['total_val'];
        $top_med_strips[] = (int)$tm['strips'];
    }
}

$pm_labels = array();
$pm_data = array();
if (!empty($payment_modes)) {
    foreach ($payment_modes as $pm) {
        $pm_labels[] = $pm['mode'];
        $pm_data[] = (float)$pm['total'];
    }
}

$doc_labels = array();
$doc_data = array();
if (!empty($top_doctors)) {
    foreach ($top_doctors as $td) {
        $doc_labels[] = $td['doc_name'];
        $doc_data[] = (int)$td['count'];
    }
}
?>

<script>
$(document).ready(function() {

    // Subscription Modal Handler
    var nextmonth = "<?= date("Y-m-d", strtotime('+1 months')) ?>";
    var deactive_date = $('#deactive_date').val();
    if(deactive_date && deactive_date <= nextmonth){
        $("#renewSubscription").modal('show');
    }
    $("#paynow").click(function(){
        $("#paynowModal").modal('show');
    });

    if (typeof Chart === 'undefined') {
        console.error('Chart.js could not be loaded.');
        return;
    }

    // Chart.js Default styling
    Chart.defaults.font.family = "'Segoe UI', Roboto, Helvetica, Arial, sans-serif";
    Chart.defaults.color = '#64748b';

    // ----------------------------------------------------
    // 1. Monthly Trends Chart (Sales vs. Purchases)
    // ----------------------------------------------------
    var ctxMonthly = document.getElementById('monthlyTrendsChart');
    if (ctxMonthly) {
        var gradSales = ctxMonthly.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradSales.addColorStop(0, 'rgba(0, 166, 90, 0.35)');
        gradSales.addColorStop(1, 'rgba(0, 166, 90, 0.0)');

        var gradPurchases = ctxMonthly.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradPurchases.addColorStop(0, 'rgba(60, 141, 188, 0.35)');
        gradPurchases.addColorStop(1, 'rgba(60, 141, 188, 0.0)');

        new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: <?= json_encode($monthly_labels) ?>,
                datasets: [
                    {
                        label: 'Sales Revenue (₹)',
                        data: <?= json_encode($monthly_sales_data) ?>,
                        borderColor: '#00a65a',
                        backgroundColor: gradSales,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#00a65a',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        tension: 0.35,
                        fill: true
                    },
                    {
                        label: 'Purchases Cost (₹)',
                        data: <?= json_encode($monthly_purchases_data) ?>,
                        borderColor: '#3c8dbc',
                        backgroundColor: gradPurchases,
                        borderWidth: 2.5,
                        pointBackgroundColor: '#3c8dbc',
                        pointBorderColor: '#ffffff',
                        pointHoverRadius: 6,
                        tension: 0.35,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: { boxWidth: 12, font: { weight: '600' } }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var val = context.parsed.y || 0;
                                return context.dataset.label + ': ₹' + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 100000) return '₹' + (value / 100000).toFixed(1) + 'L';
                                if (value >= 1000) return '₹' + (value / 1000).toFixed(0) + 'K';
                                return '₹' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    // ----------------------------------------------------
    // 2. Payment Modes Donut Chart
    // ----------------------------------------------------
    var ctxPay = document.getElementById('paymentModeChart');
    if (ctxPay) {
        new Chart(ctxPay, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($pm_labels) ?>,
                datasets: [{
                    data: <?= json_encode($pm_data) ?>,
                    backgroundColor: ['#00a65a', '#3c8dbc', '#f39c12', '#dd4b39', '#605ca8'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var val = context.parsed || 0;
                                return context.label + ': ₹' + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                            }
                        }
                    }
                },
                cutout: '68%'
            }
        });
    }

    // ----------------------------------------------------
    // 3. Daily Sales Bar Chart
    // ----------------------------------------------------
    var ctxDaily = document.getElementById('dailySalesChart');
    if (ctxDaily) {
        new Chart(ctxDaily, {
            type: 'bar',
            data: {
                labels: <?= json_encode($daily_labels) ?>,
                datasets: [{
                    label: 'Daily Sales (₹)',
                    data: <?= json_encode($daily_sales_data) ?>,
                    backgroundColor: 'rgba(0, 166, 90, 0.75)',
                    hoverBackgroundColor: '#00a65a',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var val = context.parsed.y || 0;
                                return 'Revenue: ₹' + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(val) {
                                return '₹' + Number(val).toLocaleString('en-IN');
                            }
                        }
                    }
                }
            }
        });
    }

    // ----------------------------------------------------
    // 4. Top Medicines Horizontal Bar Chart
    // ----------------------------------------------------
    var ctxTopMeds = document.getElementById('topMedicinesChart');
    if (ctxTopMeds) {
        new Chart(ctxTopMeds, {
            type: 'bar',
            data: {
                labels: <?= json_encode($top_med_labels) ?>,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: <?= json_encode($top_med_values) ?>,
                    backgroundColor: 'rgba(243, 156, 18, 0.8)',
                    hoverBackgroundColor: '#f39c12',
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var val = context.parsed.x || 0;
                                return 'Total Sales: ₹' + Number(val).toLocaleString('en-IN', { minimumFractionDigits: 2 });
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(val) {
                                if (val >= 100000) return '₹' + (val / 100000).toFixed(1) + 'L';
                                if (val >= 1000) return '₹' + (val / 1000).toFixed(0) + 'K';
                                return '₹' + val;
                            }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11, weight: '500' }
                        }
                    }
                }
            }
        });
    }

    // ----------------------------------------------------
    // 5. Top Prescribing Doctors (Polar Area / Bar Chart)
    // ----------------------------------------------------
    var ctxDocs = document.getElementById('topDoctorsChart');
    if (ctxDocs) {
        new Chart(ctxDocs, {
            type: 'bar',
            data: {
                labels: <?= json_encode($doc_labels) ?>,
                datasets: [{
                    label: 'Prescription Bills Count',
                    data: <?= json_encode($doc_data) ?>,
                    backgroundColor: [
                        'rgba(96, 92, 168, 0.85)',
                        'rgba(60, 141, 188, 0.85)',
                        'rgba(0, 192, 239, 0.85)',
                        'rgba(0, 166, 90, 0.85)',
                        'rgba(243, 156, 18, 0.85)',
                        'rgba(221, 75, 57, 0.85)',
                        'rgba(119, 119, 119, 0.85)'
                    ],
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Prescriptions Linked';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10, weight: '600' }
                        }
                    },
                    y: {
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // ----------------------------------------------------
    // 6. Inventory Quality & Health Breakdown (Doughnut)
    // ----------------------------------------------------
    var ctxHealth = document.getElementById('inventoryHealthChart');
    if (ctxHealth) {
        var normalStock = Math.max(10, <?= $cnt_meds ?> - (<?= $cnt_expiring_soon ?> + <?= $cnt_expired ?> + <?= $cnt_duplicate ?> + <?= $cnt_no_unit ?>));
        new Chart(ctxHealth, {
            type: 'doughnut',
            data: {
                labels: ['Healthy Stock', 'Expiring (<90d)', 'Expired', 'Duplicate Entry', 'No Unit Spec'],
                datasets: [{
                    data: [
                        normalStock, 
                        <?= $cnt_expiring_soon ?>, 
                        <?= $cnt_expired ?>, 
                        <?= $cnt_duplicate ?>, 
                        <?= $cnt_no_unit ?>
                    ],
                    backgroundColor: ['#00a65a', '#f39c12', '#dd4b39', '#3c8dbc', '#94a3b8'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, font: { size: 11 } }
                    }
                },
                cutout: '62%'
            }
        });
    }

});
</script>

<style>
/* ============================================================
   Pharmacy Analytics Dashboard Styles
   ============================================================ */
.dashboard-analytics-wrapper {
    margin: 0 -5px;
    font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Quick Bar Header */
.dash-quick-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
    border-radius: 8px;
    padding: 14px 20px;
    margin-bottom: 18px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    flex-wrap: wrap;
    gap: 12px;
}

.dash-page-title {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
}

.dash-date-badge {
    font-size: 12px;
    color: #64748b;
}

.btn-action-pill {
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: 600;
    font-size: 12px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.08);
    transition: transform 0.15s ease;
}

.btn-action-pill:hover {
    transform: translateY(-1px);
}

/* KPI Cards */
.dash-kpi-card {
    border-radius: 8px;
    padding: 18px 20px;
    color: #ffffff;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.dash-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}

.bg-kpi-green { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
.bg-kpi-blue { background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%); }
.bg-kpi-teal { background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); }
.bg-kpi-purple { background: linear-gradient(135deg, #6d28d9 0%, #8b5cf6 100%); }

.kpi-icon-wrap {
    font-size: 38px;
    width: 60px;
    opacity: 0.85;
}

.kpi-details {
    flex: 1;
}

.kpi-label {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.9;
    font-weight: 600;
}

.kpi-value {
    margin: 2px 0 6px 0;
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -0.5px;
}

.kpi-sub {
    font-size: 11px;
    opacity: 0.95;
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 5px;
}

/* Status Strip */
.dash-status-strip {
    background: #ffffff;
    border-radius: 6px;
    padding: 10px 18px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #e2e8f0;
}

.status-strip-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
}

.strip-label {
    color: #475569;
    font-weight: 600;
}

.status-strip-divider {
    height: 18px;
    width: 1px;
    background: #cbd5e1;
}

/* Chart Cards */
.dash-chart-card {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 22px;
    background: #ffffff;
}

.dash-chart-card .box-header {
    padding: 14px 18px;
}

.dash-chart-card .box-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
}

.dash-chart-card .box-body {
    padding: 18px;
}

.chart-canvas-container {
    position: relative;
    width: 100%;
}

/* Payment Legend */
.pay-legend-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.pay-legend-item {
    font-size: 12px;
    padding: 4px 6px;
    border-radius: 4px;
    background: #f8fafc;
}

.legend-color-dot {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 6px;
}

.legend-mode-name {
    font-weight: 600;
    color: #334155;
}

.legend-mode-val {
    color: #64748b;
}

/* Audit Status List */
.audit-status-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.audit-item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-radius: 6px;
    text-decoration: none !important;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
}

.audit-item:hover {
    transform: translateX(4px);
    background: #ffffff;
}

.audit-item i {
    font-size: 18px;
    width: 26px;
}

.audit-item.warning i { color: #f59e0b; }
.audit-item.danger i { color: #ef4444; }
.audit-item.info i { color: #3b82f6; }
.audit-item.default i { color: #64748b; }

.audit-text {
    flex: 1;
}

.audit-text strong {
    display: block;
    font-size: 12px;
    color: #1e293b;
}

.audit-text small {
    font-size: 11px;
    color: #64748b;
}

/* Table Cards */
.dash-table-card {
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    margin-bottom: 22px;
}

.dash-table-card .box-header {
    padding: 12px 18px;
}

.dash-table-card .box-title {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
}

@media (max-width: 768px) {
    .dash-quick-bar { flex-direction: column; align-items: flex-start; }
    .dash-quick-right { width: 100%; display: flex; flex-wrap: wrap; gap: 6px; }
}
</style>
