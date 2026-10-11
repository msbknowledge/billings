<style>
    /* Stock Sale Purchase Report Custom Styling */
    .report-card {
        border-radius: 8px;
        color: #fff;
        padding: 16px 18px;
        margin-bottom: 18px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }
    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .card-meta {
        margin-left: 14px;
        flex-grow: 1;
    }
    .card-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        opacity: 0.9;
        font-weight: 600;
        margin-bottom: 2px;
    }
    .card-value {
        font-size: 22px;
        font-weight: 700;
        line-height: 1.2;
    }
    .gradient-blue {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }
    .gradient-orange {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }
    .gradient-green {
        background: linear-gradient(135deg, #00b09b 0%, #96c93d 100%);
    }
    .gradient-purple {
        background: linear-gradient(135deg, #8e44ad 0%, #9b59b6 100%);
    }
    .gradient-teal {
        background: linear-gradient(135deg, #0083b0 0%, #00b4db 100%);
    }

    /* Filter Box */
    .filter-panel {
        background: #ffffff;
        border: 1px solid #e1e6ef;
        border-radius: 6px;
        padding: 18px 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    }
    .filter-panel label {
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }

    /* Table Styling */
    .report-table {
        margin-bottom: 0;
        font-size: 13px;
    }
    .report-table thead th {
        background: #2c3e50 !important;
        color: #ffffff !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11.5px;
        letter-spacing: 0.4px;
        vertical-align: middle;
        border: 1px solid #34495e !important;
        padding: 10px 8px;
    }
    .report-table tbody td {
        vertical-align: middle;
        padding: 8px 10px;
        border: 1px solid #e9ecef;
    }
    .report-table tbody tr:hover {
        background-color: #f8faff !important;
    }
    .report-table tfoot td {
        background: #f1f4f9;
        font-weight: 700;
        font-size: 13px;
        border-top: 2px solid #2c3e50;
        border-bottom: 2px solid #2c3e50;
        padding: 10px 8px;
    }
    .badge-qty {
        font-size: 12px;
        padding: 4px 8px;
        font-weight: 600;
        border-radius: 3px;
        display: inline-block;
        min-width: 32px;
        text-align: center;
    }
    .badge-in { background: #e8f4fd; color: #1e88e5; }
    .badge-out { background: #fff3e0; color: #ef6c00; }
    .badge-stock { background: #e8f8f5; color: #00897b; font-weight: 700; }
    .badge-return { background: #fbe9e7; color: #d84315; }

    /* Print Styles */
    @media print {
        body { background: #fff !important; font-size: 11px; }
        .main-header, .main-sidebar, .content-header, .filter-panel, .btn-print-hide, .report-card, .box-header .box-tools {
            display: none !important;
        }
        .content-wrapper, .right-side, .main-footer {
            margin-left: 0 !important;
            padding: 0 !important;
            border: none !important;
        }
        .box { border: none !important; box-shadow: none !important; margin: 0 !important; }
        .report-table thead th {
            background: #2c3e50 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .print-header-show {
            display: block !important;
            margin-bottom: 15px;
            text-align: center;
        }
        .print-header-show h2 { margin: 0 0 4px 0; font-size: 20px; font-weight: bold; }
        .print-header-show p { margin: 0; color: #666; font-size: 12px; }
    }
    .print-header-show { display: none; }
</style>

<div class="row">
    <div class="col-md-12">

        <!-- Print-only Brand Header -->
        <div class="print-header-show">
            <h2><?= isset($this->current_site_settings['site_setting_title']) ? $this->current_site_settings['site_setting_title'] : 'Medical Shop' ?></h2>
            <p><strong>Stock Sale Purchase Report</strong></p>
            <p id="print_date_range">Generated on: <?= date('d M Y, h:i A') ?></p>
            <hr style="margin: 10px 0;">
        </div>

        <!-- Top Overview Statistics Cards -->
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-blue">
                    <div class="card-icon"><i class="fa fa-medkit"></i></div>
                    <div class="card-meta">
                        <div class="card-title">Medicines</div>
                        <div class="card-value" id="card_total_medicines">0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-teal">
                    <div class="card-icon"><i class="fa fa-arrow-down"></i></div>
                    <div class="card-meta">
                        <div class="card-title">In Qnty (Purchase)</div>
                        <div class="card-value" id="card_total_in">0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-orange">
                    <div class="card-icon"><i class="fa fa-arrow-up"></i></div>
                    <div class="card-meta">
                        <div class="card-title">Out Qnty (Sale)</div>
                        <div class="card-value" id="card_total_out">0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-green">
                    <div class="card-icon"><i class="fa fa-cubes"></i></div>
                    <div class="card-meta">
                        <div class="card-title">Stock in Hand</div>
                        <div class="card-value" id="card_total_stock">0</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-purple">
                    <div class="card-icon"><i class="fa fa-tag"></i></div>
                    <div class="card-meta">
                        <div class="card-title">Stock Sale Value</div>
                        <div class="card-value">₹<span id="card_total_stock_sale">0.00</span></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="report-card gradient-blue">
                    <div class="card-icon"><i class="fa fa-shopping-cart"></i></div>
                    <div class="card-meta">
                        <div class="card-title">Stock Purchase Value</div>
                        <div class="card-value">₹<span id="card_total_stock_purchase">0.00</span></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Panel -->
        <div class="filter-panel btn-print-hide">
            <form id="filterForm" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label><i class="fa fa-calendar"></i> From Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label><i class="fa fa-calendar"></i> To Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label><i class="fa fa-search"></i> Search Medicine</label>
                            <input type="text" name="search" id="search_term" class="form-control" placeholder="Type medicine name..." autocomplete="off" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label><i class="fa fa-filter"></i> Stock Filter</label>
                            <select name="stock_only" id="stock_only" class="form-control">
                                <option value="0">All Medicines</option>
                                <option value="1">In-Stock Only (&gt; 0)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12 text-right" style="margin-top: 24px;">
                        <button type="button" id="btnFilter" class="btn btn-primary" style="font-weight: 600; padding: 6px 14px;">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                        <button type="button" id="btnReset" class="btn btn-default" style="padding: 6px 12px; margin-left: 4px;">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                        <button type="button" id="btnExport" class="btn btn-success" style="font-weight: 600; padding: 6px 14px; margin-left: 4px;">
                            <i class="fa fa-file-excel-o"></i> CSV
                        </button>
                        <button type="button" id="btnPrint" class="btn btn-info" style="font-weight: 600; padding: 6px 14px; margin-left: 4px;">
                            <i class="fa fa-print"></i> Print
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Report Table Box -->
        <div class="box box-primary" style="border-top: 3px solid #1e3c72; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <div class="box-header with-border" style="padding: 12px 18px;">
                <div class="row" style="display:flex; align-items:center; justify-content:space-between;">
                    <div class="col-sm-6">
                        <h3 class="box-title" style="font-size: 16px; font-weight: 700; color: #2c3e50;">
                            <i class="fa fa-list-alt text-primary"></i> Stock Sale Purchase Movement Statement
                        </h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <span id="loading_spinner" style="display:none; color: #1e3c72; font-weight: 600; font-size: 13px;">
                            <i class="fa fa-spinner fa-spin"></i> Loading report data...
                        </span>
                    </div>
                </div>
            </div>

            <div class="box-body no-padding table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-hover report-table" id="reportTable">
                    <thead>
                        <tr>
                            <th style="width: 45px; text-align: center;">#</th>
                            <th style="min-width: 220px;">Medicine Name</th>
                            <th style="width: 110px; text-align: center;">Batch No</th>
                            <th style="width: 100px; text-align: right;">Sale Price</th>
                            <th style="width: 110px; text-align: right;">Purchase Price</th>
                            <th style="width: 90px; text-align: center;">In Qnty.</th>
                            <th style="width: 90px; text-align: center;">Out Qnty.</th>
                            <th style="width: 95px; text-align: center;">Sale Return</th>
                            <th style="width: 110px; text-align: center;">Purchase Return</th>
                            <th style="width: 85px; text-align: center;">Stock</th>
                            <th style="width: 130px; text-align: right;">Stock Sale Price</th>
                            <th style="width: 140px; text-align: right;">Stock Purchase Price</th>
                        </tr>
                    </thead>
                    <tbody id="reportDataBody">
                        <tr>
                            <td colspan="12" class="text-center" style="padding: 35px; color: #777;">
                                <i class="fa fa-spinner fa-spin fa-2x text-primary"></i>
                                <div style="margin-top: 10px; font-weight: 600;">Loading report statement...</div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot id="reportDataFoot" style="display:none;">
                        <tr>
                            <td colspan="5" style="text-align: right; font-weight: 700; font-size: 13px;">TOTAL:</td>
                            <td style="text-align: center;" id="foot_in_qty">0</td>
                            <td style="text-align: center;" id="foot_out_qty">0</td>
                            <td style="text-align: center;" id="foot_sale_return">0</td>
                            <td style="text-align: center;" id="foot_purchase_return">0</td>
                            <td style="text-align: center;" id="foot_stock">0</td>
                            <td style="text-align: right; color: #8e44ad;" id="foot_stock_sale_price">₹0.00</td>
                            <td style="text-align: right; color: #1e3c72;" id="foot_stock_purchase_price">₹0.00</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    var reportUrl = "<?= console_url('medicine_stock/stock_sale_purchase_report'); ?>";

    function loadReport() {
        $('#loading_spinner').show();
        $('#reportDataBody').html('<tr><td colspan="11" class="text-center" style="padding: 35px; color: #555;"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><div style="margin-top: 8px;">Fetching data...</div></td></tr>');
        $('#reportDataFoot').hide();

        var params = $('#filterForm').serialize();

        $.ajax({
            url: reportUrl,
            type: 'GET',
            data: params + '&ajax=1',
            dataType: 'json',
            success: function(resp) {
                $('#loading_spinner').hide();
                if (resp && resp.status === 'success') {
                    renderReport(resp.data, resp.summary);
                } else {
                    $('#reportDataBody').html('<tr><td colspan="11" class="text-center text-danger" style="padding: 30px;">Error loading data</td></tr>');
                }
            },
            error: function(err) {
                $('#loading_spinner').hide();
                $('#reportDataBody').html('<tr><td colspan="11" class="text-center text-danger" style="padding: 30px;"><i class="fa fa-exclamation-triangle"></i> Failed to communicate with server</td></tr>');
            }
        });
    }

    function renderReport(items, summary) {
        // Update top cards
        if (summary) {
            $('#card_total_medicines').text(summary.total_medicines || 0);
            $('#card_total_in').text(summary.total_in || 0);
            $('#card_total_out').text(summary.total_out || 0);
            $('#card_total_stock').text(summary.total_stock || 0);
            $('#card_total_stock_sale').text(summary.total_stock_sale_price || '0.00');
            $('#card_total_stock_purchase').text(summary.total_stock_purchase_price || '0.00');

            // Update Table Foot
            $('#foot_in_qty').text(summary.total_in || 0);
            $('#foot_out_qty').text(summary.total_out || 0);
            $('#foot_sale_return').text(summary.total_sale_return || 0);
            $('#foot_purchase_return').text(summary.total_purchase_return || 0);
            $('#foot_stock').text(summary.total_stock || 0);
            $('#foot_stock_sale_price').text('₹' + (summary.total_stock_sale_price || '0.00'));
            $('#foot_stock_purchase_price').text('₹' + (summary.total_stock_purchase_price || '0.00'));
            $('#reportDataFoot').show();
        }

        if (!items || items.length === 0) {
            $('#reportDataBody').html('<tr><td colspan="12" class="text-center" style="padding: 35px; color: #888;"><i class="fa fa-info-circle fa-2x"></i><div style="margin-top: 8px;">No stock or transaction records found matching your filter.</div></td></tr>');
            $('#reportDataFoot').hide();
            return;
        }

        var html = '';
        $.each(items, function(idx, item) {
            html += '<tr>';
            html += '<td style="text-align: center; color: #777;">' + (idx + 1) + '</td>';
            html += '<td><strong>' + escapeHtml(item.medicine_name) + '</strong></td>';
            html += '<td style="text-align: center;"><span class="badge" style="background: #f1f4f9; color: #333; font-weight: 600; border: 1px solid #d5dbe5; padding: 3px 8px;">' + escapeHtml(item.batch_no || '-') + '</span></td>';
            html += '<td style="text-align: right;">₹' + item.sale_price + '</td>';
            html += '<td style="text-align: right;">₹' + item.purchase_price + '</td>';
            html += '<td style="text-align: center;"><span class="badge-qty badge-in">' + item.in_qty + '</span></td>';
            html += '<td style="text-align: center;"><span class="badge-qty badge-out">' + item.out_qty + '</span></td>';
            html += '<td style="text-align: center;"><span class="badge-qty badge-return">' + item.sale_return + '</span></td>';
            html += '<td style="text-align: center;"><span class="badge-qty badge-return">' + item.purchase_return + '</span></td>';
            html += '<td style="text-align: center;"><span class="badge-qty badge-stock">' + item.stock + '</span></td>';
            html += '<td style="text-align: right; font-weight: 600; color: #8e44ad;">₹' + item.stock_sale_price + '</td>';
            html += '<td style="text-align: right; font-weight: 600; color: #1e3c72;">₹' + item.stock_purchase_price + '</td>';
            html += '</tr>';
        });

        $('#reportDataBody').html(html);
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Initial Load
    loadReport();

    // Filter Buttons
    $('#btnFilter').click(function() {
        loadReport();
    });

    $('#btnReset').click(function() {
        $('#start_date').val('');
        $('#end_date').val('');
        $('#search_term').val('');
        $('#stock_only').val('0');
        loadReport();
    });

    // Real-time search with debounce
    var searchTimer = null;
    $('#search_term').on('keyup', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function() {
            loadReport();
        }, 350);
    });

    $('#stock_only').change(function() {
        loadReport();
    });

    // Export CSV
    $('#btnExport').click(function() {
        var params = $('#filterForm').serialize();
        window.location.href = reportUrl + '?' + params + '&export=csv';
    });

    // Print
    $('#btnPrint').click(function() {
        var sDate = $('#start_date').val();
        var eDate = $('#end_date').val();
        if (sDate || eDate) {
            $('#print_date_range').text('Period: ' + (sDate || 'Beginning') + ' to ' + (eDate || 'Today') + ' | Printed: ' + new Date().toLocaleString());
        } else {
            $('#print_date_range').text('All-Time Statement | Printed: ' + new Date().toLocaleString());
        }
        window.print();
    });
});
</script>
