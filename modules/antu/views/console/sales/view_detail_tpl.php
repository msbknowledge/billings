<?php
/**
 * Modern Sale Invoice Detail View (AdminLTE Layout)
 */
$has_data = !empty($data) && is_array($data);
$inv_row = $has_data ? $data[0] : array();
$inv_no = !empty($inv_row['sale_invoice']) ? $inv_row['sale_invoice'] : (!empty($invoice) ? $invoice : '');
$inv_date = !empty($inv_row['sale_date']) && $inv_row['sale_date'] !== '1970-01-01' ? date('d M Y', strtotime($inv_row['sale_date'])) : (!empty($inv_row['sale_timestamp']) ? date('d M Y', strtotime($inv_row['sale_timestamp'])) : date('d M Y'));

// Filter sold and return items
$sold_items = array();
$return_items = array();
if ($has_data) {
    foreach ($data as $item) {
        if (!empty($item['sale_return'])) {
            $return_items[] = $item;
        } else {
            $sold_items[] = $item;
        }
    }
}

// Financial calculations for sold items
$total_sold_taxable = 0;
$total_sold_cgst = 0;
$total_sold_sgst = 0;
$total_sold_amount = 0;
$total_strips = 0;
$total_loose = 0;

foreach ($sold_items as $item) {
    $total_sold_taxable += (float)$item['sale_taxable'];
    $total_sold_cgst += (float)$item['sale_cgst'];
    $total_sold_sgst += (float)$item['sale_sgst'];
    $total_sold_amount += (float)$item['sale_total'];
    $total_strips += (int)$item['sale_strip_quantity'];
    $total_loose += (int)$item['sale_loose_quantity'];
}

$total_sold_gst = $total_sold_cgst + $total_sold_sgst;
$prev_due = $has_data ? (float)$inv_row['sale_total_previous_due'] : 0;
$total_payable = $total_sold_amount + $prev_due;
$total_paid = $has_data ? (float)$inv_row['sale_total_paid'] : 0;
$current_due = round($total_payable - $total_paid, 2);

// Status Badge
if ($current_due <= 0 && $total_paid > 0) {
    $status_badge = '<span class="label label-success" style="font-size:13px; padding:5px 12px; border-radius:12px;"><i class="fa fa-check-circle"></i> Paid</span>';
} elseif ($total_paid > 0 && $current_due > 0) {
    $status_badge = '<span class="label label-warning" style="font-size:13px; padding:5px 12px; border-radius:12px;"><i class="fa fa-clock-o"></i> Partially Paid</span>';
} else {
    $status_badge = '<span class="label label-danger" style="font-size:13px; padding:5px 12px; border-radius:12px;"><i class="fa fa-exclamation-circle"></i> Due / Unpaid</span>';
}
?>

