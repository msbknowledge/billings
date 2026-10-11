<?php
/**
 * Due Report Sheet View - AdminLTE Layout
 */
$page_title = isset($page_title) ? $page_title : 'Due Report Sheet';
$active_report = isset($active_report) ? $active_report : 'due_report';
$start_val = !empty($start) ? $start : date('Y-m-d', strtotime("-1 month"));
$end_val = !empty($end) ? $end : date('Y-m-d');
?>

<!-- Shared Navigation for Sale Reports -->
<?php $this->load->view('console/elements/sale_reports_nav_tpl', array('active_report' => $active_report)); ?>

<!-- Filter Box -->
<div class="box box-primary filter-box no-print" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 20px;">
    <div class="box-header with-border" style="padding: 12px 18px;">
        <h3 class="box-title" style="font-size: 16px; font-weight: 600; color: #334155;">
            <i class="fa fa-filter text-primary" style="margin-right: 6px;"></i> Filter <?= $page_title ?>
        </h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body" style="padding: 18px;">
        <form id="report_filter_form" method="post" onsubmit="return false">
            <div class="row">
                <div class="col-md-4 col-sm-6 form-group">
                    <label for="start" style="font-weight: 600; color: #475569;">Start Date</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" id="start" name="start" value="<?= $start_val ?>" placeholder="Start date" class="datepicker form-control" autocomplete="off" required />
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 form-group">
                    <label for="end" style="font-weight: 600; color: #475569;">End Date</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" id="end" name="end" value="<?= $end_val ?>" placeholder="End date" class="datepicker form-control" autocomplete="off" required />
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 form-group" style="padding-top: 25px;">
                    <button type="button" id="report_sub" class="btn btn-primary" style="font-weight: 600; padding: 7px 20px; margin-right: 8px;">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <button type="button" id="report_reset" class="btn btn-default" style="padding: 7px 16px; margin-right: 8px;">
                        <i class="fa fa-refresh"></i> Reset
                    </button>
                    <button type="button" onclick="window.print()" class="btn btn-success pull-right" style="font-weight: 600; padding: 7px 18px;">
                        <i class="fa fa-print"></i> Print Report
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Results Card -->
<div class="box box-solid report-box" style="border-radius: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.08);">
    <div class="box-header with-border" style="padding: 14px 18px; border-bottom: 1px solid #f0f2f5;">
        <h3 class="box-title" style="font-size: 17px; font-weight: 600; color: #1e293b;">
            <i class="fa fa-money text-primary" style="margin-right: 6px;"></i> <?= $page_title ?>
        </h3>
        <div class="box-tools pull-right no-print">
            <button type="button" onclick="window.print()" class="btn btn-xs btn-default" style="padding: 4px 10px; font-weight: 500;">
                <i class="fa fa-print"></i> Print
            </button>
        </div>
    </div>
    <div class="box-body" style="padding: 18px;">
        <div id="container" class="report-loading-spinner" style="display: none;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <div style="margin-top: 8px; font-weight: 600; color: #475569;">Fetching due report data...</div>
        </div>
        <div class="ajax_resp table-responsive" style="min-height: 120px;">
            <div class="alert alert-info" style="background-color: #f0f9ff !important; border-color: #bae6fd !important; color: #0369a1 !important; border-radius: 6px;">
                <i class="fa fa-info-circle"></i> Click <strong>Search</strong> to generate the Due Amount report.
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    if ($.fn.datepicker) {
        $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    }

    var xhr = null;
    function fetchDueReport() {
        $('div#container').show();
        if (xhr && xhr.readyState !== 4) {
            xhr.abort();
        }

        xhr = $.post("<?= base_url() ?>console/payments/due_report/", $('#report_filter_form').serialize(), function (resp) {
            $(".ajax_resp").html(resp);
            $('div#container').hide();
        }).fail(function(jqXHR, textStatus) {
            if (textStatus !== 'abort') {
                $('div#container').hide();
                $(".ajax_resp").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Error loading due report data.</div>');
            }
        });
    }

    $('#report_sub').click(function () {
        fetchDueReport();
    });

    $('#start, #end').on("change", function () {
        fetchDueReport();
    });

    $('#report_reset').click(function () {
        $('#report_filter_form')[0].reset();
        $('#start').val('<?= date('Y-m-d', strtotime("-1 month")) ?>');
        $('#end').val('<?= date('Y-m-d') ?>');
        fetchDueReport();
    });

    // Auto load initially
    fetchDueReport();
});
</script>