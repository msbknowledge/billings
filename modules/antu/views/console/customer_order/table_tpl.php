<div class="content-wrapper-inner" style="padding: 15px;">
    <!-- Stat Summary Badges -->
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-aqua" style="border-radius: 8px 0 0 8px;"><i class="fa fa-shopping-cart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Orders</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['total']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-yellow" style="border-radius: 8px 0 0 8px;"><i class="fa fa-clock-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">New Placed</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['placed']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-orange" style="border-radius: 8px 0 0 8px; background-color: #f39c12 !important;"><i class="fa fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Out For Delivery</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['out_for_delivery']) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box" style="box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-radius: 8px;">
                <span class="info-box-icon bg-green" style="border-radius: 8px 0 0 8px;"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Delivered</span>
                    <span class="info-box-number" style="font-size: 22px;"><?= number_format($summary['delivered']) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card Box -->
    <div class="box box-primary" style="box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-radius: 8px;">
        <div class="box-header with-border" style="padding: 15px;">
            <h3 class="box-title" style="font-size: 18px; font-weight: 700;">
                <i class="fa fa-cart-arrow-down text-primary" style="margin-right: 8px;"></i> Online Medicine Orders
            </h3>
            <div class="box-tools pull-right" style="top: 10px;">
                <form method="get" action="<?= console_url('customer_order') ?>" class="form-inline" style="display: inline-block;">
                    <div class="form-group" style="margin-right: 5px;">
                        <select name="status" class="form-control input-sm" onchange="this.form.submit()" style="border-radius: 4px;">
                            <option value="all" <?= ($status_filter == 'all' || empty($status_filter)) ? 'selected' : '' ?>>All Statuses</option>
                            <option value="Order Placed" <?= ($status_filter == 'Order Placed') ? 'selected' : '' ?>>Order Placed</option>
                            <option value="Confirmed & Packing" <?= ($status_filter == 'Confirmed & Packing') ? 'selected' : '' ?>>Confirmed & Packing</option>
                            <option value="Out for Delivery" <?= ($status_filter == 'Out for Delivery') ? 'selected' : '' ?>>Out for Delivery</option>
                            <option value="Delivered" <?= ($status_filter == 'Delivered') ? 'selected' : '' ?>>Delivered</option>
                            <option value="Cancelled" <?= ($status_filter == 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="input-group input-group-sm" style="width: 220px;">
                        <input type="text" name="search" class="form-control pull-right" placeholder="Search order / customer..." value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-hover table-striped" style="vertical-align: middle; margin-bottom: 0;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; font-size: 13px;">
                            <th style="padding: 12px 15px;">Order Ref</th>
                            <th>Customer Name</th>
                            <th>Phone / Contact</th>
                            <th>Medicine Ordered</th>
                            <th>Qty</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Order Date</th>
                            <th style="text-align: right; padding-right: 15px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? if (!empty($orders)): ?>
                            <? foreach ($orders as $ord): ?>
                                <?
                                $status = $ord['status'] ?? 'Order Placed';
                                $badgeClass = 'label-info';
                                if ($status === 'Order Placed') $badgeClass = 'label-warning';
                                elseif ($status === 'Confirmed & Packing') $badgeClass = 'label-primary';
                                elseif ($status === 'Out for Delivery') $badgeClass = 'label-info';
                                elseif ($status === 'Delivered') $badgeClass = 'label-success';
                                elseif ($status === 'Cancelled') $badgeClass = 'label-danger';
                                ?>
                                <tr style="font-size: 13px;">
                                    <td style="padding: 12px 15px; font-weight: 700; color: #0284c7;">
                                        <?= htmlspecialchars($ord['order_code']) ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($ord['customer_name']) ?></strong>
                                    </td>
                                    <td>
                                        <a href="tel:<?= htmlspecialchars($ord['phone']) ?>" style="color: #334155;">
                                            <i class="fa fa-phone text-muted" style="margin-right: 4px;"></i><?= htmlspecialchars($ord['phone']) ?>
                                        </a>
                                        <? if (!empty($ord['email'])): ?>
                                            <div style="font-size: 11px; color: #94a3b8;"><?= htmlspecialchars($ord['email']) ?></div>
                                        <? endif; ?>
                                    </td>
                                    <td>
                                        <span style="font-weight: 600; color: #1e293b;"><?= htmlspecialchars($ord['medicine_name']) ?></span>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: #e2e8f0; color: #334155; font-weight: 700;"><?= $ord['quantity'] ?></span>
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: #64748b;"><?= htmlspecialchars($ord['payment_method']) ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs dropdown-toggle <?= str_replace('label-', 'btn-', $badgeClass) ?>" data-toggle="dropdown" style="font-size: 11px; font-weight: 600; border-radius: 12px; padding: 2px 10px;">
                                                <?= htmlspecialchars($status) ?> <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="javascript:void(0);" onclick="updateOrderStatus(<?= $ord['id'] ?>, 'Order Placed')"><span class="label label-warning">Order Placed</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateOrderStatus(<?= $ord['id'] ?>, 'Confirmed & Packing')"><span class="label label-primary">Confirmed & Packing</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateOrderStatus(<?= $ord['id'] ?>, 'Out for Delivery')"><span class="label label-info">Out for Delivery</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="updateOrderStatus(<?= $ord['id'] ?>, 'Delivered')"><span class="label label-success">Delivered</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="javascript:void(0);" onclick="updateOrderStatus(<?= $ord['id'] ?>, 'Cancelled')"><span class="label label-danger">Cancelled</span></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td style="color: #64748b; font-size: 12px;">
                                        <?= date('d M Y, h:i A', strtotime($ord['created_at'])) ?>
                                    </td>
                                    <td style="text-align: right; padding-right: 15px;">
                                        <button class="btn btn-default btn-xs" title="View Order & Address" onclick="openOrderDetailsModal(<?= htmlspecialchars(json_encode($ord), ENT_QUOTES, 'UTF-8') ?>)" style="margin-right: 3px;">
                                            <i class="fa fa-eye text-primary"></i>
                                        </button>
                                        <a href="<?= console_url('customer_order/delete/' . $ord['id']) ?>" onclick="return confirm('Are you sure you want to delete this order?');" class="btn btn-default btn-xs" title="Delete Order">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        <? else: ?>
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-shopping-basket" style="font-size: 40px; margin-bottom: 12px; opacity: 0.4;"></i>
                                    <p style="font-size: 15px; margin: 0;">No online medicine orders found.</p>
                                </td>
                            </tr>
                        <? endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #0284c7; color: #fff; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color: #fff; opacity: 0.9;">&times;</button>
                <h4 class="modal-title"><i class="fa fa-file-text-o"></i> Order Specifications & Delivery Details</h4>
            </div>
            <div class="modal-body" id="orderModalBody" style="padding: 20px;">
                <!-- Populated via JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function openOrderDetailsModal(ord) {
    var html = `
        <table class="table table-bordered table-striped" style="margin-bottom: 0;">
            <tr><th style="width: 35%;">Order Reference</th><td><strong style="color: #0284c7;">${ord.order_code}</strong></td></tr>
            <tr><th>Customer Name</th><td><strong>${ord.customer_name}</strong></td></tr>
            <tr><th>Contact Phone</th><td><a href="tel:${ord.phone}"><i class="fa fa-phone"></i> ${ord.phone}</a></td></tr>
            <tr><th>Email</th><td>${ord.email || 'N/A'}</td></tr>
            <tr><th>Delivery Address</th><td style="color: #b91c1c; font-weight: 600;">${ord.delivery_address}</td></tr>
            <tr><th>Medicine Name</th><td><strong>${ord.medicine_name}</strong></td></tr>
            <tr><th>Quantity</th><td><span class="badge bg-blue">${ord.quantity} Pack(s)</span></td></tr>
            <tr><th>Payment Method</th><td>${ord.payment_method || 'Cash on Delivery'}</td></tr>
            <tr><th>Order Notes</th><td>${ord.order_notes || 'No special notes'}</td></tr>
            <tr><th>Current Status</th><td><span class="label label-info">${ord.status}</span></td></tr>
            <tr><th>Order Placed At</th><td>${ord.created_at}</td></tr>
        </table>
    `;
    document.getElementById('orderModalBody').innerHTML = html;
    $('#orderDetailModal').modal('show');
}

function updateOrderStatus(id, status) {
    $.post('<?= console_url("customer_order/update_status") ?>', {id: id, status: status}, function(res) {
        window.location.reload();
    });
}
</script>
