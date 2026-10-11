<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db_config.php';

$responce = array();

if (isset($_GET['medicine_id'])) {
    $med_id = intval($_GET['medicine_id']);

    try {
        $conn = get_app_pdo();

        if (isset($_GET['term']) && strlen(trim($_GET['term'])) > 0) {
            $stmt = $conn->prepare('SELECT medicine_stocks.*, purchases.purchase_cgst_percent, purchases.purchase_unit FROM medicine_stocks LEFT JOIN purchases ON purchase_medicine_id = medicine_stock_medicine WHERE medicine_stock_medicine = :med_id AND medicine_stock_batch LIKE :term GROUP BY medicine_stock_batch LIMIT 0, 20');
            $stmt->execute(array('med_id' => $med_id, 'term' => '%' . trim($_GET['term']) . '%'));
        } else {
            $stmt = $conn->prepare('SELECT medicine_stocks.*, purchases.purchase_cgst_percent, purchases.purchase_unit FROM medicine_stocks LEFT JOIN purchases ON purchase_medicine_id = medicine_stock_medicine WHERE medicine_stock_medicine = :med_id GROUP BY medicine_stock_batch LIMIT 0, 20');
            $stmt->execute(array('med_id' => $med_id));
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmtx = $conn->prepare('SELECT medicines.* FROM medicines WHERE medicine_ID = :med_id OR medicine_id = :med_id');
            $stmtx->execute(array('med_id' => $med_id));
            $rowx = $stmtx->fetch(PDO::FETCH_ASSOC);

            $search = array();
            $search['sale_expire_year'] = isset($row['medicine_expire_year']) ? $row['medicine_expire_year'] : '';
            $search['sale_expire_month'] = isset($row['medicine_expire_month']) ? $row['medicine_expire_month'] : '';
            $gstHalf = (!empty($rowx['medicine_gst'])) ? ((float)$rowx['medicine_gst'] / 2) : 0;
            $search['sale_cgst_percent'] = !empty($row['purchase_cgst_percent']) ? $row['purchase_cgst_percent'] : $gstHalf;
            $search['sale_sgst_percent'] = $search['sale_cgst_percent'];
            $search['medicine_stock_batch'] = isset($row['medicine_stock_batch']) ? $row['medicine_stock_batch'] : '';
            $search['medicine_strip_stock'] = isset($row['medicine_strip_stock']) ? $row['medicine_strip_stock'] : 0;
            $search['medicine_loose_stock'] = isset($row['medicine_loose_stock']) ? $row['medicine_loose_stock'] : 0;
            $search['medicine_mrp'] = isset($row['medicine_mrp']) ? $row['medicine_mrp'] : '0.00';
            $search['sale_mrp'] = $search['medicine_mrp'];

            if ($search['medicine_strip_stock'] == 0 && $search['medicine_loose_stock'] == 0) {
                continue;
            }

            $responce[] = array(
                'id' => '',
                'label' => $search['medicine_stock_batch'] . ' [S:' . $search['medicine_strip_stock'] . '|L:' . $search['medicine_loose_stock'] . '](' . $search['sale_expire_month'] . '/' . $search['sale_expire_year'] . ') |' . $search['medicine_mrp'],
                'value' => $search['medicine_stock_batch'],
                'complete' => $search
            );
        }
    } catch (PDOException $e) {
        // Suppress errors to keep JSON intact
    }
}

echo json_encode($responce);
