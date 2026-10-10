<style>
    .sale-edit-wrapper {
        font-family: inherit;
    }
    .sale-edit-wrapper .box {
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        background: #fff;
    }
    .sale-edit-wrapper .panel-header-custom {
        background: #f8fafc;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 15px;
        font-weight: 600;
        color: #334155;
    }
    .sale-edit-wrapper .table-custom-items {
        margin-bottom: 0;
    }
    .sale-edit-wrapper .table-custom-items th {
        background: #2c3b4c;
        color: #ffffff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle !important;
        text-align: center;
        padding: 8px 4px;
        white-space: nowrap;
        border: 1px solid #1e293b !important;
    }
    .sale-edit-wrapper .table-custom-items td {
        vertical-align: middle !important;
        padding: 4px !important;
        text-align: center;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff;
    }
    .sale-edit-wrapper .table-custom-items input,
    .sale-edit-wrapper .table-custom-items select {
        font-size: 11px;
        height: 28px;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
        text-align: center;
        padding: 2px 4px;
        box-sizing: border-box;
    }
    .sale-edit-wrapper .table-custom-items input:focus,
    .sale-edit-wrapper .table-custom-items select:focus {
        border-color: #3c8dbc;
        outline: none;
        box-shadow: 0 0 3px rgba(60, 141, 188, 0.4);
    }
    .sale-summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 15px;
    }
    .sale-summary-card .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed #cbd5e1;
        font-size: 13px;
    }
    .sale-summary-card .summary-row:last-child {
        border-bottom: none;
    }
    .sale-summary-card .summary-label {
        color: #64748b;
        font-weight: 500;
    }
    .sale-summary-card .summary-val {
        font-weight: 700;
        color: #1e293b;
    }
    .sale-summary-card .summary-val.highlight-green {
        font-size: 18px;
        color: #059669;
    }
    .sale-summary-card .summary-val.highlight-blue {
        font-size: 18px;
        color: #2563eb;
    }
    .btn-add-medicine {
        font-size: 13px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 4px;
    }
    .ui-autocomplete-loading {
        background: white url('data:image/gif;base64,R0lGODlhEAAQAPMPALu7u5mZmTMzM93d3REREQAAAHd3d1VVVWZmZqqqqoiIiO7u7kRERCIiIgARAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBwAPACwAAAAAEAAQAEAEcPDJtyg6dUrFetDTIopMoSyFcxxD1krD8AwCkASDIlPaUDQLR6G1Cy0SgqIkE1IQGMrFAKCcGWSBzwPAnAwarcKQ15MpTMJYd1ZyUDXSDGelBY0qIoBh/ZoYGgELCjoxCRRvIQcGD1kzgSAgAACQDxEAIfkEBQcADwAsAAAAAA8AEAAABF3wyfkMkotOJpscRKJJwtI4Q1MAoxQ0RFBw0xEvhGAVRZZJh4JgMAEQW7TWI4EwGFjKR+CAQECjn8DoN0kwDtvBT8FILAKJgfoo1iAGAPNVY9DGJXNMIHN/HJVqIxEAIfkEBQcADwAsAAAAABAADwAABFrwyfmColgiydpaQiY5x9Ith7hURdIl0wBIhpCAjKIIxaAUPQ0hFQsAC7MJALFSFi4SgC4wyHyuCYNWxH3AuhSEotkNGAALAPqqkigG8MWAjAnM4A8594vPUyIAIfkEBQcADwAsAAAAABAAEAAABF3wySkDvdKsddg+APYIWrcg2DIRQAcU6DJICjIsjBEETLEEBYLqYSDdJoCGiHgZwG4LQCCRECEIBAdoF5hdEIWwgBJqDs7DgcKyRHZl3uUwuhm2AbNNW+LV7yd+FxEAIfkEBQcACAAsAAAAABAADgAABEYQyYmMoVgeWQrP3NYhBCgZBdAFRUkdBIAUguVVo1ZsWFcEGB5GMBkEjiCBL2a5ZAi+m2SAURExwKqPiuCafBkvBSCcmiYRACH5BAUHAA4ALAAAAAAQABAAAARs0MnpAKDYrbSWMp0xZIvBKYrXjNmADOhAKBiQDF5gGcICNAyJTwFYTBaDQ0HAkgwSmAUj0OkMrkZM4HBgKK7YTKDRICAo2clAEIheKc9CISjEVTuEQrJASGcSBQcSUFEUDQUXJBgDBW0Zj34RACH5BAUHAA8ALAAAAAAQABAAAARf8Mn5xqBYgrVC4EEmBcOSfAEjSopJMglmcQlgBYjE5NJgZwjCAbO4YBAJjpIjSiAQh5ayyRAIDKvJIbnIagoFRFdkQDQKC0RBsCIUFAWsT7RwG410R8HiiK0WBwJjFBEAIfkEBQcADgAsAQABAA8ADwAABFrQybEWADXJLUHHAMJxIDAgnrOo2+AOibEMh1LN62gIxphzitRoCDAYNcNN6FBLShao4WzwHDQKvVGhoFAwGgtFgQHENhoB7nCwHRAIC0EyUcC8Zw1ha3NIRgAAIfkEBQcADwAsAAAAABAAEAAABGDwyfnWoljaNYYFV+Zx3hCEGEcuypBtMJBISpClAWLfWODymIFiCJwMDMiZBNAAYFqUAaNQ2E0YBIXGURAMCo1AAsFYBBoIScBJEwgSVcmP0li4FwcHz+FpCCQMPCFINxEAIfkEBQcADgAsAAABABAADwAABFzQyemWXYNqaSXY2vVtw3UNmROM4JQowKKlFOsgRI6ASQ8IhSADFAjAMIMAgSYJtByxyQIhcEoaBcSiwegpDgvAwSBJ0AIHBoCQqIAEi/TCIAABGhLG8MbcKBQgEQAh+QQFBwAPACwAAAEAEAAPAAAEXfDJSd+qeK5RB8fDRRWFspyotAAfQBbfNLCVUSSdKDV89gDAwcFBIBgywMRnkWBgcJUDKSZRIKAPQcGwYByAAYTEEJAAJIGbATEQ+B4ExmK9CDhBd8ThdHw/AmUYEQAh+QQFBwAPACwAAAEADwAPAAAEXvBJQIa8+ILSspdHkXxS9wxF4Q3L2aTBeC0sFjhAtuyLIjAMhYc2GBgaSKGuyNoBDp7czFAgeBIKwC6kWCAMxUSAFjtNCAAFGGF5tCQLAaJnWCTqHoREvQuQJAkyGBEAOw==') right center no-repeat;
    }
