<?php
$nodeSegment = explode('.',$_SERVER['SERVER_NAME']);
$node = 'u404684354_'.$nodeSegment[0];
define('DB_SERVER', 'localhost');
define('DB_USER',$node);
define('DB_PASSWORD', 'BR66MK55@msb');
define('DB_NAME', $node);

if (isset($_GET['term'])) {
    $return_arr = array();

    try {
        $conn = new PDO("mysql:host=" . DB_SERVER . ";port=3306;dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT * FROM ' . $_REQUEST['table'] . ' WHERE ' . $_REQUEST['fieldToSearch'] . '  LIKE :term limit 0,20');
        $stmt->execute(array('term' => '' . $_GET['term'] . ''));

        while ($row = $stmt->fetch()) {
            $responce[] = array('id' => $id, 'label' => $row[$_REQUEST['fieldToSearch']], 'value' => $row[$_REQUEST['fieldToSearch']], 'complete' => $row);
        }
    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    /* Toss back results as json encoded array. */
    echo json_encode($responce);
}
?>
