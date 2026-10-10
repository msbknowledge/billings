<style>
    .purchase-edit-wrapper .box {
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .purchase-edit-wrapper .panel-header-custom {
        background: #f8fafc;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 15px;
        font-weight: 600;
        color: #334155;
    }
    .purchase-edit-wrapper .table-custom-items th {
        background: #2c3b4c;
        color: #ffffff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle !important;
        text-align: center;
        padding: 8px 4px;
        white-space: nowrap;
    }
    .purchase-edit-wrapper .table-custom-items td {
        vertical-align: middle !important;
        padding: 4px !important;
        text-align: center;
    }
    .purchase-edit-wrapper .table-custom-items input,
    .purchase-edit-wrapper .table-custom-items select {
        font-size: 11px;
        height: 28px;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
        text-align: center;
        min-width: 40px;
    }
    .purchase-edit-wrapper .table-custom-items input:focus {
        border-color: #3c8dbc;
        outline: none;
        box-shadow: 0 0 3px rgba(60, 141, 188, 0.4);
    }
    .purchase-summary-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        padding: 15px;
        margin-top: 15px;
    }
    .purchase-summary-box .stat-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        font-weight: 600;
    }
    .purchase-summary-box .stat-value {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .purchase-summary-box .stat-value.grand-total {
        font-size: 20px;
        color: #059669;
    }
    #history {
        position: fixed;
        width: 90%;
        max-width: 900px;
        top: 60px;
        right: 5%;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        font-size: 12px;
        z-index: 9999;
        display: none;
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
    }
    .ui-autocomplete-loading {
        background: white url('data:image/gif;base64,R0lGODlhEAAQAPMPALu7u5mZmTMzM93d3REREQAAAHd3d1VVVWZmZqqqqoiIiO7u7kRERCIiIgARAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBwAPACwAAAAAEAAQAEAEcPDJtyg6dUrFetDTIopMoSyFcxxD1krD8AwCkASDIlPaUDQLR6G1Cy0SgqIkE1IQGMrFAKCcGWSBzwPAnAwarcKQ15MpTMJYd1ZyUDXSDGelBY0qIoBh/ZoYGgELCjoxCRRvIQcGD1kzgSAgAACQDxEAIfkEBQcADwAsAAAAAA8AEAAABF3wyfkMkotOJpscRKJJwtI4Q1MAoxQ0RFBw0xEvhGAVRZZJh4JgMAEQW7TWI4EwGFjKR+CAQECjn8DoN0kwDtvBT8FILAKJgfoo1iAGAPNVY9DGJXNMIHN/HJVqIxEAIfkEBQcADwAsAAAAABAADwAABFrwyfmColgiydpaQiY5x9Ith7hURdIl0wBIhpCAjKIIxaAUPQ0hFQsAC7MJALFSFi4SgC4wyHyuCYNWxH3AuhSEotkNGAALAPqqkigG8MWAjAnM4A8594vPUyIAIfkEBQcADwAsAAAAABAAEAAABF3wySkDvdKsddg+APYIWrcg2DIRQAcU6DJICjIsjBEETLEEBYLqYSDdJoCGiHgZwG4LQCCRECEIBAdoF5hdEIWwgBJqDs7DgcKyRHZl3uUwuhm2AbNNW+LV7yd+FxEAIfkEBQcACAAsAAAAABAADgAABEYQyYmMoVgeWQrP3NYhBCgZBdAFRUkdBIAUguVVo1ZsWFcEGB5GMBkEjiCBL2a5ZAi+m2SAURExwKqPiuCafBkvBSCcmiYRACH5BAUHAA4ALAAAAAAQABAAAARs0MnpAKDYrbSWMp0xZIvBKYrXjNmADOhAKBiQDF5gGcICNAyJTwFYTBaDQ0HAkgwSmAUj0OkMrkZM4HBgKK7YTKDRICAo2clAEIheKc9CISjEVTuEQrJASGcSBQcSUFEUDQUXJBgDBW0Zj34RACH5BAUHAA8ALAAAAAAQABAAAARf8Mn5xqBYgrVC4EEmBcOSfAEjSopJMglmcQlgBYjE5NJgZwjCAbO4YBAJjpIjSiAQh5ayyRAIDKvJIbnIagoFRFdkQDQKC0RBsCIUFAWsT7RwG410R8HiiK0WBwJjFBEAIfkEBQcADgAsAQABAA8ADwAABFrQybEWADXJLUHHAMJxIDAgnrOo2+AOibEMh1LN62gIxphzitRoCDAYNcNN6FBLShao4WzwHDQKvVGhoFAwGgtFgQHENhoB7nCwHRAIC0EyUcC8Zw1ha3NIRgAAIfkEBQcADwAsAAAAABAAEAAABGDwyfnWoljaNYYFV+Zx3hCEGEcuypBtMJBISpClAWLfWODymIFiCJwMDMiZBNAAYFqUAaNQ2E0YBIXGURAMCo1AAsFYBBoIScBJEwgSVcmP0li4FwcHz+FpCCQMPCFINxEAIfkEBQcADgAsAAABABAADwAABFzQyemWXYNqaSXY2vVtw3UNmROM4JQowKKlFOsgRI6ASQ8IhSADFAjAMIMAgSYJtByxyQIhcEoaBcSiwegpDgvAwSBJ0AIHBoCQqIAEi/TCIAABGhLG8MbcKBQgEQAh+QQFBwAPACwAAAEAEAAPAAAEXfDJSd+qeK5RB8fDRRWFspyotAAfQBbfNLCVUSSdKDV89gDAwcFBIBgywMRnkWBgcJUDKSZRIKAPQcGwYByAAYTEEJAAJIGbATEQ+B4ExmK9CDhBd8ThdHw/AmUYEQAh+QQFBwAPACwAAAEADwAPAAAEXvBJQIa8+ILSspdHkXxS9wxF4Q3L2aTBeC0sFjhAtuyLIjAMhYc2GBgaSKGuyNoBDp7czFAgeBIKwC6kWCAMxUSAFjtNCAAFGGF5tCQLAaJnWCTqHoREvQuQJAkyGBEAOw==') right center no-repeat;
    }
