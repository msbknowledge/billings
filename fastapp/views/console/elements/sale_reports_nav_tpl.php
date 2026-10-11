<?php
/**
 * Shared Submenu Navigation for Sale Reports
 */
$current_action = isset($active_report) ? $active_report : '';
if (empty($current_action)) {
    $seg2 = $this->uri->segment(2);
    $seg3 = $this->uri->segment(3);
    $current_action = $seg2 . '/' . $seg3;
}

$sale_report_items = array(
    'return_sale' => array(
        'title' => 'Return Sale',
        'url'   => console_url('return_sale/sale_report'),
        'icon'  => 'fa-undo',
        'keys'  => array('return_sale', 'return_sale/sale_report')
    ),
    'report_gstin_wise' => array(
        'title' => 'Sale Report GSTIN Wise',
        'url'   => console_url('sale/report_gstin_wise'),
        'icon'  => 'fa-file-text-o',
        'keys'  => array('report_gstin_wise', 'sale/report_gstin_wise')
    ),
    'report_daily_wise' => array(
        'title' => 'Sale Report Daywise',
        'url'   => console_url('sale/report_daily_wise'),
        'icon'  => 'fa-calendar',
        'keys'  => array('report_daily_wise', 'sale/report_daily_wise')
    ),
    'daily_sale_medicine' => array(
        'title' => 'Sale Medicine Report Daywise',
        'url'   => console_url('sale/daily_sale_medicine'),
        'icon'  => 'fa-medkit',
        'keys'  => array('daily_sale_medicine', 'sale/daily_sale_medicine')
    ),
    'due_report' => array(
        'title' => 'Due Report Sheet',
        'url'   => console_url('payments/due_report'),
        'icon'  => 'fa-money',
        'keys'  => array('due_report', 'payments/due_report', 'payment/due_report')
    ),
    'customer_payment_report' => array(
        'title' => 'Customer Payment Report',
        'url'   => console_url('sale/customer_payment_report'),
        'icon'  => 'fa-users',
        'keys'  => array('customer_payment_report', 'sale/customer_payment_report')
    ),
);
?>

<div class="sale-report-nav no-print" style="margin-bottom: 18px;">
    <div class="box box-solid" style="border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 0;">
        <div class="box-body" style="padding: 10px 15px; background: #fafbfc; border-radius: 6px;">
            <div class="nav-tabs-custom-reports" style="display: flex; flex-wrap: wrap; gap: 8px;">
                <?php foreach ($sale_report_items as $id => $item): 
                    $is_active = in_array($current_action, $item['keys']) || ($current_action === $id);
                ?>
                    <a href="<?= $item['url'] ?>" 
                       class="btn btn-sm <?= $is_active ? 'btn-primary active' : 'btn-default' ?>" 
                       style="border-radius: 4px; font-weight: 500; font-size: 13px; padding: 7px 14px; transition: all 0.2s ease; <?= $is_active ? 'box-shadow: 0 2px 4px rgba(60,141,188,0.3); font-weight:600;' : '' ?>">
                        <i class="fa <?= $item['icon'] ?>" style="margin-right: 5px;"></i> <?= $item['title'] ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
