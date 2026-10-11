<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/db_config.php';

$responce = array();

if (isset($_GET['term']) && !empty($_REQUEST['table']) && !empty($_REQUEST['fieldToSearch'])) {
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['table']);
    $fieldToSearch = preg_replace('/[^a-zA-Z0-9_]/', '', $_REQUEST['fieldToSearch']);

    try {
        $conn = get_app_pdo();

        $stmt = $conn->prepare("SELECT * FROM `$table` WHERE `$fieldToSearch` LIKE :term LIMIT 0, 20");
        $stmt->execute(array('term' => '%' . trim($_GET['term']) . '%'));

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = isset($row['medicine_id']) ? $row['medicine_id'] : (isset($row['medicine_ID']) ? $row['medicine_ID'] : (isset($row[$table . '_id']) ? $row[$table . '_id'] : ''));
            $responce[] = array('id' => $id, 'label' => $row[$fieldToSearch], 'value' => $row[$fieldToSearch], 'complete' => $row);
        }
    } catch (PDOException $e) {}
}

echo json_encode($responce);
