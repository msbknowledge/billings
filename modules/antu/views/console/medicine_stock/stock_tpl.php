<div class="row">
    <div class="col-md-12">
        <!-- Stock Summary Card -->
        <div class="well well-sm" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: #ffffff; border-radius: 6px; padding: 15px 20px; margin-bottom: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div class="row" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                <div class="col-sm-6" style="display: flex; align-items: center;">
                    <div style="background: rgba(255,255,255,0.15); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                        <i class="fa fa-cubes" style="font-size: 24px; color: #ffffff;"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.85;">Total Stock MRP Value</div>
                        <div id="amount_val" style="font-size: 24px; font-weight: 700; color: #ffffff;">Click to Calculate</div>
                    </div>
                </div>
                <div class="col-sm-6 text-right" style="margin-top: 10px;">
                    <span id="wait_message" style="display:none; color: #ffeb3b; font-size: 13px; margin-right: 12px; font-weight: 600;">
                        <i class="fa fa-spinner fa-spin"></i> Calculating total MRP...
                    </span>
                    <button id="amount_show" type="button" class="btn btn-warning" style="font-weight: 600; padding: 7px 18px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        <i class="fa fa-calculator"></i> Calculate MRP Total
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Stock Table Box -->
        <div class="box box-primary" style="border-top: 3px solid #3c8dbc; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div class="box-header with-border" style="padding: 15px;">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="box-title" style="font-size: 18px; font-weight: 600; margin-top: 5px;">
                            <i class="fa fa-medkit text-primary"></i> Medicine Stock List
                        </h3>
                    </div>
                    <div class="col-sm-6">
                        <form action="<?= base_url() ?>console/medicine_stock/stock" id="searchform" role="form" method="post" onsubmit="return false">
                            <div class="input-group">
                                <input type="text" name="medicine_name" id="medicine_name" placeholder="Search medicine name..." class="form-control" autocomplete="off" />
                                <span class="input-group-btn">
                                    <button type="submit" id="search" class="btn btn-primary" style="font-weight: 600;">
                                        <i class="fa fa-search"></i> SEARCH
                                    </button>
                                    <button type="button" id="clear_search" class="btn btn-default" style="margin-left: 2px;">
                                        <i class="fa fa-refresh"></i> Reset
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-body no-padding table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered table-striped table-hover" style="margin-bottom: 0;">
                    <thead style="background-color: #f4f6f9;">
                        <tr>
                            <th style="width: 60px; text-align: center;">#</th>
                            <th>Medicine Name</th>
                            <th>Manufacturer</th>
                            <th style="width: 80px; text-align: center;">Unit</th>
                            <th style="width: 120px; text-align: center;">Strip Stock</th>
                            <th style="width: 110px; text-align: center;">Loose Stock</th>
                            <th style="width: 130px; text-align: center;">Storage</th>
                        </tr>
                    </thead>
                    <tbody id="searchResult">
                        <tr>
                            <td colspan="7" class="text-center" style="padding: 30px;">
                                <i class="fa fa-spinner fa-spin fa-2x text-muted"></i>
                                <div style="margin-top: 8px; color: #777;">Loading stock data...</div>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var pageCount = 1;
    var isLoading = false;

    function doSearch(resetPage) {
        if (isLoading) return;
        if (resetPage) {
            pageCount = 1;
            $('#searchResult').html('<tr><td colspan="7" class="text-center" style="padding: 25px;"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><div style="margin-top: 8px; color: #555;">Searching medicines...</div></td></tr>');
            $('tfoot').empty();
        }

        isLoading = true;
        var postData = $('#searchform').serialize();
        var url = $('#searchform').attr("action") + "?page=" + pageCount;

        $.ajax({
            url: url,
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(resp) {
                isLoading = false;
                var objresp = (typeof resp === 'string') ? JSON.parse(resp) : resp;

                if (objresp.status === "not found" || !objresp.result || objresp.result.length === 0) {
                    if (pageCount === 1) {
                        $('#searchResult').html('<tr><td colspan="7" class="text-center text-muted" style="padding: 30px; font-size: 14px;"><i class="fa fa-info-circle text-info"></i> No Medicines Found</td></tr>');
                        $('tfoot').empty();
                    } else {
                        $('tfoot').html('<tr><td colspan="7" class="text-center text-muted" style="padding: 12px;">No More Results Found</td></tr>');
                    }
                } else {
                    if (pageCount === 1) {
                        $('#searchResult').empty();
                    }

                    var perpage = 50;
                    var counter = (pageCount - 1) * perpage + 1;

                    $.each(objresp.result, function(k, v) {
                        var tr = $('<tr/>');
                        tr.append($('<td class="text-center text-muted" style="vertical-align: middle;"/>').text(counter));
                        tr.append($('<td style="font-weight: 600; vertical-align: middle;"/>').text(v.medicine_name || '-'));
                        tr.append($('<td style="vertical-align: middle;"/>').text(v.medicine_manufacturer || '-'));
                        tr.append($('<td class="text-center" style="vertical-align: middle;"/>').text(v.medicine_unit || '1'));

                        var stripVal = parseFloat(v.left_strip) || 0;
                        var stripTd = $('<td class="text-center" style="vertical-align: middle;"/>');
                        if (stripVal <= 0) {
                            stripTd.append($('<span class="label label-danger" style="font-size: 12px; padding: 4px 10px; border-radius: 3px; display: inline-block; min-width: 36px;"/>').text(stripVal));
                        } else if (stripVal <= 2) {
                            stripTd.append($('<span class="label label-warning" style="font-size: 12px; padding: 4px 10px; border-radius: 3px; display: inline-block; min-width: 36px;"/>').text(stripVal));
                        } else {
                            stripTd.append($('<span class="label label-success" style="font-size: 12px; padding: 4px 10px; border-radius: 3px; display: inline-block; min-width: 36px;"/>').text(stripVal));
                        }
                        tr.append(stripTd);

                        var looseVal = parseFloat(v.left_loose) || 0;
                        var looseTd = $('<td class="text-center" style="vertical-align: middle; font-weight: 600;"/>');
                        if (looseVal < 0) {
                            looseTd.append($('<span class="text-danger"/>').text(looseVal));
                        } else if (looseVal > 0) {
                            looseTd.append($('<span class="text-primary"/>').text(looseVal));
                        } else {
                            looseTd.append($('<span class="text-muted"/>').text('0'));
                        }
                        tr.append(looseTd);

                        tr.append($('<td class="text-center text-muted" style="vertical-align: middle;"/>').text(v.medicine_storage || '-'));

                        $('#searchResult').append(tr);
                        counter++;
                    });

                    if (objresp.result.length < 50) {
                        $('tfoot').html('<tr><td colspan="7" class="text-center text-muted" style="padding: 12px;">No More Results Found</td></tr>');
                    } else {
                        $('tfoot').html('<tr><td colspan="7" class="text-center" style="padding: 10px;"><button class="btn btn-default btn-block" style="font-weight: 600; background-color: #f8f9fa;" onclick="loadMore()"><i class="fa fa-arrow-down"></i> Load More Results</button></td></tr>');
                    }

                    pageCount++;
                }
            },
            error: function(xhr, status, err) {
                isLoading = false;
                console.error(err);
                if (pageCount === 1) {
                    $('#searchResult').html('<tr><td colspan="7" class="text-center text-danger" style="padding: 25px;"><i class="fa fa-exclamation-triangle"></i> Failed to load stock data. Please check your connection.</td></tr>');
                }
            }
        });
    }

    function loadMore() {
        doSearch(false);
    }

    $(document).ready(function() {
        $('#amount_show').click(function() {
            var $btn = $(this);
            $btn.prop('disabled', true);
            $('#wait_message').show();

            $.ajax({
                url: "<?= base_url() ?>console/medicine_stock/current_stock/",
                type: "POST",
                dataType: "json",
                success: function(resp) {
                    $('#wait_message').hide();
                    $btn.prop('disabled', false);
                    var obj = (typeof resp === 'string') ? JSON.parse(resp) : resp;
                    if (obj && obj.status === "success") {
                        var totalAmt = Number(obj.result).toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $('#amount_val').text('₹ ' + totalAmt);
                    } else {
                        $('#amount_val').text('Unavailable');
                    }
                },
                error: function() {
                    $('#wait_message').hide();
                    $btn.prop('disabled', false);
                    $('#amount_val').text('Error fetching MRP');
                }
            });
        });

        $('#searchform').on('submit', function(e) {
            e.preventDefault();
            doSearch(true);
        });

        $('#search').on('click', function() {
            doSearch(true);
        });

        $('#clear_search').on('click', function() {
            $('#medicine_name').val('');
            doSearch(true);
        });

        // Initial search load
        doSearch(true);
    });
</script>
