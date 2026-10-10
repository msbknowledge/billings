<style>
    .invoice-view-wrapper {
        margin-bottom: 25px;
    }
    .invoice-view-wrapper .box {
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .invoice-info-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 20px;
    }
    .invoice-info-card h4 {
        margin-top: 0;
        margin-bottom: 12px;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 8px;
    }
    .invoice-info-card p {
        margin-bottom: 6px;
        font-size: 13px;
        color: #475569;
    }
    .invoice-table th {
        background: #2c3b4c;
        color: #ffffff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle !important;
        text-align: center;
        padding: 8px 5px !important;
        white-space: nowrap;
    }
    .invoice-table td {
        vertical-align: middle !important;
        font-size: 12px;
        padding: 6px 5px !important;
    }
    .summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 15px;
        margin-top: 15px;
    }
    .summary-table td, .summary-table th {
        padding: 6px 12px;
        font-size: 13px;
    }
    @media print {
        .no-print, .main-sidebar, .main-header, .content-header, .btn {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }
        .box {
            border: none !important;
            box-shadow: none !important;
        }
    }
</style>

<div class="invoice-view-wrapper">
    <div class="box box-primary">
        <!-- Header -->
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-file-text-o text-primary"></i> 
                Purchase Invoice: <strong><?= htmlspecialchars($data[0]['purchase_invoice']) ?></strong>
            </h3>
            <div class="box-tools pull-right no-print">
                <a href="<?= console_url('purchase'); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-arrow-left"></i> Back to Purchases
                </a>
                <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">
                    <i class="fa fa-print"></i> Print Invoice
                </button>
            </div>
        </div>

        <div class="box-body" style="padding: 20px;">
            <!-- Supplier & Invoice Meta Grid -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="invoice-info-card">
                        <h4><i class="fa fa-truck text-primary"></i> Supplier Details</h4>
                        <p><strong>Name:</strong> <?= htmlspecialchars($data[0]['supplier_name']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($data[0]['supplier_address']) ?></p>
                        <p><strong>GSTIN:</strong> <span class="badge bg-aqua"><?= htmlspecialchars($data[0]['supplier_gst']) ?></span></p>
                        <p><strong>Contact:</strong> <?= htmlspecialchars($data[0]['supplier_contact']) ?></p>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="invoice-info-card">
                        <h4><i class="fa fa-info-circle text-primary"></i> Invoice Information</h4>
                        <p><strong>Invoice Number:</strong> <span class="label label-primary" style="font-size: 13px;"><?= htmlspecialchars($data[0]['purchase_invoice']) ?></span></p>
                        <p><strong>Purchase Date:</strong> <?= date('d M, Y', strtotime($data[0]['purchase_date'])) ?></p>
                        <p><strong>Entry Number:</strong> <?= htmlspecialchars($data[0]['purchase_entry_number']) ?></p>
                        <p><strong>Status:</strong> <span class="label label-success">Received</span></p>
                    </div>
                </div>
            </div>

            <?php
            $total = 0;
            $cgst = 0;
            $sgst = 0;
            $taxable_sum = 0;
            $counter = 0;
            ?>

            <!-- Purchased Items Table -->
            <div class="box box-solid box-default" style="border: 1px solid #e2e8f0; margin-top: 10px;">
                <div class="box-header with-border" style="background: #f8fafc;">
                    <h4 class="box-title" style="font-size: 14px; font-weight: 600; color: #334155;">
                        <i class="fa fa-cubes text-primary"></i> Purchased Items
                    </h4>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover invoice-table">
                            <thead>
                                <tr>
                                    <th style="width: 35px;">#</th>
                                    <th style="text-align: left; min-width: 160px;">Product Name</th>
                                    <th>HSN</th>
                                    <th>Mfg</th>
                                    <th>Category</th>
                                    <th>Sched</th>
                                    <th>Qty</th>
                                    <th>Free</th>
                                    <th>Unit</th>
                                    <th>Batch</th>
                                    <th>Expiry</th>
                                    <th>MRP</th>
                                    <th>Rate</th>
                                    <th>Disc%</th>
                                    <th>Bonus%</th>
                                    <th>Taxable</th>
                                    <th>CGST%</th>
                                    <th>CGST</th>
                                    <th>SGST%</th>
                                    <th>SGST</th>
                                    <th style="text-align: right;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $value): ?>
                                    <?php
                                    if ($value['purchase_return'] == true) {
                                        continue;
                                    }
                                    $counter++;
                                    $cgst += (float)$value['purchase_cgst'];
                                    $sgst += (float)$value['purchase_sgst'];
                                    $taxable_sum += (float)$value['purchase_taxable'];
                                    $total += (float)$value['purchase_total'];
                                    ?>
                                    <tr>
                                        <td class="text-center font-weight-bold"><?= $counter ?></td>
                                        <td style="text-align: left; font-weight: 600; color: #1e293b;"><?= htmlspecialchars($value['medicine_name']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['medicine_hsn']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['medicine_manufacturer']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['medicine_category']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['medicine_schedule']) ?></td>
                                        <td class="text-center"><strong><?= htmlspecialchars($value['purchase_quantity']) ?></strong></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_free_quantity']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_unit']) ?></td>
                                        <td class="text-center"><span class="badge bg-gray"><?= htmlspecialchars($value['purchase_batch']) ?></span></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_expire_month']) ?>/<?= htmlspecialchars($value['purchase_expire_year']) ?></td>
                                        <td class="text-right"><?= number_format((float)$value['purchase_mrp'], 2) ?></td>
                                        <td class="text-right"><?= number_format((float)$value['purchase_rate'], 2) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_discount_percent']) ?>%</td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_bonus']) ?>%</td>
                                        <td class="text-right"><?= number_format((float)$value['purchase_taxable'], 2) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_cgst_percent']) ?>%</td>
                                        <td class="text-right"><?= number_format((float)$value['purchase_cgst'], 2) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($value['purchase_sgst_percent']) ?>%</td>
                                        <td class="text-right"><?= number_format((float)$value['purchase_sgst'], 2) ?></td>
                                        <td class="text-right" style="font-weight: 700; color: #0f172a;"><?= number_format((float)$value['purchase_total'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Invoice Summary Grid -->
            <div class="row" style="margin-top: 15px;">
                <div class="col-sm-6">
                    <div class="callout callout-info" style="border-radius: 4px; margin-bottom: 0;">
                        <h4><i class="fa fa-info"></i> Purchase Summary</h4>
                        <p>Total items purchased: <strong><?= $counter ?></strong></p>
                        <p>Total Taxable amount: <strong>₹ <?= number_format($taxable_sum, 2) ?></strong></p>
                        <p>Total GST (CGST + SGST): <strong>₹ <?= number_format($cgst + $sgst, 2) ?></strong></p>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="summary-card">
                        <table class="table summary-table" style="margin-bottom: 0;">
                            <tr>
                                <td><strong>Total Items:</strong></td>
                                <td class="text-right"><?= $counter ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total CGST:</strong></td>
                                <td class="text-right">₹ <?= number_format($cgst, 2) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total SGST:</strong></td>
                                <td class="text-right">₹ <?= number_format($sgst, 2) ?></td>
                            </tr>
                            <tr>
                                <td><strong>Total GST:</strong></td>
                                <td class="text-right" style="color: #0284c7; font-weight: 600;">₹ <?= number_format($cgst + $sgst, 2) ?></td>
                            </tr>
                            <tr style="border-top: 2px solid #cbd5e1;">
                                <td style="font-size: 15px;"><strong>Grand Total:</strong></td>
                                <td class="text-right" style="font-size: 16px; font-weight: bold; color: #059669;">₹ <?= number_format($total, 2) ?></td>
                            </tr>
                            <tr style="background: #e2e8f0;">
                                <td style="font-size: 16px;"><strong>Round Total:</strong></td>
                                <td class="text-right" style="font-size: 18px; font-weight: 800; color: #047857;">₹ <?= number_format(round($total), 2) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <?php
            // Check if return items exist
            $hasReturns = false;
            foreach ($data as $value) {
                if ($value['purchase_return'] == true) {
                    $hasReturns = true;
                    break;
                }
            }
            ?>

            <?php if ($hasReturns): ?>
                <?php
                $return_total = 0;
                $return_cgst = 0;
                $return_sgst = 0;
                $return_counter = 0;
                ?>
                <div class="box box-warning" style="margin-top: 25px;">
                    <div class="box-header with-border">
                        <h4 class="box-title text-warning"><i class="fa fa-reply"></i> Returned Items</h4>
                    </div>
                    <div class="box-body no-padding">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped invoice-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Return Date</th>
                                        <th style="text-align: left;">Product Name</th>
                                        <th>HSN</th>
                                        <th>Mfg</th>
                                        <th>Qty</th>
                                        <th>Free</th>
                                        <th>Unit</th>
                                        <th>Batch</th>
                                        <th>Expiry</th>
                                        <th>MRP</th>
                                        <th>Rate</th>
                                        <th>Disc%</th>
                                        <th>Taxable</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $value): ?>
                                        <?php
                                        if ($value['purchase_return'] != true) {
                                            continue;
                                        }
                                        $return_counter++;
                                        $return_cgst += (float)$value['purchase_cgst'];
                                        $return_sgst += (float)$value['purchase_sgst'];
                                        $return_total += (float)$value['purchase_total'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $return_counter ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['purchase_return_date']) ?></td>
                                            <td style="text-align: left; font-weight: 600;"><?= htmlspecialchars($value['medicine_name']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['medicine_hsn']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['medicine_manufacturer']) ?></td>
                                            <td class="text-center font-weight-bold"><?= htmlspecialchars($value['purchase_quantity']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['purchase_free_quantity']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['medicine_unit']) ?></td>
                                            <td class="text-center"><span class="badge bg-gray"><?= htmlspecialchars($value['purchase_batch']) ?></span></td>
                                            <td class="text-center"><?= htmlspecialchars($value['purchase_expire_month']) ?>/<?= htmlspecialchars($value['purchase_expire_year']) ?></td>
                                            <td class="text-right"><?= number_format((float)$value['purchase_mrp'], 2) ?></td>
                                            <td class="text-right"><?= number_format((float)$value['purchase_rate'], 2) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($value['purchase_discount_percent']) ?>%</td>
                                            <td class="text-right"><?= number_format((float)$value['purchase_taxable'], 2) ?></td>
                                            <td class="text-right"><?= number_format((float)$value['purchase_cgst'], 2) ?></td>
                                            <td class="text-right"><?= number_format((float)$value['purchase_sgst'], 2) ?></td>
                                            <td class="text-right font-weight-bold" style="color: #dc2626;"><?= number_format((float)$value['purchase_total'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right" style="font-size: 15px; font-weight: 700; color: #dc2626;">
                            Total Return Amount: ₹ <?= number_format(round($return_total), 2) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="box-footer clearfix no-print" style="padding: 15px 20px; background: #ffffff; border-top: 1px solid #e9ecef;">
            <div class="pull-left">
                <a href="<?= console_url('purchase'); ?>" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i> Back to Purchases List
                </a>
            </div>
            <div class="pull-right">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fa fa-print"></i> Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>