<style>
/* Invoice View Modern Styles */
.invoice-view-wrapper {
    margin-bottom: 30px;
}
.invoice-header-card {
    background: #ffffff;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    padding: 20px 24px;
    margin-bottom: 20px;
    border-left: 4px solid #3c8dbc;
}
.invoice-meta-card {
    background: #ffffff;
    border-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    padding: 16px 20px;
    height: 100%;
    border: 1px solid #e2e8f0;
}
.invoice-meta-card .card-icon {
    width: 38px;
    height: 38px;
    line-height: 38px;
    border-radius: 50%;
    text-align: center;
    background: #eff6ff;
    color: #2563eb;
    font-size: 16px;
    margin-right: 12px;
    float: left;
}
.invoice-meta-card .card-title {
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.invoice-meta-card .card-content {
    color: #1e293b;
    font-size: 14px;
}
.invoice-table {
    margin-bottom: 0;
}
.invoice-table thead th {
    background: #f8fafc;
    color: #334155;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 2px solid #e2e8f0 !important;
    padding: 11px 10px !important;
    vertical-align: middle;
}
.invoice-table tbody td {
    padding: 11px 10px !important;
    font-size: 13px;
    color: #334155;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
}
.invoice-table tbody tr:hover {
    background-color: #f8fafc;
}
.invoice-table tfoot td {
    background: #f8fafc;
    font-weight: 600;
    font-size: 13px;
    color: #1e293b;
    border-top: 2px solid #cbd5e1 !important;
    padding: 11px 10px !important;
}
.financial-summary-table td {
    padding: 8px 12px;
    font-size: 13px;
}
.financial-summary-table tr.total-row td {
    font-size: 15px;
    font-weight: 700;
    background: #f1f5f9;
    border-top: 2px solid #cbd5e1;
    border-bottom: 2px solid #cbd5e1;
}
.badge-batch {
    background: #e2e8f0;
    color: #334155;
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 3px;
    font-weight: 500;
}
.badge-exp {
    background: #fef3c7;
    color: #92400e;
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 3px;
    font-weight: 500;
}
@media print {
    .no-print, .main-header, .main-sidebar, .main-footer, .breadcrumb, .box-tools {
        display: none !important;
    }
    .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
        background: #fff !important;
    }
    .content {
        padding: 0 !important;
    }
    .box {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<div class="invoice-view-wrapper">
    <!-- Action Toolbar Header -->
    <div class="row no-print" style="margin-bottom: 16px;">
        <div class="col-md-6 col-sm-12">
            <h2 style="margin: 0; font-size: 22px; font-weight: 700; color: #1e293b;">
                <i class="fa fa-file-text-o text-primary" style="margin-right: 8px;"></i> Invoice Details
                <?php if (!empty($inv_no)): ?>
                    <span style="font-size: 17px; font-weight: 600; color: #64748b; margin-left: 6px;">#<?= htmlspecialchars($inv_no) ?></span>
                <?php endif; ?>
            </h2>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <div class="btn-group">
                <a href="<?= console_url('sale') ?>" class="btn btn-default" style="font-weight: 500;">
                    <i class="fa fa-arrow-left"></i> Back to Sales
                </a>
                <a href="<?= console_url('sale/add_detail') ?>" class="btn btn-success" style="font-weight: 500;">
                    <i class="fa fa-plus"></i> New Sale
                </a>
                <?php if (!empty($inv_no)): ?>
                    <a href="<?= console_url('sale/view_detail/' . base64_encode($inv_no) . '/print') ?>" target="_blank" class="btn btn-primary" style="font-weight: 600;">
                        <i class="fa fa-print"></i> Print Invoice
                    </a>
                    <button type="button" onclick="window.print()" class="btn btn-default" style="font-weight: 500;">
                        <i class="fa fa-file-pdf-o"></i> Print View
                    </button>
                    <a href="<?= console_url('return_sale/add_detail') ?>" class="btn btn-warning" style="font-weight: 500;">
                        <i class="fa fa-reply"></i> Return
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Search Invoice Bar -->
    <div class="box box-solid no-print" style="border-radius: 6px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        <div class="box-body" style="padding: 12px 18px; background: #fafbfc; border-radius: 6px;">
            <form class="form-inline" onsubmit="event.preventDefault(); var inv = $('#quick_search_inv').val().trim(); if(inv){ window.location.href='<?= console_url('sale/view_detail/') ?>' + btoa(inv); }">
                <div class="form-group" style="margin-right: 10px;">
                    <label for="quick_search_inv" style="font-weight: 600; color: #475569; margin-right: 8px;">
                        <i class="fa fa-search text-muted"></i> Switch Invoice:
                    </label>
                    <input type="text" id="quick_search_inv" placeholder="Enter Invoice No (e.g. <?= htmlspecialchars($inv_no) ?>)" class="form-control" style="width: 280px;" value="<?= htmlspecialchars($inv_no) ?>" />
                </div>
                <button type="submit" class="btn btn-primary btn-sm" style="font-weight: 600; padding: 6px 14px;">
                    View Invoice
                </button>
            </form>
        </div>
    </div>

    <?php if (!$has_data): ?>
        <!-- Not Found Notice -->
        <div class="alert alert-warning" style="border-radius: 6px;">
            <h4><i class="fa fa-warning"></i> Invoice Not Found</h4>
            <p>No sale records found for invoice: <strong><?= htmlspecialchars($inv_no) ?></strong>. Please verify the invoice number or use the search box above.</p>
            <div style="margin-top: 15px;">
                <a href="<?= console_url('sale') ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Return to Sales List</a>
            </div>
        </div>
    <?php else: ?>

        <!-- Invoice Overview Header Banner -->
        <div class="invoice-header-card">
            <div class="row">
                <div class="col-md-7 col-sm-6">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: #0f172a;">
                            Invoice No: <?= htmlspecialchars($inv_no) ?>
                        </h3>
                        <div><?= $status_badge ?></div>
                    </div>
                    <div style="color: #64748b; font-size: 13px;">
                        <span><i class="fa fa-calendar"></i> <strong>Date:</strong> <?= $inv_date ?></span>
                        <span style="margin: 0 8px;">•</span>
                        <span><i class="fa fa-clock-o"></i> <strong>Created:</strong> <?= !empty($inv_row['sale_timestamp']) ? date('d M Y, h:i A', strtotime($inv_row['sale_timestamp'])) : '-' ?></span>
                    </div>
                </div>
                <div class="col-md-5 col-sm-6 text-right">
                    <div style="color: #64748b; font-size: 13px; margin-bottom: 4px;">Net Payable Amount</div>
                    <div style="font-size: 26px; font-weight: 700; color: #0284c7;">
                        ₹ <?= number_format($total_payable, 2) ?>
                    </div>
                    <div style="font-size: 12px; color: <?= $current_due > 0 ? '#dc2626' : '#16a34a' ?>; font-weight: 600;">
                        <?= $current_due > 0 ? 'Due: ₹ ' . number_format($current_due, 2) : 'Paid in Full' ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meta Information Cards (Customer, Doctor, Payment) -->
        <div class="row" style="margin-bottom: 20px;">
            <!-- Customer Card -->
            <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                <div class="invoice-meta-card">
                    <div class="card-icon"><i class="fa fa-user"></i></div>
                    <div class="card-title">Customer Information</div>
                    <div class="card-content">
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                            <?= !empty($inv_row['customer_name']) ? htmlspecialchars($inv_row['customer_name']) : 'Walk-in Customer' ?>
                        </div>
                        <?php if (!empty($inv_row['customer_contact'])): ?>
                            <div style="color: #475569; margin-bottom: 2px;">
                                <i class="fa fa-phone text-muted" style="width: 14px;"></i> <?= htmlspecialchars($inv_row['customer_contact']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($inv_row['customer_address'])): ?>
                            <div style="color: #475569; margin-bottom: 2px;">
                                <i class="fa fa-map-marker text-muted" style="width: 14px;"></i> <?= htmlspecialchars($inv_row['customer_address']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($inv_row['customer_gst'])): ?>
                            <div style="color: #475569;">
                                <i class="fa fa-id-card-o text-muted" style="width: 14px;"></i> <strong>GSTIN:</strong> <?= htmlspecialchars($inv_row['customer_gst']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Doctor Card -->
            <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                <div class="invoice-meta-card">
                    <div class="card-icon" style="background: #f0fdf4; color: #16a34a;"><i class="fa fa-user-md"></i></div>
                    <div class="card-title">Doctor / Prescriber</div>
                    <div class="card-content">
                        <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;">
                            <?= !empty($inv_row['doctor_name']) ? htmlspecialchars($inv_row['doctor_name']) : 'Self / Not Specified' ?>
                        </div>
                        <?php if (!empty($inv_row['doctor_address'])): ?>
                            <div style="color: #475569;">
                                <i class="fa fa-hospital-o text-muted" style="width: 14px;"></i> <?= htmlspecialchars($inv_row['doctor_address']) ?>
                            </div>
                        <?php else: ?>
                            <div style="color: #94a3b8; font-style: italic;">No doctor address recorded</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Payment Meta Card -->
            <div class="col-md-4 col-sm-12" style="margin-bottom: 12px;">
                <div class="invoice-meta-card">
                    <div class="card-icon" style="background: #fef3c7; color: #d97706;"><i class="fa fa-credit-card"></i></div>
                    <div class="card-title">Payment & Notes</div>
                    <div class="card-content">
                        <div style="margin-bottom: 4px;">
                            <span style="color: #64748b;">Payment Method:</span>
                            <span class="label label-primary" style="font-size: 12px; margin-left: 4px; padding: 3px 8px;">
                                <?= !empty($inv_row['sale_paid_by']) ? htmlspecialchars($inv_row['sale_paid_by']) : 'Cash' ?>
                            </span>
                        </div>
                        <div style="color: #475569; margin-top: 6px;">
                            <strong>Note / Remarks:</strong>
                            <div style="color: #64748b; font-style: italic; margin-top: 2px;">
                                <?= !empty($inv_row['sale_note']) ? htmlspecialchars($inv_row['sale_note']) : 'No payment remarks' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sold Items Table Card -->
        <div class="box box-primary" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 22px;">
            <div class="box-header with-border" style="padding: 14px 18px;">
                <h3 class="box-title" style="font-size: 16px; font-weight: 600; color: #1e293b;">
                    <i class="fa fa-list text-primary" style="margin-right: 6px;"></i> Sold Items
                    <span class="badge" style="background: #3c8dbc; font-size: 12px; margin-left: 6px;"><?= count($sold_items) ?> Items</span>
                </h3>
                <div class="box-tools pull-right no-print">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding table-responsive">
                <table class="table invoice-table table-hover">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">#</th>
                            <th style="min-width: 180px;">Product Name</th>
                            <th style="width: 80px; text-align: center;">HSN</th>
                            <th style="width: 100px; text-align: center;">Batch</th>
                            <th style="width: 75px; text-align: center;">Exp</th>
                            <th style="width: 70px; text-align: center;">Strip</th>
                            <th style="width: 70px; text-align: center;">Loose</th>
                            <th style="width: 85px; text-align: right;">MRP</th>
                            <th style="width: 85px; text-align: right;">Rate</th>
                            <th style="width: 65px; text-align: center;">Disc%</th>
                            <th style="width: 90px; text-align: right;">Taxable</th>
                            <th style="width: 80px; text-align: right;">CGST</th>
                            <th style="width: 80px; text-align: right;">SGST</th>
                            <th style="width: 100px; text-align: right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($sold_items)): ?>
                            <tr>
                                <td colspan="14" style="text-align: center; padding: 25px; color: #94a3b8;">
                                    <i class="fa fa-info-circle"></i> No sold items found in this invoice.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php 
                            $counter = 0;
                            foreach ($sold_items as $item): 
                                $counter++;
                                $exp_str = (!empty($item['sale_expire_month']) && !empty($item['sale_expire_year'])) 
                                    ? sprintf('%02d/%s', $item['sale_expire_month'], substr($item['sale_expire_year'], -2)) 
                                    : '-';
                            ?>
                                <tr>
                                    <td style="text-align: center; font-weight: 600; color: #64748b;"><?= $counter ?></td>
                                    <td>
                                        <div style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($item['medicine_name']) ?></div>
                                        <?php if (!empty($item['medicine_manufacturer'])): ?>
                                            <div style="font-size: 11px; color: #64748b;">Mfg: <?= htmlspecialchars($item['medicine_manufacturer']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center; color: #64748b;"><?= !empty($item['medicine_hsn']) ? htmlspecialchars($item['medicine_hsn']) : '-' ?></td>
                                    <td style="text-align: center;">
                                        <span class="badge-batch"><?= !empty($item['sale_batch']) ? htmlspecialchars($item['sale_batch']) : '-' ?></span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="badge-exp"><?= $exp_str ?></span>
                                    </td>
                                    <td style="text-align: center; font-weight: 600;"><?= (int)$item['sale_strip_quantity'] ?></td>
                                    <td style="text-align: center; color: #64748b;"><?= (int)$item['sale_loose_quantity'] ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_mrp'], 2) ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_rate'], 2) ?></td>
                                    <td style="text-align: center;"><?= (float)$item['sale_discount_percent'] > 0 ? (float)$item['sale_discount_percent'] . '%' : '-' ?></td>
                                    <td style="text-align: right; font-weight: 500;">₹ <?= number_format((float)$item['sale_taxable'], 2) ?></td>
                                    <td style="text-align: right; color: #64748b;">
                                        ₹ <?= number_format((float)$item['sale_cgst'], 2) ?>
                                        <div style="font-size: 10px; color: #94a3b8;"><?= (float)$item['sale_cgst_percent'] ?>%</div>
                                    </td>
                                    <td style="text-align: right; color: #64748b;">
                                        ₹ <?= number_format((float)$item['sale_sgst'], 2) ?>
                                        <div style="font-size: 10px; color: #94a3b8;"><?= (float)$item['sale_sgst_percent'] ?>%</div>
                                    </td>
                                    <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                        ₹ <?= number_format((float)$item['sale_total'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($sold_items)): ?>
                        <tfoot>
                            <tr>
                                <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                                <td style="text-align: center; font-weight: 700;"><?= $total_strips ?></td>
                                <td style="text-align: center; font-weight: 700;"><?= $total_loose ?></td>
                                <td colspan="3"></td>
                                <td style="text-align: right; font-weight: 700;">₹ <?= number_format($total_sold_taxable, 2) ?></td>
                                <td style="text-align: right; font-weight: 700;">₹ <?= number_format($total_sold_cgst, 2) ?></td>
                                <td style="text-align: right; font-weight: 700;">₹ <?= number_format($total_sold_sgst, 2) ?></td>
                                <td style="text-align: right; font-weight: 700; color: #0284c7; font-size: 14px;">
                                    ₹ <?= number_format($total_sold_amount, 2) ?>
                                </td>
                            </tr>
                        </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <?php if (!empty($return_items)): ?>
            <!-- Return Items Card -->
            <div class="box box-warning" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 22px;">
                <div class="box-header with-border" style="padding: 14px 18px;">
                    <h3 class="box-title" style="font-size: 16px; font-weight: 600; color: #92400e;">
                        <i class="fa fa-reply text-warning" style="margin-right: 6px;"></i> Returned Items
                        <span class="badge" style="background: #f39c12; font-size: 12px; margin-left: 6px;"><?= count($return_items) ?> Items</span>
                    </h3>
                </div>
                <div class="box-body no-padding table-responsive">
                    <table class="table invoice-table table-hover">
                        <thead>
                            <tr style="background: #fffbeb;">
                                <th style="width: 45px; text-align: center;">#</th>
                                <th style="width: 100px;">Return Date</th>
                                <th style="min-width: 180px;">Product Name</th>
                                <th style="width: 80px; text-align: center;">HSN</th>
                                <th style="width: 100px; text-align: center;">Batch</th>
                                <th style="width: 70px; text-align: center;">Qty</th>
                                <th style="width: 85px; text-align: right;">Rate</th>
                                <th style="width: 90px; text-align: right;">Taxable</th>
                                <th style="width: 80px; text-align: right;">CGST</th>
                                <th style="width: 80px; text-align: right;">SGST</th>
                                <th style="width: 100px; text-align: right;">Total Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $r_counter = 0;
                            $r_total_amount = 0;
                            foreach ($return_items as $item): 
                                $r_counter++;
                                $r_total_amount += (float)$item['sale_total'];
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $r_counter ?></td>
                                    <td><?= !empty($item['sale_return_date']) ? date('d M Y', strtotime($item['sale_return_date'])) : '-' ?></td>
                                    <td>
                                        <div style="font-weight: 600;"><?= htmlspecialchars($item['medicine_name']) ?></div>
                                        <?php if (!empty($item['medicine_manufacturer'])): ?>
                                            <div style="font-size: 11px; color: #64748b;">Mfg: <?= htmlspecialchars($item['medicine_manufacturer']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;"><?= !empty($item['medicine_hsn']) ? htmlspecialchars($item['medicine_hsn']) : '-' ?></td>
                                    <td style="text-align: center;"><span class="badge-batch"><?= !empty($item['sale_batch']) ? htmlspecialchars($item['sale_batch']) : '-' ?></span></td>
                                    <td style="text-align: center; font-weight: 600;"><?= (int)$item['sale_quantity'] ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_rate'], 2) ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_taxable'], 2) ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_cgst'], 2) ?></td>
                                    <td style="text-align: right;">₹ <?= number_format((float)$item['sale_sgst'], 2) ?></td>
                                    <td style="text-align: right; font-weight: 700; color: #b45309;">
                                        ₹ <?= number_format((float)$item['sale_total'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" style="text-align: right;"><strong>Total Returned Amount:</strong></td>
                                <td style="text-align: right; font-weight: 700; color: #b45309; font-size: 14px;">
                                    ₹ <?= number_format($r_total_amount, 2) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Bottom Summary Section -->
        <div class="row">
            <!-- Left Column: Actions & Payment Notes -->
            <div class="col-md-6 col-sm-12" style="margin-bottom: 20px;">
                <div class="box box-solid" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); height: 100%;">
                    <div class="box-header with-border" style="padding: 12px 18px;">
                        <h4 class="box-title" style="font-size: 15px; font-weight: 600; color: #334155;">
                            <i class="fa fa-info-circle text-info" style="margin-right: 6px;"></i> Invoice Summary & Notes
                        </h4>
                    </div>
                    <div class="box-body" style="padding: 18px;">
                        <table class="table" style="margin-bottom: 15px;">
                            <tr>
                                <td style="width: 140px; border-top: none; color: #64748b;"><strong>Payment Mode:</strong></td>
                                <td style="border-top: none; font-weight: 600;">
                                    <?= !empty($inv_row['sale_paid_by']) ? htmlspecialchars($inv_row['sale_paid_by']) : 'Cash' ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #64748b;"><strong>Invoice Status:</strong></td>
                                <td><?= $status_badge ?></td>
                            </tr>
                            <tr>
                                <td style="color: #64748b;"><strong>Notes:</strong></td>
                                <td style="color: #475569; font-style: italic;">
                                    <?= !empty($inv_row['sale_note']) ? htmlspecialchars($inv_row['sale_note']) : 'No remarks recorded for this invoice.' ?>
                                </td>
                            </tr>
                        </table>

                        <div class="no-print" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #f1f5f9; display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="<?= console_url('sale/view_detail/' . base64_encode($inv_no) . '/print') ?>" target="_blank" class="btn btn-primary btn-sm" style="font-weight: 600;">
                                <i class="fa fa-print"></i> Formal Print
                            </a>
                            <button type="button" onclick="window.print()" class="btn btn-default btn-sm">
                                <i class="fa fa-print"></i> Print View
                            </button>
                            <a href="<?= console_url('return_sale/add_detail') ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-undo"></i> Sale Return
                            </a>
                            <a href="<?= console_url('sale') ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-list"></i> All Sales
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Financial Calculation Card -->
            <div class="col-md-6 col-sm-12" style="margin-bottom: 20px;">
                <div class="box box-solid" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); border-top: 3px solid #3c8dbc;">
                    <div class="box-header with-border" style="padding: 12px 18px;">
                        <h4 class="box-title" style="font-size: 15px; font-weight: 600; color: #1e293b;">
                            <i class="fa fa-calculator text-primary" style="margin-right: 6px;"></i> Financial Calculation Breakdown
                        </h4>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table financial-summary-table" style="margin: 0;">
                            <tbody>
                                <tr>
                                    <td style="color: #475569;">Total Sold Items</td>
                                    <td style="text-align: right; font-weight: 600;"><?= count($sold_items) ?> Items</td>
                                </tr>
                                <tr>
                                    <td style="color: #475569;">Taxable Value</td>
                                    <td style="text-align: right; font-weight: 600;">₹ <?= number_format($total_sold_taxable, 2) ?></td>
                                </tr>
                                <tr>
                                    <td style="color: #475569;">Total CGST</td>
                                    <td style="text-align: right; color: #64748b;">₹ <?= number_format($total_sold_cgst, 2) ?></td>
                                </tr>
                                <tr>
                                    <td style="color: #475569;">Total SGST</td>
                                    <td style="text-align: right; color: #64748b;">₹ <?= number_format($total_sold_sgst, 2) ?></td>
                                </tr>
                                <tr>
                                    <td style="color: #475569;">Total GST (CGST + SGST)</td>
                                    <td style="text-align: right; font-weight: 600; color: #3b82f6;">₹ <?= number_format($total_sold_gst, 2) ?></td>
                                </tr>
                                <tr class="total-row">
                                    <td style="color: #0f172a;">Current Invoice Total</td>
                                    <td style="text-align: right; color: #0284c7; font-size: 16px;">₹ <?= number_format($total_sold_amount, 2) ?></td>
                                </tr>
                                <tr>
                                    <td style="color: #475569;">Previous Balance / Due</td>
                                    <td style="text-align: right; color: <?= $prev_due > 0 ? '#dc2626' : '#64748b' ?>;">₹ <?= number_format($prev_due, 2) ?></td>
                                </tr>
                                <tr style="background: #fafbfc;">
                                    <td style="font-weight: 700; color: #1e293b;">Total Payable Amount</td>
                                    <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 15px;">₹ <?= number_format($total_payable, 2) ?></td>
                                </tr>
                                <tr>
                                    <td style="color: #16a34a; font-weight: 600;">Amount Paid</td>
                                    <td style="text-align: right; font-weight: 700; color: #16a34a; font-size: 15px;">₹ <?= number_format($total_paid, 2) ?></td>
                                </tr>
                                <tr style="background: <?= $current_due > 0 ? '#fef2f2' : '#f0fdf4' ?>; border-top: 2px solid <?= $current_due > 0 ? '#fca5a5' : '#86efac' ?>;">
                                    <td style="font-size: 15px; font-weight: 700; color: <?= $current_due > 0 ? '#991b1b' : '#166534' ?>;">
                                        <?= $current_due > 0 ? 'Remaining Due Amount' : 'Balance Due' ?>
                                    </td>
                                    <td style="text-align: right; font-size: 18px; font-weight: 800; color: <?= $current_due > 0 ? '#dc2626' : '#16a34a' ?>;">
                                        ₹ <?= number_format(max(0, $current_due), 2) ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>