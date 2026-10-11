<style>
    .return-form-wrapper {
        font-family: inherit;
    }
    .return-form-wrapper .box {
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        background: #fff;
    }
    .return-form-wrapper .box-header {
        border-bottom: 1px solid #f4f4f4;
        padding: 12px 15px;
    }
    .return-form-wrapper .box-title {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        display: inline-block;
        color: #334155;
    }
    .return-form-wrapper .table-custom-items {
        margin-bottom: 0;
        width: 100%;
    }
    .return-form-wrapper .table-custom-items th {
        background: #2c3b4c;
        color: #ffffff;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        vertical-align: middle !important;
        text-align: center;
        padding: 9px 6px;
        white-space: nowrap;
        border: 1px solid #1e293b !important;
    }
    .return-form-wrapper .table-custom-items td {
        vertical-align: middle !important;
        padding: 6px !important;
        text-align: center;
        border: 1px solid #cbd5e1 !important;
        background: #ffffff;
    }
    .return-form-wrapper .table-custom-items input,
    .return-form-wrapper .table-custom-items select {
        font-size: 12px;
        height: 30px;
        border: 1px solid #cbd5e1;
        border-radius: 3px;
        text-align: center;
        padding: 3px 6px;
        box-sizing: border-box;
        width: 100%;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .return-form-wrapper .table-custom-items input:focus,
    .return-form-wrapper .table-custom-items select:focus {
        border-color: #3c8dbc;
        outline: none;
        box-shadow: 0 0 4px rgba(60, 141, 188, 0.4);
    }
    .return-summary-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 15px 20px;
    }
    .return-summary-card .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px dashed #cbd5e1;
        font-size: 14px;
    }
    .return-summary-card .summary-row:last-child {
        border-bottom: none;
        padding-top: 10px;
    }
    .return-summary-card .summary-label {
        color: #64748b;
        font-weight: 500;
    }
    .return-summary-card .summary-val {
        font-weight: 700;
        color: #1e293b;
    }
    .return-summary-card .summary-val.highlight-green {
        font-size: 20px;
        color: #059669;
    }
    .btn-remove-row {
        color: #ef4444;
        background: #fee2e2;
        border: 1px solid #fca5a5;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-remove-row:hover {
        background: #ef4444;
        color: #fff;
    }
    .ui-autocomplete-loading {
        background: white url('data:image/gif;base64,R0lGODlhEAAQAPMPALu7u5mZmTMzM93d3REREQAAAHd3d1VVVWZmZqqqqoiIiO7u7kRERCIiIgARAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFBwAPACwAAAAAEAAQAEAEcPDJtyg6dUrFetDTIopMoSyFcxxD1krD8AwCkASDIlPaUDQLR6G1Cy0SgqIkE1IQGMrFAKCcGWSBzwPAnAwarcKQ15MpTMJYd1ZyUDXSDGelBY0qIoBh/ZoYGgELCjoxCRRvIQcGD1kzgSAgAACQDxEAIfkEBQcADwAsAAAAAA8AEAAABF3wyfkMkotOJpscRKJJwtI4Q1MAoxQ0RFBw0xEvhGAVRZZJh4JgMAEQW7TWI4EwGFjKR+CAQECjn8DoN0kwDtvBT8FILAKJgfoo1iAGAPNVY9DGJXNMIHN/HJVqIxEAIfkEBQcADwAsAAAAABAADwAABFrwyfmColgiydpaQiY5x9Ith7hURdIl0wBIhpCAjKIIxaAUPQ0hFQsAC7MJALFSFi4SgC4wyHyuCYNWxH3AuhSEotkNGAALAPqqkigG8MWAjAnM4A8594vPUyIAIfkEBQcADwAsAAAAABAAEAAABF3wySkDvdKsddg+APYIWrcg2DIRQAcU6DJICjIsjBEETLEEBYLqYSDdJoCGiHgZwG4LQCCRECEIBAdoF5hdEIWwgBJqDs7DgcKyRHZl3uUwuhm2AbNNW+LV7yd+FxEAIfkEBQcACAAsAAAAABAADgAABEYQyYmMoVgeWQrP3NYhBCgZBdAFRUkdBIAUguVVo1ZsWFcEGB5GMBkEjiCBL2a5ZAi+m2SAURExwKqPiuCafBkvBSCcmiYRACH5BAUHAA4ALAAAAAAQABAAAARs0MnpAKDYrbSWMp0xZIvBKYrXjNmADOhAKBiQDF5gGcICNAyJTwFYTBaDQ0HAkgwSmAUj0OkMrkZM4HBgKK7YTKDRICAo2clAEIheKc9CISjEVTuEQrJASGcSBQcSUFEUDQUXJBgDBW0Zj34RACH5BAUHAA8ALAAAAAAQABAAAARf8Mn5xqBYgrVC4EEmBcOSfAEjSopJMglmcQlgBYjE5NJgZwjCAbO4YBAJjpIjSiAQh5ayyRAIDKvJIbnIagoFRFdkQDQKC0RBsCIUFAWsT7RwG410R8HiiK0WBwJjFBEAIfkEBQcADgAsAQABAA8ADwAABFrQybEWADXJLUHHAMJxIDAgnrOo2+AOibEMh1LN62gIxphzitRoCDAYNcNN6FBLShao4WzwHDQKvVGhoFAwGgtFgQHENhoB7nCwHRAIC0EyUcC8Zw1ha3NIRgAAIfkEBQcADwAsAAAAABAAEAAABGDwyfnWoljaNYYFV+Zx3hCEGEcuypBtMJBISpClAWLfWODymIFiCJwMDMiZBNAAYFqUAaNQ2E0YBIXGURAMCo1AAsFYBBoIScBJEwgSVcmP0li4FwcHz+FpCCQMPCFINxEAIfkEBQcADgAsAAABABAADwAABFzQyemWXYNqaSXY2vVtw3UNmROM4JQowKKlFOsgRI6ASQ8IhSADFAjAMIMAgSYJtByxyQIhcEoaBcSiwegpDgvAwSBJ0AIHBoCQqIAEi/TCIAABGhLG8MbcKBQgEQAh+QQFBwAPACwAAAEAEAAPAAAEXfDJSd+qeK5RB8fDRRWFspyotAAfQBbfNLCVUSSdKDV89gDAwcFBIBgywMRnkWBgcJUDKSZRIKAPQcGwYByAAYTEEJAAJIGbATEQ+B4ExmK9CDhBd8ThdHw/AmUYEQAh+QQFBwAPACwAAAEADwAPAAAEXvBJQIa8+ILSspdHkXxS9wxF4Q3L2aTBeC0sFjhAtuyLIjAMhYc2GBgaSKGuyNoBDp7czFAgeBIKwC6kWCAMxUSAFjtNCAAFGGF5tCQLAaJnWCTqHoREvQuQJAkyGBEAOw==') right center no-repeat;
    }