</style>

<?php
$has_data = !empty($data) && is_array($data) && count($data) > 0;
$inv_number = $has_data ? $data[0]['sale_invoice'] : '';
$inv_date = $has_data && !empty($data[0]['sale_date']) ? date('d-M-Y', strtotime($data[0]['sale_date'])) : date('d-M-Y');
$cust_contact = $has_data ? $data[0]['customer_contact'] : '';
$cust_name = $has_data ? $data[0]['customer_name'] : '';
$cust_address = $has_data ? $data[0]['customer_address'] : '';
$cust_gst = $has_data ? $data[0]['customer_gst'] : 'N/A';
$doc_name = $has_data ? $data[0]['doctor_name'] : 'N/A';
$prev_due = $has_data ? $data[0]['sale_total_previous_due'] : '0.00';
$paid_amount = $has_data ? $data[0]['sale_total_paid'] : '0.00';
$curr_due = $has_data ? $data[0]['sale_total_current_due'] : '0.00';
$paid_by = $has_data ? $data[0]['sale_paid_by'] : 'Cash';
$sale_note = $has_data ? trim($data[0]['sale_note']) : '';
?>

<div class="sale-edit-wrapper">
    <?php if (isset($status)): ?>
        <div class="alert alert-<?= $status ?> alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> <?= $message ?>
        </div>
    <?php endif; ?>

    <?php if (!$has_data): ?>
        <div class="callout callout-warning">
            <h4><i class="fa fa-warning"></i> No Sale Selected</h4>
            <p>Please select a valid sale invoice to edit from the <a href="<?= console_url('sale'); ?>" class="btn btn-xs btn-primary"><i class="fa fa-list"></i> Sales List</a>.</p>
        </div>
    <?php endif; ?>

    <form method="post" action="" id="saleEditForm">
        <input type="hidden" name="invoice_number" value="<?= $inv_number; ?>">

        <!-- Section 1: Customer & Invoice Details -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-edit text-primary"></i> Edit Sale Invoice #<?= $inv_number; ?></h3>
                <div class="box-tools pull-right">
                    <span class="label label-primary" style="font-size: 13px; padding: 5px 10px;">
                        <i class="fa fa-barcode"></i> <?= $inv_number; ?>
                    </span>
                    <a href="<?= console_url('sale'); ?>" class="btn btn-default btn-xs" style="margin-left: 8px;">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="box-body" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-hashtag text-muted"></i> Invoice No <span class="text-danger">*</span></label>
                            <input readonly="readonly" required="required" type="text" class="form-control input-sm" autocomplete="off" value="<?= $inv_number; ?>" name="sale_invoice" style="background: #f8fafc; font-weight: 700; color: #1e293b;"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-calendar text-muted"></i> Sale Date <span class="text-danger">*</span></label>
                            <input type="text" required="required" class="form-control input-sm datepicker" autocomplete="off" value="<?= $inv_date; ?>" name="sale_date"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-phone text-muted"></i> Customer Contact</label>
                            <input type="text" class="form-control input-sm" autocomplete="off" value="<?= $cust_contact; ?>" name="customer_contact"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-user text-muted"></i> Customer Name <span class="text-danger">*</span></label>
                            <input required="required" type="text" class="form-control input-sm" autocomplete="off" value="<?= $cust_name; ?>" name="customer_name" onchange="calculateTotal()"/>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-map-marker text-muted"></i> Customer Address</label>
                            <input type="text" class="form-control input-sm" autocomplete="off" value="<?= $cust_address; ?>" name="customer_address"/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-building-o text-muted"></i> Customer GSTIN</label>
                            <input type="text" class="form-control input-sm" autocomplete="off" value="<?= $cust_gst; ?>" name="customer_gst"/>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label><i class="fa fa-user-md text-muted"></i> Doctor Name <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon" style="background: #f1f5f9; font-weight: 600;">Dr.</span>
                                <input required="required" value="<?= $doc_name; ?>" type="text" class="form-control" autocomplete="off" name="doctor_name"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Items Table -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-medkit text-info"></i> Sale Medicines / Items</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm btn-add-medicine addm" onclick="addmore()" title="Add another medicine row">
                        <i class="fa fa-plus-circle"></i> Add Medicine Row
                    </button>
                </div>
            </div>
            <div class="box-body" style="padding: 10px;">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered table-hover table-custom-items" id="tableData">
                        <thead>
                            <tr>
                                <th style="width: 45px;">#</th>
                                <th style="min-width: 200px;">Product Name <small style="display:block; font-size:9px; text-transform:none;">(In-stock items appear)</small></th>
                                <th style="width: 55px;">HSN</th>
                                <th style="width: 50px;">Strip</th>
                                <th style="width: 50px;">Loose</th>
                                <th style="width: 45px;">Unit</th>
                                <th style="width: 100px;">Batch</th>
                                <th style="width: 75px;">Exp (M/Y)</th>
                                <th style="width: 65px;">MRP</th>
                                <th style="width: 65px;">Rate</th>
                                <th style="width: 50px;">Disc %</th>
                                <th style="width: 70px;">Taxable</th>
                                <th style="width: 50px;">CGST %</th>
                                <th style="width: 65px;">CGST</th>
                                <th style="width: 50px;">SGST %</th>
                                <th style="width: 65px;">SGST</th>
                                <th style="width: 80px;">Total</th>
                            </tr>
                        </thead>
                        <tbody class="appendHere center">
                            <?php if ($has_data): ?>
                                <?php foreach ($data as $k => $value): ?>
                                    <tr class="rowline">
                                        <td>
                                            <span><?= $k + 1 ?></span><br/>
                                            <a href="javascript:void(0)" onclick="removeRow(this);" title="Remove row" style="color:#ef4444; margin-top:2px; display:inline-block;">
                                                <i class="fa fa-minus-circle fa-lg"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <input required="required" type="hidden" name="medicine_id[]" value="<?= $value['medicine_id'] ?>">
                                            <input required="required" type="text" name="medicine_name[]" value="<?= $value['medicine_name'] ?>" class="form-control input-sm" style="width:100%; margin-bottom:2px;" autocomplete="off">
                                            <div style="font-size:10px; color:#64748b; text-align:left;">Storage:
                                                <input readonly="readonly" value="<?= $value['medicine_storage'] ?>" type="text" name="medicine_storage[]" style="width:65px; height:20px; font-size:10px; border:1px solid #e2e8f0; background:#f8fafc; border-radius:2px;">
                                            </div>
                                        </td>
                                        <td><input required="required" readonly="readonly" type="text" value="<?= $value['medicine_hsn'] ?>" name="medicine_hsn[]" style="width:48px; background:#f8fafc;"></td>
                                        <td><input required="required" type="text" value="<?= $value['sale_strip_quantity'] ?>" name="sale_strip_quantity[]" onkeyup="calculate_the_sale(this)" style="width:38px;"></td>
                                        <td><input required="required" type="text" value="<?= $value['sale_loose_quantity'] ?>" name="sale_loose_quantity[]" onkeyup="calculate_the_sale(this)" style="width:38px;"></td>
                                        <td><input required="required" type="text" value="<?= $value['medicine_unit'] ?>" name="medicine_unit[]" style="width:38px;" onkeyup="calculate_the_sale(this)"></td>
                                        <td><input required="required" type="text" value="<?= $value['sale_batch'] ?>" name="sale_batch[]" style="width:90px;" onkeyup="calculate_the_sale(this)"></td>
                                        <td>
                                            <div style="display:flex; justify-content:center; align-items:center;">
                                                <input required="required" type="text" value="<?= $value['sale_expire_month'] ?>" name="sale_expire_month[]" onkeyup="calculate_the_sale(this)" style="width:24px; padding:0; text-align:center;">
                                                <span style="padding:0 2px;">/</span>
                                                <input readonly="readonly" required="required" value="<?= $value['sale_expire_year'] ?>" type="text" onkeyup="calculate_the_sale(this)" name="sale_expire_year[]" style="width:24px; padding:0; text-align:center; background:#f8fafc;">
                                            </div>
                                        </td>
                                        <td><input required="required" readonly="readonly" value="<?= $value['sale_mrp'] ?>" type="text" onkeyup="calculate_the_sale(this)" name="sale_mrp[]" style="width:58px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_rate'] ?>" type="text" name="sale_rate[]" onkeyup="calculate_the_sale(this)" style="width:58px;"></td>
                                        <td><input required="required" value="<?= $value['sale_discount_percent'] ?>" type="text" name="sale_discount_percent[]" onkeyup="calculate_the_sale(this)" style="width:34px;"></td>
                                        <td><input required="required" value="<?= $value['sale_taxable'] ?>" readonly="readonly" type="text" name="sale_taxable[]" style="width:58px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_cgst_percent'] ?>" readonly="readonly" type="text" name="sale_cgst_percent[]" onkeyup="calculate_the_sale(this)" style="width:34px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_cgst'] ?>" readonly="readonly" type="text" name="sale_cgst[]" style="width:58px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_sgst_percent'] ?>" readonly="readonly" type="text" name="sale_sgst_percent[]" onkeyup="calculate_the_sale(this)" style="width:34px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_sgst'] ?>" readonly="readonly" type="text" name="sale_sgst[]" style="width:58px; background:#f8fafc;"></td>
                                        <td><input required="required" value="<?= $value['sale_total'] ?>" readonly="readonly" type="text" name="sale_total[]" style="width:65px; font-weight:700; color:#059669; background:#f8fafc;"></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 15px; margin-bottom: 5px;">
                    <button type="button" class="btn btn-success btn-sm btn-add-medicine addm" onclick="addmore()">
                        <i class="fa fa-plus-circle"></i> Add Medicine Row
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 3: Summary and Payment Calculations -->
        <div class="row">
            <!-- Left: Payment details -->
            <div class="col-md-7">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-credit-card text-muted"></i> Payment & Notes</h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><i class="fa fa-money text-muted"></i> Paid By</label>
                                    <select name="sale_paid_by" class="form-control input-sm">
                                        <option value="Cash" <?= $paid_by == 'Cash' ? 'selected' : ''; ?>>Cash</option>
                                        <option value="Paytm" <?= $paid_by == 'Paytm' ? 'selected' : ''; ?>>Paytm</option>
                                        <option value="UPI" <?= $paid_by == 'UPI' ? 'selected' : ''; ?>>UPI / GPay / PhonePe</option>
                                        <option value="Card" <?= $paid_by == 'Card' ? 'selected' : ''; ?>>Debit / Credit Card</option>
                                        <option value="Cheque" <?= $paid_by == 'Cheque' ? 'selected' : ''; ?>>Cheque</option>
                                        <option value="Mobikwik" <?= $paid_by == 'Mobikwik' ? 'selected' : ''; ?>>Mobikwik</option>
                                        <option value="Other" <?= $paid_by == 'Other' ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><i class="fa fa-clock-o text-muted"></i> Previous Due (₹)</label>
                                    <input type="text" name="sale_total_previous_due" value="<?= $prev_due; ?>" onkeyup="calculateTotal()" class="form-control input-sm text-center" style="font-weight: 600;"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><i class="fa fa-check-circle text-success"></i> Amount Paid (₹) <span class="text-danger">*</span></label>
                                    <input type="text" name="sale_total_paid" class="form-control input-sm sale_total_paid text-center" onkeyup="currentdue()" value="<?= $paid_amount; ?>" style="font-weight: 700; font-size: 15px; color: #059669;"/>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label><i class="fa fa-exclamation-circle text-danger"></i> Current Due (₹)</label>
                                    <input type="text" name="sale_total_current_due" readonly="readonly" value="<?= $curr_due; ?>" class="form-control input-sm text-center" style="background: #f8fafc; font-weight: 700; color: #dc2626;"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fa fa-sticky-note-o text-muted"></i> Payment / Sale Note</label>
                            <textarea name="sale_note" class="form-control input-sm" rows="3" placeholder="Optional notes..."><?= $sale_note; ?></textarea>
                        </div>

                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                            <button type="submit" class="btn btn-primary btn-flat" style="font-size: 14px; font-weight: 600; padding: 8px 20px;">
                                <i class="fa fa-save"></i> Save / Update Sale
                            </button>
                            <a href="<?= console_url('sale'); ?>" class="btn btn-default btn-flat" style="font-size: 14px; padding: 8px 18px; margin-left: 8px;">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Bill Summary Calculation Card -->
            <div class="col-md-5">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-calculator text-success"></i> Bill Summary</h3>
                    </div>
                    <div class="box-body" style="padding: 15px;">
                        <div class="sale-summary-card">
                            <div class="summary-row">
                                <span class="summary-label">Total Items</span>
                                <span class="summary-val totalItem">0</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">MRP Total</span>
                                <span class="summary-val mrptotal">0.00</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Discount Total</span>
                                <span class="summary-val discounttotal" style="color: #ea580c;">0.00</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">CGST Total</span>
                                <span class="summary-val totalCgst">0.00</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">SGST Total</span>
                                <span class="summary-val totalSgst">0.00</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Total GST</span>
                                <span class="summary-val totalgst">0.00</span>
                            </div>
                            <div class="summary-row" style="border-top: 2px solid #cbd5e1; margin-top: 5px; padding-top: 10px;">
                                <span class="summary-label" style="font-size: 14px; font-weight: 700; color: #1e293b;">Grand Total</span>
                                <span class="summary-val highlight-green totalAmount">0.00</span>
                            </div>
                            <div class="summary-row" style="background: #e0f2fe; margin: 8px -15px -15px -15px; padding: 12px 15px; border-radius: 0 0 6px 6px; border-bottom: none;">
                                <span class="summary-label" style="font-size: 15px; font-weight: 700; color: #0369a1;">Net Payable</span>
                                <span class="summary-val highlight-blue customer_payable">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var rowcount = <?= $has_data ? count($data) : 0 ?>;

    function addmore() {
        rowcount++;
        var therow = '<tr class="rowline">' +
            '<td><span>' + rowcount + '</span><br/>' +
            '<a href="javascript:void(0)" onclick="removeRow(this);" title="Remove row" style="color:#ef4444; margin-top:2px; display:inline-block;">' +
            '<i class="fa fa-minus-circle fa-lg"></i></a></td>' +
            '<td><input required="required" type="hidden" name="medicine_id[]">' +
            '<input required="required" type="text" name="medicine_name[]" placeholder="Medicine name" class="form-control input-sm" style="width:100%; margin-bottom:2px;">' +
            '<div style="font-size:10px; color:#64748b; text-align:left;">Storage: ' +
            '<input readonly="readonly" type="text" name="medicine_storage[]" style="width:65px; height:20px; font-size:10px; border:1px solid #e2e8f0; background:#f8fafc; border-radius:2px;"></div></td>' +
            '<td><input required="required" readonly="readonly" type="text" name="medicine_hsn[]" style="width:48px; background:#f8fafc;"></td>' +
            '<td><input required="required" type="text" name="sale_strip_quantity[]" value="1" onkeyup="calculate_the_sale(this)" style="width:38px;"></td>' +
            '<td><input required="required" type="text" name="sale_loose_quantity[]" onkeyup="calculate_the_sale(this)" value="0" style="width:38px;"></td>' +
            '<td><input required="required" type="text" name="medicine_unit[]" onkeyup="calculate_the_sale(this)" style="width:38px;"></td>' +
            '<td><input type="text" onchange="calculate_the_sale(this)" name="sale_batch[]" style="width:90px;" placeholder="Batch"></td>' +
            '<td><div style="display:flex; justify-content:center; align-items:center;">' +
            '<input required="required" type="text" name="sale_expire_month[]" max="31" min="1" maxlength="2" onfocusout="focusvalidation(this)" placeholder="MM" style="width:24px; padding:0; text-align:center;">' +
            '<span style="padding:0 2px;">/</span>' +
            '<input required="required" type="text" name="sale_expire_year[]" onfocusout="focusvalidation(this)" min="17" maxlength="2" placeholder="YY" style="width:24px; padding:0; text-align:center;">' +
            '</div></td>' +
            '<td><input required="required" type="text" name="sale_mrp[]" onkeyup="calculate_the_sale(this)" value="0.00" style="width:58px;"></td>' +
            '<td><input required="required" type="text" readonly="readonly" name="sale_rate[]" onkeyup="calculate_the_sale(this)" value="0.00" style="width:58px; background:#f8fafc;"></td>' +
            '<td><input required="required" type="text" name="sale_discount_percent[]" onkeyup="calculate_the_sale(this)" value="0" style="width:34px;"></td>' +
            '<td><input required="required" type="text" readonly="readonly" name="sale_taxable[]" style="width:58px; background:#f8fafc;"></td>' +
            '<td><input required="required" type="text" name="sale_cgst_percent[]" value="0" onkeyup="calculate_the_sale(this)" style="width:34px;"></td>' +
            '<td><input required="required" type="text" readonly="readonly" name="sale_cgst[]" style="width:58px; background:#f8fafc;"></td>' +
            '<td><input required="required" type="text" name="sale_sgst_percent[]" value="0" onkeyup="calculate_the_sale(this)" style="width:34px;"></td>' +
            '<td><input required="required" type="text" readonly="readonly" name="sale_sgst[]" style="width:58px; background:#f8fafc;"></td>' +
            '<td><input required="required" type="text" readonly="readonly" name="sale_total[]" style="width:65px; font-weight:700; color:#059669; background:#f8fafc;"></td>' +
            '</tr>';
        $('.appendHere').append(therow);

        <?php if (isset($this->page_config['autocomplete'])): ?>
            var autoComplete = $.parseJSON('<?= json_encode($this->page_config['autocomplete']); ?>');
            $.each(autoComplete, function (targetField, value) {
                $.each(value, function (model, fieldToSearch) {
                    $('.rowline').find('[name^="' + targetField + '[]"]').autocomplete({
                        source: '<?= base_url("search.php"); ?>?location=sale&table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1,
                        select: function (event, ui) {
                            var targetRow = $(this).parents('tr');
                            $.each(ui.item.complete, function (populate_field, populate_value) {
                                $(targetRow).find('[name^="' + populate_field + '[]"]').val('');

                                if (populate_field == 'medicine_name') {
                                    $.get('<?= base_url("batch.php"); ?>?medicine_id=' + ui.item.complete.medicine_id, function (resp) {
                                        var batchchooser = $('<datalist id="list_' + ui.item.complete.medicine_id + '"></datalist>');
                                        $.each(resp, function (k, v) {
                                            $(batchchooser).append($('<option value="' + v.value + '">' + v.label + '</option>'));
                                        });
                                        $(targetRow).find('[name^="sale_batch[]"]').removeAttr('list');
                                        $(targetRow).find('[name^="sale_batch[]"]').val('');
                                        $(targetRow).find('[name^="sale_batch[]"]').parent().find('datalist').remove();
                                        $(targetRow).find('[name^="sale_batch[]"]').parent().append(batchchooser);
                                        $(targetRow).find('[name^="sale_batch[]"]').attr('list', 'list_' + ui.item.complete.medicine_id);
                                    }, 'json');
                                }
                                $(targetRow).find('[name^="' + populate_field + '[]"]').val(populate_value);
                            });

                            $(targetRow).find('[name^="sale_batch[]"]').change(function () {
                                var row = $(this).parents('tr');
                                $.post('<?= base_url("batch.php"); ?>?medicine_id=' + $(row).find('[name^="medicine_id[]"]').val() + '&term=' + $(this).val(), function (resp) {
                                    if (resp && resp[0] && resp[0].complete) {
                                        $.each(resp[0].complete, function (populate_fieldx, populate_valuex) {
                                            $(row).find('[name^="' + populate_fieldx + '[]"]').val(populate_valuex);
                                            calculate_the_sale($(row).find('[name^="sale_mrp[]"]'));
                                            $(row).find('[name^="sale_discount_percent[]"]').focus().select();
                                        });
                                    }
                                }, 'json');
                            });

                            $(targetRow).find('[name^="sale_discount_percent[]"]').keydown(function (e) {
                                var keyCode = e.keyCode || e.which;
                                if (keyCode == 9 && !e.shiftKey) {
                                    e.preventDefault();
                                    $('.addm').first().click();
                                }
                            });
                        }
                    });
                });
            });
        <?php endif; ?>

        $('.appendHere tr:last [name^="medicine_name[]"]').focus();
    }

    function removeRow(targetObj) {
        $(targetObj).parents('.rowline').remove();
        calculateTotal();
        disp_calc();
    }

    function currentdue() {
        var paid = parseFloat($('[name="sale_total_paid"]').val()) || 0;
        var payable = parseFloat($('.customer_payable').html()) || 0;
        $('[name="sale_total_current_due"]').val(Math.round(payable - paid));
    }

    function calculateTotal() {
        var totalItem = $('.rowline').length;
        var totalCgst = 0;
        var totalSgst = 0;
        var totalTotal = 0;
        $('.rowline').each(function () {
            totalCgst += parseFloat($(this).find('[name="sale_cgst[]"]').val()) || 0;
            totalSgst += parseFloat($(this).find('[name="sale_sgst[]"]').val()) || 0;
            totalTotal += parseFloat($(this).find('[name="sale_total[]"]').val()) || 0;
        });
        var previousDue = parseFloat($('[name="sale_total_previous_due"]').val()) || 0;

        $('.totalItem').html(totalItem);
        $('.totalCgst').html(totalCgst.toFixed(2));
        $('.totalSgst').html(totalSgst.toFixed(2));
        $('.totalgst').html((totalSgst + totalCgst).toFixed(2));
        $('.totalAmount').html(totalTotal.toFixed(2));
        var netPayable = Math.round(previousDue + totalTotal);
        $('.customer_payable').html(netPayable);
        currentdue();
    }

    function calculate_the_sale(targetObject) {
        var tr = $(targetObject).parents('tr');
        var cgst = parseFloat(tr.find('[name="sale_cgst_percent[]"]').val()) || 0;
        var mrp = parseFloat(tr.find('[name="sale_mrp[]"]').val()) || 0;
        var unit = parseFloat(tr.find('[name="medicine_unit[]"]').val()) || 1;
        var rate = mrp2rate(mrp, cgst);
        tr.find('[name="sale_rate[]"]').val(rate.toFixed(3));
        tr.find('[name^="sale_sgst_percent[]"]').val(cgst);
        var sgst = cgst;

        var sale_strip_quantity = parseFloat(tr.find('[name^="sale_strip_quantity[]"]').val()) || 0;
        var sale_loose_quantity = parseFloat(tr.find('[name^="sale_loose_quantity[]"]').val()) || 0;
        var qty = (sale_strip_quantity * unit) + sale_loose_quantity;
        var discount_percent = parseFloat(tr.find('[name^="sale_discount_percent[]"]').val()) || 0;

        var total = (rate * qty / unit);
        var total_discount = (total * discount_percent / 100);
        var taxable_cost = (total - total_discount);
        var total_cgst = (taxable_cost * cgst / 100);
        var total_sgst = (taxable_cost * sgst / 100);
        var grandtotal = total_sgst + total_cgst + taxable_cost;

        tr.find('[name^="sale_taxable[]"]').val(taxable_cost.toFixed(2));
        tr.find('[name^="sale_cgst[]"]').val(total_cgst.toFixed(2));
        tr.find('[name^="sale_sgst[]"]').val(total_sgst.toFixed(2));
        tr.find('[name^="sale_total[]"]').val(grandtotal.toFixed(2));

        calculateTotal();
        disp_calc();
    }

    function mrp2rate(mrp, cgst) {
        return mrp * 50 / (50 + cgst);
    }

    function focusvalidation(obg) {
        if ($(obg).val() > 31) {
            alert('Value is more than 31');
            $(obg).val('');
            $(obg).focus();
            return false;
        }
    }

    function disp_calc() {
        var total_mrp = 0;
        var total = 0;
        $('.rowline').each(function () {
            total_mrp += parseFloat($(this).find('[name="sale_mrp[]"]').val()) || 0;
            total += parseFloat($(this).find('[name="sale_total[]"]').val()) || 0;
        });
        var final_disc = (total_mrp - total);
        $('td.discounttotal, .discounttotal').html(final_disc.toFixed(2));
        $('td.mrptotal, .mrptotal').html(total_mrp.toFixed(2));
    }

    function fullCalculation() {
        $('.rowline').each(function () {
            var cgst = parseFloat($(this).find('[name="sale_cgst_percent[]"]').val()) || 0;
            var mrp = parseFloat($(this).find('[name="sale_mrp[]"]').val()) || 0;
            var unit = parseFloat($(this).find('[name="medicine_unit[]"]').val()) || 1;
            var rate = mrp2rate(mrp, cgst);
            $(this).find('[name="sale_rate[]"]').val(rate.toFixed(3));
            $(this).find('[name^="sale_sgst_percent[]"]').val(cgst);
            var sgst = cgst;

            var sale_strip_quantity = parseFloat($(this).find('[name^="sale_strip_quantity[]"]').val()) || 0;
            var sale_loose_quantity = parseFloat($(this).find('[name^="sale_loose_quantity[]"]').val()) || 0;
            var qty = (sale_strip_quantity * unit) + sale_loose_quantity;
            var discount_percent = parseFloat($(this).find('[name^="sale_discount_percent[]"]').val()) || 0;

            var total = (rate * qty / unit);
            var total_discount = (total * discount_percent / 100);
            var taxable_cost = (total - total_discount);
            var total_cgst = (taxable_cost * cgst / 100);
            var total_sgst = (taxable_cost * sgst / 100);
            var grandtotal = total_sgst + total_cgst + taxable_cost;

            $(this).find('[name^="sale_taxable[]"]').val(taxable_cost.toFixed(2));
            $(this).find('[name^="sale_cgst[]"]').val(total_cgst.toFixed(2));
            $(this).find('[name^="sale_sgst[]"]').val(total_sgst.toFixed(2));
            $(this).find('[name^="sale_total[]"]').val(grandtotal.toFixed(2));
        });

        calculateTotal();
        disp_calc();
        currentdue();
    }

    $(document).ready(function () {
        setTimeout(function () {
            $('.alert-success').fadeOut();
        }, 3000);

        if ($.fn.datepicker) {
            $("[name='sale_date']").datepicker({
                dateFormat: 'dd-M-yy',
                changeMonth: true,
                changeYear: true
            });
        }

        <?php if (isset($this->page_config['autocomplete'])): ?>
            var autoCompleteTop = $.parseJSON('<?= json_encode($this->page_config['autocomplete']); ?>');
            $.each(autoCompleteTop, function (targetField, value) {
                $.each(value, function (model, fieldToSearch) {
                    $('[name="' + targetField + '"]').autocomplete({
                        source: '<?= base_url("search.php"); ?>?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1,
                        select: function (event, ui) {
                            $.each(ui.item.complete, function (populate_field, populate_value) {
                                $('[name="' + populate_field + '"]').val(populate_value);
                                calculateTotal();
                            });
                        }
                    });
                });
            });
        <?php endif; ?>

        fullCalculation();
    });
</script>