</style>

<div class="purchase-edit-wrapper">
    <?php if (isset($status)): ?>
        <div class="alert alert-<?= $status ?> alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> <?= $message ?>
        </div>
    <?php endif; ?>

    <div id="history"></div>

    <form method="post" action="" onmouseover="hide_history()" enctype="multipart/form-data" id="purchaseEditForm">
        <!-- Main Card -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-pencil-square-o text-primary"></i> Edit Purchase Entry #<?= isset($data[0]['purchase_entry_number']) ? htmlspecialchars($data[0]['purchase_entry_number']) : '' ?>
                </h3>
                <div class="box-tools pull-right">
                    <a href="<?= console_url('purchase'); ?>" class="btn btn-default btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to Purchases
                    </a>
                </div>
            </div>

            <div class="box-body" style="padding: 20px;">
                <!-- Supplier & Invoice Details Grid -->
                <div class="row">
                    <!-- Supplier Column -->
                    <div class="col-md-6">
                        <div class="box box-solid box-default" style="border: 1px solid #e2e8f0; margin-bottom: 15px;">
                            <div class="panel-header-custom">
                                <i class="fa fa-user text-primary"></i> Supplier Information
                            </div>
                            <div class="box-body" style="padding: 15px;">
                                <div class="form-group">
                                    <label>Supplier Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                                        <input required="required" type="text" autocomplete="off" name="supplier_name" value="<?= isset($data[0]['supplier_name']) ? htmlspecialchars($data[0]['supplier_name']) : '' ?>" class="form-control input-sm" placeholder="Supplier Name"/>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>GSTIN</label>
                                            <input type="text" autocomplete="off" name="supplier_gst" value="<?= isset($data[0]['supplier_gst']) ? htmlspecialchars($data[0]['supplier_gst']) : '' ?>" class="form-control input-sm" placeholder="Supplier GSTIN"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Contact Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                <input required="required" type="text" autocomplete="off" name="supplier_contact" value="<?= isset($data[0]['supplier_contact']) ? htmlspecialchars($data[0]['supplier_contact']) : '' ?>" class="form-control input-sm" placeholder="Mobile / Phone"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <input required="required" type="text" autocomplete="off" name="supplier_address" value="<?= isset($data[0]['supplier_address']) ? htmlspecialchars($data[0]['supplier_address']) : '' ?>" class="form-control input-sm" placeholder="Supplier Address"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Column -->
                    <div class="col-md-6">
                        <div class="box box-solid box-default" style="border: 1px solid #e2e8f0; margin-bottom: 15px;">
                            <div class="panel-header-custom">
                                <i class="fa fa-file-text-o text-primary"></i> Invoice & Entry Details
                            </div>
                            <div class="box-body" style="padding: 15px;">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Invoice Number <span class="text-danger">*</span></label>
                                            <input required="required" type="text" autocomplete="off" name="purchase_invoice" value="<?= isset($data[0]['purchase_invoice']) ? htmlspecialchars($data[0]['purchase_invoice']) : '' ?>" class="form-control input-sm" placeholder="Invoice Number"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Purchase Date <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" required="required" autocomplete="off" name="purchase_date" class="form-control input-sm" value="<?= isset($data[0]['purchase_date']) ? date('d-M-Y', strtotime($data[0]['purchase_date'])) : date('d-M-Y') ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label>Entry Number (Readonly)</label>
                                    <input required="required" readonly="readonly" value="<?= isset($data[0]['purchase_entry_number']) ? htmlspecialchars($data[0]['purchase_entry_number']) : '' ?>" type="text" name="purchase_entry_number" class="form-control input-sm" style="background: #f1f5f9; font-weight: bold;"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchased Items Section -->
                <div class="box box-solid box-default" style="border: 1px solid #e2e8f0; margin-top: 10px;" onmouseover="hide_history()">
                    <div class="panel-header-custom clearfix">
                        <div class="pull-left">
                            <i class="fa fa-cubes text-primary"></i> Purchased Items
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-success btn-xs" onclick="addmore()" onmouseover="hide_history()">
                                <i class="fa fa-plus"></i> Add Item Row
                            </button>
                        </div>
                    </div>

                    <div class="box-body no-padding">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-striped table-condensed table-custom-items">
                                <thead>
                                    <tr>
                                        <th style="width: 45px;">Sr</th>
                                        <th style="min-width: 170px;">Product Name</th>
                                        <th style="width: 65px;">HSN</th>
                                        <th style="width: 55px;">Storage</th>
                                        <th style="width: 60px;">Category</th>
                                        <th style="width: 55px;">Sched</th>
                                        <th style="width: 70px;">Mfg</th>
                                        <th style="width: 55px;">Qty</th>
                                        <th style="width: 50px;">Free</th>
                                        <th style="width: 50px;">Unit</th>
                                        <th style="width: 75px;">Batch</th>
                                        <th style="width: 75px;">Exp<br/>(MM/YY)</th>
                                        <th style="width: 60px;">MRP</th>
                                        <th style="width: 65px;">Rate</th>
                                        <th style="width: 50px;">Disc%</th>
                                        <th style="width: 55px;">Bonus%</th>
                                        <th style="width: 65px;">Taxable</th>
                                        <th style="width: 45px;">CGST%</th>
                                        <th style="width: 60px;">CGST</th>
                                        <th style="width: 45px;">SGST%</th>
                                        <th style="width: 60px;">SGST</th>
                                        <th style="width: 75px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="appendHere">
                                    <?php if (!empty($data)): ?>
                                        <?php foreach ($data as $k => $value): ?>
                                            <tr class="rowline" onkeyup="get_history(this)" onfocus="get_history(this)" onclick="get_history(this)" onmouseout="hide_history()">
                                                <td>
                                                    <span><?= $k + 1 ?></span><br/>
                                                    <a href="javascript:void(0)" class="text-danger" onclick="removeRow(this);" title="Remove Row"><i class="fa fa-trash"></i></a>
                                                </td>
                                                <td><input required="required" type="text" name="medicine_name[]" value="<?= htmlspecialchars($value['medicine_name'] ?? '') ?>" style="width:100%; min-width: 150px; text-align: left;" placeholder="Medicine Name"></td>
                                                <td><input required="required" type="text" name="medicine_hsn[]" value="<?= htmlspecialchars($value['medicine_hsn'] ?? '') ?>" style="width:100%;"></td>
                                                <td><input required="required" type="text" name="medicine_storage[]" value="<?= htmlspecialchars($value['medicine_storage'] ?? '') ?>" style="width:100%;"></td>
                                                <td><input type="text" name="medicine_category[]" value="<?= htmlspecialchars($value['medicine_category'] ?? '') ?>" style="width:100%;"></td>
                                                <td><input type="text" name="medicine_schedule[]" value="<?= htmlspecialchars($value['medicine_schedule'] ?? '') ?>" style="width:100%;"></td>
                                                <td><input required="required" type="text" name="medicine_manufacturer[]" value="<?= htmlspecialchars($value['medicine_manufacturer'] ?? '') ?>" style="width:100%; text-align: left;"></td>
                                                <td><input required="required" type="number" step="0.01" name="purchase_quantity[]" value="<?= htmlspecialchars($value['purchase_quantity'] ?? '1') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" type="number" step="0.01" name="purchase_free_quantity[]" value="<?= htmlspecialchars($value['purchase_free_quantity'] ?? '0') ?>" style="width:100%;"></td>
                                                <td><input required="required" type="number" name="purchase_unit[]" value="<?= htmlspecialchars($value['purchase_unit'] ?? '1') ?>" style="width:100%;"></td>
                                                <td><input required="required" type="text" name="purchase_batch[]" value="<?= htmlspecialchars($value['purchase_batch'] ?? '') ?>" pattern="^\S+$" style="width:100%;"></td>
                                                <td>
                                                    <div style="display:flex; align-items:center; justify-content:center;">
                                                        <input required="required" type="text" name="purchase_expire_month[]" value="<?= htmlspecialchars($value['purchase_expire_month'] ?? '') ?>" maxlength="2" pattern="^[0-9]+$" style="width:24px; padding:2px;" placeholder="MM">
                                                        <span style="margin: 0 2px;">/</span>
                                                        <input required="required" type="text" name="purchase_expire_year[]" value="<?= htmlspecialchars($value['purchase_expire_year'] ?? '') ?>" maxlength="4" pattern="^[0-9]+$" style="width:24px; padding:2px;" placeholder="YY">
                                                    </div>
                                                </td>
                                                <td><input required="required" type="text" name="purchase_mrp[]" value="<?= htmlspecialchars($value['purchase_mrp'] ?? '0.00') ?>" style="width:100%;"></td>
                                                <td><input required="required" type="text" name="purchase_rate[]" value="<?= htmlspecialchars($value['purchase_rate'] ?? '0.00') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" type="text" name="purchase_discount_percent[]" value="<?= htmlspecialchars($value['purchase_discount_percent'] ?? '0') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" type="number" step="0.01" name="purchase_bonus[]" value="<?= htmlspecialchars($value['purchase_bonus'] ?? '0.00') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" readonly="readonly" type="text" name="purchase_taxable[]" value="<?= htmlspecialchars($value['purchase_taxable'] ?? '0.00') ?>" style="width:100%; background:#f8fafc;"></td>
                                                <td><input required="required" type="text" name="purchase_cgst_percent[]" value="<?= htmlspecialchars($value['purchase_cgst_percent'] ?? '0') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" readonly="readonly" type="text" name="purchase_cgst[]" value="<?= htmlspecialchars($value['purchase_cgst'] ?? '0.00') ?>" style="width:100%; background:#f8fafc;"></td>
                                                <td><input required="required" readonly="readonly" type="text" name="purchase_sgst_percent[]" value="<?= htmlspecialchars($value['purchase_sgst_percent'] ?? '0') ?>" onkeyup="gst_calculation(this)" style="width:100%;"></td>
                                                <td><input required="required" readonly="readonly" type="text" name="purchase_sgst[]" value="<?= htmlspecialchars($value['purchase_sgst'] ?? '0.00') ?>" style="width:100%; background:#f8fafc;"></td>
                                                <td><input required="required" readonly="readonly" type="text" name="purchase_total[]" value="<?= htmlspecialchars($value['purchase_total'] ?? '0.00') ?>" style="width:100%; background:#f8fafc; font-weight:bold;"></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer clearfix" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 10px 15px;">
                        <button type="button" class="btn btn-primary btn-sm pull-left" onclick="addmore()" onmouseover="hide_history()">
                            <i class="fa fa-plus-circle"></i> Add More Medicine Row
                        </button>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="purchase-summary-box" onmouseover="hide_history()">
                    <div class="row text-center">
                        <div class="col-xs-6 col-sm-2" style="border-right: 1px solid #e2e8f0;">
                            <div class="stat-label">Total Items</div>
                            <div class="stat-value totalItem">0</div>
                        </div>
                        <div class="col-xs-6 col-sm-2" style="border-right: 1px solid #e2e8f0;">
                            <div class="stat-label">Total CGST</div>
                            <div class="stat-value totalCgst">0.00</div>
                        </div>
                        <div class="col-xs-6 col-sm-2" style="border-right: 1px solid #e2e8f0;">
                            <div class="stat-label">Total SGST</div>
                            <div class="stat-value totalSgst">0.00</div>
                        </div>
                        <div class="col-xs-6 col-sm-3" style="border-right: 1px solid #e2e8f0;">
                            <div class="stat-label">Total GST Amount</div>
                            <div class="stat-value totalgst">0.00</div>
                        </div>
                        <div class="col-xs-12 col-sm-3">
                            <div class="stat-label">Grand Total</div>
                            <div class="stat-value grand-total totalAmount">0.00</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box Footer Actions -->
            <div class="box-footer clearfix" style="padding: 15px 20px; background: #ffffff; border-top: 1px solid #e9ecef;" onmouseover="hide_history()">
                <div class="pull-left">
                    <a href="<?= console_url('purchase'); ?>" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Cancel
                    </a>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary btn-md">
                        <i class="fa fa-check"></i> Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    var rowcount = <?= !empty($data) ? count($data) : 0 ?>;

    function addmore() {
        rowcount++;
        var therow = " <tr class=\"rowline\" onkeyup=\"get_history(this)\" onfocus=\"get_history(this)\" onclick=\"get_history(this)\" onmouseout=\"hide_history()\">\r\n" +
            "<td><span>" + rowcount + "</span><br/><a href=\"javascript:void(0)\" class=\"text-danger\" onclick=\"removeRow(this);\" title=\"Remove Row\"><i class=\"fa fa-trash\"></i></a></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"medicine_name[]\" style=\"width:100%; min-width: 150px; text-align: left;\" placeholder=\"Medicine Name\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"medicine_hsn[]\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"medicine_storage[]\" style=\"width:100%;\"></td>\r\n" +
            "<td><input type=\"text\" name=\"medicine_category[]\" style=\"width:100%;\"></td>\r\n" +
            "<td><input type=\"text\" name=\"medicine_schedule[]\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"medicine_manufacturer[]\" style=\"width:100%; text-align: left;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"number\" step=\"0.01\" name=\"purchase_quantity[]\" onkeyup=\"gst_calculation(this)\" value=\"1\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"number\" step=\"0.01\" name=\"purchase_free_quantity[]\" value=\"0\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"number\" name=\"purchase_unit[]\" value=\"1\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"purchase_batch[]\" pattern=\"^\\S+$\" style=\"width:100%;\"></td>\r\n" +
            "<td><div style=\"display:flex; align-items:center; justify-content:center;\">" +
                "<input required=\"required\" type=\"text\" name=\"purchase_expire_month[]\" max=\"31\" min=\"1\" maxlength=\"2\" pattern=\"^[0-9]+$\" style=\"width:24px; padding:2px;\" placeholder=\"MM\">" +
                "<span style=\"margin: 0 2px;\">/</span>" +
                "<input required=\"required\" type=\"text\" name=\"purchase_expire_year[]\" pattern=\"^[0-9]+$\" style=\"width:24px; padding:2px;\" placeholder=\"YY\">" +
            "</div></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"purchase_mrp[]\" value=\"0.00\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"purchase_rate[]\" onkeyup=\"gst_calculation(this)\" value=\"0.00\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"purchase_discount_percent[]\" onkeyup=\"gst_calculation(this)\" value=\"0\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"number\" step=\"0.01\" name=\"purchase_bonus[]\" onkeyup=\"gst_calculation(this)\" value=\"0.00\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" readonly=\"readonly\" type=\"text\" name=\"purchase_taxable[]\" style=\"width:100%; background:#f8fafc;\"></td>\r\n" +
            "<td><input required=\"required\" type=\"text\" name=\"purchase_cgst_percent[]\" value=\"0\" onkeyup=\"gst_calculation(this)\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" readonly=\"readonly\" type=\"text\" name=\"purchase_cgst[]\" style=\"width:100%; background:#f8fafc;\"></td>\r\n" +
            "<td><input required=\"required\" readonly=\"readonly\" type=\"text\" name=\"purchase_sgst_percent[]\" value=\"0\" onkeyup=\"gst_calculation(this)\" style=\"width:100%;\"></td>\r\n" +
            "<td><input required=\"required\" readonly=\"readonly\" type=\"text\" name=\"purchase_sgst[]\" style=\"width:100%; background:#f8fafc;\"></td>\r\n" +
            "<td><input required=\"required\" readonly=\"readonly\" type=\"text\" name=\"purchase_total[]\" style=\"width:100%; background:#f8fafc; font-weight:bold;\"></td>\r\n" +
            "</tr>";
        $('.appendHere').append(therow);

        <?php if (isset($this->page_config['autocomplete'])): ?>
            var autoComplete = $.parseJSON('<?= json_encode($this->page_config['autocomplete']); ?>');
            $.each(autoComplete, function (targetField, value) {
                $.each(value, function (model, fieldToSearch) {
                    $('.rowline:last').find('[name^="' + targetField + '[]"]').autocomplete({
                        source: baseurl + 'search.php?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1, select: function (event, ui) {
                            var targetRow = $(this).closest('tr');
                            $.each(ui.item.complete, function (populate_field, populate_value) {
                                $(targetRow).find('[name^="' + populate_field + '[]"]').val(populate_value);
                            });
                        }
                    });
                });
            });
        <?php endif; ?>

        $("[name^='purchase_total[]']").focus(function () {
            addmore();
        });
        $(".rowline:last").find('[name^="medicine_name[]"]').focus();
    }

    function removeRow(targetObj) {
        if ($('.rowline').length > 1) {
            $(targetObj).closest('.rowline').remove();
            calculateTotal();
            // Re-index row numbers
            $('.rowline').each(function (idx) {
                $(this).find('td:first span').text(idx + 1);
            });
            rowcount = $('.rowline').length;
        } else {
            alert("At least one item row is required.");
        }
    }

    function gst_calculation(targetObject) {
        var $row = $(targetObject).closest('tr');
        var cgst = parseFloat($row.find('[name^="purchase_cgst_percent[]"]').val()) || 0;
        $row.find('[name^="purchase_sgst_percent[]"]').val(cgst);
        var sgst = parseFloat($row.find('[name^="purchase_sgst_percent[]"]').val()) || 0;
        var rate = parseFloat($row.find('[name^="purchase_rate[]"]').val()) || 0;
        var qty = parseFloat($row.find('[name^="purchase_quantity[]"]').val()) || 0;
        var discount_percent = parseFloat($row.find('[name^="purchase_discount_percent[]"]').val()) || 0;
        var purchase_bonus = parseFloat($row.find('[name^="purchase_bonus[]"]').val()) || 0;
        var total = (rate * qty);
        var total_discount = (total * discount_percent / 100);
        var taxable_cost = (total - total_discount);
        var total_cgst = (taxable_cost * cgst / 100);
        var total_sgst = (taxable_cost * sgst / 100);
        var bonus_total = (total_sgst + total_cgst + taxable_cost) * (purchase_bonus / 100);
        var grandtotal = (total_sgst + total_cgst + taxable_cost) - bonus_total;

        $row.find('[name^="purchase_taxable[]"]').val(taxable_cost.toFixed(2));
        $row.find('[name^="purchase_cgst[]"]').val(total_cgst.toFixed(2));
        $row.find('[name^="purchase_sgst[]"]').val(total_sgst.toFixed(2));
        $row.find('[name^="purchase_total[]"]').val(grandtotal.toFixed(2));
        calculateTotal();
    }

    function calculateTotal() {
        var totalItem = $('.rowline').length;
        var totalCgst = 0;
        var totalSgst = 0;
        var totalTotal = 0;
        $('.rowline').each(function () {
            totalCgst += parseFloat($(this).find('[name^="purchase_cgst[]"]').val()) || 0;
            totalSgst += parseFloat($(this).find('[name^="purchase_sgst[]"]').val()) || 0;
            totalTotal += parseFloat($(this).find('[name^="purchase_total[]"]').val()) || 0;
        });
        $('.totalItem').html(totalItem);
        $('.totalCgst').html(totalCgst.toFixed(2));
        $('.totalSgst').html(totalSgst.toFixed(2));
        $('.totalgst').html((totalSgst + totalCgst).toFixed(2));
        $('.totalAmount').html(totalTotal.toFixed(2));
    }

    $(document).ready(function () {
        calculateTotal();
        setTimeout(function () {
            $('.alert').fadeOut();
        }, 3000);

        if ($.fn.datepicker) {
            $("[name='purchase_date']").datepicker({
                dateFormat: 'dd-M-yy',
                changeMonth: true,
                changeYear: true
            });
        }

        <?php if (isset($this->page_config['autocomplete'])): ?>
            var autoComplete = $.parseJSON('<?= json_encode($this->page_config['autocomplete']); ?>');
            $.each(autoComplete, function (targetField, value) {
                $.each(value, function (model, fieldToSearch) {
                    $('[name="' + targetField + '"]').autocomplete({
                        source: baseurl + 'search.php?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1, select: function (event, ui) {
                            $.each(ui.item.complete, function (populate_field, populate_value) {
                                $('[name="' + populate_field + '"]').val(populate_value);
                            });
                        }
                    });

                    $('.rowline').find('[name^="' + targetField + '[]"]').autocomplete({
                        source: baseurl + 'search.php?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1, select: function (event, ui) {
                            var targetRow = $(this).closest('tr');
                            $.each(ui.item.complete, function (populate_field, populate_value) {
                                $(targetRow).find('[name^="' + populate_field + '[]"]').val(populate_value);
                            });
                        }
                    });
                });
            });
        <?php endif; ?>

        $("[name^='purchase_total[]']").focus(function () {
            addmore();
        });
    });

    function get_history(targetObj) {
        var medName = $(targetObj).find('[name^="medicine_name[]"]').val();
        if (medName && medName.trim() !== '') {
            $.post(console_url + 'purchase/purchase_history', { medicine: medName }, function (resp) {
                $('#history').html(resp).show();
            });
        }
    }

    function hide_history() {
        $('#history').html('').hide();
    }
</script>