</style>

<div class="return-form-wrapper">
    <?php if (isset($status)) : ?>
        <div class="alert alert-<?= $status ?> alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post" action="" onmouseover="hide_history()" id="returnPurchaseForm">
        <!-- Section 1: Purchase Return Header Details -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-reply text-primary"></i> Purchase Return Information</h3>
                <div class="box-tools pull-right">
                    <span class="label label-primary" style="font-size: 13px; padding: 5px 10px;">
                        <i class="fa fa-hashtag"></i> <?= generate_expiry_number() ?>
                    </span>
                </div>
            </div>
            <div class="box-body" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-file-text-o text-muted"></i> Purchase Invoice / Batch <span class="text-danger">*</span></label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                <input required="required" type="text" class="form-control" autocomplete="off" name="return_purchase_invoice" id="return_purchase_invoice" placeholder="Search Invoice or Batch..." />
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Search invoice to auto-fill items</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-truck text-muted"></i> Supplier <span class="text-danger">*</span></label>
                            <select name="suplier_id" id="supplier_id" class="form-control input-sm select2" style="width: 100%;">
                                <option value="">-- Choose Supplier --</option>
                                <?php if (!empty($supplier)) : ?>
                                    <?php foreach ($supplier as $val) : ?>
                                        <option value="<?= $val['supplier_id'] ?>"><?= $val['supplier_name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-list-alt text-muted"></i> Return Type <span class="text-danger">*</span></label>
                            <select required="required" name="return_purchase_type" class="form-control input-sm select2" style="width: 100%;">
                                <option value="">-- Choose Type --</option>
                                <?php if (!empty($return_purchase_type)) : ?>
                                    <?php foreach ($return_purchase_type as $key => $val) : ?>
                                        <option value="<?= $key ?>" <?= ($key == 'expiry') ? 'selected="selected"' : '' ?>><?= $val ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-calendar text-muted"></i> Return Date <span class="text-danger">*</span></label>
                            <input type="text" required="required" class="form-control input-sm datepicker" autocomplete="off" name="expiry_date" value="<?= date('d-M-Y') ?>" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-tag text-muted"></i> Ref / Note <span class="text-danger">*</span></label>
                            <input required="required" type="text" class="form-control input-sm return_purchase_ref" autocomplete="off" name="return_purchase_ref" id="return_purchase_ref" placeholder="Reference note" />
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-barcode text-muted"></i> Entry Number</label>
                            <input required="required" readonly="readonly" value="<?= generate_expiry_number() ?>" type="text" name="return_purchase_entry_number" class="form-control input-sm" style="background:#f8fafc; font-weight:700; color:#1e293b;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Items Table -->
        <div class="box box-info purchase_return_content" onmouseover="hide_history()">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-cubes text-info"></i> Purchase Return Items</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-success btn-sm btn-flat addm" onclick="addmore()" title="Add another return item row">
                        <i class="fa fa-plus-circle"></i> Add Item Row
                    </button>
                </div>
            </div>
            <div class="box-body" style="padding: 15px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-custom-items">
                        <thead>
                            <tr>
                                <th style="width: 45px;">#</th>
                                <th style="min-width: 220px;">Product Name <span class="text-danger">*</span></th>
                                <th style="width: 90px;">HSN</th>
                                <th style="width: 100px;">Batch <span class="text-danger">*</span></th>
                                <th style="width: 90px;">Strip / Qty <span class="text-danger">*</span></th>
                                <th style="width: 120px;">Exp Date (MM/YY)</th>
                                <th style="width: 100px;">MRP (₹)</th>
                                <th style="width: 110px;">Total (₹)</th>
                                <th style="width: 55px;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="appendHere">
                            <!-- Populated dynamically or via invoice lookup -->
                        </tbody>
                        <tbody id="history">
                            <!-- Purchase history tooltip / quick preview -->
                        </tbody>
                    </table>
                </div>

                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-7 col-sm-12">
                        <div style="padding-top: 10px;">
                            <button type="button" class="btn btn-default btn-sm addm" onclick="addmore()">
                                <i class="fa fa-plus text-success"></i> Add Item Row (Tab)
                            </button>
                            <p class="text-muted" style="margin-top: 10px; font-size: 12px;">
                                <i class="fa fa-info-circle"></i> Type batch or invoice above to auto-load items, or enter products manually.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12">
                        <div class="return-summary-card">
                            <div class="summary-row">
                                <span class="summary-label">Total Return Items:</span>
                                <span class="summary-val totalItem">0</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Grand Return Total:</span>
                                <span class="summary-val highlight-green">₹ <span class="totalAmount">0.00</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer text-right" style="padding: 15px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="submit" class="btn btn-primary btn-flat" style="padding: 8px 24px; font-size: 14px; font-weight: 600;">
                    <i class="fa fa-save"></i> Save Return
                </button>
                <button type="button" class="btn btn-default btn-flat" onclick="goBack()" style="padding: 8px 20px; font-size: 14px;">
                    <i class="fa fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function calcualteTotal(theObject) {
        var $row = $(theObject).closest('.rowline');
        var qty = parseFloat($row.find('[name^="return_purchase_strip"]').val()) || 0;
        var mrp = parseFloat($row.find('[name^="return_purchase_mrp"]').val()) || 0;
        var total = (mrp * qty).toFixed(2);
        $row.find('[name^="return_purchase_total"]').val(total);
        calculate_amount();
    }

    function calculate_amount() {
        var totalItem = $('.rowline').length;
        var totalTotal = 0;
        $('.rowline').each(function() {
            var val = parseFloat($(this).find('[name="return_purchase_total[]"]').val()) || 0;
            totalTotal += val;
        });
        $('.totalItem').html(totalItem);
        $('.totalAmount').html(totalTotal.toFixed(2));
    }

    var rowcount = 0;

    function addmore() {
        rowcount++;
        var therow = '<tr class="rowline" onkeyup="get_history(this)" onfocus="get_history(this)" onclick="get_history(this)" onmouseout="hide_history()">' +
            '<td class="text-center font-bold"><span>' + rowcount + '</span></td>' +
            '<td><input required="required" type="text" class="form-control input-sm" name="medicine_name[]" onblur="fetch_medicine_return()" placeholder="Type medicine name..."></td>' +
            '<td><input required="required" type="number" class="form-control input-sm" name="medicine_hsn[]"></td>' +
            '<td><input required="required" type="text" class="form-control input-sm" name="return_purchase_Batch[]" onblur="fetch_medicine_return()" pattern="^\\S+$" placeholder="Batch"></td>' +
            '<td><input required="required" type="number" class="form-control input-sm" name="return_purchase_strip[]" oninput="calcualteTotal(this)" min="1" value="1"></td>' +
            '<td>' +
                '<div style="display:flex; align-items:center; justify-content:center; gap:4px;">' +
                    '<input required="required" type="text" class="form-control input-sm" name="return_purchase_expire_month[]" max="12" min="1" maxlength="2" onfocusout="focusvalidation(this)" pattern="^[0-9]+$" placeholder="MM" style="width:46px; text-align:center;">' +
                    '<span>/</span>' +
                    '<input required="required" type="text" class="form-control input-sm" name="return_purchase_expire_year[]" pattern="^[0-9]+$" placeholder="YY" style="width:46px; text-align:center;">' +
                '</div>' +
            '</td>' +
            '<td><input required="required" type="text" class="form-control input-sm" onkeyup="calcualteTotal(this)" name="return_purchase_mrp[]" value="0.00"></td>' +
            '<td><input required="required" readonly="readonly" type="text" class="form-control input-sm" name="return_purchase_total[]" value="0.00" style="background:#f8fafc; font-weight:600;"></td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-danger btn-xs btn-remove-row" onclick="removeRow(this)" title="Remove item">' +
                    '<i class="fa fa-trash"></i>' +
                '</button>' +
            '</td>' +
        '</tr>';

        $('.appendHere').append(therow);
        bindAutocompleteToRows();
        calculate_amount();

        $(document).find('.return_purchase_ref').off('keydown').on('keydown', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 9 && !e.shiftKey) {
                e.preventDefault();
                $('.addm').first().click();
            }
        });
        $(".rowline:last").find('[name^="medicine_name[]"]').focus();
    }

    function removeRow(targetObj) {
        $(targetObj).closest('.rowline').remove();
        $('.appendHere .rowline').each(function(idx) {
            $(this).find('td:first span').text(idx + 1);
        });
        calculate_amount();
    }

    function bindAutocompleteToRows() {
        <?php if (isset($this) && isset($this->page_config['autocomplete'])) : ?>
            var autoComplete = <?= json_encode($this->page_config['autocomplete']); ?>;
            $.each(autoComplete, function(targetField, value) {
                $.each(value, function(model, fieldToSearch) {
                    $('.rowline:last').find('[name^="' + targetField + '[]"]').autocomplete({
                        source: '/search.php?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1,
                        select: function(event, ui) {
                            var targetRow = $(this).closest('tr');
                            $.each(ui.item.complete, function(populate_field, populate_value) {
                                $(targetRow).find('[name^="' + populate_field + '"]').val(populate_value);
                            });
                        }
                    });
                });
            });
        <?php endif; ?>
    }

    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() { $(this).remove(); });
        }, 3000);

        if ($.fn.select2) {
            $('.select2').select2();
        }

        if ($.fn.datepicker) {
            $("[name='expiry_date']").datepicker({
                dateFormat: 'dd-M-yy',
                changeMonth: true,
                changeYear: true
            });
        }

        <?php if (isset($this) && isset($this->page_config['autocomplete'])) : ?>
            var autoComplete = <?= json_encode($this->page_config['autocomplete']); ?>;
            $.each(autoComplete, function(targetField, value) {
                $.each(value, function(model, fieldToSearch) {
                    $('[name="' + targetField + '"]').autocomplete({
                        source: '/search.php?table=' + model + '&fieldToSearch=' + fieldToSearch,
                        minLength: 1,
                        select: function(event, ui) {
                            $.each(ui.item.complete, function(populate_field, populate_value) {
                                $('[name="' + populate_field + '"]').val(populate_value);
                            });
                        }
                    });
                });
            });
        <?php endif; ?>

        // Batch / Invoice autocomplete lookup
        $('[name="return_purchase_invoice"], [name="return_purchase_Batch[]"]').autocomplete({
            source: '<?= console_url() ?>return_purchase/fetch_invoice_details',
            minLength: 1,
            select: function(event, ui) {
                $('.purchase_return_content').show();
                $.each(ui.item.complete, function(populate_field, populate_value) {
                    $('[name="' + populate_field + '"]').val(populate_value);
                });

                if (ui.item.complete.supplier_id) {
                    $('#supplier_id').val(ui.item.complete.supplier_id).trigger('change');
                }

                var therow = "";
                $.each(ui.item.data, function(populate_field, populate_value) {
                    rowcount = populate_field + 1;
                    therow += '<tr id="rowID' + rowcount + '" class="rowline">' +
                        '<td class="text-center font-bold"><span>' + rowcount + '</span></td>' +
                        '<td><input required="required" type="text" class="form-control input-sm" name="medicine_name[]" value="' + (populate_value.medicine_name || '') + '"></td>' +
                        '<td><input required="required" type="number" class="form-control input-sm" name="medicine_hsn[]" value="' + (populate_value.medicine_hsn || '') + '"></td>' +
                        '<td><input required="required" type="text" class="form-control input-sm" name="return_purchase_Batch[]" pattern="^\\S+$" value="' + (populate_value.purchase_batch || '') + '"></td>' +
                        '<td><input required="required" type="number" class="form-control input-sm" name="return_purchase_strip[]" oninput="calcualteTotal(this)" value="' + (populate_value.purchase_quantity || 1) + '" min="1" max="' + (populate_value.purchase_quantity || '') + '"></td>' +
                        '<td>' +
                            '<div style="display:flex; align-items:center; justify-content:center; gap:4px;">' +
                                '<input required="required" type="text" readonly="readonly" class="form-control input-sm" name="return_purchase_expire_month[]" max="12" min="1" maxlength="2" onfocusout="focusvalidation(this)" pattern="^[0-9]+$" value="' + (populate_value.purchase_expire_month || '') + '" style="width:46px; text-align:center;">' +
                                '<span>/</span>' +
                                '<input required="required" type="text" readonly="readonly" class="form-control input-sm" name="return_purchase_expire_year[]" pattern="^[0-9]+$" value="' + (populate_value.purchase_expire_year || '') + '" style="width:46px; text-align:center;">' +
                            '</div>' +
                        '</td>' +
                        '<td><input required="required" type="text" readonly="readonly" class="form-control input-sm" name="return_purchase_mrp[]" value="' + (populate_value.purchase_mrp || '0.00') + '"></td>' +
                        '<td><input required="required" readonly="readonly" type="text" class="form-control input-sm" name="return_purchase_total[]" value="' + (populate_value.purchase_total || '0.00') + '" style="background:#f8fafc; font-weight:600;"></td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-danger btn-xs btn-remove-row" onclick="removeRow(this)" title="Remove item">' +
                                '<i class="fa fa-trash"></i>' +
                            '</button>' +
                        '</td>' +
                    '</tr>';
                });

                $('.appendHere').html(therow);
                calculate_amount();
                $('.addm').show();
            }
        });

        // Add initial row if table empty
        if ($('.appendHere tr').length === 0) {
            addmore();
        }
    });

    function focusvalidation(obg) {
        if ($(obg).val() > 12) {
            alert('Month value cannot be more than 12');
            $(obg).val('');
            $(obg).focus();
            return false;
        }
    }

    function fetch_medicine_return() {
        var medVal = $('[name="medicine_name[]"]').val();
        if (!medVal) return;
        $.post('/console/return_purchase/fetch_medicine_return', {
            medicine: medVal
        }, function(resp) {
            if (resp && resp.medicine_count == 0) {
                $('[name="medicine_name[]"]').css('border-color', '#ef4444');
            } else {
                $('[name="medicine_name[]"]').css('border-color', '#cbd5e1');
            }
        });
    }

    function get_history(targetObj) {
        var medVal = $(targetObj).find('[name^="medicine_name[]"]').val();
        if (!medVal) return;
        $.post('/console/purchase/purchase_history', {
            medicine: medVal
        }, function(resp) {
            $('#history').html(resp);
        });
    }

    function hide_history() {
        $('#history').html('');
    }
</script>