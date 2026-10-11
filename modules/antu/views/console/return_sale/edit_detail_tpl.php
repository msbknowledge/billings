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
    .return-summary-card .summary-val.highlight-blue {
        font-size: 20px;
        color: #2563eb;
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
</style>

<div class="return-form-wrapper">
    <?php if (isset($status)) : ?>
        <div class="alert alert-<?= $status ?> alert-dismissible" style="margin-bottom: 15px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <i class="fa fa-info-circle"></i> <?= $message ?>
        </div>
    <?php endif; ?>

    <form method="post" action="" id="editReturnSaleForm">
        <!-- Section 1: Sale Return Header Details -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-pencil-square-o text-primary"></i> Edit Sale Return Information</h3>
                <div class="box-tools pull-right">
                    <span class="label label-primary" style="font-size: 13px; padding: 5px 10px;">
                        <i class="fa fa-hashtag"></i> <?= $data[0]['return_sale_entry_number'] ?>
                    </span>
                </div>
            </div>
            <div class="box-body" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-file-text-o text-muted"></i> Sale Invoice</label>
                            <input required="required" readonly="readonly" type="text" class="form-control input-sm" autocomplete="off" name="return_sale_invoice" id="return_sale_invoice" value="<?= $data[0]['return_sale_invoice'] ?>" style="background:#f8fafc; font-weight:700;" />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-user text-muted"></i> Customer <span class="text-danger">*</span></label>
                            <select name="customer_ID" class="form-control input-sm select2" style="width: 100%;">
                                <?php if (!empty($customer)) : ?>
                                    <?php foreach ($customer as $val) : ?>
                                        <option value="<?= $val['customer_ID'] ?>" <?= ($data[0]['return_sale_customer'] == $val['customer_ID']) ? 'selected="selected"' : '' ?>><?= $val['customer_name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-calendar text-muted"></i> Return Date <span class="text-danger">*</span></label>
                            <input type="text" value="<?= date('d-M-Y', strtotime($data[0]['return_sale_date'])) ?>" required="required" class="form-control input-sm datepicker" autocomplete="off" name="expiry_date" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-tag text-muted"></i> Reference <span class="text-danger">*</span></label>
                            <input value="<?= $data[0]['return_sale_ref'] ?>" required="required" type="text" class="form-control input-sm" autocomplete="off" name="return_sale_ref" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-barcode text-muted"></i> Entry Number</label>
                            <input required="required" readonly="readonly" value="<?= $data[0]['return_sale_entry_number'] ?>" type="text" name="return_sale_entry_number" class="form-control input-sm" style="background:#f8fafc; font-weight:700; color:#1e293b;" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Items Table -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-medkit text-info"></i> Sale Return Items</h3>
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
                            <?php 
                            $totalAmount = 0;
                            foreach ($data as $k => $value) : 
                                $totalAmount += floatval($value['return_sale_total']);
                            ?>
                                <tr class="rowline">
                                    <td class="text-center font-bold"><span><?= $k + 1 ?></span></td>
                                    <td><input required="required" type="text" class="form-control input-sm" value="<?= html_escape($value['return_sale_medicine']) ?>" name="medicine_name[]"></td>
                                    <td><input required="required" type="text" class="form-control input-sm" value="<?= html_escape($value['return_sale_HSN']) ?>" name="return_sale_HSN[]"></td>
                                    <td><input required="required" type="text" class="form-control input-sm" value="<?= html_escape($value['return_sale_Batch']) ?>" name="return_sale_Batch[]" pattern="^\S+$"></td>
                                    <td><input required="required" type="number" class="form-control input-sm" value="<?= $value['return_sale_strip'] ?>" oninput="calcualteTotal(this)" name="return_sale_strip[]" min="1" max="<?= isset($value['max_strip_limit']) ? $value['max_strip_limit'] : '' ?>"></td>
                                    <td>
                                        <div style="display:flex; align-items:center; justify-content:center; gap:4px;">
                                            <input required="required" type="text" class="form-control input-sm" value="<?= $value['return_sale_expire_month'] ?>" readonly="readonly" name="return_sale_expire_month[]" pattern="^[0-9]+$" style="width:46px; text-align:center;">
                                            <span>/</span>
                                            <input required="required" value="<?= $value['return_sale_expire_year'] ?>" readonly="readonly" type="text" class="form-control input-sm" name="return_sale_expire_year[]" pattern="^[0-9]+$" style="width:46px; text-align:center;">
                                        </div>
                                    </td>
                                    <td><input required="required" value="<?= $value['return_sale_mrp'] ?>" readonly="readonly" type="text" class="form-control input-sm" name="return_sale_mrp[]"></td>
                                    <td><input required="required" value="<?= $value['return_sale_total'] ?>" readonly="readonly" type="text" class="form-control input-sm" name="return_sale_total[]" style="background:#f8fafc; font-weight:600;"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-xs btn-remove-row" onclick="removeRow(this)" title="Remove item">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-7 col-sm-12"></div>
                    <div class="col-md-5 col-sm-12">
                        <div class="return-summary-card">
                            <div class="summary-row">
                                <span class="summary-label">Total Return Items:</span>
                                <span class="summary-val" id="totalItems"><?= count($data) ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Grand Return Total:</span>
                                <span class="summary-val highlight-blue">₹ <span id="totalAmount"><?= number_format($totalAmount, 2, '.', '') ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer text-right" style="padding: 15px 20px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <button type="submit" class="btn btn-primary btn-flat" style="padding: 8px 24px; font-size: 14px; font-weight: 600;">
                    <i class="fa fa-save"></i> Save Changes
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
        var qty = parseFloat($row.find('[name^="return_sale_strip"]').val()) || 0;
        var mrp = parseFloat($row.find('[name^="return_sale_mrp"]').val()) || 0;
        var lineTotal = (mrp * qty).toFixed(2);
        $row.find('[name^="return_sale_total"]').val(lineTotal);

        updateSummaryTotals();
    }

    function updateSummaryTotals() {
        var total = 0;
        var count = 0;
        $(".appendHere").find(".rowline").each(function(i, nrElt) {
            var returnTotal = parseFloat($(nrElt).find('[name^="return_sale_total"]').val()) || 0;
            total += returnTotal;
            count++;
        });
        $('#totalAmount').html(total.toFixed(2));
        $('#totalItems').html(count);
    }

    function removeRow(targetObj) {
        $(targetObj).closest('.rowline').remove();
        $('.appendHere .rowline').each(function(idx) {
            $(this).find('td:first span').text(idx + 1);
        });
        updateSummaryTotals();
    }

    $(document).ready(function() {
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
    });
</script>