<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db_config.php';

$responce = array();

if (isset($_GET['product_id'])) {
    $prod_id = intval($_GET['product_id']);

    try {
        $conn = get_app_pdo();

        if (isset($_GET['term']) && strlen(trim($_GET['term'])) > 0) {
            $stmt = $conn->prepare('SELECT product_stocks.*, purchases.purchase_cgst_percent, purchases.purchase_unit FROM product_stocks LEFT JOIN purchases ON purchase_product_id = product_stock_product WHERE product_stock_product = :prod_id AND product_stock_batch LIKE :term GROUP BY product_stock_batch LIMIT 0, 20');
            $stmt->execute(array('prod_id' => $prod_id, 'term' => '%' . trim($_GET['term']) . '%'));
        } else {
            $stmt = $conn->prepare('SELECT product_stocks.*, purchases.purchase_cgst_percent, purchases.purchase_unit FROM product_stocks LEFT JOIN purchases ON purchase_product_id = product_stock_product WHERE product_stock_product = :prod_id GROUP BY product_stock_batch LIMIT 0, 20');
            $stmt->execute(array('prod_id' => $prod_id));
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmtx = $conn->prepare('SELECT products.* FROM products WHERE product_id = :prod_id');
            $stmtx->execute(array('prod_id' => $prod_id));
            $rowx = $stmtx->fetch(PDO::FETCH_ASSOC);

            $search = array();
            $search['sale_expire_year'] = isset($row['product_expire_year']) ? $row['product_expire_year'] : '';
            $search['sale_expire_month'] = isset($row['product_expire_month']) ? $row['product_expire_month'] : '';
            $gstHalf = (!empty($rowx['product_gst'])) ? ((float)$rowx['product_gst'] / 2) : 0;
            $search['sale_cgst_percent'] = !empty($row['purchase_cgst_percent']) ? $row['purchase_cgst_percent'] : $gstHalf;
            $search['sale_sgst_percent'] = $search['sale_cgst_percent'];
            $search['product_stock_batch'] = isset($row['product_stock_batch']) ? $row['product_stock_batch'] : '';
            $search['product_strip_stock'] = isset($row['product_strip_stock']) ? $row['product_strip_stock'] : 0;
            $search['product_loose_stock'] = isset($row['product_loose_stock']) ? $row['product_loose_stock'] : 0;
            $search['product_mrp'] = isset($row['product_mrp']) ? $row['product_mrp'] : '0.00';
            $search['sale_mrp'] = $search['product_mrp'];

            if ($search['product_strip_stock'] == 0 && !empty($search['product_stock_loose'])) {
                continue;
            }

            $responce[] = array(
                'id' => '',
                'label' => $search['product_stock_batch'] . ' [S:' . $search['product_strip_stock'] . '|L:' . $search['product_loose_stock'] . '](' . $search['sale_expire_month'] . '/' . $search['sale_expire_year'] . ') |' . $search['product_mrp'],
                'value' => $search['product_stock_batch'],
                'complete' => $search
            );
        }
    } catch (PDOException $e) {}
}

echo json_encode($responce);
