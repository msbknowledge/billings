<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db_config.php';

$responce = array();

if (isset($_GET['term']) && !empty($_REQUEST['table']) && !empty($_REQUEST['fieldToSearch'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['table']);
    $fieldToSearch = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['fieldToSearch']);
    $term = trim($_GET['term']);

    try {
        $conn = get_app_pdo();

        $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `$fieldToSearch` LIKE :term LIMIT 0, 25");
        $stmt->execute(array('term' => '%' . $term . '%'));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['doctor_name'] = isset($row['doctor_name']) ? $row['doctor_name'] : '';
            $row['sale_discount_percent'] = isset($row['medicine_discount']) ? $row['medicine_discount'] : 0;
            $row['sale_cgst_percent'] = isset($row['medicine_gst']) ? (float)$row['medicine_gst'] / 2 : 0;
            $row['sale_sgst_percent'] = isset($row['medicine_gst']) ? (float)$row['medicine_gst'] / 2 : 0;

            $id = isset($row['medicine_id']) ? $row['medicine_id'] : (isset($row['medicine_ID']) ? $row['medicine_ID'] : (isset($row[$table . '_id']) ? $row[$table . '_id'] : (isset($row[$table . '_ID']) ? $row[$table . '_ID'] : '')));

            $responce[] = array(
                'id' => $id,
                'label' => $row[$fieldToSearch],
                'value' => $row[$fieldToSearch],
                'complete' => $row
            );
        }
    } catch (PDOException $e) {
        // Suppress errors to keep JSON intact
    }
}

echo json_encode($responce);
